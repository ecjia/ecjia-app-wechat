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
			<!-- {if $action neq 'video_add'} -->
			<div class="f_l">
				<div class="mobile_news_view">
					<div class="select_mobile_area mobile_news_main">
						<div class="show_image"></div>
						<div class="item">
							<div class="default">{t}封面图片{/t}</div>
							<h4 class='news_main_title title_show'>
								{t}标题{/t}
							</h4>
						</div>
						<div class="edit_mask">
							<a href="javascript:void(0);"><i class="icon-pencil"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="mobile_news_edit">
				<div class="mobile_news_edit_area">
					<h4 class="heading">{t}图文{/t} 1</h4>
					<fieldset>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{t}标题：{/t}</label>
							<div class="controls">
								<input class='span8' type='text' name='title' value='' />
								<span class="input-must">*</span>
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{t}作者：{/t}</label>
							<div class="controls">
								<input class='span8' type='text' name='author' value='' />
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{t}封面：{/t}</label>
							<div class="controls">
								<div class="fileupload fileupload-new" data-provides="fileupload">	
									<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
									</div>
									<span class="btn btn-file">
										<span  class="fileupload-new">浏览</span>
										<span  class="fileupload-exists">修改</span>
										<input type='file' name='image_url' size="35"/>
									</span>
									<a class="btn fileupload-exists" data-dismiss="fileupload" href="javascrpt:;">删除</a>
									<span class="input-must">*</span>
								</div>
								<input type="checkbox" name="is_show" value="1" />{t}封面图片显示在正文中{/t}
								<span class="help-block">（大图片建议尺寸：900像素 * 500像素）</span>
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{t}摘要：{/t}</label>
							<div class="controls">
								<textarea name="digest" cols="55" rows="6" class="span8"></textarea>
								<span class="help-block">选填，如果不填写会默认抓取正文前54个字</span>
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{t}原文链接：{/t}</label>
							<div class="controls">
								<input name='link' class='span8' type='text' value='{t}http://{/t}' />
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{t}排序：{/t}</label>
							<div class="controls">
								<input name='sort' class='span8' type='text'/>
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<h3 class="heading">
							正文
							</h3>
							<div class="row-fluid">
								<div class="span12">
									{ecjia:editor content='' textarea_name='content'}
								</div>
							</div>
						</div>
						<div class="control-group control-group-small">
							<div class="controls">
								<input type="submit" value="{t}确定{/t}" class="btn btn-gebo" />
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			<!-- {else} -->
			<div class="control-group formSep">
				<label class="control-label">{t}标题：{/t}</label>
				<div class="controls">
					<input type="text" class="w280" name="video_title" maxlength="60" size="30" value="{$article.title}" />
					<span class="input-must">*</span>
				</div>
			</div>
			
			<!-- {if !$article.file} -->
			<div class="control-group formSep">
				<label class="control-label">{t}视频：{/t}</label>
				<div class="controls fileupload fileupload-new" data-provides="fileupload">
					<span class="btn btn-file">
						<span class="fileupload-new">{t}浏览{/t}</span>
						<span class="fileupload-exists">{t}修改视频{/t}</span>
						<input type="file" name="video"/>
					</span>
					<span class="fileupload-preview m_t10"></span>
					<a class="close fileupload-exists" style="float: none" data-dismiss="fileupload" href="index.php-uid=1&page=form_extended.html#">&times;</a>	
					<span class="input-must">*</span>
					<div class="help-block">{t}上传视频格式为mp4，大小不得超过10MB{/t}</div>
				</div>
			</div>
			<!-- {/if} -->
			
			<div class="control-group formSep">
				<label class="control-label">{t}视频简介：{/t}</label>
				<div class="controls">
					<textarea name="video_digest" class="w280">{$article.digest}</textarea>
					{if $material eq 1}<span class="input-must">*</span>{/if}
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
					{if $button_type eq 'add'}
					<input type="submit" class="btn btn-gebo" {if $errormsg}disabled{/if} value="确定" />
					{else}
					<input type="submit" class="btn btn-gebo" {if $errormsg}disabled{/if} value="更新" />
			      	<input type="hidden" name="id" value="{$article.id}" />
			      	{/if}
				</div>
			</div>
			<!-- {/if} -->
		</form>
	</div>
</div>
<!-- {/block} -->