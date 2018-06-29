<?php

namespace Ecjia\App\Wechat;

use RC_Time;
use Ecjia\App\Wechat\Models\WechatUserModel;
use Ecjia\App\Wechat\Models\WechatCustomMessageModel;

class WechatRecord
{
    
    /**
     * 输入信息
     */
    public static function inputMsg($fromusername, $content)
    {
        $uid = WechatUserModel::where('openid', $fromusername)->pluck('uid');
        if (!empty($uid)) {
            $data = array(
                'uid'  	     => $uid,
                'msg'  	     => $content,
                'send_time'  => RC_Time::gmtime(),
                'iswechat'   => 0,
            );
            WechatCustomMessageModel::insert($data);
        }
    }
    
    /**
     * 公众号回复信息
     */
    public static function replyMsg($fromusername, $content)
    {
        $uid = WechatUserModel::where('openid', $fromusername)->pluck('uid');
        if (!empty($uid)) {
            $data = array(
                'uid'  	     => $uid,
                'msg'  	     => $content,
                'send_time'  => RC_Time::gmtime(),
                'iswechat'   => 1,
            );
            WechatCustomMessageModel::insert($data);
        }
    }
    
    
}