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
 * Offers file field renderer helper
 *
 * @category	D4U
 * @package		D4U_Dealoffer
 * @author Ultimate Module Creator
 */
class D4U_Dealoffer_Block_Adminhtml_Offers_Helper_File extends Varien_Data_Form_Element_Abstract{
	/**
	 * constructor
	 * @access public
	 * @param array $data
	 * @return void
	 * @author Ultimate Module Creator
	 */
	public function __construct($data){
		parent::__construct($data);
		$this->setType('file');
	}
	/**
	 * get element html
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getElementHtml(){
		$html = '';
		$this->addClass('input-file');
		$html.= parent::getElementHtml();
		if ($this->getValue()) {
			$url = $this->_getUrl();
			if( !preg_match("/^http\:\/\/|https\:\/\//", $url) ) {
				$url = Mage::helper('dealoffer/offers')->getFileBaseUrl() . $url;
			}
			$html .= '<br /><a href="'.$url.'">'.$this->_getUrl().'</a> ';
		}
		$html.= $this->_getDeleteCheckbox();
		return $html;
	}
	/**
	 * get the delete checkbox HTML
	 * @access protected
	 * @return string
	 * @author Ultimate Module Creator
	 */
	protected function _getDeleteCheckbox(){
		$html = '';
		if ($this->getValue()) {
			$label = Mage::helper('dealoffer')->__('Delete File');
			$html .= '<span class="delete-image">';
			$html .= '<input type="checkbox" name="'.parent::getName().'[delete]" value="1" class="checkbox" id="'.$this->getHtmlId().'_delete"'.($this->getDisabled() ? ' disabled="disabled"': '').'/>';
			$html .= '<label for="'.$this->getHtmlId().'_delete"'.($this->getDisabled() ? ' class="disabled"' : '').'> '.$label.'</label>';
			$html .= $this->_getHiddenInput();
			$html .= '</span>';
		}		
		return $html;
	}
	/**
	 * get the hidden input
	 * @access protected
	 * @return string
	 * @author Ultimate Module Creator
	 */
	protected function _getHiddenInput(){
		return '<input type="hidden" name="'.parent::getName().'[value]" value="'.$this->getValue().'" />';
	}
	/**
	 * get the file url
	 * @access protected
	 * @return string
	 * @author Ultimate Module Creator
	 */
	protected function _getUrl(){
		return $this->getValue();
	}
	/**
	 * get the name
	 * @access public
	 * @return string
	 * @author Ultimate Module Creator
	 */
	public function getName(){
		return $this->getData('name');
	}
}