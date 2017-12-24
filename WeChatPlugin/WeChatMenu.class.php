<?php
// +----------------------------------------------------------------------
// | 微信处理类：菜单处理
// +----------------------------------------------------------------------
// | Copyright (c) www.php63.cc All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吹泡泡的鱼 <996674366@qq.com>
// +---------

class WeChatMenu extends WeChat
{

    /**
     * 创建菜单
     * @param $value 菜单数组
     * @return mixed 成功 {"errcode":0,"errmsg":"ok"}
     */
    public function createMenu($value)
    {
        //请求地址
        $url = $this->config['serve_url'].'menu/create?access_token='.$this->accessToken;
        return $this->post($url, json_encode($value,JSON_UNESCAPED_UNICODE));
    }

    /**
     * 获取菜单列表
     * @return mixed 获取到的菜单列表
     */
    public function getMenu()
    {
        $url = $this->config['serve_url'].'menu/get?access_token='.$this->accessToken;
        return $this->get($url);
    }

    /**
     * 删除菜单
     * @return mixed
     */
    public function deleteMenu()
    {
        $url=$this->config['serve_url'].'menu/delete?access_token='.$this->accessToken;
        return $this->get($url);
    }

}