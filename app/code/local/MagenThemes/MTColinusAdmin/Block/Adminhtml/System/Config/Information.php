<?php
class MagenThemes_MTColinusAdmin_Block_Adminhtml_System_Config_Information extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    public function render(Varien_Data_Form_Element_Abstract $element)
    {		
	$html = $this->_getHeaderHtml($element);		
	$html.= $this->_getFieldHtml($element);        
        $html .= $this->_getFooterHtml($element);
        return $html;
    }   
    protected function _getFieldHtml($fieldset)
    {
	$content = 'MT Colinus Theme version : 2.1.6<br/>Author : <a href="http://www.arexmage.com" title="Magento Themes">ArexMage.com</a><br />Copyright &copy; 2013- ArexMage.com<br/><strong>Support URL: </strong><a href="http://arex.ticksy.com/" target="_blank">http://arex.ticksy.com/</a>';
	return $content;
    }
}