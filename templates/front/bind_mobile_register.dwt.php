{nocache}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head lang="zh-CN">
		<title>{t domain="wechat"}绑定手机号{/t}</title>
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/touch.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/style.css" />
	</head>
	
	<header class="ecjia-header">
		<div class="ecjia-header-left">
		</div>
		<div class="ecjia-header-title">{t domain="wechat"}绑定手机号{/t}</div>
	</header>
	<body>
		<div class="ecjia-form  ecjia-login">
			<div class="form-group margin-right-left">
				<label class="input">
					<span class="roaming">+86</span>
					<input placeholder='{t domain="wechat"}手机号{/t}' name="mobile_phone" class="mobile_phone">
				</label>
			</div>
			
			<div class="ecjia-login-b">
			    <div class="around">
			        <input type="hidden" name="openid" value="{$openid}">
			        <input type="hidden" name="uuid" value="{$uuid}">
			        <a class="ecjia-mobile_confirm btn" href="{url path='wechat/mobile_userbind/get_code'}">{t domain="wechat"}确定{/t}</a>
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