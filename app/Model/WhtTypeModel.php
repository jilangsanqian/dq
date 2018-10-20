<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/23
 * Time: 下午12:26
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class WhtTypeModel extends Model
{
    protected $table = 'wht_type';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';


    public function getType()
    {
        return  $this->where(['state' => 1])
            ->select('type_name','id')
            ->get()
            ->toArray();
        
    }

}