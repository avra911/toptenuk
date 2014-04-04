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
class MagenThemes_Mtslideshow_Block_Info extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
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
	$content = 'MT Slideshow version : 2.0.17<br/>Author : <a href="http://www.magentheme.com" title="Magento Themes">MagenTheme.Com</a><br />Copyright &copy; 2012- MagenTheme.Com';
	return $content;
    }
}