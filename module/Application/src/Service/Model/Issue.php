<?php

namespace Application\Service\Model;

use Application\Service\ServiceAbstract;

class Issue extends ServiceAbstract
{
    private int $storyPoints = 0;
    public static function SetIssue(array $issue): self
    {
        return (new self())->setStoryPoints($issue[self::FIELDS][self::CUSTOM_FIELD_STORY_POINT]);
    }

    /**
     * @return int
     */
    public function getStoryPoints(): ?int
    {
        return $this->storyPoints;
    }

    /**
     * @param int|null $storyPoints
     * @return Issue
     */
    public function setStoryPoints(?int $storyPoints): self
    {
        if(!empty($storyPoints)){
            $this->storyPoints = $storyPoints;
        } else {
            $this->storyPoints = 0;
        }
        return $this;
    }


}