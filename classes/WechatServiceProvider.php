<?php

namespace Ecjia\App\Wechat;

use Royalcms\Component\App\AppServiceProvider;

class WechatServiceProvider extends  AppServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-wechat');
    }
    
    public function register()
    {
        
    }
    
    
    
}