<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Link;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    //get.admin/links  全部友情链接列表
    public function index()
    {
        $data = Link::orderBy('link_order','asc')->get();
        return view('admin.links.index', compact('data'));
    }

    //友情链接排序
    public function changeOrder()
    {
        $input = Input::all();
        $link = Link::find($input['link_id']);
        $link->link_order = $input['link_order'];
        $re = $link->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '友情链接排序更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接排序更新失败，请稍后重试！',
            ];
        }
        return $data;
    }

    //get.admin/links/create   添加分类
    public function create()
    {
        return view('admin.links.add');
    }

    //post.admin/links  添加分类提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'link_name'=>'required',
            'link_url'=>'required',
        ];

        $message = [
            'link_name.required'=>'友情链接名称不能为空！',
            'link_url.required'=>'友情链接url不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $re = Link::create($input);
            if($re){
                return redirect('admin/links');
            }else{
                return back()->withErrors('数据填充失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/links/{link_id}/edit  编辑友情链接
    public function edit($link_id)
    {
        $field = Link::find($link_id);

        return view('admin.links.edit',compact('field'));
    }

    //put.admin/links/{link_id}    更新友情链接
    public function update($link_id)
    {
        $input = Input::except('_token','_method');
        $re = Link::where('link_id',$link_id)->update($input);
        if($re){
            return redirect('admin/links');
        }else{
            return back()->withErrors('分类信息更新失败，请稍后重试！');
        }
    }

    //get.admin/links/{link_id}  显示单个分类信息
    public function show()
    {

    }

    //delete.admin/links/{link_id}   删除单个分类
    public function destroy($link_id)
    {
        $re = Link::where('link_id',$link_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '友情链接删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
}
