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
 * ECJIA群发消息
 */
class platform_mass_message extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        RC_Lang::load('wechat');
        RC_Loader::load_app_class('platform_account', 'platform', false);
        RC_Loader::load_app_class('wechat_method', 'wechat', false);

        RC_Loader::load_app_func('global');
        Ecjia\App\Wechat\Helper::assign_adminlog_content();

        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');

        RC_Script::enqueue_script('admin_mass_message', RC_App::apps_url('statics/platform-js/admin_mass_message.js', __FILE__), array(), false, true);
        RC_Script::enqueue_script('choose_material', RC_App::apps_url('statics/platform-js/choose_material.js', __FILE__), array(), false, true);
        
        RC_Style::enqueue_style('admin_material', RC_App::apps_url('statics/platform-css/admin_material.css', __FILE__));

        RC_Script::localize_script('admin_mass_message', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.mass_message')));

        ecjia_platform_screen::get_current_screen()->set_subject('群发消息');
    }

    public function init()
    {
        $this->admin_priv('wechat_message_manage');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.send_message')));
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.send_message'));

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');
            $type = RC_DB::table('platform_account')->where('id', $wechat_id)->pluck('type');
            $this->assign('type', $type);
            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));

            //查找所有标签 不包括黑名单
            $list = RC_DB::table('wechat_tag')->where('wechat_id', $wechat_id)->where('tag_id', '!=', 1)->orderBy('tag_id', 'asc')->get();
            $this->assign('list', $list);
            $this->assign('form_action', RC_Uri::url('wechat/platform_mass_message/mass_message'));
        }

        $this->display('wechat_mass_message.dwt');
    }

    /**
     * 群发消息处理
     */
    public function mass_message()
    {
        $this->admin_priv('wechat_message_manage');

//        $tag_id         = isset($_POST['tag_id']) ? $_POST['tag_id'] : 0;
//        $mass_type      = isset($_POST['mass_type']) ? $_POST['mass_type'] : '';
//        $id             = isset($_POST['media_id']) ? intval($_POST['media_id']) : 0;
//        $content_type   = isset($_POST['content_type']) ? $_POST['content_type'] : '';
//        $content        = isset($_POST['content']) ? $_POST['content'] : '';

        $tag_id         = $this->request->input('tag_id', 0);
        $mass_type      = $this->request->input('mass_type');
        $id             = $this->request->input('media_id', 0);
        $content_type   = $this->request->input('content_type');
        $content        = $this->request->input('content');

        //发送文本
        if ($content_type == 'text') {
            if (empty($content)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.text_must_info'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }

//            $media_id = $content;
//            $type = 'content';
//            $msg_data['content'] = $content;
        } else {
            if (empty($id)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.pls_select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
//            $media_id = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->pluck($field);
        }

        try {
            $wechat_id = $this->platformAccount->getAccountID();
            $uuid = $this->platformAccount->getUUID();
            $wechat = with(new Ecjia\App\Wechat\WechatUUID($uuid))->getWechatInstance();

//            $rs = $wechat->broadcast->sendText($massmsg);

            if ($media_id) {
                with(new Ecjia\App\Wechat\Sends\SendCustomMessage($wechat, $wechat_id))->sendMediaMessage($media_id);
            } else {
                with(new Ecjia\App\Wechat\Sends\SendCustomMessage($wechat, $wechat_id))->sendTextMessage($msg);
            }


        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

//        RC_Loader::load_app_class('wechat_method', 'wechat', false);


//        $wechat = wechat_method::wechat_instance($uuid);







        $msg_data['type'] = $content_type;
        $field = 'media_id';

        if ($content_type == 'news') {
            $content_type = 'mpnews';
        } elseif ($content_type == 'video') {
            $content_type = 'mpvideo';
        }
        $type = 'media_id';
//        //发送文本
//        if ($content_type == 'text') {
//            if (empty($content)) {
//                return $this->showmessage(RC_Lang::get('wechat::wechat.text_must_info'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
//            }
//            $media_id = $content;
//            $type = 'content';
//            $msg_data['content'] = $content;
//        } else {
//            if (empty($id)) {
//                return $this->showmessage(RC_Lang::get('wechat::wechat.pls_select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
//            }
//            $media_id = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->pluck($field);
//        }
//        if ($mass_type == 'all') {
//            //按全部用户群发
//            $massmsg = array(
//                'filter' => array('is_to_all' => true),
//                $content_type => array(
//                    $type => $media_id,
//                ),
//                'msgtype' => $content_type,
//            );
//        } else {
//            //按标签进行群发
//            $massmsg = array(
//                'filter' => array(
//                    'is_to_all' => false,
//                    'tag_id' => $tag_id,
//                ),
//                $content_type => array(
//                    $type => $media_id,
//                ),
//                'msgtype' => $content_type,
//            );
//        }
//        try {
//            $rs = $wechat->sendallMass($massmsg);
//            if (is_ecjia_error($rs)) {
//                return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
//            }
//        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
//            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
//        }

        // 数据处理
//        $msg_data['wechat_id'] = $wechat_id;
//        $msg_data['media_id'] = $id;
//        $msg_data['send_time'] = RC_Time::gmtime();
//        $msg_data['msg_id'] = $rs['msg_id'];
//        $mass_id = RC_DB::table('wechat_mass_history')->insertGetId($msg_data);
        return $this->showmessage(RC_Lang::get('wechat::wechat.mass_task_info'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_mass_message/init')));
    }

    public function get_material_list()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $db_wechat_media = RC_DB::table('wechat_media');
        if (is_ecjia_error($wechat_id)) {
            $list = array();
        } else {
            $filter = $_GET['JSON'];
            $filter = (object) $filter;
            $type = isset($filter->type) ? $filter->type : '';

            if ($type == 'image') {
                $where = "(file is NOT NULL and (type = 'image' or type = 'news')) and wechat_id = $wechat_id and thumb != ''";
            } elseif ($type == 'news') {
                $where = "type = '$type' and parent_id = 0 and wechat_id = $wechat_id and media_id != ''";
            } else {
                $where = "(file is NOT NULL and type = '$type') and wechat_id = $wechat_id";
            }
            $list = $db_wechat_media->whereRaw($where)->get();

            if (!empty($list)) {
                foreach ($list as $key => $val) {
                    if ($type == 'news') {
                        $list[$key]['children'] = $this->get_article_list($val['id'], $val['type']);
                        $list[$key]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_ymd'), $val['add_time']);
                        $list[$key]['file'] = RC_Upload::upload_url($val['file']);
                    } else {
                        if (empty($val['file']) || $type == 'voice' || $type == 'video') {
                            if (empty($val['file'])) {
                                $list[$key]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
                            } elseif ($type == 'voice') {
                                $list[$key]['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
                            } elseif ($type == 'video') {
                                $list[$key]['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
                            }
                        } else {
                            $list[$key]['file'] = RC_Upload::upload_url($val['file']);
                        }
                        if (!empty($val['add_time'])) {
                            $list[$key]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_nj'), $val['add_time']);
                        }
                        if (empty($val['title'])) {
                            $list[$key]['title'] = '';
                        }
                        if (!empty($val['size'])) {
                            if ($val['size'] > (1024 * 1024)) {
                                $list[$key]['size'] = round(($val['size'] / (1024 * 1024)), 1) . 'MB';
                            } else {
                                $list[$key]['size'] = round(($val['size'] / 1024), 1) . 'KB';
                            }
                        } else {
                            $list[$key]['size'] = '';
                        }
                    }
                    $list[$key]['type'] = $type;
                }
            }
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $list));
    }

    public function get_material_info()
    {
        $filter = $_GET['JSON'];
        $filter = (object) $filter;
        $id = $filter->id;
        $type = $filter->type;

        $info = RC_DB::table('wechat_media')->where('id', $id)->first();
        $info['type'] = isset($info['type']) ? $info['type'] : '';

        if (empty($info['file']) || $info['type'] == 'voice' || $info['type'] == 'video') {
            if (empty($info['file'])) {
                $info['file'] = RC_Uri::admin_url('statics/images/nopic.png');
            } elseif ($info['type'] == 'voice') {
                $info['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
            } elseif ($info['type'] == 'video') {
                $info['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
            }
        } else {
            $info['file'] = RC_Upload::upload_url($info['file']);
        }

        $info['id'] = $id;
        if (isset($info['add_time'])) {
            $info['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_nj'), $info['add_time']);
        }
        $content = !empty($info['digest']) ? strip_tags(html_out($info['digest'])) : strip_tags(html_out($info['content']));

        if (strlen($content) > 100) {
            $info['content'] = msubstr($content, 100);
        } else {
            $info['content'] = $content;
        }

        $is_articles = RC_DB::table('wechat_media')->where('parent_id', $id)->count();
        if ($type == 'news' && $is_articles != 0) {
            $info = $this->get_article_list($id, $info['type']);
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $info));
    }

    /**
     * 群发消息列表
     */
    public function mass_list()
    {
        $this->admin_priv('wechat_message_manage');

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.send_record')));
        $this->assign('ur_here', RC_Lang::get('wechat::wechat.send_record'));

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $this->assign('warn', 'warn');

            $type = RC_DB::table('platform_account')->where('id', $wechat_id)->pluck('type');
            $this->assign('type', $type);
            $this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.' . $type)));

            $list = $this->get_mass_history_list();
            $this->assign('list', $list);
        }
        $this->display('wechat_mass_list.dwt');
    }

    /**
     * 群发消息删除 1发送成功 2发送失败 3发送错误 4已删除
     */
    public function mass_del()
    {
        $this->admin_priv('wechat_message_manage', ecjia::MSGTYPE_JSON);

        $uuid = platform_account::getCurrentUUID('wechat');
        $wechat = wechat_method::wechat_instance($uuid);

        $wechat_id = $platform_account->getAccountID();

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $msg_id = RC_DB::table('wechat_mass_history')->where('id', $id)->pluck('msg_id');

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
        } else {
            $uuid = $this->platformAccount->getUUID();
            $wechat = wechat_method::wechat_instance($uuid);
            if (!empty($msg_id)) {
                try {
                    $rs = $wechat->deleteMass($msg_id);
                    if (is_ecjia_error($rs)) {
                        return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                    return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            }
            RC_DB::table('wechat_mass_history')->where('id', $id)->update(array('status' => '4'));
        }
        return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 获取多图文信息
     */
    private function get_article_list($id, $type)
    {
        $filter['type'] = empty($_GET['type']) ? '' : trim($_GET['type']);

        $db_wechat_media = RC_DB::table('wechat_media')->where('type', $type);
        if ($id) {
            $db_wechat_media->where('parent_id', $id)->orWhere('id', $id);
        }
        $data = $db_wechat_media->orderBy('id', 'asc')->get();
        $article['id'] = $id;

        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $article['ids'][$k] = $v['id'];

                if (!empty($v['file'])) {
                    $article['file'][$k]['file'] = RC_Upload::upload_url($v['file']);
                } else {
                    $article['file'][$k]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
                }
                $article['file'][$k]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_ymd'), $v['add_time']);
                $article['file'][$k]['title'] = strip_tags(html_out($v['title']));
                $article['file'][$k]['id'] = $v['id'];
                if (!empty($v['size'])) {
                    if ($v['size'] > (1024 * 1024)) {
                        $article['file'][$k]['size'] = round(($v['size'] / (1024 * 1024)), 1) . 'MB';
                    } else {
                        $article['file'][$k]['size'] = round(($v['size'] / 1024), 1) . 'KB';
                    }
                } else {
                    $article['file'][$k]['size'] = '';
                }
            }
        }
        return $article;
    }

    private function get_mass_history_list()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $db_mass_history = RC_DB::table('wechat_mass_history')->where('wechat_id', $wechat_id);
        $count = $db_mass_history->count();
        $page = new ecjia_platform_page($count, 10, 5);
        $list = $db_mass_history->select('*')->orderBy('send_time', 'desc')->take(10)->skip($page->start_id - 1)->get();

        if (!empty($list)) {
            foreach ($list as $key => $val) {
                if ($val['type'] == 'news') {
                    $list[$key]['children'] = $this->get_article_list($val['media_id'], $val['type']);
                } else {
                    $info = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $val['media_id'])->first();

                    $list[$key]['file_name'] = $info['file_name'];
                    if ($val['type'] == 'voice') {
                        $list[$key]['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
                    } elseif ($val['type'] == 'video') {
                        $list[$key]['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
                    } elseif ($val['type'] == 'image') {
                        if (!empty($info['file'])) {
                            $list[$key]['file'] = RC_Upload::upload_url($info['file']);
                        }
                    }
                }
                $list[$key]['send_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['send_time']);
            }
        }
        return array('list' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc());
    }
}

//end
