<?php
class Ophirah_Qquoteadv_Block_Adminhtml_System_Account_Edit_Form extends Mage_Adminhtml_Block_System_Account_Edit_Form
{
    protected function _prepareForm()
    {
        $result = parent::_prepareForm();
        $form = $this->getForm();

        /** @var $fieldset Varien_Data_Form_Element_Fieldset */
        $fieldset = $form->getElement('base_fieldset');
        $fieldset->addField(
            'telephone',
            'text',
            array(
                'name'  => 'telephone',
                'label' => Mage::helper('adminhtml')->__('Telephone'),
                'title' => Mage::helper('adminhtml')->__('User Telephone'),
                'required' => false,
            ),
            'email'
        );

        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        $user = Mage::getModel('admin/user')
            ->load($userId);
        $user->unsetData('password');
        $form->setValues($user->getData());

        return $result;
    }
}
