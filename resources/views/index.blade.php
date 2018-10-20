<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>@lang('book.sitename')_网络小说阅读网</title>
    <meta name="keywords" content="@lang('book.keywords')">
    <meta name="description" content="@lang('book.description')">
    <meta name="MobileOptimized" content="240">
    <meta name="applicable-device" content="mobile">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="Cache-Control" content="max-age=300">
    <meta http-equiv="Cache-Control" content="no-transform">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <script language="javascript" src="{{ asset('js/style.js') }}"></script>
</head>
<body>
<div class="main">
    <div class="head">
        <h1 class="logo"><a href="/">@lang('book.sitename')</a></h1>
        <div class="loginbar">
            {{--<p class="signin"><i></i>--}}
                {{--<script>user()</script>--}}
                {{--<a href="/login">登录</a></p>--}}
            {{--<p class="bookshelf"><i></i><a href="/book/bookcase" rel="nofollow">书架</a></p>--}}
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
                    <input id="txt1" type="text" name="s">
                    <input id="txt2" type="submit" value="点击搜索">
                    <input type="hidden" name="type" value="articlename">
                </div>
            </form>
            <div class="rightpic"></div>
        </div>
    </div>
    <div class="sub_menu1">
        <h3><a href="#">本站推荐</a></h3>
        <div class="conterpic"></div>
        <div class="rightpic"></div>
        <div class="list">
            <ul>
                @foreach ($banner as $item)
                    <li>
                        <p class="p1">
                            <a href="/book/desc/{{$item['id']}}.html">
                                <img src="{{ asset($item['book_img']) }}" width="72" height="95">
                            </a>
                        </p>
                        <p class="p2"><a href="/book/desc/{{$item['id']}}.html">{{$item['book_name']}}</a></p>
                        <p class="p3">{{$item['book_auther']}}</p>
                    </li>
                @endforeach
                <div class="clear"></div>
            </ul>
        </div>
    </div>

    <div class="sub_menu2">
        <h3><a href="#">阅 读 排 行</a></h3>
        <div class="conterpic"></div>
        <div class="rightpic"></div>
        <div class="article">

            <div class="pic"><a href="/book/desc/{{$index['id']}}.html"><img
                            src="{{ asset($index['book_img']) }}" width="75" height="100"
                    ></a></div>
            <div class="content">
                <h6><a href="/book/desc/{{$index['id']}}.html">{{$index['book_name']}}</a></h6>
                <p class="author">{{$index['book_auther']}}</p>
                <p class="simple">
                    {{$index['book_desc']}}
                </p>
            </div>

            <div class="list">
                <ul>
                    @foreach ($rankList as $item)
                        <li><span class="s1">[{{$item['typeName']}}]</span><span class="s2"><a
                                        href="/book/desc/{{$item['id']}}.html">{{$item['book_name']}}</a></span>|<span class="s3">{{$item['book_auther']}}</span>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
    <div class="sub_menu3">
        <h3><a href="#">最 近 更 新</a></h3>
        <div class="conterpic"></div>
        <div class="rightpic"></div>
        <div class="list_xm">
            <ul>
                @foreach ($updateRank as $item)
                    <li>
                        <span class="s1">[{{$item['typeName']}}]</span><span class="s2">
                            <a href="/book/desc/{{$item['id']}}.html">{{$item['book_name']}}</a>
                        </span>
                        / <span class="s3">{{$item['book_auther']}}</span>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
    <div class="footer">
        <div class="footer_info">
            <span><a href="/">返回首页</a></span>
            {{--|<span><a href="/mybook.html" rel="nofollow">书架管理</a></span>--}}
            {{--|<span><a href="/history.html" rel="nofollow">阅读记录</a></span>--}}
            |<span><a href="/#top" rel="nofollow">↑返回顶部</a>
            </span>
        </div>
    </div>
    <div style="display:none">

    </div>

</div>


</body>
</html>