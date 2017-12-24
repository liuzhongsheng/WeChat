<?php
// +----------------------------------------------------------------------
// | 消息管理类
// +----------------------------------------------------------------------
// | Copyright (c) www.php63.cc All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吹泡泡的鱼 <996674366@qq.com>
// +---------

class InformationManagement extends WeChat
{
    public function __construct()
    {
        parent::__construct();
    }

    //获取自定义信息
    public function getEvent()
    {
        header("Content-type:text/xml");
        //引入事件处理类
        //获取xml字符串
        $xmlStr = file_get_contents('php://input');
        if (!empty($xmlStr)) {
            //禁止从外部加载xml实体
            libxml_disable_entity_loader(true);
            $data = simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $msgType = strtolower(trim($data->MsgType));
            switch ($msgType) {
                case 'event':
                    include 'HandleEvent.class.php';
                    $handleEvent = new HandleEvent();
                    switch ($data->Event) {
                        //关注
                        case 'subscribe':
                            $handleEvent->subscribe($data);
                            break;
                        //取消关注
                        case 'unsubscribe':
                            $handleEvent->unsubscribe($data);
                            break;

                    }
                    if ($data->Event == 'subscribe') {
                        file_get_contents('1.txt',$data);

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
    public static function sendTestMessage($object, $message)
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
     * 发送模板消息
     * @param $key 要推送的模板id
     * @param string $value 要推送的值
     * @param string $url 跳转地址
     * @return mixed 返回执行结果
     */
    public function sendTemplateMessage($key, $value = '', $url='')
    {
        //获取openid
        $postData = $this->getWeChatPost();
        $data = [
            'touser' => $postData->ToUserName,
            'template_id' => $key,
            'url' => $url,
            'topcolor' => '#FF0000',
            'data' => $value,
        ];
        $url = $this->config['serve_url'] . 'message/template/send?access_token=' . $this->accessToken;
        return $this->post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

}