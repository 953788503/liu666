<?php
/**
 * 添加素材页面
 */
include '../app/admin/view/common/header.php';
?>
<!--右侧主体区域部分 start-->
<div class="col-xs-12 col-sm-9 col-lg-10">
    <!-- TAB NAVIGATION -->
    <!-- TAB NAVIGATION -->
    <ul class="nav nav-tabs" role="tablist">
        <li ><a href="<?php echo u('index')?>" >素材列表</a></li>
        <li class="active"><a href="<?php echo u('add')?>" >素材添加</a></li>
    </ul>
    <form action="" method="POST" class="form-horizontal" enctype="multipart/form-data">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">素材添加</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">上传素材</label>
                    <div class="col-sm-3">
                        <input type="file" class="form-control" name="mpath" >
                    </div>
                </div>

            </div>
        </div>
        <button class="btn btn-primary">提交</button>
    </form>


</div>

<?php include '../app/admin/view/common/footer.php'?>
