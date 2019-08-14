<?php
/**
 * @author    Marcin Frymark
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
class Alekseon_CustomerComment_Block_Adminhtml_Grid_Renderer_CustomerComment extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected $_commentsArray;

    public function render(Varien_Object $row)
    {
        if (is_null($this->_commentsArray)) {
            $gridCollection = $this->getColumn()->getGrid()->getCollection();
            $this->_commentsArray = array();
            
            switch ($this->getColumn()->getGrid()->getId()) {
                case 'sales_order_grid':
                    $collection = Mage::getModel('sales/order')->getCollection();
                    $emailField = 'customer_email';
                    break;
                case 'customerGrid':
                    $collection = Mage::getModel('customer/customer')->getCollection();
                    $emailField = 'email';
                    break;
            }
            
            $collection->addFieldToFilter('entity_id', $gridCollection->getAllIds());
            $emails = array();
            
            foreach($collection as $item) {
                $emails[$item->getId()] = $item->getData($emailField);
            }
            
            $comments = Mage::getModel('alekseon_customerComment/comment')
                        ->getCollection()
                        ->addFieldToFilter('customer_email', $emails);

            $commentsArray = array();
            foreach($comments as $comment) {
                $commentsArray[$comment->getCustomerEmail()] = $comment;
            }
                        
            foreach ($collection as $item) {
                if (isset($commentsArray[$emails[$item->getId()]])) {
                    $comment = $commentsArray[$emails[$item->getId()]];
                    $this->_commentsArray[$item->getId()] = $comment->getType();
                }
            }
        }
        
        if (isset($this->_commentsArray[$row->getId()])) {
            return $this->_commentsArray[$row->getId()];
        }
    }
}