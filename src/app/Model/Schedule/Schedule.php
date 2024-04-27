<?php

namespace App\Model\Schedule;

use PhalApi\Model\NotORMModel as NotORM;

class Schedule extends NotORM
{
    // 上传日程
    public function postSchedule($data)
    {
        $data = $this->getORM()->insert($data);
        return array('code' => 0, 'msg' => '上传成功', 'data' => $data);
    }

    // 获取日程
    public function getSchedule()
    {
        $schedule = $this->getORM()
            ->fetchAll();
        return array('code' => 0, 'msg' => '获取成功', 'data' => $schedule);
    }
}