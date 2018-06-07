<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_qrcodeshare_edit.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<!-- {if $warn && $type neq 2} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
<!-- {/if} -->	

<!-- {if $errormsg} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
<!-- {/if} -->

<div class="row">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
	               	{if $action_link}
					<a class="btn btn-light plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-lg-12">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						<div class="form-body">
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_recommended_person'}</label>
								<div class="col-lg-8 controls">
									<input type="text" name="username" id="username" class="form-control"/>
									<span class="input-must">{lang key='system::system.require_field'}</span>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_recommended_id'}</label>
								<div class="col-lg-8 controls">
									<input type="text" name="scene_id" id="scene_id" class="form-control"/>
									<span class="input-must">{lang key='system::system.require_field'}</span>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_expire_seconds'}</label>
								<div class="col-lg-8 controls">
									<input type="text" name="expire_seconds" id="expire_seconds" class="form-control"/>
									<span class="help-block">{lang key='wechat::wechat.label_expire_seconds_help'}</span>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_functions'}</label>
								<div class="col-lg-8 controls">
									<input type="text" name="functions" id="function" class="form-control"/>
									<span class="input-must">{lang key='system::system.require_field'}</span>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_sort'}</label>
								<div class="col-lg-8 controls">
									<input type="text" name="sort" id="sort" class="form-control"/>
								</div>
							</div>
							
						</div>
					</div>
	
					<div class="modal-footer justify-content-center">
						{if $errormsg || ($type_error && $type neq 2)}
						<input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-light" disabled="disabled" />	
						{else}
						<input type="submit" name="submit" value="{lang key='wechat::wechat.ok'}" class="btn btn-light" />	
						{/if}
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->