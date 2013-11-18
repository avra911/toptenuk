<?php
class MagenThemes_MTColinusAdmin_Block_Adminhtml_System_Config_Form_Field_Color extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element); 
       	$html .= ' 
       		<script type="text/javascript">
		        $mtkb(function($){
		            $("#'.$element->getHtmlId().'").width("250px").attr("data-hex", true).mColorPicker({swatches: [
		              "#9a1212",
		              "#93ad2a" 
		            ]});
		        });
		    </script> 
       	';
        return $html;
    }
}
?>