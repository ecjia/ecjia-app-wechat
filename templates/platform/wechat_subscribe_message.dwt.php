<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.subscribe_message.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- {if $errormsg} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
<!-- {/if} -->

<!-- {if $warn && $type eq 0} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
<!-- {/if} -->

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
	               	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-lg-12 card-body">
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
												<h5 class="media-text {if $msg.iswechat eq 1}text-left{/if}">{$msg.msg}</h5>
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
												{if $info.remark}
													<span class="remark_info p_r5">{$info.remark}</span>
												{/if}
												{if $info['group_id'] neq 1 && $info['subscribe'] neq 0}
												<a class="edit_remark_icon" ><i class="ft-edit"></i></a>
												{/if}
												<span class="remark" style="display:none;">
													<input class="remark w100 form-control f_l" type="text" name="remark" value="{$info.remark}" maxlength="30">
													<a class="edit_remark_url m_l10" href="javascript:;" 
														data-page="{$smarty.get.page}" data-remark="{$info.remark}" data-uid="{$info.uid}" 
														data-openid="{$info.openid}" data-url="{RC_Uri::url('wechat/platform_subscribe/edit_remark')}">
														<i class="fa fa-check remark_ok"></i>
														<i class="fa fa-times remark_cancel"></i>
													</a>
												</span>
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
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_user_tag'}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">{if $info['group_id'] eq 1}{else}{if $info['tag_name']}{$info['tag_name']}{else}{lang key='wechat::wechat.no_tag'}{/if}{/if}</span>
											<!-- {if $info.group_id neq 1 && $info.subscribe neq 0} -->
											<a class="set-label-btn" data-openid="{$info.openid}" data-uid="{$info.uid}" data-url="{$get_checked}" href="javascript:;"><i class="ft-tag"></i></a>
											<!-- {/if} -->
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_subscribe_time'}</label>
										<div class="col-md-7 controls">
											<span class="p_l10">{$info['subscribe_time']}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right"></label>
										<div class="col-md-7 controls">
											<!-- {if $info.group_id eq 1} -->
											<a class="ajaxremove no-underline btn btn-outline-primary m_t14" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_blacklist_confirm'}" href='{RC_Uri::url("wechat/platform_subscribe/backlist","uid={$info.uid}&openid={$info.openid}&type=remove_out&page={$smarty.get.page}")}' title="{lang key='wechat::wechat.remove_blacklist'}">{lang key='wechat::wechat.remove_blacklist'}</a>
											<!-- {else} -->
												<!-- {if $info.subscribe eq 0} -->
												<a class="btn m_t14" disabled>{lang key='wechat::wechat.add_blacklist'}</a>
												<!-- {else} -->
												<a class="ajaxremove no-underline btn btn-outline-primary m_t14" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.add_blacklist_confirm'}" href='{RC_Uri::url("wechat/platform_subscribe/backlist","uid={$info.uid}&openid={$info.openid}&page={$smarty.get.page}")}' title="{lang key='wechat::wechat.add_blacklist'}">{lang key='wechat::wechat.add_blacklist'}</a>
												<!-- {/if} -->
											<!-- {/if} -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-12 col-lg-12 material-table m_t20" data-url="{url path='wechat/platform_response/get_material_list'}">
						<ul class="nav nav-tabs nav-only-icon nav-top-border no-hover-bg">
							<li class="nav-item text-material">
								<a class="nav-link active" data-toggle="tab" title="{lang key='wechat::wechat.text'}"><i class="fa fa-pencil"> 文字</i></a>
							</li>
							<li class="nav-item picture-material">
								<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.image'}"><i class="fa fa-file-image-o"> 图片</i></a>
							</li>
							<li class="nav-item music-material">
								<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.voice'}"><i class="fa fa-music"> 语音</i></a>
							</li>
							<li class="nav-item video-material">
								<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.video'}"><i class="fa fa-video-camera"> 视频</i></a>
							</li>
							<li class="nav-item list-material">
								<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.text_message'}"><i class="fa fa-list-alt"> 图文</i></a>
							</li>
						</ul>
                   		<div class="text m_b10 {if $data.media_id}hidden{/if}">
                   			<textarea class="m_t10 span12 form-control" name="content" cols="40" rows="5" id="chat_editor"></textarea>
                    	</div>
                    	
    					<div class="material_picture {if empty($data.media_id)}hidden{/if}">
                        	{if $data['media']}
                       			{if $data['media']['type'] == 'voice'}
                           			<input type='hidden' name='media_id' value="{$data['media_id']}"><img src="{$data['media']['file']}" class='img-rounded material_show' />
                          		{elseif $subscribe['media']['type'] == 'video'}
                             		<input type='hidden' name='media_id' value="{$data['media_id']}"><img src="{$data['media']['file']}" class='img-rounded material_show' />
                         		{else}
                        			<input type='hidden' name='media_id' value="{$data['media_id']}"><img src="{$data['media']['file']}" class='img-rounded material_show' />
                     			{/if}
                    		{/if}
              			</div>
              			
              			<span class="tip_info">{lang key='wechat::wechat.tip_info'}</span>
						<span class="word_info">{lang key='wechat::wechat.word_info'}</span>
						<input type="hidden" name="chat_user" id="chat_user" value="{$info.uid}" />
						<input type="hidden" name="openid" id="openid" value="{$info.openid}" />
						<input type="hidden" name="nickname" id="nickname" value="{$info.nickname}" />
						<input type="hidden" name="platform_name" id="platform_name" value="{$info.platform_name}" />
						<a class="btn f_r btn-info {if !$disabled}send_msg{/if}" {if $disabled}disabled{/if} href="javascript:;">{lang key='wechat::wechat.send_msg'}</a>				
					</div>
				</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="set_label">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">{lang key='wechat::wechat.set_tag'}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			</div>
			<!-- {if $errormsg} -->
		    <div class="alert alert-danger">
	            <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
	        </div>
			<!-- {/if} -->
			
			<!-- {if $warn} -->
				<!-- {if $type eq 0} -->
				<div class="alert alert-danger">
					<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
				</div>
				<!-- {/if} -->
			<!-- {/if} -->
			
			<form class="form" method="post" action="{$label_action}&action=set_user_label" name="label_form">
				<div class="modal-body tag_popover">
					<div class="popover_inner p_b0">
						<div class="popover_content">
							<div class="popover_tag_list">
							<!-- {foreach from=$group_list.item item=val} -->
							<label class="frm_checkbox_label">
								{if $val.group_id neq 1}
								<input type="checkbox" class="frm_checkbox" name="tag_id[]" value="{$val.group_id}" id="tag_{$val.group_id}">
								<label for="tag_{$val.group_id}"></label>
								<span class="lbl_content">{$val.name}</span>
								{/if}
							</label>
							<!-- {/foreach} -->
							</div>
							<span class="label_block hide ecjiafc-red">{lang key='wechat::wechat.up_tag_count'}</span>
						</div>
			   		</div>
		   		</div>
		   	
			   	<div class="modal-footer justify-content-center">
			   		<input type="hidden" name="openid" />
			   		<input type="hidden" name="uid" />
					<button type="button" class="btn btn-outline-primary set_label" {if $errormsg}disabled{/if}>{lang key='wechat::wechat.ok'}</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- {/block} -->