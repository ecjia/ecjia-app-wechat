<?php

namespace Ecjia\App\Wechat;

use RC_Hook;
use Ecjia\App\Wechat\Models\WechatReplyModel;

class WechatMessageHandler
{
    
    /**
     * 文本回复
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Default_action($message) {
        return self::Text_action($message);
    }
    
    /**
     * 文本请求
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Text_action($message) {
        
        RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'command_reply'), 10, 2);
        RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'keyword_reply'), 90, 2);
        RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'empty_reply'), 100, 2);
        
        $response = RC_Hook::apply_filters('wechat_text_response', null, $message);
        
        return $response;
    }
    
    
    /**
     * 消息为空情况下回复
     * @param \Royalcms\Component\WeChat\Message\AbstractMessage $content
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage 
     */
    public static function empty_reply($content, $message) {
        if (!is_null($content)) {
            return $content;
        }
        
        $wechat_id = with(new WechatUUID())->getWechatID();
        
        $data = WechatReplyModel::select('reply_type', 'content', 'media_id')
                                ->where('wechat_id', $wechat_id)->where('type', 'msg')->first();
                                
        if ( ! empty($data)) {
            if ($data->reply_type) {
                $content = WechatRecord::Text_reply($message, $data['content']);
            } else {
                $content = with(new WechatMediaReply($wechat_id, $data->media_id))->replyContent($message);
            }
        }
        
        return $content;
    }
    
    /**
     * 关键字回复
     * @param \Royalcms\Component\WeChat\Message\AbstractMessage $content
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function keyword_reply($content, $message) {
        if (!is_null($content)) {
            return $content;
        }
        
        $wechat_id = with(new WechatUUID())->getWechatID();
        $rule_keywords  = $message->get('Content');
        
        //用户输入信息记录
        WechatRecord::inputMsg($message->get('FromUserName'), $rule_keywords);
        
        $model = WechatReplyModel::leftJoin('wechat_rule_keywords', 'wechat_rule_keywords.rid', '=', 'wechat_reply.id')
                                    ->select('wechat_reply.content', 'wechat_reply.media_id', 'wechat_reply.reply_type')
                                    ->where('wechat_reply.wechat_id', $wechat_id)
                                    ->where('wechat_rule_keywords.rule_keywords', $rule_keywords)->first();
        
        if (! empty($model)) {
            if ($model->media_id) {
                $content = with(new WechatMediaReply($wechat_id, $model->media_id))->replyContent($message);
            } else {
                $content = WechatRecord::Text_reply($message, $model->content);
            }
        }
        
        return $content;
    }
    
    
    /**
     * 命令回复
     * @param \Royalcms\Component\WeChat\Message\AbstractMessage $content
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function command_reply($content, $message) {
        if (!is_null($content)) {
            return $content;
        }
        
        $wechat_id = with(new WechatUUID())->getWechatID();
        
        $content = with(new WechatCommand($message, $wechat_id))->runCommand($message->get('Content'));
        
        if (is_string($content)) {
            $content = WechatRecord::Text_reply($message, $content);
        }
        
        return $content;
    }
    
}