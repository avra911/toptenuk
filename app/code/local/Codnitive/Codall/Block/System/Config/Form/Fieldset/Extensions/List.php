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
 * @package    Codnitive_Codall
 * @author     Hassan Barza <support@codnitive.com>
 * @copyright  Copyright (c) 2011 CODNITIVE Co. (http://www.codnitive.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Codnitive_Codall_Block_System_Config_Form_Fieldset_Extensions_List
    extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html      = $this->_getHeaderHtml($element);
        $modules   = Mage::getConfig()->getNode('modules')->children();
        $linkTitle = Mage::helper('codall')->__('Goto Extension Page');
        
        foreach ($modules as $moduleName => $values) {
            if (0 !== strpos($moduleName, 'Codnitive_')) {
                continue;
            }
            /*if($moduleName == 'Codnitive_Codall'){
				continue;
			}*/
            if ($values->title) {
                $moduleName = (string) $values->title;
            }
            if ($values->link) {
                $link = (string) $values->link;
                $moduleName = "<a href='{$link}' target='_blank' title='{$linkTitle}'>{$moduleName}</a>";
            }
            
            $field = $element->addField($moduleName, 'label', array(
                'label' => $moduleName,
                'value' => (string) $values->version
            ));
            $html .= $field->toHtml();
        }
        
        $html .= $this->_getFooterHtml($element);

        return $html;
    }
}
