<?php 

namespace App\Model\Closet;

use PhalApi\Model\NotORMModel as NotORM;

class Sort extends NotORM
{
    // 获取分类列表
    public function getSortList()
    {
        $data = $this->getORM()->fetchAll();
        return array('code' => 0, 'msg' => '获取成功', 'data' => $data);
    }

    // 添加分类
    public function postAddSort($data)
    {
        $data = $this->getORM()->insert($data);
        return array('code' => 0, 'msg' => '添加成功', 'data' => $data);
    }
}