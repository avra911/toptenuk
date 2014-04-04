<?php
class MagenThemes_MTColinusAdmin_Block_Adminhtml_System_Config_Form_Field_Static extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element);
       	$html .= '
            <div id="buttonsblock_content" class="buttons-set" style="padding: 10px 0 0 0;">
                <button type="button" class="scalable show-hide" id="init_'.$element->getHtmlId().'">
                    <span><span><span>Show / Hide Editor</span></span></span>
                </button>
                <button type="button" class="scalable show-hide" id="statictoggle_'.$element->getHtmlId().'" style="display: none;">
                    <span><span><span>Show / Hide Editor</span></span></span>
                </button>
            </div>
            <script type="text/javascript">
                $mtkb(document).ready(function(){
                   $mtkb("#statictoggle_'.$element->getHtmlId().'").hide();
                   $mtkb("#init_'.$element->getHtmlId().'").on("click", function(){
                        tinyMCE.init({
                            mode : "exact",
                            theme : "advanced",
                            elements : "'.$element->getHtmlId().'",
                            width : "640",
                            height: "250",
                            theme_advanced_toolbar_location : "top",
                            theme_advanced_toolbar_align : "left",
                            theme_advanced_path_location : "bottom",
                        });
                        $mtkb("#statictoggle_'.$element->getHtmlId().'").show();
                        $mtkb("#init_'.$element->getHtmlId().'").hide();
                   });
                   $mtkb("#statictoggle_'.$element->getHtmlId().'").toggle(function() {
                        tinyMCE.get("'.$element->getHtmlId().'").hide();
                    }, function() {
                        tinyMCE.get("'.$element->getHtmlId().'").show();
                    });
                });
            </script>
       	';
        return $html;
    }
}
?>