<?php
class Ophirah_Qquoteadv_Block_Checkout_Onepage_Shipping_Method_Available extends Mage_Checkout_Block_Onepage_Shipping_Method_Available{
	public function getShippingRates()
    { 
        if (empty($this->_rates)) {
            $this->getAddress()->collectShippingRates()->save();

            $groups = $this->getAddress()->getGroupedAllShippingRates();

            /*
            if (!empty($groups)) {
                $ratesFilter = new Varien_Filter_Object_Grid();
                $ratesFilter->addFilter(Mage::app()->getStore()->getPriceFilter(), 'price');

                foreach ($groups as $code => $groupItems) {
                    $groups[$code] = $ratesFilter->filter($groupItems);
                }
            }
            */
			if(Mage::helper('qquoteadv')->isActiveConfirmMode() && Mage::app()->getHelper('qquoteadv')->isSetQuoteShipPrice()) {
				foreach( $groups as $code => $_rates) {
					if('qquoteshiprate'!=$code) {
						unset($groups[$code]);
					}
				}
			}else{
				//don't show c2q shipping method
				foreach( $groups as $code => $_rates) {
					if('qquoteshiprate'==$code) {
						unset($groups[$code]);
					}
				}
			}
            return $this->_rates = $groups;
        }

        return $this->_rates;
    }
}