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

class WeChatUser extends WeChat
{
    /**
     * 获取微信用户列表
     * 调用地址：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140840
     * @param string $next_openid
     * @return mixed 获取到的用户列表
     */
    public function getUserList($next_openid='')
    {
        $url = $this->config['serve_url'].'user/get?access_token='.$this->accessToken.'&next_openid='.$next_openid;
        return $this->get($url);
    }

    /**
     * 获取微信用户信息
     * 文档地址：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140839
     * @param $openid 微信id
     * @param string $lang 语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     * @return mixed 返回查询到的用户信息
     * @throws Exception
     */
    public function getUserInfo($openid, $lang = 'zh_CN')
    {
        //检测是否传入openid
        if ($openid == '') {
            echo '<pre>';
            throw new Exception('请传入openid',5);
        }
        $url = $this->config['serve_url'].'user/info?access_token='.$this->accessToken.'&openid='.$openid.'&lang='.$lang;
        return $this->get($url);
    }

    /**
     * 获取黑名单列表
     * 文档地址https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1471422259_pJMWA
     * @param string $begin_openid 当 begin_openid 为空时，默认从开头拉取。
     * @return mixed 获取到返回的列表
     **/
    public function getBlackList($begin_openid = '')
    {
        $url  = $this->config['serve_url'].'tags/members/getblacklist?access_token='.$this->accessToken;
        $data = [
            'begin_openid' => $begin_openid
        ];
        return $this->post($url, json_encode($data));
    }

    /**
     * 拉黑用户
     * 文档地址：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1471422259_pJMWA
     * @param array $user_list 要拉黑的用户openid，一次最多20个用户
     * @return mixed 返回执行结果
     * @throws Exception
     **/
    public function batchBlackList($user_list = [])
    {
        return $this->batchAndBlackUser($user_list, 'batchblacklist');
    }

    /**
     * 取消拉黑用户
     * 文档地址：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1471422259_pJMWA
     * @param array $user_list 要取消拉黑的用户openid，一次最多20个用户
     * @return 返回执行结果
     * @throws Exception
     **/
    public function batchunBlackList($user_list = [])
    {
        return $this->batchAndBlackUser($user_list, 'batchunblacklist');
    }

    /**
     * 设置用户备注名( 新的备注名，长度必须小于30字符)
     * 文档地址：https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140838
     * @param string $openid 修改的id
     * @param string $remark 备注名称
     * @return mixed 返回修改结果
     * @throws Exception
     **/

    public function  updateRemark($openid = '', $remark = '')
    {
        //检测是否传入openid
        if ($openid == '') {
            echo '<pre>';
            throw new Exception('第一个参数openid不能为空',5);
        }

        //检测是否传昵称
        if ($remark == '') {
            echo '<pre>';
            throw new Exception('第二个参数昵称不能为空',5);
        }
        $url  = $this->config['serve_url'].'user/info/updateremark?access_token='.$this->accessToken;
        $data = [
            'openid' => $openid,
            'remark' => $remark
        ];
        return $this->post($url, json_encode($data));
    }


    /**
     * 拉黑或者取消拉黑公用方法
     * @param array $user_list 数据
     * @param string $url 要执行的方法
     * @return mixed 执行结果
     * @throws Exception 错误信息
     */
    private function batchAndBlackUser($user_list = [], $url = '')
    {
        //检测是否为数组如果不是用户强制转换为数组
        if (!is_array($user_list)) {
            $user_list = (array)$user_list;
        }

        //检测是否传入openid
        if (count($user_list) < 1) {
            echo '<pre>';
            throw new Exception('请传入要拉黑用户openid',5);
        }
        $url  = $this->config['serve_url'].'tags/members/'.$url.'?access_token='.$this->accessToken;
        $data = [
            'openid_list' => $user_list
        ];
        return $this->post($url, json_encode($data));
    }
}
