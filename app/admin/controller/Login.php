<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11 0011
 * Time: 下午 3:28
 */
//必须由命名空间不然这个类找不到
namespace app\admin\controller;
use houdunwang\core\Controller;
use houdunwang\view\View;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use system\model\Admin;

class Login extends Controller {
    /**
     * 登陆管理的登陆界面
     * @return mixed
     */
    public function index(){
        //首先生成一个加密之后的密码，手动写入数据库中
//        dd(password_hash('admin888',PASSWORD_DEFAULT));
        //测试连接数据库是否成功
//        $res=Admin::where("username='amin'")->getAll();
//        dd($res);
        //测试c函数读取配置项
//        dd(c('database.host'));
        //测试u函数
//        u('admin.entry.index');
//        dd(u('entry.index'));
//        dd(u('admin.entry.index'));
//        dd(u('index'));
        //1,调用助手函数里面的IS_POST常量,使用if判断出用户是否点击提交
        //2,点击提交后我们将获得用户名，密码还有验证码
        if (IS_POST){
            //测试是否能输出$_SESSION
//            dd($_SESSION);
            //查看提交的post数据
//            dd($_POST);
            //1,调用用Admin类的login方法
            //2,将用户提交的POST数据传过去，在那边判断用户名，密码，验证码是否输入正确
            $res = (new Admin())->login($_POST);
            //1,查看返回的值
//            dd($res);
            //1，使用if判断返回来的code的值是不是1
            //1,1代表通过验证
            if ($res['code']){
                //1,成功后调用父类的setRedirect($url)方法
                //2,弹出登录成功，3秒后跳转到$url界面
                $this->setRedirect(u('entry.index'))->message($res['msg']);
            }else{
                //失败后弹出msg信息，返回页面
                $this->setRedirect()->message($res['msg']);
            }
        }

        return View::make();
    }


    public function captcha(){
        //进入composer安装包界面搜索captcha按步骤操作
        header('Content-type: image/jpeg');
        $phraseBuilder = new PhraseBuilder(4);
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build();
        //1，将验证码存入到session中
        //2，方便我们在登陆界面直接抽取session中的验证码来验证用户输入的验证码是否正确
        $_SESSION['phrase'] = $builder->getPhrase();
        $builder->output();
    }

}
