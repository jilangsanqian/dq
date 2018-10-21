<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>{{$bookInfo['book_name']}}_最新章节_{{$bookInfo['book_auther']}}_ @lang('book.sitename')</title>
<meta name="keywords" content="{{$bookInfo['book_name']}},{{$bookInfo['book_name']}}最新章节,{{$bookInfo['book_auther']}}">
<meta name="description" content="{{$bookInfo['book_name']}}最新章节由网友提供！！{{$bookInfo['book_desc']}}">
<meta name="MobileOptimized" content="240">
<meta name="applicable-device" content="mobile">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="Cache-Control" content="max-age=0">
<meta http-equiv="Cache-Control" content="no-transform ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
<script language="javascript" src="{{ asset('js/style.js') }}"></script>
</head>
<body>
<div class="main">
<div class="currency_head">
    <div class="return"><a href="javascript:history.go(-1);">返回</a></div>
	<h1>{{$bookInfo['book_name']}}</h1>
	<div class="homepage"><a href="/">首页</a></div>
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
                <input id="txt1" type="text" name="s">
                <input id="txt2" type="submit" value="点击搜索">
                <input type="hidden" name="type" value="articlename">
            </div>
        </form>
        <div class="rightpic"></div>
    </div>
</div>
	<div class="infohead">
		<div class="pic"><img src="{{ asset($bookInfo['book_img'])}}" width="90" height="120" alt="{{$bookInfo['book_name']}}" ></div>
		<div class="cataloginfo">
			<h3>{{$bookInfo['book_name']}}</h3>
			<div class="leftpic"></div>
			<div class="rightpic"></div>
			<div class="infotype">
				<p>作者：{{$bookInfo['book_auther']}}</p>
				<p>类型：{{$catName}}</p>
				<p>更新时间：{{$bookInfo['update_time']}}</p>
				<p>最新章节：<a style="color:red;" href="/book/{{$bookInfo['id']}}/{{$bookInfo['chapter_id']}}.html">{{$bookInfo['new_chapter']}}</a></p>
			</div>
		</div>
		<ul class="infolink">
            @if($first)
                <li><p><a href="/book/{{$first['book_id']}}/{{$first['chapter_id']}}.html" target="_blank">从头阅读</a></p></li>
                <li><p><a href="/book/list/{{$first['book_id']}}/1.html" target="_blank">章节目录</a></p></li>
                {{--<li><p><a href="">推荐本书</a></p></li>--}}
                {{--<li><p><a href="l">加入书架</a></p></li>--}}
            @endif
			<div class="clear"></div>
		</ul>
		<div class="intro">
			<span>本书简介：</span>
			<p>{{$bookInfo['book_desc']}}</p>
		</div>
	</div>
    <div class="info_menu1">
        <h3>最新十章节</h3>
        <div class="conterpic"></div>
        <div class="rightpic"></div>
        <div class="list_xm">
            <ul>
                @foreach($list as $item)
                    <li>
                        <a href="/book/{{$item['book_id']}}/{{$item['chapter_id']}}.html">
                             {{$item['chapter_name']}}
                        </a>
                    </li>
                @endforeach
            </ul>
      <p class="gochapter"><a style="color:red;" href="/book/list/{{$bookInfo['id']}}/1.html" target="_blank">查看全部章节...</a></p>
        </div>
    </div>
</div>
<script>uc_foot();</script>
<div class="footer">
<div class="footer_info">
<span><a href="/">返回首页</a></span>
    {{--|<span><a href="/mybook.html" rel="nofollow">书架管理</a></span>--}}
    {{--|<span><a href="/history.html" rel="nofollow">阅读记录</a></span>--}}
    |<span><a href="/book/desc/{{$bookInfo['id']}}.html#top" rel="nofollow">↑返回顶部</a></span>
			</div>
		</div>
<div style="display:none">

</div>


</body></html>