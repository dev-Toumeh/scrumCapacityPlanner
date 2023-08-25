<?php

namespace Application\Service\Model;

use DateTime;
use Exception;

class AbsenceDatenModel extends ModelAbstract
{
private int $absenceLast25weeks = 0;
private int $absenceNext2weeks = 0;

    /**
     * @throws Exception
     */
    public static function SetAbsenceDaten(array $absences, $endOfSprint): AbsenceDatenModel
    {
        $absenceDatenModel = (new self());
        foreach ($absences as $OneAbsence) {
            $absenceDatenModel->setAbsenceDaysCounter(Absence::setAbsence($OneAbsence), $endOfSprint);
        }
        return $absenceDatenModel;
    }

    /**
     * @return int
     */
    public function getAbsenceLast25weeks(): int
    {
        return $this->absenceLast25weeks;
    }

    /**
     * @return int
     */
    public function getAbsenceNext2weeks(): int
    {
        return $this->absenceNext2weeks;
    }

    /**
     * @param int $absenceNext2weeks
     */
    private function setAbsenceNext2weeks(int $absenceNext2weeks): void
    {
        $this->absenceNext2weeks += $absenceNext2weeks;
    }

    /**
     * @param int $absenceLast25weeks
     */
    private function setAbsenceLast25weeks(int $absenceLast25weeks): void
    {
        $this->absenceLast25weeks += $absenceLast25weeks;
    }

    private function setAbsenceDaysCounter(Absence $absence, $endOfSprint): void
    {
        $startDate = $absence->getStartDate();
        $endDate = $absence->getEndDate();
        $startOfSprint = new DateTime('next Monday');

            if ($startDate >= $startOfSprint && $endDate <= $endOfSprint){
                $this->setAbsenceNext2weeks($absence->getDaysCount());
            }
            elseif($startDate >= $startOfSprint
                && $startDate <= $endOfSprint
                && $endDate >= $endOfSprint
            ){
                $dayCount = $startDate->diff($endOfSprint)->days;
                $this->setAbsenceNext2weeks($dayCount);
            }
            elseif($startDate <= $startOfSprint
                && $endDate <= $endOfSprint
                && $endDate >= $startOfSprint
            ){
                $dayCount = $startOfSprint->diff($endDate)->days;
                $this->setAbsenceNext2weeks($dayCount);
            }
            elseif($startDate <= $startOfSprint && $endDate >= $endOfSprint){
                $this->absenceNext2weeks += 10;
            }
            elseif($startDate > $endOfSprint && $endDate >= $endOfSprint){
                //do Nothing
            } else {
                $this->setAbsenceLast25weeks($absence->getDaysCount()) ;
            }
    }

}