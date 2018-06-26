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
                <h4 class="card-title">{$ur_here}</h4>
            </div>
            <div class="card-body">
            	<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link data-pjax" href='{url path="wechat/platform_response/reply_subscribe"}'>{lang key='wechat::wechat.attention_auto_reply'}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax active" href='{url path="wechat/platform_response/reply_msg"}'>{lang key='wechat::wechat.message_auto_reply'}</a>
					</li>
				</ul>
				
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="m_t10">
						<div class="form-body">
							<div class="form-group row">
								<div class="col-lg-12 controls material-table" data-url="{url path='wechat/platform_mass_message/get_material_list'}">
									<ul class="nav nav-tabs nav-only-icon nav-top-border no-hover-bg">
										<li class="nav-item text-material">
											<a class="nav-link active" data-toggle="tab" title="{lang key='wechat::wechat.text'}"><i class="fa fa-pencil"></i></a>
										</li>
										<li class="nav-item picture-material">
											<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.image'}"><i class="fa fa-file-image-o"></i></a>
										</li>
										<li class="nav-item music-material">
											<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.voice'}"><i class="fa fa-music"></i></a>
										</li>
										<li class="nav-item video-material">
											<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.video'}"><i class="fa fa-video-camera"></i></a>
										</li>
									</ul>
							   		<div class="text m_b10 {if $subscribe.media_id}hidden{/if}">
							   			<textarea class="m_t10 span12 form-control" name="content" cols="40" rows="5">{if $subscribe.content}{$subscribe.content}{/if}</textarea>
							    	</div>
							    	
									<div class="material_picture {if empty($subscribe.media_id)}hidden{/if}">
							        	{if $subscribe['media']}
							       			{if $subscribe['media']['type'] == 'voice'}
							           			<input type='hidden' name='media_id' value="{$subscribe['media_id']}"><img src="{$subscribe['media']['file']}" class='img-rounded material_show' />
							          			<div class="material_filename">{$subscribe['media']['file_name']}</div>
							          		{elseif $subscribe['media']['type'] == 'video'}
							             		<input type='hidden' name='media_id' value="{$subscribe['media_id']}"><img src="{$subscribe['media']['file']}" class='img-rounded material_show' />
							         			<div class="material_filename">{$subscribe['media']['file_name']}</div>
							         		{else}
							        			<input type='hidden' name='media_id' value="{$subscribe['media_id']}"><img src="{$subscribe['media']['file']}" class='img-rounded material_show' />
							     			{/if}
							    		{/if}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer justify-content-center">
						<input type="hidden" name="content_type" value="{if $subscribe['reply_type']}{$subscribe['reply_type']}{else}text{/if}">
	                    <input type="hidden" name="id" value="{$subscribe.id}">
	                    {if $errormsg}
	                    <input type="submit" class="btn btn-outline-primary" disabled="disabled" value="{lang key='wechat::wechat.ok'} ">
	                    {else}
	                    <input type="submit" class="btn btn-outline-primary" value="{lang key='wechat::wechat.ok'}">
	                    {/if}
					</div>
				</form>	
			</div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="add_material">
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