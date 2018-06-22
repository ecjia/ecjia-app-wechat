<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="weixin-menu-detail">
	<div class="menu-input-group" style="border-bottom: 2px #e8e8e8 solid;">
		<div class="menu-name">{$wechat_menus.name}</div>
		<div class="menu-del" data-toggle="del-menu" data-id="{$id}">删除子菜单</div>
	</div>
	<div class="menu-input-group">
		<div class="menu-label">菜单名称：</div>
		<div class="menu-input m_l10">
			<input type="text" name="name" placeholder="请输入菜单名称" class="form-control" value="{$wechat_menus.name}">
			<p class="menu-tips hide" style="color:#e15f63" v-show="menuNameBounds">
				字数超过上限
			</p>
			<p class="menu-tips">
				字数不超过4个汉字或8个字母
			</p>
		</div>
	</div>
	
	<div class="menu-input-group">
		<div class="menu-label">菜单类型：</div>
		<div class="menu-input m_l10">
			<input id="type_click" type="radio" name="type" value="click" {if $wechat_menus.type eq 'click'}checked{/if}><label for="type_click"><span>发送消息</span></label>
			<input id="type_view" type="radio" name="type" value="view" {if $wechat_menus.type eq 'view'}checked{/if}><label for="type_view"><span>跳转网页</span></label>
			<input id="type_miniprogram" type="radio" name="type" value="miniprogram" {if $wechat_menus.type eq 'miniprogram'}checked{/if}><label for="type_miniprogram"><span>跳转小程序</span></label>
		</div>
	</div>
	
	<div class="menu-input-group div-input" id="keydiv">
		<div class="menu-label">菜单关键词：</div>
		<div class="menu-input m_l10">
			<input class="form-control" type="text" name="key" id="key" value="{$wechat_menus.key}" />
			<p class="menu-tips hide" style="color:#e15f63" v-show="menuNameBounds">
				请设置菜单关键词
			</p>
		</div>
	</div>
	
	<div class="menu-input-group div-input" id="urldiv">
		<div class="menu-label">外链url：</div>
		<div class="menu-input m_l10">
			<input class="form-control" type="text" name="url" id="url" value="{$wechat_menus.url}" />
			<p class="menu-tips" style="color:#e15f63; display: none;">请设置外联url</p>
		</div>
	</div>
	
	<div class="menu-input-group div-input" id="weappdiv">
		<div class="menu-label">选择小程序：</div>
		<div class="menu-input m_l10">
			<select class="form-control" id="weapp_appid" name="weapp_appid">
		   		<option value='0'>请选择</option>
		  		<!-- {foreach from=$weapplist key=key item=val} -->
				<option value="{$key}" {if $key eq $wechat_menus.app_id}selected{/if}>{$val}</option>
				<!-- {/foreach} -->
			</select>
			<p class="menu-tips" style="color:#e15f63; display: none;">请选择小程序</p>
		</div>
	</div>
	
	<input type="hidden" name="id" value="{$id}">
</div>