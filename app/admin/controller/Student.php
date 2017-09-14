<?php
/**
 * 学生管理类
 */
namespace app\admin\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Student as StudentModel;

class Student extends Common {
    //学生管理的主界面
    public function index(){
        //1，获得学生表的全部数据
        //2,因为要将所有的学生信息输入到页面中，就需要获得到含有学生所有信息的数组
        $data=StudentModel::query("select * from student s join grade g on s.gid=g.gid join material m on s.mid=m.mid");
//        dd($data);
        //1，加载学生管理主页面
        return View::make()->with(compact('data'));
    }

    //学生管理的添加页面
    public function add(){
        //1,判断是否post提交
        //2,如果提交说明用户点击了提交按钮提交了数据
        if (IS_POST){

            //1，调用Student模版，通过它与数据库交互
            //2,调用add方法将数据添加到数据库中,返回一个可以判断是否添加成功的数组
            $res=(new StudentModel())->add($_POST);
            if ($res['code']){
                (new Controller())->setRedirect(u('index'))->message($res['msg']);
            }else{
                (new Controller())->setRedirect()->message($res['msg']);
            }
        }

        //1,获取所有头像的数据
        $materialData=$this->getMaterialData();
        //2,获取所有班级数据
        $gradeData=$this->getGradeData();
        if (array_key_exists('mid',$materialData)){
//            dd(1);
            //1,为了方便在页面上可以正常foreach循环，我们将他转为一个二维数组
            //2,这样在传递到页面上时，也会是一个二维数组
            $materialData=compact('materialData');

        }
        //1，加载学生管理添加页面
        return View::make()->with(compact('materialData','gradeData'));
    }

    //学生管理的修改页面
    public function edit(){
        //1,获取get参数，代表的是要修改的那个学生数据的主键
        //2,根据主键修改学生表的信息
        $sid=$_GET['sid'];
        //1,判断是否post提交
        //2,如果提交说明用户点击了提交按钮提交了数据
        if (IS_POST){
            //1，调用Student模版，通过它与数据库交互
            //2,调用add方法将数据添加到数据库中,返回一个可以判断是否添加成功的数组
            $res=(new StudentModel())->edit($_POST,$sid);
            if ($res['code']){
                (new Controller())->setRedirect(u('index'))->message($res['msg']);
            }else{
                (new Controller())->setRedirect()->message($res['msg']);
            }
        }

        //1,获取所有头像的数据
        $materialData=$this->getMaterialData();
        //2,获取所有班级数据
        $gradeData=$this->getGradeData();
        if (array_key_exists('mid',$materialData)){
//            dd(1);
            //1,为了方便在页面上可以正常foreach循环，我们将他转为一个二维数组
            //2,这样在传递到页面上时，也会是一个二维数组
            $materialData=compact('materialData');

        }
        //1，获取当前这个主键的学生的信息
        $oldData = StudentModel::find($sid)->toArray();
        //1，加载学生管理修改页面
        return View::make()->with(compact('materialData','gradeData','oldData'));
    }

    //学生管理的删除
    public function del(){
        //1,测试是否能调用这个方法
        //dd($_GET['sid']);
        //1,获得要删除数据的主键值
        $sid=$_GET['sid'];
        //1,调用base里面的方法删除数据
        //2,根据主键值删除数据表里面的数据
        StudentModel::destory($sid);
        //1,跳转到提示页面，提示删除成功
        //2,3秒后跳到主界面
        (new Controller())->setRedirect(u('index'))->message('删除成功');
    }

    //1,获取图像素材
    private function getMaterialData(){
        //1，获得图像素材的全部数据
        //2,因为是在同一个空间下可以直接静态调用Material::getAll()
        $data=\system\model\Material::getAll();
        return $data;
    }
    //1,获取所有的班级名称
    private function getGradeData(){
        //1,获得所有的班级名称
        //2,因为是在同一个空间下可以直接静态调用Material::getAll()
        $data=\system\model\Grade::getAll();
        return $data;
    }

}







