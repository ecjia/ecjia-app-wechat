<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.admin_subscribe.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- {if $unionid eq 1} -->
<div class="row">
	<div class="col-12">
	    <div class="alert alert-dismissible mb-2 alert-warning">
	    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><span aria-hidden="true">×</span></button>
	    	<strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.unionid_error_info'}
	    </div>
	</div>
</div>
<!-- {/if} -->

	
<!-- {if $errormsg} -->
<div class="row">
	<div class="col-12">
	    <div class="alert alert-dismissible mb-2 alert-error">
	    	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
	    </div>
	</div>
</div>
<!-- {/if} -->
	
<!-- {if $warn && $type eq 0} -->
<div class="row">
	<div class="col-12">
	    <div class="alert alert-dismissible mb-2 alert-error">
	    	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
	    </div>
	</div>
</div>
<!-- {/if} -->
	
<div class="row">
    <div class="col-12">
        <div class="card">
        	<div class="card-header">
                <h4 class="card-title">
                	{platform_account::getAccountSwtichDisplay('wechat')}
                </h4>
            </div>
            <div class="card-header">
                <h4 class="card-title">
                	{lang key='wechat::wechat.user_manage_synchro'}
                </h4>
            </div>
            <div class="card-body">
				<div><button type="button" class="ajaxmenu btn btn-info" data-url='{RC_Uri::url("wechat/platform_subscribe/get_usertag")}' data-value="get_usertag">{lang key='wechat::wechat.get_user_tag'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_user_tag_notice'}</span></div><br/>
				<div><button type="button" class="ajaxmenu btn btn-info" data-url='{RC_Uri::url("wechat/platform_subscribe/get_userinfo")}' data-value="get_userinfo">{lang key='wechat::wechat.get_user_info'}</button><span style="margin-left: 20px;">{lang key='wechat::wechat.get_user_info_notice'}</span></div><br/>
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
            </div>
			<div class="card-body">
				<button type="button" class="btn btn-info"><i class="fa fa-tag"></i> 打标签</button>
				<div class="form-inline float-right">
					<form class="form-inline" method="post" action="{$form_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="search_from">
						<div class="input-group">
			          		<input type="text" name="keywords" value="{$smarty.get.keywords}" class="form-control" placeholder="{lang key='wechat::wechat.search_user_placeholder'}">
			            	<div class="input-group-append">
			            		<button type="submit" class="btn btn-info search-btn">{lang key='wechat::wechat.search'}</button>
			             	</div>
			        	</div>
		        	</form>
				</div>
			</div>
			
            <div class="col-md-12">
                <div class="content-detached content-left col-md-9">
					<table class="table">
						<thead>
							<tr>
								<th class="table_checkbox w30"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
								<th class="w80">{lang key='wechat::wechat.headimg_url'}</th>
								<th class="w150">{lang key='wechat::wechat.nickname'}</th>
								<th class="w100">{lang key='wechat::wechat.province'}</th>
								<th class="w80">{lang key='wechat::wechat.subscribe_time'}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$list.item item=val} -->
							<tr class="big">
								<td><input class="checkbox" type="checkbox" name="checkboxes[]" value="{$val.openid}" /></td>
								<td>
									{if $val.headimgurl}
									<img class="thumbnail" src="{$val.headimgurl}">
									{else}
									<img class="thumbnail" src="{RC_Uri::admin_url('statics/images/nopic.png')}">
									{/if}
								</td>
								<td class="hide-edit-area">
									<span class="ecjaf-pre">
										{$val['nickname']}{if $val['sex'] == 1}{lang key='wechat::wechat.male_sign'}{else if $val.sex == 2}{lang key='wechat::wechat.female_sign'}{/if}<br/>{if $val.group_id eq 1 || $val.subscribe eq 0}{else}{if $val.tag_name eq ''}{lang key='wechat::wechat.no_tag'}{else}{$val.tag_name}{/if}{/if}<br>
										{$val.remark}
									</span>
									<div class="edit-list">
										<!-- {if $val.group_id neq 1 && $val.subscribe neq 0} -->
											<a class="set-label-btn cursor_pointer" data-openid="{$val.openid}" data-uid="{$val.uid}" data-url="{$get_checked}">{lang key='wechat::wechat.set_tag'}</a>&nbsp;|&nbsp;
										<!-- {/if} -->
										<a class="data-pjax" href='{url path="wechat/platform_subscribe/subscribe_message" args="uid={$val.uid}{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' title="{lang key='wechat::wechat.message_record'}">{lang key='wechat::wechat.message_record'}</a>
									</div>
								</td>
								<td>{$val['province']} - {$val['city']}</td>
								<td>{RC_Time::local_date('Y-m-d H:i:s', ($val['subscribe_time']-8*3600))}</td>
							</tr>
							<!--  {foreachelse} -->
							<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>						
				</div>
				<div class="sidebar-detached sidebar-right col-md-3">
					<div class="card">
						<div class="card-body">
				            <p class="lead"><h4>{lang key='wechat::wechat.user_tag_list'}</h4></p>
							<div class="media-list list-group">
								<div class="list-group-item list-group-item-action media {if $smarty.get.type eq 'all'}active{/if}">
									<a class="media-link" href="{url path="wechat/platform_subscribe/init" args="&type=all"}">
										<span class="media-body">
											<span class="{if $smarty.get.type eq 'all'}white{/if}">{lang key='wechat::wechat.all_user'}</span>
											<span class="badge badge-primary badge-pill">{$tag_arr.all}</span>
										</span>
									</a>
								</div>

								<!-- {if $tag_arr || $num} -->
									<!-- {if $tag_arr} -->
										<!-- {foreach from=$tag_arr.item item=val} -->
											<div class="list-group-item list-group-item-action media {if $val.id eq $smarty.get.id}active{/if}">
												<a class="{if $val.id eq $smarty.get.id}white{/if}" href='{url path="wechat/platform_subscribe/init" args="id={$val.id}&tag_id={$val.tag_id}&type=blacklist{if $val.tag_id neq 1}&type=subscribed{/if}"}'>
													{$val.name}
													<span class="badge badge-primary badge-pill">{$val.count}</span>
												</a>
												{if $val['tag_id'] != 0  && $val['tag_id'] != 1 && $val['tag_id'] != 2}
													<span class="float-right">
														<a class="subscribe-icon-edit {if $val.id eq $smarty.get.id}white{/if}" data-toggle="modal" href="#edit_tag" title="{lang key='wechat::wechat.edit_user_tag'}" data-name="{$val.name}" value="{$val.id}"><i class="ft-edit f_s15"></i></a>
														<a class="ajaxremove no-underline {if $val.id eq $smarty.get.id}white{/if}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_tag_confirm'}" href='{RC_Uri::url("wechat/platform_subscribe/remove","id={$val.id}&tag_id={$val.tag_id}")}' title="{lang key='wechat::wechat.remove_user_tag'}"><i class="ft-trash-2 f_s15 m_l5"></i></a>
													</span>
												{/if}
											</div>
										<!-- {/foreach} -->
									<!-- {/if} -->
									
									<!-- {if $num} -->
										<div class="list-group-item list-group-item-action media {if $smarty.get.type eq 'unsubscribe' && !$smarty.get.tag_id}active{/if}">
											<a class="{if $smarty.get.type eq 'unsubscribe' && !$smarty.get.tag_id}white{/if}" href='{url path="wechat/platform_subscribe/init" args="type=unsubscribe"}'>
												{lang key='wechat::wechat.cancel_subscribe'}
												<span class="badge badge-primary badge-pill">{$num}</span>
											</a>
										</div>
									<!-- {/if} -->
								<!-- {/if} -->
							</div>

				        </div>
					</div>
				</div>
            </div>
            <!-- {$list.page} -->
        </div>
    </div>
