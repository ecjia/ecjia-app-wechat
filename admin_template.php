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
 * ECJIA消息模板
 */
class admin_template extends ecjia_admin {
	private $db_mail;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		Ecjia\App\Wechat\Helper::assign_adminlog_content();
		
		$this->db_mail = RC_Loader::load_app_model('mail_templates_model');
	
		RC_Script::enqueue_script('tinymce');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('message_template', RC_App::apps_url('statics/js/message_template.js', __FILE__), array(), false, false);
		
		RC_Script::localize_script('message_template', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.message_template'), RC_Uri::url('wechat/admin_template/init')));
	}

	/**
	 * 消息模板
	 */
	public function init () {
		$this->admin_priv('message_template_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.message_template')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.message_template'));
		$this->assign('action_link', array('href'=>RC_Uri::url('wechat/admin_template/add'), 'text' => RC_Lang::get('wechat::wechat.add_message_template')));

		$data = $this->db_mail->field('template_id, template_code, template_subject, template_content')->where(array('type' => 'push'))->select();
		$this->assign('templates', $data);

		$this->display('message_template_list.dwt');
	}
	
	/**
	 * 添加模板页面
	 */
	public function add() {
		$this->admin_priv('message_template_add');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_message_template')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.add_message_template'));
		$this->assign('action_link', array('href'=>RC_Uri::url('wechat/admin_template/init'), 'text' => RC_Lang::get('wechat::wechat.message_template_list')));
		
		$this->assign('form_action', RC_Uri::url('wechat/admin_template/insert'));
		$this->assign('action', 'insert');
		
		$this->display('message_template_info.dwt');
	}
	
	/**
	 * 添加模板处理
	 */
	public function insert() {
		$this->admin_priv('message_template_add', ecjia::MSGTYPE_JSON);
		
		$template_code = trim($_POST['template_code']);
		$subject       = trim($_POST['subject']);
		$content       = trim($_POST['content']);
		
		$titlecount = $this->db_mail->where(array('template_code' => $template_code, 'type' => 'push'))->count();
		if ($titlecount > 0) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.message_template_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'template_code'    => $template_code,
			'template_subject' => $subject,
			'template_content' => $content,
			'last_modify'      => RC_Time::gmtime(),
			'type'             =>'push'
		);
		
		$tid=$this->db_mail->insert($data);
		ecjia_admin::admin_log($subject, 'add', 'template');
		
		$links[] = array('text' => RC_Lang::get('wechat::wechat.continue_add_template'), 'href'=> RC_Uri::url('wechat/admin_template/add'));
		return $this->showmessage(RC_Lang::get('wechat::wechat.add_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links , 'pjaxurl' => RC_Uri::url('wechat/admin_template/edit', array('id' => $tid))));
	}
	
	/**
	 * 模版修改
	 */
	public function edit() {
		$this->admin_priv('message_template_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.edit_message_template')));
		
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.edit_message_template'));
		$this->assign('action_link', array('href'=>RC_Uri::url('wechat/admin_template/init'), 'text' => RC_Lang::get('wechat::wechat.message_template_list')));

		$tid = intval($_GET['id']);
		$template = $this->db_mail->find(array('template_id' => $tid));
		
		$this->assign('template', $template);
		$this->assign('form_action', RC_Uri::url('wechat/admin_template/update'));
		
		$this->display('message_template_info.dwt');
	}
	
	/**
	 * 保存模板内容
	 */
	public function update() {
		$this->admin_priv('message_template_update', ecjia::MSGTYPE_JSON);
		
		$id			   = intval($_POST['id']);
		$template_code = trim($_POST['template_code']);
		$subject       = trim($_POST['subject']);
		$content       = trim($_POST['content']);
	
		$old_template_code = trim($_POST['old_template_code']);
		if ($template_code != $old_template_code) {
			$titlecount = $this->db_mail->where(array('template_code' => $template_code, 'type' => 'push'))->count();
			if ($titlecount > 0) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.message_template_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		$data = array(
			'template_code'    => $template_code,
			'template_subject' => $subject,
			'template_content' => $content,
			'last_modify'      => RC_Time::gmtime(),
			'type'             =>'push'
		);
		
		$this->db_mail->where(array('template_id' => $id))->update($data);
		ecjia_admin::admin_log($subject, 'edit', 'template');
		
	  	return $this->showmessage(RC_Lang::get('wechat::wechat.edit_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 删除消息模板
	 */
	public function remove()  {
		$this->admin_priv('message_template_delete', ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
		$template_subject = $this->db_mail->where(array('template_id' =>$id))->get_field('template_subject');
		
		$this->db_mail->where(array('template_id' => $id))->delete();
		
		ecjia_admin::admin_log($template_subject, 'remove', 'template');
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
}

//end