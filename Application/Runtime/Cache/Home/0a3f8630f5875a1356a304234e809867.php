<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="description" content="">
  	<meta name="keywords" content="">
 	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  	<meta name="renderer" content="webkit">
  	<meta http-equiv="Cache-Control" content="no-siteapp"/>
  		
	<script src="/tp/Public/js/jquery.min.js" type="text/javascript"></script>
	<script src="/tp/Public/am2.1.0/js/amazeui.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="/tp/Public/am2.1.0/css/amazeui.min.css">
	
	<link rel="stylesheet" type="text/css" href="/tp/Public/css/my.css"/>
	<title>迅泊达内容管理系统</title>
</head>

<body>
<!--[if lte IE 9 ]><div class="am-alert am-alert-danger ie-warning" data-am-alert>
  <div class="am-container" style="font-size:18px;">提醒：你的浏览器太古董了，请使用IE9以上浏览器；360浏览器请使用极速模式！</div>
</div><![endif]-->
<header class="am-topbar am-topbar-fixed-top">
	<div class="am-fl" style="line-height: 45px;margin:0 15px;">
      <img src="/tp/Public/img/xbd.png" style="height: 20px;"/>
    </div>
  <div class="am-collapse am-topbar-collapse" id="doc-topbar-collapse">
    <ul class="am-nav am-nav-pills am-topbar-nav">
      <li <?php if($daohang == index ): ?>class="am-active am-animation-shake"<?php endif; ?>><a href="<?php echo U('Index/index');?>"><span class="am-icon-home"></span>首页</a></li>
      <li <?php if($daohang == dksq ): ?>class="am-active am-animation-shake"<?php endif; ?>><a href="<?php echo U('Dksq/index');?>">贷款申请管理</a></li>
      <li <?php if($daohang == staff ): ?>class="am-active am-animation-shake"<?php endif; ?>><a href="<?php echo U('Staff/index');?>">员工信息管理</a></li>
      <li <?php if($daohang == borrow ): ?>class="am-active am-animation-shake"<?php endif; ?>><a href="<?php echo U('Borrow/index');?>">发标信息管理</a></li>
      <li <?php if($daohang == auth ): ?>class="am-active am-animation-shake"<?php endif; ?>><a href="<?php echo U('Auth/index');?>">权限管理</a></li>
      <li <?php if($daohang == fhk ): ?>class="am-active am-animation-shake"<?php endif; ?>><a href="<?php echo U('Fhk/index');?>">放还款管理</a></li>
    </ul>

    <div class="am-topbar-right am-margin-right-lg">
      <div class="am-dropdown" data-am-dropdown="{boundary: '.am-topbar'}">
        <button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle>
        	<?php echo ($user["xingming"]); ?> <span class="am-icon-caret-down"></span>
        </button>
        <ul class="am-dropdown-content">
          <li><a href="<?php echo U('User/Manage');?>">修改密码</a></li>
          <li><a href="<?php echo U('Login/tuichu');?>">退出</a></li>
        </ul>
      </div>
    </div>
    <div class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
    <div class="am-dropdown" data-am-dropdown="{boundary: '.am-topbar'}">
     <button class="am-btn am-btn-secondary am-topbar-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle>
          <span <?php if($MessageCount != 0): ?>class="am-icon-envelope-o"<?php endif; ?>></span> 站内信箱 </span><span class="am-icon-caret-down"></span>
     </button>
     <ul class="am-dropdown-content">
        <li>
          <a href="<?php echo U('User/getMail');?>" >收件信箱&nbsp;&nbsp;&nbsp;
            <?php if($MessageCount != 0): ?><span class="am-icon-envelope-o">+<?php echo ($MessageCount); ?></span><?php endif; ?>
          </a>
        </li>
        <li><a href="<?php echo U('User/postMail');?>">发件信箱</a></li>
        <li><a href="<?php echo U('User/MessageSend');?>">发送内信</a></li>
        <li><a href="<?php echo U('User/Message');?>">信息中心</a></li>
      </ul>
    </div>
    </div>
  </div>
</header>

