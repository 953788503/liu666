<?php
/**
 * 对班级表进行操作
 */
namespace app\admin\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Grade as GradeModel;

class Grade extends Common {

//1,首页
public function index(){

    //1，我们需要将数据库中的班级显示到主页面上
    $data=GradeModel::order('gid desc');
    //1,查看得到的数组
//    dd($model);
    //1,加载主页面看看
    //2,将数组通过with方法传到页面上
    return View::make()->with(compact('data'));
}
//2,,添加页面
public function add(){
    //1,判断是否post提交
    //2,post提交之后说明用户点击了提交按钮
    //3,通过助手函数里面的IS_POST常量的值可以判断出用户是否post提交
    if (IS_POST){
        //1,调用模块system\model\Grade as GradeModel,往数据库中添加数据
        //2,如果条件满足添加成功后会返回一个数组
        $res=(new GradeModel())->add($_POST);
        //1,打印查看一下返回的数组
//        dd($res);
        //1，根据返回的数组判断是否添加成功
        if ($res['code']){
            //1，添加成功后到提示页面，3秒后跳到主页面
            (new Controller())->setRedirect(u('index'))->message($res['msg']);
        }else {
            //2,添加失败后跳到提示页面，3秒后页面返回
            (new Controller())->setRedirect()->message($res['msg']);
        }
    }
    //1,加载编辑页面看看
    return View::make();
}
//3,编辑页面
public function edit(){
    //1，获取get['gid']参数传过来的那个班级的主键
    $gid=$_GET['gid'];

    //1,判断是否post提交
    //2,post提交之后说明用户点击了提交按钮
    //3,通过助手函数里面的IS_POST常量的值可以判断出用户是否post提交
    if (IS_POST){
        //1，调用模块里面的修改方法，将$_post和当前班级的主键当参数传过去
        $res = (new GradeModel())->edit($_POST,$gid);
        //2,根据他返回的参数判断是否更新成功
        if ($res['code']){
            //1，更新成功后到提示页面，3秒后跳到主页面
            (new Controller())->setRedirect(u('index'))->message($res['msg']);
        }else {
            //2,更新失败后跳到提示页面，3秒后页面返回
            (new Controller())->setRedirect()->message($res['msg']);
        }
    }

    //2,获取旧的班级名字用于在修改页面上显示
    //2.1返回一个存有满足条件的数组
    $oldData = GradeModel::find($gid)->toArray();
    //2.2查看返回的数组
//    dd($oldData);
    //3,将数组传到页面上
    //3.1只有传到页面上才能在页面使用该数组
    //1，加载编辑页面看看
    return View::make()->with(compact('oldData'));
}
//4,删除功能
public function del(){
    //获取要删除班级名的主键
    $gid=$_GET['gid'];
    //测试是否获取到
//    dd($gid);
    //1,删除相应的班级名
    //2,调用base类里面的destory方法
    GradeModel::destory($gid);
    //1,跳到提示页面，3秒后返回主页
    (new Controller())->setRedirect(u('index'))->message('删除成功');
}

}





