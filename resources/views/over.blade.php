<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta charset="utf-8">
<title>全本小说 @lang('book.sitename')</title>
<meta name="keywords" content="完结小说,全本小说,全本小说分类列表">
<meta name="description" content="分类中全本小说的列表">
<meta name="MobileOptimized" content="240">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="Cache-Control" content="max-age=0">
<meta http-equiv="Cache-Control" content="no-transform ">
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
<script language="javascript" src="{{ asset('js/style.js') }}"></script>
<body>
	<div class="currency_head">
		<div class="return"><a href="javascript:history.go(-1);">返回</a></div>
		<h1>完本小说</h1>
		<div class="homepage"><a href="/">首页</a></div>
	</div>
	<div class="fullbox">
		@foreach($list as  $item)
		 <div class="full_content"><p class="p1">[{{$item['catName']}}]</p><p class="p2">&nbsp;<a href="/book/desc/{{$item['id']}}.html" class="blue">{{$item['book_name']}}</a></p><p class="p3">{{$item['book_auther']}}</p></div>
		@endforeach
		</div>
	<script>m_bottom();</script><div id="cjjrw7"></div>

				<div class="page">
					@if($total > 0)
						<a href="/oversort/1.html">首页</a>
					@endif
					@if($page -1 > 0)
						<a href="/oversort/{{$page - 1}}.html">上页</a>
					@endif
					@if(($page + 1) <= $total)
						<a href="/oversort/{{$page + 1}}.html">下页</a>
					@endif
					@if($total > 0)
						<a href="/oversort/{{$total}}.html">尾页</a>
					@endif

				</div>
				@if($total > 0)
					<div class="page">输入页数<input id="pageinput" size="4"><input type="button" value="跳转" onclick="page({{$total}})"> <br>(第{{ $page}}/{{$total}}页)当前{{$num}}条/页
					</div>
				@endif
	<div class="footer">
<div class="footer_info">
<span><a href="/">首页</a></span>
	{{--|<span><a href="/mybook.html" rel="nofollow">书架管理</a></span>--}}
	{{--|<span><a href="/history.html" rel="nofollow">阅读记录</a></span>--}}
	|<span><a href="#top" rel="nofollow">↑返回顶部</a>
</span> 
			</div>
		</div>
<script>m_footr();</script> 
<div style="display:none">
</div>
<script>    
function page(num){
    var p = document.getElementById("pageinput").value;
    if(num < p){
        window.open("/wapsort/1_" + num + ".html", "_self");
        return false;
    }
	if(isPositiveNum(p)){window.open("/oversort/"+p+".html","_self");}
	function isPositiveNum(s){ 
    var re = /^[0-9]*[1-9][0-9]*$/ ;  
	    return re.test(s)  
	}
}
</script>

</body></html>