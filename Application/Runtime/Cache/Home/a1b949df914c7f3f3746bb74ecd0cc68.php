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





<!--<link rel="stylesheet" type="text/css" href="/tp/Public/css/dksq.css">-->
<script type="text/javascript" src="/tp/Public/js/js.js"></script>
<script>
	$scurl="<?php echo U('Dksq/shanchu','','');?>?sq=";
	$prevurl="<?php echo U('Dksq/prev','','');?>/sq/";
</script>

<div class="admin-content">
	<ol class="am-breadcrumb">
		<li><a href="#">贷款申请</a></li>
		<li class="am-active">列表</li>
	</ol>
	
	<table class="am-table am-table-striped am-table-bordered am-text-sm ">
		<tr class="am-success" >
			<th>申请编号<a href="<?php echo U('Dksq/index','','');?>?order=sqid&stu=1"title="升序"><span class="am-icon-sort-amount-asc"></span></a>
				<a href="<?php echo U('Dksq/index','','');?>?order=sqid&stu=2"title="降序"><span class="am-icon-sort-amount-desc"></span></a>
			</th>
			<th>申请人</th>
			<th>类型</th>
			<th>申请额度</th>
			<th>贷款期限</th>
			<th>贷款用途</th>
			<!--<th>信息来源</th>-->
			<th>申请日期<a href="<?php echo U('Dksq/index','','');?>?order=sqdate&stu=1"title="升序"><span class="am-icon-sort-amount-asc"></span></a>
				<a href="<?php echo U('Dksq/index','','');?>?order=sqdate&stu=2"title="降序"><span class="am-icon-sort-amount-desc"></span></a>
			</th>
			<th>添加人</th>
			<th>添加时间</th>
			<th>还款情况</th>
			<th>审批结果</th>
			<th>审批额度</th>
			<th>审批期限</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
				<td><?php echo ($vo["sqid"]); ?></td>
				<td><?php echo ($vo["xingming"]); ?></td>
				<td><?php if($vo["sqtype"] == 1 ): ?>薪金贷(无房产)
					<?php elseif($vo["sqtype"] == 2 ): ?>薪金贷(有房产)
					<?php elseif($vo["sqtype"] == 3 ): ?>企业贷(无房产)
					<?php elseif($vo["sqtype"] == 4 ): ?>房易贷
					<?php elseif($vo["sqtype"] == 5 ): ?>车易贷
					<?php elseif($vo["sqtype"] == 6 ): ?>企业贷(有房产)<?php endif; ?>
				</td>
				<td><?php echo ($vo["sqje"]); ?></td>
				<td><?php echo ($vo["qixian"]); ?></td>
				<td><?php echo ($vo["yongtu"]); ?></td>
				<!--<td><?php echo ($vo["laiyuan"]); ?></td>-->
				<td><?php if($vo["sqdate"] == 0): ?>--<?php else: ?>
					<?php echo (date("Y-m-d",$vo["sqdate"])); endif; ?>
				</td>
				<td><?php echo ($vo["luruxingming"]); ?></td>
				<td><?php echo (date("Y-m-d H:i",$vo["lurutime"])); ?></td>
				<td>
					<?php if($vo["hkstatus"] == 0): ?>--
					<?php elseif($vo["hkstatus"] == 1): ?>正常
					<?php elseif($vo["hkstatus"] == 2): ?>逾期30天内
					<?php elseif($vo["hkstatus"] == 3): ?>逾期30-60天内
					<?php elseif($vo["hkstatus"] == 4): ?>逾期超过60天<?php endif; ?>
				</td>
				<td>
					<?php if($vo["result"] == 0): ?>待审批
						<?php elseif($vo["result"] == 1): ?>通过
						<?php else: ?>未通过<?php endif; ?>
				</td>
				<td>
					<?php if($vo["result"] == 1): echo ($vo["prevlimit"]); ?>(万)
					<?php elseif($vo["result"] == 0): ?>--
					<?php else: ?>--<?php endif; ?>
				</td>
				<td>
					<?php if($vo["result"] == 1): echo ($vo["pretime"]); ?>(月)
						<?php elseif($vo["result"] == 0): ?>--
						<?php else: ?>--<?php endif; ?>
				</td>
				<td>
                    <a href="<?php echo U('Dksq/chakan','','');?>?sq=<?php echo ($vo["id"]); ?>"><button class="am-btn am-btn-xs am-btn-default am-text-primary" title="查看"><span class="am-icon-file-text-o"></span></button></a>
                    <a href="<?php echo U('Dksq/add','','');?>?sq=<?php echo ($vo["id"]); ?>"><button class="am-btn am-btn-xs am-btn-default am-text-success" title="修改"><span class="am-icon-edit"></span></button></a>
                    <a href="#" onclick="firm($scurl,<?php echo ($vo["id"]); ?>,'删除')"><button class="am-btn am-btn-xs am-btn-default am-text-danger" title="删除"><span class="am-icon-trash-o"></span></button></a>
                    <!--<?php if($vo["result"] == 0): ?><a href="javascript:;" name="prevLink" id="prevLink" onclick="prev(<?php echo ($vo["id"]); ?>)"><button class="am-btn am-btn-xs am-btn-default am-text-secondary">审批</button></a><?php endif; ?>-->
                  	<?php if($vo["result"] == 0): ?><button class="am-btn am-btn-xs am-btn-default am-text-secondary myjs-daikuanshenpi" id="<?php echo ($vo["id"]); ?>">审批</button><?php endif; ?>
				</td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	<div class="fengye"><?php echo ($page); ?></div>
	
