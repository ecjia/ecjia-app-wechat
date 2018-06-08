<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.mass_message.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
{if $warn && $type eq 0}
<div class="alert alert-error">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
{/if}

{if $errormsg}
 	<div class="alert alert-error">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}

<div class="modal fade text-left" id="add_material">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">{lang key='wechat::wechat.select_material'}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			</div>
			
			<div class="form material_choose" data-url="{url path='wechat/platform_mass_message/get_material_info'}">
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
			   		<input type="hidden" name="openid" />
					<input type="button" class="btn btn-light material_verify" {if $errormsg}disabled="disabled"{/if} value="{lang key='wechat::wechat.ok'}" />
				</div>
			</div>
		</div>
	</div>
</div>
	
<div class="row">
    <div class="col-12">
        <div class="card">
     		<div class="card-header">
                <h4 class="card-title">{$ur_here}</h4>
            </div>
            
            <div class="card-body">
            	<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link data-pjax active" href='#tab1' data-toggle="tab">{lang key='wechat::wechat.send_message'}</a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax" href='{url path="wechat/platform_mass_message/mass_list"}'>{lang key='wechat::wechat.send_record'}</a>
					</li>
				</ul>
			</div>
            <div class="col-md-12">
            	<div class="alert alert-info">
					<a class="close" data-dismiss="alert">×</a>
					<strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.mass_notice_info'}
				</div>
            </div>
            
            <div class="col-lg-12">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						<div class="form-body">
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_mass_type'}</label>
								<div class="col-lg-8 controls">
									<select name="mass_type" class="w130 f_l form-control">
										<option value="all">{lang key='wechat::wechat.all_user'}</option>
										<option value="by_group">{lang key='wechat::wechat.by_group'}</option>
					                </select>
					                <div class="by_group d-none m_l10 f_l">
										<select name="tag_id" class="w130 form-control">
						                    <!-- {foreach from=$list item=val} -->
						                    <option value="{$val['tag_id']}">{$val['name']}</option>
						                    <!-- {/foreach} -->
						                </select>
					                </div>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">
									<span class="input-must">{lang key='system::system.require_field'}</span>
									{lang key='wechat::wechat.label_select_material'}
								</label>
								<div class="col-lg-8 controls material-table" data-url="{url path='wechat/platform_mass_message/get_material_list'}">
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
										<li class="nav-item list-material">
											<a class="nav-link" data-toggle="tab" title="{lang key='wechat::wechat.text_message'}"><i class="fa fa-list-alt"></i></a>
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
							</div>
						</div>
					</div>
					<div class="modal-footer justify-content-center">
						<input type="hidden" name="content_type" value="text">
						<input type="submit" class="btn btn-light" value="{lang key='wechat::wechat.send_msg'}" {if $errormsg}disabled="disabled"{/if}/>
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->