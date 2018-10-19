<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/23
 * Time: 下午12:44
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WhtBookChapterModel extends Model {
	protected $table = 'wht_book_chapter';
	const CREATED_AT = 'create_time';
	const UPDATED_AT = 'update_time';
	protected $fillable = [
		'chapter_id',
		'book_id',
		'chapter_name',
		'content_path',
		'state',
		'spider_url',
		'create_time',
		'update_time',
	];

	public function addChapter($params) {
		$info = $this->where(['book_id' => $params['bookId'],'chapter_id' => $params['chapterId']])->first();
		if ($info){
			return false;
		}
		$data = [
			'chapter_id'   => $params['chapterId'],
			'book_id'      => $params['bookId'],
			'chapter_name' => $params['contentInfo']['charpterName'],
			'content_path' => $params['contentInfo']['contentPath'],
			'state'        => $params['charpterstatus'],
			'spider_url'   => $params['pageUrl'],
			'create_time'  => date('Y-m-d H:i:s'),
		];
		return $this->create($data);
	}

	public function getList($bookId) {
		return $this->where(['book_id' => $bookId])->select('spider_url')->get()->toArray();
	}
}