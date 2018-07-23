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
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
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
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_rule_name'}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" class="w280" name="rule_name" maxlength="60" size="30" value="{$data.rule_name}" />
									<div class="help-block">{lang key='wechat::wechat.rule_name_max'}</div>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.lable_keyword'}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" class="w280" name="rule_keywords" maxlength="60" size="30" value="{$data.rule_keywords_string}" />
									<div class="help-block">{lang key='wechat::wechat.more_keywords_split'}</div>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">
									{lang key='wechat::wechat.lable_reply'}
								</label>
								<div class="col-lg-8 controls">
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
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
						</div>	
					</div>
					<div class="modal-footer justify-content-center">
						<input type="hidden" name="id" value="{$data.id}">
						<input type="submit" class="btn btn-outline-primary" value="{if $data.id}更新{else}确定{/if}" {if $errormsg}disabled="disabled"{/if}/>
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>

<!-- {include file="./library/wechat_choose_material.lbi.php"} -->

<!-- {/block} -->