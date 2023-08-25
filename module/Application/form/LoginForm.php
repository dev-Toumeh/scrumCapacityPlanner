<?php
declare(strict_types=1);

namespace Form;

use Laminas\Form\Element\Password;
use Laminas\Form\Element\Text;

use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Submit;

class LoginForm extends FormAbstract
{
    public function __construct()
    {
        parent::__construct(self::FORM_NAME);
        $this->setAttribute('method', self::FORM_METHOD);

        $this->addName();
        $this->addPassword();
        $this->addHawkId();
        $this->addHawkAuthKey();
        $this->addCheckbox();
        $this->addSubmit();
    }

    private function addName(): void
    {
        $name = new Text(self::ELEMENT_NAME);
        $name->setLabel(self::LABEL_JIRA_USERNAME)
            ->setLabelAttributes(['class' => self::LABEL_CLASS])
            ->setAttributes(['class' => self::ELEMENT_CLASS, 'placeholder' => 'max.musterman']);
        $this->add($name);
    }

    private function addPassword(): void
    {
        $password = new Password(self::JIRA_PASSWORD);
        $password->setLabel(self::LABEL_JIRA_PASSWORD)
            ->setLabelAttributes(['class' => self::LABEL_CLASS])
            ->setAttributes(['class' => self::ELEMENT_CLASS]);
        $this->add($password);
    }

    private function addHawkId(): void
    {
        $hawkId = new Text(self::ELEMENT_HAWK_ID);
        $hawkId->setLabel(self::LABEL_ABSENCE_HAWK_ID)
            ->setLabelAttributes(['class' => self::LABEL_CLASS])
            ->setAttributes(['class' => self::ELEMENT_CLASS, 'placeholder' => '5ebb30c62933ac32298kcfd4']);
        $this->add($hawkId);
    }

    private function addHawkAuthKey(): void
    {
        $hawkAuthKey = new Password(self::ELEMENT_HAWK_AUTH_KEY);
        $hawkAuthKey->setLabel(self::LABEL_HAWK_AUTH_KEY)
            ->setLabelAttributes(['class' => self::LABEL_CLASS])
            ->setAttributes(['class' => self::ELEMENT_CLASS]);
        $this->add($hawkAuthKey);
    }

    private function addCheckbox(): void
    {
        $checkbox = new Checkbox(self::ELEMENT_CHECK_ME_OUT);
        $checkbox->setLabel(self::LABEL_CHECK_ME_OUT)
            ->setLabelAttributes(['class' => 'form-check-label'])
            ->setAttributes(['class' => 'form-check-input']);
        $this->add($checkbox);
    }

    private function addSubmit(): void
    {
        $submit = new Submit(self::ELEMENT_SUBMIT);
        $submit->setAttributes(['class' => 'btn btn-primary'])
            ->setValue(self::VALUE_SUBMIT);
        $this->add($submit);
    }

}
