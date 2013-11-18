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
	$content = 'MT Colinus Theme version : 2.0.6<br/>Author : <a href="http://www.9magentothemes.com" title="Magento Themes">9MagentoThemes.Com</a><br />Copyright &copy; 2011- 9MagentoThemes.Com';
	return $content;
    }
}