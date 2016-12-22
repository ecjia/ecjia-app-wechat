<?php

/**
 * @file
 *
 * WeChat Response
 */

class wechat_response {
    /**
     * 回复文本消息
     */
    public static function Text_reply($request, $text) {
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'text',
            'Content'       => $text
        );
        RC_Loader::load_app_class('wechat_method', 'wechat', false);
        wechat_method::record_msg($request->getParameter('FromUserName'), $text, 1);
        return $content;
    }
    
    /**
     * 回复图片消息
     */
    public static function Image_reply($request, $file) {
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'image',
            'Image'         => array(
                'MediaId' => $file //通过素材管理接口上传多媒体文件，得到的id。
            )
        );
        RC_Loader::load_app_class('wechat_method', 'wechat', false);
        wechat_method::record_msg($request->getParameter('FromUserName'), RC_Lang::get('wechat::wechat.image_content'), 1);
        return $content;
    }
    
    /**
     * 回复语音消息
     */
    public static function Voice_reply($request, $file) {
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'voice',
            'Voice'         => array(
                'MediaId' => $file //通过素材管理接口上传多媒体文件，得到的id。
            )
        );
        RC_Loader::load_app_class('wechat_method', 'wechat', false);
        wechat_method::record_msg($request->getParameter('FromUserName'), RC_Lang::get('wechat::wechat.voice_content'), 1);
        return $content;
    }
    
    /**
     * 回复视频消息
     */
    public static function Video_reply($request, $file, $title, $digest) {
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'video',
            'Video' => array(
                'MediaId'       => $file,
                'Title'         => $title,
                'Description'   => $digest
            )
        );
        RC_Loader::load_app_class('wechat_method', 'wechat', false);
        wechat_method::record_msg($request->getParameter('FromUserName'), RC_Lang::get('wechat::wechat.video_content'), 1);
        return $content;
    }
}

// end
