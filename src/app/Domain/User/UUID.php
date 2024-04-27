<?php

namespace App\Domain\User;

class UUID
{
    public function getUUID()
    {
        return uniqid();
    }
}
