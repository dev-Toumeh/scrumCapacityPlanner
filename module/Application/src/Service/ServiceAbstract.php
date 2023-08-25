<?php

namespace Application\Service;

use Laminas\Http\Client;

abstract class  ServiceAbstract extends Client
{
    protected const STATIC_URL = 'https://jira.xb.de';
    protected const USER_INFO_URL = '';
    protected const MAX_RESULT = '"&maxResults=100';
    protected const FIELDS = 'fields';
    protected const ISSUES = 'issues';
    protected const CUSTOM_FIELD_STORY_POINT = 'customfield_10002';
    protected const TOTAL = 'total';
    protected const TICKET_COUNTER = 'ticketCounter';
    protected const STORY_POINT_COUNTER = 'SPLast25weeks';
    protected const TICKETS_WITHOUT_STORY_POINTS = 'WithoutSP';
    protected const JIRA_USERNAME = 'jiraUsername';
    protected const JIRA_PASSWORD = 'jiraPassword';


    protected const ABSENCE_URL = '' ;
    protected const ABSENCE_PRIVILEGE_URL = '';
    protected const CONTENT_TYPE = "Content-Type";
    protected const APPLICATION_JSON = "application/json";
    protected const ABSENCE_ID = 'absenceID';
    protected const DATA = 'data';
    protected const DAYS_COUNT = 'daysCount';
    protected const ADMIN_ID = '000000000000000000001000';
    protected const ROLE_ID = 'roleId';
    protected const LAST_WORKDAY_AFTER_2_WEEKS = 'getLastWorkdayAfter2Weeks';
    protected const FIRST_WORKDAY_BEFORE_25_WEEKS = 'getFirstWorkdayBefore25Weeks';
    protected const SKIP = 'skip';
    protected const LIMIT = 'limit';
    protected const FILTER = 'filter';
    protected const START = 'start';
    protected const END = 'end';
    protected const ASSIGNED_TO_ID = 'assignedToId';
    protected const REASON_ID = 'reasonId';
    protected const RELATIONS = 'relations';
    protected const APPROVED_ID = 'approverId';
    protected const LTE = 'lte';
    protected const GTE = 'gte';
    protected const NE = 'ne';
    protected const REASON_ID_VALUE = "60daf6bab5dc1f0a17142ab4";
    protected const ABSENCE_LAST_25_WEEKS = 'AbsenceLast25weeks';
    protected const ABSENCE_NEXT_2_WEEKS = 'AbsenceNext2weeks';

    protected const MONDAY_THIS_WEEK = 'monday this week';
    protected const LAST_SUNDAY = 'last sunday';
    protected const MINUS_25_WEEKS = '-25 weeks';
    protected const FIRST_MONDAY = 'first monday';
    protected const FRIDAY_THIS_WEEK = 'friday this week';
    protected const NEXT_MONDAY = 'next monday';
    protected const PLUS_2_WEEKS = '+2 weeks';
    protected const LAST_FRIDAY = 'last friday';

}