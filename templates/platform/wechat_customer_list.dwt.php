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
	<strong>温馨提示：</strong>{$type_error}
</div>
<!-- {/if} -->		
		
<!-- {if $errormsg} -->
	<div class="alert alert-danger">
    	<strong>温馨提示：</strong>{$errormsg}
    </div>
<!-- {/if} -->

<div class="alert alert-info">
	<strong>温馨提示：</strong>绑定后的客服帐号，可以登录<a style="text-decoration:none;" target="_blank" href="https://mpkf.weixin.qq.com/">【在线客服功能】</a>，进行客服沟通。
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    多客服同步操作
                </h4>
            </div>
            <div class="card-body">
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_customer/get_customer")}'>获取全部客服</button><span style="margin-left: 20px;">通过点击该按钮可以获取微信端原有的客服到本地。</span></div><br/>
				<div><button type="button" class="ajaxmenu btn btn-outline-primary" data-url='{RC_Uri::url("wechat/platform_customer/get_online_customer")}'>获取在线客服</button><span style="margin-left: 20px;">通过点击该按钮可以获取微信端在线的客服到本地。</span></div>
			</div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                <!-- {if $ur_here}{$ur_here}{/if} -->
				{if $action_link}
					<a class="btn btn-outline-primary data-pjax float-right" href="{$action_link.href}" id="sticky_a"><i class="ft-plus"></i>{$action_link.text}</a>
				{/if}
					<a class="btn btn-outline-primary float-right m_r10" href="https://mpkf.weixin.qq.com/" target="__blank"><i class="ft-link"></i>去微信客服中心</a>
                </h4>
            </div>
			<div class="card-body">
				<ul class="nav nav-pills float-left">
					<li class="nav-item">
						<a class="nav-link {if $smarty.get.type neq 'online'}active{/if} data-pjax" href='{url path="wechat/platform_customer/init"}'>全部客服
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.all}</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link {if $smarty.get.type eq 'online'}active{/if} data-pjax" href='{url path="wechat/platform_customer/init" args="type=online"}'>在线客服
						<span class="badge badge-pill badge-glow badge-default badge-primary ml-1">{$list.filter.online}</span></a>
					</li>
				</ul>
			</div>
			<div class="col-md-12">
				<table class="table table-hide-edit">
					<thead>
						<tr>
							<th class="w130">客服头像</th>
							<th class="w250">客服账号</th>
							<th class="w200">绑定微信号</th>
							<th class="w200">客服昵称</th>
							<th class="w150">在线状态</th>
							<th class="w100">是否启用</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$list.item item=val} -->
						<tr>
							<td class="big"><img class="thumbnail" src="{$val.kf_headimgurl}"></td>
							<td class="hide-edit-area">
								{$val.kf_account}
								<div class="edit-list">
									{if $val.online_status eq 1}
									<a class="get_session" href='{RC_Uri::url("wechat/platform_customer/get_session", "kf_account={$val.kf_account}")}' title="获取客服会话">获取客服会话</a>&nbsp;|&nbsp;
									{/if}
									{if $val.invite_status neq 'waiting'}
									<a class="data-pjax" href='{RC_Uri::url("wechat/platform_customer/edit", "id={$val.id}")}' title='编辑'>编辑</a>&nbsp;|&nbsp;
									{/if}
									<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='您确定要删除该客服吗？' href='{RC_Uri::url("wechat/platform_customer/remove", "id={$val.id}")}' title='删除'>删除</a>
								</div>
							</td>
		
							<td>
								{if $val.status eq 1}
									{if $val.kf_wx}
										{$val.kf_wx}
									{elseif $val.invite_wx}
										{if $val.invite_status eq 'waiting'}
											{$val.invite_wx}<br />
											<span class="ecjiafc-999">
											邀请绑定待确认<a class="hint--bottom hint--rounded" data-hint="绑定邀请已发送至 {$val.invite_wx} 的微信，请去微信客户端确认后即可绑定"><i class="fontello-icon-help-circled"></i></a>
											</span>
										{elseif $val.invite_status eq 'rejected'}
											<span class="ecjiafc-999">
											邀请绑定被拒绝<a class="hint--bottom  hint--rounded" data-hint='由于对方已拒绝绑定，可重新进行绑定。'><i class="fontello-icon-help-circled"></i></a>
											</span><br />
											<a class="bind_wx" data-toggle="modal" href="#bind_wx" title='绑定微信号' data-val="{$val.kf_account}">重新绑定</a>
										{elseif $val.invite_status eq 'expired'}
											<span class="ecjiafc-999">
												邀请绑定过期<a class="hint--bottom  hint--rounded" data-hint='由于邀请绑定已过期，可重新进行绑定。'><i class="fontello-icon-help-circled"></i></a>
											</span><br />
											<a class="bind_wx" data-toggle="modal" href="#bind_wx" title='绑定微信号' data-val="{$val.kf_account}">重新绑定</a>
										{/if}
									{else}
										<a class="bind_wx" data-toggle="modal" href="#bind_wx" title='绑定微信号' data-val="{$val.kf_account}">绑定微信号</a>
									{/if}
								{else}
									<span class="ecjiafc-999">该客服账号已停用</span>
									<br />
									<a class="bind_wx" data-toggle="modal" href="#bind_wx" title="绑定微信号" data-val="{$val.kf_account}">重新绑定</a>
								{/if}
							</td>
							<td>
								<span class="cursor_pointer" data-text="text" data-trigger="editable" data-url='{RC_Uri::url("wechat/platform_customer/edit_nick")}' data-name="{$val.kf_nick}" data-pk="{$val.id}" data-title='编辑客服昵称' >{$val.kf_nick}</span>
							</td>
							<td class="{if $val.online_status}ecjiafc-red{/if}">
								{if $val.online_status eq 1}
                                web在线
								{elseif $val.online_status eq 0}
                                不在线
								{/if}
							</td>
							<td>
	                        	<i class="{if $val.status eq 1}fa fa-check cursor_pointer{else}fa fa-times cursor_pointer{/if}" data-trigger="toggle_CustomerState" data-url="{RC_Uri::url('wechat/platform_customer/toggle_show')}" data-id="{$val.id}" data-msg="{if $val.status}关闭客服[{$val.kf_account}]将在微信端删除该客服，{else}开启客服[{$val.kf_account}]将在微信端添加该客服，{/if}您确定要这么做吗？"></i>
							</td>
					    </tr>
					    <!--  {foreachelse} -->
						<tr><td class="no-records" colspan="6">没有找到任何记录</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade text-left" id="bind_wx">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">绑定微信号</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			
			<!-- {if $errormsg || $type neq 2} -->
				<div class="card-body">
					<!-- {if $errormsg} -->
				    <div class="alert alert-danger m_b0">
			            <strong>温馨提示：</strong>{$errormsg}
			        </div>
			        <!-- {/if} -->
					<!-- {if $type neq 2} -->
					<div class="alert alert-danger m_b0">
						<strong>温馨提示：</strong>{$type_error}
					</div>
					<!-- {/if} -->
				</div>
			<!-- {/if} -->
			
			<form class="form" method="post" name="bind_form" action="{url path='wechat/platform_customer/bind_wx'}">
				<div class="card-body">
					<div class="form-body">
						<div class="form-group row">
							<label class="col-md-3 label-control text-right">微信号：</label>
							<div class="col-md-8 controls">
								<input class="form-control" type="text" name="kf_wx" value="{$smarty.get.kf_wx}" autocomplete="off" placeholder='请输入需要绑定的客服人员微信号'/>
							</div>
							<div class="col-md-1"><span class="input-must">*</span></div>
						</div>
					</div>
				</div>

				<div class="modal-footer justify-content-center">
			   		<input type="hidden" name="kf_account" />
					<input type="submit" value='邀请绑定' class="btn btn-outline-primary" {if $errormsg || $warn && $type neq 2}disabled{/if}/>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- {/block} -->