</div>


<div class="modal hide fade" id="edit_tag">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='wechat::wechat.edit_user_tag'}</h3>
	</div>
	<div class="modal-body" id="group_modal">
		<div class="row-fluid">
			<!-- {if $errormsg} -->
			    <div class="alert alert-error">
		            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
		        </div>
			<!-- {/if} -->
			
			<!-- {if $warn} -->
				<!-- {if $type eq 0} -->
				<div class="alert alert-error">
					<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
				</div>
				<!-- {/if} -->
			<!-- {/if} -->
			<div class="span12">
			<form class="form-horizontal" method="post" name="edit_tag" action="{url path='wechat/platform_subscribe/edit_tag'}">
				<fieldset>
					<div class="control-group formSep">
						<label class="control-label old_tag_name" for="user_name">{lang key='wechat::wechat.label_old_tag_name'}</label>
						<div class="controls w200 ecjiaf-wwb">
							<span class="old_tag"></span>
						</div>
					</div>	
					<div class="control-group formSep">
						<label class="control-label new_tag_name" for="user_name">{lang key='wechat::wechat.label_new_tag_name'}</label>
						<div class="controls">
							<input type="text" name="new_tag" autocomplete="off"/>
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group t_c m_b0">
						<button class="btn btn-gebo" type="submit" {if $errormsg}disabled{/if}>{lang key='wechat::wechat.ok'}</button>
						<input type="hidden" name="id" />
					</div>
				</fieldset>
			</form>
			</div>
		</div>
	</div>
