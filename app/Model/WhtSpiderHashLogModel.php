<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/23
 * Time: 下午10:41
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
class WhtSpiderHashLogModel extends  Model
{
    protected $table = 'wht_spider_hash_log';

    public function getList($hashId)
    {
        return  $this->where(['spider_url_hash' => $hashId])
                ->select('spider_chapter_url')
                ->get();
        
    }


    public function add($params)
    {

        return $this->insertGetId($params);
    }

}