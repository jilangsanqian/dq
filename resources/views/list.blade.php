<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta charset="utf-8">
<title>{{$bookInfo['book_name']}}章节目录列表 {{$bookInfo['book_auther']}}  @lang('book.sitename') </title>
<meta name="keywords" content="{{$bookInfo['book_name']}}章节目录列表 {{$bookInfo['book_auther']}}  @lang('book.sitename')">
<meta name="description" content="{{$bookInfo['book_name']}}章节目录列表 {{$bookInfo['book_auther']}}  @lang('book.sitename')">
<meta name="MobileOptimized" content="240">
<meta name="applicable-device" content="mobile">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="Cache-Control" content="max-age=0">
<meta http-equiv="Cache-Control" content="no-transform ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
<script language="javascript" src="{{ asset('js/style.js') }}"></script>
</head>
<body class="chapterlist">
<div class="currency_head">
    <div class="return"><a href="javascript:history.go(-1);">返回</a></div>
    <h1><a href="/book/desc/{{$bookInfo['id']}}.html">{{$bookInfo['book_name']}}</a></h1>
    <div class="homepage"><a href="/">首页</a></div>
</div>
<div class="paixu">
    <p class="t1"><a href="/book/list/{{$bookInfo['id']}}/1.html">{{$bookInfo['book_name']}}章节列表</a></p>
    <p class="t2">
        <span><a href="/book/list/{{$bookInfo['id']}}/1.html" @if(!$order)  class="this" @endif  >正序</a>
            <a href="/book/list/{{$bookInfo['id']}}/desc/1.html" @if($order)  class="this" @endif >倒序</a>
        </span>
    </p>
</div>
<ul class="chapters">
    @foreach($list as $item)
        <li><a href="/book/{{$item['book_id']}}/{{$item['chapter_id']}}.html">{{$item['chapter_name']}}<span></span></a></li>
    @endforeach
</ul>
<script>m_bottom();</script><div id="ctz8dk"></div>

    <div class="page">
        @if($total > 0)
            <a href="/book/list/{{$bookInfo['id']}}{{$order}}/1.html">首页</a>
        @endif
        @if($page -1 > 0)
            <a href="/book/list/{{$bookInfo['id']}}{{$order}}/{{$page - 1}}.html">上页</a>
        @endif
        @if(($page + 1) <= $total)
            <a href="/book/list/{{$bookInfo['id']}}{{$order}}/{{$page + 1}}.html">下页</a>
        @endif

        @if($total > 0)
            <a href="/book/list/{{$bookInfo['id']}}{{$order}}/{{$total}}.html">尾页</a></div>
        @endif
        </div>
    @if($total > 0)
        <div class="page">输入页数<input id="pageinput" size="4"><input type="button" value="跳转" onclick="page()"> <br>(第{{ $page}}/{{$total}}页)当前{{$num}}条/页
        </div>
    @endif

<div class="footer">
<div class="footer_info">
<span><a href="/">首页</a></span>
    {{--|<span><a href="/mybook.html" rel="nofollow">书架管理</a></span>--}}
    {{--|<span><a href="/history.html" rel="nofollow">阅读记录</a></span>--}}
    |<span><a href="#top" rel="nofollow">回到顶部</a>
</span>
			</div>
		</div>
<script>m_footr();</script>
<div style="display:none">
</div>
<script>
function page(){
    var url = "/book/list/{{$bookInfo['id']}}{{$order}}/";
    var page = "{{$page}}";
	var p = document.getElementById("pageinput").value;
    var t = "{{$total}}";
    var c = p + page;
    if(c > t){
        c = t;
    }
	if(isPositiveNum(p)){window.open(url + c + '.html',"_self");}	function isPositiveNum(s){
    var re = /^[0-9]*[1-9][0-9]*$/ ;
	    return re.test(s)
	}
}
</script>

</body></html>
