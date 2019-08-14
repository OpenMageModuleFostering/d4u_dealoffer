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
 * Offers list block
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Offers_List extends Mage_Core_Block_Template{
	/**
	 * initialize
	 * @access public
	 * @return void
	 * @author Ultimate Module Creator
	 */
 	public function __construct(){
		parent::__construct();
		$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATE_INTERNAL_FORMAT);
 		$offerss = Mage::getResourceModel('dealoffer/offers_collection')
 						->addStoreFilter(Mage::app()->getStore())
						->addFilter('status', 1)
						->customaddFilter('end_date', $todayDate ,">=")
		;
	
		//$offerss->setOrder('name', 'asc');
		$offerss->GroupbyAdd('category_id');
		$this->setOfferss($offerss);
	}
	/**
	 * prepare the layout
	 * @access protected
	 * @return D4U_Dealoffer_Block_Offers_List
	 * @author Ultimate Module Creator
	 */
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'dealoffer.offers.html.pager')
			->setCollection($this->getOfferss());
		$this->setChild('pager', $pager);
		$this->getOfferss()->load();
		return $this;
	}
	/**
	 * get the pager html
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
}