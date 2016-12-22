<?php
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_request_times_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
// 		$this->db_config = RC_Config::load_config('database');
// 		$this->db_setting = 'zhong';
		$this->table_name = 'wechat_request_times';
		parent::__construct();
	}

}

// end