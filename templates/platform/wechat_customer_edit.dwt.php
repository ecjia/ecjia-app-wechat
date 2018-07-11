<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_customer.init();
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
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-lg-12">
				<form class="form" method="post" name="theForm" action="{$form_action}">
					<div class="card-body">
						<div class="form-body">
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_kf_account'}</label>
								<div class="col-lg-8 controls">
									<!-- {if $list.kf_account} -->
									<span>{$list.kf_account}</span>
									<input class="input-xlarge" name="kf_account" type="hidden" value="{$list.kf_account|escape}" maxlength="32" size="34" autocomplete="off" />
									<!-- {else} -->
									<input class="input-xlarge form-control" name="kf_account" type="text" value="{$list.kf_account|escape}" maxlength="32" size="34" autocomplete="off" />
									<span class="help-block">{lang key='wechat::wechat.kf_account_help'}</span>
									<!-- {/if} -->
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_kf_nick'}</label>
								<div class="col-lg-8 controls">
									<input class="input-xlarge form-control" name="kf_nick" type="text" value="{$list.kf_nick|escape}" maxlength="32" size="34" autocomplete="off" />
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
							
							<!-- {if $list.id} -->
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_kf_headimgurl'}</label>
								<div class="col-lg-8 controls">
									<div class="fileupload {if $list.kf_headimgurl}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
										<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
											{if $list.kf_headimgurl}
											<img src="{$list.kf_headimgurl}" alt="{lang key='wechat::wechat.img_priview'}" />
											{/if}
										</div>
										<span class="btn btn-outline-primary btn-file">
											<span class="fileupload-new">{lang key='wechat::wechat.browser'}</span>
											<span class="fileupload-exists">{lang key='wechat::wechat.modify'}</span>
											<input type='file' name='kf_headimgurl' size="35"/>
										</span>
										<a class="btn btn-danger {if !$list.kf_headimgurl}fileupload-exists{else}fileupload-new{/if}" {if !$list.kf_headimgurl}data-dismiss="fileupload" href="javascript:;"{/if}>{lang key='system::system.drop'}</a>
									</div>
								</div>
							</div>
							<!-- {/if} -->
							
							<div class="form-group row">
								<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_status'}</label>
								<div class="col-lg-8 controls">
									<input type="radio" id="status_1" name="status" value="1" {if $list.status eq 1}checked{/if}><label for="status_1">{lang key='wechat::wechat.open'}</label>
									<input type="radio" id="status_0" name="status" value="0" {if $list.status eq 0}checked{/if}><label for="status_0">{lang key='wechat::wechat.close'}</label>
									<div class="help-block">{lang key='wechat::wechat.status_help'}</div>
								</div>
							</div>
						</div>
					</div>
	
					<div class="modal-footer justify-content-center">
						<!-- {if $list.id} -->
						<input class="btn btn-outline-primary" {if $errormsg || ($warn && $type neq 2)}disabled{/if} type="submit" value="{lang key='wechat::wechat.update'}" />
						<!-- {else} -->
						<input class="btn btn-outline-primary" {if $errormsg || ($warn && $type neq 2)}disabled{/if} type="submit" value="{lang key='wechat::wechat.ok'}" />
						<!-- {/if} -->
						<input type="hidden" name="id" value="{$list.id}" />
					</div>
				</form>	
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->