<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/23
 * Time: 下午9:55
 */

namespace App\Service\SpiderService;
use App\Model\WhtSpiderHashLogModel;
use Illuminate\Support\Facades\Log;
use App\Service\QueryListService\NovelQueryList;
use App\Service\BookService\Book;
use App\Service\SpiderService\ChapteSpider;

use App\Jobs\ChapteSpiderJob;
use Carbon\Carbon;//定时

class BookSpider
{
    protected static $config;

    //书籍信息
    public function do($params)
    {
        $rule = $this->getConfig($params);
        $urls = $params['spiderUrl'];
        $this->spiderStart($rule,$urls,$params);

        return true;
    }


    public function spiderStart($rule,$urls,$params)
    {
        NovelQueryList::start($rule['bookInfoRule'],$urls,function($data,$requestUrl)use($params){
            foreach ($data[0] as &$value){
                $value =trim($this->toutf8($value));
            }
            $params['bookInfo'] = $data[0];
            //写入日志
            $params['pageUrl'] = $requestUrl;
            $params['state'] = 1;
            //添加书籍
            $bookId = (new Book())->addBook($params);
            if(!$bookId){
                $params['state'] = 0;
                $params['remark'] = '数据库插入失败';
            }else{
                $params['bookId'] = $bookId;
                //(new ChapteSpider)->do($params);
                ChapteSpiderJob::dispatch($params)
                    ->delay(Carbon::now()->addSecond(1))
                    ->onQueue(config('queue.chapeSpiderQueueName'));
            }
            (new SpiderLog())->bookSpiderLog($params);

        },function($errInfo,$requestUrl)use($params){
            //var_dump($errInfo,$requestUrl);exit;
            //写入日志

            $params['pageUrl'] = $requestUrl;
            $params['remark'] = $errInfo;
            $params['state'] = 0;
            Log::info(json_encode($params));
            (new SpiderLog())->addCategoryLog($params);
        });

        
    }
    public function getConfig($params)
    {
        if(self::$config){
            return self::$config[$params['spiderKeyWord']];
        }
        self::$config = $config = config('spider');
        return $config[$params['spiderKeyWord']];
    }



    //转编码格式
    function toutf8($str)
    {
        $encode = mb_detect_encoding($str, array('ASCII','UTF-8','GB2312','GBK','BIG5'));
        return mb_convert_encoding($str, 'UTF-8', $encode);

    }

}