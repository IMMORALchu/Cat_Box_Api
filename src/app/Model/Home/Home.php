<?php

namespace App\Model\Home;

use App\Model\User\User as UserModel;
use App\Model\Closet\Closet as ClosetModel;

class Home
{
    public function getHome($data)
    {
        $UserModel = new UserModel();
        $ClosetModel = new ClosetModel();
        $user = $UserModel->getUserCount();
        $clothes = $ClosetModel->getClotheCount($data['cookies']);
        $ClotheCheck = $ClosetModel->getClotheCheckCount();

        return array('code' => 0, 'msg' => '获取成功', 'data' => array('user' => $user['data'], 'clothes' => $clothes['data'], 'clothe_check' => $ClotheCheck['data']));
    }
}

