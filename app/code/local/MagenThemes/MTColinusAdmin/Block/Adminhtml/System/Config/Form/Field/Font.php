<?php
class MagenThemes_MTColinusAdmin_Block_Adminhtml_System_Config_Form_Field_Font extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element); 
       	$html .= '<br/><div id="font_'.$element->getHtmlId().'" class="font_preview">The quick brown fox jumps over the lazy dog</div>';
       	$html .= '
       			<script type="text/javascript">
       				$mtkb(document).ready(function(){ 
       					var font = $mtkb("#'.$element->getHtmlId().'").val();
       					changeFont'.$element->getHtmlId().'(font);
    					$mtkb("#'.$element->getHtmlId().'").bind("change", function() {  
       						value = $mtkb("#'.$element->getHtmlId().'").val(); 
       						changeFont'.$element->getHtmlId().'(value); 
						});
       					function changeFont'.$element->getHtmlId().'(val){ 
       						var link = $mtkb("<link>", {
							    type: "text/css",
							    rel: "stylesheet", 
							    href: "//fonts.googleapis.com/css?family=" + val, 
							}).appendTo("head");
							$mtkb("#font_'.$element->getHtmlId().'").css("font-family", val);    								
    					}
    				});
       			</script>
       			';
        return $html;
    }
}
?>