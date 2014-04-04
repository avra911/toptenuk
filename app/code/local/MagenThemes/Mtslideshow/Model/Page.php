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
class MagenThemes_Mtslideshow_Model_Page extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('mtslideshow/page');
    }
    public function toOptionArray()
    {
        $_collection = Mage::getSingleton('cms/page')->getCollection()
                ->addFieldToFilter('is_active', 1);

        $_result = array();
        $_result[] = array('value' => '', 'label' => '----- No display on CMS Page -----');
        foreach ($_collection as $item) {
            $data = array(
                'value' => $item->getData('page_id'),
                'label' => $item->getData('title'));
            $_result[] = $data;
        }
        return $_result;
    }
}