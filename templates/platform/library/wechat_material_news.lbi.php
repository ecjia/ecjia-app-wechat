<!--图文信息  -->
<div class="row-fluid goods-photo-list">
    <!-- {if $lists.item} -->
    <div class="wmk_grid ecj-wookmark wookmark_list material_pictures">
        <ul class="wookmark-goods-photo move-mod nomove">
            <!-- {foreach from=$lists.item item=articles} -->
            <!-- {if $articles.articles} -->
            <li class="thumbnail move-mod-group">
                <div class="article">
                    <div class="cover">
                        <a target="__blank" href="{$articles.file}">
                            <img src="{$articles.file}" />
                        </a>
                        <span>{$articles.title}</span>
                    </div>
                </div>
                <!-- {foreach from=$articles.articles key=key item=val} -->
                <div class="article_list">
                    <div class="f_l">{if $val.title}{$val.title}{else}{lang key='wechat::wechat.no_title'}{/if}</div>
                    <a target="__blank" href="{$val.file}">
                        <img src="{$val.file}" class="pull-right" />
                    </a>
                </div>
                <!-- {/foreach} -->
                <p>
                    <a class="ajaxremove" data-imgid="{$val.id}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_imgtext_cover'}" href='{url path="wechat/platform_material/remove" args="id={$articles.id}"}' title="{lang key='wechat::wechat.delete'}"><i class="ft-trash-2"></i></a>
                    <a href='{url path="wechat/platform_material/edit" args="id={$articles.id}&material=1"}'><i class="ft-edit-2"></i></a>
                </p>
            </li>
            <!-- {else} -->
            <li class="thumbnail move-mod-group">
                <div class="articles">
                    <div class="articles_title">{if $articles.title}{$articles.title}{else}{lang key='wechat::wechat.no_title'}{/if}</div>
                    <p class="ecjiaf-pre">{$articles.add_time}</p>
                    <a target="__blank" href="{$articles.file}">
                        <img src="{$articles.file}"/>
                    </a>
                    <div class="articles_content">{$articles.content}</div>
                </div>
                <p>
                    <a class="ajaxremove" data-imgid="{$articles.id}" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.remove_images_material'}" href='{url path="wechat/platform_material/remove" args="id={$articles.id}"}' title="{lang key='wechat::wechat.delete'}"><i class="ft-trash-2"></i></a>
                    <!-- {if $articles.article_id} -->
                    <a href='{url path="wechat/platform_material/edit" args="id={$articles.id}&material=1"}'><i class="ft-edit-2"></i></a>
                    <!-- {else} -->
                    <a href='{url path="wechat/platform_material/edit" args="id={$articles.id}&material=1"}'><i class="ft-edit-2"></i></a>
                    <!-- {/if} -->
                </p>
            </li>
            <!-- {/if} -->
            <!-- {/foreach} -->
        </ul>
    </div>
    <!-- {else} -->
    <table class="table table-striped">
        <tr>
            <td class="no-records" colspan="10" style="border-top:0px;line-height:100px;">{lang key='wechat::wechat.unfind_any_recode'}</td>
        </tr>
    </table>
    <!-- {/if} -->
</div>
<!-- {$lists.page} -->