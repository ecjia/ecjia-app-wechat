<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="menu-input-group" style="border-bottom: 2px #e8e8e8 solid;">
	<div class="menu-name">{$wechat_menus.name}</div>
	<div class="menu-del">删除菜单</div>
</div>
<div class="menu-input-group">
	<div class="menu-label">菜单名称</div>
	<div class="menu-input">
		<input type="text" name="name" placeholder="请输入菜单名称" class="menu-input-text" value="{$wechat_menus.name}">
		<p class="menu-tips hide" style="color:#e15f63" v-show="menuNameBounds">
			字数超过上限
		</p>
		<p class="menu-tips">
			字数不超过4个汉字或8个字母
		</p>
	</div>
</div>