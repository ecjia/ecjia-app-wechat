<?php

namespace Ecjia\App\Wechat\Handlers;

use RC_Hook;
use Ecjia\App\Wechat\Models\WechatReplyModel;

class WechatEventHandler
{
    /**
     * 事件消息请求
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function getEventHandler($message)
    {
        switch ($message->Event) {
            case 'subscribe':
                # code...
                break;
                
            case 'unsubscribe':
                
                break;
                
            case 'SCAN':
                
                break;
                
            case 'CLICK':
                return self::View_event($message);
                break;
                
            case 'VIEW':
                return self::Click_event($message);
                break;
                
            case 'LOCATION':
                
                break;
                
            default:
                # code...
                break;
        }
        
        // ...
    }
    
    /**
     * 文本回复
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function Default_event($message) 
    {
        
    }
    
    public static function Click_event($message) {
        
    }
    
    /**
     * 文本请求
     * @param \Royalcms\Component\Support\Collection $message
     * @return \Royalcms\Component\WeChat\Message\AbstractMessage
     */
    public static function View_event($message) 
    {
        
    }
    
    /**
     * 上报地理位置事件
     * @param \Royalcms\Component\Support\Collection $message
     */
    public static function Location_event($message)
    {
        
    }
    
}