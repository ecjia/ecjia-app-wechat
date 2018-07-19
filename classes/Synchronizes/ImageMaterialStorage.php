<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/19
 * Time: 4:07 PM
 */

namespace Ecjia\App\Wechat\Synchronizes;

use \Ecjia\App\Wechat\Models\WechatMediaModel;

class ImageMaterialStorage
{
    protected $wechat_id;

    protected $type;

    protected $data;

    public function __construct($wechat_id, $type, $data)
    {
        $this->wechat_id = $wechat_id;
        $this->type = $type;
        $this->data = $data;
    }


    public function save()
    {
        $items = $this->data->get('item');

        $wechat_id = $this->wechat_id;
//        dd($items);
        collect($items)->map(function($item) use ($wechat_id) {

            $media_id = $item['media_id'];

            $model = WechatMediaModel::where('wechat_id', $wechat_id)->where('media_id', $media_id)->where('type', 'image')->first();
            if (!empty($model)) {
                //已存在，更新数据
                $this->updateImage($model, $item);

            } else {
                //不存在，添加数据
                $this->saveImage($item);
            }

        });

    }

    /**
     * 更新图片素材
     * @param $model
     * @param $first_item
     * @param $create_time
     * @param $update_time
     */
    protected function updateImage($model, $item)
    {
        $data = [
            'file_name'             => $item['name'],
            'media_url'             => $item['url'],
            'edit_time'             => $item['update_time'],
        ];
        $model->update($data);
    }

    /**
     * 保存图片素材
     * @param $model
     * @param $news_item
     * @param $create_time
     * @param $update_time
     */
    protected function saveImage($item)
    {
        $data = [
            'file_name'             => $item['name'],
            'media_url'             => $item['url'],

            'wechat_id'             => $this->wechat_id,
            'is_material'           => 'material',
            'type'                  => 'image',
            'add_time'              => $item['update_time'],
            'edit_time'             => $item['update_time'],
        ];
        WechatMediaModel::create($data);
    }

}