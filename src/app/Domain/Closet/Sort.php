<?php 
namespace App\Domain\Closet;

use App\Model\Closet\Sort as SortModel;

class Sort
{
    public function getSortList()
    {
        $Model = new SortModel();
        return $Model->getSortList();
    }

    public function postAddSort($data)
    {
        $Model = new SortModel();
        return $Model->postAddSort($data);
    }
}