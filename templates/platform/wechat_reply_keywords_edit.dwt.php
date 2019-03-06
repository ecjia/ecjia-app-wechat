<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.response.init();
	ecjia.platform.choose_material.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

{if $errormsg}
<div class="alert alert-danger">
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
</div>
{/if}

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

            <div class="col-lg-12">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						<div class="form-body">
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}规则名称：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" class="w280" name="rule_name" maxlength="60" size="30" value="{$data.rule_name}" />
									<div class="help-block">{t domain="wechat"}规则名最多60个字{/t}</div>
								</div>
								<span class="input-must">*</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{t domain="wechat"}关键字：{/t}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" class="w280" name="rule_keywords" maxlength="60" size="30" value="{$data.rule_keywords_string}" />
									<div class="help-block">{t domain="wechat"}添加多个关键字，用","隔开（建议在一个规则里设置一个关键字，以便粉丝获得想要的答案）。{/t}</div>
								</div>
								<span class="input-must">*</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">
                                    {t domain="wechat"}回复：{/t}
								</label>
								<div class="col-lg-8 controls material-table">
									<ul class="nav nav-tabs nav-only-icon nav-top-border no-hover-bg">
										<li class="nav-item" data-type="text">
											<a class="nav-link {if $data.reply_type eq 'text'}active{/if}" data-toggle="tab" title='{t domain="wechat"}文本{/t}'><i class="fa fa-pencil"> {t domain="wechat"}文字{/t}</i></a>
										</li>
										<li class="nav-item" data-type="image">
											<a class="nav-link {if $data.reply_type eq 'image'}active{/if}" data-toggle="tab" title='{t domain="wechat"}图片{/t}'><i class="fa fa-file-image-o"> {t domain="wechat"}图片{/t}</i></a>
										</li>
										<li class="nav-item" data-type="voice">
											<a class="nav-link {if $data.reply_type eq 'voice'}active{/if}" data-toggle="tab" title='{t domain="wechat"}语音{/t}'><i class="fa fa-music"> {t domain="wechat"}语音{/t}</i></a>
										</li>
										<li class="nav-item" data-type="video">
											<a class="nav-link {if $data.reply_type eq 'video'}active{/if}" data-toggle="tab" title='{t domain="wechat"}视频{/t}'><i class="fa fa-video-camera"> {t domain="wechat"}视频{/t}</i></a>
										</li>
										<li class="nav-item" data-type="news">
											<a class="nav-link {if $data.reply_type eq 'news'}active{/if}" data-toggle="tab" title='{t domain="wechat"}图文消息{/t}'><i class="fa fa-list-alt"> {t domain="wechat"}图文{/t}</i></a>
										</li>
									</ul>
			                   		<div class="text m_b10">
			                   			<textarea class="m_t10 span12 form-control {if $data.reply_type neq 'text'}hide{/if}" name="content" cols="40" rows="5" id="chat_editor">{$data.content}</textarea>
										<div class="js_appmsgArea" {if $data.reply_type neq 'text'}style="display: block;"{/if}>
											<div class="tab_cont_cover create-type__list" {if $data.id}style="display: none;"{/if}>
												<div class="create-type__item">
													<a href="javascript:;" class="create-type__link choose_material" data-type="{$data.reply_type}" data-url="{RC_Uri::url('wechat/platform_material/choose_material')}&material=1">
														<i class="create-type__icon file"></i>
														<strong class="create-type__title">{t domain="wechat"}从素材库选择{/t}</strong>
													</a>
												</div>
											</div>
											
											{if $data.reply_type neq 'text'}
												{if $data.reply_type neq 'news'}
												<div class="img_preview">
													<img class="preview_img margin_10" src="{$data.media.file}" alt="">
													<input type="hidden" name="media_id" value="{$subscribe.media_id}">
													<a href="javascript:;" class="jsmsgSenderDelBt link_dele">{t domain="wechat"}删除{/t}</a>
												</div>
												{else}
												<div class="weui-desktop-media__list-col margin_10">
													<li class="thumbnail move-mod-group big grid-item">
													    <div class="article">
													        <div class="cover">
													            <a target="_blank" href="javascript:;">
													                <img src="{$data.media.file}" />
													            </a>
													            <span>{$data.media.title}</span>
													        </div>
													    </div>
													    <div class="edit_mask appmsg_mask">
													        <i class="icon_card_selected">{t domain="wechat"}已选择{/t}</i>
													    </div>
													    {if $data.child}
													    <!-- {foreach from=$data.child key=key item=val} -->
													    <div class="article_list">
													        <div class="f_l">{if $val.title}{$val.title}{else}{t domain="wechat"}无标题{/t}{/if}</div>
													        <a target="_blank" href="javascript:;">
													            <img src="{$val.file}" class="pull-right" />
													        </a>
													    </div>
													    <!-- {/foreach} -->
													    {/if}
													</li>
													<input type="hidden" name="media_id" value="{$data.media_id}" />
												</div>
												<a href="javascript:;" class="jsmsgSenderDelBt link_dele p_l0">{t domain="wechat"}删除{/t}</a>
												{/if}
											{/if}
										</div>
			                    	</div>
								</div>
								<span class="input-must">*</span>
							</div>
						</div>	
					</div>
					<div class="modal-footer justify-content-center">
						<input type="hidden" name="content_type" value="{if $data.id}{$data.reply_type}{else}text{/if}">
						<input type="hidden" name="id" value="{$data.id}">
						<input type="submit" class="btn btn-outline-primary" value='{if $data.id}{t domain="wechat"}更新{/t}{else}{t domain="wechat"}确定{/t}{/if}' {if $errormsg}disabled="disabled"{/if}/>
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>

<!-- {include file="./library/wechat_choose_material.lbi.php"} -->

<!-- {/block} -->