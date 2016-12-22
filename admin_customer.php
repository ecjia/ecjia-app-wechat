<?php

/**
 * ECJIA客服管理
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_customer extends ecjia_admin {
	private $db_platform_account;
	private $db_customer;

	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_customer = RC_Loader::load_app_model('wechat_customer_model');
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		
		RC_Loader::load_app_class('platform_account', 'platform', false);
		RC_Loader::load_app_class('wechat_method', 'wechat', false);
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('wechat_customer', RC_App::apps_url('statics/js/wechat_customer.js', __FILE__), array(), false, true);
		RC_Style::enqueue_style('admin_customer', RC_App::apps_url('statics/css/admin_customer.css', __FILE__));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') );
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Style::enqueue_style('hint.min', RC_Uri::admin_url('statics/lib/hint_css/hint.min.css'));
		
		RC_Script::localize_script('wechat_customer', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.customer'), RC_Uri::url('wechat/admin_customer/init')));
	}
	
	/**
	 * 多客服账号列表
	 */
	public function init() {
		$this->admin_priv('wechat_customer_manage');
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.customer')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.customer_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.add_customer'), 'href'=> RC_Uri::url('wechat/admin_customer/add')));
	
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.customer_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:多客服管理#.E5.A4.9A.E5.AE.A2.E6.9C.8D" target="_blank">'. RC_Lang::get('wechat::wechat.customer_help') .'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();

		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			
			$list = $this->get_list();
			$this->assign('list', $list);
		}
		
		$this->assign_lang();
		$this->display('wechat_customer_list.dwt');
	}
	
	
	public function add() {
		$this->admin_priv('wechat_customer_add');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_customer')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.add_customer'));
		$this->assign('action_link', array('href' => RC_Uri::url('wechat/admin_customer/init'), 'text' => RC_Lang::get('wechat::wechat.customer_list')));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.add_customer_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:多客服管理#.E6.B7.BB.E5.8A.A0.E5.AE.A2.E6.9C.8D.E8.B4.A6.E5.8F.B7" target="_blank">'. RC_Lang::get('wechat::wechat.add_customer_help') .'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			
			$this->assign('action', 'add');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			
			$this->assign('list', array('status' => 1));
			$this->assign('form_action', RC_Uri::url('wechat/admin_customer/insert'));
		}

		$this->assign_lang();
		$this->display('wechat_customer_edit.dwt');
	}
	
	public function insert() {
		$this->admin_priv('wechat_customer_add');
		
		$kf_account = !empty($_POST['kf_account']) ? trim($_POST['kf_account']) : '';
		$nickname = !empty($_POST['kf_nick']) ? trim($_POST['kf_nick']) : '';
		$status = !empty($_POST['status']) ? intval($_POST['status']) : 0;
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);

		//最多只能添加10个客服
		$count = $this->db_customer->where(array('wechat_id' => $wechat_id))->count();
		if ($count >= 10) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.up_customer_accounts'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//判断客服账号是否重复
		$num = $this->db_customer->where(array('wechat_id' => $wechat_id, 'kf_account' => $kf_account))->count();
		if ($num != 0) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.customer_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data = array(
			'wechat_id' 	=> $wechat_id,
			'kf_account' 	=> $kf_account,
			'kf_nick' 		=> $nickname,
			'status' 		=> $status,
		);
		
		//如果为开启状态 则微信端添加
		if ($status == 1) {
			//微信端添加客服账号
			$rs = $wechat->addKfaccount($kf_account, $nickname);
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		$id = $this->db_customer->insert($data);
		
		ecjia_admin::admin_log($kf_account, 'add', 'customer');
		$links[] = array('text' => RC_Lang::get('wechat::wechat.return_customer_list'), 'href' => RC_Uri::url('wechat/admin_customer/init'));
		$links[] = array('text' => RC_Lang::get('wechat::wechat.continue_add_customer'), 'href' => RC_Uri::url('wechat/admin_customer/add'));
		
		return $this->showmessage(RC_Lang::get('wechat::wechat.add_customer_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('wechat/admin_customer/edit', array('id' => $id))));
	}
	
	/**
	 * 编辑客服账号页面
	 */
	public function edit() {
		$this->admin_priv('wechat_customer_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.edit_customer')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.edit_customer'));
		$this->assign('action_link', array('href' => RC_Uri::url('wechat/admin_customer/init'), 'text' => RC_Lang::get('wechat::wechat.customer_list')));

		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.edit_customer_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:多客服管理#.E7.BC.96.E8.BE.91.E5.AE.A2.E6.9C.8D.E7.8A.B6.E6.80.81" target="_blank">'. RC_Lang::get('wechat::wechat.edit_customer_help') .'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
	
		$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
		$this->assign('type', $type);
		$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
	
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$list = $this->db_customer->find(array('id' => $id));
		if ($list['kf_headimgurl']) {
			$str = '.jpg';
			$arr = explode($str, $list['kf_headimgurl']);
			if (!$arr[count($arr)-1] == "") {
				$list['kf_headimgurl'] = $list['kf_headimgurl'];
			} else {
				$list['kf_headimgurl'] = RC_Upload::upload_url().'/'.$list['kf_headimgurl'];
			}
		}
		$this->assign('list', $list);
		$this->assign('form_action', RC_Uri::url('wechat/admin_customer/update'));
	
		$this->assign_lang();
		$this->display('wechat_customer_edit.dwt');
	}
	
	/**
	 * 编辑客服处理
	 */
	public function update() {
		$this->admin_priv('wechat_customer_update');
		
		$id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
		$kf_account = !empty($_POST['kf_account']) ? trim($_POST['kf_account']) : '';
		$nickname = !empty($_POST['kf_nick']) ? trim($_POST['kf_nick']) : '';
		
		$info = $this->db_customer->find(array('id' => $id));
		$status = !empty($_POST['status']) ? intval($_POST['status']) : 0;
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		//判断客服账号是否重复
		$num = $this->db_customer->where(array('wechat_id' => $wechat_id, 'kf_account' => $kf_account, 'id' => array('neq' => $id)))->count();
		if ($num != 0) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.customer_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//获取原来的图片文件
		$old_kfimgurl = $info['kf_headimgurl'];
		
		if ($info['status'] == 0) {
			if ($status == 1) {
				//微信端添加客服账号
				$rs = $wechat->addKfaccount($kf_account, $nickname);
				if (RC_Error::is_error($rs)) {
					return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				if (!empty($old_kfimgurl)) {
					//微信端添加客服头像
					$imgurl = RC_Upload::upload_path() . $old_kfimgurl;
					$message = $wechat->uploadHeadimgKfaccount($kf_account, $imgurl);
					if (RC_Error::is_error($message)) {
						return $this->showmessage(wechat_method::wechat_error($message->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				}
			}
		} else {
			if ($status == 0) {
				//微信端删除客服账号
				$rs = $wechat->deleteKfaccount($kf_account);
			} else {
				//微信端更新客服账号
				$rs = $wechat->updateKfaccount($kf_account, $nickname);
			}
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		if ((isset($_FILES['kf_headimgurl']['error']) && $_FILES['kf_headimgurl']['error'] == 0) || (!isset($_FILES['kf_headimgurl']['error']) && isset($_FILES['kf_headimgurl']['tmp_name'] ) &&$_FILES['kf_headimgurl']['tmp_name'] != 'none')) {
			$upload = RC_Upload::uploader('image', array('save_path' => 'data/headimg', 'auto_sub_dirs' => false));
			$image_info = $upload->upload($_FILES['kf_headimgurl']);
			if (!empty($image_info)) {
				$kf_headimgurl = $upload->get_position($image_info);
				if ($status == 1) {
					if ($info['status'] == 1) {
						//微信端添加客服头像
						$imgurl = RC_Upload::upload_path() . $kf_headimgurl;
						$message = $wechat->uploadHeadimgKfaccount($kf_account, $imgurl);
						if (RC_Error::is_error($message)) {
							return $this->showmessage(wechat_method::wechat_error($message->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
						}
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
		
		$data = array(
			'kf_account' 	=> 	$kf_account,
			'kf_nick' 		=> 	$nickname,
			'status' 		=>	$status,
			'kf_headimgurl' =>  $kf_headimgurl
		);

		$this->db_customer->where(array('id' => $id))->update($data);
		
		ecjia_admin::admin_log($kf_account, 'edit', 'customer');
		return $this->showmessage(RC_Lang::get('wechat::wechat.edit_customer_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_customer/edit', array('id' => $id))));
	}
	
	public function remove() {
		$this->admin_priv('wechat_customer_delete');
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$info = $this->db_customer->find(array('id' => $id));

		if ($info['status'] == 1) {
			//微信端删除客服账号
			$rs = $wechat->deleteKfaccount($info['kf_account']);
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		$disk = RC_Filesystem::disk();
		$disk->delete(RC_Upload::upload_path() . $info['kf_headimgurl']);
		
		$this->db_customer->where(array('id' => $id))->delete();
		ecjia_admin::admin_log($info['kf_account'], 'remove', 'customer');
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_customer_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	public function get_customer() {
		$this->admin_priv('wechat_customer_manage');
		
		$this->load_kf_list();
		return $this->showmessage(RC_Lang::get('wechat::wechat.get_customer_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_customer/init')));
	}
	
	public function get_online_customer() {
		$this->admin_priv('wechat_customer_manage');
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$kf_account_list = $this->db_customer->where(array('wechat_id' => $wechat_id))->get_field('kf_account', true);
		$list = $wechat->getOnlineKflist();
		
		if (RC_Error::is_error($list)) {
			return $this->showmessage(wechat_method::wechat_error($list->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
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
				$where = array(
					'wechat_id' => $wechat_id,
					'kf_account' . db_create_in($arr)
				);
			} else {
				$where = array('wechat_id' => $wechat_id);
			}
			$this->db_customer->where($where)->update(array('online_status' => 0));
	
			if (!empty($list['kf_online_list'])) {
				foreach ($list['kf_online_list'] as $k => $v) {
					if (in_array($v['kf_account'], $kf_account_list)) {
						$data['online_status'] 	= $v['status'];
						$data['kf_id'] 			= $v['kf_id'];
						$data['accepted_case'] 	= $v['accepted_case'];
						$this->db_customer->where(array('kf_account' => $v['kf_account'], 'wechat_id' => $wechat_id))->update($data);
					} else {
						$data['kf_account'] 	= $v['kf_account'];
						$data['kf_id'] 			= $v['kf_id'];
						$data['online_status'] 	= $v['status'];
						$data['accepted_case'] 	= $v['accepted_case'];
						$data['wechat_id'] 		= $wechat_id;
						$this->db_customer->insert($data);
					}
				}
			}
		}
		return $this->showmessage(RC_Lang::get('wechat::wechat.get_online_customer_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_customer/init')));
	}
	
	public function toggle_show() {
		$this->admin_priv('wechat_customer_update');
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$id 	= intval($_POST['id']);
		$val    = intval($_POST['val']);
		$info 	= $this->db_customer->find(array('id' => $id));
		if ($val == 1) {
			//微信端添加客服账号
			$rs = $wechat->addKfaccount($info['kf_account'], $info['kf_nick']);
			ecjia_admin::admin_log($info['kf_account'], 'use', 'customer');
		} else {
			//微信端删除客服账号
			$rs = $wechat->deleteKfaccount($info['kf_account']);
			ecjia_admin::admin_log($info['kf_account'], 'stop', 'customer');
		}
		if (RC_Error::is_error($rs)) {
			return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'status' 				=> $val,
			'kf_wx'	 				=> '',
			'invite_wx'				=> '',
			'invite_expire_time' 	=> '',
			'invite_status'			=> ''
		);
		$this->db_customer->where(array('id' => $id))->update($data);
		return $this->showmessage(RC_Lang::get('wechat::wechat.switch_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_customer/init')));
	}
	
	public function edit_nick() {
		$this->admin_priv('wechat_customer_update');
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$data['kf_nick'] = !empty($_POST['value']) ? $_POST['value'] : '';
		$id = !empty($_POST['pk']) ? $_POST['pk'] : '';
		$info = $this->db_customer->find(array('id' => $id));
		
		if (empty($data['kf_nick'])) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.customer_nick_require'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($info['status'] == 1) {
			//微信端更新客服账号
			$rs = $wechat->updateKfaccount($info['kf_account'], $data['kf_nick']);
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		$this->db_customer->where(array('id' => $id))->update($data);
		ecjia_admin::admin_log($info['kf_account'], 'edit', 'customer');
		return $this->showmessage(RC_Lang::get('wechat::wechat.edit_nick_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	//客服消息记录
	public function customer_message() {
		$this->admin_priv('wechat_customer_message_manage');
	
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.customer_message'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.customer_message')));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.customer_list'), 'href'=> RC_Uri::url('wechat/admin_customer/init')));
		
		$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
		$this->assign('type', $type);
		$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
		
		$this->assign_lang();
		$this->display('wechat_customer_message.dwt');
	}
	
	//绑定微信号
	public function bind_wx() {
		$kf_account = !empty($_POST['kf_account']) ? $_POST['kf_account'] : '';
		$kf_wx = !empty($_POST['kf_wx']) ? trim($_POST['kf_wx']) : '';

		if (empty($kf_wx)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.bind_wx_require'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$rs = $wechat->inviteKfaccount($kf_account, $kf_wx);
		if (RC_Error::is_error($rs)) {
			return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$this->load_kf_list();
		return $this->showmessage(RC_Lang::get('wechat::wechat.invite_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_customer/init')));
	}
	
	/**
	 * 获取客服列表
	 */
	private function get_list() {
		$db_customer = RC_Loader::load_app_model('wechat_customer_model');
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$where['wechat_id'] = $wechat_id;
		if (isset($_GET['type'])) {
			$where['online_status'] = array('neq' => 0);
		}
		
		$list = $db_customer->where($where)->select();
		
		$where = '';
		$where = array('wechat_id' => $wechat_id, 'online_status' => array('neq' => 0));
		
		$filter['all'] = $db_customer->where(array('wechat_id' => $wechat_id))->count();
		$filter['online'] = $db_customer->where($where)->count();
		
		if (!empty($list)) {
			foreach ($list as $k => $v) {
				if ($v['kf_headimgurl']) {
					if ((strpos($v['kf_headimgurl'], 'http://') === false) && (strpos($v['kf_headimgurl'], 'https://') === false)) {
						$list[$k]['kf_headimgurl'] = RC_Upload::upload_url().'/'.$v['kf_headimgurl'];
					} else {
						$list[$k]['kf_headimgurl'] = $v['kf_headimgurl'];
					}
				} else {
					$list[$k]['kf_headimgurl'] = RC_Uri::admin_url('statics/images/nopic.png');
				}
				if ($v['invite_expire_time']) {
					$list[$k]['invite_expire_time'] = RC_Time::local_date(ecjia::config('time_format'), $v['invite_expire_time']-8*3600);
				}
			}
		}
		return array('item' => $list, 'filter' => $filter);
	}
	
	/**
	 * 刷新客服列表信息
	 */
	private function load_kf_list() {
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$kf_account_list = $this->db_customer->where(array('wechat_id' => $wechat_id))->get_field('kf_account', true);
		
		$list = $wechat->getKflist();
		if (RC_Error::is_error($list)) {
			return $this->showmessage(wechat_method::wechat_error($list->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (!empty($list)) {
			foreach ($list['kf_list'] as $key => $val) {
				$kf_list[] = $val['kf_account'];
			}
			//更新微信端获取不到的客服 本地状态变更为0
			if (!empty($kf_list)) {
				if (empty($kf_account_list)) {
					$kf_account_list = array();
				}
				$arr = array_diff($kf_account_list, $kf_list);
				$where = array(
					'wechat_id' => $wechat_id,
					'kf_account' . db_create_in($arr)
				);
			} else {
				$where = array('wechat_id' => $wechat_id);
			}
			$this->db_customer->where($where)->update(array('status' => 0));
			
			foreach ($list['kf_list'] as $k => $v) {
				if (in_array($v['kf_account'], $kf_account_list)) {
					$data['status']		= 1;
					$data['kf_id']		= $v['kf_id'];
					$data['kf_nick']	= $v['kf_nick'];
					$data['kf_wx']		= !empty($v['kf_wx']) ? $v['kf_wx'] : '';
						
					$data['invite_wx']			= !empty($v['invite_wx']) 			? $v['invite_wx'] 			: '';
					$data['invite_expire_time']	= !empty($v['invite_expire_time']) 	? $v['invite_expire_time'] 	: '';
					$data['invite_status']		= !empty($v['invite_status']) 		? $v['invite_status'] 		: '';
					$data['kf_headimgurl'] 		= $v['kf_headimgurl'];
					
					//微信端存在头像 删除本地头像
					if (!empty($data['kf_headimgurl'])) {
						$info = $this->db_customer->find(array('kf_account' => $v['kf_account'], 'wechat_id' => $wechat_id));
						if (!empty($info['kf_headimgurl'])) {
							if ((strpos($info['kf_headimgurl'], 'http://') === false) && (strpos($info['kf_headimgurl'], 'https://') === false)) {
								$disk = RC_Filesystem::disk();
								$disk->delete(RC_Upload::upload_path() . $info['kf_headimgurl']);
							}
						}
					}
					$this->db_customer->where(array('kf_account' => $v['kf_account'], 'wechat_id' => $wechat_id))->update($data);
				} else {
					$data['kf_id'] 			= $v['kf_id'];
					$data['kf_account'] 	= $v['kf_account'];
					$data['kf_nick'] 		= $v['kf_nick'];
					$data['kf_wx']			= !empty($v['kf_wx']) ? $v['kf_wx'] : '';
					$data['kf_headimgurl'] 	= $v['kf_headimgurl'];
					$data['wechat_id'] 		= $wechat_id;
					$data['status'] 		= 1;
						
					$data['invite_wx']			= !empty($v['invite_wx']) 			? $v['invite_wx'] 			: '';
					$data['invite_expire_time']	= !empty($v['invite_expire_time']) 	? $v['invite_expire_time'] 	: '';
					$data['invite_status']		= !empty($v['invite_status']) 		? $v['invite_status'] 		: '';
					$this->db_customer->insert($data);
				}
			}
		}
		return true;
	}
}

//end