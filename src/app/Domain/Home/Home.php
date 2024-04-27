<?php

namespace App\Domain\Home;

use App\Model\Home\Home as HomeModel;

class Home
{
    public function getHome($data)
    {
        $Model = new HomeModel();
        return $Model->getHome($data);
    }
}

