<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        //自定义导航
        $navs = Navs::orderBy('nav_order','asc')->get();
        //最新发布的8篇文章
        $new = Article::orderBy('art_time', 'desc')->take(8)->get();
        //点击量最高的5篇文章
        $pics = Article::orderBy('art_view', 'desc')->take(5)->get();

        View::share('navs', $navs);
        View::share('new', $new);
        View::share('pics', $pics);
    }
}
