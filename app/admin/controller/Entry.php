<?php
/**
 * 登陆管理的主界面
 */
//1,必须有命名空间不然找不到这个类
namespace app\admin\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
//1,需要继承Common类判断是不是登陆成功后才进到这个界面的，如果是非法访问使他返回到登录界面
class Entry extends Common {
    public function index(){
        //加载登陆管理的主界面
        return View::make();

    }
    //当点击退出是退出账户
    public function tui(){
        //1,释放用户的Session所有的资源
        session_unset();
        session_destroy();
        //弹出退出成功，页面返回
        (new Controller())->setRedirect()->message('退出成功');
    }
}