</div>
	
<div class="modal hide fade" id="add_tag">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='wechat::wechat.add_user_tag'}</h3>
	</div>
	<div class="modal-body" id="group_modal">
		<div class="row-fluid">
			<!-- {if $errormsg} -->
			    <div class="alert alert-error">
		            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
		        </div>
			<!-- {/if} -->
			
			<!-- {if $warn} -->
				<!-- {if $type eq 0} -->
				<div class="alert alert-error">
					<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
				</div>
				<!-- {/if} -->
			<!-- {/if} -->
			<div class="span12">
			<form class="form-horizontal" method="post" name="add_tag" action="{url path='wechat/platform_subscribe/edit_tag'}">
				<fieldset>
					<div class="control-group formSep">
						<label class="control-label new_tag_name" for="user_name">{lang key='wechat::wechat.label_tag_name'}</label>
						<div class="controls">
							<input type="text" name="new_tag" autocomplete="off"/>
							<span class="input-must">*</span>
						</div>
					</div>
					<div class="control-group t_c m_b0">
						<button class="btn btn-gebo" type="submit" {if $errormsg}disabled{/if}>{lang key='wechat::wechat.ok'}</button>
					</div>
				</fieldset>
			</form>
			</div>
		</div>
	</div>
</div>

<div class="modal hide fade" id="set_label">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='wechat::wechat.set_tag'}</h3>
	</div>
	<div class="modal-body tag_popover">
		<!-- {if $errormsg} -->
	    <div class="alert alert-error">
            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
        </div>
		<!-- {/if} -->
		
		<!-- {if $warn} -->
			<!-- {if $type eq 0} -->
			<div class="alert alert-error">
				<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
			</div>
			<!-- {/if} -->
		<!-- {/if} -->
		<form class="form-inline" method="post" action="{$label_action}&action=set_label" name="label_form">
			<div class="popover_inner">
				<div class="popover_content">
					<div class="popover_tag_list">
					</div>
					<span class="label_block hide ecjiafc-red">{lang key='wechat::wechat.up_tag_count'}</span>
				</div>
				<input type="hidden" name="openid" />
				<div class="popover_bar"><a href="javascript:;" class="btn btn-gebo set_label" {if $errormsg}disabled{/if}>{lang key='wechat::wechat.ok'}</a>&nbsp;</div>
	   		</div>
	   	</form>
	</div>
</div>
<!-- {/block} -->