<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<script src="/tp/Public/js/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
		<link rel="stylesheet" type="text/css" href="/tp/Public/css/header.css"/>
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

<link rel="stylesheet" type="text/css" href="/tp/Public/css/dksq.css">
<link rel="stylesheet" type="text/css" href="/tp/Public/css/date.css"/>
<script src="/tp/Public/js/date.js" type="text/javascript" charset="utf-8"></script>

<div id="add">
<form action="<?php echo U('Dksq/addAction');?>" method="post" accept-charset="utf-8">
	<div class="leir">
		<div class="list">
		基本信息
		</div>
		<div class="lr">
			<table border="0" cellspacing="7" width="1000px;">
				<tr>
					<td><font color="red">申请编号：</font><input type="text" name="sqid" value="<?php echo ($list["sqid"]); ?>" /></td>
					<td>贷款类型：<select name="sqtype">
									<option value="">请选择</option>
									<option value="1" <?php if($list["sqtype"] == 1): ?>selected="selected"<?php endif; ?>>薪金贷(无房产)</option>
									<option value="2" <?php if($list["sqtype"] == 2): ?>selected="selected"<?php endif; ?>>薪金贷(有房产)</option>
									<option value="3" <?php if($list["sqtype"] == 3): ?>selected="selected"<?php endif; ?>>企业贷(无房产)</option>
									<option value="6" <?php if($list["sqtype"] == 6): ?>selected="selected"<?php endif; ?>>企业贷(有房产)</option>
									<option value="4" <?php if($list["sqtype"] == 4): ?>selected="selected"<?php endif; ?>>房易贷</option>
									<option value="5" <?php if($list["sqtype"] == 5): ?>selected="selected"<?php endif; ?>>车易贷</option>
								</select>
					</td>
					<td></td>
				</tr>
				<tr>
					<td>申请额度：<input type="text" name="sqje" value="<?php echo ($list["sqje"]); ?>" /></td>
					<td>贷款期限：<input type="text" name="qixian" value="<?php echo ($list["qixian"]); ?>" /></td>
					<td>贷款用途：<input type="text" list="url_list" name="yongtu" value="<?php echo ($list["yongtu"]); ?>" />
						<datalist id="url_list">
							<option value="短期拆借" />
							<option value="资金周转" />
						</datalist>
					</td>
				</tr>
				<tr>
					<td>信息来源：<input type="text" name="laiyuan" value="<?php echo ($list["laiyuan"]); ?>" /></td>
					<td>申请日期：<input name="sqdate" type="text" value="<?php if($list["sqdate"] != 0): echo (date("Y年m月d日",$list["sqdate"])); endif; ?>" 
						readonly onClick="showcalendar(event,this);" 
						onFocus="showcalendar(event, this);if(this.value=='0000-00-00')this.value=''">
					</td>
					<td>
						还款情况：
						<select name="hkstatus">	
							<option value="0" <?php if(($list["hkstatus"]) == "0"): ?>selected="selected"<?php endif; ?> >--</option>
							<option value="1" <?php if(($list["hkstatus"]) == "1"): ?>selected="selected"<?php endif; ?> >正常</option>
							<option value="2" <?php if(($list["hkstatus"]) == "2"): ?>selected="selected"<?php endif; ?> >逾期30天内</option>
							<option value="3" <?php if(($list["hkstatus"]) == "3"): ?>selected="selected"<?php endif; ?> >逾期30-60天内</option>
							<option value="4" <?php if(($list["hkstatus"]) == "4"): ?>selected="selected"<?php endif; ?> >逾期超过60天</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
	
	<div class="leir">
		<div class="list">
			个人资料
		</div>
		<div class="lr">
			<table border="0" cellspacing="7" width="1000px;">
				<tr>
					<td><font color="red">姓名：</font><input type="text" name="xingming" value="<?php echo ($grzl["xingming"]); ?>" /></td>
					<td>性别：<input type="radio" <?php if($grzl["sex"] == 0): ?>checked="checked"<?php endif; ?> name="sex" value="0" />男
							<input type="radio" name="sex" <?php if($grzl["sex"] == 1): ?>checked="checked"<?php endif; ?> value="1" />女
					</td>
					<td>年龄：<input type="text" name="age" value="<?php echo ($grzl["age"]); ?>" /></td>	
					<td>出生日期：<input name="csdate" type="text" value="<?php if($grzl["csdate"] != 0): echo (date("Y年m月d日",$grzl["csdate"])); endif; ?>" readonly onClick="showcalendar(event,this);" 
						onFocus="showcalendar(event, this);if(this.value=='0000-00-00')this.value=''"></td>
				</tr>
				<tr>
					<td colspan="2"><font color="red">证件类型和号码：</font><select name="zjtype">
									<option value="0" <?php if($grzl["zjtype"] == 0): ?>selected="selected"<?php endif; ?>>身份证</option>
									<option value="1" <?php if($grzl["zjtype"] == 1): ?>selected="selected"<?php endif; ?>>护照</option>
									<option value="2" <?php if($grzl["zjtype"] == 2): ?>selected="selected"<?php endif; ?>>其他</option>
									</select>
						<!-- 证件号码 -->
						<?php if($list["id"] == null): ?><input type="text" name="zjhm" value="" />
							<?php else: ?><input type="hidden" name="zjhm" value="<?php echo ($grzl["zjhm"]); ?>" /><?php echo ($grzl["zjhm"]); endif; ?>
						
					</td>
					
					<td colspan="2">
						  婚姻状况：<input type="radio" name="hyzk" <?php if($grzl["hyzk"] == 1): ?>checked="checked"<?php endif; ?> value="1" />未婚
									<input type="radio" name="hyzk" <?php if($grzl["hyzk"] == 2): ?>checked="checked"<?php endif; ?> value="2" />已婚
									<input type="radio" name="hyzk" <?php if($grzl["hyzk"] == 3): ?>checked="checked"<?php endif; ?> value="3" />离婚
									<input type="radio" name="hyzk" <?php if($grzl["hyzk"] == 4): ?>checked="checked"<?php endif; ?> value="4" />分居
									<input type="radio" name="hyzk" <?php if($grzl["hyzk"] == 5): ?>checked="checked"<?php endif; ?> value="5" />丧偶	
					</td>
				</tr>
				<tr>
					<td colspan="2">E-mail:<input type="email" name="email" value="<?php echo ($grzl["email"]); ?>" /></td>
					<td colspan="2">教育程度：<input type="radio" name="jycd" <?php if($grzl["jycd"] == 1): ?>checked="checked"<?php endif; ?> value="1" />初中或以上
									<input type="radio" name="jycd" <?php if($grzl["jycd"] == 2): ?>checked="checked"<?php endif; ?> value="2" />高中或中专
									<input type="radio" name="jycd" <?php if($grzl["jycd"] == 3): ?>checked="checked"<?php endif; ?> value="3" />大专
									<input type="radio" name="jycd" <?php if($grzl["jycd"] == 4): ?>checked="checked"<?php endif; ?> value="4" />本科或以上
					</td>
				</tr>
				<tr>
					<td>社保号：<input type="text" name="sbhm" value="<?php echo ($grzl["sbhm"]); ?>" /></td>
					<td>居住证/暂住证：<input type="text" name="jzz" value="<?php echo ($grzl["jzz"]); ?>" /></td>
					<td>户口所在地：<input type="text" name="hukou" value="<?php echo ($grzl["hukou"]); ?>" /></td>
					<td>籍贯：<input type="text" name="jiguan" value="<?php echo ($grzl["jiguan"]); ?>" /></td>
				</tr>
				<tr>
					<td colspan="4">家庭是否知悉此项贷款：
						<input type="radio" name="zxdk" <?php if($grzl["zxdk"] == 1): ?>checked="checked"<?php endif; ?> value="1" />否
						<input type="radio" name="zxdk" <?php if($grzl["zxdk"] == 2): ?>checked="checked"<?php endif; ?> value="2" />是
					</td>
				</tr>
			</table>
		</div>

		<div class="fengexian"></div>

		<div class="lr">
			<fieldset>
				<input type="hidden" name="zhuzaiid_1" value="<?php echo ($zhuzai[0]["id"]); ?>" />
    				<legend>住宅一</legend>
				<table border="0" cellspacing="7" width="1000px;">
					<tr>
						<td colspan="2">
							<font color="red">住宅地址：</font>
							<input type="text" style="width:497px;" name="adress_1" value="<?php echo ($zhuzai[0]["adress"]); ?>" />
						</td>
						<td>居住时间：<input type="text" name="jzsj_1" value="<?php echo ($zhuzai[0]["jzsj"]); ?>" /></td>
					</tr>
					<tr>
						<td>住宅电话：<input type="text" name="zztel_1" value="<?php echo ($zhuzai[0]["zztel"]); ?>" /></td>
						<td>移动电话：<input type="text" name="phone_1" value="<?php echo ($zhuzai[0]["phone"]); ?>" /></td>
						<td>与谁居住：<input type="text" list="ysjz_list" name="ysjz_1" value="<?php echo ($zhuzai[0]["ysjz"]); ?>" />
										<datalist id="ysjz_list">
											<option value="独居" />
											<option value="父母" />
											<option value="兄弟/姐妹" />
											<option value="同事" />
											<option value="配偶" />
											<option value="子女" />
										</datalist>
						</td>
					</tr>
					<tr>
						<td colspan="3">住宅类别：<input type="radio" name="zztype_1" <?php if($zhuzai[0][zztype] == 1): ?>checked="checked"<?php endif; ?> value="1" />自购
										<input type="radio" name="zztype_1" <?php if($zhuzai[0][zztype] == 2): ?>checked="checked"<?php endif; ?> value="2" />家族拥有
										<input type="radio" name="zztype_1" <?php if($zhuzai[0][zztype] == 3): ?>checked="checked"<?php endif; ?> value="3" />朋友拥有
										<input type="radio" name="zztype_1" <?php if($zhuzai[0][zztype] == 4): ?>checked="checked"<?php endif; ?> value="4" />自建
										<input type="radio" name="zztype_1" <?php if($zhuzai[0][zztype] == 5): ?>checked="checked"<?php endif; ?> value="5" />宿舍
										<input type="radio" name="zztype_1" <?php if($zhuzai[0][zztype] == 6): ?>checked="checked"<?php endif; ?> value="6" />租用
						　　　每月还款/租金：<input type="text" name="myhk_1" value="<?php echo ($zhuzai[0]["myhk"]); ?>" />
						</td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<input type="hidden" name="zhuzaiid_2" value="<?php echo ($zhuzai[1]["id"]); ?>" />
    				<legend>住宅二</legend>
				<table border="0" cellspacing="7" width="1000px;">
					<tr>
						<td colspan="2">
							住宅地址：<input type="text" style="width:497px;" name="adress_2" value="<?php echo ($zhuzai[1]["adress"]); ?>" />
						</td>
						<td>居住时间：<input type="text" name="jzsj_2" value="<?php echo ($zhuzai[1]["jzsj"]); ?>" /></td>
					</tr>
					<tr>
						<td>住宅电话：<input type="text" name="zztel_2" value="<?php echo ($zhuzai[1]["zztel"]); ?>" /></td>
						<td>移动电话：<input type="text" name="phone_2" value="<?php echo ($zhuzai[1]["phone"]); ?>" /></td>
						<td>与谁居住：<input type="text" list="ysjz_list" name="ysjz_2" value="<?php echo ($zhuzai[1]["ysjz"]); ?>" />
										<datalist id="ysjz_list">
											<option value="独居" />
											<option value="父母" />
											<option value="兄弟/姐妹" />
											<option value="同事" />
											<option value="配偶" />
											<option value="子女" />
										</datalist>
						</td>
					</tr>
					<tr>
						<td colspan="3">住宅类别：<input type="radio" name="zztype_2" <?php if($zhuzai[1][zztype] == 1): ?>checked="checked"<?php endif; ?> value="1" />自购
										<input type="radio" name="zztype_2" <?php if($zhuzai[1][zztype] == 2): ?>checked="checked"<?php endif; ?> value="2" />家族拥有
										<input type="radio" name="zztype_2" <?php if($zhuzai[1][zztype] == 3): ?>checked="checked"<?php endif; ?> value="3" />朋友拥有
										<input type="radio" name="zztype_2" <?php if($zhuzai[1][zztype] == 4): ?>checked="checked"<?php endif; ?> value="4" />自建
										<input type="radio" name="zztype_2" <?php if($zhuzai[1][zztype] == 5): ?>checked="checked"<?php endif; ?> value="5" />宿舍
										<input type="radio" name="zztype_2" <?php if($zhuzai[1][zztype] == 6): ?>checked="checked"<?php endif; ?> value="6" />租用
						　　　每月还款/租金：<input type="text" name="myhk_2" value="<?php echo ($zhuzai[1]["myhk"]); ?>" />
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
	</div>

	<div class="leir">
		<div class="list">
		职业资料/公司资料
		</div>
		<div class="lr">
			<fieldset>
				<input type="hidden" name="zyzlid_1" value="<?php echo ($danwei[0]["id"]); ?>" />
    				<legend>单位一</legend>
				<table border="0" cellspacing="7" width="1000px;">
					<tr>
						<td>单位名称：<input type="text" name="dwmc_1" value="<?php echo ($danwei[0]["dwmc"]); ?>" /></td>
						<td>邮编：<input type="text" name="dwyb_1" value="<?php echo ($danwei[0]["dwyb"]); ?>" /></td>
						<td>单位性质：<input type="text" list="dwxz_list" name="dwxingzi_1" value="<?php echo ($danwei[0]["dwxingzi"]); ?>" />
											<datalist id="dwxz_list">
												<option value="政府机构" />
												<option value="民营" />
												<option value="私营" />
												<option value="三资企业" />
												<option value="国有企业" />
												<option value="个体" />
											</datalist>
						</td>
					</tr>
					<tr>
						<td colspan="2">单位地址：<input type="text" style="width:497px;" name="dwdz_1" value="<?php echo ($danwei[0]["dwdz"]); ?>" /></td>
						<td>单位电话：<input type="text" name="dwtel_1" value="<?php echo ($danwei[0]["dwtel"]); ?>" /></td>
					</tr>
					<tr>
						<td>传真号码：<input type="text" name="dwcz_1" value="<?php echo ($danwei[0]["dwcz"]); ?>" /></td>
						<td>单位网址：<input type="text" name="wangzhi_1" value="<?php echo ($danwei[0]["wangzhi"]); ?>" /></td>
						<td>行业类别：<input type="text" name="hylb_1" value="<?php echo ($danwei[0]["hylb"]); ?>" /></td>
					</tr>
					<tr>
						<td>职务：<input type="text" name="zhiwu_1" value="<?php echo ($danwei[0]["zhiwu"]); ?>" /></td>
						<td>服务年数：<input type="text" name="fwns_1" value="<?php echo ($danwei[0]["fwns"]); ?>" /></td>
						<td>部门：<input type="text" name="bumen_1" value="<?php echo ($danwei[0]["bumen"]); ?>" /></td>
					</tr>
					<tr>
						<td>每月收入：<input type="text" name="mshouru_1" value="<?php echo ($danwei[0]["mshouru"]); ?>" /></td>
						<td>每月支薪日：<input type="number" name="mzxdate_1" value="<?php echo ($danwei[0]["mzxdate"]); ?>" /></td>
						<td>支付方式：<input type="text" name="zftype_1" list="zffs_list" value="<?php echo ($danwei[0]["zftype"]); ?>" />
							<datalist id="zffs_list">
												<option value="现金" />
												<option value="打卡" />
												<option value="现金及打卡" />
											</datalist>
						</td>
					</tr>
					<tr>
						<td colspan="3" style="text-align:center;color:#919EAB">补充资料（适用于个体经营者）<div class="fengexian"></div>
						</td>
					</tr>
					<tr>
						<td>个体经营类型：<input type="text" name="gttype_1" list="jylx_list" value="<?php echo ($danwei[0]["gttype"]); ?>" />
							<datalist id="jylx_list">
												<option value="有限责任" />
												<option value="个人独资" />
												<option value="个体工商户" />
											</datalist>
						</td>
						<td>工商登记号：<input type="text" name="gongshangnum_1" value="<?php echo ($danwei[0]["gongshangnum"]); ?>" /></td>
						<td>成立日期：<input name="cldate_1" type="text" value="<?php if($danwei[0][cldate] != 0): echo (date("Y年m月d日",$danwei[0][cldate])); endif; ?>" readonly 
							onClick="showcalendar(event,this);" 
						onFocus="showcalendar(event, this);if(this.value=='0000-00-00')this.value=''"></td>
					</tr>
					<tr>
						<td>国/地税编号：<input type="text" name="guoshuinum_1" value="<?php echo ($danwei[0]["guoshuinum"]); ?>" /></td>
						<td>雇员人数：<input type="text" name="guyuan_1" value="<?php echo ($danwei[0]["guyuan"]); ?>" /></td>
						<td>全年盈利：<input type="text" name="yingli_1" value="<?php echo ($danwei[0]["yingli"]); ?>" /></td>
					</tr>
					<tr>
						<td>经营场所：<select name="jycs_1">
										<option value="">--</option>
										<option <?php if($danwei[0][jycs] == '自有'): ?>selected="selected"<?php endif; ?> value="自有">自有</option>
										<option <?php if($danwei[0][jycs] == '租用'): ?>selected="selected"<?php endif; ?> value="租用">租用</option>
										<option <?php if($danwei[0][jycs] == '按揭'): ?>selected="selected"<?php endif; ?> value="按揭">按揭</option>
									</select>
						</td>
						<td>月供/租金：<input type="text" name="yuegong_1" value="<?php echo ($danwei[0]["yuegong"]); ?>" /></td>
					</tr>
				</table>
    			</fieldset>
    			<fieldset>
    				<input type="hidden" name="zyzlid_2" value="<?php echo ($danwei[1]["id"]); ?>" />
    				<legend>单位二</legend>
				<table border="0" cellspacing="7" width="1000px;">
					<tr>
						<td>单位名称：<input type="text" name="dwmc_2" value="<?php echo ($danwei[1]["dwmc"]); ?>" /></td>
						<td>邮编：<input type="text" name="dwyb_2" value="<?php echo ($danwei[1]["dwyb"]); ?>" /></td>
						<td>单位性质：<input type="text" list="dwxz_list" name="dwxingzi_2" value="<?php echo ($danwei[1]["dwxingzi"]); ?>" />
											<datalist id="dwxz_list">
												<option value="政府机构" />
												<option value="民营" />
												<option value="私营" />
												<option value="三资企业" />
												<option value="国有企业" />
												<option value="个体" />
											</datalist>
						</td>
					</tr>
					<tr>
						<td colspan="2">单位地址：<input type="text" style="width:497px;" name="dwdz_2" value="<?php echo ($danwei[1]["dwdz"]); ?>" /></td>
						<td>单位电话：<input type="text" name="dwtel_2" value="<?php echo ($danwei[1]["dwtel"]); ?>" /></td>
					</tr>
					<tr>
						<td>传真号码：<input type="text" name="dwcz_2" value="<?php echo ($danwei[1]["dwcz"]); ?>" /></td>
						<td>单位网址：<input type="text" name="wangzhi_2" value="<?php echo ($danwei[1]["wangzhi"]); ?>" /></td>
						<td>行业类别：<input type="text" name="hylb_2" value="<?php echo ($danwei[1]["hylb"]); ?>" /></td>
					</tr>
					<tr>
						<td>职务：<input type="text" name="zhiwu_2" value="<?php echo ($danwei[1]["zhiwu"]); ?>" /></td>
						<td>服务年数：<input type="text" name="fwns_2" value="<?php echo ($danwei[1]["fwns"]); ?>" /></td>
						<td>部门：<input type="text" name="bumen_2" value="<?php echo ($danwei[1]["bumen"]); ?>" /></td>
					</tr>
					<tr>
						<td>每月收入：<input type="text" name="mshouru_2" value="<?php echo ($danwei[1]["mshouru"]); ?>" /></td>
						<td>每月支薪日：<input type="number" name="mzxdate_2" value="<?php echo ($danwei[1]["mzxdate"]); ?>" /></td>
						<td>支付方式：<input type="text" name="zftype_2" list="zffs_list" value="<?php echo ($danwei[1]["zftype"]); ?>" /></td>
					</tr>
					<tr>
						<td colspan="3" style="text-align:center;color:#919EAB">补充资料（适用于个体经营者）<div class="fengexian"></div>
						</td>
					</tr>
					<tr>
						<td>个体经营类型：<input type="text" name="gttype_2" list="jylx_list" value="<?php echo ($danwei[1]["gttype"]); ?>" /></td>
						<td>工商登记号：<input type="text" name="gongshangnum_2" value="<?php echo ($danwei[1]["gongshangnum"]); ?>" /></td>
						<td>成立日期：<input name="cldate_2" type="text" value="<?php if($danwei[1][cldate] != 0): echo (date("Y年m月d日",$danwei[0][cldate])); endif; ?>" 
							readonly onClick="showcalendar(event,this);" 
						onFocus="showcalendar(event, this);if(this.value=='0000-00-00')this.value=''"></td>
					</tr>
					<tr>
						<td>国/地税编号：<input type="text" name="guoshuinum_2" value="<?php echo ($danwei[1]["guoshuinum"]); ?>" /></td>
						<td>雇员人数：<input type="text" name="guyuan_2" value="<?php echo ($danwei[1]["guyuan"]); ?>" /></td>
						<td>全年盈利：<input type="text" name="yingli_2" value="<?php echo ($danwei[1]["yingli"]); ?>" /></td>
					</tr>
					<tr>
						<td>经营场所：<select name="jycs_2">
										<option value="">--</option>
										<option <?php if($danwei[1][jycs] == '自有'): ?>selected="selected"<?php endif; ?> value="自有">自有</option>
										<option <?php if($danwei[2][jycs] == '租用'): ?>selected="selected"<?php endif; ?> value="租用">租用</option>
										<option <?php if($danwei[3][jycs] == '按揭'): ?>selected="selected"<?php endif; ?> value="按揭">按揭</option>
									</select>
						</td>
						<td>月供/租金：<input type="text" name="yuegong_2" value="<?php echo ($danwei[1]["yuegong"]); ?>" /></td>
					</tr>
				</table>
    			</fieldset>
		</div>
	</div>

	<div class="leir">
		<div class="list">
		房产资料
		</div>
		<div class="lr">
			<table border="0" cellspacing="7" width="1000px;">
				<tr>
					<td colspan="2">房产地址：<input type="text" style="width:497px;" name="fcdizhi" value="<?php echo ($fczl["fcdizhi"]); ?>" /></td>
					<td>购买方式：<select name="gmtype">
										<option value="">请选择</option>
										<option <?php if($fczl["gmtype"] == 0): ?>selected="selected"<?php endif; ?> value="0">一次性</option>
										<option <?php if($fczl["gmtype"] == 1): ?>selected="selected"<?php endif; ?> value="1">按揭</option>
									</select>
					</td>
				</tr>
				<tr>
					<td>购买日期：<input name="gmdate" type="text" value="<?php if($fczl["gmdate"] != 0): echo (date("Y年m月d日",$fczl["gmdate"])); endif; ?>" readonly 
						onClick="showcalendar(event,this);" 
						onFocus="showcalendar(event, this);if(this.value=='0000-00-00')this.value=''"></td>
					<td>面积：<input type="text" name="mianji" value="<?php echo ($fczl["mianji"]); ?>" /></td>
					<td>按揭银行：<input type="text" name="bank" value="<?php echo ($fczl["bank"]); ?>" /></td>
				</tr>
				<tr>
					<td>购买价格：<input type="text" name="goumai" value="<?php echo ($fczl["goumai"]); ?>" /></td>
					<td>贷款年限：<input type="text" name="dknianxian" value="<?php echo ($fczl["dknianxian"]); ?>" />年</td>
					<td>月供还款：<input type="text" name="mhuankuan" value="<?php echo ($fczl["mhuankuan"]); ?>" /></td>
				</tr>
				<tr>
					<td>贷款总额：<input type="text" name="dkze" value="<?php echo ($fczl["dkze"]); ?>" /></td>
					<td>尚欠余额：<input type="text" name="yue" value="<?php echo ($fczl["yue"]); ?>" /></td>
					<td></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="leir">
		<div class="list">
		配偶资料
		</div>
		<div class="lr">
			<table border="0" cellspacing="7" width="1000px;">
				<tr>
					<td>姓名：<input type="text" name="matexm" value="<?php echo ($grzl["matexm"]); ?>" /></td>
					<td>年龄：<input type="text" name="mateage" value="<?php echo ($grzl["mateage"]); ?>" /></td>
					<td>联络电话：<input type="text" name="matephone" value="<?php echo ($grzl["matephone"]); ?>" /></td>
				</tr>
				<tr>
					<td >单位名称：<input type="text" name="matedw" value="<?php echo ($grzl["matedw"]); ?>" /></td>
					<td>月收入：<input type="text" name="matemsr" value="<?php echo ($grzl["matemsr"]); ?>" /></td>
					<td>职位：<input type="text" name="matezw" value="<?php echo ($grzl["matezw"]); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2">单位地址：<input type="text" style="width:497px;" name="matedwdz" value="<?php echo ($grzl["matedwdz"]); ?>" /></td>
					<td>单位电话：<input type="text" name="matedwtel" value="<?php echo ($grzl["matedwtel"]); ?>" /></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="leir">
		<div class="list">
		联系人资料
		</div>
		<div class="lr">
			<fieldset>
				<input type="hidden" name="lxrid_1" value="<?php echo ($lxr[0]["id"]); ?>" />
    				<legend>联系人一</legend>
				<table border="0" cellspacing="7" width="1000px;">
				<tr>
					<td>姓名：<input type="text" name="nxname_1" value="<?php echo ($lxr[0]["nxname"]); ?>" /></td>
					<td>关系：<input type="text" name="nxguanxi_1" value="<?php echo ($lxr[0]["nxguanxi"]); ?>" /></td>
					<td>年龄：<input type="text" name="nxage_1" value="<?php echo ($lxr[0]["nxage"]); ?>" /></td>
				</tr>
				<tr>
					<td >住宅电话：<input type="text" name="nxzztel_1" value="<?php echo ($lxr[0]["nxzztel"]); ?>" /></td>
					<td>移动电话：<input type="text" name="nxphone_1" value="<?php echo ($lxr[0]["nxphone"]); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2">住址：<input type="text" style="width:497px;" name="nxzhuzhi_1" value="<?php echo ($lxr[0]["nxzhuzhi"]); ?>" /></td>
					<td></td>
				</tr>
				<tr>
					<td >单位名称：<input type="text" name="nxdwmc_1" value="<?php echo ($lxr[0]["nxdwmc"]); ?>" /></td>
					<td>职务：<input type="text" name="nxzhiwu_1" value="<?php echo ($lxr[0]["nxzhiwu"]); ?>" /></td>
					<td>单位电话：<input type="text" name="nxdwtel_1" value="<?php echo ($lxr[0]["nxdwtel"]); ?>" /></td>
				</tr>
			</table>
			</fieldset>

			<fieldset>
				<input type="hidden" name="lxrid_2" value="<?php echo ($lxr[1]["id"]); ?>" />
    				<legend>联系人二</legend>
				<table border="0" cellspacing="7" width="1000px;">
				<tr>
					<td>姓名：<input type="text" name="nxname_2" value="<?php echo ($lxr[1]["nxname"]); ?>" /></td>
					<td>关系：<input type="text" name="nxguanxi_2" value="<?php echo ($lxr[1]["nxguanxi"]); ?>" /></td>
					<td>年龄：<input type="text" name="nxage_2" value="<?php echo ($lxr[1]["nxage"]); ?>" /></td>
				</tr>
				<tr>
					<td >住宅电话：<input type="text" name="nxzztel_2" value="<?php echo ($lxr[1]["nxzztel"]); ?>" /></td>
					<td>移动电话：<input type="text" name="nxphone_2" value="<?php echo ($lxr[1]["nxphone"]); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2">住址：<input type="text" style="width:497px;" name="nxzhuzhi_2" value="<?php echo ($lxr[1]["nxzhuzhi"]); ?>" /></td>
					<td></td>
				</tr>
				<tr>
					<td >单位名称：<input type="text" name="nxdwmc_2" value="<?php echo ($lxr[1]["nxdwmc"]); ?>" /></td>
					<td>职务：<input type="text" name="nxzhiwu_2" value="<?php echo ($lxr[1]["nxzhiwu"]); ?>" /></td>
					<td>单位电话：<input type="text" name="nxdwtel_2" value="<?php echo ($lxr[1]["nxdwtel"]); ?>" /></td>
				</tr>
			</table>
			</fieldset>

			<fieldset>
				<input type="hidden" name="lxrid_3" value="<?php echo ($lxr[2]["id"]); ?>" />
    				<legend>联系人三</legend>
				<table border="0" cellspacing="7" width="1000px;">
				<tr>
					<td>姓名：<input type="text" name="nxname_3" value="<?php echo ($lxr[2]["nxname"]); ?>" /></td>
					<td>关系：<input type="text" name="nxguanxi_3" value="<?php echo ($lxr[2]["nxguanxi"]); ?>" /></td>
					<td>年龄：<input type="text" name="nxage_3" value="<?php echo ($lxr[2]["nxage"]); ?>" /></td>
				</tr>
				<tr>
					<td >住宅电话：<input type="text" name="nxzztel_3" value="<?php echo ($lxr[2]["nxzztel"]); ?>" /></td>
					<td>移动电话：<input type="text" name="nxphone_3" value="<?php echo ($lxr[2]["nxphone"]); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2">住址：<input type="text" style="width:497px;" name="nxzhuzhi_3" value="<?php echo ($lxr[2]["nxzhuzhi"]); ?>" /></td>
					<td></td>
				</tr>
				<tr>
					<td >单位名称：<input type="text" name="nxdwmc_3" value="<?php echo ($lxr[2]["nxdwmc"]); ?>" /></td>
					<td>职务：<input type="text" name="nxzhiwu_3" value="<?php echo ($lxr[2]["nxzhiwu"]); ?>" /></td>
					<td>单位电话：<input type="text" name="nxdwtel_3" value="<?php echo ($lxr[2]["nxdwtel"]); ?>" /></td>
				</tr>
			</table>
			</fieldset>
		</div>
	</div>
	<input type="hidden" name="id" value="<?php echo ($list["id"]); ?>" />
	<div id="sub">
		<input type="submit" value="<?php if($list["id"] == null): ?>添　　加<?php else: ?>修　　改<?php endif; ?>"/>
	</div>
</form>
</div>