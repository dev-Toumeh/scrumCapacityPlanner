<?php
declare(strict_types=1);


namespace Form;


use Laminas\Form\Form;

abstract class FormAbstract extends Form
{
    private array $employees;
    public Const FRONTEND = 'Frontend';
    public Const BACKEND = 'backend';
    public Const TYPE = 'type';
    public Const SPECIALTY = 'specialty';
    public Const FORM_ELEMENT_ATTR_CLASS = 'class';
    public Const FORM_ELEMENT_ATTR_TYPE = 'type';
    public Const FORM_ELEMENT_ATTR_ID = 'id';
    public Const FORM_ELEMENT_ATTR_VALUE = 'value';
    public Const FORM_ELEMENT_ATTR_FOR = 'for';

    public const FLEX_CHECK_DEFAULT = 'flexCheckDefault';
    public const FORM_CHECK_INPUT = 'form-check-input';
    public const FORM_CHECK_LABLE = 'form-check-label';

    public const BTN_BTN_PRIMARY = 'btn btn-primary';

    public Const CHECKBOX_LABLE_ATTRIBUTES = [
        self::FORM_ELEMENT_ATTR_CLASS => self::FORM_CHECK_LABLE,
        self::FORM_ELEMENT_ATTR_FOR => self::FLEX_CHECK_DEFAULT
    ];

    public Const CHECKBOX_INPUT_ATTRIBUTES = [
        self::FORM_ELEMENT_ATTR_CLASS => self::FORM_CHECK_INPUT,
        self::FORM_ELEMENT_ATTR_ID => self::FLEX_CHECK_DEFAULT
    ];


    protected const ELEMENT_CLASS = 'form-control';
    protected const LABEL_CLASS = 'form-label';

    protected const FORM_NAME = 'my-form';
    protected const FORM_METHOD = 'POST';

    protected const LABEL_JIRA_USERNAME = 'JIRA Username';
    protected const LABEL_JIRA_PASSWORD = 'JIRA Password';
    protected const LABEL_ABSENCE_HAWK_ID = 'Absence Hawk ID';
    protected const LABEL_HAWK_AUTH_KEY = 'Hawk Auth Key';
    protected const LABEL_CHECK_ME_OUT = 'Check me out';
    protected const VALUE_SUBMIT = 'Submit';

    protected const ELEMENT_NAME = 'name';
    protected const JIRA_PASSWORD = 'jiraPassword';
    protected const ELEMENT_HAWK_ID = 'hawkID';
    protected const ELEMENT_HAWK_AUTH_KEY = 'hawkAuthKey';
    protected const ELEMENT_CHECK_ME_OUT = 'checkMeOut';
    protected const ELEMENT_SUBMIT = 'submit';

}
