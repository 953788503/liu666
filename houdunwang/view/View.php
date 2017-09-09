<?php
/**
 * 视图层
 */
namespace houdunwang\view;

class View{
    /**
     * 当调用不存在的方法时触发
     * @param $name     不存在方法名称
     * @param $arguments        方法参数
     *
     * @return  mixed
     *
     */
    public function __call( $name , $arguments )
    {
        //1，静态调用parseAction方法
        //2,parseAction方法是用来访问Base里面的$name方法的；
        return  self::parseAction($name.$arguments);
    }

    /**
     * 当静态调用不存在的方法时候触发
     * @param $name     不存在的方法名称
     * @param $arguments        方法参数
     *
     * @return  mixed
     */
    public static function __callStatic( $name , $arguments )
    {
        //测试在静态调用不存在的方法时，是否执行了这个类;
//        dd('callstatic');
        //1，静态调用parseAction方法
        //2,parseAction方法是用来访问Base里面的$name方法的；
        return  self::parseAction($name,$arguments);
    }

    /**
     * 实例化类Base
     * @param $name     调用Base类中的$name方法
     * @param $arguments         Base类中的$name方法的参数
     * @return mixed
     */
    public static function parseAction($name,$arguments){
        //1，测试知否执行了这个方法
//        dd('parseAction');
        //1,访问Base类里面的$name方法，$arguments是这个方法的参数
        return call_user_func_array([new Base(),$name],$arguments);
    }

}














