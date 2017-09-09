<?php
/**
 *
 */

namespace houdunwang\model;



class Model{
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
        return  self::parseAction($name,$arguments);
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
        //1,测试是否访问到这个类
//        dd('__callStatic');
        //1，静态调用parseAction方法
        //2,parseAction方法是用来访问Base里面的$name方法的；
        return self::parseAction($name,$arguments);
    }
    /**
     * 实例化类Base
     * @param $name     调用Base类中的$name方法
     * @param $arguments         Base类中的$name方法的参数
     * @return mixed            返回查找到的结果
     */
    public static function parseAction($name,$argument){
        //1,返回当前调用的类名
        //2,因为是子类继承调用父类的，所以它返回的是子类的类名
//        dd(get_called_class());
//        dd('parseAction');
        //1,等到调用这个父类方法的子类的类名Article
        //2,将这个类名当作一个数据库表名传到Base类中
        $class = get_called_class();
        //1，调用Base里面的$name方法，并将$class传到Base类中的构造方法中
        return call_user_func_array([new Base($class),$name],$argument);

    }


}









