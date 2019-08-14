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
 * Offers admin edit tabs
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Adminhtml_Offers_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('offers_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('dealoffer')->__('Offer Information'));
	}
	/**
	 * before render html
	 * @access protected
	 * @return D4U_Dealoffer_Block_Adminhtml_Offers_Edit_Tabs
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml(){
		$this->addTab('products', array(
			'label' => Mage::helper('dealoffer')->__('Associated products'),
			'url'   => $this->getUrl('*/*/products', array('_current' => true)),
   			'class'	=> 'ajax'
		));
		$this->addTab('form_offers', array(
			'label'		=> Mage::helper('dealoffer')->__('Offer Settings'),
			'title'		=> Mage::helper('dealoffer')->__('Offer Settings'),
			'content' 	=> $this->getLayout()->createBlock('dealoffer/adminhtml_offers_edit_tab_form')->toHtml(),
		));
		$this->addTab('form_meta_offers', array(
			'label'		=> Mage::helper('dealoffer')->__('Meta Information'),
			'title'		=> Mage::helper('dealoffer')->__('Meta Information'),
			'content' 	=> $this->getLayout()->createBlock('dealoffer/adminhtml_offers_edit_tab_meta')->toHtml(),
		));
		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_offers', array(
				'label'		=> Mage::helper('dealoffer')->__('Store views'),
				'title'		=> Mage::helper('dealoffer')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('dealoffer/adminhtml_offers_edit_tab_stores')->toHtml(),
			));
		}
		
		return parent::_beforeToHtml();
	}
}