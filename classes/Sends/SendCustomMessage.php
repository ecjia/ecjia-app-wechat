<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/20
 * Time: 4:25 PM
 */

namespace Ecjia\App\Wechat\Sends;

use Ecjia\App\Wechat\WechatRecord;
use Ecjia\App\Wechat\WechatMediaReply;
use Royalcms\Component\WeChat\Message\Text;
use Royalcms\Component\WeChat\Message\Image;
use Royalcms\Component\WeChat\Message\Voice;
use Royalcms\Component\WeChat\Message\Video;
use Royalcms\Component\WeChat\Message\News;
use Royalcms\Component\WeChat\Message\Music;
use Royalcms\Component\WeChat\Message\Mpnews;
use Ecjia\App\Wechat\Models\WechatMediaModel;

class SendCustomMessage
{
    protected $wechat_id;

    protected $wechat;

    protected $openid;

    public function __construct($wechat, $wechat_id, $openid)
    {
        $this->wechat_id = $wechat_id;
        $this->wechat = $wechat;
        $this->openid = $openid;
    }

    /**
     * 发送素材消息
     * @param $id
     */
    public function sendMediaMessage($id)
    {
        $model = WechatMediaModel::where('wechat_id', $this->wechat_id)->find($id);
        if ( ! empty($model)) {
            switch ($model->type) {
                case 'image':
                    return $this->sendImageMessage($model->media_id, $model);
                    break;

                case 'voice':
                    return $this->sendVoiceMessage();
                    break;

                case 'video':
                    return $this->sendVedioMessage();
                    break;

                case 'news':
                    return $this->sendMpnewsMessage();
                    break;

                default:
                    break;
            }
        }
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
    public function sendImageMessage($media_id, $model = null)
    {
        $content = ['media_id' => $media_id];

        $message = new Image($content);

        $result = $this->wechat->staff->message($message)->to($this->openid)->send();

        if (! is_null($model)) {
            $content['img_url'] = \RC_Upload::upload_url($model->file);
        }

        WechatRecord::replyMsg($this->openid, '发送图片消息', 'image', $content);

        return $result;
    }

    /**
     * 发送语音消息
     */
    public function sendVoiceMessage($media_id, $model = null)
    {
        $content = ['media_id' => $media_id];

        $message = new Voice($content);

        $result = $this->wechat->staff->message($message)->to($this->openid)->send();

        if (! is_null($model)) {
            $content['voice_url'] = \RC_Upload::upload_url($model->file);
        }

        WechatRecord::replyMsg($this->openid, '发送语音消息', 'voice', $content);

        return $result;
    }

    /**
     * 发送视频消息
     */
    public function sendVideoMessage($media_id, $model = null)
    {
        $content = [
            'media_id' => $media_id,
            'thumb_media_id' => $model->thumb,
            'title' => $model->title,
            'description' => $model->digest,
        ];

        $message = new Video($content);

        $result = $this->wechat->staff->message($message)->to($this->openid)->send();

        if (! is_null($model)) {
            $content['video_url'] = \RC_Upload::upload_url($model->file);
        }

        WechatRecord::replyMsg($this->openid, '发送视频消息', 'video', $content);

        return $result;
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
    public function sendMpnewsMessage($media_id, $model = null)
    {
        $content = [
            'media_id' => $media_id
        ];

        $message = new Mpnews($content);

        $result = $this->wechat->staff->message($message)->to($this->openid)->send();

        WechatRecord::replyMsg($this->openid, '发送图文消息（点击跳转到图文消息页面）', 'mpnews', $content);

        return $result;
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