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

/**
 * ECJIA抽奖记录
 */
class platform_prize extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global');
        Ecjia\App\Wechat\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');

        RC_Script::enqueue_script('wechat_prize', RC_App::apps_url('statics/platform-js/wechat_prize.js', __FILE__), array(), false, true);

        RC_Script::localize_script('wechat_prize', 'js_lang', config('app-wechat::jslang.platform_prize_page'));

        ecjia_platform_screen::get_current_screen()->set_subject(__('抽奖记录', 'wechat'));
    }

    /**
     * 抽奖记录页面
     */
    public function init()
    {
        $this->admin_priv('wechat_prize_manage');

        $this->assign('ur_here', __('抽奖记录列表', 'wechat'));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('抽奖记录', 'wechat')));

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', __('请先添加公众号，再进行后续操作', 'wechat'));
        } else {
            $this->assign('warn', 'warn');
            $this->assign('form_action', RC_Uri::url('wechat/platform_prize/init'));

            $list = $this->get_prize();
            $this->assign('list', $list);

            //获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
            $types = $this->platformAccount->getType();
            $this->assign('type', $types);
        }
        $wechat_type = array(__('未认证的公众号', 'wechat'), __('订阅号', 'wechat'), __('服务号', 'wechat'), __('测试账号', 'wechat'), __('企业号', 'wechat'));

        $this->assign('type_error', sprintf(__('抱歉！您当前公众号属于%s类型，该模块目前只支持“认证订阅号”和“认证服务号”类型的公众号。', 'wechat'), $wechat_type[$types]));
        return $this->display('wechat_prize_list.dwt');
    }

    /**
     * 发放奖品
     */
    public function winner_issue()
    {
        $this->admin_priv('wechat_prize_manage', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();
        $id        = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $cancel    = isset($_GET['cancel']) ? intval($_GET['cancel']) : 0;
        $type      = isset($_GET['type']) ? $_GET['type'] : '';

        $url = RC_Uri::url('wechat/platform_prize/init');
        if ($type) {
            $url = RC_Uri::url('wechat/platform_prize/init', array('type' => $type));
        }
        if (!empty($cancel)) {
            $data['issue_status'] = 0;
            $message              = __('取消成功', 'wechat');
        } else {
            $data['issue_status'] = 1;
            $message              = __('发放成功', 'wechat');
        }

        RC_DB::table('wechat_prize')->where('wechat_id', $wechat_id)->where('id', $id)->update($data);
        return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
    }

    /**
     * 删除记录
     */
    public function remove()
    {
        $this->admin_priv('wechat_prize_manage', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();
        $id        = !empty($_GET['id']) ? intval($_GET['id']) : 0;

        RC_DB::table('wechat_prize')->where('wechat_id', $wechat_id)->where('id', $id)->delete();
        return $this->showmessage(__('删除成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 发送消息通知用户
     */
    public function send_message()
    {
        $this->admin_priv('wechat_custom_message_add', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(__('发送失败，请先添加公众号,再进行后续操作', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $openid      = !empty($_POST['openid']) ? $_POST['openid'] : '';
        $data['msg'] = !empty($_POST['message_content']) ? $_POST['message_content'] : '';
        $data['uid'] = !empty($_POST['uid']) ? intval($_POST['uid']) : 0;

        if (empty($openid)) {
            return $this->showmessage(__('请选择微信用户', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($data['msg'])) {
            return $this->showmessage(__('消息内容不能为空', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $data['send_time'] = RC_Time::gmtime();
        $data['iswechat']  = 1;

        // 微信端发送消息
        $msg    = array(
            'touser'  => $openid,
            'msgtype' => 'text',
            'text'    => array(
                'content' => $data['msg'],
            ),
        );
        $uuid   = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        try {
            with(new Ecjia\App\Wechat\Sends\SendCustomMessage($wechat, $wechat_id, $openid))->sendTextMessage($data['msg']);

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        // 添加数据
        $message_id = RC_DB::table('custom_message')->insertGetId($data);

        $this->admin_log($data['msg'], 'send', 'subscribe_message');
        if ($message_id) {
            return $this->showmessage(__('发送成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_prize/init')));
        } else {
            return $this->showmessage(__('发送失败', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

    }

    /**
     * 获取抽奖记录信息
     */
    private function get_prize()
    {
        $wechat_id = $this->platformAccount->getAccountID();
        $db        = RC_DB::table('wechat_prize')->where('wechat_id', $wechat_id)->where('prize_type', 1);

        $activity_type = !empty($_GET['type']) ? trim($_GET['type']) : '';
        if ($activity_type) {
            $db->where('activity_type', $activity_type);
        }
        $count = $db->count();
        $page  = new ecjia_platform_page($count, 10, 5);
        $data  = $db->orderBy('dateline', 'desc')->take(10)->skip($page->start_id - 1)->get();

        $arr = array();
        if (isset($data)) {
            foreach ($data as $row) {
                $info            = RC_DB::table('wechat_user')->where('wechat_id', $wechat_id)->where('openid', $row['openid'])->first();
                $row['winner']   = unserialize($row['winner']);
                $row['nickname'] = $info['nickname'];
                $row['uid']      = $info['uid'];
                $row['dateline'] = RC_Time::local_date(ecjia::config('time_format'), $row['dateline'] - 8 * 3600);
                $arr[]           = $row;
            }
        }
        return array('prize_list' => $arr, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
}

//end
