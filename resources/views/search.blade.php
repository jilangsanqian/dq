<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta charset="utf-8">
<title>搜索"{{$keywords}}"结果- @lang('book.sitename')</title>
<meta name="MobileOptimized" content="240">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="Cache-Control" content="max-age=300">
<meta http-equiv="Cache-Control" content="no-transform ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
<script language="javascript" src="{{ asset('js/style.js') }}"></script>

</head>
<body>
<div class="main">
    <div class="head">
    <h1 class="logo"><a href="/">@lang('book.sitename')</a></h1>
    <div class="loginbar">
        {{--<p class="signin"><i></i><script>user()</script><script src=""></script><a href=""></a></p>--}}
        {{--<p class="bookshelf"><i></i><a href="" rel="nofollow">���</a></p>--}}
        <div class="clear"></div>
    </div>
</div>
<div class="nav">
        <ul>
            <li><a href="/">首页</a></li>
            <li><a href="/wapsort/1_1.html">分类</a></li>
            {{--<li><a href="/rank.html">排行</a></li>--}}
            <li><a href="/oversort/1.html">完本</a></li>
            {{--<li><a href="/history.html" rel="nofollow">足迹</a></li>--}}
            <div class="clear"></div>
        </ul>
</div>
<div class="main1">
    <div class="searchbox">
        <div class="leftpic"></div>
        <form action="/search" method="post">
            <div class="txt">
                {{ csrf_field() }}
                <input id="txt1" name="s" type="text">
                <input id="txt2" value="{{$keywords}}" type="submit">
                <input name="type" value="articlename" type="hidden">
            </div>
        </form>
        <div class="rightpic"></div>
    </div>
</div>
    <div class="searchresult">
        <div class="p1">搜索“{{$keywords}}”找到的小说</div>
            @foreach($search as $item)
                <p class="sone">
                    <a href="/book/desc/{{$item['id']}}.html" target="_blank">{{$item['book_name']}}</a>/
                    <span class="author"><a href="/book/desc/{{$item['id']}}.html" target="_blank">{{$item['book_auther']}}</a></span>
                </p>
            @endforeach
    </div>
</div>
<div class="footer">
<div class="footer_info">
<span><a href="/">首页</a></span>
    {{--|<span><a href="http://m.biquge.com.tw/mybook.php" rel="nofollow">��ܹ���</a></span>--}}
    {{--|<span><a href="http://m.biquge.com.tw/history.html" rel="nofollow">�Ķ���¼</a></span>--}}
    |<span><a href="#top" rel="nofollow">↑返回顶部</a>
</span> 
			</div>
		</div>
<div style="display:none">

</div>


 
</body></html>