<div data-am-widget="gotop" class="am-gotop am-gotop-fixed">
  <a href="#top" title="回到顶部">
    <span class="am-gotop-title">回到顶部</span>
    <i class="am-gotop-icon am-icon-chevron-up"></i>
  </a>
</div>
<div class="admin-sidebar">
<div class="am-panel am-panel-default">
<div class="am-panel-bd">
<!--首页-->
<?php if($daohang == index ): ?><p><span class="am-icon-bookmark"></span> 公告</p>
    <p>信泊四海 诚达天下</p>
<!--员工信息-->
<?php elseif($daohang == staff ): ?>
   <ul class="am-nav">
	<li <?php if($daohang2 == staff_index ): ?>class="am-active"<?php endif; ?>><a href="<?php echo U('Staff/index');?>">员工信息</a></li>
	<li><a href="<?php echo U('Staff/add');?>" class="am-text-warning am-margin-left-lg"><span class="am-icon-plus"></span>添加</a></li>
	<li class="am-nav-divider"></li>
	<li <?php if($daohang2 == staff_ulog ): ?>class="am-active"<?php endif; ?>><a href="<?php echo U('Staff/ulog');?>">操作日志</a></li>
   </ul>
<!--贷款申请-->
<?php elseif($daohang == dksq ): ?>
	<ul class="am-nav">
		<li <?php if($daohang2 == dksq_index ): ?>class="am-active"<?php endif; ?>>
			<a href="<?php echo U('Dksq/index');?>">贷款申请</a>
		</li>
		<li><a href="<?php echo U('Dksq/add');?>" class="am-text-warning am-margin-left-lg"><span class="am-icon-plus"></span>添加</a></li>
		<li><a href="<?php echo U('Dksq/match');?>" class="am-text-warning am-margin-left-lg"><span class="am-icon-search"></span>匹配</a></li>
		<li class="am-nav-divider"></li>
		<li <?php if($daohang2 == dksq_sqrlist ): ?>class="am-active"<?php endif; ?>>
			<a href="<?php echo U('Dksq/sqrlist');?>">申请人列表</a>
		</li>
    </ul>
<!--发标信息-->   
<?php elseif($daohang == borrow ): ?>
	<ul class="am-nav">
	<li class="am-active"><a href="<?php echo U('Borrow/index');?>">发标信息</a></li>
	<li><a href="<?php echo U('Borrow/Ecar');?>" class="am-text-warning am-margin-left-lg">车贷E通</a></li>
	<li><a href="<?php echo U('Borrow/tongji');?>" class="am-text-warning am-margin-left-lg">统计</a></li>
	<li class="am-nav-divider"></li>
   </ul>
   <div class="am-alert am-alert-secondary">
   	<p><span class="am-icon-bookmark"></span> 数据截止</p>
	<p class="am-text-warning"><?php echo (date("Y-m-d H:i",$maxScore)); ?></p>
	</div>
<!--权限管理-->
<?php elseif($daohang == auth ): ?>
	<ul class="am-nav">
	<li class="am-active"><a href="<?php echo U('Auth/index');?>">用户组</a></li>
	<li><a href="<?php echo U('Auth/groupAdd');?>" class="am-text-warning am-margin-left-lg"><span class="am-icon-plus"></span>添加</a></li>
	<li class="am-nav-divider"></li>
	
   </ul>

<?php elseif($daohang == fhk ): ?>
	<ul class="am-nav">
	<li <?php if($Items == index): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('Fhk/index');?>">合同列表</a></li>
	<li <?php if($Items == clientView): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('Fhk/clientView');?>">客户账款</a></li>
	<li <?php if($Items == DsList): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('Fhk/DsList');?>">待收清单</a></li>
	<li <?php if($Items == YsList): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('Fhk/YsList');?>">应收清单</a></li>
	<li <?php if($Items == AlreadyList): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('Fhk/AlreadyList');?>">已收清单</a></li>
	<li <?php if($Items == TcList ): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('Fhk/TcList');?>">提成统计</a></li>
	<li <?php if($Items == pre): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('Fhk/pre','','');?>">管理审核</a></li>
	<li class="am-nav-divider"></li>
	<li><a href="<?php echo U('Fhk/add');?>" class="am-text-warning am-margin-left-lg"><span class="am-icon-plus"></span>添加</a></li>
   </ul>
