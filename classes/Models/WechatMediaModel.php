<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatMedia
 */
class WechatMediaModel extends Model
{
    protected $table = 'wechat_media';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'title',
        'command',
        'author',
        'is_show',
        'digest',
        'content',
        'link',
        'file',
        'size',
        'file_name',
        'thumb',
        'add_time',
        'edit_time',
        'type',
        'article_id',
        'sort'
    ];

    protected $guarded = [];

    

}