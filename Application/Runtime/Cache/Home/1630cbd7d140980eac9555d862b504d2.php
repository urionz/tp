<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="/xbdcms/Public/css/login.css"/>
		<script src="/xbdcms/Public/js/jquery-1.11.0.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="/xbdcms/Public/js/check.js"></script>
		<title>审批</title>	
	</head>
	<div id="prevPage">
		<form method="post" name="prevForm" action="" class="prevForm">
		<em>设置审批额度:</em><input type="text" name="prevLimit" class="text1" autofocus="autofocus" placeholder="请填写数字(万)"/><br />
		<em>设置期限　　:</em><input type="text" name="deadLine" class="text1" placeholder="设置期限" /><br />
							<em>通过</em> <input type="radio" checked="checked" name="prevCheck" class="prevCheck" value="1"/> <em>不通过 </em>	 <input type="radio" name="prevCheck" class="prevCheck" value="2" />
					<input type="submit" id="but1" value="设置"/>
		</form>
	</div>
</html>