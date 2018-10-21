<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/23
 * Time: 下午9:55
 */

namespace App\Service\SpiderService;
use Illuminate\Support\Facades\Log;
use App\Service\QueryListService\NovelQueryList;
use App\Service\SpiderService\SpiderLog;
use App\Jobs\BookspiderJob;
use Carbon\Carbon;//定时


use App\Service\SpiderService\BookSpider;

class CategorySpider
{
    protected static $config;

    //类型爬取
    public function do($params)
    {
        //规则
        $rules = $this->getConfig($params);
		$urls = $params['spiderUrl'];
		if($params['pageList']){
			$urls = $this->spiderPage($params);
		}
        if(!$urls){
            return false;
        }
        $this->spiderBookUrl($rules,$urls,$params);

    }
    //获取书籍url
    public function spiderBookUrl($rules,$urlList,$params)
    {
        NovelQueryList::start($rules['pageListRule'],$urlList,function($data,$requestUrl)use($params){
            $links = array_column($data,'link');
            $bookSpiderInfo = $params;
            $bookSpiderInfo['spiderUrl'] = $links;
            $bookSpiderInfo['status'] = 0;
            BookspiderJob::dispatch($bookSpiderInfo)
                ->delay(Carbon::now()->addSecond(1))
                ->onQueue(config('queue.bookSpiderQueueName'));

            //爬取书籍介绍
           //(new BookSpider)->do($bookSpiderInfo);
            //写入日志
            $params['pageUrl'] = $requestUrl;
            $params['state'] = 1;
            (new SpiderLog())->addCategoryLog($params);

        },function($errInfo,$requestUrl)use($params){
            //写入日志
            $params['pageUrl'] = $requestUrl;
            $params['remark'] = $errInfo;
            $params['state'] = 0;
            Log::info(json_encode($params));
            (new SpiderLog())->addCategoryLog($params);
        });
    }

    //计算采集页码
    public function spiderPage($params)
    {

        $page = $params['pageEnd'] - $params['finshPage'];
        if(($page == 0 && $params['pageEnd'] == $params['finshPage'] ) || $page < 0 ){
            Log::info('CategorySpider 采集完毕不要重复采集');
            return false;
        }
        $urls = [];
        $start = $params['finshPage'] <= 0 ? 1 : $params['finshPage'];
        for($i = $start; $i <= $params['pageEnd'];$i++){

            $urls[] = str_replace('#p#',$i,$params['spiderUrl']);
        }
        return $urls;
    }
    //获取采集规则
    public function getConfig($params)
    {
        if(self::$config){
            return self::$config[$params['spiderKeyWord']];
        }
        self::$config = $config = config('spider');
        return $config[$params['spiderKeyWord']];
    }




}