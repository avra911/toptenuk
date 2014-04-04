<?php
class MagenThemes_MTColinusAdmin_Block_Adminhtml_System_Config_Form_Field_Patternlist extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element);
		$directry = Mage::getBaseDir('media').DS.'magenthemes'.DS.'pattern_body'; 
		$urlparth = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$images = array();
		if (is_dir($directry)) {
			if ($dh = opendir($directry)) { 
				while (($file = readdir($dh)) !== false) {
					if(is_file($directry.DS.$file)){
						$filetype = substr($file, -3, 3);
						switch ($filetype)
						{ 
							case 'jpg':
							case 'png':
							case 'gif':  
								$images[] = $file; 
								break; 
						}
					} 
				} 
			}
		} 
		$html .='<div class="listpattern '.$element->getHtmlId().'_pattern">';
			$html .='<span class="item">
						<span class="ptnone">None</span>
						<input type="radio" name="'.$element->getHtmlId().'_pattern" value="none" style="margin-top: 7px;" class="valpt"/>
					 </span>';
			if($images){
				foreach ($images as $img){
			$html .='<span class="item">
						<img src="'.$urlparth.'/media/magenthemes/pattern_body/'.$img.'" />
						<input type="radio" name="'.$element->getHtmlId().'_pattern" value="'.$img.'" class="valpt"/>
					 </span>';
				}
			}
		$html .='</div>';
		$html .= ' 
				<script type="text/javascript">
					$mtkb(window).load(function(){  
						$mtkb(".'.$element->getHtmlId().'_pattern input[type=radio]").click(function(){ 
							$mtkb("#'.$element->getHtmlId().'").val($mtkb(this).val())
						}); 
						pattern'.$element->getHtmlId().'Active();
					});
					function pattern'.$element->getHtmlId().'Active(){
						var ptnbody =$mtkb("#'.$element->getHtmlId().'").val();
						$mtkb(".'.$element->getHtmlId().'_pattern input[type=radio]").each(function(i,rad){
							if(rad.value==ptnbody){  
								$mtkb(rad).attr("checked", true); 
							}   
						});
					}
				</script> 
			';
        return $html;
    }
}
?>