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
 * ECJIA客服管理
 */
class platform_customer extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        RC_Loader::load_app_func('global');
        Ecjia\App\Wechat\Helper::assign_adminlog_content();

        /* 加载全局 js/css */
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('bootstrap-placeholder');

        RC_Script::enqueue_script('wechat_customer', RC_App::apps_url('statics/platform-js/wechat_customer.js', __FILE__), array(), false, true);
        RC_Style::enqueue_style('admin_customer', RC_App::apps_url('statics/css/admin_customer.css', __FILE__));
        RC_Style::enqueue_style('hint.min', RC_Uri::admin_url('statics/lib/hint_css/hint.min.css'));

        RC_Script::enqueue_script('ecjia-platform-bootstrap-fileupload-js');
        RC_Style::enqueue_style('ecjia-platform-bootstrap-fileupload-css');

        RC_Script::localize_script('wechat_customer', 'js_lang', config('app-wechat::jslang.platform_customer_page'));

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客服管理', 'wechat'), RC_Uri::url('wechat/platform_customer/init')));
        ecjia_platform_screen::get_current_screen()->set_subject(__('客服管理', 'wechat'));
    }

    /**
     * 客服账号列表
     */
    public function init()
    {
        $this->admin_priv('wechat_customer_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客服账号', 'wechat')));
        $this->assign('ur_here', __('客服账号列表', 'wechat'));
        $this->assign('action_link', array('text' => __('添加客服账号', 'wechat'), 'href' => RC_Uri::url('wechat/platform_customer/add')));

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', __('请先添加公众号，再进行后续操作', 'wechat'));
        } else {
            $this->assign('warn', 'warn');
            $type        = $this->platformAccount->getType();
            $wechat_type = array(__('未认证的公众号', 'wechat'), __('订阅号', 'wechat'), __('服务号', 'wechat'), __('测试账号', 'wechat'), __('企业号', 'wechat'));

            $this->assign('type', $type);
            $this->assign('type_error', sprintf(__('抱歉！您的公众号属于%s类型，该模块目前只支持“认证服务号”类型的公众号。', 'wechat'), $wechat_type[$type]));

            $list = $this->get_list();
            $this->assign('list', $list);
        }

        return $this->display('wechat_customer_list.dwt');
    }

    public function add()
    {
        $this->admin_priv('wechat_customer_add');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加客服账号', 'wechat')));
        $this->assign('ur_here', __('添加客服账号', 'wechat'));
        $this->assign('action_link', array('href' => RC_Uri::url('wechat/platform_customer/init'), 'text' => __('客服账号列表', 'wechat')));

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', __('请先添加公众号，再进行后续操作', 'wechat'));
        } else {
            $this->assign('warn', 'warn');
            $type        = $this->platformAccount->getType();
            $wechat_type = array(__('未认证的公众号', 'wechat'), __('订阅号', 'wechat'), __('服务号', 'wechat'), __('测试账号', 'wechat'), __('企业号', 'wechat'));

            $this->assign('action', 'add');
            $this->assign('type', $type);
            $this->assign('type_error', sprintf(__('抱歉！您的公众号属于%s类型，该模块目前只支持“认证服务号”类型的公众号。', 'wechat'), $wechat_type[$type]));

            $this->assign('list', array('status' => 1));
            $this->assign('form_action', RC_Uri::url('wechat/platform_customer/insert'));
        }

        return $this->display('wechat_customer_edit.dwt');
    }

    public function insert()
    {
        $this->admin_priv('wechat_customer_add', ecjia::MSGTYPE_JSON);

        $kf_account = !empty($_POST['kf_account']) ? trim($_POST['kf_account']) : '';
        $nickname   = !empty($_POST['kf_nick']) ? trim($_POST['kf_nick']) : '';
        $status     = !empty($_POST['status']) ? intval($_POST['status']) : 0;

        $wechat_id = $this->platformAccount->getAccountID();

        $uuid   = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        //最多只能添加10个客服
        $count = RC_DB::table('wechat_customer')->where('wechat_id', $wechat_id)->count();
        if ($count >= 10) {
            return $this->showmessage(__('最多添加10个客服账号', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //判断客服账号是否重复
        $num = RC_DB::table('wechat_customer')->where('wechat_id', $wechat_id)->where('kf_account', $kf_account)->count();
        if ($num != 0) {
            return $this->showmessage(__('客服账号已存在', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $data = array(
            'wechat_id'  => $wechat_id,
            'kf_account' => $kf_account,
            'kf_nick'    => $nickname,
            'status'     => $status,
        );

        //如果为开启状态 则微信端添加
        if ($status == 1) {
            //微信端添加客服账号
            try {
                $wechat->staff->create($kf_account, $nickname);
            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $id = RC_DB::table('wechat_customer')->insertGetId($data);

        $this->admin_log($kf_account, 'add', 'customer');
        $links[] = array('text' => __('返回客服账号列表', 'wechat'), 'href' => RC_Uri::url('wechat/platform_customer/init'));
        $links[] = array('text' => __('继续添加客服账号', 'wechat'), 'href' => RC_Uri::url('wechat/platform_customer/add'));

        return $this->showmessage(__('添加客服账号成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('wechat/platform_customer/edit', array('id' => $id))));
    }

    /**
     * 编辑客服账号页面
     */
    public function edit()
    {
        $this->admin_priv('wechat_customer_update');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑客服账号', 'wechat')));
        $this->assign('ur_here', __('编辑客服账号', 'wechat'));
        $this->assign('action_link', array('href' => RC_Uri::url('wechat/platform_customer/init'), 'text' => __('客服账号列表', 'wechat')));

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', __('请先添加公众号，再进行后续操作', 'wechat'));
        } else {
            $this->assign('warn', 'warn');
        }
        $type        = $this->platformAccount->getType();
        $wechat_type = array(__('未认证的公众号', 'wechat'), __('订阅号', 'wechat'), __('服务号', 'wechat'), __('测试账号', 'wechat'), __('企业号', 'wechat'));

        $this->assign('type', $type);
        $this->assign('type_error', sprintf(__('抱歉！您的公众号属于%s类型，该模块目前只支持“认证服务号”类型的公众号。', 'wechat'), $wechat_type[$type]));

        $id   = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $list = RC_DB::table('wechat_customer')->where('id', $id)->first();

        if ($list['kf_headimgurl']) {
            $str = '.jpg';
            $arr = explode($str, $list['kf_headimgurl']);
            if (!$arr[count($arr) - 1] == "") {
                $list['kf_headimgurl'] = $list['kf_headimgurl'];
            } else {
                $list['kf_headimgurl'] = RC_Upload::local_upload_url($list['kf_headimgurl']);
            }
        }
        $this->assign('list', $list);
        $this->assign('form_action', RC_Uri::url('wechat/platform_customer/update'));

        return $this->display('wechat_customer_edit.dwt');
    }

    /**
     * 编辑客服处理
     */
    public function update()
    {
        $this->admin_priv('wechat_customer_update', ecjia::MSGTYPE_JSON);

        $id         = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $kf_account = !empty($_POST['kf_account']) ? trim($_POST['kf_account']) : '';
        $nickname   = !empty($_POST['kf_nick']) ? trim($_POST['kf_nick']) : '';

        $info   = RC_DB::table('wechat_customer')->where('id', $id)->first();
        $status = !empty($_POST['status']) ? intval($_POST['status']) : 0;

        $wechat_id = $this->platformAccount->getAccountID();

        $uuid   = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        //判断客服账号是否重复
        $num = RC_DB::table('wechat_customer')->where('wechat_id', $wechat_id)->where('kf_account', $kf_account)->where('id', '!=', $id)->count();
        if ($num != 0) {
            return $this->showmessage(__('客服账号已存在', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //获取原来的图片文件
        $old_kfimgurl = $info['kf_headimgurl'];

        try {
            if ($info['status'] == 0) {
                if ($status == 1) {
                    //微信端添加客服账号
                    $wechat->staff->create($kf_account, $nickname);

                    if (!empty($old_kfimgurl)) {
                        //微信端添加客服头像
                        $imgurl = RC_Upload::local_upload_path() . $old_kfimgurl;
                        $wechat->staff->avatar($kf_account, $imgurl);
                    }
                }
            } else {
                if ($status == 0) {
                    //微信端删除客服账号
                    $wechat->staff->delete($kf_account);
                } else {
                    //微信端更新客服账号
                    $wechat->staff->update($kf_account, $nickname);
                }
            }

            if ((isset($_FILES['kf_headimgurl']['error']) && $_FILES['kf_headimgurl']['error'] == 0) || (!isset($_FILES['kf_headimgurl']['error']) && isset($_FILES['kf_headimgurl']['tmp_name']) && $_FILES['kf_headimgurl']['tmp_name'] != 'none')) {
                $upload     = RC_Upload::uploader('image', array('save_path' => 'data/headimg', 'auto_sub_dirs' => false));
                $upload->setStorageDisk(RC_Storage::disk('local'));

                $image_info = $upload->upload($_FILES['kf_headimgurl']);
                if (!empty($image_info)) {
                    $kf_headimgurl = $upload->get_position($image_info);
                    if ($status == 1) {
                        if ($info['status'] == 1) {
                            //微信端添加客服头像
                            $imgurl = RC_Upload::local_upload_path() . $kf_headimgurl;
                            $wechat->staff->avatar($kf_account, $imgurl);
                        }
                    }
                    //删除原来的图片文件
                    if (!empty($old_kfimgurl)) {
                        $upload->remove($old_kfimgurl);
                    }
                }
            } else {
                $kf_headimgurl = $old_kfimgurl;
            }

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'kf_account'    => $kf_account,
            'kf_nick'       => $nickname,
            'status'        => $status,
            'kf_headimgurl' => $kf_headimgurl,
        );

        RC_DB::table('wechat_customer')->where('id', $id)->update($data);

        $this->admin_log($kf_account, 'edit', 'customer');
        return $this->showmessage(__('编辑客服账号成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_customer/edit', array('id' => $id))));
    }

    public function remove()
    {
        $this->admin_priv('wechat_customer_delete', ecjia::MSGTYPE_JSON);

        $uuid      = $this->platformAccount->getUUID();
        $wechat    = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
        $wechat_id = $this->platformAccount->getAccountID();

        $id   = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $info = RC_DB::table('wechat_customer')->where('id', $id)->where('wechat_id', $wechat_id)->first();

        if ($info['status'] == 1) {
            //微信端删除客服账号
            try {
                $wechat->staff->delete($info['kf_account']);
            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        $disk = RC_Filesystem::disk('local');
        $disk->delete(RC_Upload::local_upload_path() . $info['kf_headimgurl']);

        RC_DB::table('wechat_customer')->where('id', $id)->where('wechat_id', $wechat_id)->delete();

        $this->admin_log($info['kf_account'], 'remove', 'customer');
        return $this->showmessage(__('删除客服账号成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function get_customer()
    {
        $this->admin_priv('wechat_customer_manage', ecjia::MSGTYPE_JSON);

        $this->load_kf_list();
        return $this->showmessage(__('获取客服信息成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_customer/init')));
    }

    public function get_online_customer()
    {
        $this->admin_priv('wechat_customer_manage', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(__('请先添加公众号，再进行后续操作', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $uuid   = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $kf_account_list = RC_DB::table('wechat_customer')->where('wechat_id', $wechat_id)->lists('kf_account');

        try {
            $list = $wechat->staff->onlines();
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $db_wechat_customer = RC_DB::table('wechat_customer');
        if (!empty($list)) {
            foreach ($list['kf_online_list'] as $key => $val) {
                $kf_list[] = $val['kf_account'];
            }

            //更新微信端获取不到的客服 本地在线状态变更为0
            if (!empty($kf_list)) {
                if (empty($kf_account_list)) {
                    $kf_account_list = array();
                }
                $arr = array_diff($kf_account_list, $kf_list);
                $db_wechat_customer->where('wechat_id', $wechat_id)->whereRaw('kf_account' . ecjia_db_create_in($arr));
            } else {
                $db_wechat_customer->where('wechat_id', $wechat_id);
            }
            $db_wechat_customer->update(array('online_status' => 0));

            if (!empty($list['kf_online_list'])) {
                foreach ($list['kf_online_list'] as $k => $v) {
                    if (in_array($v['kf_account'], $kf_account_list)) {
                        $data['online_status'] = $v['status'];
                        $data['kf_id']         = $v['kf_id'];
                        $data['accepted_case'] = $v['accepted_case'];
                        RC_DB::table('wechat_customer')->where('kf_account', $v['kf_account'])->where('wechat_id', $wechat_id)->update($data);
                    } else {
                        $data['kf_account']    = $v['kf_account'];
                        $data['kf_id']         = $v['kf_id'];
                        $data['online_status'] = $v['status'];
                        $data['accepted_case'] = $v['accepted_case'];
                        $data['wechat_id']     = $wechat_id;
                        RC_DB::table('wechat_customer')->insert($data);
                    }
                }
            }
        }
        return $this->showmessage(__('获取在线客服成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_customer/init')));
    }

    public function toggle_show()
    {
        $this->admin_priv('wechat_customer_update', ecjia::MSGTYPE_JSON);

        $uuid      = $this->platformAccount->getUUID();
        $wechat    = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
        $wechat_id = $this->platformAccount->getAccountID();

        $id   = intval($_POST['id']);
        $val  = intval($_POST['val']);
        $info = RC_DB::table('wechat_customer')->where('id', $id)->where('wechat_id', $wechat_id)->first();

        try {
            if ($val == 1) {
                //微信端添加客服账号
                $wechat->staff->add($info['kf_account'], $info['kf_nick']);
                $action = 'use';
            } else {
                //微信端删除客服账号
                $wechat->staff->delete($info['kf_account']);
                $action = 'stop';
            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $this->admin_log($info['kf_account'], $action, 'customer');
        $data = array(
            'status'             => $val,
            'kf_wx'              => '',
            'invite_wx'          => '',
            'invite_expire_time' => 0,
            'invite_status'      => '',
        );
        RC_DB::table('wechat_customer')->where('id', $id)->where('wechat_id', $wechat_id)->update($data);
        return $this->showmessage(__('切换成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_customer/init')));
    }

    public function edit_nick()
    {
        $this->admin_priv('wechat_customer_update', ecjia::MSGTYPE_JSON);

        $uuid   = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $data['kf_nick'] = !empty($_POST['value']) ? $_POST['value'] : '';
        $id              = !empty($_POST['pk']) ? $_POST['pk'] : '';
        $info            = RC_DB::table('wechat_customer')->where('id', $id)->first();

        if (empty($data['kf_nick'])) {
            return $this->showmessage(__('客服昵称不能为空', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($info['status'] == 1) {
            //微信端更新客服账号
            try {
                $wechat->staff->update($info['kf_account'], $data['kf_nick']);
            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        RC_DB::table('wechat_customer')->where('id', $id)->update($data);
        $this->admin_log($info['kf_account'], 'edit', 'customer');
        return $this->showmessage(__('编辑昵称成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    //客服消息记录
    public function customer_message()
    {
        $this->admin_priv('wechat_customer_message_manage');

        $wechat_id = $this->platformAccount->getAccountID();

        $this->assign('ur_here', __('客服消息记录', 'wechat'));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客服消息记录', 'wechat')));
        $this->assign('action_link', array('text' => __('客服账号列表', 'wechat'), 'href' => RC_Uri::url('wechat/platform_customer/init')));

        $type        = $this->platformAccount->getType();
        $wechat_type = array(__('未认证的公众号', 'wechat'), __('订阅号', 'wechat'), __('服务号', 'wechat'), __('测试账号', 'wechat'), __('企业号', 'wechat'));

        $this->assign('type', $type);
        $this->assign('type_error', sprintf(__('抱歉！您的公众号属于%s类型，该模块目前只支持“认证服务号”类型的公众号。', 'wechat'), $wechat_type[$type]));

        return $this->display('wechat_customer_message.dwt');
    }

    //绑定微信号
    public function bind_wx()
    {
        $kf_account = !empty($_POST['kf_account']) ? $_POST['kf_account'] : '';
        $kf_wx      = !empty($_POST['kf_wx']) ? trim($_POST['kf_wx']) : '';
        $id         = intval($_GET['id']);
        $wechat_id  = $this->platformAccount->getAccountID();

        if (empty($kf_wx)) {
            return $this->showmessage(__('绑定的客服人员微信号不能为空', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $uuid   = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $data = RC_DB::table('wechat_customer')->where('kf_account', $kf_account)->where('wechat_id', $wechat_id)->first();

        try {
            if (empty($data['status'])) {
                $wechat->staff->create($kf_account, $data['kf_nick']);
            }
            $wechat->staff->invite($kf_account, $kf_wx);

        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_DB::table('wechat_customer')->where('wechat_id', $wechat_id)->where('kf_account', $kf_account)->update(array('invite_wx' => $kf_wx, 'invite_status' => '', 'status' => 1));

        $this->load_kf_list();
        $pjaxurl = RC_Uri::url('wechat/platform_customer/init');
        if (!empty($id)) {
            $pjaxurl = RC_Uri::url('wechat/platform_customer/edit', array('id' => $id));
        }
        return $this->showmessage(__('邀请成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
    }

    //客服会话
    public function session()
    {
        $this->admin_priv('wechat_customer_session_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('客服会话', 'wechat')));
        $this->assign('ur_here', __('客服会话', 'wechat'));

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', __('请先添加公众号，再进行后续操作', 'wechat'));
        } else {
            $this->assign('warn', 'warn');
            //获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
            $types       = $this->platformAccount->getType();
            $wechat_type = array(__('未认证的公众号', 'wechat'), __('订阅号', 'wechat'), __('服务号', 'wechat'), __('测试账号', 'wechat'), __('企业号', 'wechat'));

            $this->assign('type', $types);
            $this->assign('type_error', sprintf(__('抱歉！您的公众号属于%s类型，该模块目前只支持“认证服务号”类型的公众号。', 'wechat'), $wechat_type[$types]));
        }

        $list = $this->get_session_list();
        $this->assign('list', $list);

        return $this->display('wechat_customer_session.dwt');
    }

    //获取未接入的客服会话
    public function get_customer_session()
    {
        $this->admin_priv('wechat_customer_session_update', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $uuid   = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
        $status = intval($_GET['status']);

        try {
            $list = $wechat->staff_session->waiters()->toArray();

            with(new \Ecjia\App\Wechat\Synchronizes\WaitCustomerSessionStorage($wechat_id, collect($list)))->save();

            return $this->showmessage(__('获取成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_customer/session', array('status' => $status))));
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

    }

    //获取客服会话
    public function get_session()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $uuid   = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $kf_account = trim($_GET['kf_account']);

        if (empty($kf_account)) {
            return $this->showmessage(__('请选择客服账号', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        try {
            $list = $wechat->staff_session->lists($kf_account)->toArray();

            with(new \Ecjia\App\Wechat\Synchronizes\CustomerSessionStorage($wechat_id, collect($list), $kf_account))->save();

            return $this->showmessage(__('获取成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    //创建会话
    public function create_session()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $uuid   = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $openid     = trim($_POST['openid']);
        $kf_account = trim($_POST['kf_account']);

        if (empty($openid)) {
            return $this->showmessage(__('请选择用户', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (empty($kf_account)) {
            return $this->showmessage(__('请选择客服账号', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        try {
            $wechat->staff_session->create($kf_account, $openid);
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = array(
            'wechat_id'   => $wechat_id,
            'kf_account'  => $kf_account,
            'openid'      => $openid,
            'create_time' => RC_Time::gmtime(),
            'status'      => 1,
        );
        RC_DB::table('wechat_customer_session')->insert($data);
        return $this->showmessage(__('创建成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    //关闭会话
    public function close_session()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $uuid   = $this->platformAccount->getUUID();
        $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

        $id = intval($_GET['id']);
        if (empty($id)) {
            return $this->showmessage(__('请选择要关闭的会话', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data = RC_DB::table('wechat_customer_session')->where('wechat_id', $wechat_id)->where('id', $id)->first();

        try {
            $wechat->staff_session->close($data['kf_account'], $data['openid']);
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        RC_DB::table('wechat_customer_session')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('status' => 3));
        return $this->showmessage(__('关闭成功', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 获取客服列表
     */
    private function get_list()
    {
        $wechat_id   = $this->platformAccount->getAccountID();
        $db_customer = RC_DB::table('wechat_customer')->where('wechat_id', $wechat_id);

        if (isset($_GET['type'])) {
            $db_customer->where('online_status', '!=', 0);
        }
        $list = $db_customer->get();

        $filter['all']    = RC_DB::table('wechat_customer')->where('wechat_id', $wechat_id)->count();
        $filter['online'] = RC_DB::table('wechat_customer')->where('wechat_id', $wechat_id)->where('online_status', '!=', 0)->count();

        if (!empty($list)) {
            foreach ($list as $k => $v) {
                if (!empty($v['kf_headimgurl'])) {
                    if ((strpos($v['kf_headimgurl'], 'http://') === false) && (strpos($v['kf_headimgurl'], 'https://') === false)) {
                        $list[$k]['kf_headimgurl'] = RC_Upload::local_upload_url($v['kf_headimgurl']);
                    } else {
                        $list[$k]['kf_headimgurl'] = is_ssl() ? str_replace('http://', 'https://', $v['kf_headimgurl']) : $v['kf_headimgurl'];
                    }
                } else {
                    $list[$k]['kf_headimgurl'] = RC_Uri::admin_url('statics/images/nopic.png');
                }
                if ($v['invite_expire_time']) {
                    $list[$k]['invite_expire_time'] = RC_Time::local_date(ecjia::config('time_format'), $v['invite_expire_time'] - 8 * 3600);
                }
            }
        }
        return array('item' => $list, 'filter' => $filter);
    }

    /**
     * 刷新客服列表信息
     */
    private function load_kf_list()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(__('请先添加公众号，再进行后续操作', 'wechat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $uuid            = $this->platformAccount->getUUID();
        $wechat          = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();
        $kf_account_list = RC_DB::table('wechat_customer')->where('wechat_id', $wechat_id)->lists('kf_account');

        try {
            $list = $wechat->staff->lists();
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage(\Ecjia\App\Wechat\WechatErrorCodes::getError($e->getCode(), $e->getMessage()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if (!empty($list)) {
            foreach ($list['kf_list'] as $key => $val) {
                $kf_list[] = $val['kf_account'];
            }
            $db_wechat_customer = RC_DB::table('wechat_customer');
            //更新微信端获取不到的客服 本地状态变更为0
            if (!empty($kf_list)) {
                if (empty($kf_account_list)) {
                    $kf_account_list = array();
                }
                $arr = array_diff($kf_account_list, $kf_list);
                $db_wechat_customer->where('wechat_id', $wechat_id)->whereRaw('kf_account' . ecjia_db_create_in($arr));
            } else {
                $db_wechat_customer->where('wechat_id', $wechat_id);
            }
            $db_wechat_customer->update(array('status' => 0));

            foreach ($list['kf_list'] as $k => $v) {
                if (in_array($v['kf_account'], $kf_account_list)) {
                    $data['status']  = 1;
                    $data['kf_id']   = $v['kf_id'];
                    $data['kf_nick'] = $v['kf_nick'];
                    $data['kf_wx']   = !empty($v['kf_wx']) ? $v['kf_wx'] : '';

                    $data['invite_wx']          = !empty($v['invite_wx']) ? $v['invite_wx'] : '';
                    $data['invite_expire_time'] = !empty($v['invite_expire_time']) ? $v['invite_expire_time'] : 0;
                    $data['invite_status']      = !empty($v['invite_status']) ? $v['invite_status'] : '';
                    $data['kf_headimgurl']      = is_ssl() && !empty($v['kf_headimgurl']) ? str_replace('http://', 'https://', $v['kf_headimgurl']) : $v['kf_headimgurl'];

                    //微信端存在头像 删除本地头像
                    if (!empty($data['kf_headimgurl'])) {
                        $info = RC_DB::table('wechat_customer')->where('kf_account', $v['kf_account'])->where('wechat_id', $wechat_id)->first();

                        if (!empty($info['kf_headimgurl'])) {
                            if ((strpos($info['kf_headimgurl'], 'http://') === false) && (strpos($info['kf_headimgurl'], 'https://') === false)) {
                                $disk = RC_Filesystem::disk('local');
                                $disk->delete(RC_Upload::local_upload_path() . $info['kf_headimgurl']);
                            }
                        }
                    }
                    RC_DB::table('wechat_customer')->where('kf_account', $v['kf_account'])->where('wechat_id', $wechat_id)->update($data);
                } else {
                    $data['kf_id']         = $v['kf_id'];
                    $data['kf_account']    = $v['kf_account'];
                    $data['kf_nick']       = $v['kf_nick'];
                    $data['kf_wx']         = !empty($v['kf_wx']) ? $v['kf_wx'] : '';
                    $data['kf_headimgurl'] = is_ssl() && !empty($v['kf_headimgurl']) ? str_replace('http://', 'https://', $v['kf_headimgurl']) : $v['kf_headimgurl'];
                    $data['wechat_id']     = $wechat_id;
                    $data['status']        = 1;

                    $data['invite_wx']          = !empty($v['invite_wx']) ? $v['invite_wx'] : '';
                    $data['invite_expire_time'] = !empty($v['invite_expire_time']) ? $v['invite_expire_time'] : 0;
                    $data['invite_status']      = !empty($v['invite_status']) ? $v['invite_status'] : '';

                    RC_DB::table('wechat_customer')->insert($data);
                }
            }
        }
        return true;
    }

    private function get_session_list()
    {
        $wechat_id  = $this->platformAccount->getAccountID();
        $db_session = RC_DB::table('wechat_customer_session as w')
            ->leftJoin('wechat_user as u', RC_DB::raw('w.openid'), '=', RC_DB::raw('u.openid'))
            ->where(RC_DB::raw('w.wechat_id'), $wechat_id);
        $status     = isset($_GET['status']) ? intval($_GET['status']) : 2;

        $total_count = $db_session->select(
            RC_DB::raw("SUM(w.status = 1) AS going"),
            RC_DB::raw("SUM(w.status = 2) AS wait"),
            RC_DB::raw("SUM(w.status = 3) AS close"))->first();
        if (empty($total_count['going'])) {
            $total_count['going'] = 0;
        }
        if (empty($total_count['wait'])) {
            $total_count['wait'] = 0;
        }
        if (empty($total_count['close'])) {
            $total_count['close'] = 0;
        }

        $db_session->where(RC_DB::raw('w.status'), $status);

        $count = $db_session->count();
        $page  = new ecjia_platform_page($count, 15, 5);
        $list  = $db_session->select(RC_DB::raw('w.*'), RC_DB::raw('u.nickname'))->orderBy('id', 'desc')->take(15)->skip($page->start_id - 1)->get();

        return array('item' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'count' => $total_count);
    }
}

//end
