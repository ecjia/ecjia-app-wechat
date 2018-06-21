<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_menus_list.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
{if $warn && $type eq 0}
<div class="alert alert-error">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
{/if}

{if $errormsg}
<div class="alert alert-error">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
{/if}

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                	{lang key='wechat::wechat.wechat_menu'}
                </h4>
            </div>
            <div class="card-body">
				<div><button type="button" class="ajaxmenu  btn" data-url='{RC_Uri::url("wechat/platform_menus/get_menu")}'>{lang key='wechat::wechat.get_menu'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_menu_notice'}</span></div><br/>
				<div><button type="button" class="ajaxmenu  btn" data-url='{RC_Uri::url("wechat/platform_menus/delete_menu")}' data-msg="{lang key='wechat::wechat.clear_menu_confirm'}">{lang key='wechat::wechat.clear_menu'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.clear_menu_notice'}</span></div><br/>
				<div><button type="button" class="ajaxmenu  btn" data-url='{RC_Uri::url("wechat/platform_menus/sys_menu")}'>{lang key='wechat::wechat.make_menu'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.make_menu_notice'}</span></div>
            </div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
                	{if $action_link}
					<a class="btn btn-light plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="ft-plus"></i>{$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-md-12">
				<div class="weixin-menu-content" style="">
		            <div id="weixin-app-menu">
		                <div class="weixin-menu-right">
							<div class="weixin-menu-detail">
							</div>
		                </div>
		                
		                <!-- 预览窗 -->
		                <div class="weixin-preview">
		                	<div class="mobile_menu_preview">
			                    <div class="weixin-hd">
			                        <div class="weixin-title">{$platformAccount->getAccountName()}</div>
			                    </div>
			                    <div class="weixin-bd">
			                        <ul class="weixin-menu" id="weixin-menu">
			                        
			                        	<!-- {foreach from=$menu_list item=list} -->
			                            <li class="menu-item">
			                                <div class="menu-item-title">
			                                    <span>菜单名称</span>
			                                </div>
			                                <ul class="weixin-sub-menu" v-show="selectedMenuIndex===i">
			                                    <li class="menu-sub-item">
			                                        <div class="menu-item-title">
			                                            <i class="icon14_menu_add"></i>
			                                        </div>
			                                    </li>
			                                    <i class="menu-arrow arrow_out"></i>
			                                    <i class="menu-arrow arrow_in"></i>
			                                </ul>
			                            </li>
			                            <li class="menu-item" v-if="menu.button.length<3" @click="addMenu(1)"> <i class="icon14_menu_add"></i></li>
			                            <!-- {foreachelse} -->
			                            
			                            <li class="menu-item size1of1">
			                                <div class="menu-item-title" data-toggle="add-menu" data-pid="0">
			                                    <i class="icon14_menu_add"></i>
			                                    <span>添加菜单</span>
			                                </div>
			                            </li>
			                            <!-- {/foreach} -->
			                            
			                        </ul>
			                    </div>
			            	</div>
		                </div>
		                
		            </div>
		            
		            {if $menu_list}
		            <div class="weixin-btn-group">
		                <div id="btn-create" class="btn btn-success">保存并发布</div>
		            </div>
		            {/if}
		            
		            <input type="hidden" name="add_url" value="{$form_action}" />
		        </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->