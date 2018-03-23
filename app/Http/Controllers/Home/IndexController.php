<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Link;

class IndexController extends CommonController
{
    //博客首页
    public function index()
    {
        //点击量最高的6篇文章(站长推荐)
        $hot = Article::orderBy('art_view', 'desc')->take(6)->get();
        //图文列表（带分页）
        $data = Article::orderBy('art_time', 'desc')->paginate(5);
        //友情链接
        $links = Link::all();

        return view('home.index' ,compact('hot', 'data', 'links'));
    }

    //全部栏目分类
    public function category()
    {
        $categorys = (new Category())->tree();
        return view('home.category' ,compact('categorys'));
    }

    //栏目页面
    public function cate($cate_id)
    {
        $field = Category::find($cate_id);
        //查看次数自增
        Category::where('cate_id',$cate_id)->increment('cate_view',1);
        //当前分类的子分类
        $submenu = Category::where('cate_pid',$cate_id)->get();
        //图文列表（带分页）
        $art = Article::where('cate_id', $cate_id)->orderBy('art_time','desc')->paginate(5);

        return view('home.list', compact('field', 'art', 'submenu'));
    }

    //文章页面
    public function article($art_id)
    {
        $article['content'] = Article::Join('category', 'article.cate_id', '=', 'category.cate_id')
                 ->where('art_id',$art_id)->first();

        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view',1);

        //上一篇 下一篇
        $article['pre']  = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();

        //相关文章
        $data = Article::where('cate_id',$article['content']->cate_id)->orderBy('art_time','desc')->get();

        return view('home.new', compact('article', 'data'));
    }


}
