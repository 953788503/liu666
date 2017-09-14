<?php
/**
 * 进入界面
 */
include '../app/admin/view/common/header.php';
?>

        <!--右侧主体区域部分 start-->
        <div class="col-xs-12 col-sm-9 col-lg-10">
            <!-- TAB NAVIGATION -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#tab1" role="tab" data-toggle="tab">欢迎页面</a></li>
            </ul>
            <div class="alert alert-info">
                欢迎使用XX后台管理系统，这里可以项目介绍...
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>事件</th>
                            <th>描述</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>项目负责人</td>
                            <td>我是超人</td>
                        </tr>
                        <tr>
                            <td>使用框架</td>
                            <td>thinkphp5</td>
                        </tr>
                        <tr>
                            <td>服务器环境</td>
                            <td>apache</td>
                        </tr>
                        <tr>
                            <td>联系邮箱</td>
                            <td>wubin.mail@foxmail.com</td>
                        </tr>
                        <tr>
                            <td>qq</td>
                            <td>290646986</td>
                        </tr>
                        <tr>
                            <td>开发周期</td>
                            <td>30天</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--右侧主体区域部分结束 end-->
    <?php include "../app/admin/view/common/footer.php";?>
