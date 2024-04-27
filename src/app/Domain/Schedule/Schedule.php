<?php

namespace App\Domain\Schedule;

use App\Model\Schedule\Schedule as ScheduleModel;

class Schedule
{
    public function postSchedule($data)
    {
        $Model = new ScheduleModel();
        return $Model->postSchedule($data);
    }

    public function getSchedule()
    {
        $Model = new ScheduleModel();
        return $Model->getSchedule();
    }
}