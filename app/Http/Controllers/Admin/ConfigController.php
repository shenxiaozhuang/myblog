<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    //get.admin/config  全部配置项列表
    public function index()
    {
        $data = Config::orderBy('conf_order','asc')->get();
        foreach ($data as $k=>$v)
        {
            switch ($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text" class="lg" name="conf_content[]" >'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    //1|开启,0|关闭
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    foreach($arr as $m=>$n){
                        //1|开启
                        $r = explode('|',$n);
                        $c = $v->conf_content==$r[0]?' checked ':'';
                        $str .= '<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }
        return view('admin.config.index', compact('data'));
    }

    //改变配置内容
    public function changeContent()
    {
        $input = Input::all();
        foreach ($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }

        $this->putFile();
        return back()->withErrors('更新配置内容成功');
    }

    //获取配置项
    public function putFile()
    {
        $confg = Config::pluck('conf_content', 'conf_name')->all();
        $str = '<?php return ';
        $str .= var_export($confg, true).';';
        $path = base_path().'/config/web.php';
        file_put_contents($path, $str);
    }


    //配置项排序
    public function changeOrder()
    {
        $input = Input::all();
        $conf = Config::find($input['conf_id']);
        $conf->conf_order = $input['conf_order'];
        $re = $conf->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '配置项排序更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置项排序更新失败，请稍后重试！',
            ];
        }
        return $data;
    }

    //get.admin/config/create   添加分类
    public function create()
    {
        return view('admin.config.add');
    }

    //post.admin/config  添加分类提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'conf_title'=>'required',
            'conf_name'=>'required',
            'field_type'=>'required',
        ];

        $message = [
            'conf_name.required'=>'配置项名称不能为空！',
            'conf_title.required'=>'配置项标题不能为空！',
            'field_type.required'=>'配置项类型不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $re = Config::create($input);
            if($re){
                return redirect('admin/config');
            }else{
                return back()->withErrors('数据填充失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //get.admin/config/{conf_id}/edit  编辑配置项
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);

        return view('admin.config.edit',compact('field'));
    }

    //put.admin/config/{conf_id}    更新配置项
    public function update($conf_id)
    {
        $input = Input::except('_token','_method');
        $re = Config::where('conf_id',$conf_id)->update($input);
        if($re){
            $this->putFile();
            return redirect('admin/config');
        }else{
            return back()->withErrors('分类信息更新失败，请稍后重试！');
        }
    }

    //get.admin/config/{conf_id}  显示单个分类信息
    public function show()
    {

    }

    //delete.admin/config/{conf_id}   删除单个分类
    public function destroy($conf_id)
    {
        $re = Config::where('conf_id',$conf_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '配置项删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置项删除失败，请稍后重试！',
            ];
        }
        $this->putFile();
        return $data;
    }
}
