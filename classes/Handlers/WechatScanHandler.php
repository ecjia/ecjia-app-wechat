<?php

namespace Ecjia\App\Wechat\Handlers;

use Ecjia\App\Wechat\WechatUUID;

class WechatScanHandler
{
    protected $message;
    
    protected $wechatUUID;
    
    protected $eventType;
    
    protected $eventKey;
    
    protected $ticket;
    
    const EVENT_TYPE_SUBSCRIBE = 'subscribe';
    
    const EVENT_TYPE_SCAN = 'scan';
    
    public function __construct($message)
    {
        
        $this->message = $message;
        
        $this->wechatUUID = new WechatUUID();
        
        if ($this->message->get('Event') == 'subscribe') {
            $this->eventType = self::EVENT_TYPE_SUBSCRIBE;
            $this->eventKey = str_replace('qrscene_', '', $this->message->get('EventKey'));
            
        } else {
            $this->eventType = self::EVENT_TYPE_SCAN;
            $this->eventKey = $this->message->get('EventKey');
        }
        
        $this->ticket = $this->message->get('Ticket');
    }
    
    /**
     * 根据$this->eventKey参数决定做什么
     */
    public function getScanEventHandler()
    {
        
        
        
    }
    
}