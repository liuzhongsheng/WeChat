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

    //获取自定义信息
    public function getEvent()
    {
        header("Content-type:text/xml");
        //引入事件处理类
        require dirname(__FILE__) . '/HandleEvent.class.php';
        //获取xml字符串
        $xmlStr = file_get_contents('php://input');
        file_put_contents('12.txt', var_export($xmlStr, true));
        if (!empty($xmlStr)) {
            //禁止从外部加载xml实体
            libxml_disable_entity_loader(true);
            $data = simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $msgType = strtolower(trim($data->MsgType));
            switch ($msgType) {
                case 'event':
                    if ($data->Event == 'subscribe') {
                        $handleEvent = new HandleEvent();
                        $handleEvent->subscribe($data);
                    }
                    break;
                case 'text':
                    echo self::sendTestMessage($data, '吹泡泡的鱼');
                    exit;
                    break;
                case 'image':
                    echo self::sendImageMessage($data);
                    exit;
                    break;

            }
        }
    }

    /**
     * 文本回复
     * @param $object 接受到微信传递过来的对象
     * @param $message 消息内容
     * @return string 返回拼接好的文本消息模板
     */
    protected function sendTestMessage($object, $message)
    {
        $xmlTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName> 
                <FromUserName><![CDATA[%s]]></FromUserName> 
                <CreateTime>%s</CreateTime>
                 <MsgType><![CDATA[text]]></MsgType> 
                 <Content><![CDATA[%s]]></Content> 
                 </xml>";
        return sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $message);
    }

    /**
     * 图文回复
     * @param $object 微信传递过来的数据
     * @return string 返回拼接好的模板
     */
    protected function sendImageMessage($object)
    {

        $xmlTpl = "<xml> 
                        <ToUserName>< ![CDATA[%s] ]></ToUserName> 
                        <FromUserName>< ![CDATA[%s] ]></FromUserName> 
                        <CreateTime>%s</CreateTime> 
                        <MsgType>< ![CDATA[image] ]></MsgType> 
                        <PicUrl>< ![CDATA[%s] ]></PicUrl> 
                        <MediaId>< ![CDATA[%s] ]></MediaId> 
                        <MsgId>%s</MsgId> 
                    </xml>";
        return sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $object->PicUrl, '', $object->MsgId);
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
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        file_put_contents('1.txt',var_export($data,true));
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
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        return $data;
    }
}