<?php
/**
 * 班级处理模块
 */
namespace system\model;

use houdunwang\model\Model;
//1，因为要进行数据库的操作就需要通过Model类与可以对数据库进行增删改差的Base类打交道
//2，所以在这里我们继承Model这个类
class Grade extends Model {

    /**
     * 添加班级名
     * @param $data传过来的用来添加到数据库的班级名字
     * @return array返回添加是否成功
     */
    public function add($data){
        //1,测试传过来的数据
//        dd($data);
        //1,判断传过来的班级名是否为空
        if (!trim($data['gname'])) return ['code'=>0,'msg'=>'班级名称不能为空'];
        //2,测试班级名称是否重复
        //3,返回符合条件的数组，如果没有返回空数组
        $gradeData = $this->where("gname='{$data['gname']}'")->getAll();
        ;
        //4,判断是否为空数组
        if ($gradeData) return ['code'=>0,'msg'=>'该班级名称已存在,请勿重复添加'];
        //5,执行添加
        //6,将满足条件的班级名字写入数据库
        $this->insert($data);
        return ['code'=>1,'msg'=>'添加成功'];

    }

    /**
     * @param $data存有要修改的数据的数组
     * @param $gid要修改的那个班级名的主键值
     * @return array返回是否修改成功和提示信息
     */
    public function edit($data,$gid){
        //1,判断传过来的班级名是否为空
        if (!trim($data['gname'])) return ['code'=>0,'msg'=>'班级名称不能为空'];
        //2,测试班级名称是否重复
        //3,返回符合条件的数组，如果没有返回空数组
        //4,在这里判断时需要抛出自己本身
        $gradeData = $this->where("gname='{$data['gname']}' and gid!={$gid}")->getAll();
        //4,判断是否为空数组
        if ($gradeData) return ['code'=>0,'msg'=>'该班级名称已存在,请勿重复添加'];
        //5,执行添加
        //6,将满足条件的班级名字跟新如数据库
        //7,他会返回对数据库更新了几条数据
        $res=$this->where("gid={$gid}")->update($data);
        if ($res){
            return ['code'=>1,'msg'=>'更新成功'];
        }else{
            return ['code'=>0,'msg'=>'数据未更新'];
        }

    }
}


