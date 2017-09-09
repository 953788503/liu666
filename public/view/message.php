<?php
/**
 * 友情提示
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>友情提示</title>
    <link rel="stylesheet" href="./static/bs3/css/bootstrap.min.css">
</head>
<body style="background: #eeeeee">
<div class="jumbotron" style="text-align:center;margin-top: 200px">
	<div class="container">
		<h1><?php echo $message;?></h1>
		<p>
<!--            因为默认的是js代码，所以这里a标签里面要写javascript:;-->
            <a href="javascript:<?php echo $this->url;?>;">
                <span id="time">3</span>秒之后自动跳转，如果没有跳转请点击这里...
            </a>
        </p>
		<p>
			<a class="btn btn-primary btn-lg">About Me</a>
		</p>
	</div>
</div>
<script>

//    设置定时器
    var a=setInterval(function(){
        var time = document.getElementById('time');
        time.innerHTML = time.innerHTML - 1;
    },1000);
//    设置炸弹定时器，3秒后清除定时器a
    setTimeout(function(){
//        php后面需要加一个分号跟下面的代码分隔开,不然会报错
        <?php echo $this->url; ?>;
        clearInterval(a);
    },3000);
</script>
</body>
</html>






