<?php
/******************************************************
 * @package MT Slideshow module for Magento 1.4.x.x, Magento 1.5.x.x and Magento 1.6.x.x
 * @version 2.0.0
 * @author http://www.magentheme.com
 * @copyright (C) 2011- MagenTheme.Com
 * @license PHP files are GNU/GPL
*******************************************************/
?>
<?php
class MagenThemes_Mtslideshow_Adminhtml_MtslideshowController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('magenthemes/mtslideshow')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('mtslideshow/mtslideshow')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('mtslideshow_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('mtslideshow/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Slide Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Slide News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('mtslideshow/adminhtml_mtslideshow_edit'))
				->_addLeft($this->getLayout()->createBlock('mtslideshow/adminhtml_mtslideshow_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mtslideshow')->__('Slide does not exist'));
			$this->_redirect('*/*/');
		}
	}
	
	public function imageAction() {
        $result = array();
        try {
            $uploader = new MagenThemes_Mtslideshow_Media_Uploader('image');
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $result = $uploader->save(
                    Mage::getSingleton('mtslideshow/config')->getBaseMediaPath()
            );
			
            $result['url'] = Mage::getSingleton('mtslideshow/config')->getMediaUrl($result['file']);
            $result['cookie'] = array(
                    'name'     => session_name(),
                    'value'    => $this->_getSession()->getSessionId(),
                    'lifetime' => $this->_getSession()->getCookieLifetime(),
                    'path'     => $this->_getSession()->getCookiePath(),
                    'domain'   => $this->_getSession()->getCookieDomain()
            );
        } catch (Exception $e) {
            $result = array('error'=>$e->getMessage(), 'errorcode'=>$e->getCode());
        }

        $this->getResponse()->setBody(Zend_Json::encode($result));
    }
	
	public function categoriesJsonAction()
    {
        $slideId     = $this->getRequest()->getParam('id');
        $_model  = Mage::getModel('mtslideshow/mtslideshow')->load($slideId);
        Mage::register('mtslideshow_data', $_model);

        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('mtslideshow/adminhtml_mtslideshow_edit_tab_category')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$_model = Mage::getModel('mtslideshow/mtslideshow');            
            
            if (isset($data['categories'])) {
                $data['categories'] = explode(',',$data['categories']);
                if (is_array($data['categories'])) {
                    $data['categories'] = array_unique($data['categories']);
                }
            }
				
		
            $_model->setData($data)
                    ->setId($this->getRequest()->getParam('id'));			

            try {
                $_model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mtslideshow')->__('Slide was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $_model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mtslideshow')->__('Unable to find slide to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('mtslideshow/mtslideshow');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $mtslideshowIds = $this->getRequest()->getParam('mtslideshow');
        if(!is_array($mtslideshowIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($mtslideshowIds as $mtslideshowId) {
                    $mtslideshow = Mage::getModel('mtslideshow/mtslideshow')->load($mtslideshowId);
                    $mtslideshow->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($mtslideshowIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $mtslideshowIds = $this->getRequest()->getParam('mtslideshow');
        if(!is_array($mtslideshowIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($mtslideshowIds as $mtslideshowId) {
                    $mtslideshow = Mage::getSingleton('mtslideshow/mtslideshow')
                        ->load($mtslideshowId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($mtslideshowIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'mtslideshow.csv';
        $content    = $this->getLayout()->createBlock('mtslideshow/adminhtml_mtslideshow_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'mtslideshow.xml';
        $content    = $this->getLayout()->createBlock('mtslideshow/adminhtml_mtslideshow_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}