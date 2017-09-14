<?php
/**
 * 素材主界面
 */
include '../app/admin/view/common/header.php';
?>

<!--右侧主体区域部分 start-->
<div class="col-xs-12 col-sm-9 col-lg-10">
    <!-- TAB NAVIGATION -->
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#tab1" >素材列表</a></li>
        <li><a href="<?php echo u('add')?>" >素材添加</a></li>
    </ul>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">素材列表</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>素材编号</th>
                    <th>素材图片</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $v){?>
                    <tr>
                        <td><?php echo $v['mid']?></td>
                        <td>
                            <img style="width: 80px" src="<?php echo $v['mpath']?>" alt="">
                        </td>
                        <td><?php echo date('Y-m-d H:i:s',$v['mtime']) ?></td>
                        <td>
                            <div class="btn-group btn-group-xs">
                                <a href="javascript:;" onclick="del(<?php echo $v['mid']?>)" class="btn btn-danger">删除</a>
                            </div>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function del(mid){
            var url="<?php echo u('del')?>"+"mid="+mid;
            modal(url);
        }
    </script>

</div>

<?php include '../app/admin/view/common/footer.php'?>
