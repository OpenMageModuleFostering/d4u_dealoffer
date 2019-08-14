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
 * Dealoffer RSS block
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Rss extends Mage_Core_Block_Template{
	protected $_feeds = array();
	/**
	 * add a new feed
	 * @access public
	 * @param string $label
	 * @param string $url
	 * @param bool $prepare
	 * @return D4U_Dealoffer_Block_Rss
	 * @author Ultimate Module Creator
	 */
	public function addFeed($label, $url, $prepare = false){
		$link = ($prepare ? $this->getUrl($url) : $url);
		$feed = new Varien_Object();
		$feed->setLabel($label);
		$feed->setUrl($link);
		$this->_feeds[$link] = $feed;
		return $this;
	}
	/**
	 * get the current feeds
	 * @access public
	 * @return array()
	 * @author Ultimate Module Creator
	 */
	public function getFeeds(){
		return $this->_feeds;
	}
} 