<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.subscribe_message.init();
	ecjia.platform.choose_material.init();
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
												<h5 class="media-text {if $msg.iswechat eq 1}text-left{/if}">
												{if $msg.type eq 'text'}{$msg.msg}{/if}
												
												{if $msg.type eq 'image'}
												<div class="img_preview">
													<img class="preview_img margin_10" src="{$msg.media_content.img_url}" title="点击查看" data-type="image">
												</div>
												{/if}
												
												{if $msg.type eq 'voice'}
												<div class="img_preview">
													<img class="preview_img margin_10" src="{$msg.media_content.img_url}" title="点击播放" data-src="{$msg.media_content.voice_url}" data-type="voice"></img>
												</div>
												{/if}
												
												{if $msg.type eq 'video'}
												<div class="img_preview">
													<img class="preview_img margin_10" src="{$msg.media_content.img_url}" title="点击播放" data-src="{$msg.media_content.video_url}" data-type="video"></img>
												</div>											
												{/if}
												
												{if $msg.type eq 'mpnews'}
												<div class="weui-desktop-media__list-col margin_10">
													<li class="thumbnail move-mod-group big grid-item">
														<!-- {foreach from=$msg.media_content.articles key=key item=val} -->
														{if $key eq 0}
													    <div class="article">
													        <div class="cover">
													            <a target="__blank" href="{$val.url}">
													                <img src="{$val.picurl}" />
													            </a>
													            <span>{$val.title}</span>
													        </div>
													    </div>
													    {else}
													    <div class="article_list">
													        <div class="f_l">{$val.title}</div>
													        <a target="__blank" href="{$val.url}">
													            <img src="{$val.picurl}" class="pull-right" />
													        </a>
													    </div>
														{/if}
													    <!-- {/foreach} -->
													</li>
												</div>
												{/if}
												</h5>
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
										<div class="col-md-7 controls p_l0">
											{if $info['headimgurl']}
												<img class="thumbnail" src="{$info['headimgurl']}" alt="{$info['nickname']}"/>
											{else}
												<img class="thumbnail" src="{RC_Uri::admin_url('statics/images/nopic.png')}">
											{/if}
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_nickname'}</label>
										<div class="col-md-7 controls p_l0">
											<span class="">{$info.nickname}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_remark'}</label>
										<div class="col-md-7 controls p_l0">
											<span class="">
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
										<div class="col-md-7 controls p_l0">
											<span class="">{if $info['sex'] == 1}{lang key='wechat::wechat.male'}{else if $info.sex == 2}{lang key='wechat::wechat.female'}{/if}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_province'}</label>
										<div class="col-md-7 controls p_l0">
											<span class="">{$info['province']} - {$info['city']}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_user_tag'}</label>
										<div class="col-md-7 controls p_l0">
											<span class="">{if $info['group_id'] eq 1}{else}{if $info['tag_name']}{$info['tag_name']}{else}{lang key='wechat::wechat.no_tag'}{/if}{/if}</span>
											<!-- {if $info.group_id neq 1 && $info.subscribe neq 0} -->
											<a class="set-label-btn" data-openid="{$info.openid}" data-uid="{$info.uid}" data-url="{$get_checked}" href="javascript:;"><i class="ft-tag"></i></a>
											<!-- {/if} -->
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right">{lang key='wechat::wechat.label_subscribe_time'}</label>
										<div class="col-md-7 controls p_l0">
											<span class="">{$info['subscribe_time']}</span>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-md-5 label-control text-right"></label>
										<div class="col-md-7 controls p_l0">
											<!-- {if $info.group_id eq 1} -->
											<a class="ajaxremove no-underline btn btn-outline-primary m_t14" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_blacklist_confirm'}" href='{RC_Uri::url("wechat/platform_subscribe/black_user","openid={$info.openid}&uid={$info.uid}&type=remove_out&page={$smarty.get.page}")}' title="{lang key='wechat::wechat.remove_blacklist'}">{lang key='wechat::wechat.remove_blacklist'}</a>
											<!-- {else} -->
												<!-- {if $info.subscribe eq 0} -->
												<a class="btn m_t14" disabled>{lang key='wechat::wechat.add_blacklist'}</a>
												<!-- {else} -->
												<a class="ajaxremove no-underline btn btn-outline-primary m_t14" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.add_blacklist_confirm'}" href='{RC_Uri::url("wechat/platform_subscribe/black_user","openid={$info.openid}&uid={$info.uid}&page={$smarty.get.page}")}' title="{lang key='wechat::wechat.add_blacklist'}">{lang key='wechat::wechat.add_blacklist'}</a>
												<!-- {/if} -->
											<!-- {/if} -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-12 col-lg-12 material-table m_t20 p_l0">
						<ul class="nav nav-tabs nav-only-icon nav-top-border no-hover-bg">
							<li class="nav-item" data-type="text">
								<a class="nav-link active" data-toggle="tab" title="{lang key='wechat::wechat.text'}"><i class="fa fa-pencil"> 文字</i></a>
							</li>
							<li class="nav-item" data-type="image">
								<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.image'}"><i class="fa fa-file-image-o"> 图片</i></a>
							</li>
							<li class="nav-item" data-type="voice">
								<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.voice'}"><i class="fa fa-music"> 语音</i></a>
							</li>
							<li class="nav-item" data-type="video">
								<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.video'}"><i class="fa fa-video-camera"> 视频</i></a>
							</li>
							<li class="nav-item" data-type="news">
								<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.text_message'}"><i class="fa fa-list-alt"> 图文</i></a>
							</li>
						</ul>
                   		<div class="text m_b10">
                   			<textarea class="m_t10 span12 form-control" name="content" cols="40" rows="5" id="chat_editor"></textarea>
							<div class="js_appmsgArea">
								<div class="tab_cont_cover create-type__list">
									<div class="create-type__item">
										<a href="javascript:;" class="create-type__link choose_material" data-type="" data-url="{RC_Uri::url('wechat/platform_material/choose_material')}&material=1">
											<i class="create-type__icon file"></i>
											<strong class="create-type__title">从素材库选择</strong>
										</a>
									</div>
								</div>
							</div>
                    	</div>
              			
              			<span class="tip_info">{lang key='wechat::wechat.tip_info'}</span>
						<span class="word_info">{lang key='wechat::wechat.word_info'}</span>
						<input type="hidden" name="chat_user" id="chat_user" value="{$info.uid}" />
						<input type="hidden" name="openid" id="openid" value="{$info.openid}" />
						<input type="hidden" name="nickname" id="nickname" value="{$info.nickname}" />
						<input type="hidden" name="account_name" id="account_name" value="{$account_name}" />
						<a class="btn f_r btn-info send_msg" href="javascript:;">{lang key='wechat::wechat.send_msg'}</a>				
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

<!-- {include file="./library/wechat_choose_material.lbi.php"} -->

<!-- {include file="./library/wechat_show_message.lbi.php"} -->

<!-- {/block} -->