<?php elseif($daohang == Message): ?>
	<ul class="am-nav">
		<li <?php if($MessageItems == Message): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('User/Message','','');?>">信息中心</a></li>
		<li <?php if($MessageItems == MessageSend): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('User/MessageSend','','');?>">发送内信</a></li>
		<li <?php if($MessageItems == getMail): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('User/getMail','','');?>">收件信箱</a></li>
		<li <?php if($MessageItems == postMail): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('User/postMail','','');?>">发件信箱</a></li>
		<li <?php if($MessageItems == Manage): ?>class="am-active"<?php endif; ?> ><a href="<?php echo U('User/Manage','','');?>">设置中心</a></li>
	</ul><?php endif; ?>

</div>
</div>
</div>





<script type="text/javascript" src="/tp/Public/js/js.js"></script>
<script>
	$czmmurl="<?php echo U('Staff/czmm','','');?>?sq=";
</script>


<div class="admin-content">
	<ol class="am-breadcrumb">
		<li><a href="#">员工信息</a></li>
		<li class="am-active">列表</li>
	</ol>
	
	<table class="am-table am-table-bordered am-table-striped am-text-sm">
		<tr class="am-success">
			<th>员工编号</th>
			<th>姓名</th>
			<th>身份证号码</th>
			<th>部门</th>
			<th>在职状态</th>
			<th>入职日期</th>
			<th>离职日期</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td><?php echo ($vo["username"]); ?></td>
				<td><?php echo ($vo["xingming"]); ?></td>
				<td><?php echo ($vo["sfid"]); ?></td>
				<td><?php if($vo["bumeng"] == 1 ): ?>总经办
					<?php elseif($vo["bumeng"] == 2 ): ?>风控部
					<?php elseif($vo["bumeng"] == 3 ): ?>财务部
					<?php elseif($vo["bumeng"] == 4 ): ?>技术部
					<?php elseif($vo["bumeng"] == 5 ): ?>市场部
					<?php elseif($vo["bumeng"] == 6 ): ?>客服部<?php endif; ?>
				</td>
				<td><?php if($vo["status"] == 0 ): ?>在职
					<?php elseif($vo["status"] == 1 ): ?>离职
					<?php elseif($vo["status"] == 2 ): ?>试用期<?php endif; ?>
				</td>
				<td><?php echo (date("Y-m-d",$vo["rzdate"])); ?></td>
				<td><?php if($vo["lzdate"] == 0): ?>--
					<?php else: echo (date("Y-m-d",$vo["lzdate"])); endif; ?></td>
				<td style="text-align: center;">
					<a href="<?php echo U('Staff/add','','');?>?sq=<?php echo ($vo["id"]); ?>">修改</a>
					|<a href="#" onclick="firm($czmmurl,<?php echo ($vo["id"]); ?>,'重置密码')">重置密码</a>
					|[详细信息]：<a href="<?php echo U('Staff/info_add','','');?>?sq=<?php echo ($vo["id"]); ?>">添加/修改</a>
					|<a href="<?php echo U('Staff/ViewInfo','','');?>/sq/<?php echo ($vo["id"]); ?>">查看</a>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	<div class="fengye"><?php echo ($page); ?></div>
	

</div>
<div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
  <div class="am-modal-dialog">
    <div class="am-modal-bd">
      确认信息无误了吗？
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
      <span class="am-modal-btn" data-am-modal-confirm>确定</span>
    </div>
  </div>
</div>
<br>
<footer data-am-widget="footer" class="am-footer am-footer-default">
	<hr>
  <div class="am-footer-miscs ">
  	<p>迅泊达内容管理系统<br>
  		Xunboda Content Management System<br>
    CopyRight©2014 xunboda Inc. | 武汉迅泊达金融服务有限公司 | 信泊四海 诚达天下</p>
  </div>
</footer>

</body>
</html>