<?php
/**
 * D4U_Dealoffer extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	D4U
 * @package		D4U_Dealoffer
 * @copyright  	Copyright (c) 2013
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Offers admin grid block
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Adminhtml_Offers_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('offersGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	/**
	 * prepare collection
	 * @access protected
	 * @return D4U_Dealoffer_Block_Adminhtml_Offers_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection(){
		$collection = Mage::getModel('dealoffer/offers')->getCollection();
		
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	/**
	 * prepare grid collection
	 * @access protected
	 * @return D4U_Dealoffer_Block_Adminhtml_Offers_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
	$collection = Mage::getModel('catalog/category')->getCollection()->addAttributeToFilter('level',2)->addAttributeToSelect('name');
	$options = array();
	foreach ($collection as $item){
		if($item->getId() != ''){
			$options[$item->getId()] = $item->getName();
		}
	}

		$this->addColumn('entity_id', array(
			'header'	=> Mage::helper('dealoffer')->__('Id'),
			'index'		=> 'entity_id',
			'type'		=> 'number'
		));
		$this->addColumn('name', array(
			'header'=> Mage::helper('dealoffer')->__('Name'),
			'index' => 'name',
			'type'	 	=> 'text',

		));
		$this->addColumn('category_id', array(
			'header'=> Mage::helper('dealoffer')->__('Category'),
			'index' => 'category_id',
			'type' => 'options',
            'options'  =>$options
			
		));
		$this->addColumn('start_date', array(
			'header'=> Mage::helper('dealoffer')->__('Start Date'),
			'index' => 'start_date',
			'type'	 	=> 'date',

		));
		$this->addColumn('end_date', array(
			'header'=> Mage::helper('dealoffer')->__('End Date'),
			'index' => 'end_date',
			'type'	 	=> 'date',

		));
		$this->addColumn('offer_image', array(
			'header'	=> Mage::helper('dealoffer')->__('Today Offer'),
			'index'		=> 'offer_image',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('dealoffer')->__('Yes'),
				'0' => Mage::helper('dealoffer')->__('No'),
			)
		));
		$this->addColumn('status', array(
			'header'	=> Mage::helper('dealoffer')->__('Status'),
			'index'		=> 'status',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('dealoffer')->__('Enabled'),
				'0' => Mage::helper('dealoffer')->__('Disabled'),
			)
		));
		if (!Mage::app()->isSingleStoreMode()) {
			$this->addColumn('store_id', array(
				'header'=> Mage::helper('dealoffer')->__('Store Views'),
				'index' => 'store_id',
				'type'  => 'store',
				'store_all' => true,
				'store_view'=> true,
				'sortable'  => false,
				'filter_condition_callback'=> array($this, '_filterStoreCondition'),
			));
		}
		
		
		/*$this->addColumn('created_at', array(
			'header'	=> Mage::helper('dealoffer')->__('Created at'),
			'index' 	=> 'created_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));
		$this->addColumn('updated_at', array(
			'header'	=> Mage::helper('dealoffer')->__('Updated at'),
			'index' 	=> 'updated_at',
			'width' 	=> '120px',
			'type'  	=> 'datetime',
		));*/
		$this->addColumn('action',
			array(
				'header'=>  Mage::helper('dealoffer')->__('Action'),
				'width' => '100',
				'type'  => 'action',
				'getter'=> 'getId',
				'actions'   => array(
					array(
						'caption'   => Mage::helper('dealoffer')->__('Edit'),
						'url'   => array('base'=> '*/*/edit'),
						'field' => 'id'
					)
				),
				'filter'=> false,
				'is_system'	=> true,
				'sortable'  => false,
		));
		$this->addExportType('*/*/exportCsv', Mage::helper('dealoffer')->__('CSV'));
		$this->addExportType('*/*/exportExcel', Mage::helper('dealoffer')->__('Excel'));
		$this->addExportType('*/*/exportXml', Mage::helper('dealoffer')->__('XML'));
		return parent::_prepareColumns();
	}
	/**
	 * prepare mass action
	 * @access protected
	 * @return D4U_Dealoffer_Block_Adminhtml_Offers_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _prepareMassaction(){
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('offers');
		$this->getMassactionBlock()->addItem('delete', array(
			'label'=> Mage::helper('dealoffer')->__('Delete'),
			'url'  => $this->getUrl('*/*/massDelete'),
			'confirm'  => Mage::helper('dealoffer')->__('Are you sure?')
		));
		$this->getMassactionBlock()->addItem('TodayDeal', array(
			'label'=> Mage::helper('dealoffer')->__('Set TodayDeal'),
			'url'  => $this->getUrl('*/*/massTodayDeal'),
		));
		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('dealoffer')->__('Change status'),
			'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			'additional' => array(
				'status' => array(
						'name' => 'status',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('dealoffer')->__('Status'),
						'values' => array(
								'1' => Mage::helper('dealoffer')->__('Enabled'),
								'0' => Mage::helper('dealoffer')->__('Disabled'),
						)
				)
			)
		));
		return $this;
	}
	/**
	 * get the row url
	 * @access public
	 * @param D4U_Dealoffer_Model_Offers
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRowUrl($row){
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
	/**
	 * get the grid url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}
	/**
	 * after collection load
	 * @access protected
	 * @return D4U_Dealoffer_Block_Adminhtml_Offers_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
	/**
	 * filter store column
	 * @access protected
	 * @param D4U_Dealoffer_Model_Resource_Offers_Collection $collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * @return D4U_Dealoffer_Block_Adminhtml_Offers_Grid
	 * @author Ultimate Module Creator
	 */
	protected function _filterStoreCondition($collection, $column){
		if (!$value = $column->getFilter()->getValue()) {
        	return;
		}
		$collection->addStoreFilter($value);
		return $this;
    }
	

}