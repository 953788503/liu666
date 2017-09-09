<?php
/**
 * 暂时用来测试
 */
//1,设置命名空间
//2,命名空间的名字于目录相对应方便从composer.json里面自动加载这个空间
//3,加载到这个空间后可以对里面的任何一个类实例化
namespace  app\home\controller;
//1，声明类app\home\controller\Entry
//2,测试在地址栏传入不同的参数调用不同目录中不同命名空间里的类
//3,因为要继承Controller这个类，所以要加载它的命名空间和目录
//4,使用use 加载Controller的命名空间,目录我们通过composer.json加载
//5,要想使用一个类必须满足两点，1，include把他的目录加载进来，2，use 把他的命名空间加载进来
use houdunwang\core\Controller;
//1,因为在方位不存在的方法是要用到这个路径下和这个命名空间下的View里面的方法，所以在这里需要使用use加载它的命名空间
//2,composer.json里面已经加载了他的目录路径
//3,要调用一个类必须先加载好他的命名空间和路径，两个缺一不可，不然会报错
use houdunwang\view\View;
//1,因为在方位不存在的方法是要用到这个路径下和这个命名空间下的Article里面的方法，所以在这里需要使用use加载它的命名空间
//2,composer.json里面已经加载了他的目录路径
//3,要调用一个类必须先加载好他的命名空间和路径，两个缺一不可，不然会报错
use system\model\Article;

class Entry extends Controller {
    //1,声明普通方法index
    //2,用于测试在地址栏改变参数，是否能访问到这个方法
    public function index(){
        //1，测试是否能从单一入口文件访问到这个类
//        echo 'indexdd';

        //1，测试c函数是否正常
        //2,访问不存在的数据时返回null
        //$user =c('database.hosat');//null
        //3,访问存在的数据时，返回当前结果
        //$user=c('database.host');//127.0.0.1
//        dd($user);

        //测试数据库操作
        $data = Article::find(5);
        //输出查询到的结果
        dd($data);
//        exit();
        $test = 'houdunwang';
        //1,compact('变量名'),
        //2,将一个声明的变量转换成一个以变量名为键名，他的值为键值的数组
//        dd(compact('test'));
        //3,效果如下
//        Array
//        (
//            [test] => houdunwang
//        )
        //1，测试它访问到了那里
        //2,访问的分别是View类里面的__callStatic方法再到parseAction方法在访问到Base类里面的with方法
        //View::with(compact('test'));
        return View::with(compact('test'))->make();

    }
    //1,声明普通方法add
    //2,用于测试在地址栏改变参数，是否能访问到这个方法
    public function add(){
        //1,测试是否能从单一入口文件访问到这个类
        //echo 'add';

        //1,测试Controller.php中setRedirect和message方法
        //2,首先调用setRedirect()方法，给$url赋值
        //$this->setRedirect('http://liuzhaobo.xin');
        //3,在掉用message()方法，加载提示页面
        //4,这时可以在提示页面中使用跳转变量$url，因为已经在前面给他赋值了
        //$this->message('添加成功');

        //1,使用链式方法调用父类里面的方法
        $this->setRedirect()->message('添加成功');

    }
}





