<?php

namespace Ecjia\App\Wechat\Models;

use Royalcms\Component\Database\Eloquent\Model;

/**
 * Class WechatMassHistory
 */
class WechatMassHistoryModel extends Model
{
    protected $table = 'wechat_mass_history';

    public $timestamps = false;

    protected $fillable = [
        'wechat_id',
        'media_id',
        'type',
        'status',
        'send_time',
        'msg_id',
        'totalcount',
        'filtercount',
        'sentcount',
        'errorcount'
    ];

    protected $guarded = [];

    

}