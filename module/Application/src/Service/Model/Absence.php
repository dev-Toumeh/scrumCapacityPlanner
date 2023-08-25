<?php

namespace Application\Service\Model;



use DateTime;
use Exception;

class Absence extends ModelAbstract
{
    private int $daysCount = 0;
    private DateTime $startDate;
    private DateTime $endDate;
    public function __construct()
    {
        $this->startDate = new DateTime('-8 month');
        $this->endDate = $this->startDate->modify('+1 day');
    }


    /**
     * @throws Exception
     */
    public static function setAbsence(array $Absence): self
    {
        return (new self())->setStartDate($Absence[self::START])
                           ->setEndDate($Absence[self::END])
                            ->setDaysCount($Absence[self::DAYS_COUNT]);
    }

    /**
     * @return int
     */
    public function getDaysCount(): int
    {
        return $this->daysCount;
    }

    /**
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * @throws Exception
     */
    private function setStartDate(?string $startDate): self
    {
        if(!empty($startDate)){
            $this->startDate = new DateTime($startDate);
        }
        return $this;
    }


    /**
     * @throws Exception
     */
    private function setEndDate(?string $endDate): self
    {
        if(!empty($endDate)){
            $this->endDate = new DateTime($endDate);
        }
        return $this;
    }

    private function setDaysCount(?int $daysCount): self{

        if(!empty($daysCount)){
             $this->daysCount += $daysCount;
        }
        return $this;
    }


}