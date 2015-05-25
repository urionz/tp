<?php if (!defined('THINK_PATH')) exit();?><!-- 贷款申请查看页面 -->
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="/tp/Public/css/dksq.css">
		<script type="text/javascript" src="/tp/Public/js/js.js"></script>
	</head>
	<body>
		<div id="chakan_header">
			<a href="<?php echo U('Dksq/index');?>"><img height="50px" src="/tp/Public/img/header.jpg" /></a>
		</div>
		<div id="chakan">
			<div id="top">
				<b>贷款申请表</b>
				<span class="sp1">贷款类型：<?php if($list["sqtype"] == 1 ): ?>薪金贷(无房产)
					<?php elseif($list["sqtype"] == 2 ): ?>薪金贷(有房产)
					<?php elseif($list["sqtype"] == 3 ): ?>企业贷(无房产)
					<?php elseif($list["sqtype"] == 4 ): ?>房易贷
					<?php elseif($list["sqtype"] == 5 ): ?>车易贷
					<?php elseif($list["sqtype"] == 6 ): ?>企业贷(有房产)<?php endif; ?></span>
				<span class="sp2">申请编号：<?php echo ($list["sqid"]); ?></span>
			</div>
			<div id="sqxx" class="mg_top">
				<table class="cktable">
					<tr>
						<td>申请额度：￥<?php echo ($list["sqje"]); ?></td>
						<td>贷款期限：<?php echo ($list["qixian"]); ?></td>
						<td>贷款用途：<?php echo ($list["yongtu"]); ?></td>
						<td>信息来源：<?php echo ($list["laiyuan"]); ?></td>
						<td>申请日期：<?php if($list["sqdate"] != 0): echo (date("Y年m月d日",$list["sqdate"])); endif; ?></td>
					</tr>
				</table>
			</div>
			<!-- 个人资料 -->
			<div id="grzl" class="mg_top">
				<table class="cktable">
					<tr><th colspan="6">个人资料</th></tr>
					<tr>
						<td rowspan="4">基</br>本</br>信</br>息</td>
						<td rowspan="2">姓名：<?php echo ($grzl["xingming"]); ?></td>
						<td rowspan="2">性别：<?php if($grzl["sex"] == 0): ?>男
									<?php elseif($grzl["sex"] == 1 ): ?>女<?php endif; ?>
						</td>
						<td rowspan="2">证件：<?php if($grzl["zjtype"] == 0 ): ?>身份证
								<?php elseif($grzl["zjtype"] == 1 ): ?>护照
								<?php elseif($grzl["zjtype"] == 2 ): ?>其他<?php endif; ?>（<?php echo ($grzl["zjhm"]); ?>）
						</td>
						<td colspan="2">出生日期：<?php if($grzl["csdate"] != 0): echo (date("Y年m月d日",$grzl["csdate"])); endif; ?></td>
					</tr>
					<tr>
						<td>户口所在地：<?php echo ($grzl["hukou"]); ?></td>
						<td>籍贯：<?php echo ($grzl["jiguan"]); ?></td>
					</tr>
					<tr>
						<td rowspan="2">年龄：<?php if($grzl["age"] != 0): echo ($grzl["age"]); endif; ?></td>
						<td rowspan="2">婚姻状况：<?php if($grzl["hyzk"] == 1 ): ?>未婚
								<?php elseif($grzl["hyzk"] == 2 ): ?>已婚
								<?php elseif($grzl["hyzk"] == 3 ): ?>离婚
								<?php elseif($grzl["hyzk"] == 4 ): ?>分居
								<?php elseif($grzl["hyzk"] == 5 ): ?>丧偶<?php endif; ?>
						</td>
						<td>社会保险卡电脑号：<?php echo ($grzl["sbhm"]); ?></td>
						<td colspan="2" rowspan="2">教育程度：<?php if($grzl["jycd"] == 1 ): ?>初中或以下
								<?php elseif($grzl["jycd"] == 2 ): ?>高中或中专
								<?php elseif($grzl["jycd"] == 3 ): ?>大专
								<?php elseif($grzl["jycd"] == 4 ): ?>本科或以上<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>武汉市居住证/暂住证：<?php echo ($grzl["jzz"]); ?></td>
					</tr>
					<!-- 住宅信息一 -->
					<?php if(is_array($zhuzai)): $i = 0; $__LIST__ = $zhuzai;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vozz): $mod = ($i % 2 );++$i;?><tr>
						<td rowspan="2">住</br>宅</br>
							<?php if($key == 0 ): ?>一
							<?php elseif($key == 1 ): ?>二<?php endif; ?>
						</td>
						<td colspan="3">住址：<?php echo ($vozz["adress"]); ?></td>
						<td>居住时间：<?php echo ($vozz["jzsj"]); ?></td>
						<td>与谁居住：<?php echo ($vozz["ysjz"]); ?></td>
					</tr>
					<tr>
						<td colspan="2">住宅电话：<?php echo ($vozz["zztel"]); ?></td>
						<td>移动电话：<?php echo ($vozz["phone"]); ?></td>
						<td>住宅类别：<?php if($vozz["zztype"] == 1): ?>自购
							<?php elseif($vozz["zztype"] == 2): ?>家族拥有
							<?php elseif($vozz["zztype"] == 3): ?>朋友拥有
							<?php elseif($vozz["zztype"] == 4): ?>自建
							<?php elseif($vozz["zztype"] == 5): ?>宿舍
							<?php elseif($vozz["zztype"] == 6): ?>租用<?php endif; ?>
						</td>
						<td>每月还款/租金：￥<?php echo ($vozz["myhk"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					<!-- 住宅信息结束 -->
					<tr>
						<td colspan="3">电邮地址：<?php echo ($grzl["email"]); ?></td>
						<td colspan="3">家庭是否知悉此项贷款：<?php if($grzl["zxdk"] == 1 ): ?>否
							<?php elseif($grzl["zxdk"] == 2 ): ?>是<?php endif; ?></td>
					</tr>
				</table>
			</div>
			
		<!-- 职业资料-->
			<div id="zyzl" class="mg_top">
				<table class="cktable">
					<tr><th colspan="6">职业资料/公司资料</th></tr>
					
					<?php if(is_array($danwei)): $i = 0; $__LIST__ = $danwei;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vodw): $mod = ($i % 2 );++$i;?><tr>
						<th rowspan="2">单</br>位</br>
							<?php if($key == 0 ): ?>一
							<?php elseif($key == 1 ): ?>二<?php endif; ?>
						</th>
						<td colspan="2">名称：<?php echo ($vodw["dwmc"]); ?></td>
						<td>性质：<?php echo ($vodw["dwxingzi"]); ?></td>
						<td>行业类别：<?php echo ($vodw["hylb"]); ?></td>
						<td>单位电话：<?php echo ($vodw["dwtel"]); ?></td>
					</tr>
					<tr>
						<td colspan="3">地址：<?php echo ($vodw["dwdz"]); ?></td>
						<td>邮编：<?php if($vodw["dwyb"] != 0): echo ($vodw["dwyb"]); endif; ?></td>
						<td>传真号码：<?php echo ($vodw["dwcz"]); ?></td>
					</tr>
					<tr>
						<td colspan="3">单位网址：<?php echo ($vodw["wangzhi"]); ?></td>
						<td>职务：<?php echo ($vodw["zhiwu"]); ?></td>
						<td>服务年数：<?php if($vodw["fwns"] != 0): echo ($vodw["fwns"]); endif; ?></td>
						<td>部门：<?php echo ($vodw["bumen"]); ?></td>
					</tr>
					<tr>
						<td colspan="3">每月收入：￥<?php echo ($vodw["mshouru"]); ?></td>
						<td colspan="2">每月支薪日：<?php if($vodw["mzxdate"] != 0): echo ($vodw["mzxdate"]); endif; ?></td>
						<td>支付方式：<?php echo ($vodw["zftype"]); ?></td>
					</tr>
					<tr><td colspan="6" style="text-align: center">补充资料（适用于个体经营者）</td></tr>
					<tr>
						<td colspan="3">个体经营类型：<?php echo ($vodw["gttype"]); ?></td>
						<td>工商登记号：<?php echo ($vodw["gongshangnum"]); ?></td>
						<td>经营场所：<?php echo ($vodw["jycs"]); ?></td>
						<td>月供/租金：￥<?php echo ($vodw["yuegong"]); ?></td>
					</tr>
					<tr>
						<td colspan="3">成立日期：<?php if($vodw["cldate"] != 0): echo (date("Y年m月d日",$vodw["cldate"])); endif; ?></td>
						<td>国/地税编号：<?php echo ($vodw["guoshuinum"]); ?></td>
						<td>雇员人数：<?php if($vodw["guyuan"] != 0): echo ($vodw["guyuan"]); endif; ?></td>
						<td>全年盈利：￥<?php echo ($vodw["yingli"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</table>
			</div>
			
			<!--房产资料-->
			<div id="fczl" class="mg_top">
				<table class="cktable">
					<tr><th colspan="6">房产资料</th></tr>
					<tr>
						<td colspan="3">房产地址：<?php echo ($fczl["fcdizhi"]); ?></td>
						<td>购买方式：<?php if($fczl["gmtype"] == 0 ): ?>一次性
							<?php elseif($fczl["gmtype"] == 1 ): ?>按揭<?php endif; ?></td>
						<td>购买日期：<?php if($fczl["gmdate"] != 0): echo (date("Y年m月d日",$fczl["gmdate"])); endif; ?></td>
						<td>面积：<?php echo ($fczl["mianji"]); ?></td>
					</tr>
					<tr>
						<td>按揭银行：<?php echo ($fczl["bank"]); ?></td>
						<td>购买价格：￥<?php echo ($fczl["goumai"]); ?></td>
						<td>贷款年限：<?php if($fczl["dknianxian"] != 0): echo ($fczl["dknianxian"]); endif; ?></td>
						<td>月供还款：￥<?php echo ($fczl["mhuankuan"]); ?></td>
						<td>贷款总额：￥<?php echo ($fczl["dkze"]); ?></td>
						<td>尚欠余额：￥<?php echo ($fczl["yue"]); ?></td>
					</tr>
				</table>
			</div>
			
			<!--配偶资料-->
			<div class="mg_top">
				<table class="cktable">
					<tr><th colspan="6">配偶资料</th></tr>
					<tr>
						<td>姓名：<?php echo ($grzl["matexm"]); ?></td>
						<td>年龄：<?php if($grzl["mateage"] != 0): echo ($grzl["mateage"]); endif; ?></td>
						<td>联络电话：<?php echo ($grzl["matephone"]); ?></td>
						<td>月收入：￥<?php echo ($grzl["matemsr"]); ?></td>
						<td>职位：<?php echo ($grzl["matezw"]); ?></td>
						<td>单位电话：<?php echo ($grzl["matedwtel"]); ?></td>
					</tr>
					<tr>
						<td colspan="2">单位名称：<?php echo ($grzl["matedw"]); ?></td>
						<td colspan="4">单位地址：<?php echo ($grzl["matedwdz"]); ?></td>
					</tr>
				</table>
			</div>
			
			<!--联系人资料-->
			<div id="zyzl" class="mg_top">
				<table class="cktable">
					<tr><th colspan="7">联系人资料</th></tr>
					
					<?php if(is_array($lxr)): $i = 0; $__LIST__ = $lxr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$volxr): $mod = ($i % 2 );++$i;?><tr>
						<th rowspan="2">
							<?php if($key == 0 ): ?>1
							<?php elseif($key == 1 ): ?>2
							<?php elseif($key == 2 ): ?>3<?php endif; ?>
						</th>
						<td>姓名：<?php echo ($volxr["nxname"]); ?></td>
						<td>年龄：<?php if($volxr["nxage"] != 0): echo ($volxr["nxage"]); endif; ?></td>
						<td>关系：<?php echo ($volxr["nxguanxi"]); ?></td>
						<td>移动电话：<?php echo ($volxr["nxphone"]); ?></td>
						<td>住宅电话：<?php echo ($volxr["nxzztel"]); ?></td>
						<td>单位电话：<?php echo ($volxr["nxdwtel"]); ?></td>
					</tr>
					<tr>
						<td colspan="3">住址：<?php echo ($volxr["nxzhuzhi"]); ?></td>
						<td colspan="2">单位名称：<?php echo ($volxr["nxdwmc"]); ?></td>
						<td>职务：<?php echo ($volxr["nxzhiwu"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</table>
			</div>
			
			
		</div>
	</body>
</html>