<?php
/**
 * 公众号调用接口每日限制
 */
return array(
	/*获取接口调用凭据*/
	'token' => array(
		'title' => '获取access_token',
	    'times' => '2000',
	    'api' => 'https://api.weixin.qq.com/cgi-bin/token'
	),
	'getcallbackip' => array(
		'title' => '获取微信服务器IP地址',
		'times' => null,
		'api' => 'https://api.weixin.qq.com/cgi-bin/getcallbackip'
	),
		
	/*自定义菜单*/
    'menu/create' => array(
    	'title' => '自定义菜单创建',
        'times' => '1000',
        'api' => 'https://api.weixin.qq.com/cgi-bin/menu/create'
    ),
    'menu/get' => array(
    	'title' => '自定义菜单查询',
        'times' => '10000',
        'api' => 'https://api.weixin.qq.com/cgi-bin/menu/get'
    ),
    'menu/delete' => array(
    	'title' => '自定义菜单删除',
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/delete'
    ),
	'menu/addconditional' => array(
		'title' => '创建个性化菜单',
		'times' => '2000',
		'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/addconditional'
	),
	'menu/delconditional' => array(
		'title' => '删除个性化菜单',
		'times' => '2000',
		'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/delconditional'
	),
	'menu/trymatch' => array(
		'title' => '测试个性化菜单匹配结果',
		'times' => '20000',
		'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/trymatch'
	),
	'get_current_selfmenu_info' => array(
		'title' => '获取自定义菜单配置',
		'times' => null,
		'api'   => 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info'
	),
		
	/*用户管理*/
    'groups/create' => array(
    	'title' => '创建用户分组',
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/create'
    ),
    'groups/get' => array(
        'title' => '获取用户分组',
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/get'
    ),
	'groups/getid' => array(
		'title' => '查询用户所在分组',
		'times' => null,
		'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/getid'
	),
    'groups/update' => array(
        'title' => '修改用户分组名',
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/update'
    ),
    'groups/members/update' => array(
        'title' => '移动用户分组',
        'times' => '100000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/members/update'
    ),
    'groups/members/batchupdate' => array(
    	'title' => '批量移动用户分组',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate'
    ),
    'groups/delete' => array(
    	'title' => '删除用户分组',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/delete'
    ),
    'user/info/updateremark' => array(
    	'title' => '设置用户备注名',
    	'times' => '10000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark'
    ),
    'user/info' => array(
    	'title' => '获取用户基本信息',
    	'times' => '5000000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/info'
    ),
    'user/info/batchget' => array(
    	'title' => '批量获取用户基本信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/info/batchget'
    ),
    'user/get' => array(
    	'title' => '获取关注者列表',
    	'times' => '500',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/get'
    ),
    'tags/create' => array(
    	'title' => '创建标签',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/create'
    ),
    'tags/get' => array(
	    'title' => '获取公众号已创建的标签',
	    'times' => null,
	    'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/get'
    ),
    'tags/update' => array(
    	'title' => '编辑标签',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/update'
    ),
    'tags/delete' => array(
    	'title' => '删除标签',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/delete'
    ),
    'tags/getidlist' => array(
    	'title' => '获取用户身上的标签列表',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/getidlist'
    ),
    'tags/members/batchtagging' => array(
    	'title' => '批量为用户打标签',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging'
    ),
    'tags/members/batchuntagging' => array(
    	'title' => '批量为用户取消标签',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging'
    ),
    
    /*发送消息*/
    'customservice/kfaccount/add' => array(
    	'title' => '添加客服帐号',
    	'times' => null,
    	'api' => 'https://api.weixin.qq.com/customservice/kfaccount/add'
    ),
    'customservice/kfaccount/update' => array(
    	'title' => '修改客服帐号',
    	'times' => null,
    	'api' => 'https://api.weixin.qq.com/customservice/kfaccount/update'
    ),
    'customservice/kfaccount/del' => array(
    	'title' => '删除客服帐号',
    	'times' => null,
    	'api' => 'https://api.weixin.qq.com/customservice/kfaccount/del'
    ),
    'customservice/kfaccount/uploadheadimg' => array(
    	'title' => '设置客服帐号的头像',
    	'times' => null,
    	'api' => 'http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg'
    ),
    'customservice/getkflist' => array(
    	'title' => '获取所有客服账号',
    	'times' => null,
    	'api' => 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist'
    ),
    'customservice/getonlinekflist' => array(
    	'title' => '获取在线客服接待信息',
    	'times' => null,
    	'api' => 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist'
    ),
    'customservice/kfaccount/inviteworker' => array(
    	'title' => '邀请绑定客服帐号',
    	'times' => null,
    	'api' 	=> 'https://api.weixin.qq.com/cgi-bin/customservice/kfaccount/inviteworker'
    ),
    'message/custom/send' => array(
        'title' => '发送客服消息',
        'times' => '500000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/message/custom/send'
    ),
    'message/mass/sendall' => array(
    	'title' => '根据分组进行群发',
    	'times' => '100',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall'
    ),
    'message/mass/send' => array(
    	'title' => '根据OpenID列表群发',
    	'times' => '100',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/send'
    ),
    'message/mass/delete' => array(
    	'title' => '删除群发',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/delete'
    ),
    'message/mass/preview' => array(
    	'title' => '预览消息样式和排版',
    	'times' => '100',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/preview'
    ),
    'message/mass/get' => array(
    	'title' => '查询群发消息发送状态',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/get'
    ),
    'template/api_set_industry' => array(
    	'title' => '设置所属行业',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry'
    ),
    'template/api_add_template' => array(
    	'title' => '获得模板ID',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/template/api_add_template'
    ),
    'message/template/send' => array(
    	'title' => '发送模板消息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/template/send'
    ),
    'get_current_autoreply_info' => array(
    	'title' => '获取自动回复规则',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info'
    ),
    
    /*素材管理*/
    'material/add_news' => array(
    	'title' => '新增永久图文素材',
    	'times' => '5000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/add_news'
    ),
    'material/add_material' => array(
    	'title' => '新增其他类型永久素材',
    	'times' => '1000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/add_material'
    ),
    'material/get_material' => array(
    	'title' => '获取永久素材',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/get_material'
    ),
    'material/del_material' => array(
    	'title' => '删除永久素材',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/del_material'
    ),
    'material/update_news' => array(
    	'title' => '修改永久图文素材',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/update_news'
    ),
    'material/get_materialcount' => array(
    	'title' => '获取素材总数',
    	'times' => null, //图片和图文消息素材（包括单图文和多图文）的总数上限为5000，其他素材的总数上限为1000
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount'
    ),
    'material/batchget_material' => array(
    	'title' => '获取素材列表',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/batchget_material'
    ),
    
    /*账号管理*/
    'qrcode/create' => array(
        'title' => '创建二维码ticket',
        'times' => '100000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/qrcode/create'
    ),
    'showqrcode' => array(
    	'title' => '通过ticket换取二维码',
    	'times' => null,
    	'api'   => 'https://mp.weixin.qq.com/cgi-bin/showqrcode'
    ),
    'shorturl' => array(
    	'title' => '长链接转短链接',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/shorturl'
    ),
    
    /*数据统计*/
    'datacube/getusersummary' => array(
    	'title' => '获取用户增减数据',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusersummary'
    ),
    'datacube/getusercumulate' => array(
    	'title' => '获取累计用户数据',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusercumulate'
    ),
    'datacube/getarticlesummary' => array(
    	'title' => '获取图文群发每日数据',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getarticlesummary'
    ),
    'datacube/getarticletotal' => array(
    	'title' => '获取图文群发总数据',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getarticletotal'
    ),
    'datacube/getuserread' => array(
    	'title' => '获取图文统计数据',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getuserread'
    ),
    'datacube/getuserreadhour' => array(
    	'title' => '获取图文统计分时数据',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getuserreadhour'
    ),
    'datacube/getusershare' => array(
    	'title' => '获取图文分享转发数据',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusershare'
    ),
    'datacube/getusersharehour' => array(
    	'title' => '获取图文分享转发分时数据',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusersharehour'
    ),
    
    /*微信JS-SDK*/
    'ticket/getticket' => array(
    	'title' => '获取api_ticket',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/ticket/getticket'
    ),
    
    /*微信门店*/
    'media/uploadimg' => array(
    	'title' => '上传门店图片',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/media/uploadimg'
    ),
    'poi/addpoi' => array(
    	'title' => '创建门店',
    	'times' => null,
    	'api'   => 'http://api.weixin.qq.com/cgi-bin/poi/addpoi'
    ),
    'poi/getpoi' => array(
    	'title' => '查询门店信息',
    	'times' => null,
    	'api'   => 'http://api.weixin.qq.com/cgi-bin/poi/getpoi'
    ),
    'poi/getpoilist' => array(
   		'title' => '查询门店列表',
   		'times' => null,
   		'api'   => 'https://api.weixin.qq.com/cgi-bin/poi/getpoilist'
    ),
    'poi/updatepoi' => array(
   		'title' => '修改门店服务信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/poi/updatepoi'
    ),
    'poi/delpoi' => array(
   		'title' => '删除门店',
   		'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/poi/delpoi'
    ),
    'poi/getwxcategory' => array(
    	'title' => '门店类目表',
    	'times' => null,
    	'api'   => 'http://api.weixin.qq.com/cgi-bin/poi/getwxcategory'
    ),
    
    /*微信智能接口*/
    'semantic/semproxy/search' => array(
    	'title' => '发送语义理解请求',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/semantic/semproxy/search'
    ),
    
  	/*微信摇一摇周边*/
    'account/register' => array(
    	'title' => '申请开通摇一摇周边',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/account/register'
    ),
    'device/applyid' => array(
    	'title' => '申请设备ID',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/applyid'
    ),
    'device/applystatus' => array(
    	'title' => '查询设备ID申请审核状态',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/applystatus'
    ),
    'device/update' => array(
    	'title' => '编辑设备信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/update'
    ),
    'device/bindlocation' => array(
    	'title' => '配置设备与门店的关联关系',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/bindlocation'
    ),
    'device/search' => array(
    	'title' => '查询设备列表',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/search'
    ),
    'page/add' => array(
    	'title' => '新增页面',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/add'
    ),
    'page/update' => array(
    	'title' => '编辑页面信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/update'
    ),
    'page/search' => array(
    	'title' => '查询页面列表',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/search'
    ),
    'page/delete' => array(
    	'title' => '删除页面',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/delete'
    ),
    'material/add' => array(
    	'title' => '上传图片素材',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/material/add'
    ),
    'device/bindpage' => array(
    	'title' => '配置设备与页面的关联关系',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/bindpage'
    ),
    'relation/search' => array(
    	'title' => '查询设备与页面的关联关系',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/relation/search'
    ),
    'user/getshakeinfo' => array(
    	'title' => '获取摇周边的设备及用户信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/user/getshakeinfo'
    ),
    'statistics/device' => array(
    	'title' => '以设备为维度的数据统计',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/device'
    ),
    'statistics/devicelist' => array(
    	'title' => '批量查询设备统计数据',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/devicelist'
    ),
    'statistics/page' => array(
    	'title' => '以页面为维度的数据统计',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/page'
    ),
    'statistics/pagelist' => array(
    	'title' => '批量查询页面统计数据',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/pagelist'
    ),
    'lottery/addlotteryinfo' => array(
    	'title' => '创建红包活动',
    	'times' => null,
    	'api'   => ' https://api.weixin.qq.com/shakearound/lottery/addlotteryinfo'
    ),
    'lottery/setprizebucket' => array(
    	'title' => '录入红包信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/lottery/setprizebucket'
    ),
    'lottery/setlotteryswitch' => array(
    	'title' => '设置红包活动抽奖开关',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/lottery/setlotteryswitch'
    ),
    'lottery/querylottery' => array(
    	'title' => ' 红包查询',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/lottery/querylottery'
    ),
    'device/group/add' => array(
    	'title' => '新增设备分组',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/add'
    ),
    'device/group/update' => array(
    	'title' => '编辑设备分组信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/update'
    ),
    'device/group/delete' => array(
    	'title' => '删除设备分组',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/delete'
    ),
    'device/group/getlist' => array(
    	'title' => '查询设备分组列表',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/getlist'
    ),
    'device/group/getdetail' => array(
    	'title' => '查询设备分组详情',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/getdetail'
    ),
    'device/group/adddevice' => array(
    	'title' => '添加设备到设备分组',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/adddevice'
    ),
    'device/group/deletedevice' => array(
    	'title' => '从设备分组中移除设备',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/deletedevice'
    ),
    'openplugin/token' => array(
    	'title' => '第三方平台获取开插件wifi_token',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/openplugin/token'
    ),
    
    /*微信连Wi-Fi*/
    'shop/list' => array(
    	'title' => '获取WiFi门店列表',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/list'
    ),
    'shop/get' => array(
    	'title' => '查询门店的WiFi信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/get'
    ),
    'shop/update' => array(
    	'title' => '修改门店网络信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/update'
    ),
    'shop/clean' => array(
    	'title' => '清空门店网络及设备',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/clean'
    ),
    'device/add' => array(
    	'title' => '添加密码型Wi-Fi设备',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/device/add'
    ),
    'device/list' => array(
    	'title' => '查询Wi-Fi设备',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/device/list'
    ),
    'device/delete' => array(
    	'title' => '删除Wi-Fi设备',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/device/delete'
    ),
    'qrcode/get' => array(
    	'title' => '获取物料二维码',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/qrcode/get'
    ),
    'account/get_connecturl' => array(
    	'title' => '获取公众号连网URL',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/account/get_connecturl'
    ),
    'homepage/set' => array(
    	'title' => '设置商家主页',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/homepage/set'
    ),
    'homepage/get' => array(
    	'title' => '查询商家主页',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/homepage/get'
    ),
    'bar/set' => array(
    	'title' => '设置顶部常驻入口文案',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/bar/set'
    ),
    'statistics/list' => array(
    	'title' => 'Wi-Fi数据统计',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/statistics/list'
    ),
    
    /*微信扫一扫*/
    'merchantinfo/get' => array(
    	'title' => '获取商户信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/merchantinfo/get'
    ),
    'product/create' => array(
    	'title' => '创建商品',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/create'
    ),
    'product/modstatus' => array(
    	'title' => '提交审核/取消发布商品',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/modstatus'
    ),
    'testwhitelist/set' => array(
    	'title' => '设置测试人员白名单',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/testwhitelist/set'
    ),
    'product/getqrcode' => array(
    	'title' => '获取商品二维码',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/getqrcode'
    ),
    'product/get' => array(
    	'title' => '查询商品信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/get'
    ),
    'product/getlist' => array(
    	'title' => '批量查询商品信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/getlist'
    ),
    'product/update' => array(
    	'title' => '更新商品信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/update'
    ),
    'product/clear' => array(
    	'title' => '清除商品信息',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/clear'
    ),
    'scanticket/check' => array(
    	'title' => '检查wxticket参数',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/scanticket/check'
    ),
    'sns/oauth2/access_token' => array(
        'title' => '获取网页授权access_token',
        'times' => null,
        'api'   => 'https://api.weixin.qq.com/sns/oauth2/access_token'
    ),
    'sns/oauth2/refresh_token' => array(
        'title' => '刷新网页授权access_token',
        'times' => null,
        'api'   => 'https://api.weixin.qq.com/sns/oauth2/refresh_token'
    ),
    'sns/userinfo' => array(
        'title' => '网页授权获取用户信息',
        'times' => null,
        'api'   => 'https://api.weixin.qq.com/sns/userinfo'
    ),
    'sns/auth' => array(
    	'title' => '检验授权凭证（access_token）是否有效',
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/sns/auth'
    ),
);

//end