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

<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">操作提示</h4>
	<p>推荐二维码：即管理员可以使用网站已有会员生成带推荐功能的二维码（默认永久二维码），让新用户扫码关注，即与推荐人形成上下级关系。</p>
	<p>推荐二维码的扫描量为新用户首次扫码量，即每注册一个新用户算一次。</p>
	<p>需要开启网站推荐注册分成功能使用。</p>
</div>

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
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="w150">{lang key='wechat::wechat.recommended_person'}</th>
							<th class="w100">{lang key='wechat::wechat.cash_into'}</th>
							<th class="w100">{lang key='wechat::wechat.scan_num'}</th>
							<th class="w150">过期时间</th>
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
								{RC_Time::local_date('Y-m-d H:i', $val.endtime)}
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

<div class="modal fade text-left" id="show_qrcode">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">推荐二维码</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body text-center">
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->