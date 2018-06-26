<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.response.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

{if $errormsg}
<div class="alert alert-error">
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
							<!-- {if !$id} -->
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_rule_name'}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" class="w280" name="rule_name" maxlength="60" size="30" />
									<div class="help-block">{lang key='wechat::wechat.rule_name_max'}</div>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.lable_keyword'}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" class="w280" name="rule_keywords" maxlength="60" size="30" />
									<div class="help-block">{lang key='wechat::wechat.more_keywords_split'}</div>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">
									{lang key='wechat::wechat.lable_reply'}
								</label>
								<div class="col-lg-8 controls material-table" data-url="{url path='wechat/platform_response/get_material_list'}">
									<ul class="nav nav-tabs nav-only-icon nav-top-border no-hover-bg">
										<li class="nav-item text-material">
											<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.text'}"><i class="fa fa-pencil"> 文字</i></a>
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
                               			<textarea class="m_t10 span12 form-control" name="content" cols="40" rows="5"></textarea>
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
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							<!-- {else} -->
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_rule_name'}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" class="w280" name="rule_name" maxlength="60" size="30" value="{if $id}{$data.rule_name}{/if}" />
									<div class="help-block">{lang key='wechat::wechat.rule_name_max'}</div>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.lable_keyword'}</label>
								<div class="col-lg-8 controls">
									<input class="form-control" type="text" class="w280" name="rule_keywords" maxlength="60" size="30" value="{if $id}{$data.rule_keywords_string}{/if}" />
									<div class="help-block">{lang key='wechat::wechat.more_keywords_split'}</div>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							

							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">
									{lang key='wechat::wechat.lable_reply'}
								</label>
								<div class="col-lg-8 controls material-table" data-url="{url path='wechat/platform_mass_message/get_material_list'}">
									
									<ul class="nav nav-tabs nav-only-icon nav-top-border no-hover-bg">
										<li class="nav-item text-material">
											<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.text'}"><i class="fa fa-pencil"> 文字</i></a>
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
                               			<textarea class="m_t10 span12 form-control" name="content" cols="40" rows="5">{$data.content}</textarea>
                                	</div>
                                	
									<div class="material_picture {if empty($data.media_id)}hidden{/if}">
										 <!-- {if $data.media} -->
			                                {if $data['reply_type'] == 'voice' || $data['reply_type'] == 'video' || $data['reply_type'] == 'image'}
			                                    <input type='hidden' name='media_id' value="{$data['media_id']}"><img src="{$data['media']['file']}" class='img-rounded material_show' />
			                                	<!-- {if $data.reply_type neq image} --><div class="material_filename">{$data['media']['file_name']}</div><!-- {/if} -->
			                                {elseif $data['reply_type'] == 'news'}
			                                	<div class="wmk_grid ecj-wookmark wookmark_list material_pictures w200">
													<div class="thumbnail move-mod-group">
					                                    <div class="article_media">
					                                        <div class="article_media_title">{$data['media']['title']}</div>
					                                        <div>{$data['media']['add_time']}</div>
					                                        <div class="cover"><img src="{$data['media']['file']}" /></div>
					                                        <div class="articles_content">{$data['media']['content']}</div>
					                                    </div>
				                                    </div>
				                                </div>
				                                <input type='hidden' name='media_id' value="{$data['media_id']}">
			                                {/if}
			                            <!-- {elseif $data.medias} -->
				                            <div class="wmk_grid ecj-wookmark wookmark_list material_pictures w200">
												<div class="thumbnail move-mod-group">
													<!-- {foreach from=$data.medias key=k item=val} -->
														{if $k == 0}
														<div class="article">
					                                		<div class="cover">
					                                			<img src="{$val.file}" />
					                                			<span>{$val.title}</span>
					                                		</div>
														</div>
														{else}
														<div class="article_list">
														 	<div class="f_l">{if $val.title}{$val.title}{else}{lang key='wechat::wechat.no_title'}{/if}</div>
					                               	 		<img src="{$val.file}" class="pull-right material_content" />
														</div>
														{/if}
					                                <!-- {/foreach} -->
							               		</div>
							               		<input type='hidden' name='media_id' value="{$data.media_id}">
					                        </div>
			                            <!-- {/if} -->
									</div>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							<!-- {/if} -->
						</div>
					</div>
					<div class="modal-footer justify-content-center">
						<!-- {if $id} -->
						<input type="hidden" name="content_type" value="{$data['reply_type']}">
		               	<input type="hidden" name="id" value="{$data.id}">
		                <input type="submit" class="btn btn-outline-primary" value="{lang key='wechat::wechat.update'}">
						<!-- {else} -->
						<input type="hidden" name="content_type" value="text">
						<input type="submit" class="btn btn-outline-primary" value="{lang key='wechat::wechat.send_msg'}" {if $errormsg}disabled="disabled"{/if}/>
						<!-- {/if} -->
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left keywords_material" id="add_material">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">{lang key='wechat::wechat.select_material'}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			</div>
			
			<div class="form material_choose" data-url="{url path='wechat/platform_response/get_material_info'}">
				<div class="material_choose_list">
                    <div class="material_select m_0">
                        <table class="table smpl_tbl dataTable m_b0">
                            <thead>
                            </thead>
                            <tbody class="material_select_tbody">
                            </tbody>
                        </table>
					</div>
				</div>
		   	
			   	<div class="modal-footer justify-content-center">
					<input type="button" class="btn btn-outline-primary material_verify" value="{lang key='wechat::wechat.ok'}" />
				</div>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->