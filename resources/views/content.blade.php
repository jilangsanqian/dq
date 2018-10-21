<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>{{$chapter_name}} @lang('book.sitename')</title>
<meta name="keywords" content="{{$chapter_name}}">
<meta name="description" content="{{$chapter_name}}">
<meta name="MobileOptimized" content="240">
<meta name="applicable-device" content="mobile">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="Cache-Control" content="max-age=0">
<meta http-equiv="Cache-Control" content="no-transform ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
<script language="javascript" src="{{ asset('js/style.js') }}"></script>
</head>
<body>
<div id="novelbody" class="main">
	<div class="content_top">
		<ul>
			<li><a href="/">首页</a></li>
			@if($prechapter)
            	<li><a href="/book/{{$prechapter['book_id']}}/{{$prechapter['chapter_id']}}.html">上一章</a></li>
			@endif
			<li><a href="/book/list/{{$book_id}}/1.html">返回目录</a></li>
			@if($nextchapter)
            	<li><a href="/book/{{$nextchapter['book_id']}}/{{$nextchapter['chapter_id']}}.html">下一章</a></li>
			@endif
			<div class="clear"></div>
		</ul>
	</div>
	<div class="content_title">
		<h1 id="chaptertitle">{{$chapter_name}}</h1>
		<div class="chaptertilebg"></div>
		<div class="content_button">
			<div class="button_left">
				<p ><a id="huyandiv"  onclick="nr_setbg('huyan')">护眼</a></p>
				<p><a id="lightdiv" onclick="nr_setbg('light')">关灯</a></p>
				<div class="clear"></div>
			</div>
			<div class="button_right">
				<p><a id="fontbig" onclick="nr_setbg('big')">大</a></p>
				<p><a id="fontmiddle" onclick="nr_setbg('middle')">中</a></p>
				<p><a id="fontsmall" onclick="nr_setbg('small')">小</a></p>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="content_novel">
		<div id="novelcontent" class="novelcontent">
			<p>&nbsp;&nbsp;
				{{$content}}
			</p>

    <ul class="novelbutton">
       <div style="margin:3px;"><script>m_middle();</script>
</div>
		@if($prechapter)
			<li><p class="p2"> <a href="/book/{{$prechapter['book_id']}}/{{$prechapter['chapter_id']}}.html">上一章</a></p></li>
		@endif

		<li><p class="p2"> <a href="/book/list/{{$book_id}}/1.html">返回目录</a></p></li>

		{{--<li><p class="p2"><a href="">加入书签</a></p></li>--}}
		@if($nextchapter)
			<li><p class="p1 p3"><a href="/book/{{$nextchapter['book_id']}}/{{$nextchapter['chapter_id']}}.html">下一章</a></p></li>
		@endif

    	<div class="clear"></div>
      <div style="margin:3px;"><script>m_bottom();</script>
</div>
    </ul>
    </div>
</div>
<div class="footer">
<div class="footer_info">
<span><a href="/">返回首页</a></span>
	{{--|<span><a href="/mybook.html" rel="nofollow">书架管理</a></span>--}}
	{{--|<span><a href="/history.html" rel="nofollow">阅读记录</a></span>--}}
	|<span><a href="/book/{{$book_id}}/{{$chapter_id}}.html#top" rel="nofollow">↑返回顶部</a>
</span> 
			</div>
		</div>
<script>m_footr();</script> 
<div style="display:none">
</div>
</div><style>#cauvf div{display:inline-block;padding-left:8.348837209302326px;}#cauvf div img{width:166.97674418604652px}</style><style>#cauvf div{display:inline-block;padding-left:8.348837209302326px;}#cauvf div img{width:166.97674418604652px}</style><style>#ctbcfh div{display:inline-block;padding-left:8.348837209302326px;}#ctbcfh div img{width:166.97674418604652px}</style><style>#ctbcfh div{display:inline-block;padding-left:8.348837209302326px;}#ctbcfh div img{width:166.97674418604652px}</style>
<script src="{{ asset('js/yuedu.js') }}"></script>
<script type="text/javascript">
    var lastread=new LastRead();lastread.set('17762', '9459729', '垂钓诸天', '第一百一十四章 笼罩世界');
    getset();
</script>

<style>#i088{line-height:0;position:fixed!important;z-index:2147483647!important;width:100%!important;left:1px!important;clear:both;text-indent:0;}#i088i{display:block;position:relative;left:0;bottom:0;width:100%;height:auto;}#i088a{display:block;position:absolute;bottom:0;height:auto;left:0;z-index:999;width:100%;}#i088e{display:block;position:absolute;left:0;top:0;width:100%;height:auto;z-index:999;-webkit-tap-highlight-color:transparent;}#i088c{display:block;position:absolute;bottom:0;right:0;margin-bottom:0px;z-index:999}#i088c img{width:auto;display:block;height:20px;}#i088p{display:block;width:100%;height:87.890625px;}</style></body></html>