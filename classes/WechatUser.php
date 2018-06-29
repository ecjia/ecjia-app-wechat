<?php

namespace Ecjia\App\Wechat;

use Ecjia\App\Weapp\Models\WechatUserModel;

/**
 * 微信用户类
 * @author royalwang
 *
 */
class WechatUser
{
    protected $wechat_id;
    
    protected $open_id;
    
    protected $user;
    
    public function __construct($wechat_id, $openid) 
    {
        $this->wechat_id    = $wechat_id;
        $this->open_id      = $openid;
        
        $this->user  = $this->findUser();
    }
    
    public function getWechatUser() 
    {
        return $this->user;
    }
    
    protected function findUser()
    {
        $user = WechatUserModel::where('wechat_id', $this->wechat_id)->where('openid', $this->open_id)->first();
        return $user;
    }
    
    public function getUnionid() 
    {
        return $this->user->unionid;
    }
    
    public function getImage() 
    {
        return $this->user->headimgurl;
    }
    
    public function getNickname() 
    {
        return $this->user->nickname;
    }
    
    public function sex() 
    {
        return $this->user->sex;
    }
    
    /**
     * 获取ecajia用户id
     */
    public function getEcjiaUserId() 
    {
        return $this->user->ect_uid;
    }
    
    /**
     * 设置与微信关联的ecjia用户id
     * @param integer $userid
     */
    public function setEcjiaUserId($userid) 
    {
        $this->user->ect_uid = $userid;
        return $this->user->update(array('ect_uid' => $userid));
    }
    
    /**
     * 生成用户名
     * @return string
     */
    public static function generateUsername() {
        /* 不是用户注册，则创建随机用户名*/
        return 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');
    }
    
    /**
     * 生成用户名
     * @return string
     */
    public static function generatePassword() {
        /* 不是用户注册，则创建随机用户名*/
        return md5(rc_random(13, 'abcdefghijklmnopqrstuvwxyz0123456789'));
    }
    
    /**
     * 生成邮箱
     * @return string
     */
    public static function generateEmail() {
        /* 不是用户注册，则创建随机用户名*/
        $string = 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');
        $email = $string.'@163.com';
        return $email;
    }
    
}