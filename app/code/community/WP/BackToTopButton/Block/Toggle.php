<?php

class WP_BackToTopButton_Block_Toggle extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        if (Mage::helper('backtotopbutton')->isDisabled()) return;
        $layout = $this->getLayout();
        $beforeBodyEnd = $layout->getBlock('before_body_end');
        if (is_object($beforeBodyEnd)) {
            // --- button ---
            $block = $layout->getBlock('back_to_top_button');
            if (!is_object($block)) {
                $block = $layout->createBlock('core/template', 'back_to_top_button')
                    ->setTemplate('webandpeople/backtotopbutton/button.phtml');
            }
            $beforeBodyEnd->append($block);
            // --- css ---
            $head = $layout->getBlock('head');
            $head->addItem('skin_css', 'css/webandpeople/backtotopbutton/backtotopbutton.css');
            // --- js ---
            if (Mage::getStoreConfigFlag('backtotopbutton/general/include_jquery')) {
                $head->addItem('js', 'webandpeople/jquery/backtotopbutton/jquery.min.js');
                $head->addItem('js', 'webandpeople/jquery/backtotopbutton/jquery-noconflict.js');
            }
            $head->addItem('js', 'webandpeople/jquery_plugins/backtotopbutton/jquery-noconflict.js', 'name="wp_jquery_noconflict"');
            if (Mage::getStoreConfigFlag('backtotopbutton/general/include_waypoints')) {
                $head->addItem('js', 'webandpeople/jquery_plugins/backtotopbutton/waypoints.js', 'name="wp_jquery_plugins"');
            }
        }
    }
}
