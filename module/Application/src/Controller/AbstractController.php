<?php

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;

Abstract class AbstractController extends AbstractActionController
{
    protected const NAME_KEY = 'name';
    protected const JIRA_PASSWORD_KEY = 'jiraPassword';
    protected const HAWK_ID_KEY = 'hawkID';
    protected const HAWK_AUTH_KEY = 'hawkAuthKey';
    protected const SUBMIT_KEY = 'submit';
    protected const LOGIN_FORM_KEY = 'loginForm';
    protected const ERROR_MESSAGE_KEY = 'errorMessage';
    protected const INVALID_CREDENTIALS_ERROR_MESSAGE = 'Invalid credentials or insufficient privileges.';

    protected const TEMPLATE_CHECK24_INFO = 'check24/info';
    protected const TEMPLATE_CHECK24_SEARCH = 'check24/search';
    protected const TEAM_CAPACITY = 'teamCapacity';
    protected const INFO_FORM = 'infoForm';
    protected const SEARCH_FORM = 'searchForm';
    protected const SUBMIT = 'Submit';
    protected const FULL_NAME = 'fullName';
    protected const SPECIALTY = 'specialty';
    protected const WITHOUT_SP = 'WithoutSP';
    protected const WOCHEN = 'Wochen';
    protected const ABSENCE_DAYS = 'AbsenceDays';
    protected const SP_LAST_25_WEEKS = 'SPLast25weeks';
    protected const FACTOR = 'Factor';
    protected const PFAK = 'PFAK';
    protected const DSPR = 'D/SPR';
    protected const SP = 'SP';
    protected const ABSENCE_LAST_25_WEEKS = 'AbsenceLast25weeks';
    protected const ABSENCE_NEXT_2_WEEKS = 'AbsenceNext2weeks';


}