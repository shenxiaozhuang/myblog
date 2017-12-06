@extends('layouts.home')

@section('content')
    <style type="text/css">
        body{
            font-family: "Helvetica Neue", Helvetica, Arial, "Hiragino Sans GB", "Hiragino Sans GB W3", "WenQuanYi Micro Hei", "Microsoft YaHei UI", "Microsoft YaHei", sans-serif;
            font-size: 15px;
            line-height: 2.0;
            color: #333;
        }
        #main{
            padding-bottom: 150px;
            display: block;
            margin-top: 50px;
            min-height: 300px;
        }
        .main-inner{
            width: 860px;
            margin:0 auto;
        }
        .posts-collapse {
            margin-left: 0;
        }
        .category-all-title{
            text-align: center;
        }
        .category-all{
            margin-top: 20px;
        }
        .category-all-page .category-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .category-all-page .category-list-item {
            display: inline-block;
            margin: 10px;
        }
        ul li {
            list-style: disc;
        }
        a {
            border-bottom-color: #ccc;
            word-wrap: break-word;
            color: #555;
            text-decoration: none;
            border-bottom-color: rgb(153, 153, 153);
        }

    </style>
    <main id="main" class="main">
        <div class="main-inner">
            <div id="content" class="content">
                <div id="posts" class="posts-collapse">
                    <div class="category-all-page">
                        <div class="category-all-title">
                        </div>
                        <div class="category-all">
                            <ul class="category-list">
                                <li class="category-list-item">
                                    @foreach($categorys as $c)
                                    <a class="category-list-link" href="{{url('cate/'.$c->cate_id)}}">{{$c->cate_name}}</a>
                                    <span class="category-list-count">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


