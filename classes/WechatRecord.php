<?php

namespace Ecjia\App\Wechat;

use RC_Time;
use RC_Lang;
use Ecjia\App\Wechat\Models\WechatUserModel;
use Ecjia\App\Wechat\Models\WechatCustomMessageModel;
use Royalcms\Component\WeChat\Message\Text;
use Royalcms\Component\WeChat\Message\Image;

class WechatRecord
{
    /**
     * 回复文本消息
     */
    public static function Default_reply($message) {
        $content = array(
            'content'       => '抱歉，暂未找到与您关键词所匹配的信息，可以进入客服系统进行相关咨询'
        );
        self::replyMsg($message->get('FromUserName'), $content['content']);
        
        return new Text($content);
    }
    
    /**
     * 回复文本消息
     */
    public static function Text_reply($message, $text) {
        if (!empty($text)) {
            $content = array(
                'content'       => $text
            );
            self::replyMsg($message->get('FromUserName'), $text);
            
            return new Text($content);
        } 
        else {
            return self::Default_reply($message);
        }
    }
    
    /**
     * 回复图片消息
     */
    public static function Image_reply($message, $file) {
        if (!empty($file)) {
            $content = [
                'media_id' => $file //通过素材管理接口上传多媒体文件，得到的id。
            ];
            self::replyMsg($message->get('FromUserName'), RC_Lang::get('wechat::wechat.image_content'));
            
            return new Image($content);
        } 
        else {
            return self::Default_reply($message);
        }
    }
    
    /**
     * 回复语音消息
     */
    public static function Voice_reply($message, $file) {
        if (!empty($file)) {
            $content = [
                'media_id' => $file //通过素材管理接口上传多媒体文件，得到的id。
            ];
            self::replyMsg($message->get('FromUserName'), RC_Lang::get('wechat::wechat.voice_content'));
        } else {
            $content = self::Default_reply($message);
        }
        
        return $content;
    }
    
    /**
     * 回复视频消息
     */
    public static function Video_reply($message, $file, $title, $digest) {
        if (!empty($file)) {
            $content = [
                'media_id' => $file,
                'title' => $title,
                'description' => $digest
            ];
            self::replyMsg($message->get('FromUserName'), RC_Lang::get('wechat::wechat.video_content'));
        } else {
            $content = self::Default_reply($message);
        }
        
        return $content;
    }
    
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