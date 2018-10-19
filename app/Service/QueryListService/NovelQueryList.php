<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/24
 * Time: 上午12:00
 */

namespace App\Service\QueryListService;
use QL\QueryList;
use QL\Ext\CurlMulti;

class NovelQueryList
{
    protected static $spider;
    private function __construct()
    {

    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getInstance()
    {
        if(self::$spider && self::$spider instanceof QueryList){
            return self::$spider;
        }
       // self::queryListConfig();
        $ql = QueryList::getInstance();
        $ql->use(CurlMulti::class);
        $ql->use(CurlMulti::class,'curlMulti');
        self::$spider = $ql;
        return $ql;
    }

    /*
    protected static function queryListConfig ()
    {
        QueryList::config()->bind('toutf8',function(){
            $encode = mb_detect_encoding($this->getHtml(), array('ASCII','UTF-8','GB2312','GBK','BIG5'));
            $html = mb_convert_encoding($this->getHtml(), 'utf-8', $encode);
            $this->setHtml($html);
            return $this;
        });
    }
    */


    public static function start(array $rules, array $urls,callable $sFun,callable $eFun)
    {
        $ql = self::getInstance();
        $ql->rules($rules)
           // ->toutf8()
            ->curlMulti($urls)
            ->success(function (QueryList $ql,CurlMulti $curl,$r)use($sFun){
                $url = $r['info']['url'];
                $data = $ql->query()->getData();
                return $sFun($data->all(),$url);
            })->error(function ($errorInfo,CurlMulti $curl)use($eFun){
                return $eFun($errorInfo['error'],$errorInfo['info']['url']);
            })->start([
                // 最大并发数，这个值可以运行中动态改变。
                'maxThread' => 10,
                // 触发curl错误或用户错误之前最大重试次数，超过次数$error指定的回调会被调用。
                'maxTry' => 3,
                // 全局CURLOPT_*
                'opt' => [
                    CURLOPT_TIMEOUT => 1000,
                    CURLOPT_CONNECTTIMEOUT => 1,
                    CURLOPT_RETURNTRANSFER => true
                ],
                // 缓存选项很容易被理解，缓存使用url来识别。如果使用缓存类库不会访问网络而是直接返回缓存。
                'cache' => ['enable' => false, 'compress' => false, 'dir' => null, 'expire' =>86400, 'verifyPost' => false]
            ]);
        $ql->destruct();

    }

    //转编码格式
    function toutf8($str)
    {
        $encode = mb_detect_encoding($str, array('ASCII','UTF-8','GB2312','GBK','BIG5'));
        return mb_convert_encoding($str, 'UTF-8', $encode);

    }
    function file_path($bookName,$chapterName,$content){
        if(!$content){
            return false;
        }
        $dirname = md5($bookName);
        $filepath = '/BookChapter/' . $dirname . '/';//缩略图按月划分
        $fileroot = public_path().$filepath;
        if( !is_dir($fileroot) ) {
            mkdir($fileroot ,0777,true);
        }
        $filename =  md5($chapterName).'.txt';
        $path = $fileroot.$filename;
        if(file_put_contents($path,$content)){
            return  $filepath.$filename;
        }
        return  'error';

    }

}