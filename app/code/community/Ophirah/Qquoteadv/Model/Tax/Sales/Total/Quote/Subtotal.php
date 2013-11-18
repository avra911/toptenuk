<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Tax
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Calculate items and address amounts including/excluding tax
 */
class Ophirah_Qquoteadv_Model_Tax_Sales_Total_Quote_Subtotal extends Mage_Tax_Model_Sales_Total_Quote_Subtotal  {


    /**
     * Recalculate row information for item based on children calculation
     *
     * @param   Mage_Sales_Model_Quote_Item_Abstract $item
     * @return  Mage_Tax_Model_Sales_Total_Quote_Subtotal
     */
    protected function _recalculateParent(Mage_Sales_Model_Quote_Item_Abstract $item)
    {
        $price       = 0;
        $basePrice   = 0;
        $rowTotal    = 0;
        $baseRowTotal= 0;
        $priceInclTax       = 0;
        $basePriceInclTax   = 0;
        $rowTotalInclTax    = 0;
        $baseRowTotalInclTax= 0;
        foreach ($item->getChildren() as $child) {
            $price              += $child->getPrice() * $child->getQty();
            $basePrice          += $child->getBasePrice() * $child->getQty();
            $rowTotal           += $child->getRowTotal();
            $baseRowTotal       += $child->getBaseRowTotal();
            $priceInclTax       += $child->getPriceInclTax() * $child->getQty();
            $basePriceInclTax   += $child->getBasePriceInclTax() * $child->getQty();
            $rowTotalInclTax    += $child->getRowTotalInclTax();
            $baseRowTotalInclTax+= $child->getBaseRowTotalInclTax();
        }
        
        
        /**
        *
        * Customisation To make the custom price work with configurable items
        *
        **/
        
        if($item->getCustomPrice()){ 
                $customPrice = $item->getCustomPrice(); 
                $price = $customPrice; 
                $basePrice = $customPrice; 
                $rowTotal = $customPrice * $item->getQty(); 
                $baseRowTotal = $customPrice * $item->getQty(); 
                $priceInclTax = $customPrice; 
                $basePriceInclTax = $customPrice; 
                $rowTotalInclTax = $customPrice * $item->getQty(); 
                $baseRowTotalInclTax= $customPrice * $item->getQty(); 
        }
        
        $item->setConvertedPrice($price);
        $item->setPrice($basePrice);
        $item->setRowTotal($rowTotal);
        $item->setBaseRowTotal($baseRowTotal);
        $item->setPriceInclTax($priceInclTax);
        $item->setBasePriceInclTax($basePriceInclTax);
        $item->setRowTotalInclTax($rowTotalInclTax);
        $item->setBaseRowTotalInclTax($baseRowTotalInclTax);
        return $this;
    }
    
        /**
     * Calculate item price including/excluding tax, row total including/excluding tax
     * and subtotal including/excluding tax.
     * Determine discount price if needed
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  Mage_Tax_Model_Sales_Total_Quote_Subtotal
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        $this->_store   = $address->getQuote()->getStore();
        $this->_address = $address;

        $this->_subtotalInclTax     = 0;
        $this->_baseSubtotalInclTax = 0;
        $this->_subtotal            = 0;
        $this->_baseSubtotal        = 0;
        $this->_roundingDeltas      = array();

        $address->setSubtotalInclTax(0);
        $address->setBaseSubtotalInclTax(0);
        $address->setTotalAmount('subtotal', 0);
        $address->setBaseTotalAmount('subtotal', 0);

        $items = $this->_getAddressItems($address);
        if (!$items) {
            return $this;
        }

        $addressRequest = $this->_getAddressTaxRequest($address);
        $storeRequest   = $this->_getStoreTaxRequest($address);
        $this->_calculator->setCustomer($address->getQuote()->getCustomer());
        if ($this->_config->priceIncludesTax($this->_store)) {
            $classIds = array();
            foreach ($items as $item) {
                $classIds[] = $item->getProduct()->getTaxClassId();
                if ($item->getHasChildren()) {
                    foreach ($item->getChildren() as $child) {
                        $classIds[] = $child->getProduct()->getTaxClassId();
                    }
                }
            }
            $classIds = array_unique($classIds);
            $storeRequest->setProductClassId($classIds);
            $addressRequest->setProductClassId($classIds);
            $this->_areTaxRequestsSimilar = $this->_calculator->compareRequests($storeRequest, $addressRequest);
        }

        foreach ($items as $item) {
            if ($item->getParentItem()) {
                continue;
            }
            
            
            $origItem = clone $item;
            if ($item->getHasChildren() && $item->isChildrenCalculated()) {
                foreach ($item->getChildren() as $child) {
                    $this->_processItem($child, $addressRequest);
                    if($child->getTaxPercent() > 0) {
                           $item->setTaxPercent($child->getTaxPercent());
                    }
                }
              
                $this->_recalculateParent($item);
                 
            } else {
                $this->_processItem($item, $addressRequest);
            }
           

            
            
            if( $origItem->getCustomPrice()){
                $taxPercent = $item->getTaxPercent();
                $customPrice =  $origItem->getCustomPrice();
                $price = $customPrice;
                try{
                    $storeId = Mage::getSingleton('adminhtml/session_quote')->getStore()->getId();
                } catch(Exception $e) {
                    $storeId = Mage::app()->getStore()->getId();    
                }
                $currencyCode = Mage::app()->getStore($storeId)->getCurrentCurrencyCode();
                $baseCurrency = Mage::app()->getBaseCurrencyCode();
                if($currencyCode != $baseCurrency){
                    $rates = Mage::getModel('directory/currency')->getCurrencyRates($baseCurrency,$currencyCode);
                    $rate = $rates[$currencyCode];
                } else {
                    $rate = 1;
                }
                
                $baseCustomPrice = $customPrice / $rate;
                $taxAmount = ($customPrice *  ($taxPercent/100));
                $baseTaxAmount = ( $baseCustomPrice *  ($taxPercent/100));
                
                $basePrice          = $customPrice;
                $rowTotal           = $customPrice * $item->getQty();
                $baseRowTotal       = $baseCustomPrice * $item->getQty();
                $priceInclTax       = $customPrice + $taxAmount;
                $basePriceInclTax   = $baseCustomPrice +  $baseTaxAmount;
                $rowTotalInclTax    = $priceInclTax * $item->getQty();
                $baseRowTotalInclTax= $basePriceInclTax * $item->getQty();
                
                $item->setCustomPrice($origItem->getCustomPrice());
                $item->setConvertedPrice($price);
                $item->setPrice($basePrice);
                $item->setRowTotal($rowTotal);
                $item->setBaseRowTotal($baseRowTotal);
                $item->setTaxableAmount($rowTotal);
                $item->setBaseTaxableAmount($baseRowTotal);
                $item->setPriceInclTax($priceInclTax);
                $item->setBasePriceInclTax($basePriceInclTax);
                $item->setRowTotalInclTax($rowTotalInclTax);
                $item->setBaseRowTotalInclTax($baseRowTotalInclTax);
                
                $count = 0;
                if($item->getHasChildren()) {
                    foreach($item->getChildren() as $child) {
                        if($count === 0) {
                            $child->setTaxableAmount($rowTotal);
                            $child->setBaseTaxableAmount($baseRowTotal);
                        } else {
                            $child->setTaxableAmount(0);
                            $child->setBaseTaxableAmount(0);
                        }

                        $count++;
                    }
                }
            }
            $this->_addSubtotalAmount($address, $item);
        }
       
        $address->setRoundingDeltas($this->_roundingDeltas);
        return $this;
    }

}