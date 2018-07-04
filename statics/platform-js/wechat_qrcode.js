// JavaScript Document
;(function(app, $) {
	app.wechat_qrcode_list = {
		init : function() {
			$("form[name='searchForm'] .search_qrcode").off('click').on('click', function(e){
				e.preventDefault();
				var url = $("form[name='searchForm']").attr('action') + '&keywords=' +$("input[name='keywords']").val();
				ecjia.pjax(url);
			});		
			
			$(".ajaxswitch").off('click').on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function(data){
					ecjia.platform.showmessage(data);
				}, 'json');
			});
			
			$(".ajaxwechat").off('click').on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function(data){
					if (data.state == 'error') {
						ecjia.platform.showmessage(data);
					}
					var img = '<img style="-webkit-user-select: none;" src='+ data.url +'>';
					$('#show_qrcode').find('.modal-body').html(img);
					$('#show_qrcode').modal('show');
				}, 'json');
			});	
		}
	};
	
	/* **编辑** */
	app.wechat_qrcode_edit = {
			init : function() {
				app.wechat_qrcode_edit.submit_form();
			},
			submit_form : function(formobj) {
				var $form = $("form[name='theForm']");
				var option = {
					rules : {
						functions : { required : true },
						scene_id : { required : true }
					},
					messages : {
						functions : { required : js_lang.qrcode_funcions_required },
						scene_id : { required : js_lang.application_adsense_required }
					},
					submitHandler : function() {
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								ecjia.platform.showmessage(data);
							}
						});
						
					}
				}
				var options = $.extend(ecjia.platform.defaultOptions.validate, option);
				$form.validate(options);
			}
		};
	
})(ecjia.platform, jQuery);

// end