<?php

namespace App\Api\Closet;

use PhalApi\Api;
use App\Domain\Closet\Closet as ClosetModel;
use App\Domain\User\UUID as UUIDModel;
use App\Domain\Cookie as Domain_Cookie;

/**
 * 衣橱接口
 */

class Closet extends Api
{
    public function getRules()
    {
        return array(
            'postUploadClothe' => array(
                'title' => array('name' => 'title', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '标题'),
                'sort' => array('name' => 'sort', 'type' => 'array', 'min' => 1, 'require' => true, 'desc' => '分类'),
                'image_list' => array('name' => 'image_list', 'type' => 'array', 'min' => 1, 'require' => true, 'desc' => '图片列表'),
            ),
            'getClotheList' => array(
                'type' => array('name' => 'type', 'type' => 'int', 'min' => 0, 'require' => true, 'desc' => '审核类型'),
                'id' => array('name' => 'id', 'type' => 'int', 'min' => 0, 'require' => false, 'desc' => '0表示获取全部，大于0表示获取某个用户的衣橱'), // 0表示获取全部，大于0表示获取某个用户的衣橱
                'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '页码'),
                'size' => array('name' => 'size', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '每页数量'),
            ),
            'getClotheCount'=> array(
                'id' => array('name' => 'id', 'type' => 'int', 'min' => 0, 'require' => false, 'desc' => '0表示获取全部，大于0表示获取某个用户的衣橱'), // 0表示获取全部，大于0表示获取某个用户的衣橱
            ),
            'postCheckClothe' => array(
                'type' => array('name' => 'type', 'type' => 'int', 'min' => 0, 'require' => true, 'desc' => '审核or驳回'),
                'id' => array('name' => 'id', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '衣橱id'),
            ),
            'postSubmitCheck' => array(
                'id' => array('name' => 'id', 'type' => 'string', 'min' => 1, 'require' => true, 'desc' => '衣橱id'),
            ),
        );
    }

    /**
     * 上传新衣
     * @desc 上传新衣
     * @return int code 操作码，0表示成功
     * @return string msg 提示信息
     * @return array data 数据
     * 
     */

    public function postUploadClothe()
    {
        // 验证cookie
        // 获取cookie
        $cookie = $_COOKIE['cookie'];
        $domain_cookie = new Domain_Cookie();
        $check_cookie = $domain_cookie->checkCookie($cookie);
        if ($check_cookie['code'] != 0) {
            return $check_cookie;
        }
        // 生成UUID
        $uuid = new UUIDModel();
        $closet_id = $uuid->getUUID();
        // 获取cookie
        $cookie = $_COOKIE['cookie'];
        // 生成创建时间(时间戳精确到毫秒)
        $create_time = round(microtime(true) * 1000);
        $title = $this->title;
        $sort = $this->sort;
        $image_list = $this->image_list;
        $data = array(
            'title' => $title,
            'sort' => $sort,
            'image_list' => $image_list,
            'closet_id' => $closet_id,
            'create_time' => $create_time,
            'cookie' => $cookie
        );

        $domain = new ClosetModel();
        return $domain->postUploadClothe($data);
    }

    /**
     * 获取衣橱列表
     * @desc 获取衣橱列表
     * @return int code 操作码，0表示成功
     * @return string msg 提示信息
     * @return array data 数据
     * 
     */

    public function getClotheList()
    {
        // 验证cookie
        // 获取cookie
        $cookie = $_COOKIE['cookie'];
        $domain_cookie = new Domain_Cookie();
        $check_cookie = $domain_cookie->checkCookie($cookie);
        if ($check_cookie['code'] != 0) {
            return $check_cookie;
        }
        $type = $this->type;
        $page = $this->page;
        $size = $this->size;
        $id = $this->id;
        if ($id != 0) {
            $data = array(
                'type' => $type,
                'page' => $page,
                'size' => $size,
                'cookie' => $cookie,
            );
        } else {
            $data = array(
                'type' => $type,
                'page' => $page,
                'size' => $size
            );
        }

        $domain = new ClosetModel();
        return $domain->getClotheList($data);
    }

