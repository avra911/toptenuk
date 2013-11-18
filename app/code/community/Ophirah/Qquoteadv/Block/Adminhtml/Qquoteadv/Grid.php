<?php

class Ophirah_Qquoteadv_Block_Adminhtml_Qquoteadv_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
      parent::__construct();
      $this->setId('qquoteGrid');
      $this->setSaveParametersInSession(true);
      $this->setDefaultSort('increment_id');
      $this->setDefaultDir('desc');
    }
    
    
    /*
     * Adding button Create New Quote
     * 
     */
    
        protected function  _prepareLayout()
    {        
        $this->setChild('priceupdate_deactivate_button',
          $this->getLayout()->createBlock('adminhtml/widget_button')
          ->setData(array(
            'label'     => Mage::helper('qquoteadv')->__('Create New Quote'),
            'onclick'   => 'setLocation(\'' . $this->getCreateQuoteUrl() . '\')',              
            'class' => 'add'
          ))
                
        );

        return parent::_prepareLayout();
    }

    public function  getSearchButtonHtml()
    {      
        return parent::getSearchButtonHtml() . $this->getChildHtml('priceupdate_deactivate_button');
    }
    
    public function getCreateQuoteUrl()
    {
        if(Mage::registry('current_customer')){
            $customer='/customer_id/'.Mage::registry('current_customer')->getId();
        } else {
            $customer ="";
        }
        return $this->getUrl('adminhtml/sales_order_create/start'.$customer);
    }
    
    /*
     * Setting up grid and adding data for display
     * 
     */
  
    protected function _setCollectionOrder($column)
    {
        $collection = $this->getCollection();
        if ($collection) {
            $columnIndex = $column->getFilterIndex() ?
                $column->getFilterIndex() : $column->getIndex();

                                if($columnIndex == 'increment_id') $columnIndex = 'quote_id';
            $collection->setOrder($columnIndex, $column->getDir());
        }
        return $this;
    }
	
  protected function _prepareCollection()
  {
  	  $country_id = Mage::getSingleton('admin/session')
                                ->getUser()
                                ->getRole()
                                ->getData('role_name');
          
          $collection = Mage::getModel('qquoteadv/qqadvcustomer')->getCollection()
                                ->addFieldToFilter('is_quote','1')
                                ->addFieldToFilter('customer_id',array('gt' =>'0'))
                                ->addFieldToFilter('status',array('gt' =>Ophirah_Qquoteadv_Model_Status::STATUS_BEGIN))
                                ;
          
          // Adding filter for customer quote
          if(Mage::registry('current_customer'))
          {
                $collection = $collection->addFieldToFilter('customer_id', Mage::registry('current_customer')->getId());   
          }
          
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {         
      $this->addColumn('increment_id', array(
          'header'    => Mage::helper('qquoteadv')->__('Quote #'),
          'align'     =>'left',
          'index'     => 'increment_id',
      ));

	   $this->addColumn('created_at', array(
            'header' => Mage::helper('qquoteadv')->__('Created On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));
        $_collection = Mage::getModel('admin/user')->getCollection();
        $adm = array();
        foreach($_collection as $model) {
         $name = $model->getFirstname() . ' ' . $model->getLastname();
         $adm[$model->getUserId()] =  $name;
        }
        $this->addColumn('user_id', array(
            'header'    => Mage::helper('qquoteadv')->__('Assigned to'),
            'width' => '100px',
            'align'     => 'left',
            'sortable'  => true,
            'index'     => 'user_id',
            'type'      => 'options',
            'options'   => $adm //Ophirah_Qquoteadv_Model_Status::getGridOptionArray()
        )); 
       $this->addColumn('company', array(
            'header'    => Mage::helper('qquoteadv')->__('Company'),
            'index'     => 'company',
			'width'     => '100',
        ));


		$this->addColumn('firstname', array(
            'header'    => Mage::helper('qquoteadv')->__('First Name'),
            'index'     => 'firstname'
        ));

        $this->addColumn('lastname', array(
            'header'    => Mage::helper('qquoteadv')->__('Last Name'),
            'index'     => 'lastname'
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('qquoteadv')->__('Email'),
            'width'     => '150',
            'index'     => 'email'
        ));

		 $this->addColumn('country_id', array(
            'header'    => Mage::helper('qquoteadv')->__('Country'),
            'width'     => '150',
            'type'      => 'country',
            'index'     => 'country_id',
        ));

		 $this->addColumn('city', array(
            'header'    => Mage::helper('qquoteadv')->__('City'),
            'index'     => 'city',
			'width'     => '100',
        ));

      $this->addColumn('status', array(
          'header'    => Mage::helper('qquoteadv')->__('Status'),
          'align'     => 'left',
          'width'     => '120px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => Ophirah_Qquoteadv_Model_Status::getGridOptionArray(),
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('qquoteadv')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('qquoteadv')->__('View'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('qquote_id');
        $this->getMassactionBlock()->setFormFieldName('qquote');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('qquoteadv')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('qquoteadv')->__('Are you sure?')
        ));
 

        $statuses = Mage::getSingleton('qquoteadv/status')->getChangeOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('qquoteadv')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('qquoteadv')->__('Status'),
                         //'values' => Ophirah_Qquoteadv_Model_Status::getGridOptionArray()
                         'values' => $statuses
                     )
             )
        ));
       
        
        
        $this->getMassactionBlock()->addItem('export', array(
            'label'    => Mage::helper('qquoteadv')->__('Export'),
            'url'      => $this->getUrl('*/*/export'),
        ));
        
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('adminhtml/qquoteadv/edit', array('id' => $row->getId()));
  }

}