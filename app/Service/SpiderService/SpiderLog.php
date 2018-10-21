<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/24
 * Time: 下午5:29
 */

namespace App\Service\SpiderService;


/****
 *采集日志处理
****/
use App\Model\WhtSpiderHashLogModel;
use App\Model\WhtSpiderSettingModel;
use App\Model\WhtSpiderLogModel;

class SpiderLog
{

    //写入wht_spider_log
    //写入wht_spider_hash_log
    //写入wht_spider_setting
    //分类日志
    public function addCategoryLog($data)
    {

        $this->spiderLog($data);
        $this->spiderHashLog($data);
        //$this->spiderSetting($data);
        return true;
    }

    //书籍写入日志
    public function bookSpiderLog($params)
    {
        $bookInfo = $params['bookInfo'];
        unset($params['bookInfo']);
        $data =  array_merge($params,$bookInfo);
        $this->spiderLog($data);
        $this->spiderHashLog($data);
        return true;

    }

    public function spiderLog($params)
    {
        $data =  [
            'spider_id' => $params['spiderId'],
            'book_type' => $params['bookType'],
            'status' => $params['status'],
            'state' => $params['state'],
            'spider_url' => $params['pageUrl'],
            'spider_url_hash' => md5($params['pageUrl']),
            'remark' =>  isset($params['remark']) ? $params['remark']:'',
            //章节爬取信息
            'book_id' => isset($params['bookId']) ? $params['bookId'] : 0,
            'spider_chapter_id' => isset($params['spiderChapterId']) ? $params['spiderChapterId'] : 0,
            'create_time' => date('Y-m-d H:i:s'),
            'update_time' => date('Y-m-d H:i:s'),
        ];
       return  (new WhtSpiderLogModel())->add($data);

    }

    public function spiderHashLog($params)
    {
        $data  = [
            'spider_url_hash' => md5($params['pageUrl']),
            'spider_chapter_url' => $params['pageUrl'],
        ];
       return  ( new WhtSpiderHashLogModel)->add($data);
    }

    public function spiderSetting($params)
    {

        $data = [
            'id' => $params['spiderId']
        ];

        return  (new WhtSpiderSettingModel)->updatefinshPage($data);

    }


}