<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_qrcodeshare_list.init();
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
					<a class="btn btn-light plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="ft-plus"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="w150">{lang key='wechat::wechat.recommended_person'}</th>
							<th class="w100">{lang key='wechat::wechat.cash_into'}</th>
							<th class="w100">{lang key='wechat::wechat.scan_num'}</th>
							<th class="w150">{lang key='wechat::wechat.expire_seconds'}</th>
							<th class="w200">{lang key='wechat::wechat.function'}</th>
							<th class="w100">{lang key='wechat::wechat.sort'}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$listdb.share_list item=val} -->
						<tr>
							<td class="hide-edit-area">
								{$val.username}
					    		<div class="edit-list">
							     	{assign var=view_url value=RC_Uri::url('wechat/platform_qrcode/qrcode_get',"id={$val.id}")}
						      		<a class="ajaxwechat" href="{$view_url}" title="{lang key='system::system.view'}">{lang key='wechat::wechat.get_qrcode'}</a>&nbsp;|&nbsp;
						      		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_qrcode_confirm'}" href='{RC_Uri::url("wechat/platform_share/remove","id={$val.id}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
							    </div>
							</td>
							<td>
								0
							</td>
							<td>
								{$val['scan_num']}
							</td>
							<td>
								{$val['expire_seconds']}
							</td>
							<td>
								{$val.function}
							</td>
							<td><span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('wechat/platform_share/edit_sort')}" data-name="sort" data-pk="{$val.id}"  data-title="{lang key='wechat::wechat.edit_qrcode_sort'}">{$val.sort}</span></td>
						</tr>
						<!--  {foreachelse} -->
						<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>						
            </div>
            <!-- {$listdb.page} -->
        </div>
    </div>
</div>
<!-- {/block} -->