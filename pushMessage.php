<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
include "./WeChat/WeChat.class.php";
include "./WeChat/WeChatMenu.class.php";
//获取消息事件
$obj=new WeChat();
echo $obj->getToKen();
exit;
$value = [
    'button' => [
        [
            'type' => 'click',
            'name' => '最新博文',
            'key'  => 'V1001_TODAY_MUSIC'
        ],[
            'name' => '更多实例',
            'sub_button' => [
                [
                    'type' => 'view',
                    'name' => '搜索',
                    'url'  => 'http://www.soso.com/'
                ],[
                    "type"  => "click",
                    "name"  => "赞一下我们",
                    "key"  => "V1001_GOOD"
                ]
            ]
        ]
    ]
];

if(!isset($_GET["echostr"])){
    $obj = new WeChatMenu();
    echo $obj->createMenu($value);
//    $obj->getEvent();
}else{
    $obj->valid();
}