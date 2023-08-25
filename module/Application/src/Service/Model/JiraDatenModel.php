<?php

namespace Application\Service\Model;

use Laminas\Json\Json;

class JiraDatenModel
{
    private const TOTAL = 'total';
    private const ISSUES = 'issues';
    private const STORY_POINT_COUNTER = 'SPLast25weeks';
    private const ISSUES_WITHOUT_STORY_POINTS = 'WithoutSP';
    private const TOTAL_ISSUES = 'totalIssues';
    private const CUSTOM_FIELD_STORY_POINT = 'customfield_10002';



    private int $totalStoryPoints = 0;
    private int $totalIssues = 0;
    private int $totalIssuesWithoutStoryPoints = 0;

    public static function setJiraDaten(string $issues): JiraDatenModel
    {
        $issues = json_decode($issues, true);
        $jiraDatenModel =  (new self())->setTotalIssues($issues[self::TOTAL]);

        foreach ($issues[self::ISSUES] as $oneIssue) {
            $issue = Issue::SetIssue($oneIssue);
            if(!empty($issue->getStoryPoints()) && $issue->getStoryPoints() > 0){
                $jiraDatenModel->totalStoryPoints += $issue->getStoryPoints();
            } else {
                $jiraDatenModel->totalIssuesWithoutStoryPoints += 1;
            }
        }
        return $jiraDatenModel;
    }

    public function getTotal(): int
    {
        return $this->totalIssues;
    }

    private function setTotalIssues(int $totalIssues): self
    {
        $this->totalIssues = $totalIssues;

        return $this;
    }

    public function getTotalNoIssues(): int
    {
        return $this->totalIssuesWithoutStoryPoints;

    }

    /**
     * @return int
     */
    public function getTotalStoryPoints(): int
    {
        return $this->totalStoryPoints;
    }

}