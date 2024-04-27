<?php

namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;

class Cookie extends NotORM
{
    protected function getTableName($id)
    {
        return 'user_user';  // 手动设置表名为 my_user
    }
    // 验证cookie是否有效
    public function checkCookie($cookie)
    {
        $data = $this->getORM()
            ->where('cookie', $cookie)
            ->fetchOne();
        if ($data) {
            return array('code' => 0, 'msg' => 'cookie有效', 'data' => $data);
        } else {
            return array('code' => 100, 'msg' => 'cookie无效', 'data' => $data);
        }
    }
}
