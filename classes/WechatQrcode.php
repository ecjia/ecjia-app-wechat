<?php

namespace Ecjia\App\Wechat;

class WechatQrcode
{
    
    const QR_SCENE = 'QR_SCENE';
    
    const QR_STR_SCENE = 'QR_STR_SCENE';
    
    const QR_LIMIT_SCENE = 'QR_LIMIT_SCENE';
    
    const QR_LIMIT_STR_SCENE = 'QR_LIMIT_STR_SCENE';
    
    protected $wechat_uuid;
    
    public function __construct()
    {
        $this->wechat_uuid = new WechatUUID();
    }
    
    /**
     * 临时二维码
     */
    public function temporary($sceneValue, $expireDays = 1)
    {
        $qrcode = $this->wechat_uuid->getWechatInstance()->qrcode;
        
        $result = $qrcode->temporary($sceneValue, $expireDays * 24 * 3600);
        
        return $result;
    }
    
    /**
     * 永久二维码
     */
    public function forever($sceneValue)
    {
        $qrcode = $this->wechat_uuid->getWechatInstance()->qrcode;
        
        $result = $qrcode->forever($sceneValue);
        
        return $result;
    }
    
    
}