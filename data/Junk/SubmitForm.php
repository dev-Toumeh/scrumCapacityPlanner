<?php
declare(strict_types=1);


use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;

/**
 * Class SubmitForm
 * @package Form
 * @copyright   Copyright © 2023 CHECK24 Vergleichsportal Reise GmbH München
 */
class SubmitForm extends \Laminas\Form\Form
{

    const FORM_ELEMENT_ATTR_CLASS = '';
    const BTN_BTN_PRIMARY = '' ;

    protected function createAuthIdInput()
    {
        $username = new Text('id');
        $username->setLabel('Hawk Auth ID');
        $username->setAttributes([
            'class' => 'username',
            'size'  => '30',
        ]);
    }

    protected function CreatHawkAuthKeyInput()
    {
        $submit = new Submit('Submit');
        $submit->setAttribute(self::FORM_ELEMENT_ATTR_CLASS, self::BTN_BTN_PRIMARY);
        $submit->setValue('Submit Form');

        $this->add($submit);
    }
    protected function createSubmit()
    {
        $submit = new Submit('Submit');
        $submit->setAttribute(self::FORM_ELEMENT_ATTR_CLASS, self::BTN_BTN_PRIMARY);
        $submit->setValue('Submit Form');

        $this->add($submit);
    }
}
