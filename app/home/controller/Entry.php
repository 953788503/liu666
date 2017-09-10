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
//        $data = Article::find(5);
        //输出查询到的结果
//        dd($data);
//        exit();
//*************************************************************************
        //测试抛出异常加载第三方类库
//        Article::query('aaa');
//******************测试数据库根据主键查找单一一条数据************************************
        //1，Article::find(5)返回的是一个对象,Article::find(5)->toArray()返回的是一个数组
        //2,获得我们需要的数据
//        $data=Article::find(1)->toArray();
        //1,测试输出查看获得的数组
//        dd($data);
//***********************where条件查找数据************************************
//        $data=Article::where('age>22 and id>12')->getAll()->toArray();
//        $data=Article::getAll()->toArray();

//        dd($data);
//***********************使用原生方式查询所有的数据***********************************
        //1，调用base类里面的query方法，直接传入原生sql代码查询
        //2，base类里面的query方法会返回查到的数组
//        $data=Article::query('select * from ss');
        //1,测试查看查询到的是否正确
//        dd($data);
//***********************测试删除数据******************************
          //1,测试是否访问到destory方法里面的else
        //2,当没有使用where(）和destory()里面都没有传参数时会返回false
//        Article::where('id=2')->destory();
//        $data=Article::destory(3);
//        dd($data);
//            dd( Article::destory(2));
//*******************测试数据新增******************************************
        //1，往数据库新增数据，我们需要传入的是一个含有标签和内容的数组
        //2,我们将标签作为键名，内容作为键值来写这个数组
        $data = [
            'id'=>6,
            'name' => '亚索',
            'age' => 22,
            'sex' => '男',
            'hobby' => '篮球'
        ];
        //1,调用base里面的insert方法，像数据库中插入数据
        //2,会返回对数据库中的几条数据进行了操作
//        $res = Article::insert($data);
        //1，输出对数据库中的几条数据进行了操作
//        dd($res);

//************************测试数据更新************************************************
        //1,调用base里面的update方法，像数据库中插入数据
        //2,调用之前必须先调用where方法，给where穿个更新条件不然会返回false
        //3,操作成功后会返回对数据库中的几条数据进行了操作
//        $res = Article::where("id=6")->update($data);
        //1，输出对数据库中的几条数据进行了操作
//        dd($res);
//*********************测试统计********************************
        //1,测试不传where条件的查找
//        $count = Article::count();
        //2,测试传where条件的查找
//        $count = Article::where("sex='女'")->count();
        //1,输出查找到的数据
//        dd($count);

//********************测试获取指定字段的查找*************************************
        //1,查找name,sex标签的所有数据
        //2,返回一个数组
//        $data = Article::field('name,sex')->getAll()->toArray();
        //1,查找name,sex标签中主键是5的数据
        //2,返回的是一个数组
//        $data = Article::field('name,sex')->find(5)->toArray();
        //1,输出这个数组
//        dd($data);
//************************测试排序*************************************
        //1,调用base里面的order方法,必须传入一个排序字段，不然会报错
        //2,返回排序好的数组
        $data = Article::order('id');
        //1,输出这个排序好的数组
        dd($data);
//************************************************************************
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





