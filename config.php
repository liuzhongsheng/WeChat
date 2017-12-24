<?php
return [
    'token'            =>      'weixin',
    'appid'            =>      'wxf3dfbfcf9bbe9230',
    'secret'           =>      '66cfed2094589fb44e2ffe1c88b1959e', //393a40fbf99c087f3b914c0be16580bf
    'serve_url'        =>      'https://api.weixin.qq.com/cgi-bin/',
    'event_drive'      =>      'redis',//驱动方式(关注，取消关注)：redis
    'host'             =>      '127.0.0.1',
    'port'             =>       111,
    'password'         =>       '',//redis密码
    'time_out'         =>       1,//超时时间(秒)
];