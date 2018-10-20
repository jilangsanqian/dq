<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/22
 * Time: 下午9:22
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class WhtBookModel extends Model {

	protected $table = 'wht_book';
	const CREATED_AT = 'create_time';
	const UPDATED_AT = 'update_time';

	public function getOne($bookName,$auther) {
		$where = [
			'book_name'   => $bookName,
			'book_auther' => $auther,
		];
		return $this->where($where)->first();
	}

	public function addBook($params) {
		$data = [
			'book_name'   => $params['bookInfo']['bookName'],
			'book_auther' => $params['bookInfo']['auther'],
			'book_img'    => $params['bookInfo']['imgPath'],
			'book_desc'   => $params['bookInfo']['desc'],
			'book_type'   => $params['bookType'],
			'view_num'    => $params['bookInfo']['viewNum'],
			'follow_num'  => $params['bookInfo']['followNum'],
			'word_num'    => $params['bookInfo']['keyWordCount'],
			'is_over'     => $params['bookInfo']['bookStatus'],
			'create_time' => date('Y-m-d H:i:s'),
		];
		return $this->insertGetId($data);
	}

	//更新时间及信息
	public function updateT($params) {
		$data = [
			'update_time' => date('Y-m-d H:i:s'),
			'is_over'     => $params['bookStatus'],
		];
		return $this->where(['id' => $params['id']])->update($data);
	}

	//更新最新章节
	public function updateNewChapter($params) {
		$data = [
			'new_chapter' => $params['contentInfo']['charpterName'],
			'chapter_id'  => $params['chapterId'],
			'update_time' => date('Y-m-d H:i:s'),
			'is_update'   => 1,
		];
		$where = [
			['id','=',$params['bookId']],
			['chapter_id','<',$params['chapterId']],
		];
		return $this->where($where)->update($data);
	}

	public function paginate() {
		$perPage = Request::get('per_page',10);
		$page = Request::get('page',1);
		$start = ($page - 1) * $perPage;
		//$status = Request::get('status',0);
		//$state = Request::get('state','empty');
		//['status' => $status,'state' => $state];
		//		$where = [
		//			'status' => $status,
		//		];
		//		if ($state != 'empty'){
		//			$where['state'] = $state;
		//		}
		$isOver = Request::get('is_over','empty');
		$isDisplay = Request::get('is_display','empty');
		$auther = Request::get('book_auther','empty');
		$bookName = Request::get('bookName','empty');
		$where = [];
		if ($isOver != 'empty'){
			$where['is_over'] = $isOver;
		}
		if ($isDisplay != 'empty'){
			$where['is_display'] = $isDisplay;
		}
		if ($auther != 'empty'){
			$where['book_auther'] = $auther;
		}
		if ($bookName != 'empty'){
			$where['book_name'] = $bookName;
		}
		$model = $this;
		if ($where){
			$model = $model->where($where);
		}
		$total = $model->count('id');
		$data = $model->offset($start)->limit($perPage)->get();
		$paginator = new LengthAwarePaginator($data,$total,$perPage);
		$paginator->setPath(url()->current());
		return $paginator;
	}

	public static function with($relations) {
		return new static;
	}

	public function updateInfo($where,$data) {
		return $this->where($where)->update($data);
	}

    //首页banner推荐
    public function getIndexRecommand($num =4)
    {
       return  $this->where(['is_display' => 1,'nav_recommend' => 1,])
                ->select('book_name','book_auther','book_img','id')
                ->orderBy('sort','asc')
                ->groupBy('book_type')
                ->limit($num)
                ->get()
                ->toArray();

	}
	
	//阅读排行
    public function readRand($num = 30)
    {
        return $this->where(['is_display' => 1,'nav_recommend' => 1,])
                ->select('book_name','book_auther','book_img','id','book_type','book_desc')
                ->orderBy('click_num','desc')
                ->limit($num)
                ->get()
                ->toArray();

        
    }
    
    //最近更新
    public function updateRank($num = 30)
    {

        return $this->where(['is_display' => 1,'nav_recommend' => 1,])
            ->select('book_name','book_auther','book_img','id','book_type','book_desc')
            ->orderBy('update_time','desc')
            ->limit($num)
            ->get()
            ->toArray();
    }

    public function categoryIndex($catid,$page = 1,$num = 30)
    {
        $offset = ($page - 1) * $num;
        $com = $this->where(['is_display' => 1,'book_type' => $catid]);
        $list = $com->select('book_name','book_auther','book_img','id','book_type','book_desc')
            ->orderBy('sort','desc')
            ->orderBy('update_time','desc')
            ->offset($offset)
            ->limit($num)
            ->get()
            ->toArray();

        $com = $this->where(['is_display' => 1,'book_type' => $catid]);
        $total =  ceil($com->count('id') / $num);
        return  ['list' => $list,'total' => $total,'num' => $num];
    }

    public function overBook($page,$num)
    {
        $offset = ($page - 1) * $num;
        $com = $this->where(['is_display' => 1,'is_over' => 1]);
        $list = $com->select('book_name','book_auther','book_img','id','book_type','book_desc')
            ->orderBy('sort','desc')
            ->orderBy('update_time','desc')
            ->offset($offset)
            ->limit($num)
            ->get()
            ->toArray();

        $com = $this->where(['is_display' => 1,'is_over' => 1]);
        $total =  ceil($com->count('id') / $num);
        return  ['list' => $list,'total' => $total,'num' => $num];

    }

    public function bookDesc($bookid)
    {
        $bookInfo = $this->where(['is_display' => 1,'id' => $bookid])
             ->select('book_name','book_auther','book_img','id','book_type','book_desc','update_time','chapter_id','new_chapter')
            ->first();
        return $bookInfo ? $bookInfo->toArray() : [];

    }

    public function search($keywords)
    {

        $bookInfo = $this->where(['is_display' => 1,['book_name','like','%'.$keywords.'%']])
            ->select('book_name','book_auther','book_img','id','book_type','book_desc','update_time','chapter_id','new_chapter')
            ->get()->toArray();
        return ['search' => $bookInfo];

    }

}