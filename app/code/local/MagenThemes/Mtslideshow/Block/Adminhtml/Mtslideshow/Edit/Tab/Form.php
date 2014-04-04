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
class MagenThemes_Mtslideshow_Block_Adminhtml_Mtslideshow_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
	$form = new Varien_Data_Form();
	$this->setForm($form);
	$fieldset = $form->addFieldset('mtslideshow_form', array('legend'=>Mage::helper('mtslideshow')->__('Slide information'))); 
	$slide_id = $this->getRequest()->getParam('id');
	$model  = Mage::getModel('mtslideshow/mtslideshow')->load($slide_id);
	$fieldset->addField('name', 'text', array(
	    'label'     => Mage::helper('mtslideshow')->__('Identifier'),
	    'required'  => true,
	    'class'	=> 'validate-xml-identifier',
	    'name'      => 'name',
	)); 
	    
	$fieldset->addField('position', 'select', array(
	    'label'     => Mage::helper('mtslideshow')->__('Position'),
	    'name'      => 'position',
	    'required'  => true,
	    'values'    => Mage::getModel('mtslideshow/position')->editOptionArray()
	));
	    
	if (!Mage::app()->isSingleStoreMode()) {
	    $fieldset->addField('stores', 'multiselect', array(
		    'label'     => Mage::helper('mtslideshow')->__('Visible In'),
		    'required'  => true,
		    'name'      => 'stores[]',
		    'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(),
		    'value'     => 'stores'
	    ));
	} else {
	    $fieldset->addField('stores', 'hidden', array(
		    'name'      => 'stores[]',
		    'value'     => Mage::app()->getStore(true)->getId()
	    ));
	}
	
	$fieldset->addField('style', 'select', array(
		    'label'     => Mage::helper('mtslideshow')->__('Style'),
		    'name'      => 'style',
		    'values'    => Mage::getModel('mtslideshow/config_mode')->toOptionArray()
	));
	if($model->getStyle()=='mtcooslider' || $model->getStyle()=='mtonebyone'){
	$fieldset->addField('bgmode', 'select', array(
			'label'     => Mage::helper('mtslideshow')->__('Background Mode'),
			'name'      => 'bgmode',
			'values'    => Mage::getModel('mtslideshow/config_bgmode')->toOptionArray()
	)); 
	}
	if($model->getStyle()=='mtcooslider' || $model->getStyle()=='mtonebyone'){
	$fieldset->addField('bg_color', 'text', array(
			'label' => Mage::helper('mtslideshow')->__('Background Color'),
			'id' => 'bg_color',
			'class' => 'required-entry',
			'required' => true,
			'name' => 'bg_color', 
			'after_element_html' => ''
			. "
			<script type='text/javascript' src='".$this->getJsUrl('magenthemes/mtslideshow/jquery/1.9.1/jquery-1.9.1.min.js')."'></script>
       		<script type='text/javascript' src='".$this->getJsUrl('magenthemes/mtslideshow/mColorPicker.js')."'></script>
       		<link href='".$this->getJsUrl('magenthemes/mtslideshow/css/adminstyle.css')."' type='text/css' rel='stylesheet'>
			<script type=\"text/javascript\">
				var jQuery = jQuery.noConflict();
				jQuery(document).ready(function(){
    				jQuery.fn.mColorPicker.defaults.currentId=false;
	            	jQuery.fn.mColorPicker.defaults.currentInput = false;
	            	jQuery.fn.mColorPicker.defaults.currentColor = false;
	            	jQuery.fn.mColorPicker.defaults.changeColor = false;
	            	jQuery.fn.mColorPicker.init.showLogo = false;
	            	jQuery.fn.mColorPicker.defaults.color = true;
	            	jQuery.fn.mColorPicker.defaults.imageFolder = '".$this->getJsUrl('magenthemes/mtslideshow/images/')."';  
    			});
		        jQuery(function($){ 
		            $('#bg_color').width('250px').attr('data-hex', true).mColorPicker({swatches: [
		              '#9a1212',
		              '#93ad2a' 
		            ]});
		        });
		    </script> 
			",)
	); 
	}
	if($model->getStyle()=='mtcooslider' || $model->getStyle()=='mtonebyone'){
        $fieldset->addField('slide_width', 'text', array(
                'label'     => Mage::helper('mtslideshow')->__('Slide Width'),
                'required'  => true,
                'class'	=> 'validate-greater-than-zero',
                'name'      => 'slide_width',
        ));
        $fieldset->addField('slide_height', 'text', array(
                'label'     => Mage::helper('mtslideshow')->__('Slide Height'),
                'required'  => true,
                'class'	=> 'validate-greater-than-zero',
                'name'      => 'slide_height',
        ));
	}
	$fieldset->addField('width', 'text', array(
		    'label'     => Mage::helper('mtslideshow')->__('Width'),
		    'required'  => true,
		    'class'	=> 'validate-greater-than-zero',
		    'name'      => 'width',
	));
	
	$fieldset->addField('height', 'text', array(
		    'label'     => Mage::helper('mtslideshow')->__('Height'),
		    'required'  => true,
		    'class'	=> 'validate-greater-than-zero',
		    'name'      => 'height',
	));		
	
	$fieldset->addField('sort_order', 'text', array(
		    'label'     => Mage::helper('mtslideshow')->__('Sort Order'),
		    'required'  => false,
		    'name'      => 'sort_order',
	));
		  
	$fieldset->addField('status', 'select', array(
	    'label'     => Mage::helper('mtslideshow')->__('Status'),
	    'name'      => 'status',
	    'values'    => array(
		array(
		    'value'     => 1,
		    'label'     => Mage::helper('mtslideshow')->__('Enabled'),
		),
  
		array(
		    'value'     => 2,
		    'label'     => Mage::helper('mtslideshow')->__('Disabled'),
		),
	    ),
	));	
       
	if ( Mage::getSingleton('adminhtml/session')->getMtslideshowData() ) {
	    $form->setValues(Mage::getSingleton('adminhtml/session')->getMtslideshowData());
	    Mage::getSingleton('adminhtml/session')->setMtslideshowData(null);
	} elseif ( Mage::registry('mtslideshow_data') ) {
	    $form->setValues(Mage::registry('mtslideshow_data')->getData());
	}
	return parent::_prepareForm();
    }
}