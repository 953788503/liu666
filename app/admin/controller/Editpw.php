<?php
/**
 * 修改密码
 */
namespace app\admin\controller;

use houdunwang\view\View;
use houdunwang\core\Controller;
use system\model\Admin;

class Editpw extends Common{

    public function index(){
        //测试是否能从这里访问到数据库
//        $res=Admin::where('id=1')->getAll();
//        dd($res);
        //1,判断用户是否Post提交
        //2,如果提交了说明用户提交了修改后的密码
        if (IS_POST){
            //测试输出查看能否判断用户提交
//            dd($_POST);
            //1,判断用户的旧密码不能为空
            //2,如果为空不让他注册
            if (!trim($_POST['oldpw'])){
                //弹出旧密码不能为空，页面返回
                (new Controller())->setRedirect()->message('旧密码不能为空');
                //下面代码不再执行
                return false;
            }
            //1,判断用户的新密码是否为空
            //2,如果为空不让他注册
            if (!trim($_POST['newpw'])){
                //弹出旧密码不能为空，页面返回
                (new Controller())->setRedirect()->message('新密码不能为空');
                //下面代码不再执行
                return false;
            }
            //1,判断用户重新输入的新密码是否为空
            //2,如果为空不让他注册
            if (!trim($_POST['newspw'])){
                //弹出旧密码不能为空，页面返回
                (new Controller())->setRedirect()->message('重写新密码不能为空');
                //下面代码不再执行
                return false;
            }
            //调用Admin里面的editpw方法，判断旧密码是否正确
            $res = (new Admin())->editpw($_POST);
            //1,判断旧密码输入的是否正确
            //2,如果不对不让他注册成功，防止不是本人操作
            //3,判断两次输入的新密码是否一样
            if ($res['code']){
                (new Controller())->setRedirect(u('entry.index'))->message($res['msg']);
            }else{
                (new Controller())->setRedirect()->message($res['msg']);
            }
        }

        //1,加载修改界面
        return View::make();
    }
}

