<?php
/**
 * 跟素材数据库交互的模块
 */
namespace system\model;
use houdunwang\model\Model;
//因为要访问数据库所以要继承Model类
class Material extends Model {

    public function add(){
        //1,将他转换为一维数组
        //2,为了方便验证
        $file= current($_FILES);
        //1,用来查看上传的信息
//        dd($file);die();
        //1,根据上传信息中的error判断是否上传文件
        //2,如果error==4说明没有上传图片
        if ($file['error']==4) return ['code'=>0,'msg'=>'没有上传文件'];
        //3,如果error==3说明没有上传图片只上传了一半，没有上传成功
        if ($file['error']==3) return ['code'=>0,'msg'=>'文件上传失败'];
        //4,如果error==2或1说明没有上传图片过大
        if ($file['error']==2 || $file['error']==1) return ['code'=>0,'msg'=>'上传文件过大'];
        //1,调用上传方法，返回是否上传成功
        $res=$this->upload();
        //1,测试查看返回值
//        dd($res);die();
        //1,根据返回数组中的code判断是否上传成功
        if(!$res['code']) return ['code'=>0,'msg'=>$res['msg'][0]];
        //1,开始创建往数据库中添加的数组
        $data=[
            'mpath'=>$res['path'],
            'mtime'=>time()
        ];

//        dd($data);die();
        //1，开始往数据库中添加文件
        //2,调用base方法中的insert方法，向数据库中添加数据
        $this->insert($data);
        //返回提示
        return ['code'=>1,'msg'=>'添加成功'];
    }

    public function upload()
    {
        //1,先创建好要创建的目录
        //2,方便下面直接通过这个变量来创建目录
        $dir = 'uploads/' . date( 'y/m/d' );
        //1,查看创建的目录属否合格
//        dd($dir);die();
        //1,判断是否有$dir目录如果没有创建这个目录
        is_dir($dir) || mkdir($dir,0777,true);

        $storage = new  \ Upload \ Storage \ FileSystem( $dir );
        $file = new  \ Upload \ File( 'mpath' , $storage );
        //可选地，您可以在上传文件上重命名
        $new_filename = uniqid();
        $file -> setName( $new_filename );
        //验证文件上传
        $file -> addValidations( array(
                //确保文件的类型为“image / png“ new \ Upload \ Validation \ Mimetype（ ' image / png '），
                //您还可以添加多个mimetype验证
//                new \ Upload \ Validation \ Mimetype( array( 'image / png' , 'image / gif' ) ) ,

                //确保文件不大于5M（使用“B”，“K”，M“或”G“）
                new \Upload\Validation\Size( '5M'))
        );

        //访问有关上传文件的数据
        $data = array(
            'name' => $file -> getNameWithExtension() ,
            'extension' => $file -> getExtension() ,
//            'mime' => $file -> getMimetype() ,
            'size' => $file -> getSize() ,
//            'md5' => $file -> getMd5() ,
//            'dimensions' => $file -> getDimensions()
        );
//        dd($data);
        // Try to upload file
        try {
            // Success!
            $file->upload();
            return ['code'=>1,'msg'=>'添加成功','path'=>$dir .'/'. $data['name']];
        } catch (\Exception $e) {
            // Fail!
            $errors = $file->getErrors();
            return ['code'=>0,'msg'=>$errors];
        }
    }
}

