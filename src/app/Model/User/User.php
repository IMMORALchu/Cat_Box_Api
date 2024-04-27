<?php

namespace App\Model\User;

use PhalApi\Model\NotORMModel as NotORM;

class User extends NotORM
{

    // 注册用户接口
    public function postRegister($data)
    {
        $repeat = $this->getORM()
            ->where('user_account', $data['user_account'])
            ->fetchOne();

        if ($repeat) {
            return array('code' => 1, 'msg' => '账号已存在');
        } else {
            $data = $this->getORM()->insert($data);
            return array('code' => 0, 'msg' => '注册成功', 'data' => $data);
        }
    }

    // 登录接口
    public function postLogin($data)
    {
        // 通过账号密码查询用户
        $user = $this->getORM()
            ->select('user_id, user_name, user_avatar, user_phone, user_role, create_time, login_time, update_time')
            ->where('user_account', $data['user_account'])
            ->where('user_password', md5($data['user_password']))
            ->fetch();

        if ($user) {
            $time = time();
            
            // 生成cookie,时效一个月
            $cookie = md5($user['user_id'] . $time);
            setcookie('cookie', $cookie, time() + 3600 * 24 * 30, '/');

            // 更新登录时间
            $this->getORM()
                ->where('user_id', $user['user_id'])
                ->update(array('login_time' => $time));

            // cookie存储到数据库
            $this->getORM()
                ->where('user_id', $user['user_id'])
                ->update(array('cookie' => $cookie));

            return array('code' => 0, 'msg' => '登录成功', 'data' => $user);
        } else {
            return array('code' => 1, 'msg' => '账号或密码错误');
        }
    }

    // 根据cookie获取用户信息
    public function getUserInfo($cookie)
    {
        $user = $this->getORM()
            ->select('user_id', 'user_avatar', 'user_name', 'user_phone', 'user_role')
            ->where('cookie', $cookie)
            ->fetchOne();

        if ($user) {
            return array('code' => 0, 'msg' => '获取成功', 'data' => $user);
        } else {
            return array('code' => 1, 'msg' => '获取失败');
        }
    }

    // 修改用户信息
    public function postUpdate($data)
    {
        $this->getORM()
            ->where('user_id', $data['user_id'])
            ->update($data);

        return array('code' => 0, 'msg' => '修改成功');
    }

    // 获取用户数量
    public function getUserCount()
    {
        $data['count'] = $this->getORM()
            ->count('user_id');

        // 同时返回user_role为1的数量
        $data['admin_count'] = $this->getORM()
            ->where('user_role', 1)
            ->count('user_id');

        return array('code' => 0, 'msg' => '获取成功', 'data' => $data);
    }
}
