<?php
declare(strict_types=1);

namespace Form;

use Application\configuration\Config;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Submit;

class SearchForm extends FormAbstract
{
    private Config $config;
    public function __construct(Config $config)
    {
        parent::__construct('search');
        $this->config = $config;
        $this->createCheckboxes();
        $this->createSubmit();
        $this->setAttribute('method', 'post');
    }

    protected function createCheckboxes()
    {
        $developers = $this->config->getDevelopersConfigArray();
        foreach ($developers as $developer){
            $this->getCheckbox($developer);
        }
    }

    protected function getCheckbox($developer)
    {
        $checkbox = new Checkbox($developer['fullName']);
        $checkbox->setLabel($developer['fullName'])->setLabelAttributes(self::CHECKBOX_LABLE_ATTRIBUTES);
        $checkbox->setAttributes(self::CHECKBOX_INPUT_ATTRIBUTES);
        $checkbox->setAttribute(self::SPECIALTY, $developer[self::SPECIALTY]);
        $checkbox->setUseHiddenElement(false);
        $checkbox->setChecked(true);

        $this->add($checkbox);
    }

    protected function createSubmit()
    {
        $submit = new Submit('Submit');
        $submit->setAttribute(self::FORM_ELEMENT_ATTR_CLASS, self::BTN_BTN_PRIMARY);
        $submit->setValue('Submit Form');

        $this->add($submit);
    }
}