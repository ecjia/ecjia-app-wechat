<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

return array(
    'platform_mass_message_page' => array(
        'preview_content_required'  => __('请先输入要预览的内容', 'wechat'),
        'preview_material_required' => __('请先选择要预览的素材', 'wechat'),
        'preview_account_required'  => __('请输入预览的账号', 'wechat'),
        'ok'                        => __('确定', 'wechat')
    ),
    'choose_material_page'       => array(
        'delete' => '删除'
    ),
    'platform_customer_page'     => array(
        'ok'                  => '确定',
        'cancel'              => '取消',
        'status_edit_success' => '状态修改成功',
        'kf_account_required' => '请输入客服账号',
        'kf_nick_required'    => '请输入客服昵称',
        'password_required'   => '请输入客服密码',
        'kf_wx_required'      => '请输入需要绑定的微信账号',
    ),
    'platform_material_page'     => array(
        'upload_images_area'        => '将图片拖动至此处上传',
        'upload_mp3_area'           => '将语音拖动至此处上传（格式：mp3）',
        'title_placeholder'         => '请输入标题',
        'title_placeholder_title'   => '请输入视频标题',
        'graphic'                   => '图文',
        'clone_no_parent'           => 'clone-obj方法未设置data-parent参数。',
        'title'                     => '标题',
        'thumbnail'                 => '缩略图',
        'batch_less_parameter'      => '批量操作缺少参数！',
        'images_most8'              => '图文最多只能添加8条',
        'img_priview'               => '图片预览',
        'remove_material_cover'     => '您确定要删除该封面素材吗？',
        'title_placeholder_graphic' => '请输入图文标题',
        'ok'                        => '确定',
        'cancel'                    => '取消',
    ),
    'platform_menus_page'        => array(
        'ok'              => '确定',
        'cancel'          => '取消',
        'content_require' => '消息内容不能为空',
    ),
    'platform_message_page'      => array(
        'ok'                 => '确定',
        'cancel'             => '取消',
        'getting'            => '正在获取中...',
        'get_user_tag'       => '获取用户标签',
        'get_user_info'      => '获取用户信息',
        'tag_name_required'  => '请输入标签名称',
        'tag_name_maxlength' => '不得超过6个汉字或6个字符',
        'pls_select_user'    => '请先选择用户',
    ),
    'platform_prize_page'        => array(
        'content_require' => '消息内容不能为空',
    ),
    'platform_qrcode_page'       => array(
        'application_adsense_required' => '请填写应用场景',
        'qrcode_funcions_empty'        => '请选择或填写关键词',
    ),
    'platform_record_page'       => array(
        'getting'             => '正在获取中...',
        'get_customer_record' => '获取客服聊天记录',
    ),
    'platform_request_page'      => array(
        'unfind_any_record'  => '没有找到任何记录',
        'Monday'             => '星期一',
        'Tuesday'            => '星期二',
        'Wednesday'          => '星期三',
        'Thursday'           => '星期四',
        'Friday'             => '星期五',
        'Saturday'           => '星期六',
        'Sunday'             => '星期日',
        'num'                => '次',
        'num_time'           => '次数',
        'get_message_record' => '获取客服聊天记录',
    ),
    'platform_response_page'     => array(
        'rule_name_required'     => '请填写规则名称',
        'rule_keywords_required' => '请至少填写1个关键词',
    ),
    'platform_share_page'        => array(
        'qrcode_username_required' => '请填写推荐人',
        'qrcode_scene_id_required' => '请填写推荐人ID',
        'qrcode_funcions_required' => '请填写功能',
    ),
    'platform_subscribe_page'    => array(
        'ok'                 => '确定',
        'cancel'             => '取消',
        'getting'            => '正在获取中...',
        'get_user_tag'       => '获取用户标签',
        'get_user_info'      => '获取用户信息',
        'tag_name_required'  => '请输入标签名称',
        'tag_name_maxlength' => '不得超过6个汉字或6个字符',
        'pls_select_user'    => '请先选择用户',
    ),
    'mobile_profile_page'        => array(
        'bind_mobile_first ' => '请先绑定手机号',
        'resend'             => '重新发送',
        'resend_s'           => '重新发送 %s (s)',
    )
);

// end