{if $type eq 'image'}
<div class="img_preview">
	<img class="preview_img margin_10" src="{$msg.img_url}" alt="点击查看">
</div>
{/if}

{if $type eq 'voice'}
<div class="img_preview">
	<img class="preview_img margin_10" src="{$msg.voice_url}" alt="点击播放">
</div>
{/if}

{if $type eq 'video'}
<div class="img_preview">
	<img class="preview_img margin_10" src="{$msg.video_url}" alt="点击播放">
</div>											
{/if}

{if $type eq 'mpnews'}
<div class="weui-desktop-media__list-col margin_10">
	<li class="thumbnail move-mod-group big grid-item">
		<!-- {foreach from=$media_content.articles key=key item=val} -->
		{if $key eq 0}
	    <div class="article">
	        <div class="cover">
	            <a target="__blank" href="javascript:;">
	                <img src="{$val.picurl}" />
	            </a>
	            <span>{$val.title}</span>
	        </div>
	    </div>
	    {else}
	    <div class="article_list">
	        <div class="f_l">{$val.title}</div>
	        <a target="__blank" href="javascript:;">
	            <img src="{$val.picurl}" class="pull-right" />
	        </a>
	    </div>
		{/if}
	    <!-- {/foreach} -->
	</li>
</div>
{/if}
