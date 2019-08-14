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
 * Offers tab on product edit form
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Adminhtml_Catalog_Product_Edit_Tab_Offers extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * Set grid params
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('offers_grid');
		$this->setDefaultSort('position');
		$this->setDefaultDir('ASC');
		$this->setUseAjax(true);
		if ($this->getProduct()->getId()) {
			$this->setDefaultFilter(array('in_offerss'=>1));
		}
	}
	/**
	 * prepare the offers collection
	 * @access protected 
	 * @return D4U_Dealoffer_Block_Adminhtml_Catalog_Product_Edit_Tab_Offers
	 * @author Ultimate Module Creator
	 */
	protected function _prepareCollection() {
		$collection = Mage::getResourceModel('dealoffer/offers_collection');
		if ($this->getProduct()->getId()){
			$constraint = 'related.product_id='.$this->getProduct()->getId();
			}
			else{
				$constraint = 'related.product_id=0';
			}
		$collection->getSelect()->joinLeft(
			array('related'=>$collection->getTable('dealoffer/offers_product')),
			'related.offers_id=main_table.entity_id AND '.$constraint,
			array('position')
		);
		$this->setCollection($collection);
		parent::_prepareCollection();
		return $this;
	}
	/**
	 * prepare mass action grid
	 * @access protected
	 * @return D4U_Dealoffer_Block_Adminhtml_Catalog_Product_Edit_Tab_Offers
	 * @author Ultimate Module Creator
	 */ 
	protected function _prepareMassaction(){
		return $this;
	}
	/**
	 * prepare the grid columns
	 * @access protected
	 * @return D4U_Dealoffer_Block_Adminhtml_Catalog_Product_Edit_Tab_Offers
	 * @author Ultimate Module Creator
	 */
	protected function _prepareColumns(){
		$this->addColumn('in_offerss', array(
			'header_css_class'  => 'a-center',
			'type'  => 'checkbox',
			'name'  => 'in_offerss',
			'values'=> $this->_getSelectedOfferss(),
			'align' => 'center',
			'index' => 'entity_id'
		));
		$this->addColumn('name', array(
			'header'=> Mage::helper('dealoffer')->__('Name'),
			'align' => 'left',
			'index' => 'name',
		));
		$this->addColumn('position', array(
			'header'		=> Mage::helper('dealoffer')->__('Position'),
			'name'  		=> 'position',
			'width' 		=> 60,
			'type'		=> 'number',
			'validate_class'=> 'validate-number',
			'index' 		=> 'position',
			'editable'  	=> true,
		));
	}
	/**
	 * Retrieve selected offerss
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	protected function _getSelectedOfferss(){
		$offerss = $this->getProductOfferss();
		if (!is_array($offerss)) {
			$offerss = array_keys($this->getSelectedOfferss());
		}
		return $offerss;
	}
 	/**
	 * Retrieve selected offerss
	 * @access protected
	 * @return array
	 * @author Ultimate Module Creator
	 */
	public function getSelectedOfferss() {
		$offerss = array();
		//used helper here in order not to override the product model
		$selected = Mage::helper('dealoffer/product')->getSelectedOfferss(Mage::registry('current_product'));
		if (!is_array($selected)){
			$selected = array();
		}
		foreach ($selected as $offers) {
			$offerss[$offers->getId()] = array('position' => $offers->getPosition());
		}
		return $offerss;
	}
	/**
	 * get row url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getRowUrl($item){
		return '#';
	}
	/**
	 * get grid url
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/offerssGrid', array(
			'id'=>$this->getProduct()->getId()
		));
	}
	/**
	 * get the current product
	 * @access public
	 * @return Mage_Catalog_Model_Product
	 * @author Ultimate Module Creator
	 */
	public function getProduct(){
		return Mage::registry('current_product');
	}
	/**
	 * Add filter
	 * @access protected
	 * @param object $column
	 * @return D4U_Dealoffer_Block_Adminhtml_Catalog_Product_Edit_Tab_Offers
	 * @author Ultimate Module Creator
	 */
	protected function _addColumnFilterToCollection($column){
		if ($column->getId() == 'in_offerss') {
			$offersIds = $this->_getSelectedOfferss();
			if (empty($offersIds)) {
				$offersIds = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('entity_id', array('in'=>$offersIds));
			} 
			else {
				if($offersIds) {
					$this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$offersIds));
				}
			}
		} 
		else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;
	}
}