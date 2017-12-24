<?php
// +----------------------------------------------------------------------
// | 微信处理类
// +----------------------------------------------------------------------
// | Copyright (c) www.php63.cc All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吹泡泡的鱼 <996674366@qq.com>
// +---------

class WeChat
{
    //订阅后欢迎语
    public $welcomeController = '欢迎订阅PHP63.cc';

    //配置信息
    protected $config;
    //accessToken
    protected $accessToken;
    public function __construct()
    {
        //加载配置文件
        $this->config = include './config.php';
        //加载token，由于accessToken有效时间为2小时可以用shell定时获取写入这个文件
        $this->accessToken = file_get_contents('./access_token.txt');
    }

    /**
     * 获取access_token
     * @return mixed
     */
    public function getToKen()
    {
        //请求地址
        $url = $this->config['serve_url'] . 'token';
        //请求参数
        $param = [
            'grant_type' => 'client_credential',
            'appid' => $this->config['appid'],
            'secret' => $this->config['secret']
        ];
        return $this->post($url, $param);
    }



    /**
     *  检测授权
     */
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    // 授权检测
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $tmpArr = array($this->config['token'], $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 模拟post请求
     * @param $url 请求地址
     * @param $data 参数值
     * @return mixed 结果
     */
    public function post($url, $data)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
//        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        return $data;
    }

    /**
     * 模拟post覃塘区
     * @param $url 请求地址
     * @return mixed 结果
     */
    public function get($url)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
//        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        return $data;
    }

    public function exception($message, $code)
    {
        new SystemException($message, $code);
        
    }
}