<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/23
 * Time: 下午12:37
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;


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

    public function paginate() {
        $perPage = Request::get('per_page',10);
        $page = Request::get('page',1);
        $start = ($page - 1) * $perPage;
        $total = $this->count('id');
        $data = $this->offset($start)->limit($perPage)->get();
        $paginator = new LengthAwarePaginator($data,$total,$perPage);
        $paginator->setPath(url()->current());
        return $paginator;
    }

    public static function with($relations) {
        return new static;
    }

    public function getList($ids)
    {
        return $this->whereIn('id',$ids)->get();

    }


}