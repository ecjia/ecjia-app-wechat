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
		},
		
		add: function() {
			$('[data-toggle="add-menu"]').off('click').on('click', function() {
				var $this = $(this),
					pid = $this.attr('data-pid'),
					url = $('input[name="add_url"]').val();
				var info = {
					pid: pid
				}
				$.post(url, info, function(data) {
					ecjia.pjax(data.pjaxurl);
				});
				
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
					$('.weixin-menu-detail').html(data.data);
					app.wechat_menus_edit.init();
				});
				
			});
		},
	};
	
})(ecjia.platform, jQuery);

// end