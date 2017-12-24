<?php
// +----------------------------------------------------------------------
// | 事件处理类
// +----------------------------------------------------------------------
// | Copyright (c) www.php63.cc All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吹泡泡的鱼 <996674366@qq.com>
// +---------

class HandleEvent extends WeChat
{
    //订阅事件
    public function subscribe($object)
    {
        //获取关注者微信openid
        $openid = $object->FromUserName;
        //获取驱动方式
        switch ($this->config['event_drive']) {
            case 'redis':
                $this->joinRedis('WechatSubscribe', $openid);
                break;
        }
        echo InformationManagement::sendTestMessage($object, $this->welcomeController);
        exit;
    }

    //取消订阅事件
    public function unsubscribe($object)
    {
        //获取关注者微信openid
        $openid = $object->FromUserName;
        //获取驱动方式
        switch ($this->config['event_drive']) {
            case 'redis':
                $this->joinRedis('WechatUnsubscribe', $openid);
                break;
        }

    }

    /**
     *
     * @param $key 操作名称
     * @param $openid 微信openid
     */
    protected function joinRedis($key, $openid)
    {
        include 'Drive/RedisHandle.class.php';
        $obj = RedisHandle::getInstance();
        $obj->host = $this->config['host'];
        $obj->port = $this->config['port'];
        $obj->password=$this->config['password'];
        $obj->timeOut =$this->config['time_out'];
        $obj->joinQueue($key, $openid);
    }


}