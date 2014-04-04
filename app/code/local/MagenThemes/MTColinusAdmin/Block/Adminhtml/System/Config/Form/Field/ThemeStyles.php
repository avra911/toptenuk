<?php
class MagenThemes_MTColinusAdmin_Block_Adminhtml_System_Config_Form_Field_ThemeStyles extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element);  
		$curWebsite = $this->getRequest()->getParam('website');
        $curStore   = $this->getRequest()->getParam('store');
        $storeModel = Mage::getSingleton('adminhtml/system_store')->getStoreCollection($curStore);
        foreach(Mage::getSingleton('adminhtml/system_store')->getStoreCollection() as $store) { 
        	if($store->getCode()==$curStore){
        		$storeId = $store->getId();
        	}
        }  
       	$config = Mage::getStoreConfig('mtcolinusadmin/mtcolinusadmin_appearance',$storeId);
       	$bg_color = isset($config['bg_color']) ? $config['bg_color'] :''; 
       	$text_color = isset($config['text_color']) ? $config['text_color'] :'';
       	$link_color = isset($config['link_color']) ? $config['link_color'] :'';
       	$link_hover_color = isset($config['link_hover_color']) ? $config['link_hover_color'] :'';
       	$link_active_color = isset($config['link_active_color']) ? $config['link_active_color'] :'';
       	$pattern_body_select = isset($config['pattern_body_select']) ? $config['pattern_body_select'] :'';
		$header_pattern = isset($config['pattern_header_select']) ? $config['pattern_header_select'] : '';
		$top_pattern = isset($config['pattern_top_select']) ? $config['pattern_top_select'] : '';
		$pattern_copyright = isset($config['pattern_copyright_select']) ? $config['pattern_copyright_select'] : '';
       	$footer_pattern = isset($config['pattern_footer_select']) ? $config['pattern_footer_select'] : '';
       		
		$header_bg_color = isset($config['header_bg_color']) ? $config['header_bg_color'] :'';
       	$header_text_color = isset($config['header_text_color']) ? $config['header_text_color'] :'';
       	$header_link_color = isset($config['header_link_color']) ? $config['header_link_color'] :'';
       	$header_link_hover_color = isset($config['header_link_hover_color']) ? $config['header_link_hover_color'] :'';
       	$header_link_active_color = isset($config['header_link_active_color']) ? $config['header_link_active_color'] :'';

       	$icons_bg_color = isset($config['icons_bg_color']) ? $config['icons_bg_color'] :'';
       	$icons_bg_hover_color = isset($config['icons_bg_hover_color']) ? $config['icons_bg_hover_color'] :'';

       	$buttons_bg_color = isset($config['buttons_bg_color']) ? $config['buttons_bg_color'] :'';
       	$buttons_bg_hover_color = isset($config['buttons_bg_hover_color']) ? $config['buttons_bg_hover_color'] :'';
       	$buttons_text_color = isset($config['buttons_text_color']) ? $config['buttons_text_color'] :'';
       	$buttons_text_hover_color = isset($config['buttons_text_hover_color']) ? $config['buttons_text_hover_color'] :'';
       	$addtocart_bg_color = isset($config['addtocart_bg_color']) ? $config['addtocart_bg_color'] :'';
       	$addtocart_bg_hover_color = isset($config['addtocart_bg_hover_color']) ? $config['addtocart_bg_hover_color'] :'';
				
		$top_bg_color = isset($config['top_bg_color']) ? $config['top_bg_color'] :'';
		$top_bg_hover_color = isset($config['top_bg_hover_color']) ? $config['top_bg_hover_color'] :'';
       	$top_text_color = isset($config['top_text_color']) ? $config['top_text_color'] :'';
       	$top_link_color = isset($config['top_link_color']) ? $config['top_link_color'] :'';
       	$top_link_hover_color = isset($config['top_link_hover_color']) ? $config['top_link_hover_color'] :'';	
       	$top_link_active_color = isset($config['top_link_active_color']) ? $config['top_link_active_color'] :'';       		
		
       	$mainmenu_bg_color = isset($config['mainmenu_bg_color']) ? $config['mainmenu_bg_color'] :'';
       	$mainmenu_dropdown_bg_color = isset($config['mainmenu_dropdown_bg_color']) ? $config['mainmenu_dropdown_bg_color'] :'';
       	$mainmenu_bg_hover_color = isset($config['mainmenu_bg_hover_color']) ? $config['mainmenu_bg_hover_color'] :'';
       	$mainmenu_bg_active_color = isset($config['mainmenu_bg_active_color']) ? $config['mainmenu_bg_active_color'] :'';
       	$mainmenu_text_color = isset($config['mainmenu_text_color']) ? $config['mainmenu_text_color'] :'';
       	$mainmenu_link_color = isset($config['mainmenu_link_color']) ? $config['mainmenu_link_color'] :'';
       	$mainmenu_link_hover_color = isset($config['mainmenu_link_hover_color']) ? $config['mainmenu_link_hover_color'] :'';
       	$mainmenu_link_sub_hover_color = isset($config['mainmenu_link_sub_hover_color']) ? $config['mainmenu_link_sub_hover_color'] :'';
       	$mainmenu_link_active_color = isset($config['mainmenu_link_active_color']) ? $config['mainmenu_link_active_color'] :'';

       	$copyright_bg_color = isset($config['copyright_bg_color']) ? $config['copyright_bg_color'] :'';
		$copyright_text_color = isset($config['copyright_text_color']) ? $config['copyright_text_color'] :'';
		$copyright_link_color = isset($config['copyright_link_color']) ? $config['copyright_link_color'] :'';
		$copyright_link_hover_color = isset($config['copyright_link_hover_color']) ? $config['copyright_link_hover_color'] :'';
		$copyright_link_active_color = isset($config['copyright_link_active_color']) ? $config['copyright_link_active_color'] :'';
		
       	$footer_static_bg_color = isset($_COOKIE['footer_static_bg_color']) ? $_COOKIE['footer_static_bg_color'] : $config['footer_static_bg_color']; 
		$footer_static_text_color = isset($_COOKIE['footer_static_text_color']) ? $_COOKIE['footer_static_text_color'] :$config['footer_static_text_color']; 
		$footer_static_link_color = isset($_COOKIE['footer_static_link_color']) ? $_COOKIE['footer_static_link_color'] :$config['footer_static_link_color'];
		$footer_static_link_hover_color = isset($_COOKIE['footer_static_link_hover_color']) ? $_COOKIE['footer_static_link_hover_color'] :$config['footer_static_link_hover_color'];
		$footer_static_link_active_color = isset($_COOKIE['footer_static_link_active_color']) ? $_COOKIE['footer_static_link_active_color'] :$config['footer_static_link_active_color'];	
			
		$_storeBaseUrl = str_replace('index.php', '', Mage::getBaseUrl());
		$html .= '
				<script language="javascript" type="text/javascript" src="'.$_storeBaseUrl.'js/tiny_mce/tiny_mce.js"></script>
				';	
		
       	$html .='
       		<script type="text/javascript" src="'.$this->getJsUrl('magenthemes/mt_colinus/js/jquery-1.8.2.min.js').'"></script>
       		<script type="text/javascript" src="'.$this->getJsUrl('magenthemes/mt_colinus/js/mColorPicker.js').'"></script>
			<link href="'.$this->getJsUrl('magenthemes/mt_colinus/css/adminstyle.css').'" type="text/css" rel="stylesheet">
            <style>
                    #mColorPickerImg{background-image: url("'.$this->getJsUrl('magenthemes/mt_colinus/images/').'picker.png") !important;}
				    div.listpattern{float:left;overflow: hidden;}
					div.listpattern span.item {overflow:hidden; width: 50px; float:left; text-align: center; margin:0 6px 6px 0px;}
					div.listpattern span.item img{width: 50px; height: 50px;}
					div.listpattern span.item .ptnone {background: #fff; width: 50px; height: 50px; display:block;line-height:50px;color:#999;}
					span.delete-image{display:none;}
					#row_mtcolinusadmin_mtcolinusadmin_appearance_pattern_upload_body a {display:none} 
					#row_mtcolinusadmin_mtcolinusadmin_appearance_pattern_upload_main a {display:none}
					#mtcolinusadmin_mtcolinusadmin_appearance_pattern_body_select {display:none;}					
					#row_mtcolinusadmin_mtcolinusadmin_appearance_pattern_upload_header a {display:none}
					#mtcolinusadmin_mtcolinusadmin_appearance_pattern_header_select {display:none;}						
					#row_mtcolinusadmin_mtcolinusadmin_appearance_pattern_upload_top a {display:none}
					#mtcolinusadmin_mtcolinusadmin_appearance_pattern_top_select {display:none;}
					#row_mtcolinusadmin_mtcolinusadmin_appearance_pattern_upload_copyright a {display:none}
					#mtcolinusadmin_mtcolinusadmin_appearance_pattern_copyright_select {display:none;}	
					#row_mtcolinusadmin_mtcolinusadmin_appearance_pattern_main a {display:none}
					#mtcolinusadmin_mtcolinusadmin_appearance_pattern_main_select {display:none;}					
					#row_mtcolinusadmin_mtcolinusadmin_appearance_pattern_upload_footer a {display:none}
					#mtcolinusadmin_mtcolinusadmin_appearance_pattern_footer_select {display:none;}	
					
			</style>
			<script type="text/javascript"> 
       				$mtkb(document).ready(function($) { 
       					$mtkb.fn.mColorPicker.defaults.currentId=false;
		            	$mtkb.fn.mColorPicker.defaults.currentInput = false;
		            	$mtkb.fn.mColorPicker.defaults.currentColor = false;
		            	$mtkb.fn.mColorPicker.defaults.changeColor = false;
		            	$mtkb.fn.mColorPicker.init.showLogo = false;
		            	$mtkb.fn.mColorPicker.defaults.color = true;
		            	$mtkb.fn.mColorPicker.defaults.imageFolder = "'.$this->getJsUrl('magenthemes/mt_colinus/images/').'"; 
       					var value = "'.$config['theme_styles'].'"; 
    					var styles = {
						    blue : {
								bg_color: "#FFFFFF",
                                pattern_body_select: "none",
								pattern_header_select: "none",
								pattern_top_select: "none",
								pattern_copyright_select: "none",
       							pattern_footer_select: "none",								
								text_color: "#676767 ",
								link_color: "#454545",
								link_hover_color: "#89B9C5",
								link_active_color: "#89B9C5",
								header_bg_color: "#FFFFFF",
								header_text_color: "#ADADAD",
								header_link_color: "#676767",
								header_link_hover_color: "#89B9C5",
								header_link_active_color: "#89B9C5",
								top_bg_color: "#89B9C5",
								top_bg_hover_color: "#FFFFFF",
								top_text_color: "#757575",
								top_link_color: "#FFFFFF",
								top_link_hover_color: "#89B9C5",
								top_link_active_color: "#89B9C5",
								icons_bg_color: "#CFCFCF",
								icons_bg_hover_color: "#89B9C5",
								buttons_bg_color: "#CFCFCF",
								buttons_bg_hover_color: "#89B9C5",
								buttons_text_color: "#FFFFFF",
								buttons_text_hover_color: "#FFFFFF",
								addtocart_bg_color: "#89B9C5",
								addtocart_bg_hover_color: "#CFCFCF",
								mainmenu_bg_color: "#ECECEC",
								mainmenu_dropdown_bg_color: "#FFFFFF",
								mainmenu_bg_hover_color: "#89B9C5",
								mainmenu_bg_active_color: "#89B9C5",
								mainmenu_text_color: "#4A4A4A",
								mainmenu_link_color: "#757575",								
								mainmenu_link_hover_color: "#FFFFFF",
								mainmenu_link_sub_hover_color: "#89B9C5",
								mainmenu_link_active_color: "#FFFFFF",
								copyright_bg_color: "#C1C1C1",
								copyright_text_color: "#676767",
								copyright_link_color: "#676767",
								copyright_link_hover_color: "#89B9C5",
								copyright_link_active_color: "#89B9C5",			
								footer_static_bg_color: "#ECECEC",
								footer_static_text_color: "#676767",
								footer_static_link_color: "#838383",
								footer_static_link_hover_color: "#89B9C5",
								footer_static_link_active_color: "#89B9C5"
							},
							
							red : {
								bg_color: "#FFFFFF", 
								pattern_body_select: "none",
							    pattern_header_select: "none",
								pattern_top_select: "none",
								pattern_copyright_select: "none",
       							pattern_footer_select: "none",
								text_color: "#676767 ",
								link_color: "#454545",
								link_hover_color: "#FF4F4F",
								link_active_color: "#FF4F4F",
								header_bg_color: "#FFFFFF",
								header_text_color: "#ADADAD",
								header_link_color: "#676767",
								header_link_hover_color: "#FF4F4F",
								header_link_active_color: "#FF4F4F",
								top_bg_color: "#FF4F4F",
								top_bg_hover_color: "#FFFFFF",
								top_text_color: "#757575",
								top_link_color: "#FFFFFF",
								top_link_hover_color: "#FF4F4F",
								top_link_active_color: "#FF4F4F",
								icons_bg_color: "#CFCFCF",
								icons_bg_hover_color: "#FF4F4F",
								buttons_bg_color: "#CFCFCF",
								buttons_bg_hover_color: "#FF4F4F",
								buttons_text_color: "#FFFFFF",
								buttons_text_hover_color: "#FFFFFF",
								addtocart_bg_color: "#FF4F4F",
								addtocart_bg_hover_color: "#CFCFCF",
								mainmenu_bg_color: "#ECECEC",
								mainmenu_dropdown_bg_color: "#FFFFFF",
								mainmenu_bg_hover_color: "#FF4F4F",
								mainmenu_bg_active_color: "#FF4F4F",
								mainmenu_text_color: "#4A4A4A",
								mainmenu_link_color: "#757575",								
								mainmenu_link_hover_color: "#FFFFFF",
								mainmenu_link_sub_hover_color: "#FF4F4F",
								mainmenu_link_active_color: "#FFFFFF",								
								copyright_bg_color: "#C1C1C1",
								copyright_text_color: "#676767",
								copyright_link_color: "#676767",
								copyright_link_hover_color: "#FF4F4F",
								copyright_link_active_color: "#FF4F4F",
								footer_static_bg_color: "#ECECEC",
								footer_static_text_color: "#676767",
								footer_static_link_color: "#838383",
								footer_static_link_hover_color: "#FF4F4F",
								footer_static_link_active_color: "#FF4F4F"
							},
							
							green : {
								bg_color: "#FFFFFF",
								pattern_body_select: "none",	
								pattern_header_select: "none",
								pattern_top_select: "none",
								pattern_copyright_select: "none",
       							pattern_footer_select: "none",
								text_color: "#676767 ",
								link_color: "#454545",
								link_hover_color: "#5DBA5D",
								link_active_color: "#5DBA5D",
								header_bg_color: "#FFFFFF",
								header_text_color: "#ADADAD",
								header_link_color: "#676767",	
								header_link_hover_color: "#5DBA5D",
								header_link_active_color: "#5DBA5D",
								top_bg_color: "#5DBA5D",
								top_bg_hover_color: "#FFFFFF",
								top_text_color: "#757575",
								top_link_color: "#FFFFFF",
								top_link_hover_color: "#5DBA5D",
								top_link_active_color: "#5DBA5D",
								icons_bg_color: "#CFCFCF",
								icons_bg_hover_color: "#5DBA5D",
								buttons_bg_color: "#CFCFCF",
								buttons_bg_hover_color: "#5DBA5D",
								buttons_text_color: "#FFFFFF",
								buttons_text_hover_color: "#FFFFFF",
								addtocart_bg_color: "#5DBA5D",
								addtocart_bg_hover_color: "#CFCFCF",
								mainmenu_bg_color: "#ECECEC",
								mainmenu_dropdown_bg_color: "#FFFFFF",
								mainmenu_bg_hover_color: "#5DBA5D",
								mainmenu_bg_active_color: "#5DBA5D",
								mainmenu_text_color: "#4A4A4A",
								mainmenu_link_color: "#757575",
								mainmenu_link_hover_color: "#FFFFFF",
								mainmenu_link_sub_hover_color: "#5DBA5D",
								mainmenu_link_active_color: "#FFFFFF",
								copyright_bg_color: "#C1C1C1",
								copyright_text_color: "#676767",
								copyright_link_color: "#676767",
								copyright_link_hover_color: "#5DBA5D",
								copyright_link_active_color: "#5DBA5D",
								footer_static_bg_color: "#ECECEC",
								footer_static_text_color: "#676767",
								footer_static_link_color: "#838383",
								footer_static_link_hover_color: "#5DBA5D",
								footer_static_link_active_color: "#5DBA5D"
							},
							
							custom : {
								bg_color: "'.$bg_color.'", 
								pattern_body_select: "'.$pattern_body_select.'",
								pattern_header_select: "'.$header_pattern.'",
								pattern_header_select: "'.$top_pattern.'",
       							pattern_footer_select: "'.$footer_pattern.'",
								text_color: "'.$text_color.'",
								link_color: "'.$link_color.'", 
								link_hover_color: "'.$link_hover_color.'",
								link_active_color: "'.$link_active_color.'",
								header_bg_color: "'.$header_bg_color.'",
								header_text_color: "'.$header_text_color.'",
								header_link_color: "'.$header_link_color.'",
								header_link_hover_color: "'.$header_link_hover_color.'",
								header_link_active_color: "'.$header_link_active_color.'",
								top_bg_color: "'.$top_bg_color.'",
								top_bg_hover_color: "'.$top_bg_hover_color.'",
								top_text_color: "'.$top_text_color.'",
								top_link_color: "'.$top_link_color.'",	
								top_link_hover_color: "'.$top_link_hover_color.'",	
								top_link_active_color:"'.$top_link_active_color.'",
								icons_bg_color: "'.$icons_bg_color.'",	
								icons_bg_hover_color: "'.$icons_bg_hover_color.'",
								buttons_bg_color: "'.$buttons_bg_color.'",
								buttons_text_color: "'.$buttons_text_color.'",
								buttons_text_hover_color: "'.$buttons_text_hover_color.'",					
								buttons_bg_hover_color: "'.$buttons_bg_hover_color.'",
								addtocart_bg_color: "'.$addtocart_bg_color.'",
								addtocart_bg_hover_color: "'.$addtocart_bg_hover_color.'",
								mainmenu_bg_color: "'.$mainmenu_bg_color.'",
								mainmenu_dropdown_bg_color: "'.$mainmenu_dropdown_bg_color.'",
								mainmenu_bg_hover_color: "'.$mainmenu_bg_hover_color.'",
								mainmenu_bg_active_color: "'.$mainmenu_bg_active_color.'",
								mainmenu_text_color: "'.$mainmenu_text_color.'",
								mainmenu_link_color: "'.$mainmenu_link_color.'",
								mainmenu_link_hover_color: "'.$mainmenu_link_hover_color.'",
								mainmenu_link_sub_hover_color: "'.$mainmenu_link_sub_hover_color.'",
								mainmenu_link_active_color: "'.$mainmenu_link_active_color.'",
								copyright_bg_color: "'.$copyright_bg_color.'",
								copyright_text_color: "'.$copyright_text_color.'",
								copyright_link_color: "'.$copyright_link_color.'",
								copyright_link_hover_color: "'.$copyright_link_hover_color.'",
								copyright_link_active_color: "'.$copyright_link_active_color.'",
								footer_static_bg_color: "'.$footer_static_bg_color.'",
								footer_static_text_color: "'.$footer_static_text_color.'",
								footer_static_link_color: "'.$footer_static_link_color.'",
								footer_static_link_hover_color: "'.$footer_static_link_hover_color.'",
								footer_static_link_active_color: "'.$footer_static_link_active_color.'"
							} 
						} 
       					changeStyle(value,styles);
       					$mtkb("#'.$element->getHtmlId().'").bind("change", function() {  
       						value = $mtkb("#'.$element->getHtmlId().'").val(); 
       						changeStyle(value,styles); 
						}); 
       					function changeStyle(apper,styles){ 
       						if(apper=="blue" || apper=="red" || apper=="green"){
    							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_bg_color").attr("readonly","");
    							$mtkb(".valpt").attr("disabled","");
    							$mtkb(".valptheader").attr("disabled","");
    							$mtkb(".valptfooter").attr("disabled","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_text_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_link_color").attr("readonly",""); 
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_link_hover_color").attr("readonly",""); 
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_link_active_color").attr("readonly",""); 
								
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_header_bg_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_header_text_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_header_link_color").attr("readonly","");	
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_header_link_hover_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_header_link_active_color").attr("readonly","");

								$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_bg_color").attr("readonly","");
								$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_bg_hover_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_text_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_link_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_link_hover_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_link_active_color").attr("readonly","");

       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_icons_bg_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_icons_bg_hover_color").attr("readonly","");

       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_buttons_bg_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_buttons_bg_hover_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_buttons_text_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_buttons_text_hover_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_addtocart_bg_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_addtocart_bg_hover_color").attr("readonly","");

       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_bg_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_dropdown_bg_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_bg_hover_color").attr("readonly","");						
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_bg_active_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_text_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_hover_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_sub_hover_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_active_color").attr("readonly","");

       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_copyright_bg_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_copyright_text_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_copyright_link_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_copyright_link_hover_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_copyright_link_active_color").attr("readonly","");

       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_footer_static_bg_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_footer_static_text_color").attr("readonly","");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_footer_static_link_color").attr("readonly",""); 
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_footer_static_link_hover_color").attr("readonly",""); 
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_footer_static_link_active_color").attr("readonly","");
    						}else{
    							$mtkb(".valpt").removeAttr("disabled");
    							$mtkb(".valptheader").removeAttr("disabled");
    							$mtkb(".valptfooter").removeAttr("disabled"); 
    							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_bg_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_text_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_link_color").removeAttr("readonly");	
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_link_hover_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_link_active_color").removeAttr("readonly");

       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_header_bg_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_header_text_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_header_link_color").removeAttr("readonly");	
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_header_link_hover_color").removeAttr("readonly");	
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_header_link_active_color").removeAttr("readonly");	

								$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_bg_color").removeAttr("readonly");
								$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_bg_hover_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_text_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_link_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_link_hover_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_top_link_active_color").removeAttr("readonly");

       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_icons_bg_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_icons_bg_hover_color").removeAttr("readonly"); 

       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_buttons_bg_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_buttons_bg_hover_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_buttons_text_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_buttons_text_hover_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_addtocart_bg_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_addtocart_bg_hover_color").removeAttr("readonly");

       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_bg_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_dropdown_bg_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_bg_hover_color").removeAttr("readonly");								
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_bg_active_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_text_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_hover_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_sub_hover_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_active_color").removeAttr("readonly");

       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_copyright_bg_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_copyright_text_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_copyright_link_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_copyright_link_hover_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_copyright_link_active_color").removeAttr("readonly");

       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_footer_static_bg_color").removeAttr("readonly"); 
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_footer_static_text_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_footer_static_link_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_footer_static_link_hover_color").removeAttr("readonly");
       							$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_footer_static_link_active_color").removeAttr("readonly");
    						}
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_bg_color", styles[apper]["bg_color"]); 
       						$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_pattern_body_select").val(styles[apper]["pattern_body_select"]);
       						$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_pattern_header_select").val(styles[apper]["pattern_header_select"]);
       						$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_pattern_footer_select").val(styles[apper]["pattern_footer_select"]);
       						$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_pattern_top_select").val(styles[apper]["pattern_top_select"]);
       						$mtkb("#mtcolinusadmin_mtcolinusadmin_appearance_pattern_copyright_select").val(styles[apper]["pattern_copyright_select"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_text_color", styles[apper]["text_color"]); 
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_link_color", styles[apper]["link_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_link_hover_color", styles[apper]["link_hover_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_link_active_color", styles[apper]["link_active_color"]);

       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_header_bg_color", styles[apper]["header_bg_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_header_text_color", styles[apper]["header_text_color"]); 
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_header_link_color", styles[apper]["header_link_color"]); 	
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_header_link_hover_color", styles[apper]["header_link_hover_color"]); 
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_header_link_active_color", styles[apper]["header_link_active_color"]); 			

							$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_top_bg_color", styles[apper]["top_bg_color"]);
							$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_top_bg_hover_color", styles[apper]["top_bg_hover_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_top_text_color", styles[apper]["top_text_color"]); 
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_top_link_color", styles[apper]["top_link_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_top_link_hover_color", styles[apper]["top_link_hover_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_top_link_active_color", styles[apper]["top_link_active_color"]);

       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_icons_bg_color", styles[apper]["icons_bg_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_icons_bg_hover_color", styles[apper]["icons_bg_hover_color"]);

       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_buttons_bg_color", styles[apper]["buttons_bg_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_buttons_bg_hover_color", styles[apper]["buttons_bg_hover_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_buttons_text_color", styles[apper]["buttons_text_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_buttons_text_hover_color", styles[apper]["buttons_text_hover_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_addtocart_bg_color", styles[apper]["addtocart_bg_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_addtocart_bg_hover_color", styles[apper]["addtocart_bg_hover_color"]);

       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_bg_color", styles[apper]["mainmenu_bg_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_dropdown_bg_color", styles[apper]["mainmenu_dropdown_bg_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_bg_hover_color", styles[apper]["mainmenu_bg_hover_color"]);						
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_bg_active_color", styles[apper]["mainmenu_bg_active_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_text_color", styles[apper]["mainmenu_text_color"]); 
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_color", styles[apper]["mainmenu_link_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_hover_color", styles[apper]["mainmenu_link_hover_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_sub_hover_color", styles[apper]["mainmenu_link_sub_hover_color"]);
							$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_mainmenu_link_active_color", styles[apper]["mainmenu_link_active_color"]);

							$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_copyright_bg_color", styles[apper]["copyright_bg_color"]);
							$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_copyright_text_color", styles[apper]["copyright_text_color"]);
							$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_copyright_link_color", styles[apper]["copyright_link_color"]);
							$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_copyright_link_hover_color", styles[apper]["copyright_link_hover_color"]);
							$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_copyright_link_active_color", styles[apper]["copyright_link_active_color"]);

       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_footer_static_bg_color", styles[apper]["footer_static_bg_color"]);
       						$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_footer_static_text_color", styles[apper]["footer_static_text_color"]);  
							$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_footer_static_link_color", styles[apper]["footer_static_link_color"]); 
							$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_footer_static_link_hover_color", styles[apper]["footer_static_link_hover_color"]); 
							$mtkb.fn.mColorPicker.setInputColor("mtcolinusadmin_mtcolinusadmin_appearance_footer_static_link_active_color", styles[apper]["footer_static_link_active_color"]);				
    						 
    						patternmtcolinusadmin_mtcolinusadmin_appearance_pattern_body_selectActive();
    						patternmtcolinusadmin_mtcolinusadmin_appearance_pattern_header_selectActive();
    						patternmtcolinusadmin_mtcolinusadmin_appearance_pattern_footer_selectActive();
    						patternmtcolinusadmin_mtcolinusadmin_appearance_pattern_top_selectActive();
    						patternmtcolinusadmin_mtcolinusadmin_appearance_pattern_copyright_selectActive();							
    					 }
    				});       				
            </script>
       	'; 
        return $html;
    }
}
?>