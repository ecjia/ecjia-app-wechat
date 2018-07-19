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

        collect($items)->map(function($item) use ($wechat_id) {

            $media_id = $item['media_id'];
            $create_time = array_get($item, 'content.create_time');
            $update_time = array_get($item, 'content.update_time');
            $news_item = array_get($item, 'content.news_item');

            $model = WechatMediaModel::where('wechat_id', $wechat_id)->where('media_id', $media_id)->where('type', 'news')->first();
            if (!empty($model)) {
                //已存在，更新数据
                if (count($news_item) > 1) {
                    $this->updateMultiNews($model, $news_item, $create_time, $update_time);
                } else {
                    $this->updateMainNews($model, $news_item[0], $create_time, $update_time);
                }

            } else {
                //不存在，添加数据
                if (count($news_item) > 1) {
                    $this->saveMultiNews($news_item, $create_time, $update_time);
                } else {
                    $this->saveMainNews($news_item[0], $create_time, $update_time);
                }
            }

        });

    }

    /**
     * 更新主图文素材
     * @param $model
     * @param $first_item
     * @param $create_time
     * @param $update_time
     */
    protected function updateMainNews($model, $first_item, $create_time, $update_time)
    {
        $data = [
            'title'                 => $first_item['title'],
            'author'                => $first_item['author'],
            'digest'                => $first_item['digest'],
            'content'               => $first_item['content'],
            'link'                  => $first_item['content_source_url'],
            'thumb'                 => $first_item['thumb_media_id'],
            'is_show'               => $first_item['show_cover_pic'],
            'media_url'             => $first_item['url'],
            'thumb_url'             => $first_item['thumb_url'],
            'need_open_comment'     => $first_item['need_open_comment'],
            'only_fans_can_comment' => $first_item['only_fans_can_comment'],

            'add_time'              => $create_time,
            'edit_time'             => $update_time,
        ];
        $model->update($data);
    }

    /**
     * 更新多图文素材
     * @param $model
     * @param $news_item
     * @param $create_time
     * @param $update_time
     */
    protected function updateMultiNews($model, $news_item, $create_time, $update_time)
    {
        $this->updateMainNews($model, $news_item[0], $create_time, $update_time);

        unset($news_item[0]);

        if (! $model->subNews->isEmpty()) {
            $model->subNews->each(function ($item) {
                $item->delete();
                return true;
            });
        }

//        dd($model->subNews);

        foreach ($news_item as $news) {
            $data = [
                'title'                 => $news['title'],
                'author'                => $news['author'],
                'digest'                => $news['digest'],
                'content'               => $news['content'],
                'link'                  => $news['content_source_url'],
                'thumb'                 => $news['thumb_media_id'],
                'is_show'               => $news['show_cover_pic'],
                'media_url'             => $news['url'],
                'thumb_url'             => $news['thumb_url'],
                'need_open_comment'     => $news['need_open_comment'],
                'only_fans_can_comment' => $news['only_fans_can_comment'],

                'wechat_id'             => $this->wechat_id,
                'parent_id'             => $model->id,
                'is_material'           => 'material',
                'type'                  => 'news',
                'add_time'              => $create_time,
                'edit_time'             => $update_time,
            ];
            WechatMediaModel::create($data);
        }
    }

    /**
     * 保存主图文
     * @param $first_item
     */
    protected function saveMainNews($first_item, $create_time, $update_time)
    {
//        $first_item = $news_item[0];

        $data = [
            'title'                 => $first_item['title'],
            'author'                => $first_item['author'],
            'digest'                => $first_item['digest'],
            'content'               => $first_item['content'],
            'link'                  => $first_item['content_source_url'],
            'thumb'                 => $first_item['thumb_media_id'],
            'is_show'               => $first_item['show_cover_pic'],
            'media_url'             => $first_item['url'],
            'thumb_url'             => $first_item['thumb_url'],
            'need_open_comment'     => $first_item['need_open_comment'],
            'only_fans_can_comment' => $first_item['only_fans_can_comment'],

            'wechat_id'             => $this->wechat_id,
            'parent_id'             => 0,
            'is_material'           => 'material',
            'type'                  => 'news',
            'add_time'              => $create_time,
            'edit_time'             => $update_time,
        ];
        $parent_model = WechatMediaModel::create($data);

        return $parent_model;
    }


    /**
     * 保存多图文
     * @param $news_item
     * @param $create_time
     * @param $update_time
     */
    protected function saveMultiNews($news_item, $create_time, $update_time)
    {
        $parent_model = $this->saveMainNews($news_item[0], $create_time, $update_time);

        unset($news_item[0]);

        foreach ($news_item as $news) {
            $data = [
                'title'                 => $news['title'],
                'author'                => $news['author'],
                'digest'                => $news['digest'],
                'content'               => $news['content'],
                'link'                  => $news['content_source_url'],
                'thumb'                 => $news['thumb_media_id'],
                'is_show'               => $news['show_cover_pic'],
                'media_url'             => $news['url'],
                'thumb_url'             => $news['thumb_url'],
                'need_open_comment'     => $news['need_open_comment'],
                'only_fans_can_comment' => $news['only_fans_can_comment'],

                'wechat_id'             => $this->wechat_id,
                'parent_id'             => $parent_model->id,
                'is_material'           => 'material',
                'type'                  => 'news',
                'add_time'              => $create_time,
                'edit_time'             => $update_time,
            ];
            WechatMediaModel::create($data);
        }
    }



}