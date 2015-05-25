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
<div id='match'>
<font color="red">匹配条件</font>
<div class="">
	<form action="<?php echo U('Dksq/match_grzl');?>" method="post" ccept-charset="utf-8">
		姓名：<input type="text" name="xingming" value=""/>
	证件号码：<input type="text" name="zjhm" value="" />
	<br><br>
	住宅地址：<input type="text" style="width:350px;" name="adress" value="" />
	住宅电话：<input type="text" name="zztel" value="" />
	移动电话：<input type="text" name="phone" value="" />
	<br><br>
	单位名称：<input type="text" name="dwmc" value="" />
	单位地址：<input type="text" style="width:350px;" name="dwdz" value="" />
	单位电话：<input type="text" name="dwtel" value="" />
	<br><br>
	房产地址：<input type="text" style="width:350px;" name="fcdizhi" value="" />
	<br><br>
	<fieldset>
    	<legend>配偶信息</legend>
    	姓名：<input type="text" name="matexm" value="" />		
		联络电话：<input type="text" name="matephone" value="" />
		单位电话：<input type="text" name="matedwtel" value="" /><br>
		单位名称：<input type="text" name="matedw" value="" />
		单位地址：<input type="text" style="width:350px;" name="matedwdz" value="" />
    </fieldset>
	<br>
	<fieldset>
    	<legend>联系人信息</legend>
		姓名：<input type="text" name="nxname" value="" />
		住宅电话：<input type="text" name="nxzztel" value="" />
		移动电话：<input type="text" name="nxphone" value="" />
		单位电话：<input type="text" name="nxdwtel" value="" /><br>
		住址：<input type="text" style="width:350px;" name="nxzhuzhi" value="" />
		单位名称：<input type="text" name="nxdwmc" value="" />
	</fieldset>
	<br>
	<button type="submit">匹配</button>
	</form>
	
</div>
<div class="ppjg">
	<font color="red">匹配结果</font>
	<p id="p11"></p>
	<p id="p12"></p>
	<p id="p21"></p>
	<p id="p22"></p>
	<p id="p23"></p>
	<p id="p31"></p>
	<p id="p32"></p>
	<p id="p33"></p>
	<p id="p41"></p>
	<p id="p51"></p>
	<p id="p52"></p>
	<p id="p53"></p>
	<p id="p54"></p>
	<p id="p55"></p>
	<p id="p61"></p>
	<p id="p62"></p>
	<p id="p63"></p>
	<p id="p64"></p>
	<p id="p65"></p>
	<p id="p66"></p>
</div>
<script>
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
			myjgxs(data['xm'],"#p11","姓名：");
	    	myjgxs(data['hm'],"#p12","证件号码：");
	    	
	    	myjgxs(data['adress'],"#p21","住宅地址：");
	    	myjgxs(data['zztel'],"#p22","住宅电话：");
	    	myjgxs(data['phone'],"#p23","移动电话：");
	    	
	    	myjgxs(data['dwmc'],"#p31","单位名称：");
	    	myjgxs(data['dwdz'],"#p32","单位地址：");
	    	myjgxs(data['dwtel'],"#p33","单位电话：");
	    	
	    	myjgxs(data['fcdizhi'],"#p41","房产地址：");
	    	
	    	myjgxs(data['matexm'],"#p51","配偶-姓名：");
	    	myjgxs(data['matephone'],"#p52","配偶-电话：");
	    	myjgxs(data['matedwtel'],"#p53","配偶-单位电话：");
	    	myjgxs(data['matedw'],"#p54","配偶-单位：");
	    	myjgxs(data['matedwdz'],"#p55","配偶-单位地址：");
	    	
	    	myjgxs(data['nxname'],"#p61","联系人-姓名：");
	    	myjgxs(data['nxzztel'],"#p62","联系人-住宅电话：");
	    	myjgxs(data['nxphone'],"#p63","联系人-移动电话：");
	    	myjgxs(data['nxdwtel'],"#p64","联系人-单位电话：");
	    	myjgxs(data['nxzhuzhi'],"#p65","联系人-住址：");
	    	myjgxs(data['nxdwmc'],"#p66","联系人-单位：");
	    	
	    }
		/*
		 * ajax返回信息的处理方法
		 */
		function myjgxs(dkey,pid,ptext){
			if(dkey != null){
	    		var len = eval(dkey).length;
	    		$(pid).text(ptext+"["+len+"]");
	    		for(var i=0;i<len;i++){
	    			var strhref = '<?php echo U('Dksq/chakan','','');?>' + '?sq=' + dkey[i].id;
	    			var str = '　' + '<a href="' + strhref +'" target="_blank">' + dkey[i].sqid + '</a>';
	    			$(pid).append(str);
	    		}
	    	}else{
	    		$(pid).text(ptext+"[0]");
	    	}
		}
	});
	
</script>
</div>