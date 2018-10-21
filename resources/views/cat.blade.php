<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>{{$catName}}小说 @lang('book.sitename')</title>
    <meta name="keywords" content="{{$catName}}小说,{{$catName}}小说推荐,热门{{$catName}}小说,{{$catName}}小说分类列表">
    <meta name="description" content="@lang('book.sitename')分类中{{$catName}}小说的列表">
    <meta name="MobileOptimized" content="240">
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
        <h1>{{$catName}}小说</h1>
        <div class="homepage"><a href="/">首页</a></div>
    </div>
    <div class="branch_menu">

        <div class="menu_nav">
            <ul>
                <li @if($catid == 1)  class="this" @endif ><a href="/wapsort/1_1.html">玄幻小说</a></li>
                <li @if($catid == 2)  class="this" @endif ><a href="/wapsort/2_1.html">修真小说</a></li>
                <li @if($catid == 3)  class="this" @endif ><a href="/wapsort/3_1.html">都市小说</a></li>
                <li @if($catid == 4)  class="this" @endif><a href="/wapsort/4_1.html">历史小说</a></li>
                <li @if($catid == 5)  class="this" @endif ><a href="/wapsort/5_1.html">网游小说</a></li>
                <li @if($catid == 6)  class="this" @endif><a href="/wapsort/6_1.html">科幻小说</a></li>
                <li @if($catid == 7)  class="this" @endif><a href="/wapsort/7_1.html">恐怖小说</a></li>
                <li @if($catid == 8)  class="this" @endif><a href="/wapsort/8_1.html">其他小说</a></li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="ranking_general">
            @foreach($list as $item)
            <div class="articlegeneral">
                <p class="p1">《<a href="/book/desc/{{$item['id']}}.html" class="blue">{{$item['book_name']}}</a>》
                </p>
                <p class="p3">{{$item['book_auther']}}</p>
            </div>
            @endforeach

        </div>
        <script>m_bottom();</script>

</div>

<div>
    <div class="page">


            @if($total > 0)
                <a href="/wapsort/{{$catid}}_1.html">首页</a>
            @endif
            @if($page -1 > 0)
                <a href="/wapsort/{{$catid}}_{{$page -1 }}.html">上页</a>
            @endif
            @if(($page + 1) <= $total)
                <a href="/wapsort/{{$catid}}_{{$page + 1}}.html">下页</a>
            @endif

            @if($total > 0)
                 <a href="/wapsort/{{$catid}}_{{$total}}.html">尾页</a></div>
            @endif
            @if($total > 0)
                <div class="page">输入页数<input id="pageinput" size="4"><input type="button" value="跳转" onclick="page({{$total}})"> <br>(第{{ $page}}/{{$total}}页)当前{{$num}}条/页
                </div>
            @endif

</div>
</div>
<div class="footer">
    <div class="footer_info">
        <span><a href="/">返回首页</a></span>
            {{--|<span><a href="/mybook.html" rel="nofollow">书架管理</a></span>--}}
        {{--|<span><a href="/history.html" rel="nofollow">阅读记录</a></span>--}}
        |<span><a href="/wapsort/{{$catid}}_{{$page}}.html#top" rel="nofollow">↑返回顶部</a>
</span>
    </div>
</div>
<script>m_footr();</script>
<div style="display:none">
</div>
</div>
<style>#c0hue div {
        display: inline-block;
        padding-left: 8.72093023255814px;
    }

    #c0hue div img {
        width: 174.4186046511628px
    }</style>
<style>#c0hue div {
        display: inline-block;
        padding-left: 8.72093023255814px;
    }

    #c0hue div img {
        width: 174.4186046511628px
    }</style>
<script>
    function page(num) {
        var p = document.getElementById("pageinput").value;
        if(num < p){
            window.open("/wapsort/1_" + num + ".html", "_self");
            return false;
        }
        if (isPositiveNum(p)) {
            window.open("/wapsort/1_" + p + ".html", "_self");
        }

        function isPositiveNum(s) {
            var re = /^[0-9]*[1-9][0-9]*$/;
            return re.test(s)
        }
    }
</script>


<style>#i636 {
        line-height: 0;
        position: fixed !important;
        z-index: 2147483647 !important;
        width: 100% !important;
        left: 1px !important;
        clear: both;
        text-indent: 0;
    }

    #i636i {
        display: block;
        position: relative;
        left: 0;
        bottom: 0;
        width: 100%;
        height: auto;
    }

    #i636a {
        display: block;
        position: absolute;
        bottom: 0;
        height: auto;
        left: 0;
        z-index: 999;
        width: 100%;
    }

    #i636e {
        display: block;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: auto;
        z-index: 999;
        -webkit-tap-highlight-color: transparent;
    }

    #i636c {
        display: block;
        position: absolute;
        bottom: 0;
        right: 0;
        margin-bottom: 0px;
        z-index: 999
    }

    #i636c img {
        width: auto;
        display: block;
        height: 20px;
    }

    #i636p {
        display: block;
        width: 100%;
        height: 87.890625px;
    }</style>
</body>
</html>