<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.wechat_customer.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- {if $errormsg} -->
<div class="alert mb-2 alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
</div>
<!-- {/if} -->

<!-- {if $warn && $type neq 2} -->
<div class="alert alert-danger">
	<strong>{lang key='wechat::wechat.label_notice'}</strong>{$type_error}
</div>
<!-- {/if} -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                	客服会话同步操作
                </h4>
            </div>
            <div class="card-body">
            	<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_customer/get_customer_session")}' data-value="get_customer_session">获取客服会话</button><span style="margin-left: 20px;">通过点击该按钮可以获取未接入会话列表。</span></div><br/>
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
     			<ul class="nav nav-pills float-left">
     				<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 1}active{/if}" href='{url path="wechat/platform_record/init" args="
					status=1{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>会话中
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.last_five_days}{$list.filter.last_five_days}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 2}active{/if}" href='{url path="wechat/platform_record/init" args="
						status=2{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>待接入
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.today}{$list.filter.today}{else}0{/if}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $list.filter.status eq 3}active{/if}" href='{url path="wechat/platform_record/init" args="
						status=3{if $smarty.get.kf_account}&kf_account={$smarty.get.kf_account}{/if}"}'>已关闭
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{if $list.filter.yesterday}{$list.filter.yesterday}{else}0{/if}</span></a>
					</li>
				</ul>
			</div>
			
            <div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="w130">客服账号</th>
							<th>用户昵称</th>
							<th>状态</th>
							<th>创建时间</th>
							<th>最后一条消息的时间</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$list.item item=val} -->
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<!--  {foreachelse} -->
						<tr>
							<td class="no-records" colspan="5">{lang key='system::system.no_records'}</td>
						</tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
				 <!-- {$list.page} -->						
            </div>
        </div>
    </div>
</div>

<!-- {/block} -->