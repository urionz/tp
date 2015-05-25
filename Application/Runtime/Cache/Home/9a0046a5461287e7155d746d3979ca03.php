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
<script type="text/javascript">
	$(document).ready(function(){
	$ajaxUrl="<?php echo U('Fhk/ajaxAction','','');?>?id=";
	$isModify="<?php echo ($isModify); ?>";
	_json='<?php echo ($_json); ?>';
	FkType='<?php echo ($lists[0][fk_type]); ?>';
});
</script>
<style type="text/css">
	table *{
		font-size: 10px;
		padding: 0px;
		text-align: center;
	}
</style>
<div class="admin-content" style="overflow:scroll;">
	<ol class="am-breadcrumb">
		<li><a href="<?php echo U('Fhk/index','','');?>">合同</a></li>
		<li class="am-active"><?php echo ($lists[0]["agree_num"]); ?></li>
	</ol>
	<table class="am-table am-table-striped am-table-bordered am-text-sm am-table-hover">
		<tr>
			<th colspan="16" class="top">合同放款明细--<button href="#" class="cmodify am-sm-btn am-btn-default am-radius">设置</button><button href="#" class="csave am-btn-sm am-btn-default" style="display:none">保存</button></th>
		</tr>
		<tr class="am-success">
			<th colspan="2">客户姓名</th>
			<th colspan="2">客户身份证号码</th>
			<th>业务员</th>
			<th>期限</th>
			<th>利率</th>
			<th colspan="2">放款金额</th>
			<th>放款类型</th>
			<th colspan="2">放款日期</th>
			<th colspan="2">还款方式</th>
			<th colspan="2">合同备注信息</th>
		</tr>
		<tr>
			<td colspan="2"><?php echo ($clients[0]['cname']); ?></td>
			<td colspan="2"><?php echo ($clients[0]['id_card']); ?></td>
			
			<?php if(is_array($userinfo)): $i = 0; $__LIST__ = $userinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$uinfo): $mod = ($i % 2 );++$i; if($uinfo['id'] == $lists[0]['saler']): ?><td title="<?php echo ($uinfo['id']); ?>"><?php echo ($uinfo['xingming']); ?></td><?php endif; endforeach; endif; else: echo "" ;endif; ?>

			<td><?php echo ($lists[0]["limit_time"]); ?></td>
			<td><?php echo round($lists[0]['rate']*100,2).'%';?></td>
			<td colspan="2"><?php echo number_format($lists[0]['fk_money'],2,'.',',');?></td>
			<td><?php if($lists[0][fk_type] == 1): ?>信用<?php elseif($lists[0][fk_type] == 2): ?>抵押<?php elseif($lists[0][fk_type] == 3): ?>担保<?php elseif($lists[0][fk_type] == 4): ?>其他<?php endif; ?></td>
			
			<td colspan="2"><?php echo (date('Y-m-d',$lists[0]["fk_date"])); ?></td>
			<td colspan="2"><?php echo ($lists[0]["hk_method"]); ?></td>
			<td colspan="2"><span title="<?php echo ($lists[0]["info"]); ?>"><?php echo SubTitle($lists[0]['info']);?></span></td>
		</tr>
		<tr class="hktable">
			<th colspan="16" class="top">合同应还款详情</th>
		</tr>
		<tr class="am-success">
			<th colspan="2">还款期数</th>
			<th colspan="3">还款日期</th>
			<th colspan="3">合同还款</th>
			<th colspan="3">合同还本</th>
			<th colspan="3">合同还息</th>
			<th colspan="2">操作</th>
		</tr>
		<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="hktable td">
			<td colspan="2"><?php echo ($vo["hk_term"]); ?></td>
			<td colspan="3"><?php echo (date('Y-m-d',$vo["hk_date"])); ?></td>
			<td colspan="3"><?php if(!empty($vo['agree_hk'])): echo number_format($vo['agree_hk'],2,'.',','); endif; ?></td>
			<td colspan="3"><?php if(!empty($vo['agree_hb'])): echo number_format($vo['agree_hb'],2,'.',','); endif; ?></td>
			<td colspan="3"><?php if(!empty($vo['agree_hx'])): echo number_format($vo['agree_hx'],2,'.',','); endif; ?></td>
			<td colspan="2"><button href="<?php echo ($lists[0]["agree_num"]); ?>" class="hkmodify am-sm-btn am-btn-default am-radius">修改</button><button href="<?php echo ($lists[0]["agree_num"]); ?>" class="hksave am-sm-btn am-btn-default am-radius" style="display:none">保存</button></td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr class="sktable">
			<th colspan="16" class="top">实际收款详情</th>
		</tr>
		<tr class="am-success">
			<th>收款期数</th>
			<th>提成金额</th>
			<th>还款状态</th>
			<th>距离还款</th>
			<th>状态详细</th>
			<th>收款编号</th>
			<th>结算金额</th>
			<th>实际还本</th>
			<th>实际还息</th>
			<th>收款日期</th>
			<th>坏账本金</th>
			<th>坏账利息</th>
			<th>提前去息</th>
			<th>违约金等</th>
			<th>逾期罚息</th>
			<th>操作</th>
		</tr>
		<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$svo): $mod = ($i % 2 );++$i;?><tr class="sktable td">
			<td><?php echo ($svo["receive_term"]); ?></td>
			<td><?php if(!empty($svo['tc_money'])): echo number_format($svo['tc_money'],2,'.',','); endif; ?></td>
			<td>
				<?php if(!empty($svo['receive_date'])): ?>已收
					<?php else: ?>
						<?php if(time() < $svo['hk_date']): ?>待收<?php endif; ?>
						<?php if(time() > $svo['hk_date']): ?>应收<?php endif; endif; ?>
			</td>
			<td>
				<?php if(!empty($svo['receive_date'])): echo floor(($svo[receive_date]-$svo['hk_date'])/(60*60*24));?>
					<?php elseif(empty($svo['receive_date'])): echo floor((time()-$svo['hk_date'])/(60*60*24)); endif; ?>
			</td>
			<td>
				<?php if(!empty($svo['receive_date'])): if(floor(($svo['receive_date']-$svo['hk_date'])/(60*60*24)) < -7): ?>提前还款
						<?php elseif((floor(($svo[receive_date]-$svo['hk_date'])/(60*60*24)) >= -7) and ((floor(($svo[receive_date]-$svo['hk_date'])/(60*60*24)) <= 7))): ?>正常收款
						<?php elseif(floor(($svo[receive_date]-$svo['hk_date'])/(60*60*24)) >= 7): ?>逾期收款<?php endif; ?>
				<?php else: ?>
					<?php if(time() < $svo['hk_date']): if(floor((time()-$svo['hk_date'])/(60*60*24)) < -365): ?>一年外到期
							<?php elseif((floor((time()-$svo['hk_date'])/(60*60*24)) >= -365) and ((floor((time()-$svo['hk_date'])/(60*60*24)) < -182))): ?>一年内到期
							<?php elseif((floor((time()-$svo['hk_date'])/(60*60*24)) >= -182) and ((floor((time()-$svo['hk_date'])/(60*60*24)) < -91))): ?>6个月内到期
							<?php elseif((floor((time()-$svo['hk_date'])/(60*60*24)) >= -91) and ((floor((time()-$svo['hk_date'])/(60*60*24)) < -30))): ?>3个月内到期
							<?php elseif((floor((time()-$svo['hk_date'])/(60*60*24)) >= -30) and ((floor((time()-$svo['hk_date'])/(60*60*24)) < -7))): ?>一个月内到期
							<?php elseif((floor((time()-$svo['hk_date'])/(60*60*24)) >= -7) and ((floor((time()-$svo['hk_date'])/(60*60*24)) < 0))): ?>即将到期<?php endif; endif; ?>
					<?php if(time() > $svo['hk_date']): if((floor((time()-$svo['hk_date'])/(60*60*24)) >= 0) and ((floor((time()-$svo['hk_date'])/(60*60*24)) <= 7))): ?>正常
							<?php elseif((floor((time()-$svo['hk_date'])/(60*60*24)) > 7) and ((floor((time()-$svo['hk_date'])/(60*60*24)) <= 30))): ?>逾期一个月
							<?php elseif((floor((time()-$svo['hk_date'])/(60*60*24)) >= 30) and ((floor((time()-$svo['hk_date'])/(60*60*24)) <= 91))): ?>逾期3个月
							<?php elseif(floor((time()-$svo['hk_date'])/(60*60*24)) > 91): ?>逾期3个月以上<?php endif; endif; endif; ?>
			</td>
			<td><?php echo ($svo["receive_num"]); ?></td>
			<td><?php if(!empty($svo['result_money'])): echo number_format($svo['result_money'],2,'.',','); endif; ?></td>
			<td><?php if(!empty($svo['fac_hb'])): echo number_format($svo['fac_hb'],2,'.',','); endif; ?></td>
			<td><?php if(!empty($svo['fac_hx'])): echo number_format($svo['fac_hx'],2,'.',','); endif; ?></td>
			<td><?php if(!empty($svo['receive_date'])): echo (date('Y-m-d',$svo["receive_date"])); endif; ?></td>
			<td><?php if(!empty($svo['hz_bj'])): echo number_format($svo['hz_bj'],2,'.',','); endif; ?></td>
			<td><?php if(!empty($svo['hzlx'])): echo number_format($svo['hzlx'],2,'.',','); endif; ?></td>
			<td><?php if(!empty($svo['tqhkqx'])): echo number_format($svo['tqhkqx'],2,'.',','); endif; ?></td>
			<td><?php if(!empty($svo['wyj'])): echo number_format($svo['wyj'],2,'.',','); endif; ?></td>
			<td>
				<?php if(!empty($svo['receive_date'])): if(!empty($svo['fx'])): echo number_format($svo['fx'],2,'.',','); endif; ?>
				<?php else: ?>
					<?php if(time() > $svo['hk_date']): if(floor((time()-$svo['hk_date'])/(60*60*24)) <= 15): echo number_format($svo['result_money']*0.04*floor((time()-$svo['hk_date'])/(60*60*24)),2,'.',',');?>
						<?php elseif(floor((time()-$svo['hk_date'])/(60*60*24)) > 15): ?>
							<?php echo number_format($svo['result_money']*0.05*floor((time()-$svo['hk_date'])/(60*60*24)),2,'.',','); endif; endif; endif; ?>
			</td>
			<td><?php if(!empty($svo['receive_date'])): ?><button href="<?php echo ($lists[0]["agree_num"]); ?>" class="skmodify am-sm-btn am-btn-default am-radius">修改</button><button href="<?php echo ($lists[0]["agree_num"]); ?>" class="sksave am-sm-btn am-btn-default am-radius" style="display:none">保存</button><?php else: ?>无可修改<?php endif; ?></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
</div>
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