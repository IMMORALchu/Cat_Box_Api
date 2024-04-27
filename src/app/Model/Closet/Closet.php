<?php

namespace App\Model\Closet;

use PhalApi\Model\NotORMModel as NotORM;
use App\Model\User\User as UserModel;

class Closet extends NotORM
{
    // 上传新衣接口
    public function postUploadClothe($data)
    {
        $user = new UserModel();
        // 根据cookie获取用户信息
        $userInfo = $user->getUserInfo($data['cookie']);
        $data['create_user'] = $userInfo['data']['user_id'];
        // 删除cookie
        unset($data['cookie']);
        $data = $this->getORM()->insert($data);
        return array('code' => 0, 'msg' => '上传成功', 'data' => $data);
    }


    // 获取衣橱列表接口
    public function getClotheList($data)
    {
        $page = $data['page'];
        $size = $data['size'];
        $type = $data['type'];
        $cookie = $data['cookie'];
        $start = ($page - 1) * $size;
        if ($cookie) {
            $user = new UserModel();
            // 根据cookie获取用户信息
            $userInfo = $user->getUserInfo($cookie);
            $data['create_user'] = $userInfo['data']['user_id'];
            $data = $this->getORM()
                ->where('create_user', $data['create_user'])
                ->limit($start, $size)
                ->fetchAll();
        } else {
            $data = $this->getORM()
                ->where('status', $type)
                ->limit($start, $size)
                ->fetchAll();
        }

        // 格式化所有时间
        foreach ($data as $key => $value) {
            $data[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time'] / 1000);
            // 拆分年月日
            $data[$key]['year'] = date('Y', $value['create_time'] / 1000);
            $data[$key]['month'] = date('m', $value['create_time'] / 1000);
            $data[$key]['day'] = date('d', $value['create_time'] / 1000);
        }
        return array('code' => 0, 'msg' => '获取成功', 'data' => $data);
    }

    // 获取衣橱总数接口
    public function getClotheCount($data)
    {
        $cookie = $data['cookie'];
        if ($cookie) {
            $user = new UserModel();
            // 根据cookie获取用户信息
            $userInfo = $user->getUserInfo($cookie);
            $data['create_user'] = $userInfo['data']['user_id'];
            $data = $this->getORM()
                ->where('create_user', $data['create_user'])
                ->count('id');
        } else {
            $data = $this->getORM()
                ->count('id');
        }
        return array('code' => 0, 'msg' => '获取成功', 'data' => $data);
    }

    // 获取衣橱审核数量接口
    public function getClotheCheckCount()
    {
        $data = $this->getORM()
            ->where('status', 0)
            ->count('id');
        return array('code' => 0, 'msg' => '获取成功', 'data' => $data);
    }

    // 根据cookie获取用户上传的衣橱总数及审核数量接口
    public function getClotheCountByCookie($data)
    {
        $user = new UserModel();
        // 根据cookie获取用户信息
        $userInfo = $user->getUserInfo($data['cookie']);
        $data['create_user'] = $userInfo['data']['user_id'];
        $data['clothe_count'] = $this->getORM()
            ->where('create_user', $data['create_user'])
            ->count('id');
        $data['check_count'] = $this->getORM()
            ->where('create_user', $data['create_user'])
            ->where('status', 0)
            ->count('id');
        $data['notpass_count'] = $this->getORM()
            ->where('create_user', $data['create_user'])
            ->where('status', 3)
            ->count('id');
        // 不返回cookie和create_user
        unset($data['cookie']);
        unset($data['create_user']);
        return array('code' => 0, 'msg' => '获取成功', 'data' => $data);
    }

    // 审核衣橱接口
    public function postCheckClothe($data)
    {
        $array = array('code' => 1, 'msg' => '');
        if ($data['type'] == 1) {
            $data = $this->getORM()
                ->where('closet_id', $data['id'])
                ->update(array('status' => 1));
            $array['msg'] = '审核成功';
        } else {
            $data = $this->getORM()
                ->where('closet_id', $data['id'])
                ->update(array('status' => 3));
            $array['msg'] = '驳回成功';
        }
        return $array;
    }

    // 提交审核接口
    public function postSubmitCheck($data)
    {
        $data = $this->getORM()
            ->where('closet_id', $data['id'])
            ->where('status', 3)
            ->update(array('status' => 0));
        return array('code' => 0, 'msg' => '提交成功', 'data' => $data);
    }
}
