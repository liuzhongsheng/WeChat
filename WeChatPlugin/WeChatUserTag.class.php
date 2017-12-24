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

	//更新标签
	public function updateTag()
	{
		$url = $this->config['serve_url'].'tags/update?access_token='.$this->accessToken;
		$data = [
			'tag' => [
				'name' => $name
			]
		];
		return $this->post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
	}

	//删除标签
	public function deleteTag()
	{
		$url = $this->config['serve_url'].'tags/delete?access_token='.$this->accessTokenl;
		$data = [
			'tagid' => $tagId,
			'next_openid' => $next_openid
		];
		return $this->post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
	}
	// 获取标签下粉丝列表
	public function getFansList()
	{
		$url = $this->config['serve_url'].'user/tag/get?access_token='.$this->accessTokenl;
		$data = [
			'tagid' => $tagId,
			'next_openid' => $next_openid
		];
		return $this->post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
	}
	//为用户设置标签
	public function setUserTag($tagId, $openIdList)
	{
		$url = $this->config['serve_url'].'tags/members/batchtagging?access_token='.$this->accessToken;
		$data = [
			'tagid'			=> $tagId,
			'openid_list'   => $opendIdList
		];
		return $this->post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
	}
	
	//批量为用户取消标签
	public function cancelUserTag()
	{
		$url = $this->config['serve_url'].'tags/members/batchuntagging?access_token='.$this->accessToken;
		$data = [
			'tagid'			=> $tagId,
			'openid_list'   => $opendIdList
		];
		return $this->post($url, json_encode($data, JSON_UNESCAPED_UNICODE);
	}

	//获取用户身上的标签列表
	public function getUserTag()
	{
		$url = $this->config['serve_url'].'tags/getidlist?access_token='.$this->accessToken;
		$data = [
			'openid' = $openid
		];
		return $this->post($url, json_encode($data);
	}
}
