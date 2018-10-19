<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/25
 * Time: 上午11:59
 */
namespace App\Service\BookService;

use App\Model\WhtBookModel;
use App\Model\WhtBookChapterModel;
use Illuminate\Support\Facades\Log;

class Book {

	public function addBook($params) {
		$bookInfo = $params['bookInfo'];
		$info = [];
		foreach ($bookInfo as $key => $v) {
			if ($key == 'bookName'){
				$v = str_replace('全文阅读','',$v);
			}
			if ($key == 'keyWordCount'){
				$v = str_replace('字','',$v);
			}
			$v = $this->word($v);
			if ($key == 'bookStatus'){
				$v = strstr($v,'载中') ? 0 : (strstr($v,'完成') ? 1 : 2);
			}
			if ($key == 'imgPath'){
				$v = $this->save_remote_thumb($v);
			}
			$info[$key] = $v;
		}
		$bookModel = new WhtBookModel();
		$params['bookInfo'] = $info;
		$bookResult = $bookModel->getOne($params['bookInfo']['bookName'],$params['bookInfo']['auther']);
		if ($bookResult){
			$bookModel->updateT(['id' => $bookResult->id,'bookStatus' => $params['bookInfo']['bookStatus']]);
			return $bookResult->id;
		}
		return $bookModel->addBook($params);
	}

	public function word($str) {

		return trim(strip_tags(html_entity_decode($str)));
	}

	function save_remote_thumb($thumb,$dir = 'books') {
		if (empty($thumb))
			return '';
		if (strstr($thumb,'nocover')){
			return '/thumb/default.png';
		}
		$filepath = '/thumb/' . $dir . '/' . date('Ym/d') . '/';//缩略图按月划分
		$fileroot = public_path() . $filepath;
		if (!is_dir($fileroot))
			mkdir($fileroot,0777,true);
		$filename = time() . rand(100000,999999);
		$fileext = substr($thumb,strrpos($thumb,'.'));
		in_array($fileext,['jpg','png','gif','bmp']) or $fileext = 'jpg';//jpeg->jpg
		$filename .= '.' . $fileext;
		$result = \File::put($fileroot . $filename,@file_get_contents($thumb));
		if ($result){
			if ($this->isImage($fileroot . $filename)){
				$thumb = $filepath . $filename;
			} else{
				\File::delete($fileroot . $filename);
				$thumb = '';
			}
		} else{
			$thumb = '';
		}
		return $thumb;
	}

	function isImage($image) {
		$info = @getimagesize($image);
		if (!$info)
			return false;
		//$ext = image_type_to_extension($info[2]);
		return true;
	}

	//添加内容
	public function addChapte($params) {

		$pathInfo = explode('/',$params['pageUrl']);
		$pathInfo = array_pop($pathInfo);
		$chapterId = explode('.',$pathInfo)[0];
		$params['chapterId'] = $chapterId;
		$contentPath = $this->file_path($params['bookId'],$params['contentInfo']['charpterName'],$params['contentInfo']['content']);
		$params['contentInfo']['contentPath'] = $contentPath;
		if ((new WhtBookChapterModel())->addChapter($params)){
			(new WhtBookModel)->updateNewChapter($params);
		}
		return true;
	}

	//数据过滤
	public function removeDD($content) {
		$ll = ['顶点小说 Ｘ２３ＵＳ．ＣＯＭ','更新最快','顶 点 小 说 Ｘ ２３ Ｕ Ｓ．Ｃ ＯＭ','顶点小说 ２３ＵＳ．ＣＯＭ'];
		$sub = ['','','',''];
		return str_replace($ll,$sub,$content);
	}

	function file_path($bookId,$chapterName,$content) {
		if (!$content){
			return false;
		}
		$content = $this->removeDD($content);
		$dirname = md5($bookId);
		$filepath = '/BookChapter/' . $dirname . '/';//缩略图按月划分
		$fileroot = public_path() . $filepath;
		if (!is_dir($fileroot)){
			mkdir($fileroot,0777,true);
		}
		$filename = md5($chapterName) . '.txt';
		$path = $fileroot . $filename;
		if (file_put_contents($path,$content)){
			return $filepath . $filename;
		}
		return 'error';
	}

}