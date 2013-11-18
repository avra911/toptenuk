<?php

class Ophirah_Qquoteadv_Model_Shipping_Carrier_Qquoteshiprate
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{

    protected $_code = 'qquoteshiprate';

    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $freeBoxes = 0;
        if ($request->getAllItems()) {
            foreach ($request->getAllItems() as $item) {
                if ($item->getFreeShipping() && !$item->getProduct()->isVirtual()) {
                    $freeBoxes+=$item->getQty();
                }
            }
        }
        $this->setFreeBoxes($freeBoxes);

        $quoteId = Mage::getSingleton('core/session')->proposal_quote_id;
        if($quoteId){
            $price = Mage::app()->getHelper('qquoteadv')->getQquoteShipPriceById($quoteId);

            $result = Mage::getModel('shipping/rate_result');
           /* if ($this->getConfigData('type') == 'O') { // per order
                $shippingPrice = $price;
            } elseif ($this->getConfigData('type') == 'I') { // per item
                $shippingPrice = ($request->getPackageQty() * $price) - ($this->getFreeBoxes() * $price);
            } else {
                $shippingPrice = false;
            }*/
            $type = Mage::app()->getHelper('qquoteadv')->getShipTypeByQuote();
            if ($type == 'O') { // per order
                $shippingPrice = $price;
            } elseif ($type == 'I') { // per item
                $shippingPrice = ($request->getPackageQty() * $price) - ($this->getFreeBoxes() * $price);
            } else {
                $shippingPrice = false;
            }


           $shippingPrice = $this->getFinalPriceWithHandlingFee($shippingPrice);

            if ($shippingPrice !== false) {
                $method = Mage::getModel('shipping/rate_result_method');

                $method->setCarrier('qquoteshiprate');
                $method->setCarrierTitle($this->getConfigData('title'));

                $method->setMethod('qquoteshiprate');

                if($type=='I')
                  $method->setMethodTitle('Price per Item');
                else
                  $method->setMethodTitle($this->getConfigData('name'));

                if ($request->getFreeShipping() === true || $request->getPackageQty() == $this->getFreeBoxes()) {
                    $shippingPrice = '0.00';
                }

                $method->setPrice($shippingPrice);
                $method->setCost($shippingPrice);

                $result->append($method);
            }

            return $result;
        }
        return false;

    }

    public function getAllowedMethods()
    {
        return array('qquoteshiprate'=>$this->getConfigData('name'));
    }

}
