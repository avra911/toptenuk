<?php 
  require "app/Mage.php";
  umask(0);
  Mage::app()->setCurrentStore(Mage::getModel('core/store')->load(Mage_Core_Model_App::ADMIN_STORE_ID));
  $categoryCollection = Mage::getModel('catalog/category')->getCollection()->addFieldToFilter('level',  array('gteq' => 2));
foreach($categoryCollection as $category) {
   if ($category->getProductCount() === 0) {
       print_r ($category->entity_id);
       echo "<br><hr><br>";
       $category->delete();
    }
}
echo 'End!';
?>