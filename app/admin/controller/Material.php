<?php
/**
 * 素材管理控制类
 */
namespace app\admin\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Material as MaterialModel;
class Material extends Common {
    //素材管理主界面
    public function index(){
        //1,获取素材数据库中的数据
        //2,如果数据库中有素材返回数组
        //3,没有返回空数组
        $data=MaterialModel::getAll();

        //1,判断这个数组中是否有键值mid
        //2,如果有，说明他是一个一维数组
        if (array_key_exists('mid',$data)){
//            dd(1);
            //1,为了方便在页面上可以正常foreach循环，我们将他转为一个二维数组
            //2,这样在传递到页面上时，也会是一个二维数组
            $data=compact('data');

        }

//        dd($data);
        //1，加载素材管理主界面
        return View::make()->with(compact('data'));
    }
    //素材添加界面
    public function add(){
        //1，if判断是否post提交
        //2，提交了说明用户上传了数据，我们需要判断数据是否合格，然后存入数据库
        if (IS_POST){
            //1，测试是否访问到这里
//            dd($_FILES);
            //1,访问模块里面的add方法，返回一个数组
            //2,可以通过判断返回数组中的code值，判断是否添加成功
            $res=(new MaterialModel())->add();
            //1,判断是否添加成功
            if ($res['code']){
                //1,添加成功后跳到提示消息界面显示$res里面的msg值
                //2,3秒钟后跳到素材主界面
                (new Controller())->setRedirect(u('index'))->message($res['msg']);
            }else{
                //1,添加失败后跳到提示消息界面显示$res里面的msg值
                //2,3秒钟后返回素材添加界面
                (new Controller())->setRedirect()->message($res['msg']);
            }
        }
        //1,加载素材添加界面
        return View::make();
    }
    //素材删除
    public function del(){
        //1，查看传递过来的get参数
//        dd($_GET);die();
        //1，获取要删除数据的主键
        //2，只要获取到主键就可以根据主键删除数据库中相应的数据
        $mid=$_GET['mid'];
        //1,获取要删除的全部数据
        //2,因为要获得删除图片的路径，在文件夹中也要删除相应的图片
        $data=MaterialModel::find($mid)->toArray();
        //1,查看获取到的数组
//        dd($data);
        //1,file_exists($data['mpath'])检测该路径是否存在
        //2,如果存在说明有这个图片，需要删除它
        if (file_exists($data['mpath'])){
            //删除文件中的图片
            unlink($data['mpath']);
        }
        //1,数据库中的数据也需要删除
        //2,开始删除
        MaterialModel::destory($mid);
        //1,跳转到提示页面，提示删除成功
        //2,3秒后跳转到主页面
        $this->setRedirect(u('index'))->message('删除成功');
    }

}


