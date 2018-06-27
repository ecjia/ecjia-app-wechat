<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.material_edit.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<!-- {if $errormsg} -->
<div class="alert alert-light">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
<!-- {/if} -->

{if $warn && $wechat_type eq 0}
<div class="alert alert-light">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.notice_public_not_certified'}
</div>
{/if}

<div class="row edit-page">
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
				<form class="form" method="post" name="theForm" action="{$form_action}" enctype="multipart/form-data">
					<!-- {if $action neq 'video_add'} -->
						<div class="f_l">
							<div class="mobile_news_view">
								<div class="select_mobile_area mobile_news_main">
									<div class="show_image"></div>
									<div class="item">
										<div class="default">{lang key='wechat::wechat.cover_images'}</div>
										<h4 class='news_main_title title_show'>{lang key='wechat::wechat.title'}</h4>
									</div>
									<div class="edit_mask">
										<a href="javascript:void(0);"><i class="ft-edit-2"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="mobile_news_edit">
							<div class="mobile_news_edit_area">
								<h4 class="heading">{lang key='wechat::wechat.graphic'} 1</h4>
								<fieldset>
									<div class="form-group row">
										<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.label_title'}</label>
										<div class="col-lg-9 controls">
											<input class="span8 form-control" type="text" name="title" value='' />
										</div>
										<span class="input-must">*</span>
									</div>
									<div class="form-group row">
										<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.author'}</label>
										<div class="col-lg-9 controls">
											<input class='span8 form-control' type='text' name='author' value='' />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.cover'}</label>
										<div class="col-lg-9 controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">	
												<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
												</div>
												<span class="btn btn-outline-primary btn-file">
													<span class="fileupload-new">{lang key='wechat::wechat.browser'}</span>
													<span class="fileupload-exists">{lang key='wechat::wechat.modify'}</span>
													<input type='file' name='image_url' size="35"/>
												</span>
												<a class="btn btn-danger fileupload-exists" data-dismiss="fileupload" href="javascrpt:;">{lang key='wechat::wechat.delete'}</a>
											</div>
											<span class="input-must">*</span>
								
											<input type="checkbox" name="is_show" value="1" id="is_show_1"/><label for="is_show_1"></label>{lang key='wechat::wechat.cover_img_centent'}
											<span class="help-block">{lang key='wechat::wechat.img_size900x500'}</span>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.summary'}</label>
										<div class="col-lg-9 controls">
											<textarea name="digest" cols="55" rows="6" class="span8 form-control"></textarea>
											<span class="help-block">{lang key='wechat::wechat.optional_for54'}</span>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.text_link'}</label>
										<div class="col-lg-9 controls">
											<input name='link' class='span8 form-control' type='text' value='{t}http://{/t}' />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.label_sort'}</label>
										<div class="col-lg-9 controls">
											<input name='sort' class='span8 form-control' type='text'/>
										</div>
									</div>
									<div class="form-group row">
										<h3 class="heading card-title col-lg-12">{lang key='wechat::wechat.main_body'}</h3>
										<div class="row">
											<div class="col-lg-10">
												{ecjia:editor content='' textarea_name='content'}
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-lg-1 label-control text-right"></label>
										<div class="col-lg-9 controls">
											<input type="submit" value="{lang key='wechat::wechat.ok'}" {if $errormsg}disabled{/if} class="btn btn-outline-primary" />
										</div>
									</div>
								</fieldset>
							</div>
						</div>
					<!-- {else} -->
						<div class="form-group row">
							<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.label_title'}</label>
							<div class="col-lg-9 controls">
								<input type="text" class="w280 form-control" name="video_title" maxlength="60" size="30" value="{$article.title}" />
							</div>
							<span class="input-must">*</span>
						</div>
					
						<!-- {if !$article.file} -->
						<div class="form-group row">
							<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.label_video'}</label>
							<div class="col-lg-9 controls fileupload fileupload-new" data-provides="fileupload">
								<span class="btn btn-outline-primary btn-file">
									<span class="fileupload-new">{lang key='wechat::wechat.browser'}</span>
									<span class="fileupload-exists">{lang key='wechat::wechat.modify_video'}</span>
									<input type="file" name="video"/>
								</span>
								<span class="fileupload-preview m_t10"></span>
								<a class="close fileupload-exists" style="float: none" data-dismiss="fileupload" href="index.php-uid=1&page=form_extended.html#">&times;</a>	
								<div class="help-block">{lang key='wechat::wechat.uploadmp4_most10'}</div>
							</div>
							<span class="input-must">*</span>
						</div>
						<!-- {/if} -->
					
					<div class="form-group row">
						<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.label_video_intro'}</label>
						<div class="col-lg-9 controls">
							<textarea name="video_digest" class="w280 form-control">{$article.digest}</textarea>
						</div>
						{if $material eq 1}<span class="input-must">*</span>{/if}
					</div>
						
					<div class="modal-footer justify-content-center">
						{if $button_type eq 'add'}
						<input type="submit" class="btn btn-outline-primary" {if $errormsg}disabled{/if} value="{lang key='wechat::wechat.ok'}" />
						{else}
						<input type="submit" class="btn btn-outline-primary" {if $errormsg}disabled{/if} value="{lang key='wechat::wechat.update'}" />
				      	<input type="hidden" name="id" value="{$article.id}" />
				      	{/if}
					</div>
				<!-- {/if} -->
				</form>	
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->