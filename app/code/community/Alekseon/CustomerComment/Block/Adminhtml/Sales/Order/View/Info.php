<?php
/**
 * @author    Marcin Frymark
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
class Alekseon_CustomerComment_Block_Adminhtml_Sales_Order_View_Info extends Mage_Adminhtml_Block_Sales_Order_View_Info
{
    public function getCustomerAccountData()
    {
        $accountData = parent::getCustomerAccountData();
        $customerCommentBlock = $this->getLayout()->getBlock('customer_comment_container');        
        
        if ($customerCommentBlock) {            
            $accountData[] = array(
                    'label' => $this->__('Customer Comment'),
                    'value' => $customerCommentBlock->toHtml(),
                );
        }
        return $accountData;
    }
}
