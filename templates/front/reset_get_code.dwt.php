{nocache}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head lang="zh-CN">
		<title>{t domain="wechat"}重设密码{/t}</title>
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/touch.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/style.css" />
	</head>
	
	<header class="ecjia-header">
		<div class="ecjia-header-left">
		</div>
		<div class="ecjia-header-title">{t domain="wechat"}设置新密码{/t}</div>
	</header>
	<body>
	   <div class="ecjia-form ecjia-login">
	   		<input name="mobile" type="hidden" value="{$mobile}" />
	    	<p class="text-st-mobile">{t domain="wechat"}绑定手机号：{/t}{$mobile}</p>
	        <p class="text-st">{t domain="wechat"}请输入收到的短信验证码{/t}</p>
	    	<div class="form-group small-text">
	    		<label class="input-1">
	    			<input name="code" type="text" value="" placeholder='{t domain="wechat"}输入验证码{/t}' />
	    		</label>
	    	</div>
	    	<div class="small-submit">
	            <a class="get_code btn" id="get_code" href="{url path='wechat/mobile_profile/get_code'}">{t domain="wechat"}获取验证码{/t}</a>
	        </div>
	    	 <div class="around">
	    	  <a class="next_pwd btn ecjia-login-margin-top" href="{url path='wechat/mobile_profile/next_pwd'}">{t domain="wechat"}下一步{/t}</a>
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