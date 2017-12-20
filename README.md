# WeChat 微信处理类
需要引入的类
<pre>
#基础类
include './WeChat/WeChat.class.php';

#菜单类
include './WeChat/WeChatMenu.class.php';

#事件类
include './WeChat/HandleEvent.class.php';

</pre>

获取token
<pre>
$obj=new WeChat();
echo $obj->getToKen();
</pre>

创建菜单
<pre>
$obj = new WeChatMenu();
echo $obj->createMenu($value);
</pre>


消息相关
<pre>
if(!isset($_GET["echostr"])){
    #创建获取事件
    $obj->getEvent();
}else{
    $obj->valid();
}
</pre>