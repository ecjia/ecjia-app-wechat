{if $list}
<ul>
	<!-- {foreach from=$list item=val} -->
	<li class="img_item">
		<label class="img_item_bd">
			<div class="pic_box"><img class="pic" src="{$val.file}" data-src="{$val.media_url}"/></div>
			<span class="lbl_content">{$val.file_name}</span>
			<div class="selected_mask">
	            <div class="selected_mask_inner"></div>
	            <div class="selected_mask_icon"></div>
	        </div>
		</label>
	</li>
	<!-- {/foreach} -->
</ul>
{else}
	<div class="empty_material">暂无图片素材</div>
{/if}