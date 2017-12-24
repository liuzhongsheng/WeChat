<?php
// +----------------------------------------------------------------------
// |用户标签类 
// +----------------------------------------------------------------------
// | Copyright (c) www.php63.cc All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吹泡泡的鱼 <996674366@qq.com>
// +---------

class WeChatUserTag extends WeChat
{

	
	//创建用户标签
	//一个公众号最多可以创建100个标签
	//标签名（30个字符以内）
	public function createTags($name)
	{
		$url = $this->config['serve_url'].'tags/create?access_token='.$this->accessToken;
		$data = [
			'tag' => [
				'name' => $name
			]
		];
		return $this->post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
	}

	//获取公众号已创建的标签
	public function getTags()
	{
		$url = $this->config['serve_url'].'tags/get?access_token='.$this->accessTokenl;
		return $this->get($url);
	}

}
