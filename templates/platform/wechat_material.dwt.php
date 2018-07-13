<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.material.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<!-- {if $errormsg} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
<!-- {/if} -->

{if $warn && $wechat_type eq 0}
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.notice_public_not_certified'}
</div>
{/if}

<!-- {if ecjia_screen::get_current_screen()->get_help_sidebar()} -->
<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">操作提示</h4>
	<!-- {ecjia_screen::get_current_screen()->get_help_sidebar()} -->
</div>
<!-- {/if} -->

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
            </div>
            <div class="card-body">
            	<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.material eq 1}active{/if}" href="{url path='wechat/platform_material/init' args='type=news&material=1'}">{lang key='wechat::wechat.forever_material'}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if !$smarty.get.material}active{/if}" href="{url path='wechat/platform_material/init' args='type=image'}">{lang key='wechat::wechat.provisional_material'}</a>
					</li>
				</ul>
			</div>
			<div class="card-body">
				<ul class="nav nav-pills float-left">
					<!-- {if $smarty.get.material eq 1} -->
     				<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.type eq 'news'}active{/if}" href='{url path="wechat/platform_material/init" args="type=news{if $smarty.get.material}&material=1{/if}"}'>
						{lang key='wechat::wechat.text_message'}
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $lists.filter.count.news}{$lists.filter.count.news}{else}0{/if}</span></a>
					</li>
					<!-- {/if} -->
					
					<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.type eq 'image'}active{/if}" href='{url path="wechat/platform_material/init" args="type=image{if $smarty.get.material}&material=1{/if}"}'>
						{lang key='wechat::wechat.image'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $lists.filter.count.image}{$lists.filter.count.image}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.type eq 'voice'}active{/if}" href='{url path="wechat/platform_material/init" args="type=voice{if $smarty.get.material}&material=1{/if}"}'>
						{lang key='wechat::wechat.voice'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $lists.filter.count.voice}{$lists.filter.count.voice}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.type eq 'video'}active{/if}" href='{url path="wechat/platform_material/init" args="type=video{if $smarty.get.material}&material=1{/if}"}'>
						{lang key='wechat::wechat.video'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $lists.filter.count.video}{$lists.filter.count.video}{else}0{/if}</span></a>
					</li>
                    <li class="nav-item">
                        <a class="nav-link data-pjax {if $smarty.get.type eq 'thumb'}active{/if}" href='{url path="wechat/platform_material/init" args="type=thumb{if $smarty.get.material}&material=1{/if}"}'>
                            {lang key='wechat::wechat.thumb'}<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $lists.filter.count.thumb}{$lists.filter.count.thumb}{else}0{/if}</span></a>
                    </li>
				</ul>
				<!-- {if $action_link} -->
				<a class="btn btn-outline-primary plus_or_reply float-right" id="sticky_a" href='{$action_link.href}{if $smarty.get.material}&material=1{/if}'><i class="ft-plus"></i>{$action_link.text}</a>
				<!-- {/if} -->
			</div>
			<div class="card-body">
				<!-- {if $smarty.get.type eq news} -->
				<!--图文信息  -->
				<div class="row-fluid goods-photo-list">
					<!-- {if $lists.item} -->
					    <div class="wmk_grid ecj-wookmark wookmark_list material_pictures">
				        <ul class="wookmark-goods-photo move-mod nomove">
				        <!-- {foreach from=$lists.item item=articles} -->
				            <!-- {if $articles.articles} -->
				            <li class="thumbnail move-mod-group">
					            <div class="article">
					            	<div class="cover">
					            		<a target="__blank" href="{$articles.file}">
					                		<img src="{$articles.file}" />
					                	</a>
					                    <span>{$articles.title}</span>
					                </div>
					            </div>
				            <!-- {foreach from=$articles.articles key=key item=val} -->
				                <div class="article_list">
				                    <div class="f_l">{if $val.title}{$val.title}{else}{lang key='wechat::wechat.no_title'}{/if}</div>
				                    <a target="__blank" href="{$val.file}">
				                    	<img src="{$val.file}" class="pull-right" />
				                    </a>
				                </div>
				            <!-- {/foreach} -->
				                <p>
				                    <a class="ajaxremove" data-imgid="{$val.id}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_imgtext_cover'}" href='{url path="wechat/platform_material/remove" args="id={$articles.id}"}' title="{lang key='wechat::wechat.delete'}"><i class="ft-trash-2"></i></a>
				                    <a class="data-pjax" href='{url path="wechat/platform_material/edit" args="id={$articles.id}&material=1"}'><i class="ft-edit-2"></i></a>
				                </p>
				            </li>
				            <!-- {else} -->
				            <li class="thumbnail move-mod-group">
				                <div class="articles">
				                    <div class="articles_title">{if $articles.title}{$articles.title}{else}{lang key='wechat::wechat.no_title'}{/if}</div>
				                    <p class="ecjiaf-pre">{$articles.add_time}</p>
				                    <a target="__blank" href="{$articles.file}">
				                        <img src="{$articles.file}"/>
				                    </a>
				                    <div class="articles_content">{$articles.content}</div>
				                </div>
				                <p>
				                    <a class="ajaxremove" data-imgid="{$articles.id}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_images_material'}" href='{url path="wechat/platform_material/remove" args="id={$articles.id}"}' title="{lang key='wechat::wechat.delete'}"><i class="ft-trash-2"></i></a>
				                    <!-- {if $articles.article_id} -->
				                    <a class="data-pjax" href='{url path="wechat/platform_material/edit" args="id={$articles.id}&material=1"}'><i class="ft-edit-2"></i></a>
				                    <!-- {else} -->
				                    <a class="data-pjax" href='{url path="wechat/platform_material/edit" args="id={$articles.id}&material=1"}'><i class="ft-edit-2"></i></a>
				                    <!-- {/if} -->
				                </p>
				            </li>
				            <!-- {/if} -->
				        <!-- {/foreach} -->
				        </ul>
				    </div>
					<!-- {else} -->
					<table class="table table-striped">
						<tr>
							<td class="no-records" colspan="10" style="border-top:0px;line-height:100px;">{lang key='wechat::wechat.unfind_any_recode'}</td>
						</tr>
					</table>
					<!-- {/if} -->
				</div>
				<!-- {$lists.page} -->
				<!-- {/if} -->
				
				<!-- {if $smarty.get.type eq image} -->
				<div class="row">
					<div class="col-lg-12">
						<div class="fileupload" data-type="image" data-action="{$form_action}{if $smarty.get.material}&material=1{/if}"></div>
					</div>
				</div>
				<div class="row-fluid goods-photo-list{if !$lists.item} hide{/if}">
					<div class="span12">
						<div class="wmk_grid ecj-wookmark wookmark_list">
							<ul class="wookmark-goods-photo move-mod nomove">
								<!-- {foreach from=$lists.item item=val} -->
								<li class="thumbnail move-mod-group">
									<div class="attachment-preview">
										<div class="ecj-thumbnail">
											<div class="centered">
												<a target="__blank" href="{$val.file}" title="{$val.file_name}">
													<img src="{$val.file}" />
												</a>
											</div>
										</div>
									</div>
									<p>
										<a href="javascript:;" title="{lang key='wechat::wechat.cancel'}" data-toggle="sort-cancel" style="display:none;"><i class="fa fa-times"></i></a>
										<a href="javascript:;" title="{lang key='wechat::wechat.save'}" data-toggle="sort-ok" data-imgid="{$val.id}" data-saveurl="{url path='wechat/platform_material/edit_file_name' args='type=picture'}" style="display:none;"><i class="fa fa-check"></i></a>
										<a class="ajaxremove" data-imgid="{$val.id}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_images_material'}" href='{url path="wechat/platform_material/picture_remove" args="id={$val.id}"}' title="{lang key='wechat::wechat.delete'}"><i class="ft-trash-2"></i></a>
										<a href="javascript:;" title="{lang key='wechat::wechat.edit'}" data-toggle="edit"><i class="ft-edit-2"></i></a>
										<span class="edit_title">{if $val.file_name}{$val.file_name}{else}{lang key='wechat::wechat.no_title'}{/if}</span>
									</p>
								</li>
									<!-- {foreach from=$val.articles item=article} -->
									<li class="thumbnail move-mod-group">
										<div class="attachment-preview">
											<div class="ecj-thumbnail">
												<div class="centered">
													<a target="__blank" href="{$article.file}" title="{$article.file_name}">
														<img src="{$article.file}"/>
													</a>
												</div>
											</div>
										</div>
										<p>
											<a href="javascript:;" title="{lang key='wechat::wechat.cancel'}" data-toggle="sort-cancel" style="display:none;"><i class="fa fa-times"></i></a>
											<a href="javascript:;" title="{lang key='wechat::wechat.save'}" data-toggle="sort-ok" data-imgid="{$article.id}" data-saveurl="{url path='wechat/platform_material/edit_file_name' args='type=picture'}" style="display:none;"><i class="fa fa-check"></i></a>
											<a class="ajaxremove" data-imgid="{$article.id}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_images_material'}" href='{url path="wechat/platform_material/picture_remove" args="id={$article.id}"}' title="{lang key='wechat::wechat.cancel'}"><i class="ft-trash-2"></i></a>
											<a href="javascript:;" title="{lang key='wechat::wechat.edit'}" data-toggle="edit"><i class="ft-edit-2"></i></a>
											<span class="edit_title">{if $article.file_name}{$article.file_name}{else}{lang key='wechat::wechat.no_title'}{/if}</span>
										</p>
									</li>
									<!-- {/foreach} -->
								<!-- {/foreach} -->
							</ul>
						</div>
						<!-- {$lists.page} -->
					</div>
				</div>	
				<!-- {/if} -->
				
				<!-- {if $smarty.get.type eq voice} -->
				<div class="row-fluid">
					<div class="span12">
						<div class="fileupload" data-type="voice" data-action="{$form_action}{if $smarty.get.material}&material=1{/if}"></div>
					</div>
				</div>
				<div class="row-fluid goods-photo-list{if !$lists.item} hide{/if}">
					<div class="span12">
						<div class="wmk_grid ecj-wookmark wookmark_list">
							<ul class="wookmark-goods-photo move-mod nomove">
								<!-- {foreach from=$lists.item item=val} -->
								<li class="thumbnail move-mod-group">
									<div class="attachment-preview">
										<div class="ecj-thumbnail">
											<div class="centered">
												<a target="__blank" href="{$val.file}" title="{$val.file_name}">
													<img src="{$val.file}" />
												</a>
											</div>
										</div>
									</div>
									<p>
										<a href="javascript:;" title="{lang key='wechat::wechat.cancel'}" data-toggle="sort-cancel" style="display:none;"><i class="fa fa-times"></i></a>
										<a href="javascript:;" title="{lang key='wechat::wechat.save'}" data-toggle="sort-ok" data-imgid="{$val.id}" data-saveurl="{url path='wechat/platform_material/edit_file_name' args='type=voice'}" style="display:none;"><i class="fa fa-check"></i></a>
										<a class="ajaxremove" data-imgid="{$val.id}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_voice_material'}" href='{url path="wechat/platform_material/voice_remove" args="id={$val.id}"}' title="{lang key='wechat::wechat.delete'}"><i class="ft-trash-2"></i></a>
										<a href="javascript:;" title="{lang key='wechat::wechat.edit'}" data-toggle="edit"><i class="ft-edit-2"></i></a>
										<span class="edit_title">{if $val.file_name}{$val.file_name}{else}{lang key='wechat::wechat.no_title'}{/if}</span>
									</p>
								</li>
								<!-- {/foreach} -->
							</ul>
						</div>
						<!-- {$lists.page} -->
					</div>
				</div>	
				<!-- {/if} -->
				
				<!-- {if $smarty.get.type eq video} -->
				<div class="row-fluid goods-photo-list">
					<!-- {if $lists.item} -->
					<div class="span12">
						<div class="wmk_grid ecj-wookmark wookmark_list">
							<ul class="wookmark-goods-photo move-mod nomove">
								<!-- {foreach from=$lists.item item=val} -->
								<li class="thumbnail move-mod-group">
									<div class="attachment-preview">
										<div class="ecj-thumbnail">
											<div class="centered">
												<a target="__blank" href="{$val.file}" title="{$val.title}">
													<img data-original="{$val.file}" src="{$val.file}" alt="" />
												</a>
											</div>
										</div>
									</div>
									<p>
										<a href="javascript:;" title="{lang key='wechat::wechat.cancel'}" data-toggle="sort-cancel" style="display:none;"><i class="fa fa-times"></i></a>
										<a href="javascript:;" title="{lang key='wechat::wechat.save'}" data-toggle="sort-ok" data-imgid="{$val.id}" data-saveurl="{url path='wechat/platform_material/edit_title'}" style="display:none;"><i class="fa fa-check"></i></a>
										<a class="ajaxremove" data-imgid="{$val.id}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_video_material'}" href='{url path="wechat/platform_material/video_remove" args="id={$val.id}"}' title="{lang key='wechat::wechat.delete'}"><i class="ft-trash-2"></i></a>
										{if $smarty.get.material neq 1}
										<a class="data-pjax" href='{url path="wechat/platform_material/video_edit" args="id={$val.id}{if $smarty.get.material}&material=1{/if}"}'><i class="ft-edit-2"></i></a>
										{/if}
										<span class="edit_title f_l f_s15">{if $val.title}{$val.title}{else}{lang key='wechat::wechat.no_title'}{/if}</span>
									</p>
								</li>
								<!-- {/foreach} -->
							</ul>
						</div>
						<!-- {$lists.page} -->
					</div>
					<!-- {else} -->
					<table class="table table-striped m_b0">
						<tr>
							<td class="no-records" colspan="10" style="border-top:0px;line-height:100px;">{lang key='wechat::wechat.unfind_any_recode'}</td>
						</tr>
					</table>
					<!-- {/if} -->
				</div>
				<!-- {/if} -->
			</div>
        </div>
    </div>
</div>
<!-- {/block} -->
