<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
include "./WeChatPlugin/WeChat.class.php";

//菜单类
//include "./WeChat/WeChatMenu.class.php";
//消息管理类
include './WeChatPlugin/InformationManagement.class.php';

//$obj=new WeChat();
$obj=new WeChat();
//echo $obj->getToKen();
//exit;
//$value = [
//    'button' => [
//        [
//            'type' => 'click',
//            'name' => '最新博文',
//            'key'  => 'V1001_TODAY_MUSIC'
//        ],[
//            'name' => '更多实例',
//            'sub_button' => [
//                [
//                    'type' => 'view',
//                    'name' => '搜索',
//                    'url'  => 'http://www.soso.com/'
//                ],[
//                    "type"  => "click",
//                    "name"  => "赞一下我们",
//                    "key"  => "V1001_GOOD"
//                ]
//            ]
//        ]
//    ]
//];

if(!isset($_GET["echostr"])){
//    $obj = new InformationManagement();
    //        $value = [
//            'title' => [
//                'value' => '支付成功',
//                'color' => '#173177'
//            ],
//            'orderNumber' => [
//                'value' => 'O201712221231',
//                'color' => '#173177'
//            ],
//            'userName' => [
//                'value' => '刘中胜',
//                'color' => '#173177'
//            ],
//            'payTime' => [
//                'value' => '2017年12月22日 12时32分',
//                'color' => '#173177'
//            ],
//            'sum' => [
//                'value' => '人民币2200.00元',
//                'color' => '#173177'
//            ],
//            'desc' => [
//                'value' => '测试服务',
//                'color' => '#999'
//            ]
//        ];
//    $obj->sendTemplateMessage();
//    echo $obj->createMenu($value);
    $obj=new InformationManagement();
    $obj->getEvent();
}else{
    $obj->valid();
}
