<?php/** * @author    Marcin Frymark * @email     contact@alekseon.com * @company   Alekseon * @website   www.alekseon.com */class Alekseon_CustomerComment_Model_Observer{    public function addCustomerCommentColumn(Varien_Event_Observer $observer)    {        $block = $observer->getBlock();                if (!$block instanceof Mage_Adminhtml_Block_Widget_Grid) {            return;        }        switch ($block->getId()) {            case 'sales_order_grid':                if (Mage::getStoreConfig('alekseon_customerComment/general/orders_grid')) {                    $this->_addCustomerCommentComment($block, 'status');                }                break;            case 'customerGrid':                if (Mage::getStoreConfig('alekseon_customerComment/general/orders_grid')) {                    $this->_addCustomerCommentComment($block, 'email');                }                break;        }    }        protected function _addCustomerCommentComment($block, $afterColumn)    {        $block->addColumnAfter('test', array(            'header'  => Mage::helper('alekseon_customerComment')->__('Customer comment'),            'width'   => '50px',            'renderer'  => 'alekseon_customerComment/adminhtml_grid_renderer_customerComment',            'frame_callback' => array($this, 'decorateCustomerComment'),            'filter' => false,            'sortable' => false,        ), $afterColumn);    }        public function decorateCustomerComment($value, $row, $column, $isExport)    {        $customerCommentTypes = Mage::helper('alekseon_customerComment')->getCustomerCommentTypes();        if (isset($customerCommentTypes[$value])) {            $class = $customerCommentTypes[$value]['grid_class'];            $value = $customerCommentTypes[$value]['label'];            if ($isExport) {                $cell = $value;            } else {                $cell = '<span class="' . $class . '"><span>' . $value . '</span></span>';            }            return $cell;        } else {            return $value;        }    }}