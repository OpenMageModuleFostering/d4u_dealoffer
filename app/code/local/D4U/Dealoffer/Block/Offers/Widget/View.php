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
 * Offers widget block
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Offers_Widget_View extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface{
	protected $_htmlTemplate = 'd4u_dealoffer/offers/widget/view.phtml';
	/**
	 * Prepare a for widget
	 * @access protected
	 * @return D4U_Dealoffer_Block_Offers_Widget_View
	 * @author Ultimate Module Creator
	 */
	protected function _beforeToHtml() {
		parent::_beforeToHtml();
		$offersId = $this->getData('offers_id');
		if ($offersId) {
			$offers = Mage::getModel('dealoffer/offers')
				->setStoreId(Mage::app()->getStore()->getId())
				->load($offersId);
		if ($offers->getStatus()) {
				$this->setCurrentOffers($offers);
				$this->setTemplate($this->_htmlTemplate);
			}
		}
		return $this;
	}
}