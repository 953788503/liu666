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
    //1,存放查询结构的数据
    private $data;
    /**
     * @var存放查询的指定字段
     */
    private $field;
    //1,定义私有属性where,用来存储sql语句的where条件
    //2,方便根据多个条件查找数据库里面的数据
    private $where='';

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
     * 排序方法
     * @param string $a 按照那个标签排序
     * @param string $b 排序的方式升序还是降序，默认是升序
     * @return bool|mixed返回查询到的结果
     */
    public function order($a='',$b='asc'){
        //1,$a为要排序的字段，这个必须要有
        //2,if语句判断它是否为空，如果为空说明没有传如排序字段，返回false，下面的代码不再执行
        if (empty($a)){
            //1,没有传如排序字段，返回false，下面的代码不再执行
            return false;
        }
        //1,排序语句中排序条件只认这两个，如果不是这两个，返回false
        if ($b!='asc' && $b!='desc'){
            //返回false，下面代码不再执行
            return false;
        }
        //1,在这个方法中声明一个变量用来存储查询的指定字段
        //2,使用三元表达式判断是否传入了指定的查询字段，如果没有，设置为*，查询所有
        $field = $this->field ? : '*';
        //1,拼接排序的语句，必须有一个要排序的参数
        //2,拼接完后可以调用query()方法直接查询
        $sql="select $field from {$this->table} {$this->where} order by $a $b";
        //1，开始执行自己声明的方法query，开始查找
        //2,将获取到的数据存到私有属性data里面
        $data = $this->query($sql);;
        //1,将这个类以对象形式返回
        return $data;

    }

    /**
     * 统计数据
     * @return mixed返回查询到的结果
     */
    public function count(){
        //1,拼接完整的查询sql语句
        //2,方便直接调用query()方法直接查询
        $sql = "select count(*) as total from {$this->table} {$this->where}";
        //1,调用自己创建的query方法，查询语句
        //2,返回查询到的结果
        $data = $this->query($sql);
        //1,得到的是如下这样一个数组，我们只要他的total值
//        Array
//        (
//            [0] => Array
//            (
//                [total] => 3
//            )
//
//        )
        //1,返回查询到的结果
        //2,返回数组的total值
        return $data[0]['total'];
    }

    /**
     * 执行跟新数据
     * @param array $data跟新数据，传入的是一个含有标签和内容的数组
     * @return bool|mixed返回改变了数据库里面的几条数据
     */
    public function update(array $data){
        //1,如果没有指定where条件不允许更新数据
        //2,不然数据库里面的数据会全部被更新
        if (empty($this->where)){
            //1,返回false下面的代码不让他执行
            return false;
        }
        //1，声明一个空字符串用来存储拼接完成的要跟新的数据
        //2，效果:title='后盾网',time=10
        //3,方便写入sql语句中执行
        $fields='';
        //1,使用foreach循环遍历$data数组
        //2,得到需要修改内容的标签有哪些和每个标签相对应的内容
        foreach ($data as $k => $v){
            //1,数组的键值为标签内容，我们将他们用逗号拼接起来
            //2,方便写到sql语句中
            //3,在拼接之前我们还需要判断这个内用是不是整形的，如果是整形的我们在拼接时就不能给他加上引号
            //4,因为如果是整形的说明这个标签在数据库中的类型为整形，加上单引号后会转换为string类型，在执行sql语句是会报错
            if (is_int($v)){
                $fields .= "{$k}={$v}" . ',';
            }else{
                $fields .= "{$k} = '{$v}'" . ',';
            }
        }
        //1,在拼接完成后得到的语句最后面有个逗号，这个逗号我们不要使用rtrim将这个逗号去掉
        $fields = rtrim( $fields , ',');
        //1,测试拼接到的结果是不是我们想要的
//        dd($fields);
        //1,开始拼接完整的sql语句
        //2,可以放到sql中直接执行的
        $sql = "update {$this->table} set $fields {$this->where}";
        //1,测试拼接完的结果是否正确
//        dd($sql);
        //1,调用我们自己创建的方法exec()，往数据库中添加数据
        //2,返回的是对里面的几条数据进行了操作
        return $this->exec($sql);
    }

    /**
     * 插入语句
     * @param $data往数据库新增数据，传入的是一个含有标签和内容的数组
     * @return mixed返回改变了数据库里面的几条数据
     */
    public function insert($data){
        //1,用来存储拼接标签名
        //2,我们需要得到要给数据表里面那些标签添加内容
        //3,用户需要传进来一个以标签为键名内容为键值的数组
        //4,我们需要将标签名拼接成一个完整的条件
        $fields = '';
        //1,用来存储拼接标签内容
        //2,我们需要得到要给数据表里面那些标签添加内容
        //3,用户需要传进来一个以标签为键名内容为键值的数组
        //4,我们需要将标签的内容拼接成一个完整的条件，对应拼接好的每一个标签名
        $values = '';
        //1,使用foreach循环遍历$data数组
        //2,得到需要添加内容的标签有哪些和每个标签相对应的内容
        foreach ($data as $k => $v){
            //1,数组的键名为标签名，我们将他们用逗号拼接起来
            //2,方便写到sql语句中
            $fields .= $k . ',';
            //1,数组的键值为标签内容，我们将他们用逗号拼接起来
            //2,方便写到sql语句中
            //3,在拼接之前我们还需要判断这个内用是不是整形的，如果是整形的我们在拼接时就不能给他加上引号
            //4,因为如果是整形的说明这个标签在数据库中的类型为整形，加上单引号后会转换为string类型，在执行sql语句是会报错
            if ( is_int($v)){
                $values .= $v . ',';
            }else{
                $values .= "'$v'" . ',';
            }
        }
            //1,在拼接完成后得到的语句最后面有个逗号，这个逗号我们不要使用rtrim将这个逗号去掉
            $fields = rtrim( $fields , ',');
            $values = rtrim( $values , ',');
            //1,测试拼接完成的语句是否符合要求
            //dd($fields);
            //dd($values);
            //1,拼接完成sql添加语句
            //2,方便我们直接调用exec方法来执行sql添加语句
            $sql = "insert into {$this->table} ({$fields}) values ({$values})";
            //1,测试输出拼接完成的语句是否符合要求
            //2,做好复制到cmd框里面执行以下
            //dd($sql);
            //1,调用我们自己创建的方法exec()，往数据库中添加数据
            //2,返回的是对里面的几条数据进行了操作
            return $this->exec($sql);
    }


    /**
     * 删除语句
     * @param string $pk删除主键值
     * @return bool|mixed返回改变了数据库里面的几条数据
     */
    public function destory($pk = ''){
        //1,判断where条件是否为空
        //2,删除语句不能让where条件语句为空，因为这会把整个表的数据删除
        if (empty($this->where)){
            //测试是否执行到这里
//            dd(1);
            //1，如果where值为空，检测参数主键值是否为空
            //2,如果为空，就让他返回false，不能让他为空，不然会报错
            if (!empty($pk)){
                //1,获取主键
                //2,得到主键值方便删除指定的那个主键值，
                $priKey=$this->getPk();
                //1,他没有where条件，我们给他设置主键值来给他当where条件
                $this->where("{$priKey}={$pk}");

            }else{
//                dd($pk);
                //测试是否访问到了这里
//                dd(1);
                //1，如果where和主键值都为空，让他返回false
                //2,where和主键值都为空的话，会删除表里面所有的数据
                return false;
            }
            //1,得到了where条件，我们来拼接完整的sql删除语句
            //2,方便后面调用我们自创建的exec（）方法对数据库进行操作
            $sql = "delete from {$this->table} {$this->where}";
        }else{
            //测试是否访问到这里
//            dd(2);
            //1，如果有where条件的话，拼接完整的sql删除语句
            //2,方便后面调用我们自创建的exec（）方法对数据库进行操作
            $sql = "delete from {$this->table} {$this->where}";
        }
        //1,执行sql语句
        //2,返回对几条数据进行了操作
        return $this->exec($sql);

    }


    /**
     * 获取指定查找的字段
     * @param $field 要查找的指定字段 ('title,time')
     * @return $this 将这个类以对象形式返回
     */
    public function field($field){
        //1,将指定查找的字段存入私有属性field中
        //2,方便可以在全局方法中调用
        $this->field = $field;
        //1,将这个类以对象形式返回
        //2,得到这个对象后可以调用里面已经定义过得属性
        return $this;
    }

    /**
     * 查询数据表中满足条件的所有数据
     * @return $this   返回查到的数据
     */
    public function getAll(){
        //1,在这个方法中声明一个变量用来存储查询的指定字段
        //2,使用三元表达式判断是否传入了指定的查询字段，如果没有，设置为*，查询所有
        $field = $this->field ? : '*';
        //1,组合查询所有数据的sql语句
        //2,通过query（）方法执行它
//        dd($this->where);
        $sql = "select {$field} from {$this->table} {$this->where}";
//        dd($sql);
        //1,执行查询
        //2,调用我们自定义的query方法执行sql语句
        $data = $this->query($sql);
        //1,使用if判断得到的结果是否为空
        //2,如果不为空执行if里面的代码
        if (!empty($data)){
            //测试是否执行到if里面
//            dd(1);
            //3,将获取到的数据存到私有属性data里面
//            $this->data = $data;
            //1,将这个类以对象的形式返回
            if (count($data)==1){
                return current($data);
            }
            return $data;
        }
        return [];
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
//        dd($pk);
        //1,将完整的sql语句写入其中，下面用来执行查找
        //2,$id是用来查找的那个主键的值
        //$sql = "select * from {$this->table} where {$pk} = {$id}";

        //1，组合where语句，调用where方法
        //2,将sql语句中的where条件语句存储到私有变量where属性中
        //3,$pk是我们获得到的主键名，$id是传入的要查找那个主键的参数
        $this->where("$pk={$id}");
//        dd($this->where);
        //1,测试得到的where条件语句是否正确
//        dd($this->where);// where id=5
        //1,在这个方法中声明一个变量用来存储查询的指定字段
        //2,使用三元表达式判断是否传入了指定的查询字段，如果没有，设置为*，查询所有
        $field = $this->field ? : '*';
        //1,测试查看默认情况下得到的查询字段是否为*
//        dd($field);//*
        //1,开始拼接完整的sql查询语句
        //2,下面可以直接在query方法中使用查询
        $sql = "select {$field} from {$this->table} {$this->where}";
//        dd($sql);
        //1,测试拼接是否正确，能够执行
        //dd($sql);//select * from article  where id=5
        //1,执行查询
        //2,调用我们自定义的query方法执行sql语句
        $data = $this->query($sql);
        //1,查看获取到的结果
        //2,妨碍结果是一个二维数组
//        dd($data);
        //1,使用if判断得到的结果是否为空
        //2,如果不为空执行if里面的代码
//        if (!empty($data)){
            //测试是否执行到if里面
//            dd(1);
            //3,将他转换为一维数组返回
            $this->data=current($data);
            //1,将类以数组对象返回
            //2,方便使用链式操作调用这个类中的其他方法
//            return $this;
//        }
        //1,将类以数组对象返回
        //2,方便使用链式操作调用这个类中的其他方法
        return $this;
    }

    /**
     * 将对象转为数组
     * 其实就是将返回对象改为返回查到的数据
     * @return array
     */
    public function toArray(){
        //1,测试传过来的data是不是一个空数组
//        dd($this->data);
        //2,测试是否执行到了这里
//        dd(1);
        //1,判断查询到的数据是否为空
        //2,如果不是可以断定在前面的方法中已经将查询到的数据存入到了私有属性data中
        if ($this->data){
            //3,直接将这个存有查询到数据的数组返回出去
            return $this->data;
        }
        //1,如果查询到的数据为空的话，说明数据库中没有这个数据
        //2,返回一个空数组
        return [];
    }


    /**
     * @param $where要查到数据的where条件
     * @return $this将Base类以对象的形式返回
     */
    public function where($where){
        //1,将要查找的where条件拼接完整
        //2,在后面可以直接在sql操作语句后面拼接，形成一条完整的带有条件的sql操作语句
        //3,拼接效果:$this->where = "where sex='女' and age>20";
        $this->where=" where {$where}";
        //1，将这个类以对象形式返回
        //2，如果不返回的话后面调用不到里面的数据
        return $this;
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

    /**
     * 执行没有结果集的sql
     * @param $sql需要执行的sql代码
     * @return mixed返回改变了数据库里面的几条数据
     * @throws Exception抛出的异常
     */
    public function exec($sql){

        try{
            //1,开始对数据库进行操作
            //2,执行这个self::$pdo->exec($sql)方法会返回对数据库中的几条数据进行了操作
            $res=self::$pdo->exec($sql);
            //1,返回对数据库中的几条数据进行了操作
            return $res;
        }catch(PDOException $exception){
            //1,取出结果集的过程中出现错误后抛出异常
            //2,使用throw new Exception（）抛出的异常比较详细，可以看到都经过那些类
            //3,推荐使用
            throw new Exception($exception->getMessage());
        }

    }


}











