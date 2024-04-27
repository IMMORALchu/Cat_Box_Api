<?php

namespace App\Domain;

use App\Model\Cookie as CookieModel;

class Cookie
{
    public function checkCookie($cookie)
    {
        $Model = new CookieModel();
        return $Model->checkCookie($cookie);
    }
}