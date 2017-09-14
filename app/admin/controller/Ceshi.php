<?php
/**
 * 用来测试页面加载
 */

namespace app\admin\controller;

use houdunwang\view\View;

class Ceshi{

    public function index(){
        //测试普通方法里面调用静态方法
//        return self::add();die();
//          return  $this->add();die();
        //1,需要return，不然不能加载页面
        //2,因为他需要返回一个对象
        return View::make();
//        return (new View())->make();
    }
}



