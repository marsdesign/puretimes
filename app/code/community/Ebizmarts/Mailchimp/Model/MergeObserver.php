<?php
/**
 * Created by PhpStorm.
 * User: Santiago
 * Date: 5/2/17
 * Time: 11:01
 */
class Ebizmarts_MailChimp_Model_MergeObserver
{
    public function updateMergeFields (Varien_Event_Observer $observer)
    {
        Mage::log(__METHOD__, null, 'mergeFields.log', true);
        $event = $observer->getEvent();
//        $emailAddress = $event->getSubscriberEmail();
        $customerId = $event->getCustomerId();
        $mergeFieldTag = $event->getMergeFieldTag();
        Mage::log($event->getMergeFieldValue(), null, 'mergeFields.log', true);
        $customer = Mage::getModel('customer/customer')->load($customerId);
        if ($customer->getId())
            $groupId = (int)$customer->getData('group_id');
        else { // Anonymous subscriber
            $groupId = (int)Mage::getSingleton('customer/session')->getData('customer_group_id_from_url_param');
        }
        $customerGroup = Mage::getModel('customer/group')->load($groupId);

        switch ($mergeFieldTag) {
            case 'group_id':
            case 'customer_group':
                $grp = Mage::helper('customer')->getGroups()->toOptionHash();
                if ($groupId == 0) {
                    $event->setMergeFieldValue('NOT LOGGED IN');
                } else {
                    $event->setMergeFieldValue($grp[$groupId]);
                }
                break;
            case 'group_name':
            case 'group_title':
            case 'group_owner':
                $event->setMergeFieldValue($customerGroup->getData($mergeFieldTag));
                break;
            case 'group_code_pdf':
            case 'group_code_url':
            case 'group_sales_first_name':
            case 'group_sales_last_name':
            case 'group_sales_role':
            case 'group_sales_email':
            case 'group_sales_phone':
                $event->setMergeFieldValue($customerGroup->getData(str_replace('group_', '', $mergeFieldTag)));
                break;
        }
        Mage::log($event->getMergeFieldValue(), null, 'mergeFields.log', true);
    }

}