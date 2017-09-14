<?php
/**
 * 创建框架的启动类houdunwang\core\Boot.php类,类名和文件名首字母大写
 */
//1,创建命名空间
//2,命名空间的名字于目录相对应方便从composer.json里面自动加载这个空间
//3,加载到这个空间后可以对里面的任何一个类实例化
namespace houdunwang\core;
class Boot{
    //1，设置单一入口的接头方法
    //2,以后的框架中为了避免调用类里面的方法需要重复实例化各个类，在这里将各个类设置成静态方法，不需要实例化便可以直接调用
    public static function run(){

        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
        //测试是否能调用到这个类
//        echo 1;
        //1,初始化框架
        //2,将框架的先决条件准备好，比如编码时间session等，避免后面代码中出现不必要的错误
        self::init();
        //2,执行应用
        //2,1里面判断地址栏参数?s=home/entry/add,访问不同文件里面不同命名空间里面的类
        self::appRun();
    }

    public static function appRun(){

        //1,判断地址栏是否有$get['s']参数
        //2,$get['s']参数中的值不同，访问的类也不同，执行的方法也不同，实现的功能也不会相同
        if (isset($_GET['s'])){
            //1,为了避免因为要访问每个目录下的某个类，而需要在地址栏声明多个参数来存这个目录的地址，类名等等，我们将他们统一写入到s里面
            //2,效果像这样:home/entry/index:代表着home模块(文件夹)里面的entry控制器(类)里面的index方法
            //测试一下if语句是否生效
//            dd($_GET['s']);
//            exit();
            //1，根据/将每个参数从s字符串里面解析出来，形成一个数组
            //2,使用数组里面的值就可以访问到指定文件里面的指定命名空间下的类
            $info=explode('/',$_GET['s']);
            //1,通过拼接$info数组得到指定命名空间里面的类
            //2,下面可以通过实例化这个空间里面的类调用里面的方法
            $class = "\app\\{$info[0]}\controller\\" . ucfirst($info[1]);
            //1,通过$info数组得到访问的方法名
            //2,与$class配合，访问$class类里面的$action方法
            $action = $info['2'];

            //1,定义常量
            //2,这里定义的常量用于后面在其他类的方法中加载不同的界面
            define('MODULE',$info[0]);
            define('CONTROLLER',$info[1]);
            define('ACTION',$info[2]);

        }else{
            //1，地址栏如果没有参数我们需要给他一个默认值
            //2，通过给他一个默认值使他在没有值的情况下按照我们给的思路走，呈献给用户我们想让他看到的效果,避免因为没有值下面的代码不再执行而造成的界面空洞的效果
            $class = "\app\home\controller\Entry";
            $action = 'index';
//            echo '没有s';
//            exit();
            //1,定义常量
            //2,这里定义的常量用于后面在其他类的方法中加载不同的界面
            define('MODULE','home');
            define('CONTROLLER','entry');
            define('ACTION','index');
        }
        //1，实例化$class这个类，调用里面的$action方法,后面的那个[]是用来填$action方法里面的参数的，就算没有参数也必须写上它给个空值，不然会报错
        //2,call_user_func_array([new $class , $action ],[])相当与代码(new $class)->$action();
        echo call_user_func_array([new $class , $action ],[]);
//        call_user_func_array([new $class , $action ],[]);
//        call_user_func_array([new $class , $action ],[]);
        //1,测试是不是随便输出一个对象就会触发Base类里面的__tostring方法
        //2,结果不是，我在这个文件中声明了一个类，用来作为对象，得到的答案是如果a这个类中有__tostring这个方法，那么他会触发a类里面的这个方法，如果没有的话会报错
//        echo (new a());
        //1，测试一下它经过Entry类在经过Base类返回回来的是不是一个对象
//        var_dump(call_user_func_array([new $class , $action ],[]));
        //2,输出出来的结果
        /**
         * object(houdunwang\view\Base)#3 (2) { ["data":protected]=> array(1) { ["test"]=> string(10) "houdunwang" } ["file":protected]=> string(32) "../app/home/view/entry/index.php" }
         */

    }




    /**
     * 初始化框架，设置执行框架时的先决条件
     */
    public static function init(){
        //1,声明头部的文本编译utf8
        //2,如果不加上头部,浏览器在输出中文是会出现乱码
        header('Content-type:text/html;charset=utf8');
        //1,设置时区
        //2,如果不设置时区，有的电脑上设置的是其他时区，那么使用时间的时候会出现偏差
        date_default_timezone_set('PRC');
        //1,开始session
        //2,使用session必须开启,如果有session_id说明已经开启了session，不用再重复开启session
        session_id()||session_start();


    }


}

//class a{
//public function __toString()
//{
//    return 'aaa';
//}
//}