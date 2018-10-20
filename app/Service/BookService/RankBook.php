<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/10/20
 * Time: 上午11:31
 */

namespace App\Service\BookService;

use App\Model\WhtBookModel;
use App\Model\WhtTypeModel;
use App\Model\WhtBookChapterModel;
/****
 * 排行推荐
**/
class RankBook
{
    //首页banner推荐
    public function indexRank()
    {
        $bookModel = new WhtBookModel();
        $rangResult  = $bookModel->getIndexRecommand(4);
        $count  = count($rangResult);
        if($rangResult  && $count == 4){
            return $rangResult;
        }
        //$len =  4 - $count;
        $rank = $bookModel->readRand(4);
        return $rank;
    }

    //排行版
    public function indexRecommendRank()
    {
        $ll = $this->typePross();
        $rank = (new WhtBookModel())->readRand();
        foreach ($rank as &$item){
            $item['typeName'] =  $ll[$item['book_type']];

        }
        return $rank;
    }
    
    //类型重组
    public function typePross()
    {
        $typeList = (new WhtTypeModel)->getType();
        $ll = [];
        foreach ($typeList as $type){
            $ll  +=  [$type['id'] => $type['type_name']] ;
        }
        return $ll;
    }

    //最近更新
    public function updateRank()
    {
        $typeList = (new WhtBookModel())->updateRank();
        $ll = $this->typePross();
        foreach ($typeList as &$item){
            $item['typeName'] =  $ll[$item['book_type']];

        }
        return $typeList;
        
    }

    //分类排序
    public function category($catid,$page,$num = 30)
    {

      return   (new WhtBookModel)->categoryIndex($catid,$page,$num);

    }
    //完本
    public function overBook($page = 1,$num = 30)
    {

        $pageList = (new WhtBookModel)->overBook($page,$num);
        $typeList = $this->typePross();
        foreach ($pageList['list'] as &$item){

            $item['catName'] = $typeList[$item['book_type']];
        }
        return $pageList;

    }

    public function bookDesc($bookid)
    {
        $bookInfo = (new WhtBookModel)->bookDesc($bookid);
        $typeList = $this->typePross();
        $list = [
            'bookInfo' => $bookInfo,
            'catName' => $typeList[$bookInfo['book_type']]
        ];
        return $list;

    }

    public function getFirstChapte($bookid)
    {
        return  ['first' => (new WhtBookChapterModel)->getFirstChapte($bookid)];
        
    }
    public function getChapte($bookid,$page = 1,$num = 30,$desc = 'desc')
    {
       $chapteList  =  (new WhtBookChapterModel)->getPageList($bookid,$page,$num,$desc);
       /*
       foreach ($chapteList['list'] as &$item){
           $item['content'] = file_get_contents(public_path().$item['content_path']);
       }
       */
       return $chapteList;

    }

    public function content($bookid,$chapterid)
    {
       $contentInfo = (new WhtBookChapterModel)->getcontent($bookid,$chapterid);
       if(!$contentInfo){
           $contentInfo['content'] = '';
           return $contentInfo;
       }
        $contentInfo['content'] = file_get_contents(public_path().$contentInfo['content_path']);
       return $contentInfo;
    }

    //上一章节
    public function prechapter($bookid,$chapterid)
    {

      return   (new WhtBookChapterModel)->prechapter($bookid,$chapterid);
    }

    public function nextchapter($bookid,$chapterid)
    {
        return  (new WhtBookChapterModel)->nextchapter($bookid,$chapterid);

    }

    public function search($keywords)
    {
        return (new WhtBookModel)->search($keywords);
    }

}