<?php
/*------------------------------------------------------------------------

 # APL Solutions and Vision Co., LTD

# ------------------------------------------------------------------------

# Copyright (C) 2008-2010 APL Solutions and Vision Co., LTD. All Rights



Reserved.

# @license - Copyrighted Commercial Software

# Author: APL Solutions and Vision Co., LTD

# Websites: http://www.joomlavision.com/ - http://www.magentheme.com/

-------------------------------------------------------------------------*/ 
class MagenThemes_MTColinusAdmin_productController extends Mage_Core_Controller_Front_Action { 
	public function compareAction(){
		$response = array(); 
		if ($productId = (int) $this->getRequest()->getParam('product')) {
			$product = Mage::getModel('catalog/product')
			->setStoreId(Mage::app()->getStore()->getId())
			->load($productId); 
			if ($product->getId()/* && !$product->isSuper()*/) {
				Mage::getSingleton('catalog/product_compare_list')->addProduct($product);
				$response['status'] = 'SUCCESS';
				$response['message'] = $this->__('The product %s has been added to comparison list.', Mage::helper('core')->escapeHtml($product->getName()));
				Mage::register('referrer_url', $this->_getRefererUrl());
				Mage::helper('catalog/product_compare')->calculate();
				Mage::dispatchEvent('catalog_product_compare_add_product', array('product'=>$product));
				$this->loadLayout();
				$header_compare = $this->getLayout()->getBlock('compareajax')->toHtml();
				$this->getResponse()->setBody($header_compare);  
				$sidebar_block = $this->getLayout()->getBlock('catalog.compare.sidebar');
				$sidebar_block->setTemplate('magenthemes/ajaxcart/compare/sidebar.phtml');
				$sidebar = $sidebar_block->toHtml();
				$response['output'] = $sidebar;
				$response['topcompare'] = $header_compare; 
			}
		}
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody( (string) $this->getRequest()->getParam('callback') . '(' . Mage::helper('core')->jsonEncode($response) . ')' );
		return;
	} 
	public function rmcompareAction()
	{
		$response = array();
		if ($productId = (int) $this->getRequest()->getParam('product')) {
			$product = Mage::getModel('catalog/product')
			->setStoreId(Mage::app()->getStore()->getId())
			->load($productId); 
			if($product->getId()) { 
				$item = Mage::getModel('catalog/product_compare_item'); 
				if(Mage::getSingleton('customer/session')->isLoggedIn()) {
                    $item->addCustomerData(Mage::getSingleton('customer/session')->getCustomer());
                } elseif ($this->_customerId) {
                    $item->addCustomerData(
                        Mage::getModel('customer/customer')->load($this->_customerId)
                    );
                } else {
                    $item->addVisitorId(Mage::getSingleton('log/visitor')->getId());
                }
				$item->loadByProduct($product); 
				if($item->getId()) {
					$item->delete();
					$response['status'] = 'SUCCESS';
					$response['message'] = $this->__('The product %s has been removed from comparison list.', $product->getName()); 
					Mage::dispatchEvent('catalog_product_compare_remove_product', array('product'=>$item));
					Mage::helper('catalog/product_compare')->calculate();
					$this->loadLayout();
					$header_compare = $this->getLayout()->getBlock('compareajax'); 
					$header_compare->setTemplate('magenthemes/ajaxcart/compare/header.phtml');
					$blockcompare = $header_compare->toHtml();
					$sidebar_block = $this->getLayout()->getBlock('catalog.compare.sidebar');
					$sidebar_block->setTemplate('magenthemes/ajaxcart/compare/sidebar.phtml');
					$sidebar = $sidebar_block->toHtml();
					$response['output'] = $sidebar;
					$response['topcompare'] = $blockcompare; 
				}
			}
		} 
		$this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody( (string) $this->getRequest()->getParam('callback') . '(' . Mage::helper('core')->jsonEncode($response) . ')' );
		return;  
	}
	
