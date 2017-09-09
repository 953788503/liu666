<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/8 0008
 * Time: 下午 3:35
 */
//1,命名空间
//2,命名空间的名字于目录相对应方便从composer.json里面自动加载这个空间
//3,加载到这个空间后可以对里面的任何一个类实例化
namespace houdunwang\core;

class Controller{
    //1,定义调转地址属性
    //2,用来使页面返回
    //3,第一位私有的只能在父类中使用
    private $url = 'window.history.back()';

    /**
     * 提示消息
     * @param $message   消息内容
     */
    public function message($message){
        //加载提示的模版文件
        //因为是从单一入口开始的，所以在调用时要从单一入口文件所在的目录开始调用，目录为./view/message.php
        include "./view/message.php";
        //1,但提示消息后后面的代码应该不让它在执行
        //2,参考其他网站，一旦进入到提示消息页面，其他的操作应该停止
        exit();
    }

    /**
     * 跳转功能
     * @param string $url    跳转地址
     */
    //1,这里要先给参数$url设置默认值为空
    //2,方便下面判断是否传入了要跳转的地址
    public function setRedirect($url = ''){
        //1,判断是否传入了要跳转的地址
        //2,默认参数的值为空,empty($url)判断参数的值是否为空，如果是空，说明没有传入跳转地址
        if (empty($url)){
            //1,使页面返回
            //2,因为没有传入要跳转的地址所以我们要是页面返回
            $this->url="window.history.back()";
        }else{
            //1,跳转到传入的地址页面
            //2,传入了跳转的地址，按照要求跳转到相应的地址
            $this->url="location.href='$url'";
        }
        //1,返回这个类的对象
        //2,方便链式操作,再调用这个方法时，他返回这个类的对象，可以直接使用他的返回值调用这个类里面的其他方法
        return $this;
    }


}












