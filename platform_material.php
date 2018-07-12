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
 * ECJIA素材
 */
class platform_material extends ecjia_platform
{
    public function __construct()
    {
        parent::__construct();

        RC_Lang::load('wechat');
        RC_Loader::load_app_class('platform_account', 'platform', false);
        RC_Loader::load_app_class('wechat_method', 'wechat', false);

        RC_Loader::load_app_func('global');
        Ecjia\App\Wechat\Helper::assign_adminlog_content();

        /* 加载所有全局 js/css */
        RC_Script::enqueue_script('bootstrap-placeholder');
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-chosen');
        RC_Style::enqueue_style('chosen');
        RC_Script::enqueue_script('jquery-dropper', RC_App::apps_url('statics/platform-js/dropper-upload/jquery.fs.dropper.js', __FILE__), array(), false, true);

        RC_Script::enqueue_script('ecjia-platform-bootstrap-fileupload-js');
        RC_Style::enqueue_style('ecjia-platform-bootstrap-fileupload-css');

        RC_Script::enqueue_script('admin_material', RC_App::apps_url('statics/platform-js/admin_material.js', __FILE__), array(), false, true);
        RC_Style::enqueue_style('admin_material', RC_App::apps_url('statics/platform-css/admin_material.css', __FILE__));
        RC_Script::localize_script('admin_material', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));