    /**
     * 获取衣橱总数
     * @desc 获取衣橱总数
     * @return int code 操作码，0表示成功
     * @return string msg 提示信息
     * @return array data 数据
     * 
     */

    public function getClotheCount()
    {
        // 验证cookie
        // 获取cookie
        $cookie = $_COOKIE['cookie'];
        $domain_cookie = new Domain_Cookie();
        $check_cookie = $domain_cookie->checkCookie($cookie);
        if ($check_cookie['code'] != 0) {
            return $check_cookie;
        }
        $id = $this->id;
        if ($id) {
            $data = array(
                'id' => $id,
                'cookie' => $cookie,
            );
        } else {
            $data = array();
        }

        $domain = new ClosetModel();
        return $domain->getClotheCount($data);
    }

    /**
     * 获取衣橱审核数量
     * @desc 获取衣橱审核数量
     * @return int code 操作码，0表示成功
     * @return string msg 提示信息
     * @return array data 数据
     * 
     */

    public function getClotheCheckCount()
    {
        // 验证cookie
        // 获取cookie
        $cookie = $_COOKIE['cookie'];
        $domain_cookie = new Domain_Cookie();
        $check_cookie = $domain_cookie->checkCookie($cookie);
        if ($check_cookie['code'] != 0) {
            return $check_cookie;
        }
        $domain = new ClosetModel();
        return $domain->getClotheCheckCount();
    }

    /**
     * 根据cookie获取用户上传的衣橱总数及审核数量
     * @desc 根据cookie获取用户上传的衣橱总数及审核数量
     * @return int code 操作码，0表示成功
     * @return string msg 提示信息
     * @return array data 数据
     * 
     */

    public function getClotheCountByCookie()
    {
        // 验证cookie
        // 获取cookie
        $cookie = $_COOKIE['cookie'];
        $domain_cookie = new Domain_Cookie();
        $check_cookie = $domain_cookie->checkCookie($cookie);
        if ($check_cookie['code'] != 0) {
            return $check_cookie;
        }
        $data = array(
            'cookie' => $cookie
        );

        $domain = new ClosetModel();
        return $domain->getClotheCountByCookie($data);
    }

    /**
     * 审核衣橱
     * @desc 审核衣橱
     * @return int code 操作码，0表示成功
     * @return string msg 提示信息
     * @return array data 数据
     * 
     */
    public function postCheckClothe()
    {
        // 验证cookie
        // 获取cookie
        $cookie = $_COOKIE['cookie'];
        $domain_cookie = new Domain_Cookie();
        $check_cookie = $domain_cookie->checkCookie($cookie);
        if ($check_cookie['code'] != 0) {
            return $check_cookie;
        }
        // 判断权限
        if ($check_cookie['data']['user_role'] == 0) {
            return array('code' => 1, 'msg' => '权限不足');
        }
        $id = $this->id;
        $type = $this->type;
        $data = array(
            'id' => $id,
            'type' => $type
        );

        $domain = new ClosetModel();
        return $domain->postCheckClothe($data);
    }

    /**
     * 提交审核
     * @desc 提交审核
     * @return int code 操作码，0表示成功
     * @return string msg 提示信息
     * @return array data 数据
     * 
     */

    public function postSubmitCheck()
    {
        // 验证cookie
        // 获取cookie
        $cookie = $_COOKIE['cookie'];
        $domain_cookie = new Domain_Cookie();
        $check_cookie = $domain_cookie->checkCookie($cookie);
        if ($check_cookie['code'] != 0) {
            return $check_cookie;
        }
        $id = $this->id;
        $data = array(
            'id' => $id
        );

        $domain = new ClosetModel();
        return $domain->postSubmitCheck($data);
    }
}
