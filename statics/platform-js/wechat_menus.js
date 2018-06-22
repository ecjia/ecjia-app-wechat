// JavaScript Document
;(function(app, $) {	
	app.wechat_menus_edit = {
			init : function() {
				$(".ajaxswitch").on('click', function(e){
					e.preventDefault();
					var url = $(this).attr('href');
					$.get(url, function(data){
						ecjia.platform.showmessage(data);
					}, 'json');
				});	
				
				$(document).on('click', 'input[name="type"]', function(e){
					if ($("input[name='type']:checked").val() == 'click') {
						$('#keydiv').show();
						$('#urldiv').hide();
						$('#weappdiv').hide();
						$("input[name='url']").val("");
					} else if ($("input[name='type']:checked").val() == 'view') {
						$('#keydiv').hide();
						$('#urldiv').show();
						$('#weappdiv').hide();
						$("input[name='key']").val("");
					} else {
						$('#keydiv').hide();
						$('#urldiv').hide();
						$('#weappdiv').show();
						$("input[name='url']").val("");
						$("input[name='key']").val("");
					}
				});
				$('input[name="type"]:checked').trigger('click');
				
				$('form').on('submit', function(e) {
					e.preventDefault();
					$(this).ajaxSubmit({
						dataType : "json",
						success : function(data) {
							ecjia.platform.showmessage(data);
						}
					});
				});
			}
		};
	
	
	app.wechat_menus_list = {
		init : function() {
			$(".ajaxswitch").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function(data){
					ecjia.platform.showmessage(data);
				}, 'json');
			});	
			
			
			$(".ajaxmenu").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('data-url');
				var message = $(this).attr('data-msg');
				if (message) {
					smoke.confirm(message,function(e){
						e && $.get(url, function(data){
							ecjia.platform.showmessage(data);
						}, 'json');
					}, {ok:js_lang.ok, cancel:js_lang.cancel});
				} else {
					$.get(url, function(data){
						ecjia.platform.showmessage(data);
					}, 'json');
				}
			});	
			
			app.wechat_menus_list.add();
			app.wechat_menus_list.edit();
			app.wechat_menus_list.remove();
			app.wechat_menus_list.save();
			app.wechat_menus_list.auto_save();
		},
		
		add: function() {
			$('[data-toggle="add-menu"]').off('click').on('click', function() {
				var $this = $(this),
					pid = $this.attr('data-pid'),
					url = $('input[name="add_url"]').val(),
					count = $this.attr('data-count');
				var info = {
					pid: pid
				}
				if (count == 0) {
					smoke.confirm('添加子菜单后，一级菜单的内容将被清除。确定添加子菜单？', function(e) {
						if (e) {
							$.post(url, info, function(data) {
								$('#weixin-menu').html(data.data);
								$('.weixin-menu-right-content').html(data.result);
								app.wechat_menus_edit.init();
								app.wechat_menus_list.init();
							});
						}
					}, {ok:"确定", cancel:"取消"});
				} else {
					$.post(url, info, function(data) {
						$('#weixin-menu').html(data.data);
						$('.weixin-menu-right-content').html(data.result);
						app.wechat_menus_edit.init();
						app.wechat_menus_list.init();
					});
				}
			});
		},
		
		edit: function() {
			$('[data-toggle="edit-menu"]').off('click').on('click', function() {
				var $this = $(this),
					id = $this.attr('data-id'),
					pid = $this.attr('data-pid'),
					url = $('input[name="edit_url"]').val();
				var info = {
					id: id,
					pid: pid
				}
				$.post(url, info, function(data) {
					$('.menu-sub-item').removeClass('current');
					$('.menu-item').removeClass('size1of1');
					if ($this.parent().hasClass('menu-item')) {
						$this.parent('.menu-item').addClass('size1of1');
						$('.weixin-sub-menu').addClass('hide');
						$this.parent('.menu-item').find('.weixin-sub-menu').removeClass('hide');
					} else {
						$this.parent('.menu-sub-item').addClass('current');
					}
					$('.weixin-menu-right-content').html(data.data);
					app.wechat_menus_edit.init();
					app.wechat_menus_list.init();
				});
			});
		},
		
		remove: function() {
			$('[data-toggle="del-menu"]').off('click').on('click', function() {
				var $this = $(this),
					id = $this.attr('data-id'),
					url = $('input[name="del_url"]').val();
				var info = {
					id: id
				}
				smoke.confirm('您确定要删除该菜单吗？', function(e) {
					if (e) {
						$.post(url, info, function(data) {
							ecjia.platform.showmessage(data);
						});
					}
				}, {ok:"确定", cancel:"取消"});
			});
		},
		
		save: function() {
			$('[data-toggle="btn-create"]').off('click').on('click', function() {
				var $this = $(this),
					url = $('input[name="check_url"]').val();
				$.post(url, function(data) {
					$('#weixin-menu').html(data.data);
					$('.weixin-menu-right-content').html(data.result);
					app.wechat_menus_edit.init();
					app.wechat_menus_list.init();
					$('.div-input').find('.menu-tips').removeClass('hide');
				});
			});
		},
		
		auto_save: function() {
			$('input[name="name"]').blur(function() {
				var $this = $(this),
					val = $this.val(),
					id = $('input[name="id"]').val(),
					url = $('input[name="update_url"]').val();
				var info = {
					'name': val,
					'id': id
				};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						ecjia.platform.showmessage(data);
						return false;
					}
					app.wechat_menus_list.check()
				})
			});
			
			$('input[name="type"]').change(function() {
				var $this = $(this),
					val = $('input[name="type"]:checked').val(),
					id = $('input[name="id"]').val(),
					url = $('input[name="update_url"]').val();
				var info = {
					'type': val,
					'id': id
				};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						ecjia.platform.showmessage(data);
						return false;
					}
					app.wechat_menus_list.check()
				})
			});
			
			$('input[name="key"]').blur(function() {
				var $this = $(this),
					val = $this.val(),
					id = $('input[name="id"]').val(),
					url = $('input[name="update_url"]').val();
				var info = {
					'key': val,
					'id': id
				};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						ecjia.platform.showmessage(data);
						return false;
					}
					app.wechat_menus_list.check()
				})
			});
			
			$('input[name="url"]').blur(function() {
				var $this = $(this),
					val = $this.val(),
					id = $('input[name="id"]').val(),
					url = $('input[name="update_url"]').val();
				var info = {
					'url': val,
					'id': id
				};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						ecjia.platform.showmessage(data);
						return false;
					}
					app.wechat_menus_list.check()
				})
			});
			
			$('input[name="weapp_appid"]').change(function() {
				var $this = $(this),
					val = $('select[name="weapp_appid"]:selected').val(),
					id = $('input[name="id"]').val(),
					url = $('input[name="update_url"]').val();
				var info = {
					'weapp_appid': val,
					'id': id
				};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						ecjia.platform.showmessage(data);
						return false;
					}
					app.wechat_menus_list.check()
				})
			});
		},
		
		check: function() {
			var url = $('input[name="check_url"]').val();
			$.post(url, function(data) {
				$('#weixin-menu').html(data.data);
				$('.weixin-menu-right-content').html(data.result);
				app.wechat_menus_edit.init();
				app.wechat_menus_list.init();
				$('.div-input').find('.menu-tips').removeClass('hide');
			});
		}
	};
	
})(ecjia.platform, jQuery);

// end