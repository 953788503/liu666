<?php
/**
 *视图层
 */

namespace houdunwang\view;

class Base{

    //存放数据
    protected $data = [];

    //存放模版路径
    protected $file;

    //分配变量
    public function with($var){
        //1，测试是否访问到这里
        //dd($var);
        //1，将从Entry这个类里面传过来的参数赋值给data属性
        //2，因为测试至传过来存有一个值的一维数组，所以在这里将他赋值给data属性，不用再将它变为一个二维数组
        $this->data = $var;
        //1,查看data属性的值
        //2,查看在这里是否赋值成功
//        dd($this->data);
        //1，将这个类以对象的形式返回，方便链式操作
        return $this;
    }

    //显示模版
    public function make(){
        //1,测试是否访问到这里
//        dd('显示模版');
        //2，测试是否能够调用Boot类里面定义的常量
        //dd(MODULE);//home
        //dd(CONTROLLER);//entry
        //dd(ACTION);//index
        //3，测试在这里访问到的data属性是否赋值成功
//        dd($this->data);
//        Array
//        (
//            [test] => houdunwang
//        )
        //1,用来获取要加载页面的路径
        //2,得到路径后，当在Boot里面echo Base类这个对象时，触发对象中的__tostrong方法，在这个方法中加载这个页面
        //3,c($var)是在助手函数中创建的一个方法，用来获得这个文件的后缀名
        $this->file = "../app/".MODULE."/view/".strtolower(CONTROLLER)."/".ACTION.".".c('view.suffix');
        //将这个类以对象形式返回
//        dd($this->file);die();
        return $this;

    }

    /**
     * 当echo 输出对象的时候触发这个方法
     * 在echo前面所需要访问到的类中必须都得有返回值,最后需要返回一个对象
     * 返回的对象必须是含有这个__tostring方法的这个对象，就像__call一样，只有找到这个对象才能触发里面的方法
     * @return string
     */
    public function __toString()
    {
//        dd($this->file);die();
        //1,Boot类里面echo一个对象，
        extract($this->data);
        include $this->file;
        //1,这个类必须有一个返回值，不然会报错
        //2,一下是测试是否访问到这个类
//        return '__toString';
        return '';
    }


}

















