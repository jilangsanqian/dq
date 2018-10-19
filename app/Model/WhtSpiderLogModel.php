<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/22
 * Time: 下午9:16
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class WhtSpiderLogModel extends Model {

	const CREATED_AT = 'create_time';
	const UPDATED_AT = 'update_time';
	protected $table = 'wht_spider_log';
	protected $fillable = [
		'spider_id',
		'book_id',
		'book_type',
		'status',
		'state',
		'spider_url',
		'spider_url_hash',
		'spider_chapter_id',
		'remark',
		'create_time',
		'update_time',
	];

	public function getLogList($typeId = 1) {
		return $this->where(['status' => $typeId])->get();
	}

	public function paginate() {
		$perPage = Request::get('per_page',10);
		$page = Request::get('page',1);
		$start = ($page - 1) * $perPage;
		$status = Request::get('status',0);
		$state = Request::get('state','empty');
		['status' => $status,'state' => $state];
		$where = [
			'status' => $status,
		];
		if ($state != 'empty'){
			$where['state'] = $state;
		}
		$total = $this->where($where)->count('id');
		$data = $this->where($where)->offset($start)->limit($perPage)->get();
		$paginator = new LengthAwarePaginator($data,$total,$perPage);
		$paginator->setPath(url()->current());
		return $paginator;
	}

	public function add($params) {
		$where = ['spider_url_hash' => $params['spider_url_hash']];
		if ($this->where($where)->first()){
			return $this->where($where)->update(['update_time' => $params['update_time']]);
		}
		return $this->insertGetId($params);
	}

	public static function with($relations) {
		return new static;
	}

	public function getSpiderList($ids) {
		return $this->whereIn('id',$ids)->get();
	}

	//获取
	public function getSpiderLists($ids) {
		return $this->whereIn('book_id',$ids)->groupBy('book_id')->orderBy('update_time','desc')->get();
	}
}