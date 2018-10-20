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

    public function getPageList($bookid,$page = 1,$num =30,$desc)
    {
        $offset = ($page - 1) * $num;
        $com = $this->where(['is_display' => 1,'book_id' => $bookid,'state'=> 1]);
        $list = $com->select('chapter_name','book_id','chapter_id')
            ->orderBy('chapter_id',$desc)
            ->orderBy('create_time',$desc)
            ->offset($offset)
            ->limit($num)
            ->get()
            ->toArray();

        $com = $this->where(['is_display' => 1,'book_id' => $bookid,'state'=> 1]);
        $total =  ceil($com->count('chapter_id') / $num);
        return  ['list' => $list,'total' => $total,'num' => $num];

	}

    public function getFirstChapte($bookid)
    {
        $info = $this->where(['is_display' => 1,'book_id' => $bookid,'state'=> 1])
                ->select('chapter_id','book_id')
                ->orderBy('chapter_id','asc')
                ->first();
        return $info ? $info->toArray() : [];
        
	}

    public function getContent($bookid,$chapterid)
    {

        $info = $this->where(['is_display' => 1,'book_id' => $bookid,'chapter_id' => $chapterid,'state'=> 1])
            ->select('content_path','chapter_name')
            ->first();
        return $info ? $info->toArray() : [];
	}

	//前一章节
    public function prechapter($bookid,$chapterid)
    {
       $where = [
           'is_display' => 1,
           'book_id' => $bookid,
           'state'=> 1,
           ['chapter_id','<',$chapterid]
       ];
        $info = $this->where($where)
            ->select('chapter_id','book_id')
            ->orderBy('chapter_id','desc')
            ->first();
        return $info ? ['prechapter' => $info->toArray() ]  : ['prechapter' => []];
	}
    //后一章节
    public function nextchapter($bookid,$chapterid)
    {
        $where = [
            'is_display' => 1,
            'book_id' => $bookid,
            'state'=> 1,
            ['chapter_id','>',$chapterid]
        ];
        $info = $this->where($where)
            ->select('chapter_id','book_id')
            ->orderBy('chapter_id','asc')
            ->first();
        return $info ? ['nextchapter' => $info->toArray()] : ['nextchapter' => []];
    }
}