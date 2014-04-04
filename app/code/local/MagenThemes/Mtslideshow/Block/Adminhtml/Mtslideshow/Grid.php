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
class MagenThemes_Mtslideshow_Block_Adminhtml_Mtslideshow_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('mtslideshowGrid');
      $this->setDefaultSort('position');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('mtslideshow/mtslideshow')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('slide_id', array(
          'header'    => Mage::helper('mtslideshow')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'slide_id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('mtslideshow')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));
	  
	  if (!Mage::app()->isSingleStoreMode()) {
		  $this->addColumn('stores', array(
			  'header'        => Mage::helper('mtslideshow')->__('Store View'),
			  'index'         => 'stores',
			  'type'          => 'store',
			  'width'     	  => '150px',
			  'align'		  => 'center',
			  'store_all'     => true,
			  'store_view'    => true,
			  'sortable'      => false,
			  'filter_condition_callback' => array($this, '_filterStoreCondition'),
		  ));
	  }
	  
	  $this->addColumn('position', array(
		  'header'    => Mage::helper('mtslideshow')->__('Position'),
		  'align'     => 'left',
		  'width'     => '80px',
		  'index'     => 'position',
		  'type'      => 'options',
		  'options'   => Mage::getSingleton('mtslideshow/position')->gridOptionArray(),
	  ));
	  
	  $this->addColumn('sort_order', array(
          'header'    => Mage::helper('mtslideshow')->__('Sort Order'),
          'align'     =>'left',
		  'width'     => '80px',
          'index'     => 'sort_order',
      ));

      $this->addColumn('status', array(
          'header'    => Mage::helper('mtslideshow')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('mtslideshow')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('mtslideshow')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('mtslideshow')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('mtslideshow')->__('XML'));
	  
      return parent::_prepareColumns();
  }
  
  protected function _afterLoadCollection()
  {
	  $this->getCollection()->walk('afterLoad');
	  parent::_afterLoadCollection();
  }
  
  protected function _filterStoreCondition($collection, $column)
  {
	  if (!$value = $column->getFilter()->getValue()) {
		  return;
	  }

	  $this->getCollection()->addStoreFilter($value);
  }

  protected function _prepareMassaction()
  {
	  $this->setMassactionIdField('slide_id');
	  $this->getMassactionBlock()->setFormFieldName('mtslideshow');

	  $this->getMassactionBlock()->addItem('delete', array(
		   'label'    => Mage::helper('mtslideshow')->__('Delete'),
		   'url'      => $this->getUrl('*/*/massDelete'),
		   'confirm'  => Mage::helper('mtslideshow')->__('Are you sure?')
	  ));
	  return $this;
  }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}