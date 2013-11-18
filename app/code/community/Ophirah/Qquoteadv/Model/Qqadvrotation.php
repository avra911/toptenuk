<?php

class Ophirah_Qquoteadv_Model_Qqadvrotation extends Mage_Sales_Model_Quote
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('qquoteadv/qqadvrotation');
    }

    /**
     * @param int $roleId
     * @return int
     */
    public function getNextUserId($roleId)
    {
        $connection = $this->getResource()->getReadConnection();
        $connection->beginTransaction();

        try
        {
            /** @var $collection Ophirah_Qquoteadv_Model_Mysql4_Qqadvrotation_Collection */
            $collection = $this->getCollection();
            $collection->addFilter('role_id', $roleId);
            $collection->getSelect()->limit(1);

            $rotationModel = $collection->getFirstItem();
            $rotationModel->setRoleId($roleId);

            $lastUserId = $rotationModel->getUserId();

            // Next user from last user and group
            $nextUser = $this->getNextUser($lastUserId, $roleId);
            if($nextUser->getId() !== null)
            {
                $nextUserId = $nextUser->getId();
            }
            else
            {
                // Reset rotation
                $nextUser = $this->getNextUser(0, $roleId);
                if($nextUser->getId() !== null)
                {
                    $nextUserId = $nextUser->getId();
                }
                else
                {
                    $nextUserId = 0;
                }
            }

            $rotationModel->setUserId($nextUserId);
            $rotationModel->save();
            $connection->commit();

            return $nextUserId;
        }
        catch(Exception $e)
        {
            $connection->rollBack();
            throw $e;
        }
    }

    /**
     * @param int $lastUserId
     * @param int|null $roleId
     * @return Mage_Admin_Model_User
     */
    protected function getNextUser($lastUserId, $roleId = null)
    {
        $roleId = (int) $roleId;
        $lastUserId = (int) $lastUserId;

        /** @var $userCollection Mage_Admin_Model_Mysql4_User_Collection */
        $userCollection = Mage::getModel('admin/user')->getCollection();
        $userCollection
            ->addFieldToFilter('main_table.user_id', array('gt' => $lastUserId))
            ->setOrder('main_table.user_id', Varien_Data_Collection::SORT_ORDER_ASC);

        if($roleId !== null)
        {
            $userCollection
                ->join(array('role' => 'admin/role'), 'role.user_id = main_table.user_id', array())
                ->addFieldToFilter('role.parent_id', $roleId);
        }
        $userCollection->getSelect()->limit(1);

        return $userCollection->getFirstItem();
    }
}