<?php
/**
 * @author    Marcin Frymark
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
class Alekseon_CustomerComment_Helper_Data extends Mage_Core_Helper_Abstract
{
    const COMMENT_TYPE_NEUTRAL = 0;
    const COMMENT_TYPE_POSITIVE = 1;
    const COMMENT_TYPE_NEGATIVE = 2;

    public function getAlekseonUrl()
    {   
        return 'http://www.alekseon.com';
    }
    
    public function getCustomerCommentTypes()
    {
        return array(
            self::COMMENT_TYPE_NEUTRAL => array(
                'label'      => $this->__('Neutral'),
                'class'      => 'notice-msg',
                'grid_class' => 'grid-severity-minor'
            ),
            self::COMMENT_TYPE_POSITIVE => array(
                'label' => $this->__('Positive'),
                'class' => 'success-msg',
                'grid_class' => 'grid-severity-notice'
            ),
            self::COMMENT_TYPE_NEGATIVE => array(
                'label' => $this->__('Negative'),
                'class' => 'error-msg',
                'grid_class' => 'grid-severity-critical'
            ),
        );
    }
}