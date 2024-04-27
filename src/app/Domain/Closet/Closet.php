<?php 
namespace App\Domain\Closet;

use App\Model\Closet\Closet as ClosetModel;

class Closet
{
    public function postUploadClothe($data)
    {
        $Model = new ClosetModel();
        return $Model->postUploadClothe($data);
    }

    public function getClotheList($data)
    {
        $Model = new ClosetModel();
        return $Model->getClotheList($data);
    }

    public function getClotheCount($data)
    {
        $Model = new ClosetModel();
        return $Model->getClotheCount($data);
    }

    public function getClotheCheckCount()
    {
        $Model = new ClosetModel();
        return $Model->getClotheCheckCount();
    }

    public function getClotheCountByCookie($cookie)
    {
        $Model = new ClosetModel();
        return $Model->getClotheCountByCookie($cookie);
    }

    public function postCheckClothe($data)
    {
        $Model = new ClosetModel();
        return $Model->postCheckClothe($data);
    }

    public function postSubmitCheck($data)
    {
        $Model = new ClosetModel();
        return $Model->postSubmitCheck($data);
    }
}