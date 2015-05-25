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

<link rel="stylesheet" type="text/css" href="/xbdcms/Public/css/date.css"/>
<script src="/xbdcms/Public/js/date.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="/xbdcms/Public/css/dksq.css">
<div id="index">
	<form action="<?php echo U("Staff/addAction");?>" method="post">
		姓　　名：<input type="text" name="xingming" value="<?php echo ($list["xingming"]); ?>" /><br>
		身份证号：<input type="text" name="sfid" value="<?php echo ($list["sfid"]); ?>" /><br>
		部　　门：<select name="bumeng">
					<option value="05" <?php if($list["bumeng"] == 5): ?>selected="selected"<?php endif; ?>>市场部</option>
					<option value="01" <?php if($list["bumeng"] == 1): ?>selected="selected"<?php endif; ?>>总经办</option>
					<option value="02" <?php if($list["bumeng"] == 2): ?>selected="selected"<?php endif; ?>>风控部</option>
					<option value="03" <?php if($list["bumeng"] == 3): ?>selected="selected"<?php endif; ?>>财务部</option>
					<option value="04" <?php if($list["bumeng"] == 4): ?>selected="selected"<?php endif; ?>>技术部</option>
					<option value="06" <?php if($list["bumeng"] == 6): ?>selected="selected"<?php endif; ?>>客服部</option>
				</select><br>
		在职状态：<select name="status">
					<option value="2" <?php if($list["status"] == 2): ?>selected="selected"<?php endif; ?>>试用期</option>
					<option value="0" <?php if($list["status"] == 0): ?>selected="selected"<?php endif; ?>>在职</option>
					<option value="1" <?php if($list["status"] == 1): ?>selected="selected"<?php endif; ?>>离职</option>
				</select><br>
		入职日期：<input name="rzdate" type="text" value="<?php if($list["rzdate"] != 0): echo (date("Y-m-d",$list["rzdate"])); endif; ?>" 
		readonly onClick="showcalendar(event,this);" onFocus="showcalendar(event, this);if(this.value=='0000-00-00')this.value=''">
		<br>
		离职日期：<input name="lzdate" type="text" value="<?php if($list["lzdate"] != 0): echo (date("Y-m-d",$list["lzdate"])); endif; ?>" 
		readonly onClick="showcalendar(event,this);" onFocus="showcalendar(event, this);if(this.value=='0000-00-00')this.value=''">
		<br>
		<input type="hidden" name="id" value="<?php echo ($list["id"]); ?>" />
		<input type="submit" value="<?php if($list["id"] == null): ?>添加<?php else: ?>修改<?php endif; ?>"/>
	</form>
</div>