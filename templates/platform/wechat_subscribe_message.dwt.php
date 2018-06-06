<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.subscribe_message.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

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
                	{$ur_here}
	               	{if $action_link}
					<a class="btn btn-light plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-lg-12">
				<div class="chat_box row" data-url='{$chat_action}' style="padding-left:15px;">
					<div class="col-xl-8 col-lg-12 chat_content h550">
						<div class="card">
							<div class="card-header popover-header">
								<h4 class="card-title">{lang key='wechat::wechat.label_chat_user'}<span class="act_users">{$info.nickname}</span></h4>
							</div>
							<div class="card-content collapse show popover-body chat-box">
								<div class="chat_msg clearfix">
									<div class="chat_msg_heading t_c"><a class="readed_message" href="javascript:;" data-chatid="{$info.uid}" data-lastid="{$message.last_id}" data-href="{$last_action}">{lang key='wechat::wechat.view_earlier_message'}</a></div>
								</div>
								<div class="card-body">
									<div class="chat_msg media-list">
										<!-- {foreach from=$message.item item=msg} -->
										<div class="media {if $msg.iswechat eq 1} chat-msg-mine{else} chat-msg-you{/if} last_chat">
											<div class="media-body">
												<h5 class="media-heading"><span class="chat_msg_date">{$msg.send_time}</span><span class="chat_user_name">{$msg.nickname}</span></h5>
												<h5 class="media-text {if $msg.iswechat eq 1}text-right{/if}">{$msg.msg}</h5>
											</div>
										</div>
										<!-- {/foreach} -->
										<div class="media msg_clone chat-msg-mine" style="display:none">
											<div class="media-body">
												<h5 class="media-heading"><span class="chat_msg_date"></span><span class="chat_user_name"></span></h5>
												<h5 class="media-text"></h5>
											</div>
										</div>
									</div>
								</div>
							</div>
								<div class="chat_editor_box">
									<textarea class="col-lg-12" name="chat_editor" id="chat_editor" cols="30" rows="3" maxlength="600"></textarea>
									<div class="btn-group send_btns">
										<a class="btn btn-small btn-info {if !$disabled}send_msg{/if}" {if $disabled}disabled="disabled"{/if} href="javascript:;">{lang key='wechat::wechat.send_msg'}</a>
									</div>
									<span class="tip_info">{lang key='wechat::wechat.tip_info'}</span>
									<span class="word_info">{lang key='wechat::wechat.word_info'}</span>
									<input type="hidden" name="chat_user" id="chat_user" value="{$info.uid}" />
									<input type="hidden" name="openid" id="openid" value="{$info.openid}" />
									<input type="hidden" name="nickname" id="nickname" value="{$info.nickname}" />
									<input type="hidden" name="platform_name" id="platform_name" value="{$info.platform_name}" />
								</div>
						</div>
					</div>
					
					
					<div class="col-xl-4 col-lg-12">
						<div class="card info_content h550">
							<div class="card-header popover-header">
								<h4 class="card-title">{lang key='wechat::wechat.user_info'}</h4>
							</div>
							<div class="card-body popover-body">
								<div class="form-body">
									<div class="form-group row p_t20">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_user_headimgurl'}</label>
										<div class="col-md-7 controls">
											{if $info['headimgurl']}
												<img class="thumbnail" src="{$info['headimgurl']}" alt="{$info['nickname']}"/>
											{else}
												<img class="thumbnail" src="{RC_Uri::admin_url('statics/images/nopic.png')}">
											{/if}
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_nickname'}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">{$info.nickname}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_remark'}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">
												<span class="remark_info p_r5">{$info.remark}</span>
											</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.lable_sex'}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">{if $info['sex'] == 1}{lang key='wechat::wechat.male'}{else if $info.sex == 2}{lang key='wechat::wechat.female'}{/if}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_province'}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">{$info['province']} - {$info['city']}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.lable_user_group'}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">
												<!-- {foreach from=$group_list item=val} -->
													<!-- {if $val.group_id eq $info.group_id} -->
														<span class="group_info p_r5">{$val.name}</span>
													<!-- {/if} -->
												<!-- {/foreach} -->
											</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_subscribe_time'}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">{$info['subscribe_time']}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_bind_user'}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">{if $info['user_name']}{$info['user_name']}{else}{lang key='wechat::wechat.not_bind_yet'}{/if}</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
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
		<form class="form-inline" method="post" action="{$label_action}&action=set_user_label" name="label_form">
			<div class="popover_inner">
				<div class="popover_content">
					<div class="popover_tag_list">
						<!-- {foreach from=$group_list.item item=val} -->
						<label class="frm_checkbox_label">
							{if $val.group_id neq 1}
							<input type="checkbox" class="frm_checkbox" name="group_id[]" value="{$val.group_id}">
							<span class="lbl_content">{$val.name}</span>
							{/if}
						</label>
						<!-- {/foreach} -->
					</div>
					<span class="help-block m_b5">{lang key='wechat::wechat.up_tag_count'}</span>
				</div>
				<input type="hidden" name="openid" />
				<input type="hidden" name="uid" />
				<div class="popover_bar"><a href="javascript:;" class="btn btn-gebo set_label" {if $errormsg}disabled{/if}>{lang key='wechat::wechat.ok'}</a>&nbsp;</div>
	   		</div>
	   	</form>
	</div>
</div>
<!-- {/block} -->