<?php
namespace system\model;


//1，加载到houdunwang\model目录里面的Model类
//2,以他为跳板访问到与他同目录同命名空间下Base类
//3,通过aseB类里面的方法实现对数据库的增删改查
use houdunwang\model\Model;
//继承Model这个类后里面的方法可以拿到自己这里来使用
class Article extends Model{

}