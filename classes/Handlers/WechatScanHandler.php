<?php

namespace Ecjia\App\Wechat\Handlers;

use Ecjia\App\Wechat\WechatUUID;

class WechatScanHandler
{
    protected $message;
    
    protected $wechatUUID;
    
    public function __construct($message)
    {
        $this->message = $message;
        
        $this->wechatUUID = new WechatUUID();
    }
    
    
    public function scan()
    {
        
        
        
    }
    
}