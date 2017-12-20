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
        //调用消息发送
        echo self::sendTestMessage($object, $this->welcomeController);
        exit;
    }



}