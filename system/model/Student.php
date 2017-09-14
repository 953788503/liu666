<?php
/**
 * 学生管理模块
 */

namespace system\model;

use houdunwang\model\Model;

class Student extends Model {
    /**
     * 学生管理的添加功能
     * @param $data传过来的用户提交的数据
     * @return array返回一个含有提示信息的数组
     */
    public function add($data){
        //1,判断用户填入的数据是否为空
        //2,如果是返回return，下面代码不再执行，因为不能往数据库存入空数据
        if (!trim($data['sname'])) return ['code'=>0,'msg'=>'请输入姓名'];
        if (!isset($data['ssex'])) return ['code'=>0,'msg'=>'请选择性别'];
        if (!isset($data['mid'])) return ['code'=>0,'msg'=>'请选择头像'];
        if (!trim($data['sage'])) return ['code'=>0,'msg'=>'请输入年龄'];
        if (!$data['gid']) return ['code'=>0,'msg'=>'请选择班级'];
        //1,走到这里，说明用户在学生列表中填写了数据
        //2,开始将用户填写的数据写入到数据库中
        $this->insert($data);
        //1，添加成功后返回数据提示用户添加成功
        return ['code'=>1,'msg'=>'添加成功'];
    }

    public function edit($data,$sid){
        //1,判断用户填入的数据是否为空
        //2,如果是返回return，下面代码不再执行，因为不能往数据库存入空数据
        if (!trim($data['sname'])) return ['code'=>0,'msg'=>'请输入姓名'];
        if (!isset($data['ssex'])) return ['code'=>0,'msg'=>'请选择性别'];
        if (!isset($data['mid'])) return ['code'=>0,'msg'=>'请选择头像'];
        if (!trim($data['sage'])) return ['code'=>0,'msg'=>'请输入年龄'];
        if (!trim($data['gid'])) return ['code'=>0,'msg'=>'请选择班级'];
        //1,走到这里，说明用户在学生列表中填写了数据
        //2,开始将用户填写的数据写入到数据库中
        $this->where("sid={$sid}")->update($data);
        //1，添加成功后返回数据提示用户添加成功
        return ['code'=>1,'msg'=>'修改成功'];
    }

}
