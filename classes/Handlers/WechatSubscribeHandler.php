<?php

namespace Ecjia\App\Wechat\Handlers;

use Ecjia\App\Wechat\WechatUUID;
use Ecjia\App\Wechat\WechatUser;
use Ecjia\App\Wechat\Models\WechatUserModel;
use Ecjia\App\Wechat\Models\WechatReplyModel;
use Ecjia\App\Wechat\WechatRecord;
use Ecjia\App\Wechat\WechatMediaReply;

class WechatSubscribeHandler
{
    protected $message;
    
    protected $wechatUUID;
    
    public function __construct($message)
    {
        $this->message = $message;
        
        $this->wechatUUID = new WechatUUID();
    }
    
    /**
     * 关注公众号
     */
    public function subscribe()
    {
        $wechat_id = $this->wechatUUID->getWechatId();
        $openid = $this->message->get('FromUserName');
        
        $wechat = $this->wechatUUID->getWechatInstance();
        
        $userinfo = $wechat->user->get($openid);
        
        if (! empty($userinfo)) {
            if ($userinfo->has('unionid')) {
                $unionid = $userinfo->get('unionid');
                //查看有没有在手机或网站上使用微信登录
                $wechat_user = new WechatUser($wechat_id, $openid);
                $connect_user = $wechat_user->getConnectUser($unionid);
                $ecjia_userid = $connect_user->getUserId();
                if (empty($ecjia_userid)) {
                    //查看公众号unionid是否绑定
                    $userModel = $wechat_user->findUnionidUser($unionid);
                    if (!empty($userModel)) {
                        $ecjia_userid = $userModel->ect_uid;
                    }
                }
                
            } else {
                $ecjia_userid = 0;
            }
            
            //曾经关注过，再次关注，更新资料
            $userModel = $wechat_user->getWechatUser();
            if (! empty($userModel)) {
                $userModel->subscribe       = 1;
                $userModel->nickname        = $userinfo->get('nickname');
                $userModel->sex             = $userinfo->get('sex');
                $userModel->city            = $userinfo->get('city');
                $userModel->country         = $userinfo->get('country');
                $userModel->province        = $userinfo->get('province');
                $userModel->language        = $userinfo->get('language');
                $userModel->headimgurl      = $userinfo->get('headimgurl');
                $userModel->subscribe_time  = $userinfo->get('subscribe_time');
                $userModel->remark          = $userinfo->get('remark');
                $userModel->group_id        = $userinfo->get('groupid');
                $userModel->unionid         = $userinfo->get('unionid');
                $userModel->ect_uid         = $ecjia_userid;
                
                $userModel->save();
            } 
            //新关注用户，插入资料
            else {
                WechatUserModel::create([
                    'wechat_id'         => $wechat_id,
                    'group_id'          => $userinfo->get('groupid'),
                    'subscribe'         => 1,
                    'openid'            => $openid,
                    'nickname'          => $userinfo->get('nickname'),
                    'sex'               => $userinfo->get('sex'),
                    'city'              => $userinfo->get('city'),
                    'country'           => $userinfo->get('country'),
                    'province'          => $userinfo->get('province'),
                    'language'          => $userinfo->get('language'),
                    'headimgurl'        => $userinfo->get('headimgurl'),
                    'subscribe_time'    => $userinfo->get('subscribe_time'),
                    'remark'            => $userinfo->get('remark'),
                    'unionid'           => $userinfo->get('unionid'),
                    'ect_uid'           => $ecjia_userid,
                ]);
            }
            
            $defaultReply = '感谢您的关注';
            
            //给关注用户进行问候
            $data = WechatReplyModel::select('reply_type', 'content', 'media_id')
                    ->where('wechat_id', $wechat_id)->where('type', 'subscribe')->first();
            
            if ( ! empty($data)) {
                if ($data->reply_type == 'text') {
                    $content = WechatRecord::Text_reply($this->message, $data->getOriginal('content', $defaultReply));
                } else {
                    if ($data->media_id) {
                        $content = with(new WechatMediaReply($wechat_id, $data->media_id))->replyContent($this->message);
                    } 
                    //没有上传素材ID时，默认文字回复
                    else {
                        $content = WechatRecord::Text_reply($this->message, $defaultReply);
                    }
                }
            }
            
            return $content;
        }
        
    }
    
    /**
     * 取消关注时
     */
    public function unsubscribe()
    {
        $wechat_id = with(new WechatUUID())->getWechatId();
        $openid = $this->message->get('FromUserName');

        $wechat_user = new WechatUser($wechat_id, $openid);
        $userModel = $wechat_user->getWechatUser();
        if (! empty($userModel)) {
            $userModel->subscribe = 0;
            $userModel->save();
        }
    }
    
}
