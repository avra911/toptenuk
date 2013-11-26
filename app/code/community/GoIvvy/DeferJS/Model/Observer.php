<?php
class GoIvvy_DeferJS_Model_Observer 
{
   public function filterHtml($observer)
   {
      if(!Mage::helper('goivvy_deferjs')->isEnabled())
         return $this;
      $html = $observer->getEvent()->getTransport()->getHtml();
      $block = $observer->getEvent()->getBlock();
      if(preg_match('/goivvy_deferjs_inline/',$block->getNameInLayout()) || preg_match('/goivvy_deferjs_script/',$block->getNameInLayout())) return;
      preg_match_all('@(?:<script type="text/javascript">|<script>)(.*)</script>@msU',$html,$_matches);
      $_js_arr = $_matches[1];
      foreach($_js_arr as &$_ja)
         $_ja .= ";"; 
      $observer->getEvent()->getTransport()->setHtml(preg_replace('@(?:<script type="text/javascript">|<script>).*</script>@msU','',$html));
      $html = $observer->getEvent()->getTransport()->getHtml();
      $_js = preg_replace('/var\s/','',preg_replace('/;\s*;/msU',';',preg_replace('@//.*\]\]>@','',preg_replace('@//.*<!\[CDATA\[@','',implode(' ',$_js_arr)))));
      $_js_block = Mage::app()->getFrontController()->getAction()->getLayout()->createBlock('core/text')->setText($_js);
      if(Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('goivvy_deferjs_inline'))
      Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('goivvy_deferjs_inline')->append($_js_block);
   }
   
   public function addBlockToTheEnd($observer)
   {
      if(!Mage::helper('goivvy_deferjs')->isEnabled())
         return $this;

      $layout = $observer->getEvent()->getLayout()->getUpdate();
      $layout->addHandle('goivvy_deferjs_custom_handle_inline');
      return $this; 
   }
}
