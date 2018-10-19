<?php
/**
 * Created by PhpStorm.
 * User: ranhai
 * Date: 2018/9/23
 * Time: 下午10:52
 */

/***
 *所有爬虫配置文件必须遵守该规则
 *
 *统一使用querylist 采集
 *
 *pageListRule:分页内容url获取规则
 *chapterUrlListRule:获取章节urlList规则
 *contentReule:获取内容规则
 *
****/


return [

    'DingDian' => [
        //分页内容url获取规则
        'pageListRule' => [
            'link' => ['#content  dd  table  tr   .L:first-child  a:first-child','href'],
        ],
        //book简介规则
        'bookInfoRule'=>[
            'imgPath' => ['.hst img','src'], //封面图片
            'bookName' => ['h1','text'], //书籍名称
            'auther'   => ['#at tr:first td:eq(1)','text'], //书籍作者
            'bookStatus' => ['#at tr:first td:eq(2)','text'], //书籍状态
            'followNum' => ['#at tr:eq(1) td:eq(0)','text'], //关注量
            'keyWordCount' => ['#at tr:eq(1) td:eq(1)','text'], //字数
            'updateTime' => ['#at tr:eq(1) td:eq(2)','text'], //更新时间
            'viewNum' => ['#at tr:eq(2) td:eq(0)','text'], //浏览量
            'contentUrl' => ['.read','href'], //内容url
            'desc' => ['#content dd:eq(3) p:eq(1)','text'],
        ],
        //获取章节urlList规则
        'chapterUrlListRule' => [
                'link' => ['.L a','href'],
        ],
        //获取内容规则
        'contentReule' => [
            'content' => ['#contents','text'],
            'title'   => ['h1','text'],
        ]

    ],

];