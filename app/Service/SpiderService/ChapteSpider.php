<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/24
 * Time: 下午5:14
 */
namespace App\Service\SpiderService;

/***
 *
 *章节spider
 *
 ***/
use App\Service\QueryListService\NovelQueryList;
use App\Service\BookService\Book;
use App\Model\WhtBookChapterModel;
use Illuminate\Support\Facades\Log;

class ChapteSpider {

	protected static $config;

	//单本书籍爬取
	public function do($params) {
		$rule = $this->getConfig($params);
		$url = $params['bookInfo']['contentUrl'];
		$urls = $this->getContentUrlList($url,$rule['chapterUrlListRule']);
		$urls = $this->linksFilter($urls,$params['bookId']);
		if (empty($urls)){
			Log::info('new version url:'.$url.',bookname:'.$params['bookId']);
			return false;
		}
		$this->spiderStart($urls,$rule['contentReule'],$params);
	}

	//links去重复
	public function linksFilter($links,$bookId) {
		$links = array_unique($links);
		$list = (new WhtBookChapterModel)->getList($bookId);
		if (empty($list)){
			return $links;
		}
		$list = array_column($list,'spider_url');
		$diff = array_diff($links,$list);
		if(empty($diff)){
			return [];
		}
		return  array_values($diff);
	}

	public function spiderStart($urls,$rule,$params) {

		NovelQueryList::start($rule,$urls,function ($data,$requestUrl) use ($params) {

			$content = $data[0]['content'];
			$charpterName = $data[0]['title'];
			$params['contentInfo'] = [
				'content'      => $this->toutf8($content),
				'charpterName' => $this->toutf8($charpterName),
			];
			$params['pageUrl'] = $requestUrl;
			$params['charpterstatus'] = 1;
			(new Book())->addChapte($params);
			$hashlog = [
				'pageUrl' => $requestUrl,
			];
			(new SpiderLog())->spiderHashLog($hashlog);
		},function ($errInfo,$requestUrl) use ($params) {
			$hashlog = [
				'pageUrl' => $requestUrl,
			];
			(new SpiderLog())->spiderHashLog($hashlog);
		});
	}

	public function getConfig($params) {
		if (self::$config){
			return self::$config[$params['spiderKeyWord']];
		}
		self::$config = $config = config('spider');
		return $config[$params['spiderKeyWord']];
	}

	public function getContentUrlList($url,$rule) {

		$ql = NovelQueryList::getInstance();
		$links = $ql->get($url)->rules($rule)->query(function ($item) use ($url) {
			$link = $item['link'];
			if (!strstr($link,'http') || !strstr($link,'https')){
				$link = $url . $link;
			}
			return $link;
		})->getData()->all();
		$ql->destruct();
		return $links;
	}

	//转编码格式
	function toutf8($str) {
		$encode = mb_detect_encoding($str,['ASCII','UTF-8','GB2312','GBK','BIG5']);
		return mb_convert_encoding($str,'UTF-8',$encode);
	}
}