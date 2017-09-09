<?php
/**
 *
 */
namespace houdunwang\model;
//1,加载PDOException类的命名空间
//2,避免每次调用这个类都需要在前面加反斜杠
use PDOException;
//1,加载PDO类的命名空间
//2,避免每次调用这个类都需要在前面加反斜杠
use PDO;
//1,加载Exception类的命名空间
//2,避免每次调用这个类都需要在前面加反斜杠
use Exception;

class Base{
    //1，用来存储连接到数据库后产生的那个值
    //2,将他设置为静态变量防止重复的连接数据库
    private static $pdo=null;
    //1，操作数据表名
    private $table;

    public function __construct($class)
    {
        //1,连接数据库
        //2,由于$pdo是一个静态变量，所以可以根据判断他是否为空来判断是否连接到了数据库
        if (is_null(self::$pdo)){
            //1,如果$pdo为空说明没有连接到数据库
            //2，调用connect方法，链接到数据库
            self::connect();
        }
        //测试get_called_class()返回的是谁的类名
//        dd(get_called_class());
//        dd($class);
        //1，得到数据库表名
        $info=strtolower(ltrim(strrchr($class,'\\'),'\\'));
        //1,将数据表名赋值给私有变量table
        $this->table=$info;
        //2,输出打印看表明是否正确
//        dd($info);
    }

    /**
     * 连接数据库
     * @throws Exception  抛出的异常错误
     */
    private static function connect(){
        try{
            //1,加载到哪个数据库
            //2,我们已经将数据库的类型地址和数据库表名存储到了database里面，通过调用助手函数中的c()方法来获得我们需要用的信息
            $dsn = c('database.driver').":host=".c('database.host').";dbname=".c('database.dbname');
            //1,数据库的用户名
            $user = c('database.user');
            //1,数据库的密码
            $password=c('database.password');
            //1,开始链接到数据库
            //2,前面已经将$pdo设置为静态变量，在这里不用每次连接数据库
            self::$pdo = new PDO($dsn,$user,$password);
            //1,设置字符集
            //2,头部声明utf8编码和这里设置字符集为utf8一个都不能少，不然在页面输出中文后会报错
            self::$pdo->query('set names utf8');
            //1,设置错误属性
            //2,当连接数据库出问题后会抛出异常,需要和try{}catch(){}一起用，不然不会抛出异常，而是浏览器报错
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $exception){
            //1,通过throw new Exception抛出的异常更加详细
            //2推荐使用
            throw new Exception($exception->getMessage());
        }
    }


    /**
     * 查找数据并返回查找到的值
     * @param $id要查找的那个数据表的主键值
     * @return mixed查找到的结果
     */
    public function find($id){
        //1，测试是否可以访问到这个类
//        dd('find');
        //1,通过getPk()我们来获取到$table这个数据表的主键
        //2,方便我们直接设置主键的值，通过相应的语句，主键值作为条件查找数据
        $pk = $this->getPk();
        //1,将完整的sql语句写入其中，下面用来执行查找
        //2,$id是用来查找的那个主键的值
        $sql = "select * from {$this->table} where {$pk} = {$id}";
        //1,执行查询
        $data = $this->query($sql);
        //1,查看获取到的结果
        //2,妨碍结果是一个二维数组
//        dd($data);
        //3,将他转换为一维数组返回
        return current($data);
    }

    /**
     * 获取table数据表中的主键
     * @return string返回主键
     */
    private function getPk(){
//        dd('getPk');die();
        //1,查看表结构
        //2,将sql命令拼接存入到$sql中
        $sql = "desc " . $this->table;
//        dd($sql);die();
        //1,调用$data方法得到查出的表结构内容
//        $data = $this->query($sql);
        $data=$this->query($sql);
        //1,测试查看$data的数据样式
        //2,如果数据库中没有这个表，便会报错
//        dd($data);
        //数据如下
//        Array
//        (
//            [0] => Array
//            (
//                [Field] => id
//                [Type] => int(11)
//                [Null] => NO
//                [Key] => PRI
//                [Default] =>
//                [Extra] => auto_increment
//            )
        //1,我们声明一个变量用来存储有primary key的id或cid,aid
        $pk = '';
        //2,通过foreach循环遍历这个数组
        foreach ($data as $v){
            //3,找到$v['Key']键值为PRI的那个数组
            if ($v['Key']=='PRI'){
                //4,里面的$v['Field']的值就是我们要找的那个有自增的主键
                //5,将他的值赋给我们先前声明的变量$pk
                $pk=$v['Field'];
                //6,可以结束循环了，下面的信息不需要了
                break;
            }
        }
        //1,返回这个主键
        //2,后面我们可以通过传入主键值来查找相应的数据
        return $pk;
    }

    /**
     * 执行有结果集的查询
     * @param $sql需要执行的sql语句
     * @return mixed返回查询到的结果
     * @throws Exception抛出异常
     */
    public function query($sql){
        try{
            $res = self::$pdo->query($sql);
            //1,取出结果集
            //2,以数组的形式返回得到的数据
            return $row=$res->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $exception){
            //取出结果集的过程中出现错误抛出异常
            throw new Exception($exception->getMessage());
        }
    }


}











