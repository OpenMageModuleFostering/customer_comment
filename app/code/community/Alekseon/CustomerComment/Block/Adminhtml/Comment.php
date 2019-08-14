<?php
/**
 * @author    Marcin Frymark
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
class Alekseon_CustomerComment_Block_Adminhtml_Comment extends Mage_Adminhtml_Block_Template
{
    protected $_customerComment;
    protected $_customerCommentTypes;

    public function setComment($comment)
    {
        $this->_customerComment = $comment;
        return $this;
    }
    
    public function getCustomerEmail()
    {
        $customerEmail = false;
    
        if ($customer = Mage::registry('current_customer')) {
            $customerEmail = $customer->getEmail();
        } elseif ($order = Mage::registry('current_order')) {
            $customerEmail = $order->getCustomerEmail();
        }

        return $customerEmail;
    }
    
    public function getCustomerComment()
    {
        if (is_null($this->_customerComment)) {        
            $customerEmail = $this->getCustomerEmail();
            $this->_customerComment = Mage::getModel('alekseon_customerComment/comment')
                        ->getCollection()
                        ->addFieldToFilter('customer_email', $customerEmail)
                        ->getFirstItem();
        }
        return $this->_customerComment;
    }
    
    protected function _getUrlParams()
    {
        if ($customer = Mage::registry('current_customer')) {
            $params = array('customer_id' => $customer->getId());
        } elseif ($order = Mage::registry('current_order')) {
            $params = array('order_id' => $order->getId());
        }
        
        return $params;
    }
    
    public function getSaveUrl()
    {
        return $this->getUrl('*/customerComment/save', $this->_getUrlParams());
    }
    
    public function getDeleteUrl()
    {
        return $this->getUrl('*/customerComment/delete', $this->_getUrlParams());
    }
    
    public function getCustomerCommentTypes()
    {
        if (is_null($this->_customerCommentTypes)) {
            $this->_customerCommentTypes = Mage::helper('alekseon_customerComment')->getCustomerCommentTypes();
        }
        
        return $this->_customerCommentTypes;
    }
    
    public function getCurrentCommentType()
    {
        return $this->getCustomerComment()->getType();
    }
    
    public function getCommentTypeClass()
    {
        $types = $this->getCustomerCommentTypes();
        $type = $this->getCurrentCommentType();
        
        if (isset($types[$type])) {
            return $types[$type]['class'];
        } else {        
            return $types[Alekseon_CustomerComment_Helper_Data::COMMENT_TYPE_NEUTRAL]['class'];
        }
    }
}