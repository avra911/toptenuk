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
class MagenThemes_Mtslideshow_Model_Layout
{
    private $_type = array(
                'tree_columns'      => 'page/3columns.phtml',
                'two_columns_left'  => 'page/2columns-left.phtml',
                'two_columns_right' => 'page/2columns-right.phtml',
                'one_column'        => 'page/1column.phtml'                
            );
    /*
     * @param string $template : template of root
     * @return string|null : type of layout
     */
    public function getTypeLayout($template) {
        foreach($this->_type as $type => $templateType) {
            if($templateType == $template) {
                return $type;
            }
        }
        return null;
    }
}