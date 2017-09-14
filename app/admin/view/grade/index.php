<?php
/**
 * 主页
 */
include '../app/admin/view/common/header.php';
?>
<!--右侧主体区域部分 start-->
<div class="col-xs-12 col-sm-9 col-lg-10">
    <!-- TAB NAVIGATION -->
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1" >班级列表</a></li>
        <li><a href="<?php echo u('add')?>" >班级添加</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">班级列表</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>班级编号</th>
                    <th>班级名称</th>
                    <th>操作</th>
                </tr>
                </thead>
<!--                --><?php //dd($data)?>
                <tbody>
                <?php foreach ($data as $v){?>
                    <tr>
                        <td><?php echo $v['gid']?></td>
                        <td><?php echo $v['gname']?></td>
                        <td>
                            <div class="btn-group btn-group-xs">
                                <a href="<?php echo u('edit',['gid'=>$v['gid']])?>" class="btn btn-primary">编辑</a>
                                <a href="javascript:;" onclick="del(<?php echo $v['gid']?>)" class="btn btn-danger">删除</a>
                            </div>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function del(gid){
//            if(confirm('确认删除吗')){
//                location.href = "<?php //echo u('del')?>//"+'&gid='+gid;
//            }
            var url="<?php echo u('del')?>"+"gid="+gid;
            //调用js里面的modal方法，这个js是自己写的，提示框模版
            modal(url);
        }
    </script>

</div>


<?php include '../app/admin/view/common/footer.php'?>