	public function clearallAction(){
        $response = array();
        $items = Mage::getResourceModel('catalog/product_compare_item_collection');

        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $items->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId());
        } elseif ($this->_customerId) {
            $items->setCustomerId($this->_customerId);
        } else {
            $items->setVisitorId(Mage::getSingleton('log/visitor')->getId());
        }

        /** @var $session Mage_Catalog_Model_Session */
        $session = Mage::getSingleton('catalog/session');

        try {
            $items->clear();
            $session->addSuccess($this->__('The comparison list was cleared.'));
            $response['status'] = 'SUCCESS';
            $response['message'] = $this->__('The comparison list was cleared.');
            Mage::helper('catalog/product_compare')->calculate();
            $this->loadLayout();
            $header_compare = $this->getLayout()->getBlock('compareajax'); 
			$header_compare->setTemplate('magenthemes/ajaxcart/compare/header.phtml');
			$blockcompare = $header_compare->toHtml();
            $sidebar_block = $this->getLayout()->getBlock('catalog.compare.sidebar');
            $sidebar_block->setTemplate('magenthemes/ajaxcart/compare/sidebar.phtml');
            $sidebar = $sidebar_block->toHtml();
            $response['output'] = $sidebar;
            $response['topcompare'] = $blockcompare; 
        } catch (Mage_Core_Exception $e) {
            $session->addError($e->getMessage());
        } catch (Exception $e) {
            $session->addException($e, $this->__('An error occurred while clearing comparison list.'));
        }
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody( (string) $this->getRequest()->getParam('callback') . '(' . Mage::helper('core')->jsonEncode($response) . ')' );
        return;
    }
	
	protected function _getWishlist($wishlistId = null)
	{
		$wishlist = Mage::registry('wishlist');
		if ($wishlist) {
			return $wishlist;
		} 
		try {
			if (!$wishlistId) {
				$wishlistId = $this->getRequest()->getParam('wishlist_id');
			}
			$customerId = Mage::getSingleton('customer/session')->getCustomerId();
			/* @var Mage_Wishlist_Model_Wishlist $wishlist */
			$wishlist = Mage::getModel('wishlist/wishlist');
			if ($wishlistId) {
				$wishlist->load($wishlistId);
			} else {
				$wishlist->loadByCustomer($customerId, true);
			}
	
			if (!$wishlist->getId() || $wishlist->getCustomerId() != $customerId) {
				$wishlist = null;
				Mage::throwException(
				Mage::helper('wishlist')->__("Requested wishlist doesn't exist")
				);
			}
	
			Mage::register('wishlist', $wishlist);
		} catch (Mage_Core_Exception $e) {
			Mage::getSingleton('wishlist/session')->addError($e->getMessage());
			return false;
		} catch (Exception $e) {
			Mage::getSingleton('wishlist/session')->addException($e,
			Mage::helper('wishlist')->__('Wishlist could not be created.')
			);
			return false;
		}
	
		return $wishlist;
	}
	public function addAction()
	{ 
		$response = array();
		if (!Mage::getStoreConfigFlag('wishlist/general/active')) {
			$response['status'] = 'ERROR';
			$response['message'] = $this->__('Wishlist Has Been Disabled By Admin');
		}
		if(!Mage::getSingleton('customer/session')->isLoggedIn()){
			$response['status'] = 'ERROR';
			$response['message'] = $this->__('Please Login First');
		}

		if(empty($response)){
			$session = Mage::getSingleton('customer/session');
			$wishlist = $this->_getWishlist();
			if (!$wishlist) {
				$response['status'] = 'ERROR';
				$response['message'] = $this->__('Unable to Create Wishlist');
			}else{

				$productId = (int) $this->getRequest()->getParam('product');
				if (!$productId) {
					$response['status'] = 'ERROR';
					$response['message'] = $this->__('Product Not Found');
				}else{

					$product = Mage::getModel('catalog/product')->load($productId);
					if (!$product->getId() || !$product->isVisibleInCatalog()) {
						$response['status'] = 'ERROR';
						$response['message'] = $this->__('Cannot specify product.');
					}else{ 
						try {
							$requestParams = $this->getRequest()->getParams();
							$buyRequest = new Varien_Object($requestParams);

							$result = $wishlist->addNewItem($product, $buyRequest);
							if (is_string($result)) {
								Mage::throwException($result);
							}
							$wishlist->save();

							Mage::dispatchEvent(
                				'wishlist_add_product',
							array(
			                    'wishlist'  => $wishlist,
			                    'product'   => $product,
			                    'item'      => $result
							)
							);

							Mage::helper('wishlist')->calculate();

							$message = $this->__('%1$s has been added to your wishlist.', $product->getName());
							$response['status'] = 'SUCCESS';
							$response['message'] = $message; 
							Mage::unregister('wishlist'); 
							$this->loadLayout();
							$toplink = $this->getLayout()->getBlock('top.links')->toHtml();
							$sidebar_block = $this->getLayout()->getBlock('wishlist_sidebar'); 
							if($sidebar_block){
								$sidebar_block->setTemplate('magenthemes/wishlist/sidebar.phtml');
								$sidebar = $sidebar_block->toHtml();  
								$response['sidebar'] = $sidebar;
							} 
							$response['toplink'] = $toplink;
						}
						catch (Mage_Core_Exception $e) {
							$response['status'] = 'ERROR';
							$response['message'] = $this->__('An error occurred while adding item to wishlist: %s', $e->getMessage());
						}
						catch (Exception $e) {
							mage::log($e->getMessage());
							$response['status'] = 'ERROR';
							$response['message'] = $this->__('An error occurred while adding item to wishlist.');
						}
					}
				}
			}

		}

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody( (string) $this->getRequest()->getParam('callback') . '(' . Mage::helper('core')->jsonEncode($response) . ')' );
		return;
	}
	public function removeAction()
	{
		$response = array();	
		$id = (int) $this->getRequest()->getParam('item');
		$item = Mage::getModel('wishlist/item')->load($id);
		if (!$item->getId()) {
			return $this->norouteAction();
		}
		$wishlist = $this->_getWishlist($item->getWishlistId());
		if (!$wishlist) {
			return $this->norouteAction();
		}
		try {
			$item->delete();
			$wishlist->save();
			$response['status'] = 'SUCCESS';
			$response['message'] = $this->__('The product %s has been removed from Wishlist.', $item->getName());
			$this->loadLayout();
			$toplink = $this->getLayout()->getBlock('top.links')->toHtml();
			$sidebar_block = $this->getLayout()->getBlock('wishlist_sidebar');
			$sidebar_block->setTemplate('magenthemes/wishlist/sidebar.phtml');
			$sidebar = $sidebar_block->toHtml();
			$response['toplink'] = $toplink;
			$response['sidebar'] = $sidebar;
		} catch (Mage_Core_Exception $e) {
			Mage::getSingleton('customer/session')->addError(
			$this->__('An error occurred while deleting the item from wishlist: %s', $e->getMessage())
			);
		} catch(Exception $e) {
			Mage::getSingleton('customer/session')->addError(
			$this->__('An error occurred while deleting the item from wishlist.')
			);
		} 
		Mage::helper('wishlist')->calculate(); 
		$this->getResponse()->setHeader('Content-type', 'application/json');
		$this->getResponse()->setBody( (string) $this->getRequest()->getParam('callback') . '(' . Mage::helper('core')->jsonEncode($response) . ')' );
		return;
	}
}

