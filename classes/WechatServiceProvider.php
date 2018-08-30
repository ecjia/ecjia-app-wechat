<?php

namespace Ecjia\App\Wechat;

use Royalcms\Component\App\AppParentServiceProvider;

class WechatServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-wechat', null, dirname(__DIR__));
    }
    
    public function register()
    {
        
    }
    
    
    
}