{nocache}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head lang="zh-CN">
		<title>绑定账号</title>
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/touch.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/style.css" />
	</head>
	
	<header class="ecjia-header">
		<div class="ecjia-header-left">
		</div>
		<div class="ecjia-header-title">关联账号</div>
	</header>
	<body>
		<div class="ecjia-form  ecjia-login">
			<div class="form-group margin-right-left ">
				<label class="input">
					<i class="iconfont icon-dengluyonghuming"></i>
					<input placeholder="{$lang.name_or_mobile}" name="username" datatype="*3-16|zh2-7" errormsg="用户名错误请重新输入！" nullmsg="请输入用户名户或手机号" />
				</label>
			</div>
			
			<div class="form-group ecjia-margin-t margin-right-left">
				<label class="input">
					<i class="iconfont icon-lock "></i>
					<i class="iconfont icon-attention ecjia-login-margin-l"  id="password1"></i>
					<input placeholder="{$lang.input_passwd}" name="password" type="password" id="password-1" datatype="*6-16" errormsg="密码错误请重新输入！" nullmsg="请输入密码" />
				</label>
			</div>
			
			<div class="ecjia-login-b">
			    <div class="around">
			        <input type="hidden" name="openid" value="{$openid}">
			         <input type="hidden" name="uuid" value="{$uuid}">
			        <a class="ecjia-bind-login btn" href="{url path='wechat/mobile_userbind/bind_login_insert'}">关联</a>
			    </div>	
			</div>
		</div>
		
		<script src="{$system_statics_url}/js/jquery.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/ecjia-js/ecjia.js" type="text/javascript"></script>
        
        <script src="{$front_url}/js/bind.js" type="text/javascript"></script>
        
        <script src="{$system_statics_url}/lib/chosen/chosen.jquery.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/js/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/smoke/smoke.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/js/jquery-cookie.min.js" type="text/javascript"></script>
        <script type="text/javascript">
       		 ecjia.bind.init();
        </script>
	</body>
</html>
{/nocache}