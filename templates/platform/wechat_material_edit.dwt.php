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
				<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
					<!-- {if $article.articles}-->
						<div class="f_l">
							<div class="mobile_news_view">
								<!-- {foreach from=$article.articles key=key item=list}-->
									<!-- {if $key eq '0'} -->
									<div class="select_mobile_area mobile_news_main">
										<div class="show_image"><img src='{$list.file}'></div>
										<div class="item">
											<div class="default">{lang key='wechat::wechat.cover_images'}</div>
											<h4 class='news_main_title title_show'>{$list.title}</h4>
										</div>
										<div class="edit_mask">
											<a href="javascript:;" class="data-pjax" data-id="{$list.id}" data-href='{url path="wechat/platform_material/get_material_info" args="id={$list.id}&material=1"}'><i class="ft-edit-2"></i></a>&nbsp;&nbsp;&nbsp;
										</div>
									</div>
									<!-- {else} -->
									<div class="select_mobile_area mobile_news_auxiliary">
										<div class="span7 news_auxiliary_title title_show">{$list.title}</div>
										<div class="span4 thumb_image"><div>{lang key='wechat::wechat.thumbnail'}</div><div class="show_image"><img src='{$list.file}'></div></div>
										<div class="edit_mask">
											<a href="javascript:;" class="data-pjax" data-id="{$list.id}" data-href='{url path="wechat/platform_material/get_material_info" args="id={$list.id}&material=1"}'><i class="ft-edit-2"></i></a>&nbsp;&nbsp;&nbsp;
		<!-- 									<a href="javascript:;" {if $list.id}class="data-pjax" data-toggle="remove_material" data-msg="{t}您确定要删除该图文素材吗？{/t}" data-href='{url path="wechat/platform_material/remove" args="id={$list.id}&article_id={$article.id}"}' title="{t}移除{/t}"{else}data-toggle="remove_edit_mask"{/if} data-parent=".mobile_news_auxiliary"><i class="icon-trash"></i></a> -->
										</div>
									</div>
									<!-- {/if} -->
								<!-- {/foreach} -->
								<a href="javascript:;" class="create_news" data-toggle="clone-object" data-parent=".mobile_news_auxiliary_clone" data-clone-area=".create_news" data-child=".mobile_news_editarea_clone" data-child-clone-area=".mobile_news_edit"><i class="ft-plus"></i></a>
							</div>
						</div>
						<div class="mobile_news_edit material_info">
							<!-- {foreach from=$article.articles key=key item=list}-->
								<!-- {if $key eq 0} -->
								<div class="mobile_news_edit_area">
									<h4 class="heading">{lang key='wechat::wechat.graphic'} {$key+1}</h4>
									<fieldset>
										<div class="form-group row">
											<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.label_title'}</label>
											<div class="col-lg-9 controls">
												<input class='span8 form-control' type='text' name='title' value='{$list.title}'/>
											</div>
											<span class="input-must">*</span>
										</div>
										<div class="form-group row">
											<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.author'}</label>
											<div class="col-lg-9 controls">
												<input class='span8 form-control' type='text' name='author' value='{$list.author}'/>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.cover'}</label>
											<div class="col-lg-9 controls">
												<div class="fileupload {if $list.file}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
													<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
														{if $list.file}
														<img src="{$list.file}" alt="{lang key='wechat::wechat.img_priview'}" />
														{/if}
													</div>
													<span class="btn btn-outline-primary btn-file">
														<span class="fileupload-new">{lang key='wechat::wechat.browser'}</span>
														<span class="fileupload-exists">{lang key='wechat::wechat.modify'}</span>
														<input type='file' name='image_url' size="35"/>
													</span>
												</div>
												<input type="checkbox" name="is_show" value="1" {if $list.is_show eq 1}checked="checked"{/if}/>{lang key='wechat::wechat.cover_img_centent'}
												<!-- {if $key eq '0'} -->
												<span class="help-block">{lang key='wechat::wechat.img_size900x500'}</span>
												<!-- {else} -->
												<span class="help-block">{lang key='wechat::wechat.img_size200x200'}</span>
												<!-- {/if} -->
											</div>
											<span class="input-must">*</span>
										</div>
										<div class="form-group row">
											<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.summary'}</label>
											<div class="col-lg-9 controls">
												<textarea name="digest" cols="55" rows="6" class="span8 form-control">{$list.digest}</textarea>
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.text_link'}</label>
											<div class="col-lg-9 controls">
												<input name='link' class='span8 form-control' type='text' value='{$list.link}'/>
											</div>
										</div>
										
										<div class="form-group row sort_form">
											<label class="col-lg-1 label-control text-right">{lang key='wechat::wechat.label_sort'}</label>
											<div class="col-lg-9 controls">
												<input name='sort' class='span8 form-control' type='text' value='{$list.sort}'/>
											</div>
										</div>
		
										<div class="form-group row">
											<h3 class="heading card-title col-lg-12">
											{lang key='wechat::wechat.main_body'}
											</h3>
											<div class="row">
												<div class="col-lg-10">
													{ecjia:editor content=$list.content textarea_name='content' is_teeny=0}
												</div>
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-lg-1 label-control text-right"></label>
											<div class="col-lg-9 controls">
												<input type="hidden" name="id" value="{$list.id}">
												<input type="hidden" name="index">
												<input type="submit" value="{lang key='wechat::wechat.update'}" class="btn btn-lighr"/>
											</div>
										</div>
									</fieldset>
								</div>
								<!-- {/if} -->
							<!-- {/foreach} -->
						</div>
					<!-- {/if} -->
				</form>
			</div>
		</div>
	</div>
</div>

<div class="select_mobile_area mobile_news_auxiliary mobile_news_auxiliary_clone hide material_info_select">
	<div class="col-lg-7 news_auxiliary_title title_show">{lang key='wechat::wechat.title'}</div>
	<div class="col-lg-4 thumb_image"><div>{lang key='wechat::wechat.thumbnail'}</div><div class="show_image"></div></div>
	<div class="edit_mask">
		<a href="javascript:;"><i class="ft-edit-2"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" data-toggle="remove_edit_mask" data-parent=".mobile_news_auxiliary"><i class="ft-trash-2"></i></a>
	</div>
</div>
<!-- {/block} -->