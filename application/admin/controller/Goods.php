<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Goods extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function goods()
    {
        //查询列表页需要的数据
        $goods = \app\admin\model\Goods::select();
        //模板变量赋值
//        $this->assign('list',$goods);
        //渲染模板
        return view('goods',['list'=>$goods]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
        return view();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //获取输入变量
        //$data = request()->param();
        //使用依赖注入的$request对象
        $data = $request->param();

        //参数检测，表单验证
        //1定义验证规则
        $rule = [
            'goods_name' => 'require',
            'goods_price' => 'require|float|gt:0',
            'goods_number' => 'require|integer|gt:0',
        ];
        //定义错误提示信息
        $msg = [
            'goods_name.require' => '商品名称不能为空',
            'goods_price.require' => '商品价格不能为空',
            'goods_price.float' => '商品价格格式不正确',
            'goods_price.gt' => '商品价格必须大于0',
            'goods_number.require' => '商品数量不能为空',
            'goods_number.integer' => '商品数量必须为整数',
            'goods_number.gt' => '商品数量必须大于0',
        ];

        //实例化验证类 Validate
        $validate = new \think\Validate($rule,$msg);
        //执行验证
        if(!$validate->check($data)){
            //验证失败，调用getError方法获取具体的错误提示
            $error = $validate->getError();
            $this->error($error);
        }
        //数据添加到数据表 create方法第二个参数true表示过滤飞数据表中的字段
        \app\admin\model\Goods::create($data,true);
        //页面跳转，商品列表页
        $this->success('添加成功','index');
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(Request $request,$id)
    {
        //接受修改数据
        $data = $request->param();
        //表单验证
        //验证规则
        $rule = [
            'goods_name' => 'require',
            'goods_price' => 'require|float|gt:0',
            'goods_number' => 'require|integer|gt:0'
        ];
        //提示错误信息
        $msg = [
            'goods_name.require' => '商品名称不能为空',
            'goods_price.require' => '商品价格不能为空',
            'goods_price.float' => '商品价格格式不正确',
            'goods_price.gt' => '商品价格必须大于0',
            'goods_number.require' => '商品数量不能为空',
            'goods_number.integer' => '商品数量必须为整数',
            'goods_number.gt' => '商品数量必须大于0',
        ];
        //实例化验证类 Validate
        $validate = new \think\Validate($rule,$msg);
        //执行验证
        if(!$validate->check($data)){
            //验证失败，调用getError方法获取具体的错误提示
            $error = $validate->getError();
            $this->error($error);
        }
//        var_dump($data);die;
        //如果通过验证就更新数据
        \app\admin\model\Goods::update($data,['id'=>$id],true);
        $this->success('修改成功','goods');

    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //查询这条要编辑的原数据
        $data = \app\admin\model\Goods::find($id);

        return view('edit',['info'=>$data]);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete(Request $request,$id)
    {
        //接受id 值
        //静态方法删除
        \app\admin\model\Goods::destroy($id);
        $this->success('删除完成','goods');

    }
}
