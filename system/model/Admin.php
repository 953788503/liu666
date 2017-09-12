<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11 0011
 * Time: 下午 2:53
 */
namespace system\model;

use houdunwang\model\Model;

class Admin extends Model{
    /**
     * 判断用户输入的账户和密码是否正确
     * @param $data用户提交的密码和账户验证码
     * @return array提示信息
     */
    public function login($data){
        //1,测试是否能调用这个方法，能不能传过来数据
//        dd($data);
        //1，得到提交上来的用户名
        $admin_username = $data['admin_username'];
        //2,得到提交上来的密码
        $admin_password = $data['admin_password'];
        //1，得到提交上来的验证码
        $captcha = $data['captcha'];
        //1,开始数据验证
        //2,验证用户名，密码和二维码
        //return['code'=>0,'msg'=>'请输入用户名']
        //code 标识成功还是失败的标识 1代表成功，0代表失败
        //msg 提示消息
        //1,判断用户名是否为空
        //2,如果为空返回['code'=>0,'msg'=>'请输入用户名']，下面代码不再执行
        if (!trim($admin_username)) return ['code'=>0,'msg'=>'请输入用户名'];
        //1,判断密码是否为空
        //2,如果为空返回['code'=>0,'msg'=>'请输入密码']，下面代码不再执行
        if (!trim($admin_password)) return ['code'=>0,'msg'=>'请输入密码'];
        //1,判断验证码是否为空
        //2,如果为空返回['code'=>0,'msg'=>'请输入验证码']，下面代码不再执行
        if (!trim($captcha)) return ['code'=>0,'msg'=>'请输入验证码'];
        //1,比对用户名密码是否正确
        //2,根据用户提交的username在数据库中进行查找
        //3,这里的用户名在sql语句中是字符串要加上单引号
        $userInfo = $this->where("username='{$admin_username}'")->getAll();
        //1,如果找不到数据，他会返回一个空数组
        //2,使用if判断，如果是空数组会false，返回['code'=>0,'msg'=>'用户名不存在']
        if (!$userInfo) return ['code'=>0,'msg'=>'用户名不存在'];
        //1,到这里已经可以断定传过来的三个都有参数，且传过来的用户名在数据库中存在
        //2,现在要判断的就剩下与用户名相对应的密码和$_SESSION中的验证码
        //3,测试查看查到的数组
//        dd($userInfo);
        //1,判断密码是否正确
        //2,如果不正确的话
        if (!password_verify($admin_password,$userInfo[0]['password'])) return ['code'=>0,'msg'=>'密码不正确'];
        //1，测试密码正确后是否走到这里
//        dd(1);
        //1,开始验证验证码是否正确
        //2,跟$_SESSION['phrase']比较
        //3,验证之前要先将他们都转为小写，防止因为大写的原因出现偏差
        if (strtolower($captcha) != strtolower($_SESSION['phrase'])) return ['code'=>0,'msg'=>'验证码不正确'];
        //1,测试验证码正确后是否能走到这里
//        dd(1);die();
        //1,登陆成功
        //2,将用户登录信息存储到session中
        $_SESSION['admin_id'] = $userInfo[0]['id'];
        $_SESSION['admin_username']=$userInfo[0]['username'];
        //1,返回成功标识和成功提示信息
        return ['code'=>1,'msg'=>'登录成功'];

    }

    /**
     * 用来修改密码
     * @param $data传过来的旧密码和新密码
     */
    public function editpw($data){
        //1,测试是否访问到这里
//        dd($data);
        //1,比对用户的旧密码是否正确
        //2,根据$_SESSION["admin_username"]用户名在数据库中进行查找
        //3,这里的用户名在sql语句中是字符串要加上单引号
        $userInfo = $this->where("username='{$_SESSION["admin_username"]}'")->getAll();
        //1,查看返回的数据
//        dd($userInfo);
        //1,判断密码是否正确
        //2,如果不正确的话
        if (!password_verify($data['oldpw'],$userInfo[0]['password'])) return ['code'=>0,'msg'=>'旧密码不正确'];

        //1,判断两次输入的修改密码是否相同
        //2,如果不相同提醒用户让他重新输入
        if ($data['newpw']==$data['newspw']){
            //1，创建跟新数据库的数组
            $data=[
                'password'=>password_hash($data['newpw'],PASSWORD_DEFAULT)
            ];
            //2,跟新数据库
            $res=$this->where("username='{$_SESSION["admin_username"]}'")->update($data);
            //1,如果相同提示用户修改成功返回主界面
            return ['code'=>1,'msg'=>'修改成功'];
//            (new Controller())->setRedirect(u('entry.index'))->message('修改成功');
        }else{
            //1,如果不相同提醒用户让他重新输入
            return ['code'=>0,'msg'=>'两次输入的修改密码不一样'];
//            (new Controller())->setRedirect()->message('两次输入的修改密码不一样');
        }


    }

}










