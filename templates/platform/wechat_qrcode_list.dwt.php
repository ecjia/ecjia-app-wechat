<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_qrcode_list.init();
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
					<a class="btn btn-outline-primary plus_or_reply data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="ft-plus"></i> {$action_link.text}</a>
					{/if}
                </h4>
            </div>
            <div class="card-body">
	            <div class="heading-elements float-left">
					<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown"><i class="ft-settings"></i> {lang key='wechat::wechat.batch_operate'}</button>
					<div class="dropdown-menu">
						<a class="dropdown-item button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="wechat/platform_qrcode/batch"}'  data-msg="{lang key='wechat::wechat.remove_qrcode_confirm'}" data-noSelectMsg="{lang key='wechat::wechat.select_operate_qrcode'}" data-name="id" href="javascript:;"><i class="ft-trash-2"></i> {lang key='wechat::wechat.remove_qrcode'}</a>
					</div>
				</div>
				<div class="form-inline float-right">
					<form class="form-inline" method="post" action="{$search_action}" name="searchForm">
		          		<input type="text" name="keywords" value="{$listdb.filter.keywords}" class="form-control m_r5" placeholder="{lang key='wechat::wechat.qrcode_search_placeholder'}">
		            	<button type="button" class="btn btn-outline-primary search_qrcode">{lang key='wechat::wechat.search'}</button>
		        	</form>
				</div>
			</div>
			
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="table_checkbox w30">
								<input type="checkbox" data-toggle="selectall" data-children=".checkbox" id="customCheck"/>
								<label for="customCheck"></label>
							</th>
							<th class="w250">{lang key='wechat::wechat.application_adsense'}</th>
							<th class="w200">{lang key='wechat::wechat.qrcode_type'}</th>
							<th class="w200">{lang key='wechat::wechat.function'}</th>
							<th class="w150">{lang key='wechat::wechat.status'}</th>
							<th class="w100">{lang key='wechat::wechat.sort'}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$listdb.qrcode_list item=val key=key} -->
						<tr>
							<td>
								<input class="checkbox" type="checkbox" name="checkboxes[]" value="{$val.id}" id="checkbox_{$key}" />
								<label for="checkbox_{$key}"></label>
							</td>
							<td class="hide-edit-area">
								{$val.scene_id}
					    		<div class="edit-list">
							     	{assign var=view_url value=RC_Uri::url('wechat/platform_qrcode/qrcode_get',"id={$val.id}")}
						      		<a class="ajaxwechat" href="{$view_url}">{lang key='wechat::wechat.get_qrcode'}</a>&nbsp;|&nbsp;
						      		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_qrcode_confirm'}" href='{RC_Uri::url("wechat/platform_qrcode/remove","id={$val.id}")}'>{lang key='system::system.drop'}</a>
							    </div>
							</td>
							<td>
								{if $val.type eq 0}{lang key='wechat::wechat.qrcode_short'}{else}{lang key='wechat::wechat.qrcode_forever'}{/if}
							</td>
							<td>
								{$val.function}
							</td>
							<td>
                                <i class="{if $val.status eq 1}fa fa-check{else}fa fa-times{/if} cursor_pointer" data-trigger="toggleState" data-url="{RC_Uri::url('wechat/platform_qrcode/toggle_show')}" data-id="{$val.id}" ></i>
							</td>
							<td><span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('wechat/platform_qrcode/edit_sort')}" data-name="sort" data-pk="{$val.id}"  data-title="{lang key='wechat::wechat.edit_qrcode_sort'}">{$val.sort}</span></td>
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