/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {
	ecjia.bind = {
		init: function() {
			$('.ecjia-bind-login').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('href');
				var username = $('input[name="username"]').val();
				var password = $('input[name="password"]').val();
				var openid = $('input[name="openid"]').val();
				var uuid = $('input[name="uuid"]').val();
				var info = {
					'username': username,
					'password': password,
					'openid': openid,
					'uuid': uuid,
				};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						alert(data.message);
					} else if (data.state == 'success'){
						location.href = data.url;
					}
				});
				
			});
		},
	};
})(ecjia, jQuery);

//end