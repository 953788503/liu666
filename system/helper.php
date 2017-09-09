<?php
/**
 * 助手函数
 */
//头部
//header ('Content-type:text/html;charset=utf8');
//设置时区
//date_default_timezone_set('PRC');

//定义常量判断是否为post请求
define('IS_POST',$_SERVER['REQUEST_METHOD']=='POST'?true:false);

//判断是否为ajax请求
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest'){
    //是异步请求
    define('IS_AJAX',true);
}else{
    //异步请求没成功
    define('IS_AJAX',false);
}

if(!function_exists ('dd')){
	/**
	 * 打印函数
	 */
	function dd($var){
		echo '<pre style="background: #ccc;padding: 8px;border-radius: 5px">';
		//print_r打印函数，不显示数据类型
		//print_r不能打印null，boolen
		if(is_null ($var)){
			var_dump ($var);
		}else if(is_bool ($var)){
			var_dump ($var);
		}else{
			print_r ($var) ;
		}
		echo '</pre>';
	}
}
if(!function_exists ('getRunTime')){
	/**
	 * 计算脚本运行时间
	 * @param $pos	开始/结束标记
	 */
	function getRunTime($pos){
		//声明静态变量
		//存开始时间，为了结束调用的时候还可以使用$time
		static $time = 0;
		//脚本运行开始，start开始的标识
		if($pos=='start'){
			//将当前时间存到静态变量
			//存起来给结束时候调用
			$time = microtime (true);
		}
		//end脚本运行结束标识
		if($pos=='end'){
			//microtime (true)结束时间
			//$time开始时间
			//时间差即为脚本运行时间差
			return microtime (true) - $time;
		}
	}
}


/**
 * 上传函数
 */

/**
 * @param string $path默认路径
 * @return array存有上传图片所有完整路径的数组
 */
if (!function_exists('up')){
    function up($path='upload'){

        //重组数组
        $arr=resetArr();
//    dd($arr);
        //移动上传,
        return move($arr,$path);

//        echo '<script>alert("上传成功");location.href="index.php"</script>';

    }
}

//重组数组函数
/**
 * @return array将数组重组后的结果
 */
if (!function_exists('resetArr')){
    function resetArr(){
        //因为数组$_FILES里面只有一个元素，使用curren获取他的键值，得到一个二维数组
        $file=current($_FILES);
//    dd($file);
        //重组数组
        //创建一个空数组用来接受重组后的数组
        $arr=[];
        //判断上传的是一个文件还是多个文件
        if(is_array($file['name'])){
            //foreach遍历数组$file
            foreach ($file['name'] as $k=>$v){
                $arr[]=[
                    'name'=>$v,
                    'type'=>$file['type'][$k],
                    'tmp_name'=>$file['tmp_name'][$k],
                    'error'=>$file['error'][$k],
                    'size'=>$file['size'][$k]
                ];
            }
        }else{
            //else里得到的数组$arr需要跟if得到的数组$arr的格式保持一致，都是一个二维数组
            $arr[]=$file;
        }
//    dd($arr);
        //返回数组$arr
        return $arr;
    }
}


//移动上传文件
/**
 * @param $arr获取到的重组数组
 * @param string $path自己填写的目录
 */
if (!function_exists('move')){
    function move($arr,$path){
        //声明一个数组用来存储图片的完整路径
        $lujing=[];
        //移动上传
        //foreach遍历数组$arr,获取上传的每一个元素
        foreach ($arr as $k=>$v){
            //根据是否能捕获到临时缓存数据$v['tmp_name']判断每一个上传的数据是否是合法上传
            if(is_uploaded_file($v['tmp_name'])){
                //上传目录
                $uploadDir=$path.'/'.date('Y/m/d');
//            $uploadDir=$path;
                //短路创建目录，创建目录是mkdir里面需要在第二个参数写上0777权限设置，可读可写可改,第三个参数写上true递归创建
                is_dir($uploadDir)||mkdir($uploadDir,0777,true);
                //获取文件后缀名
                $type=strrchr($v['name'],'.');
                //设置随机文件名
                $fileName=time().mt_rand(1,9999).$type;
                //组合完整目录
                $dest=$uploadDir.'/'.$fileName;
                //将图片的完整路径追加到数组$lujing里面
                $lujing[]=$dest;
                //移动上传
                move_uploaded_file($v['tmp_name'],$dest);

            }
        }
        //将存有所有图片完整路径的数组return
        return $lujing;
    }

}

//将数据写入文件
if(!function_exists('dataToFile')){
    function dataToFile($file,$data){
        file_put_contents($file,"<?php\r\n return ".var_export($data,true).';');

    }
}

if(!function_exists('error')){
    /**
     * @param $msg提示消息
     */
    function error($msg){
        echo "<script>alert('$msg');history.back();</script>";
        exit();
    }
}

//自动加载，一但出现实例化便会自动执行函数，参数为实例化的类名，自动把类名传入
function __autoload($name){
//    echo $name;die();
    //判断用户实例化的对象是控制类还是工具类
    if (substr($name,-10)=='Controller'){
        //说明是控制类
        include "./controller/{$name}.class.php";
    }else{
        include "./tools/{$name}.class.php";
    }

}


if (!function_exists('c')){
    function c($var){
        $info=explode('.',$var);

        $data = include '../system/config/'.$info[0].'.php';

        return isset($data[$info[1]]) ? $data[$info[1]] : null;

    }
}







