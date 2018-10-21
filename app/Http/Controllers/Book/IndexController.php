<?php
/**
 * Created by yunniu.
 * User: ranhai
 * Date: 2018-10-17
 * Time: 16:31
 */
namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Service\BookService\RankBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IndexController extends Controller {

	public function index() {

        $book = new RankBook;
        $result = $book->indexRank();
        $rankList = $book->indexRecommendRank();
        $index = array_shift($rankList);
        $updateRank = $book->updateRank();
        $data = [
            'banner' => $result,
            'index' => $index,
            'rankList' => $rankList,
            'updateRank' => $updateRank
        ];
		return view('index',$data);
	}

    public function category($catid,$page)
    {
        if($page <= 0){
            $page = 1;
        }
        $book = new RankBook;
        $typeList = $book->typePross();
        if(!isset($typeList[$catid])){
            $catid =  array_keys($typeList)[0];
        }
        $pageList = $book->category($catid,$page,10);
        $pageList['catName'] =  $typeList[$catid];
        $pageList['page'] = $page;
        $pageList['catid'] = $catid;
        return view('cat',$pageList);
        
	}

	//完本
    public function overBook($page)
    {
        $page = intval($page);
        if( $page <= 0){
            $page = 1;
        }
        $book = new RankBook;
        $overList = $book->overBook($page,10);
        $overList['page'] = $page;
        return view('over',$overList);

	}
	//书籍描述
    public function bookDesc($bookid)
    {
        if($bookid <= 0){
            return redirect('／');
        }
        $book = new RankBook;
        $bookInfo = $book->bookDesc($bookid);
        $chapteInfo = $book->getChapte($bookid,1,30);
        $chapteFirst =  $book->getFirstChapte($bookid);
        return view('book',array_merge($bookInfo,$chapteInfo,$chapteFirst));
        
	}
    //内容
    public function content($bookid,$chapterid)
    {
        $bookid = intval($bookid);
        $chapterid = intval($chapterid);
        if($bookid <= 0 || $chapterid <=0){
            return redirect('／');
        }
        $book = new RankBook;
        $content = $book->content($bookid,$chapterid);
        $prechapter = $book->prechapter($bookid,$chapterid);
        $nextchapter = $book->nextchapter($bookid,$chapterid);
        $data = array_merge($content,$prechapter,$nextchapter,['book_id' => $bookid,'chapter_id' => $chapterid]);
        return view('content',$data);
	}
    //章节列表
    public function list($bookid,$desc,$page)
    {
        $bookid = intval($bookid);
        $page = intval($page);
        if($page <= 0){
            $page = 1;
        }
        if($bookid <= 0 ){
            return redirect('/');
        }
        $linkDesc = ['order' => '/desc','page' => $page];
        if($desc != 'desc'){
            $desc = 'asc';
            $linkDesc['order'] = '';

        }
        $book = new RankBook;
        $list = $book->getChapte($bookid,$page,30,$desc);
        $bookInfo = $book->bookDesc($bookid);
        return view('list', array_merge($bookInfo,$list,$linkDesc));
	}

    public function listAsc($bookid,$page)
    {
        return $this->list($bookid,'asc',$page);
        
	}
    //搜索
    public function search(Request $request)
    {
        $keywords = $request->get('s');
        if(!$keywords){
            return  redirect('/');
        }
        $book = new RankBook;
        $info = $book->search($keywords);
        $info['keywords'] = $keywords;
        return view('search',$info);

	}
}