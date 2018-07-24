<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/24
 * Time: 5:07 PM
 */

namespace Ecjia\App\Wechat\Sends;


class BroadcastSendMessage
{

    protected $wechat_id;

    protected $wechat;


    public function __construct($wechat, $wechat_id, $openid)
    {
        $this->wechat_id = $wechat_id;
        $this->wechat = $wechat;
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
                    return $this->sendVoiceMessage($model->media_id, $model);
                    break;

                case 'video':
                    return $this->sendVideoMessage($model->media_id, $model);
                    break;

                case 'news':
                    return $this->sendMpnewsMessage($model->media_id, $model);
                    break;

                default:
                    break;
            }
        }
    }


    /**
     * 发送文本消息
     */
    public function sendTextMessage($msg)
    {


    }

    /**
     * 发送图片消息
     */
    public function sendImageMessage($media_id, $model = null)
    {


    }


    /**
     * 发送语音消息
     */
    public function sendVoiceMessage($media_id, $model = null)
    {
        

    }


    /**
     * 发送视频消息
     */
    public function sendVideoMessage($media_id, $model = null)
    {


    }


    /**
     * 发送音乐消息
     */
    public function sendMusicMessage()
    {

    }


    /**
     * 发送图文消息（点击跳转到外链）
     */
    public function sendNewsMessage()
    {

    }


    /**
     * 发送图文消息（点击跳转到图文消息页面）
     */
    public function sendMpnewsMessage($media_id, $model = null)
    {


    }


    /**
     * 发送卡券
     */
    public function sendWxcardMessage()
    {

    }


}