<?php
// +----------------------------------------------------------------------
// | redis邮件发送类v2.0
// +----------------------------------------------------------------------
// | Copyright (c) www.php63.cc All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吹泡泡的鱼 <996674366@qq.com>
// +---------
class RedisHandle
{
    /**
     * 是否启用阻塞模式，如果使用cli执行，建议开启阻塞模式
     * @var bool 是否使用阻塞模式，true是 false 否
     */
    public $block = true;

    /**
     * 当启用阻塞模式时该方法生效
     * @var int 超时时间，单位秒
     */
    public $timeOut = 100;

    public $host='127.0.0.1';

    public $port=6379;
    public $password;
    /**
     * 为了避免类被重复实例化，第一次实例化后将会把实例化后的结果存入该方法
     * @var
     */
    private static $instance;


    private $redis;

    //初始化化类，防止被实例化
    private function __construct()
    {
        $this->redis = $this->connect();
    }

    //防止类被克隆
    private function __clone()
    {
        trigger_error('Clone is not allow!', E_USER_ERROR);
    }

    /**
     * 防止类重复实例化
     * 检测当前类是否已经实例化过，如果实例化过直接返回
     * @return redisEmail 返回实例化过后的对象
     */
    public static function getInstance()
    {
        //检测当前类是否实例化过
        if (!(self::$instance instanceof self)) {
            //如果当前类没有实例化过则实例化当前类
            self::$instance = new self;
        }
        return self::$instance;
    }

    //连接redis
    private function connect()
    {
        try {
            $redis = new \Redis();
            $redis->pconnect($this->host, $this->port);
            return $redis;
        } catch (RedisException $e) {
            echo 'phpRedis扩展没有安装：' . $e->getMessage();
            exit;
        }
    }

    /**
     * @param $key 要加入的key
     * @param $value 要加入的openid
     * @return int 成功返回1
     */
    public function joinQueue($key, $value)
    {
        return $this->redis->lpush($key, $value);
    }

    /**
     * @param $key
     * @return array|string
     */
    public function popQueue($key)
    {
        return $this->redis->brpop($key, $this->timeOut);
    }


    /**
     * 获取key的总长度
     * @param $key 要获取的key
     * @return int 长度
     */
    public function getCount($key)
    {
        return $this->redis->llen($key);
    }
}