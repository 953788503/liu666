<?php
/**
 * 登陆界面
 */
?>
<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
    <meta charset="utf-8" />
    <title>Notebook | Web Application</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="./static/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="./static/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="./static/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="./static/css/font.css" type="text/css" />
    <link rel="stylesheet" href="./static/css/app.css" type="text/css" />
</head>
<body class="">
<section id="content" class="m-t-lg wrapper-md animated fadeInDown">
    <div class="container aside-xxl">
        <a class="navbar-brand block" href="http://wubin.pro" target="_blank">武斌博客后台登录</a>
        <section class="panel panel-default m-t-lg bg-white">
            <header class="panel-heading text-center">
                <h4>登录</h4>
            </header>
            <form action="" class="panel-body wrapper-lg" method="post">
                <div class="form-group">
                    <label class="control-label">帐号</label>
                    <input type="text" placeholder="请输入登录帐号" name="admin_username" class="form-control input-lg">
                </div>

                <div class="form-group">
                    <label class="control-label">密码</label>
                    <input type="password" name="admin_password" placeholder="请输入登录密码" class="form-control input-lg">
                </div>

                <div class="form-group" style="overflow: hidden">
                    <label class="control-label">验证码</label>
                    <div>
                        <input type="text" name="captcha" placeholder="请输入验证码" class="form-control input-lg" style="width: 50%;float: left">
                        <img onclick="this.src=this.src+'&'+Math.random()" src="<?php echo '?s=admin/login/captcha'?>" alt="" style="width: 45%;float: right">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">登录</button>
                <div class="line line-dashed"></div>
                <p class="text-muted text-center alert alert-danger" style="margin-bottom: 0"><small>用户名或者密码不正确</small></p>
            </form>
        </section>
    </div>
</section>
<!-- footer -->
<footer id="footer">
    <div class="text-center padder clearfix">
        <p>
            <small>超人：wubin.mail@foxmail.com<br>&copy; 2017</small>
        </p>
    </div>
</footer>
<!-- / footer -->
<script src="./static/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="./static/js/bootstrap.js"></script>
<!-- App -->
<script src="./static/js/app.js"></script>
<script src="./static/js/slimscroll/jquery.slimscroll.min.js"></script>
<script src="./static/js/app.plugin.js"></script>
</body>
</html>
