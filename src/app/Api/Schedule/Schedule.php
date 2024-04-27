<?php
namespace App\Api\Schedule;

use PhalApi\Api;
use App\Domain\Schedule\Schedule as Domain_Schedule;

use function PHPSTORM_META\type;

/**
 * 日程接口
 */

class Schedule extends Api
{
    
        public function getRules()
        {
            return array(
                'postSchedule' => array(
                    'year' => array('name' => 'year', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '年'),
                    'week' => array('name' => 'week', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '周'),
                    'events' => array('name' => 'events', 'type' => 'array', 'require' => true, 'desc' => '日程事件')
                )
            );
        }
    
        /**
        * 上传日程
        * @desc 上传日程
        * @return int code 操作码，0表示成功
        * @return array data 日程数据
        */
        public function postSchedule()
        {
            $year = $this->year;
            $week = $this->week;
            $events = $this->events;
            $data = array(
                'year' => $year,
                'week' => $week,
                'events' => $events
            );

            $domain = new Domain_Schedule();
            return $domain->postSchedule($data);
        }
    
        /**
        * 获取日程
        * @desc 获取日程
        * @return int code 操作码，0表示成功
        * @return array data 日程数据
        */
        public function getSchedule()
        {
            $domain = new Domain_Schedule();
            return $domain->getSchedule();
        }
}