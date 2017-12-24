<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) www.php63.cc All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吹泡泡的鱼 <996674366@qq.com>
// +---------

date_default_timezone_set("PRC");
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
include "./WeChatPlugin/WeChat.class.php";
include './WeChatPlugin/WeChatUser.class.php';


$object = new WeChatUser();
//获取用户列表接口
//$data = $object->getUserList();
//echo '<Pre>';
//print_r($data);

//"ogCv9vmjF-QdAFuAQaDIvDL90uac",
//"ogCv9vlDNxCNukXg7nDQ8XYyPeso",
//"ogCv9vi3VVdDWWEZ5mYUwBw-S_iI"

//获取用户详情
//$data = $object->getUserInfo();

//获取黑名单列表
// $data = $object->getBlackList();

//拉黑用户
// $data = $object->batchBlackList(['ogCv9vi3VVdDWWEZ5mYUwBw-S_iI','ogCv9vlDNxCNukXg7nDQ8XYyPeso']);

//取消拉黑用户
// $data = $object->batchunBlackList(['ogCv9vlDNxCNukXg7nDQ8XYyPeso']);

//设置备注
// $data = $object->updateRemark('', '妹纸');

//添加用户标签
$data = $object->createTags('测试标签2');
var_dump($data);
