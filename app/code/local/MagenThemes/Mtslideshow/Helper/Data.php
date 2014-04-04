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
class MagenThemes_Mtslideshow_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function jsonEncode($valueToEncode, $cycleCheck = false, $options = array())
    {
        $json = Zend_Json::encode($valueToEncode, $cycleCheck, $options);
        /* @var $inline Mage_Core_Model_Translate_Inline */
        $inline = Mage::getSingleton('core/translate_inline');
        if ($inline->isAllowed()) {
            $inline->setIsJson(true);
            $inline->processResponseBody($json);
            $inline->setIsJson(false);
        }

        return $json;
    }
    /*
     * @return boolean : Module is enable or not
     * 
     */
    public function getSpeedShow() {
        return Mage::getStoreConfig('mtslideshow/mtslideshow_config/speed_show');
    }
    public function isActive() {
        return Mage::getStoreConfig('mtslideshow/mtslideshow_config/enabled');
    }
    /*flexslider*/
    public function isHeightFlexSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/flexslider_height');
    }
    public function isAnimationFlexSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/flexslider_animation');
    }
    public function isAutoFlexSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/flexslider_auto');
    }
    public function isSmoothHeightFlexSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/flexslider_smoothheight');
    }
    public function isLoopFlexSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/flexslider_animation_loop');
    }
    public function isMousewheelFlexSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/flexslider_mousewheel');
    }
    public function isSlideshowSpeedFlexSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/flexslider_slideshow_speed');
    }
    public function isAnimationSpeedFlexSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/flexslider_animation_speed');
    }
    public function isControlNavFlexSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/flexslider_control_nav');
    }
    public function isDirectionNavFlexSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/flexslider_direction_nav');
    }
    public function isTimelineFlexSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/flexslider_timeline');
    }
    /*CooSlider*/
    public function isAutoCooSlider() {
    	return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_auto');
    }
    public function isDelayCooSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_delay');
    }
    public function isIntervalCooSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_interval');
    }
    public function isAnimSpeedCooSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_anim_speed');
    }
    public function isPauseHoverCooSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_pause_hover');
    }
    public function isSameEffectCooSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_same_random_text');
    }
    public function isTouchCooSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_touch');
    }
    public function isMouseWheelCooSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_mousewheel');
    }
    public function isResponsiveCooSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_responsive');
    }
    public function isKeyBoardCooSlider() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_keyboard');
    }
    public function isPagenaveCooSlider() {
    	return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_pagenav');
    }
    public function isDirectionCooSlider() {
    	return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_direction');
    }
    public function isTitleCooSlider() {
    	return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_title');
    }
    public function isDescCooSlider() {
    	return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_desc');
    }
    public function isMoreCooSlider() {
    	return Mage::getStoreConfig('mtslideshow/slider_settings/cooslider_more');
    }
    /*End*/
    /*MT Onebyone*/
    public function isAutoonebyone() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/onebyone_auto');
    }
    public function isSpeedonebyone() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/onebyone_anim_speed');
    }
    public function isPagenaveonebyone() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/onebyone_pagenav');
    }
    public function isDirectiononebyone() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/onebyone_direction');
    }
    public function isTitleonebyone() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/onebyone_title');
    }
    public function isDesconebyone() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/onebyone_desc');
    }
    public function isMoreonebyone() {
        return Mage::getStoreConfig('mtslideshow/slider_settings/onebyone_more');
    }
    /*End*/
}