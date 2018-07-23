// JavaScript Document
; (function (app, $) {
	app.material = {
		init: function () {
			app.material.choose_material();
		},
		choose_material: function () {
			$('.choose_material').off('click').on('click', function () {
				var $this = $(this);
				url = $this.attr('data-url'),
					type = $this.attr('data-type');
				var info = {
					type: type
				}
				$.post(url, info, function (data) {
					$('.inner_main').html(data.data);
					$('#choose_material').modal('show');
					app.material.img_item_click();
				})
			});

			$('.js-btn').off('click').on('click', function () {
				var $this = $('.img_item_bd.selected'),
					media_id = $this.find('.pic').attr('data-media'),
					src = $this.find('.pic').attr('src');
				var inner_html = '<div class="img_preview"><img class="preview_img margin_10" src="'+ src +'" alt=""><input type="hidden" name="media" value='+ media_id +'><a href="javascript:;" class="jsmsgSenderDelBt link_dele" onclick="return false;">删除</a></div>';
				
				if (media_id == undefined) {
					var html = $('.grid-item.selected');
					media_id = html.attr('data-media');
					inner_html = '<div class="weui-desktop-media__list-col margin_10">' + html[0]['outerHTML'] + '<input type="hidden" name="media" value='+ media_id +'></div><a href="javascript:;" class="jsmsgSenderDelBt link_dele p_l0" onclick="return false;">删除</a>';
				}
				$('.create-type__list').hide();
				$('.js_appmsgArea').append(inner_html);
				$('#choose_material').modal('hide');
			});
		},

		img_item_click: function () {
			$('.img_item').off('click').on('click', function () {
				var $this = $(this),
					child = $this.children('.img_item_bd');

				if (child.hasClass('selected')) {
					child.removeClass('selected');
					return false;
				}
				child.addClass('selected');
				$this.siblings('li').children('.img_item_bd').removeClass('selected');
			});
			
			$('.grid-item').off('click').on('click', function () {
				var $this = $(this);
				if ($this.hasClass('selected')) {
					$this.removeClass('selected');
					return false;
				}
				$this.addClass('selected').siblings('li').removeClass('selected');
				$this.parent().siblings('div').find('.grid-item').removeClass('selected');
			});
		},
	};
})(ecjia.platform, jQuery);

// end