<?php

namespace App\Domain\User;

use App\Model\User\User as UserModel;

class User
{
    public function postRegister($data)
    {
        $Model = new UserModel();
        return $Model->postRegister($data);
    }

    public function postLogin($data)
    {
        $Model = new UserModel();
        return $Model->postLogin($data);
    }

    public function getUserInfo($cookie)
    {
        $Model = new UserModel();
        return $Model->getUserInfo($cookie);
    }

    public function postUpdate($data)
    {
        $Model = new UserModel();
        return $Model->postUpdate($data);
    }

    public function getUserCount()
    {
        $Model = new UserModel();
        return $Model->getUserCount();
    }
}