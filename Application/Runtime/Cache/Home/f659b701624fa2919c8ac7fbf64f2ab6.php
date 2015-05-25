<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<script src="/xbdcms/Public/js/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="/xbdcms/Public/css/header.css"/>
		<title>迅泊达</title>
		<script type="text/javascript" charset="utf-8">
			$(function(){
				$('#bm').mouseover(function(){
					$('#grzx').show();
				});
				$('#grzx').mouseleave(function(){
					$(this).hide();
				});
			});
		</script>
	</head>
	<body>
		<div id="top">
			<div id="header">
				<div id="xbd">
					<a href="<?php echo U('Index/index');?>">迅泊达</a>
				</div>
				<div id="bm">
					<?php echo ($user["xingming"]); ?>
					[<?php if($user["bumeng"] == 1 ): ?>总经办
					<?php elseif($user["bumeng"] == 2 ): ?>风控部
					<?php elseif($user["bumeng"] == 3 ): ?>财务部
					<?php elseif($user["bumeng"] == 4 ): ?>技术部
					<?php elseif($user["bumeng"] == 5 ): ?>市场部
					<?php elseif($user["bumeng"] == 6 ): ?>客服部<?php endif; ?>]
				</div>
				<div id="grzx">
					<a href="<?php echo U('Login/changePsw');?>">修改密码</a><br>
					<a href="<?php echo U('Login/tuichu');?>">退出</a>
				</div>
			</div>
		</div>
		
		<div id="daohang">
			<div id="cda">
				<div id="cda_ul">
					<a class="ul_a" href="<?php echo U('Index/index');?>"><font <?php if($daohang == index ): ?>color="#FC8936"<?php endif; ?>>首页</font></a>
					<a class="ul_a" href="<?php echo U('Dksq/index');?>"><font <?php if($daohang == dksq ): ?>color="#FC8936"<?php endif; ?>>贷款申请</font></a>
					<a class="ul_a" href="#">发标信息</a>
					<a class="ul_a" href="<?php echo U('Staff/index');?>"><font <?php if($daohang == staff ): ?>color="#FC8936"<?php endif; ?>>员工信息</font></a>
					<a class="ul_a" href="#">XXXX</a>
				</div>
			</div>
		</div>
	</body>
</html>

<link rel="stylesheet" type="text/css" href="/xbdcms/Public/css/dksq.css">
<div id="index">
	<form action="<?php echo U("Login/changeAction");?>" method="post">
		原　密　码：<input type="password" name="oldpsw" value="" /><br>
		新　密　码：<input type="password" name="newpsw1" value="" /><br>
		新密码确认：<input type="password" name="newpsw2" value="" /><br>
		<input type="submit" value="修改"/>
	</form>
</div>