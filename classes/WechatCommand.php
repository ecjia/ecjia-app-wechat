<?php

namespace Ecjia\App\Wechat;

use Ecjia\App\Platform\Models\PlatformCommandModel;
use Ecjia\App\Platform\Plugin\PlatformPlugin;

class WechatCommand
{
    protected $message;
    
    protected $wechat_id;
    
    public function __construct($message, $wechat_id)
    {
        $this->message = $message;
        $this->wechat_id = $wechat_id;
    }
    
    /**
     * 执行一个命令
     * @param string $cmd
     */
    public function runCommand($cmd) {
        //查询$cmd命令是哪个插件的
        $model = PlatformCommandModel::where('account_id', $this->wechat_id)->where('cmd_word', $cmd)->first();
        
        if (!empty($model) && $model->ext_code) {
//             $handler = new platform_factory($row['ext_code'], array('parameter' => $this->request->getParameters(), 'sub_code' => $row['sub_code']));
            // @todo 插件子命令查询
            $extend_handle = with(new PlatformPlugin)->channel($model->ext_code);
            $extend_handle->setMessage($this->message);
            return $extend_handle->eventReply();
        } else {
            return null;
        }
    }
    
    /**
     * 查询$cmd命令是否存在
     * @param string $cmd
     * @return boolean
     */
    public function hasCommand($cmd) 
    {
        $model = PlatformCommandModel::where('account_id', $this->wechat_id)->where('cmd_word', $cmd)->first();
        
        if (!empty($model)) {
            return true;
        } else {
            return false;
        }
    }
    
}