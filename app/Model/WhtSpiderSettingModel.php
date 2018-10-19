<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/23
 * Time: 下午12:37
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WhtSpiderSettingModel extends Model
{

    protected $table = 'wht_spider_setting';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    public function getOne($id)
    {
       return $this->where(['id' =>$id])->first();
    }

    public function updatefinshPage($params)
    {
        return $this->increment('finsh_page',1,$params);
    }

}