<?php


class Ophirah_Qquoteadv_Block_Adminhtml_Permissions_User_Edit_Tab_Main extends Mage_Adminhtml_Block_Permissions_User_Edit_Tab_Main
{
    /**
     * {@inheritDoc}
     */
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

        $model = Mage::registry('permissions_user');
        $data = $model->getData();
        unset($data['password']);
        $form->setValues($data);

        return $result;
    }
}
