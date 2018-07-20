<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/20
 * Time: 4:25 PM
 */

namespace Ecjia\App\Wechat\Sends;

use Ecjia\App\Wechat\WechatRecord;
use Royalcms\Component\WeChat\Message\Text;
use Royalcms\Component\WeChat\Message\Image;
use Royalcms\Component\WeChat\Message\Voice;
use Royalcms\Component\WeChat\Message\Video;
use Royalcms\Component\WeChat\Message\News;
use Royalcms\Component\WeChat\Message\Music;

class SendCustomMessage
{

    protected $wechat;

    protected $openid;

    public function __construct($wechat, $openid)
    {
        $this->wechat = $wechat;
        $this->openid = $openid;
    }

    /**
     * 发送文本消息
     */
    public function sendTextMessage($content)
    {
        $body = ['content' => $content];

        $message = new Text($body);

        $result = $this->wechat->staff->message($message)->to($this->openid)->send();

        WechatRecord::replyMsg($this->openid, $body['content']);

        return $result;
    }

    /**
     * 发送图片消息
     */
    public function sendImageMessage()
    {

    }

    /**
     * 发送语音消息
     */
    public function sendVoiceMessage()
    {

    }

    /**
     * 发送视频消息
     */
    public function sendVedioMessage()
    {

    }

    /**
     * 发送音乐消息
     */
    public function sendMusicMessage()
    {

    }


    /**
     * 发送图文消息
     */
    public function sendNewsMessage()
    {

    }

    /**
     * 发送图文消息
     */
    public function sendMpnewsMessage()
    {

    }

    /**
     * 发送卡券
     */
    public function sendWxcardMessage()
    {

    }

    /**
     * 发送小程序卡片
     */
    public function sendMiniProgrampageMessage()
    {

    }


}