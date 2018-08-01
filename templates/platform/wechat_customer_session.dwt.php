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
                	客服会话同步操作
                </h4>
            </div>
            <div class="card-body">
            	<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_customer/get_customer_session")}&status={$smarty.get.status}' data-value="get_customer_session">获取客服会话</button><span style="margin-left: 20px;">通过点击该按钮可以获取未接入会话列表。</span></div><br/>
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
						<a class="nav-link data-pjax {if $smarty.get.status eq 2 || !$smarty.get.status}active{/if}" href='{url path="wechat/platform_customer/session" args="status=2"}'>待接入
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.count.wait}</span></a>
					</li>
     				<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.status eq 1}active{/if}" href='{url path="wechat/platform_customer/session" args="status=1"}'>会话中
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.count.going}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link data-pjax {if $smarty.get.status eq 3}active{/if}" href='{url path="wechat/platform_customer/session" args="status=3"}'>已关闭
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.count.close}</span></a>
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
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$list.item item=val} -->
						<tr>
							<td>{if $val.kf_account}{$val.kf_account}{else}暂无{/if}</td>
							<td>{$val.nickname}</td>
							<td>
								{if $val.status eq 1}
								会话中
								{elseif $val.status eq 2}
								待接入
								{elseif $val.status eq 3}
								已关闭
								{/if}
							</td>
							<td>
								{if $val.create_time}
								{date('Y-m-d H:i:s', ($val['create_time']))}
								{/if}
							</td>
							<td>
								{if $val.latest_time}
								{date('Y-m-d H:i:s', ($val['latest_time']))}
								{/if}
							</td>
							<td>
								{if $val.status neq 3}
									<a class="ajaxremove cursor_pointer" href='{RC_Uri::url("wechat/platform_customer/close_session", "id={$val.id}")}' title="关闭" data-toggle="ajaxremove" data-msg="您确定要关闭该会话吗？">关闭会话</a>
								{/if}
							</td>
						</tr>
						<!--  {foreachelse} -->
						<tr>
							<td class="no-records" colspan="6">{lang key='system::system.no_records'}</td>
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