        ecjia_platform_screen::get_current_screen()->set_subject('素材管理');
    }

    /**
     * 素材列表
     */
    public function init()
    {
        $this->admin_priv('wechat_material_manage');

        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();

        $nav_here = RC_Lang::get('wechat::wechat.forever_material');
        $material = intval($_GET['material']);
        if ($material != 1) {
            $nav_here = RC_Lang::get('wechat::wechat.provisional_material');
        }
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here));

        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $form_action = '';
        $action_link = '';

        if ($type == 'news') {
            $action_link = array('text' => RC_Lang::get('wechat::wechat.add_images'), 'href' => RC_Uri::url('wechat/platform_material/add'));

            ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                '<p>图文素材：分为单图文、多图文素材。支持图片，语音，视频，缩略图素材。</p>' .
                '<p>单图文素材添加好之后，即可将多条单图文素材组合成为一条多图文素材。</p>' .
                '<p>★ 注意事项：单图文素材如果经过修改，则原先添加好的多图文素材需要重新组合。</p>'
            );
        } elseif ($type == 'image') {
            $form_action = RC_Uri::url('wechat/platform_material/picture_insert');

            ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                '<p>图片（image）素材大小: 2M，支持PNG\JPEG\JPG\GIF格式。</p>'
            );
        } elseif ($type == 'voice') {
            $form_action = RC_Uri::url('wechat/platform_material/voice_insert');

            ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                '<p>语音（voice）素材大小：2M，播放长度不超过60s，支持AMR\MP3格式。</p>'
            );
        } elseif ($type == 'video') {
            $action_link = array('text' => RC_Lang::get('wechat::wechat.add_video'), 'href' => RC_Uri::url('wechat/platform_material/video_add'));

            ecjia_platform_screen::get_current_screen()->set_help_sidebar(
                '<p>视频（video）素材大小：10MB，支持MP4格式。</p>' .
                '<p>建议直接使用优酷等第三方视频网站的视频地址。优点:不占用服务器资源，支持更大、更多格式的视频素材。</p>'
            );
        } elseif ($type == 'thumb') {
            $action_link = array('text' => RC_Lang::get('wechat::wechat.add_video'), 'href'=> RC_Uri::url('wechat/platform_material/thumb_add'));

            ecjia_screen::get_current_screen()->set_help_sidebar(
                '<p>缩略图（thumb）素材大小：64KB，支持JPG格式。</p>'
            );
        }

        $this->assign('ur_here', RC_Lang::get('wechat::wechat.material_manage'));
        $this->assign('action_link', $action_link);
        $this->assign('form_action', $form_action);

        $wechat_id = $this->platformAccount->getAccountID();

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.operate_before_pub'));
        } else {
            $this->assign('warn', 'warn');

            $wechat_type = $this->platformAccount->getType();
            $this->assign('wechat_type', $wechat_type);

            $lists = $this->get_all_material();
            $this->assign('lists', $lists);
        }

        $this->assign_lang();
        $this->display('wechat_material.dwt');
    }

    /**
     * 图文添加
     */
    public function add()
    {
        $this->admin_priv('wechat_material_add');

        $material = !empty($_GET['material']) ? 1 : 0;

        $nav_here = RC_Lang::get('wechat::wechat.forever_material');
        if ($material != 1) {
            $nav_here = RC_Lang::get('wechat::wechat.provisional_material');
        }
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here, RC_Uri::url('wechat/platform_material/init', array('type' => 'news', 'material' => $material))));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_images')));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' =>
            '<p>' . RC_Lang::get('wechat::wechat.welcome_add_images') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E6.B7.BB.E5.8A.A0.E5.9B.BE.E6.96.87" target="_blank">' . RC_Lang::get('wechat::wechat.images_meterial_help') . '</a>') . '</p>'
        );
        ecjia_platform_screen::get_current_screen()->set_sidebar_display(false);

        $wechat_id = $this->platformAccount->getAccountID();

        $this->assign('ur_here', RC_Lang::get('wechat::wechat.add_images'));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.material_manage'), 'href' => RC_Uri::url('wechat/platform_material/init', array('type' => 'news', 'material' => $material))));
        $this->assign('form_action', RC_Uri::url('wechat/platform_material/insert'));
        $this->assign('action', 'article_add');

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.operate_before_pub'));
        } else {
            $this->assign('warn', 'warn');

            $wechat_type = $this->platformAccount->getType();
            $this->assign('wechat_type', $wechat_type);
            $this->assign('material', $material);
        }

        $this->assign_lang();
        $this->display('wechat_material_add.dwt');
    }

    /**
     * 图文添加数据插入
     */
    public function insert()
    {
        $this->admin_priv('wechat_material_add', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $uuid = $this->platformAccount->getUUID();
        $wechat = wechat_method::wechat_instance($uuid);

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $title = !empty($_POST['title']) ? trim($_POST['title']) : '';
        $author = !empty($_POST['author']) ? trim($_POST['author']) : '';
        $is_show = !empty($_POST['is_show']) ? intval($_POST['is_show']) : 0;
        $digest = !empty($_POST['digest']) ? $_POST['digest'] : '';
        $link = !empty($_POST['link']) ? trim($_POST['link']) : '';
        $content = !empty($_POST['content']) ? stripslashes($_POST['content']) : '';
        $sort = !empty($_POST['sort']) ? intval($_POST['sort']) : 0;

        if (empty($title)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.enter_images_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        try {
            if (!empty($_POST)) {
                if ((isset($_FILES['image_url']['error']) && $_FILES['image_url']['error'] == 0) || (!isset($_FILES['image_url']['error']) && isset($_FILES['image_url']['tmp_name']) && $_FILES['image_url']['tmp_name'] != 'none')) {
                    $upload = RC_Upload::uploader('image', array('save_path' => 'data/material/article_pic', 'auto_sub_dirs' => false));
                    $file = array(
                        'name' => $_FILES['image_url']['name'],
                        'type' => $_FILES['image_url']['type'],
                        'tmp_name' => $_FILES['image_url']['tmp_name'],
                        'error' => $_FILES['image_url']['error'],
                        'size' => $_FILES['image_url']['size'],
                    );
                    $info = $upload->upload($file);
                    if (!empty($info)) {
                        $image_url = $upload->get_position($info);
                    } else {
                        return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                } else {
                    return $this->showmessage(RC_Lang::get('wechat::wechat.upload_images_cover'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                if (empty($content)) {
                    return $this->showmessage(RC_Lang::get('wechat::wechat.enter_main_body'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
                $data = array(
                    'wechat_id' => $wechat_id,
                    'title' => $title,
                    'author' => $author,
                    'is_show' => $is_show,
                    'digest' => $digest,
                    'link' => $link,
                    'content' => $content,
                    'sort' => $sort,
                    'file' => $image_url,
                    'size' => $file['size'],
                    'file_name' => $file['name'],
                    'add_time' => RC_Time::gmtime(),
                    'type' => 'news',
                    'is_material' => 'material',
                );
                if ($id) {
                    $data['parent_id'] = $id;
                } else {
                	$data['parent_id'] = 0;
                }
                $rs = $wechat->addMaterialFile('image', RC_Upload::upload_path() . $image_url);
                if (is_ecjia_error($rs)) {
                    return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                $articles[0] = array(
                    'title' => $title,
                    'thumb_media_id' => $rs['media_id'],
                    'author' => $author,
                    'digest' => $digest,
                    'show_cover_pic' => $is_show,
                    'content' => $content,
                    'content_source_url' => $link,
                );
                $article_list = array('articles' => $articles);

                $rs1 = $wechat->addMaterialNews($article_list);
                if (is_ecjia_error($rs1)) {
                    return $this->showmessage(wechat_method::wechat_error($rs1->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                //封面图片素材id
                $data['thumb'] = $rs['media_id'];
                $data['media_url'] = $rs['url'];
                //图文消息的id
                $data['media_id'] = $rs1['media_id'];

                $id = RC_DB::table('wechat_media')->insertGetId($data);
                ecjia_admin::admin_log($title, 'add', 'article_material');
            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $links[] = array('text' => RC_Lang::get('wechat::wechat.return_material_manage'), 'href' => RC_Uri::url('wechat/platform_material/init', array('type' => 'news', 'material' => 1)));
        $links[] = array('text' => RC_Lang::get('wechat::wechat.continue_material_manage'), 'href' => RC_Uri::url('wechat/platform_material/add', array('material' => 1)));
        return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('wechat/platform_material/edit', array('id' => $id, 'material' => 1))));
    }

    /**
     * 素材编辑
     */
    public function edit()
    {
        $this->admin_priv('wechat_material_update');

        $material = !empty($_GET['material']) ? 1 : 0;

        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.material_manage'), RC_Uri::url('wechat/platform_material/init', array('type' => 'news', 'material' => $material))));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.edit_material')));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' =>
            '<p>' . RC_Lang::get('wechat::wechat.welcome_edit_material') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E7.BC.96.E8.BE.91.E5.9B.BE.E6.96.87" target="_blank">' . RC_Lang::get('wechat::wechat.edit_material_help') . '</a>') . '</p>'
        );
        ecjia_platform_screen::get_current_screen()->set_sidebar_display(false);

        $wechat_id = $this->platformAccount->getAccountID();

        $this->assign('ur_here', RC_Lang::get('wechat::wechat.edit_material'));
        $this->assign('form_action', RC_Uri::url('wechat/platform_material/update', array('id' => $_GET['id'], 'material' => $material)));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.material_manage'), 'href' => RC_Uri::url('wechat/platform_material/init', array('type' => 'news', 'material' => $material))));
        $this->assign('action', 'article_add');

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.operate_before_pub'));
        } else {
            $this->assign('warn', 'warn');

            $wechat_type = $this->platformAccount->getType();
            $this->assign('wechat_type', $wechat_type);

            $article = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', intval($_GET['id']))->where('type', 'news')->first();
			if (empty($article)) {
				return $this->showmessage('该素材不存在', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
			}
            if (!empty($article['file'])) {
                $article['file'] = RC_Upload::upload_url($article['file']);
            }
            $article['articles'][0] = $article;
            $data = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('parent_id', $article['id'])->orderBy('id', 'asc')->get();

            if (!empty($data)) {
                foreach ($data as $k => $v) {
                    $article['articles'][$k + 1] = $v;
                    if (!empty($v['file'])) {
                        $article['articles'][$k + 1]['file'] = RC_Upload::upload_url($v['file']);
                    }
                }
            }
            $this->assign('article', $article);
        }
        $this->assign_lang();
        $this->display('wechat_material_edit.dwt');
    }

    public function update()
    {
        $this->admin_priv('wechat_material_update', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();
        $uuid = $this->platformAccount->getUUID();
        $wechat = wechat_method::wechat_instance($uuid);

        $parent_id = !empty($_GET['id']) ? $_GET['id'] : 0;
        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $title = !empty($_POST['title']) ? trim($_POST['title']) : '';
        $author = !empty($_POST['author']) ? trim($_POST['author']) : '';
        $is_show = !empty($_POST['is_show']) ? intval($_POST['is_show']) : 0;
        $digest = !empty($_POST['digest']) ? $_POST['digest'] : '';
        $link = !empty($_POST['link']) ? trim($_POST['link']) : '';
        $content = !empty($_POST['content']) ? stripslashes($_POST['content']) : '';
        $sort = !empty($_POST['sort']) ? intval($_POST['sort']) : 0;
        $id = !empty($_POST['id']) ? intval($_POST['id']) : 0;

        $index = !empty($_POST['index']) ? intval($_POST['index']) : 0;

        try {
            if (!empty($_POST)) {
                if ((isset($_FILES['image_url']['error']) && $_FILES['image_url']['error'] == 0) || (!isset($_FILES['image_url']['error']) && isset($_FILES['image_url']['tmp_name']) && $_FILES['image_url']['tmp_name'] != 'none')) {
                    $upload = RC_Upload::uploader('image', array('save_path' => 'data/material/article_pic', 'auto_sub_dirs' => false));
                    $file = array(
                        'name' => $_FILES['image_url']['name'],
                        'type' => $_FILES['image_url']['type'],
                        'tmp_name' => $_FILES['image_url']['tmp_name'],
                        'error' => $_FILES['image_url']['error'],
                        'size' => $_FILES['image_url']['size'],
                    );
                    $info = $upload->upload($file);
                    if (!empty($info)) {
                        $image_url = $upload->get_position($info);
                    } else {
                        return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                    $rs = $wechat->addMaterialFile('image', RC_Upload::upload_path() . $image_url);
                    if (is_ecjia_error($rs)) {
                        return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                } else {
                    if (empty($_POST['id'])) {
                        return $this->showmessage(RC_Lang::get('wechat::wechat.upload_images_cover'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                }
                if (empty($content)) {
                    return $this->showmessage(RC_Lang::get('wechat::wechat.enter_main_body'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }

                $data = array(
                    'wechat_id' => $wechat_id,
                    'title' => $title,
                    'author' => $author,
                    'is_show' => $is_show,
                    'digest' => $digest,
                    'content' => $content,
                    'link' => $link,
                    'sort' => $sort,
                    'type' => 'news',
                    'is_material' => 'material',
                );
                if (!empty($image_url)) {
                    $data['file'] = $image_url;
                    $data['file_name'] = $file['name'];
                    $data['size'] = $file['size'];

                    //封面图片素材id
                    $data['thumb'] = $rs['media_id'];
                    $data['media_url'] = $rs['url'];
                }
                if (!empty($id)) {
                    //更新永久图文素材
                    $arr = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->first();
                    $articles = array('articles' => array(
                        'title' => $title,
                        'thumb_media_id' => $arr['thumb'],
                        'author' => $author,
                        'digest' => $digest,
                        'show_cover_pic' => $is_show,
                        'content' => $content,
                        'content_source_url' => $link,
                    ));

                    if ($index != 0) {
                        $articles['articles']['digest'] = '';
                    }
                    if (isset($data['thumb'])) {
                        $articles['articles']['thumb_media_id'] = $data['thumb'];
                    }
                    if (empty($arr['media_id'])) {
                        $arr['media_id'] = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $arr['parent_id'])->pluck('media_id');
                    }
                    $msg = $wechat->updateMaterialNews($arr['media_id'], $index, $articles);
                    if (is_ecjia_error($msg)) {
                        return $this->showmessage(wechat_method::wechat_error($msg->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }

                    $data['edit_time'] = RC_Time::gmtime();
                    RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->update($data);
                } else {
                    //添加多图文素材
                    $arr = $this->get_article_list($parent_id);

                    if (!empty($arr)) {
                        $count = count($arr);
                        foreach ($arr as $k => $v) {
                            $articles[$k] = array(
                                'title' => $v['title'],
                                'thumb_media_id' => $v['thumb'],
                                'author' => $v['author'],
                                'digest' => $v['digest'],
                                'show_cover_pic' => $v['is_show'],
                                'content' => $v['content'],
                                'content_source_url' => $v['link'],
                            );
                            if (!empty($v['media_id'])) {
                                //删除原素材
                                $msg = $wechat->deleteMaterial($v['media_id']);
                                if (is_ecjia_error($msg)) {
                                    return $this->showmessage(wechat_method::wechat_error($msg->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                                }
                            }
                        }
                    } else {
                        $count = 0;
                    }

                    $articles[$count] = array(
                        'title' => $title,
                        'thumb_media_id' => $rs['media_id'],
                        'author' => $author,
                        'digest' => $digest,
                        'show_cover_pic' => $is_show,
                        'content' => $content,
                        'content_source_url' => $link,
                    );
                    $article_list = array('articles' => $articles);

                    $rs1 = $wechat->addMaterialNews($article_list);
                    if (is_ecjia_error($rs1)) {
                        return $this->showmessage(wechat_method::wechat_error($rs1->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }

                    RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $parent_id)->update(array('media_id' => $rs1['media_id']));

                    $data['parent_id'] = $parent_id;
                    $data['add_time'] = RC_Time::gmtime();
                    $id = RC_DB::table('wechat_media')->insertGetId($data);
                }
                $title = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $parent_id)->pluck('title');
                ecjia_admin::admin_log($title, 'edit', 'article_material');
            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_material/edit', array('id' => $parent_id, 'material' => 1))));
    }

    /**
     * 删除图文封面图片
     */
    public function remove_file()
    {
        $this->admin_priv('wechat_material_delete', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $id = intval($_GET['id']);
        $info = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->first();
        //删除图片
        if (!empty($info['file'])) {
            $disk = RC_Filesystem::disk();
            $disk->delete(RC_Upload::upload_path() . $info['file']);
        }

        $uuid = $this->platformAccount->getUUID();
        $wechat = wechat_method::wechat_instance($uuid);

        if ($info['media_id'] && $info['is_material'] == 'material') {
            //删除永久素材
            try {
                $msg = $wechat->deleteMaterial($info['thumb']);
                if (is_ecjia_error($msg)) {
                    return $this->showmessage(wechat_method::wechat_error($msg->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('file' => ''));

        return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 删除图文素材
     */
    public function remove()
    {
        $this->admin_priv('wechat_material_delete', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();
        $wechat = wechat_method::wechat_instance($uuid);

        $wechat_id = $this->platformAccount->getAccountID();

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //判断素材是否正在被使用
        $count = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('media_id', $id)->count();
        if ($count != 0) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.images_used'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $info = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->orWhere('parent_id', $id)->get();
        if (!empty($info)) {
            $ids = array();
            foreach ($info as $k => $v) {
                if ($v['parent_id'] == 0) {
                    ecjia_admin::admin_log($v['title'], 'remove', 'article_material');
                }
                if (!empty($v['media_id']) && $v['is_material'] == 'material') {
                    //删除永久素材
                    try {
                        $msg = $wechat->deleteMaterial($v['media_id']);
                        if (is_ecjia_error($msg)) {
                            return $this->showmessage(wechat_method::wechat_error($msg->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                        }
                    } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                        return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                    }
                    RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('media_id' => ''));
                }
                if (empty($v['thumb'])) {
                    $ids[] = $v['id'];
                }
            }
            if (!empty($ids)) {
                RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->delete();
            }
        }
        return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 添加图片素材
     */
    public function picture_insert()
    {
        $this->admin_priv('wechat_material_add', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $uuid = $this->platformAccount->getUUID();
        $wechat = wechat_method::wechat_instance($uuid);

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.upload_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $upload = RC_Upload::uploader('image', array('save_path' => 'data/material/image', 'auto_sub_dirs' => false));
        if (!$upload->check_upload_file($_FILES['img_url'])) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $image_info = $upload->upload($_FILES['img_url']);
        if (empty($image_info)) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $file_path = $upload->get_position($image_info);
        $material = !empty($_GET['material']) ? 1 : 0;

        $data = array(
            'title' => '',
            'author' => '',
            'is_show' => 0,
            'link' => '',
            'sort' => 0,
            'digest' => '',
            'content' => '',
            'file' => $file_path,
            'type' => 'image',
            'file_name' => $_FILES['img_url']['name'],
            'add_time' => RC_Time::gmtime(),
            'size' => $_FILES['img_url']['size'],
            'wechat_id' => $wechat_id,
        );
        if ($material) {
            $data['is_material'] = 'material';
        }
        $rs['url'] = '';

        try {
            //临时素材
            if ($material == 0) {
                $rs = $wechat->uploadFile('image', RC_Upload::upload_path() . $file_path);
            } elseif ($material == 1) {
                //新增其他类型永久素材
                $rs = $wechat->addMaterialFile('image', RC_Upload::upload_path() . $file_path);
            }
            if (is_ecjia_error($rs)) {
                return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($material == 1) {
            $data['media_url'] = $rs['url'];
        }
        $data['thumb'] = $rs['media_id'];

        $id = RC_DB::table('wechat_media')->insertGetId($data);
        ecjia_admin::admin_log($_FILES['img_url']['name'], 'add', 'picture_material');
        return $this->showmessage(RC_Lang::get('wechat::wechat.upload_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_material/init', array('type' => 'image', 'material' => $material))));
    }

    /**
     * 删除图片
     */
    public function picture_remove()
    {
        $this->admin_priv('wechat_material_delete', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();
        $wechat = wechat_method::wechat_instance($uuid);

        $wechat_id = $this->platformAccount->getAccountID();

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //判断素材是否正在被使用
        $count = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('media_id', $id)->count();
        if ($count != 0) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.images_beused'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $info = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->first();

        if (!empty($info['thumb']) && $info['is_material'] == 'material') {
            //删除微信端图片素材
            try {
                $rs = $wechat->deleteMaterial($info['thumb']);
                if (is_ecjia_error($rs)) {
                    return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        //图片素材
        if ($info['type'] == 'image') {
            //删除图片
            $disk = RC_Filesystem::disk();
            if (!empty($info['file']) && $disk->exists(RC_Upload::upload_path($info['file']))) {
                $disk->delete(RC_Upload::upload_path($info['file']));
            }
            RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->delete();
        } elseif ($info['type'] == 'news') {
            RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('thumb' => ''));
            if (empty($info['parent_id']) && empty($info['media_id'])) {
                RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->delete();
            } elseif (!empty($info['parent_id'])) {
                $media_id = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $info['parent_id'])->pluck('media_id');
                if (empty($media_id)) {
                    RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->delete();
                }
            }
        }

        ecjia_admin::admin_log($info['file_name'], 'remove', 'picture_material');
        return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 语音添加
     */
    public function voice_insert()
    {
        $this->admin_priv('wechat_material_add', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $uuid = $this->platformAccount->getUUID();
        $wechat = wechat_method::wechat_instance($uuid);

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.upload_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $upload = RC_Upload::uploader('file', array('save_path' => 'data/material/voice', 'auto_sub_dirs' => false));
        $upload->allowed_type('mp3'); //暂时不用amr
        $upload->allowed_mime('audio/mp3');
        $upload->allowed_size('2097152');

        $image_info = $upload->upload($_FILES['img_url']);
        if (empty($image_info)) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $file_path = $upload->get_position($image_info);
        $material = !empty($_GET['material']) ? 1 : 0;

        $data = array(
            'title' => '',
            'author' => '',
            'is_show' => 0,
            'link' => '',
            'sort' => 0,
            'digest' => '',
            'content' => '',
            'file' => $file_path,
            'type' => 'voice',
            'file_name' => $_FILES['img_url']['name'],
            'add_time' => RC_Time::gmtime(),
            'size' => $_FILES['img_url']['size'],
            'wechat_id' => $wechat_id,
        );
        if ($material) {
            $data['is_material'] = 'material';
        }

        try {
            if ($material == 0) {
                //临时素材
                $rs = $wechat->uploadFile('voice', RC_Upload::upload_path() . $file_path);
            } elseif ($material == 1) {
                //永久素材
                $rs = $wechat->addMaterialFile('voice', RC_Upload::upload_path() . $file_path);
            }
            if (is_ecjia_error($rs)) {
                return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $data['media_id'] = $rs['media_id'];

        $id = RC_DB::table('wechat_media')->insertGetId($data);
        ecjia_admin::admin_log($_FILES['img_url']['name'], 'add', 'voice_material');
        return $this->showmessage(RC_Lang::get('wechat::wechat.upload_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_material/init', array('type' => 'voice', 'material' => $material))));
    }

    /**
     * 删除语音
     */
    public function voice_remove()
    {
        $this->admin_priv('wechat_material_delete', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();
        $wechat = wechat_method::wechat_instance($uuid);

        $wechat_id = $this->platformAccount->getAccountID();

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //判断素材是否正在被使用
        $count = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('media_id', $id)->count();
        if ($count != 0) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.voice_used'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $info = RC_DB::table('wechat_media')->where('id', $id)->first();
        if (!empty($info['media_id']) && $info['is_material'] == 'material') {
            //删除永久素材
            try {
                $rs = $wechat->deleteMaterial($info['media_id']);
                if (is_ecjia_error($rs)) {
                    return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        //删除语音
        $disk = RC_Filesystem::disk();
        if (!empty($info['file']) && $disk->exists(RC_Upload::upload_path($info['file']))) {
            $disk->delete(RC_Upload::upload_path($info['file']));
        }
        RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->delete();

        ecjia_admin::admin_log($info['file_name'], 'remove', 'voice_material');
        return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function video_add()
    {
        $this->admin_priv('wechat_material_add');

        $material = !empty($_GET['material']) ? 1 : 0;
        $nav_here = RC_Lang::get('wechat::wechat.forever_material');
        if ($material != 1) {
            $nav_here = RC_Lang::get('wechat::wechat.provisional_material');
        }
        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here, RC_Uri::url('wechat/platform_material/init', array('type' => 'video', 'material' => $material))));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_video')));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' =>
            '<p>' . RC_Lang::get('wechat::wechat.welcome_add_video') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E6.B7.BB.E5.8A.A0.E8.A7.86.E9.A2.91" target="_blank">' . RC_Lang::get('wechat::wechat.add_video_help') . '</a>') . '</p>'
        );

        $wechat_id = $this->platformAccount->getAccountID();

        $this->assign('ur_here', RC_Lang::get('wechat::wechat.add_video'));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.material_manage'), 'href' => RC_Uri::url('wechat/platform_material/init', array('type' => 'video', 'material' => $material))));
        $this->assign('form_action', RC_Uri::url('wechat/platform_material/video_insert', array('material' => $material)));
        $this->assign('action', 'video_add');
        $this->assign('button_type', 'add');

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.operate_before_pub'));
        } else {
            $this->assign('warn', 'warn');

            $wechat_type = $this->platformAccount->getType();
            $this->assign('wechat_type', $wechat_type);

            $this->assign('material', $material);
        }
        $this->assign_lang();
        $this->display('wechat_material_add.dwt');
    }

    public function video_insert()
    {
        $this->admin_priv('wechat_material_add', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $uuid = $this->platformAccount->getUUID();
        $wechat = wechat_method::wechat_instance($uuid);

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $title = !empty($_POST['video_title']) ? trim($_POST['video_title']) : '';
        $digest = !empty($_POST['video_digest']) ? $_POST['video_digest'] : '';
        $material = !empty($_GET['material']) ? 1 : 0;

        if (empty($title)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.enter_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($_FILES['video'])) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.upload_viedo'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        if ($material == 1) {
            if (empty($digest)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.video_intro'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        $upload = RC_Upload::uploader('file', array('save_path' => 'data/material/video', 'auto_sub_dirs' => false));
        $upload->allowed_type('mp4');
        $upload->allowed_mime('video/mp4');
        $upload->allowed_size('10485760');

        if ((isset($_FILES['video']))) {
            $image_info = $upload->upload($_FILES['video']);
            if (!empty($image_info)) {
                $file_path = $upload->get_position($image_info);
            } else {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $file_path = '';
        }

        $data = array(
            'title' => $title,
            'digest' => $digest,
            'is_show' => 0,
            'file' => $file_path,
            'file_name' => $_FILES['video']['name'],
            'add_time' => RC_Time::gmtime(),
            'type' => 'video',
            'size' => $_FILES['video']['size'],
            'wechat_id' => $wechat_id,
        );

        if ($material) {
            $data['is_material'] = 'material';
        }

        try {
            if ($material == 0) {
                //临时素材
                $rs = $wechat->uploadFile('video', RC_Upload::upload_path() . $file_path);
            } elseif ($material == 1) {
                $description = array('title' => $title, 'introduction' => $digest);
                //永久素材
                $rs = $wechat->addMaterialFile('video', RC_Upload::upload_path() . $file_path, $description);
            }
            if (is_ecjia_error($rs)) {
                return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
            return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $data['media_id'] = $rs['media_id'];
        $id = RC_DB::table('wechat_media')->insertGetId($data);

        ecjia_admin::admin_log($title, 'add', 'video_material');
        if ($id) {
            $links[] = array('text' => RC_Lang::get('wechat::wechat.return_material_manage'), 'href' => RC_Uri::url('wechat/platform_material/init', array('type' => 'video', 'material' => $material)));
            $links[] = array('text' => RC_Lang::get('wechat::wechat.continue_add_video'), 'href' => RC_Uri::url('wechat/platform_material/video_add', array('material' => $material)));
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('wechat/platform_material/init', array('type' => 'video', 'material' => $material))));
        } else {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 素材编辑
     */
    public function video_edit()
    {
        $this->admin_priv('wechat_material_update');

        $material = !empty($_GET['material']) ? 1 : 0;
        $nav_here = RC_Lang::get('wechat::wechat.forever_material');
        if ($material != 1) {
            $nav_here = RC_Lang::get('wechat::wechat.provisional_material');
        }
        ecjia_platform_screen::get_current_screen()->remove_last_nav_here();
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here($nav_here, RC_Uri::url('wechat/platform_material/init', array('type' => 'video'))));
        ecjia_platform_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.edit_material')));

        ecjia_platform_screen::get_current_screen()->add_help_tab(array(
            'id' => 'overview',
            'title' => RC_Lang::get('wechat::wechat.overview'),
            'content' =>
            '<p>' . RC_Lang::get('wechat::wechat.welcome_edit_video') . '</p>',
        ));

        ecjia_platform_screen::get_current_screen()->set_help_sidebar(
            '<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E7.BC.96.E8.BE.91.E8.A7.86.E9.A2.91" target="_blank">' . RC_Lang::get('wechat::wechat.edit_video_help') . '</a>') . '</p>'
        );

        $wechat_id = $this->platformAccount->getAccountID();

        $this->assign('ur_here', RC_Lang::get('wechat::wechat.edit_video'));
        $this->assign('form_action', RC_Uri::url('wechat/platform_material/video_update', array('material' => $material)));
        $this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.material_manage'), 'href' => RC_Uri::url('wechat/platform_material/init', array('type' => 'video', 'material' => $material))));
        $this->assign('action', 'video_add');

        if (is_ecjia_error($wechat_id)) {
            $this->assign('errormsg', RC_Lang::get('wechat::wechat.operate_before_pub'));
        } else {
            $this->assign('warn', 'warn');

            $wechat_type = $this->platformAccount->getType();
            $this->assign('wechat_type', $wechat_type);

            $article = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $_GET['id'])->first();
            if (!empty($article['file'])) {
                $article['files'] = RC_Uri::admin_url('statics/images/ecjiafile.png');
            }
            $this->assign('article', $article);
        }
        $this->assign_lang();
        $this->display('wechat_material_add.dwt');
    }

    /**
     * 视频素材更新
     */
    public function video_update()
    {
        $this->admin_priv('wechat_material_update', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $uuid = $this->platformAccount->getUUID();
        $wechat = wechat_method::wechat_instance($uuid);

        if (is_ecjia_error($wechat_id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $title = !empty($_POST['video_title']) ? trim($_POST['video_title']) : '';
        $digest = !empty($_POST['video_digest']) ? $_POST['video_digest'] : '';
        $id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $material = !empty($_GET['material']) ? 1 : 0;

        if (empty($title)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.enter_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $medias = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->first();
        if (empty($medias['file'])) {
            if (empty($_FILES['video'])) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.upload_viedo'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        if ($material == 1) {
            if (empty($digest)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.video_intro'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        if ((isset($_FILES['video']['error']) && $_FILES['video']['error'] == 0) || (!isset($_FILES['video']['error']) && isset($_FILES['video']['tmp_name']) && $_FILES['video']['tmp_name'] != 'none')) {
            $upload = RC_Upload::uploader('file', array('save_path' => 'data/material/video', 'auto_sub_dirs' => true));
            $upload->allowed_type('mp4');
            $upload->allowed_size('10485760');
            $upload->allowed_mime('video/mp4');

            $info = $upload->upload($_FILES['video']);
            if (!empty($info)) {
                if (!empty($medias['file'])) {
                    $upload->remove($medias['file']);
                }
                $file = $upload->get_position($info);
            } else {
                return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            if (!empty($medias['file'])) {
                $file = $medias['file'];
            } else {
                $disk = RC_Filesystem::disk();
                $disk->delete(RC_Upload::upload_path() . $medias['file']);
            }
        }
        $data = array(
            'title' => $title,
            'is_show' => 0,
            'digest' => $digest,
            'file' => $file,
            'type' => 'video',
            'edit_time' => RC_Time::gmtime(),
            'size' => $_FILES['video']['size'],
        );
        RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->update($data);

        ecjia_admin::admin_log($title, 'edit', 'video_material');
        return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/platform_material/video_edit', array('id' => $id, 'material' => $material))));
    }

    /**
     * 删除视频素材
     */
    public function video_remove()
    {
        $this->admin_priv('wechat_material_delete', ecjia::MSGTYPE_JSON);

        $uuid = $this->platformAccount->getUUID();
        $wechat = wechat_method::wechat_instance($uuid);

        $wechat_id = $this->platformAccount->getAccountID();

        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        //判断素材是否正在被使用
        $count = RC_DB::table('wechat_reply')->where('wechat_id', $wechat_id)->where('media_id', $id)->count();
        if ($count != 0) {
            return $this->showmessage(RC_Lang::get('wechat::wechat.video_used'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $info = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->first();

        if (!empty($info['media_id']) && $info['is_material'] == 'material') {
            //删除永久素材
            try {
                $rs = $wechat->deleteMaterial($info['media_id']);
                if (is_ecjia_error($rs)) {
                    return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                }
            } catch (\Royalcms\Component\WeChat\Core\Exceptions\HttpException $e) {
                return $this->showmessage($e->getMessage(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }

        //删除视频
        $disk = RC_Filesystem::disk();
        if (!empty($info['file']) && $disk->exists(RC_Upload::upload_path($info['file']))) {
            $disk->delete(RC_Upload::upload_path($info['file']));
        }

        RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->detele();

        ecjia_admin::admin_log($info['title'], 'remove', 'video_material');
        return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    /**
     * 编辑素材名称或文件名称
     */
    public function edit_file_name()
    {
        $this->admin_priv('wechat_material_update', ecjia::MSGTYPE_JSON);

        $wechat_id = $this->platformAccount->getAccountID();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $val = isset($_GET['val']) ? $_GET['val'] : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        if ($type == 'voice' || $type == 'picture') {
            if (empty($val)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.enter_filename'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('file_name' => $val));
            if ($type == 'voice') {
                ecjia_admin::admin_log($val, 'edit', 'voice_material');
            } elseif ($type == 'picture') {
                ecjia_admin::admin_log($val, 'edit', 'picture_material');
            }
        } else {
            if (empty($val)) {
                return $this->showmessage(RC_Lang::get('wechat::wechat.enter_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->update(array('title' => $val));

            ecjia_admin::admin_log($val, 'edit', 'article_material');
        }
        return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }

    public function search()
    {

        $wechat_id = $this->platformAccount->getAccountID();

        $keyword = !empty($_POST['keyword']) ? trim($_POST['keyword']) : '';
        $arr = RC_DB::table('wechat_media')
            ->select('id', 'file')
            ->where('wechat_id', $wechat_id)
            ->where('type', 'news')
            ->where('title', 'like', "%" . mysql_like_quote($keyword) . "%")
            ->get();

        if (empty($arr)) {
            $arr = array(0 => array(
                'id' => 0,
                'file' => RC_Lang::get('wechat::wechat.nosearch_record'),
            ));
        } else {
            foreach ($arr as $key => $item) {
                if (!empty($item['file'])) {
                    $arr[$key]['file'] = RC_Upload::upload_url($item['file']);
                }
            }
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $arr));
    }

    public function get_material_list()
    {
        $wechat_id = $this->platformAccount->getAccountID();

        $filter = $_GET['JSON'];
        $filter = (object) $filter;
        $type = isset($filter->type) ? $filter->type : '';
        $material = !empty($_GET['material']) ? 'material' : null;

        $db_wechat_media = RC_DB::table('wechat_media')
            ->where('wechat_id', $wechat_id)
            ->where('is_material', $material);

        if ($type == 'image') {
            $db_wechat_media
                ->where('file', '!=', '')
                ->where(function ($query) {
                    $query->where('type', 'image')->orWhere('type', 'news');
                });

        } elseif ($type == 'news') {
            $db_wechat_media
                ->where('article_id', '')
                ->where('type', $type);
        } else {
            $db_wechat_media
                ->where('file', '!=', '')
                ->where('type', $type);
        }
        $list = $db_wechat_media->select('id', 'file', 'title', 'size', 'add_time', 'type', 'file_name')->get();

        if (!empty($list)) {
            foreach ($list as $key => $val) {
                $val['type'] = isset($val['type']) ? $val['type'] : '';
                if (empty($val['file']) || $val['type'] == 'voice' || $val['type'] == 'video') {
                    if (empty($val['file'])) {
                        $list[$key]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
                    } elseif ($val['type'] == 'voice') {
                        $list[$key]['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
                    } elseif ($val['type'] == 'video') {
                        $list[$key]['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
                    }
                } else {
                    $list[$key]['file'] = RC_Upload::upload_url($val['file']);
                }
                if (isset($val['add_time'])) {
                    $list[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i:s', $val['add_time']);
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
        }
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $list));
    }
    
    public function get_material_array() {
    	$wechat_id = $this->platformAccount->getAccountID();
    	
    	$type = !empty($_POST['type']) ? trim($_POST['type']) : '';
    	$material = !empty($_GET['material']) ? 'material' : null;
    	
    	$db_wechat_media = RC_DB::table('wechat_media')
    	->where('wechat_id', $wechat_id)
    	->where('is_material', $material);
    	
    	if ($type == 'image') {
    		$db_wechat_media
    		->where('file', '!=', '')
    		->where(function ($query) {
    			$query->where('type', 'image');
//     			->orWhere('type', 'news');
    		});
    	
    	} elseif ($type == 'news') {
    		$db_wechat_media
    		->where('article_id', '')
    		->where('type', $type);
    	} else {
    		$db_wechat_media
    		->where('file', '!=', '')
    		->where('type', $type);
    	}
    	$list = $db_wechat_media->select('id', 'file', 'title', 'size', 'add_time', 'type', 'file_name', 'media_url')->get();
    	
    	if (!empty($list)) {
    		foreach ($list as $key => $val) {
    			$val['type'] = isset($val['type']) ? $val['type'] : '';
    			if (empty($val['file']) || $val['type'] == 'voice' || $val['type'] == 'video') {
    				if (empty($val['file'])) {
    					$list[$key]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
    				} elseif ($val['type'] == 'voice') {
    					$list[$key]['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
    				} elseif ($val['type'] == 'video') {
    					$list[$key]['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
    				}
    			} else {
    				$list[$key]['file'] = RC_Upload::upload_url($val['file']);
    			}
//     			if (isset($val['add_time'])) {
//     				$list[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i:s', $val['add_time']);
//     			}
    	
//     			if (empty($val['title'])) {
//     				$list[$key]['title'] = '';
//     			}
//     			if (!empty($val['size'])) {
//     				if ($val['size'] > (1024 * 1024)) {
//     					$list[$key]['size'] = round(($val['size'] / (1024 * 1024)), 1) . 'MB';
//     				} else {
//     					$list[$key]['size'] = round(($val['size'] / 1024), 1) . 'KB';
//     				}
//     			} else {
//     				$list[$key]['size'] = '';
//     			}
    		}
    	}
    	
    	$this->assign('list', $list);
    	$data = $this->fetch('library/wechat_material_list.lbi');
    	
    	return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $data));
    }

    public function get_material_info()
    {

        $wechat_id = $this->platformAccount->getAccountID();

        $id = intval($_GET['id']);
        $info = RC_DB::table('wechat_media')->where('wechat_id', $wechat_id)->where('id', $id)->first();

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
        $info['href'] = RC_Uri::url('wechat/platform_material/remove_file', array('id' => $id));
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $info));
    }

    /**
     * 获取所有素材列表
     */
    private function get_all_material()
    {

        $wechat_id = $this->platformAccount->getAccountID();

        $filter['type'] = empty($_GET['type']) ? '' : trim($_GET['type']);
        $type = $filter['type'];

        $db_wechat_media = RC_DB::table('wechat_media')
            ->where('wechat_id', $wechat_id);

        $where = '';
        if ($type == 'image') {
            $db_wechat_media
                ->where('file', '!=', '')
                ->where(function ($query) {
                    $query->where('type', 'image')->orWhere('type', 'news')
                        ->where('thumb', '!=', '');
                });

        } elseif ($type == 'news') {
            $db_wechat_media
                ->where('type', 'news')
                ->where('media_id', '!=', '')
                ->where('parent_id', 0);
        } else {
            $db_wechat_media->where('type', $type);
        }

        $material = !empty($_GET['material']) ? 'material' : null;
        $db_wechat_media->where('is_material', $material);

        $data = RC_DB::table('wechat_media')->select(
            RC_DB::raw("SUM(type='news' and parent_id = 0 and media_id != '') AS news"),
            RC_DB::raw("SUM(file != '' and (type = 'image' or type = 'news') and thumb != '') AS image"),
            RC_DB::raw("SUM(type='voice') AS voice"),
            RC_DB::raw("SUM(type='video') AS video")
        )
            ->where('wechat_id', $wechat_id)
            ->where('is_material', $material)
            ->get();

        if (!empty($data)) {
            foreach ($data as $v) {
                if (empty($v['news']) && empty($v['image']) && empty($v['voice']) && empty($v['video'])) {
                    $v['news'] = 0;
                    $v['image'] = 0;
                    $v['voice'] = 0;
                    $v['video'] = 0;
                }
                $filter['count'] = $v;
            }
        }

        $count = $db_wechat_media->count();
        $page = new ecjia_platform_page($count, 12, 5);
        $data = $db_wechat_media->orderBy('sort', 'asc')->orderBy('id', 'desc')->take(12)->skip($page->start_id - 1)->get();

        if (!empty($data)) {
            foreach ($data as $key => $val) {
                if (isset($val['add_time'])) {
                    $data[$key]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_nj'), $val['add_time']);
                }

                if (empty($val['file']) || $val['type'] == 'voice' || $val['type'] == 'video') {
                    if (empty($val['file'])) {
                        $data[$key]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
                    } elseif ($val['type'] == 'voice') {
                        $data[$key]['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
                    } elseif ($val['type'] == 'video') {
                        $data[$key]['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
                    }
                } else {
                    $data[$key]['file'] = RC_Upload::upload_url($val['file']);
                }
                $content = !empty($val['digest']) ? strip_tags(html_out($val['digest'])) : strip_tags(html_out($val['content']));
                if (strlen($content) > 100) {
                    $data[$key]['content'] = msubstr($content, 100);
                } else {
                    $data[$key]['content'] = $content;
                }

                if ($type == 'news') {
                    $datas = RC_DB::table('wechat_media')->where('parent_id', $val['id'])->orderBy('id', 'asc')->get();
                    if (!empty($datas)) {
                        foreach ($datas as $k => $v) {
                            if (!empty($v['file'])) {
                                $data[$key]['articles'][$k]['file'] = RC_Upload::upload_url($v['file']);
                            } else {
                                if (empty($val['file'])) {
                                    $data[$key]['articles'][$k]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
                                } elseif ($val['type'] == 'voice') {
                                    $data[$key]['articles'][$k]['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
                                } elseif ($val['type'] == 'video') {
                                    $data[$key]['articles'][$k]['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
                                }
                            }
                            $data[$key]['articles'][$k]['id'] = $v['id'];
                            $data[$key]['articles'][$k]['title'] = $v['title'];
                            $data[$key]['articles'][$k]['file_name'] = $v['file_name'];
                        }
                    }
                }
            }
        }
        $arr = array('item' => $data, 'desc' => $page->page_desc(), 'page' => $page->show(5), 'filter' => $filter);
        return $arr;
    }

    /**
     * 获取多图文信息
     */
    private function get_article_list($id)
    {
        $db_wechat_media = RC_DB::table('wechat_media');
        if ($id) {
            $db_wechat_media->where('type', 'news')->where('parent_id', $id)->orWhere('id', $id);
        }
        $data = $db_wechat_media->orderBy('id', 'asc')->get();
        return $data;
    }
}

//end
