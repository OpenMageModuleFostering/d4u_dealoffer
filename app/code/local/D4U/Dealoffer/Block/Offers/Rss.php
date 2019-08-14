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
 * Offers RSS block
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Offers_Rss extends Mage_Rss_Block_Abstract{
	/**
	 * Cache tag constant for feed reviews
	 * @var string
	 */
	const CACHE_TAG = 'block_html_dealoffer_offers_rss';
	/**
	 * constructor
	 * @access protected
	 * @return void
	 * @author Ultimate Module Creator
	 */
	protected function _construct(){
		$this->setCacheTags(array(self::CACHE_TAG));
		/*
		* setting cache to save the rss for 10 minutes
		*/
		$this->setCacheKey('dealoffer_offers_rss');
		$this->setCacheLifetime(600);
	}
	/**
	 * toHtml method
	 * @access protected
	 * @return string
	 * @author Ultimate Module Creator
	 */
	protected function _toHtml(){
		$url = Mage::helper('dealoffer')->getOfferssUrl();
		$title = Mage::helper('dealoffer')->__('Offers');
		$rssObj = Mage::getModel('rss/rss');
		$data = array(
			'title' => $title,
			'description' => $title,
			'link'=> $url,
			'charset' => 'UTF-8',
		);
		$rssObj->_addHeader($data);
		$collection = Mage::getModel('dealoffer/offers')->getCollection()
			->addStoreFilter(Mage::app()->getStore())

			->addFilter('status', 1)
			->addFilter('in_rss', 1)
			->setOrder('created_at');
		$collection->load();
		foreach ($collection as $item){
			$description = '<p>';
			$description .= '</p>';
			$data = array(
				'title'=>$item->getName(),
				'link'=>$item->getOffersUrl(),
				'description' => $description
			);
			$rssObj->_addEntry($data);
		}
		return $rssObj->createRssXml();
	}
}