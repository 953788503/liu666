<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11 0011
 * Time: 下午 3:44
 */

namespace app\admin\controller;

use houdunwang\core\Controller;
//1,用来判断是否登录成功
//2,每到一个界面都需要判断它是不是登录成功后才走到这个界面的，如果是非法访问要是它返回到登陆界面
//3,除了登陆界面其他几个界面都要集成这个类
class Common extends Controller{

    public function __construct()
    {
        //1,if判断是否登录成功，如果没有返回到登录界面
        if (!isset($_SESSION['admin_id'])){
            //跳转到登陆界面
            header('location:?s=admin/login/index');
            exit();
        }
//        else{
            //1,如果有的话说明在登录状态
//            header('location:?s=admin/entry/index');
//            exit();
//        }
    }

}