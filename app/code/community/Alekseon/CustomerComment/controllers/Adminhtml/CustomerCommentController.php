<?php
/**
 * @author    Marcin Frymark
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
class Alekseon_CustomerComment_Adminhtml_CustomerCommentController extends Mage_Adminhtml_Controller_Action
{
    protected function _getComment()
    {
        $customerEmail = false;
        if ($customerId = $this->getRequest()->getParam('customer_id', false)) {
            $customerEmail = Mage::getModel('customer/customer')->load($customerId)->getEmail();
        } elseif ($orderId = $this->getRequest()->getParam('order_id', false)) {
            $customerEmail = Mage::getModel('sales/order')->load($orderId)->getCustomerEmail();
        }
        if (!$customerEmail) {
            Mage::throwException($this->__('Cannot save comment for empty email address.'));
        }
        $comment = Mage::getModel('alekseon_customerComment/comment')
                    ->getCollection()
                    ->addFieldToFilter('customer_email', $customerEmail)
                    ->getFirstItem();

        if (!$comment->getId()) {
            $comment->setCustomerEmail($customerEmail);
        }

        return $comment;
    }

    protected function _getCustomerCommentHtml($comment = null)
    {
        $this->loadLayout();
        $customerCommentBlock = $this->getLayout()->getBlock('customer_comment');
        $customerCommentBlock->setComment($comment);
            
        if (!$customerCommentBlock) {
            Mage::throwException($this->__('Customer Comment block has not be founded.'));
        }
        
        return $customerCommentBlock->toHtml();
    }

    public function saveAction()
    {
        $result = array();
        try {
            $comment = $this->_getComment();

            $commentType = $this->getRequest()->getParam('type', 0);
            $commentText = $this->getRequest()->getParam('comment', '');        
            $commentText = trim($commentText);

            $comment->setType($commentType);
            $comment->setComment($commentText);
            $comment->save();
            $result['commentBlockHtml'] = $this->_getCustomerCommentHtml($comment);
        } catch(Exception $e) {
            $result['errorMsg'] = $e->getMessage();
        }
        
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
    
    public function deleteAction()
    {
        $result = array();
        try {
            $comment = $this->_getComment();
            $comment->delete();
            $result['commentBlockHtml'] = $this->_getCustomerCommentHtml();
        } catch(Exception $e) {
            $result['errorMsg'] = $e->getMessage();
        }
        
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}