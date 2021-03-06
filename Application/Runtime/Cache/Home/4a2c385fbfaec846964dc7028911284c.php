<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp"/>

  <title>xbdcms - 登录</title>
  <link rel="stylesheet" href="/tp/Public/am2.1.0/css/amazeui.min.css">
</head>
<body>
<!--[if lte IE 9 ]><div class="am-alert am-alert-danger ie-warning" data-am-alert>
  <div class="am-container" style="font-size:18px;">提醒：你的浏览器太古董了，请使用IE9以上浏览器；360浏览器请使用极速模式！</div>
</div><![endif]-->
<div class="am-text-center" style="margin-top: 30px;font-size: 20px;">
    <img src="/tp/Public/img/logo196.png"/>
    <p>内容管理系统</p>
</div>
<hr>

<div class="am-g">
  <div class="am-u-lg-4 am-u-md-6 am-u-sm-centered">
    <form action="<?php echo U(login);?>" method="post" class="am-form">
      <label for="username" class="am-text-primary">员工编号:</label>
      <div class="am-form-group am-form-icon">
	      <i class="am-icon-user"></i>
	      <input type="text" class="am-form-field" name="username" id="username" placeholder="xbd+部门编号+身份证后4位">
      </div>

      <label for="password" class="am-text-primary">密码:</label>
      <div class="am-form-group am-form-icon">
	      <i class="am-icon-lock"></i>
      	  <input type="password" class="am-form-field" name="password" id="password" placeholder="请输入密码">
      </div>
      
      <label for="verify" class="am-text-primary">验证码:</label>
      <div class="am-form-group am-form-icon">
      	<div class="am-u-lg-8 am-u-md-8 am-u-sm-8" style="padding-left: 0;">
      		<i class="am-icon-pencil"></i>
      		<input type="text" class="am-form-field" name="verify" id="verify" placeholder="点击验证码可更换">
      	</div>
      	<img class="am-u-lg-4 am-u-md-4 am-u-sm-4" src="<?php echo U(verify,'','');?>" style="height: 43px;" onclick="change()" id="ver"/>
      </div>
      
      <div class="am-cf" style="height: 70px;line-height: 45px;">
      	<p id="sp1"  class="am-text-danger"></p>
      </div>
      
      <input type="submit" id="but1" value="登 录" class="am-btn am-btn-primary am-btn-block am-round">
    </form>
   <br>
    <hr>
    <p>© 2014 xunboda</p><p>Xunboda Content Management System</p>
  </div>
</div>

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/tp/Public/js/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<![endif]-->
	<script type="text/javascript" charset="utf-8">
			function change(){
				var v = document.getElementById('ver');
				var s = v.src + '/' + Math.random();
				v.src = s;
			}
			
//			ajax
			$(document)
	    	.ajaxStart(function(){
	    		$("button:submit").attr("disabled", true);
	    	})
	    	.ajaxStop(function(){
	    		$("button:submit").attr("disabled", false);
	    	});

	    	$("form").submit(function(){
	    		var self = $(this);
	    		$.post(self.attr("action"), self.serialize(), success, "json");
	    		return false;
	
	    		function success(data){
	    			if(data.status){
	    				window.location.href = data.url;
	    			} else {
	    				$("#sp1").text(data.info);
	    				//刷新验证码
	  					$("#ver").click();
	    			}
	    		}
	    	});
	</script>
</body>
</html>