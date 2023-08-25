<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\configuration\AppSessionManager;
use Application\Service\AbsenceService;
use Application\Service\JiraService;
use Exception;
use Form\Filters\IndexInputFilter;
use Form\LoginForm;
use Laminas\Form\Form;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractController
{
    private AbsenceService $absence;
    private JiraService $jira;
    private AppSessionManager $sessionManager;

    public function __construct(AbsenceService $absence, JiraService $jira, AppSessionManager $sessionManager)
    {
        $this->absence = $absence;
        $this->jira = $jira;
        $this->sessionManager = $sessionManager;
    }

    /**
     * Handles the login action.
     *
     * @throws Exception
     */
    public function indexAction()
    {
        $request = $this->getRequest();

        try {
            if ($request->isPost()) {
                $loginFormData = $request->getPost()->toArray();
                unset($loginFormData[self::SUBMIT_KEY]);

                $form = new Form();
                $indexInputFilter = new IndexInputFilter();
                $form->setInputFilter($indexInputFilter->getInputFilter());
                $form->setData($loginFormData);
                if ($form->isValid()){
                    $data = $form->getData();
                    if($this->checkIfUserHasPrivileges($data)){

                        $this->sessionManager->setCredentials(
                            $data[self::NAME_KEY],
                            $data[self::JIRA_PASSWORD_KEY],
                            $data[self::HAWK_ID_KEY],
                            $data[self::HAWK_AUTH_KEY]
                        );
                        return $this->redirect()->toRoute('search');
                    }

                } else {
                    throw new Exception(self::INVALID_CREDENTIALS_ERROR_MESSAGE);
                }
            } else {
                $LoginForm = new LoginForm();
                return new ViewModel([self::LOGIN_FORM_KEY => $LoginForm]);
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $LoginForm = new LoginForm();
            return new ViewModel([
                self::LOGIN_FORM_KEY => $LoginForm,
                self::ERROR_MESSAGE_KEY => $errorMessage
            ]);
        }
    }

    /**
     * Checks if a user has the required privileges.
     *
     * @param array $data User data.
     * @return bool
     */
    private function checkIfUserHasPrivileges(array $data): bool
    {
        $privileges = false;
        if (
            $this->absence->hasAbsencePrivileges($data) &&
            $this->jira->hasJiraAccess($data[self::NAME_KEY], $data[self::JIRA_PASSWORD_KEY])
        ) {
            $privileges = true;
        }
        return $privileges;
    }
}