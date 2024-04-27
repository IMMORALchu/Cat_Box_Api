<?php
namespace App\Api\Closet;

use PhalApi\Api;
use App\Domain\Closet\Sort as SortDomain;
use App\Domain\Cookie as Domain_Cookie;

/**
 * 衣橱分类接口
 */

class Sort extends Api
{
    public function getRules()
    {
        return array(
            'getSortList' => array(
            ),
            'postAddSort' => array(
                'value' => array('name' => 'sort_name', 'type' => 'string', 'require' => true, 'desc' => '分类名称'),
            ),
        );
    }

    /**
     * 获取分类列表
     * @desc 获取分类列表
     * @return int code 操作码，0表示成功
     * @return string msg 提示信息
     * @return array data 数据
     * 
     */

    public function getSortList()
    {
                // 验证cookie
        // 获取cookie
        $cookie = $_COOKIE['cookie'];
        $domain_cookie = new Domain_Cookie();
        $check_cookie = $domain_cookie->checkCookie($cookie);
        if ($check_cookie['code'] != 0) {
            return $check_cookie;
        }
        $domain = new SortDomain();
        return $domain->getSortList();
    }

    /**
     * 添加分类
     * @desc 添加分类
     * @return int code 操作码，0表示成功
     * @return string msg 提示信息
     * @return array data 数据
     * 
     */

    public function postAddSort()
    {
                // 验证cookie
        // 获取cookie
        $cookie = $_COOKIE['cookie'];
        $domain_cookie = new Domain_Cookie();
        $check_cookie = $domain_cookie->checkCookie($cookie);
        if ($check_cookie['code'] != 0) {
            return $check_cookie;
        }
        $value = $this->value;
        $data = array(
            'value' => $value
        );
        $domain = new SortDomain();
        return $domain->postAddSort($data);
    }
}