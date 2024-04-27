<?php

namespace App\Api\Home;

use PhalApi\Api;
use App\Model\Home\Home as HomeModel;

/** 
* 获取主页数据
*/

class Home extends Api
{

    /**
     * 获取主页数据
     * @desc 获取主页数据
     * @return int code 操作码，0表示成功
     * @return string msg 提示信息
     * @return array data 数据
     * 
     */

    public function getHome()
    {
        $rs = array('code' => 0, 'msg' => '', 'data' => array());
        $data['cookie'] = $_COOKIE['cookie'];
        $HomeModel = new HomeModel();
        $data = $HomeModel->getHome($data);
        $rs['data'] = $data;

        return $rs;
    }
}