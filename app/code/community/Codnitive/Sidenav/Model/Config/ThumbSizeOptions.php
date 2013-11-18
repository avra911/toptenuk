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
 * @category   Codnitive
 * @package    Codnitive_Sidenav
 * @author     Hassan Barza <support@codnitive.com>
 * @copyright  Copyright (c) 2011 CODNITIVE Co. (http://www.codnitive.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Codnitive_Sidenav_Model_Config_ThumbSizeOptions extends Mage_Core_Model_Config_Data
{
    
    const DEFAULT_VALUE = 0;
    const CUSTOM_VALUE  = 1;

    /**
     * Fills the select field with values
     * 
     * @return array
     */
    public function toOptionArray()
    {
        return array(
			array(
				'value' => self::DEFAULT_VALUE, 
				'label' => Mage::helper('sidenav')->__('Default')
			),
			array(
				'value' => self::CUSTOM_VALUE, 
				'label' => Mage::helper('sidenav')->__('Custom')
			),
        );
    }
}
