<?php
namespace App\Api\User;

use PhalApi\Api;
use App\Domain\User\User as Domain_User;
use App\Domain\User\UUID as Domain_UUID;

/**
 * 用户接口
 */

class User extends Api
{
    
        public function getRules()
        {
            return array(
                'postRegister' => array(
                    'account' => array('name' => 'account', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '账号'),
                    'password' => array('name' => 'password', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '密码')
                ),
                'postLogin' => array(
                    'account' => array('name' => 'account', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '账号'),
                    'password' => array('name' => 'password', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '密码')
                ),
                'postUpdate' => array(
                    'user_id' => array('name' => 'user_id', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '用户id'),
                    'user_name' => array('name' => 'user_name', 'type' => 'string', 'min' => 1, 'require' => false, 'desc' => '昵称'),
                    'user_avatar' => array('name' => 'user_avatar', 'type' => 'string', 'min' => 1, 'require' => false, 'desc' => '头像'),
                    'user_phone' => array('name' => 'user_phone', 'type' => 'string', 'min' => 1, 'require' => false, 'desc' => '手机号'),
                    'user_password' => array('name' => 'user_password', 'type' => 'string', 'min' => 1, 'require' => false, 'desc' => '密码')
                )
            );
        }
    
        /**
        * 用户注册
        * @desc 用户注册
        * @return int code 操作码，0表示成功
        * @return string msg 提示信息
        */
        public function postRegister()
        {
            $account = $this->account;
            $password = $this->password;
            // 生成uuid
            $uuid = new Domain_UUID();
            $user_id = $uuid->getUUID();
            // 默认昵称
            $user_name = '用户' . $uuid;
            // 默认头像
            $user_avatar = 'https://www.freeimg.cn/i/2024/02/10/65c728fb4da49.png';
            // 默认权限
            $user_role = 1;
            // 创建时间(时间戳,单位:毫秒)
            $create_time = time() * 1000;
            $data = array(
                'user_id' => $user_id,
                'user_avatar' => $user_avatar,
                'user_name' => $user_name,
                'user_account' => $account,
                'user_password' => md5($password),
                'user_role' => $user_role,
                'create_time' => $create_time
            );

            $domain = new Domain_User();
            $data = $domain->postRegister($data);

            return $data;
        }

        /**
         * 用户登录
         * @desc 用户登录
         * @return int code 操作码，0表示成功
         * @return string msg 提示信息
         * @return array data 用户信息
         */
        public function postLogin()
        {
            $account = $this->account;
            $password = $this->password;
            $data = array(
                'user_account' => $account,
                'user_password' => $password
            );

            $domain = new Domain_User();
            $data = $domain->postLogin($data);

            return $data;
        }

        /**
         * 用户信息更新
         * @desc 用户信息更新
         * @return int code 操作码，0表示成功
         * @return string msg 提示信息
         */
        public function postUpdate()
        {
            $user_id = $this->user_id;
            $user_name = $this->user_name;
            $user_avatar = $this->user_avatar;
            $user_phone = $this->user_phone;
            $user_password = $this->user_password;
            $data = array(
                'user_id' => $user_id,
                'user_name' => $user_name,
                'user_avatar' => $user_avatar,
                'user_phone' => $user_phone
            );
            if ($user_password) {
                $data['user_password'] = md5($user_password);
            }

            $domain = new Domain_User();
            $data = $domain->postUpdate($data);

            return $data;
        }

        /**
         * 获取用户信息
         * @desc 获取用户信息
         * @return int code 操作码，0表示成功
         * @return string msg 提示信息
         * @return array data 用户信息
         */

        public function getUserInfo()
        {
            $cookie = $_COOKIE['cookie'];

            $domain = new Domain_User();
            $data = $domain->getUserInfo($cookie);

            return $data;
        }

        /**
         * 获取用户总数
         * @desc 获取用户总数
         * @return int code 操作码，0表示成功
         * @return string msg 提示信息
         * @return array data 用户总数
         */

        public function getUserCount()
        {
            $domain = new Domain_User();
            $data = $domain->getUserCount();

            return $data;
        }
}

