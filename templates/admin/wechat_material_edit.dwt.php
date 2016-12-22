<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.material_edit.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->

<!-- {if $errormsg} -->
	<div class="alert alert-error">
		<strong>温馨提示：</strong>{$errormsg}
	</div>
<!-- {/if} -->

{if $warn}
	{if $wechat_type eq 0}
	 	<div class="alert alert-error">
	        <strong>温馨提示：</strong>{t}抱歉！您当前公众号属于“未认证的公众号”，该模块目前还不支持“未认证的公众号”。{/t}
	    </div>
	{/if}
{/if}

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"  id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class='span m_b20'>
		<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
			<!-- {if $article.articles}-->
				<div class="f_l">
					<div class="mobile_news_view">
						<!-- {foreach from=$article.articles key=key item=list}-->
							<!-- {if $key eq '0'} -->
							<div class="select_mobile_area mobile_news_main">
								<div class="show_image"><img src='{$list.file}'></div>
								<div class="item">
									<div class="default">{t}封面图片{/t}</div>
									<h4 class='news_main_title title_show'>
										{$list.title}
									</h4>
								</div>
								<div class="edit_mask">
									<a href="javascript:;" class="data-pjax" data-id="{$list.id}" data-href='{url path="wechat/admin_material/get_material_info" args="id={$list.id}&material=1"}'><i class="icon-pencil"></i></a>&nbsp;&nbsp;&nbsp;
								</div>
							</div>
							<!-- {else} -->
							<div class="select_mobile_area mobile_news_auxiliary">
								<div class="span7 news_auxiliary_title title_show">{$list.title}</div>
								<div class="span4 thumb_image"><div>{t}缩略图{/t}</div><div class="show_image"><img src='{$list.file}'></div></div>
								<div class="edit_mask">
									<a href="javascript:;" class="data-pjax" data-id="{$list.id}" data-href='{url path="wechat/admin_material/get_material_info" args="id={$list.id}&material=1"}'><i class="icon-pencil"></i></a>&nbsp;&nbsp;&nbsp;
<!-- 									<a href="javascript:;" {if $list.id}class="data-pjax" data-toggle="remove_material" data-msg="{t}您确定要删除该图文素材吗？{/t}" data-href='{url path="wechat/admin_material/remove" args="id={$list.id}&article_id={$article.id}"}' title="{t}移除{/t}"{else}data-toggle="remove-obj"{/if} data-parent=".mobile_news_auxiliary"><i class="icon-trash"></i></a> -->
								</div>
							</div>
							<!-- {/if} -->
						<!-- {/foreach} -->
						<a href="javascript:;" class="create_news" data-toggle="clone-object" data-parent=".mobile_news_auxiliary_clone" data-clone-area=".create_news" data-child=".mobile_news_editarea_clone" data-child-clone-area=".mobile_news_edit"><i class="fontello-icon-plus"></i></a>
					</div>
				</div>
				<div class="mobile_news_edit material_info">
					<!-- {foreach from=$article.articles key=key item=list}-->
						<!-- {if $key eq 0} -->
						<div class="mobile_news_edit_area">
							<h4 class="heading">{t}图文{/t} {$key+1}</h4>
							<fieldset>
								<div class="control-group control-group-small formSep">
									<label class="control-label">{t}标题：{/t}</label>
									<div class="controls">
										<input class='span8' type='text' name='title' value='{$list.title}'/>
										<span class="input-must">*</span>
									</div>
								</div>
								<div class="control-group control-group-small formSep">
									<label class="control-label">{t}作者：{/t}</label>
									<div class="controls">
										<input class='span8' type='text' name='author' value='{$list.author}'/>
									</div>
								</div>
								<div class="control-group control-group-small formSep">
									<label class="control-label">{t}封面：{/t}</label>
									<div class="controls">
										<div class="fileupload {if $list.file}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
											<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
												{if $list.file}
												<img src="{$list.file}" alt="图片预览" />
												{/if}
											</div>
											<span class="btn btn-file">
												<span class="fileupload-new">浏览</span>
												<span class="fileupload-exists">修改</span>
												<input type='file' name='image_url' size="35"/>
											</span>
<!-- 											<a class="btn fileupload-exists" {if !$list.file}data-dismiss="fileupload" href="javascript:;"{else}data-toggle="ajaxremove" data-msg="{t}您确定要删除该封面素材吗？{/t}" href='{url path="wechat/admin_material/remove_file" args="id={$list.id}"}' title="{t}移除{/t}"{/if}>删除</a> -->
											<span class="input-must">*</span>
										</div>
										<input type="checkbox" name="is_show" value="1" {if $list.is_show eq 1}checked="checked"{/if}/>{t}封面图片显示在正文中{/t}
										<!-- {if $key eq '0'} -->
										<span class="help-block">（大图片建议尺寸：900像素 * 500像素）</span>
										<!-- {else} -->
										<span class="help-block">（小图片建议尺寸：200像素 * 200像素）</span>
										<!-- {/if} -->
									</div>
								</div>
								<div class="control-group control-group-small formSep">
									<label class="control-label">{t}摘要：{/t}</label>
									<div class="controls">
										<textarea name="digest" cols="55" rows="6" class="span8">{$list.digest}</textarea>
									</div>
								</div>
								
								<div class="control-group control-group-small formSep">
									<label class="control-label">{t}原文链接：{/t}</label>
									<div class="controls">
										<input name='link' class='span8' type='text' value='{$list.link}'/>
									</div>
								</div>
								
								<div class="control-group control-group-small formSep sort_form">
									<label class="control-label">{t}排序：{/t}</label>
									<div class="controls">
										<input name='sort' class='span8' type='text' value='{$list.sort}'/>
									</div>
								</div>

								<div class="control-group formSep">
									<h3 class="heading">
									正文
									</h3>
									<div class="row-fluid">
										<div class="span12">
											{ecjia:editor content=$list.content textarea_name='content' is_teeny=0}
										</div>
									</div>
								</div>
								
								<div class="control-group control-group-small">
									<div class="controls">
										<input type="hidden" name="id" value="{$list.id}">
										<input type="hidden" name="index">
										<input type="submit" value="{t}更新{/t}" class="btn btn-gebo"/>
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

<div class="select_mobile_area mobile_news_auxiliary mobile_news_auxiliary_clone hide material_info_select">
	<div class="span7 news_auxiliary_title title_show">{t}标题{/t}</div>
	<div class="span4 thumb_image"><div>{t}缩略图{/t}</div><div class="show_image"></div></div>
	<div class="edit_mask">
		<a href="javascript:;"><i class="icon-pencil"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" data-toggle="remove-obj" data-parent=".mobile_news_auxiliary"><i class="icon-trash"></i></a>
	</div>
</div>
<!-- {/block} -->