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
class MagenThemes_Mtslideshow_Block_Adminhtml_Mtslideshow_Edit_Tab_Page extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('mtslideshow_form', array('legend'=>Mage::helper('mtslideshow')->__('Display on CMS Page')));
        $fieldset->addField('pages', 'multiselect', array(
            'label'     => Mage::helper('mtslideshow')->__('CMS Page'),
            'name'      => 'pages[]',
            'values'    => Mage::getSingleton('mtslideshow/page')->toOptionArray()
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