</div>

<div class="am-modal am-modal-prompt" tabindex="-1" id="my-prompt">
	<div class="am-modal-dialog">
	<div class="am-modal-hd am-text-success">贷款审批</div>
     <div class="am-modal-bd">
	   <p id="p123"></p>
	   <input type="text" class="am-modal-prompt-input" placeholder="审批额度(万)" id="input1">
	   <input type="text" class="am-modal-prompt-input" placeholder="审批期限(月)" id="input2">
		 <input type="radio" checked="checked" name="prevCheck" value="1" id="yescheck"/>通过
		 <input type="radio" name="prevCheck" value="2" id="nocheck"/>不通过
	 </div>
	 
	 <div class="am-modal-footer">
	      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
	      <span class="am-modal-btn" data-am-modal-confirm>提交</span>
	 </div>
	</div>
</div>

<script type="text/javascript">
$(function() {
	$("#nocheck").on('click',function() {
		$("#input1,#input2").attr("disabled","disabled");
	});
	$("#yescheck").on('click',function() {
		$("#input1,#input2").removeAttr("disabled");
	});
	
	
	
  $('.myjs-daikuanshenpi').on('click', function() {
  	var sqid = $(this).attr('id');//获取申请id
  	
  	var sqbianhao = $(this).parents("td").prevAll(":eq(12)").html();
  	var sqren = $(this).parents("td").prevAll(":eq(11)").html();
  	$("#p123").text(sqbianhao + '(' + sqren + ')');//申请编号+申请人
  	
  	$('#my-prompt').prepend('<input type="hidden" name="sqid" value="" id="qweeed">');
  	$("#qweeed").val(sqid);
  	
    $('#my-prompt').modal({
      relatedTarget: this,
      onConfirm: function(e) {
      	var sq = $("#qweeed").val();
      	var prevLimit = e.data[0];
      	var deadLine = e.data[1];
      	var checkValue = $("input[name='prevCheck']:checked").val();
      	if(checkValue!=2){
			if(prevLimit==''){
				alert('请设置审批额度!');
				return false;
			}
			else if(deadLine==''){
				alert('请设置审批期限!');
				return false;
			}
		}
			$.post($prevurl+sq,{prevLimit:prevLimit,checkValue:checkValue,deadLine:deadLine},function(data){
				var sqid=data.sqid;
				var prevLimit=data.prevlimit;
				var deadLine=data.pretime;
				var result=data.result;
				var hkstatus=data.hkstatus;
				var status=data.status;
				
				var spqx=data.spqx;//审批权限
				if(spqx == 0){
					alert("无审批权限");
					$(this).modal('close');
				}
				
				if(status)
				{
					if(result==1)
					{
						$('td:contains('+sqid+')').nextAll(":eq(9)").html("通过");
						$('td:contains('+sqid+')').nextAll(":eq(10)").html(prevLimit+"(万)");
						$('td:contains('+sqid+')').nextAll(":eq(11)").html(deadLine+"(月)");
						$('td:contains('+sqid+')').nextAll().children(":eq(3)").hide();
					}
					if(result==2)
					{
						$('td:contains('+sqid+')').nextAll(":eq(9)").html("未通过");
						$('td:contains('+sqid+')').nextAll().children(":eq(3)").hide();
					}
					$(this).modal('close');
				}
				else{
					$(this).modal('close');
				}
				
			});
			
      },
     
    });
    
  });
  
//Confirm 关闭后移除暂存的实例，再次调用时重新初始化
  $('#my-prompt').on('closed.modal.amui', function() {
  	$(this).removeData('am.modal');
  });
});
</script>

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