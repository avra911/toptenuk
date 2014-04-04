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
class MagenThemes_Mtslideshow_Block_Adminhtml_Mtslideshow_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'mtslideshow';
        $this->_controller = 'adminhtml_mtslideshow';
        
        $this->_updateButton('save', 'label', Mage::helper('mtslideshow')->__('Save Slide'));
        $this->_updateButton('delete', 'label', Mage::helper('mtslideshow')->__('Delete Slide'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('mtslideshow_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'mtslideshow_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'mtslideshow_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }	    
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('mtslideshow_data') && Mage::registry('mtslideshow_data')->getId() ) {
            return Mage::helper('mtslideshow')->__("Edit Slide '%s'", $this->htmlEscape(Mage::registry('mtslideshow_data')->getName()));
        } else {
            return Mage::helper('mtslideshow')->__('Add Slide');
        }
    }
}