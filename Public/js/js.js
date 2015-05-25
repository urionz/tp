window.onload=function(){
	var tr = document.getElementsByTagName('tr');

	var form=document.getElementsByName('prevForm');

}

function firm(tzurl,id,tishi){
	if(confirm('确定要'+tishi+'吗？')){
		location.href = tzurl+id;
	}
}
 
function hide(node){  
    var winNode = $("#win");    
    winNode.remove();
    var detailNode=$("#addDetail");  
    detailNode.remove();
   
}


$(function(){
	/*合同信息*/
	$('.cmodify').click(function(){
		var self=$(this);
        if($isModify=='no')
        {
            alert('您没有此权限!');
            return false;
        }
		$('button').each(function(){
			if($(this).attr('class')!=self.next().attr('class'))
				$(this).attr('disabled',true);
		})
		$(this).hide();
		$(this).next().show();
		$(this).parent().parent().next().next().children(':eq(0)').html('<input type="text" name="cname" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" value="'+$(this).parent().parent().next().next().children(':eq(0)').text()+'" />');
		$(this).parent().parent().next().next().children(':eq(1)').html('<input type="text" name="id_card" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" value="'+$(this).parent().parent().next().next().children(':eq(1)').text()+'" />');
		
		var jd=eval(_json);
		var salers="<select name='saler'>";
		for(var o=0;o<jd.length;o++)
		{
			if(jd[o]['id']!=1&&jd[o]['status']!=1)
			{
				if($(this).parent().parent().next().next().children(':eq(2)').attr('title')==jd[o]['id'])
					salers+="<option value='"+jd[o]['id']+"' selected='selected'>"+jd[o]['xingming']+"</option>";
				else
					salers+="<option value='"+jd[o]['id']+"'>"+jd[o]['xingming']+"</option>";
			}
		}
		salers+="</select>";


		$(this).parent().parent().next().next().children(':eq(2)').html(salers);



		$(this).parent().parent().next().next().children(':eq(5)').html('<input type="text" name="fk_money" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" value="'+$(this).parent().parent().next().next().children(':eq(5)').text()+'" />');
		if($(this).parent().parent().next().next().children(':eq(6)').text()=="信用")
		{
			$(this).parent().parent().next().next().children(':eq(6)').html('<select name="fk_type"><option value="1" selected="selected">信用</option><option value="2">抵押</option><option value="3">担保</option></select>');
		}
		if($(this).parent().parent().next().next().children(':eq(6)').text()=="抵押")
		{
			$(this).parent().parent().next().next().children(':eq(6)').html('<select name="fk_type"><option value="1">信用</option><option value="2" selected="selected">抵押</option><option value="3">担保</option></select>');
		}
		if($(this).parent().parent().next().next().children(':eq(6)').text()=="担保")
		{
			$(this).parent().parent().next().next().children(':eq(6)').html('<select name="fk_type"><option value="1">信用</option><option value="2">抵押</option><option value="3" selected="selected">担保</option></select>');
		}
		$(this).parent().parent().next().next().children(':eq(4)').html('<input type="text" name="fk_rate" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" value="'+$(this).parent().parent().next().next().children(':eq(4)').text()+'" />');
		$(this).parent().parent().next().next().children(':eq(7)').html('<input type="text" name="fk_date" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" value="'+$(this).parent().parent().next().next().children(':eq(7)').text()+'" />');
		if($(this).parent().parent().next().next().children(':eq(8)').text()=="等额本息")
		{
			$(this).parent().parent().next().next().children(':eq(8)').html('<select name="hk_type"><option value="1" selected="selected">等额本息</option><option value="2">等本等息</option><option value="3">到期本息</option><option value="4">先息后本</option></select>');
		}
		if($(this).parent().parent().next().next().children(':eq(8)').text()=="等本等息")
		{
			$(this).parent().parent().next().next().children(':eq(8)').html('<select name="hk_type"><option value="1">等额本息</option><option value="2" selected="selected">等本等息</option><option value="3">到期本息</option><option value="4">先息后本</option></select>');
		}
		if($(this).parent().parent().next().next().children(':eq(8)').text()=="到期本息")
		{
			$(this).parent().parent().next().next().children(':eq(8)').html('<select name="hk_type"><option value="1">等额本息</option><option value="2">等本等息</option><option value="3" selected="selected">到期本息</option><option value="4">先息后本</option></select>');
		}
		if($(this).parent().parent().next().next().children(':eq(8)').text()=="先息后本")
		{
			$(this).parent().parent().next().next().children(':eq(8)').html('<select name="hk_type"><option value="1">等额本息</option><option value="2">等本等息</option><option value="3">到期本息</option><option value="4" selected="selected">先息后本</option></select>');
		}
		$(this).parent().parent().next().next().children(':eq(9)').html('<textarea style="resize:none;" name="agreeinfo">'+$(this).parent().parent().next().next().children(':eq(9)').children().attr('title')+'</textarea>');
		return false;
});

	$('.csave').attr("disabled", false);
	$('.csave').click(function(){
		$('.csave').attr("disabled", true);
		if($('.csave').attr('disabled'))
		{
			var mode='agree';
			var client=$('input[name="cname"]').val();
			var saler=$('select[name="saler"] option:selected');
			// alert($('select[name="saler"] option:selected').text());
			var id_card=$('input[name="id_card"]').val();
			var fk_money=$('input[name="fk_money"]');
			var fk_type=$('select[name="fk_type"]');
			var fk_rate=$('input[name="fk_rate"]');
			var fk_date=$('input[name="fk_date"]');
			var hk_type=$('select[name="hk_type"]');
			var info=$('textarea[name="agreeinfo"]');
			var id=$('ol.am-breadcrumb li.am-active').text();
			var self=$(this);
			
			$.post($ajaxUrl,{mode:mode,id:id,saler:saler.val(),info:info.val(),client:client,id_card:id_card,fk_money:fk_money.val(),fk_type:fk_type.val(),fk_rate:fk_rate.val(),fk_date:fk_date.val(),hk_type:hk_type.val()},function(data){
				if(data.status)
				{
					alert('保存成功!');
					$('button').attr('disabled',false);
					self.parent().parent().next().next().children(':eq(0)').html(client);
					self.parent().parent().next().next().children(':eq(1)').html(id_card);
					self.parent().parent().next().next().children(':eq(5)').html(fk_money.val());
					self.parent().parent().next().next().children(':eq(2)').html(saler.text());
					if(fk_type.val()==1)
					{
						self.parent().parent().next().next().children(':eq(6)').html('信用');
					}
					if(fk_type.val()==2)
					{
						self.parent().parent().next().next().children(':eq(6)').html('抵押');
					}
					if(fk_type.val()==3)
					{
						self.parent().parent().next().next().children(':eq(6)').html('担保');
					}
					if(hk_type.val()==1)
					{
						self.parent().parent().next().next().children(':eq(8)').html('等额本息');
					}
					if(hk_type.val()==2)
					{
						self.parent().parent().next().next().children(':eq(8)').html('等本等息');
					}
					if(hk_type.val()==3)
					{
						self.parent().parent().next().next().children(':eq(8)').html('到期本息');
					}
					if(hk_type.val()==4)
					{
						self.parent().parent().next().next().children(':eq(8)').html('先息后本');
					}
					self.parent().parent().next().next().children(':eq(4)').html(fk_rate.val());
					self.parent().parent().next().next().children(':eq(7)').html(fk_date.val());
					self.parent().parent().next().next().children(':eq(8)').html(data.hk_method);
					self.parent().parent().next().next().children(':eq(9)').html(data.info);
					return false;
				}
				else
				{
					alert('内容无修改!');
					$('button').attr('disabled',false);
					location.reload();
				}
			});
			$(this).hide();
			$(this).prev().show();
			
			
			return false;
		}
	});
	
	
	
	/*还款明细修改*/
	$('.hkmodify').each(function(){
		$(this).click(function(){
			if($isModify=='no')
			{
				alert('您没有此权限!');
				return false;
			}
			var self=$(this);
			$('button').each(function(){
				if($(this).attr('class')!=self.next().attr('class'))
					$(this).attr('disabled',true);
			});
			$(this).hide();
			$(this).next().show();
			$(this).parent().parent().children(':eq(3)').html('<input type="text" name="hthb" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" value="'+$(this).parent().parent().children(':eq(3)').text()+'" />');
			$(this).parent().parent().children(':eq(4)').html('<input type="text" name="hthx" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" value="'+$(this).parent().parent().children(':eq(4)').text()+'" />');
			if(FkType==4)
				$(this).parent().parent().children(':eq(1)').html('<input type="text" name="fk_date" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" value="'+$(this).parent().parent().children(':eq(1)').text()+'" />');
			return false;
		});
	});
	/*还款明细保存*/
	$('.hksave').each(function(){

		$(this).click(function(){
			var mode='hk';
			var hthb=$('input[name="hthb"]');
			var hthx=$('input[name="hthx"]');
			var term=$(this).parent().parent().children(':eq(0)');
			var id=$(this).attr('href');
			var self=$(this);
			var hk_date=null;
			if(FkType==4)
				hk_date=$('input[name="fk_date"]').val();
			else
				hk_date=$(this).parent().parent().children(':eq(1)').text();
			$.post($ajaxUrl+id,{mode:mode,hk_date:hk_date,hthb:hthb.val(),hthx:hthx.val(),term:term.text()},function(data){
				if(data.status)
				{
					alert('保存成功!');
					self.parent().parent().children(':eq(1)').html(data.hk_date);
					
					$('td:contains("'+term.text()+'"):last').nextAll(':eq(1)').text(fmoney(data.fac_hb, 2));
					$('td:contains("'+term.text()+'"):last').nextAll(':eq(2)').text(fmoney(data.fac_hx, 2));
					$('td:contains("'+term.text()+'"):last').nextAll(':eq(0)').text(fmoney(data.result_money, 2));
					self.parent().parent().children(':eq(2)').text(fmoney(data.agree_hk,2));
					self.parent().parent().children(':eq(3)').text(hthb.val());
					self.parent().parent().children(':eq(4)').text(hthx.val());
					$('button').attr('disabled',false);
					self.hide();
					self.prev().show();
				}
				else
				{
					alert('数据无修改!');
					location.reload();
					self.hide();
					self.prev().show();
				}
			});
			return false;
		});
	});
	
	
	
	//收款修改
	$('.skmodify').each(function(){
		$(this).click(function(){
			if($isModify=='no')
			{
				alert('您没有此权限!');
				return false;
			}
			var self=$(this);
			$('button').each(function(){
				if($(this).attr('class')!=self.next().attr('class'))
					$(this).attr('disabled',true);
			});
			$(this).hide();
			$(this).next().show();
			$(this).parent().parent().children(':eq(9)').html('<input type="text"  onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" name="skrq" value="'+$(this).parent().parent().children(':eq(9)').text()+'" />');
			$(this).parent().parent().children(':eq(10)').html('<input type="text" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" name="hzbj" value="'+$(this).parent().parent().children(':eq(10)').text()+'" />');
			$(this).parent().parent().children(':eq(11)').html('<input type="text" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" name="hzlx" value="'+$(this).parent().parent().children(':eq(11)').text()+'" />');
			$(this).parent().parent().children(':eq(12)').html('<input type="text" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" name="tqhkqx" value="'+$(this).parent().parent().children(':eq(12)').text()+'" />');
			$(this).parent().parent().children(':eq(13)').html('<input type="text" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" name="wyj" value="'+$(this).parent().parent().children(':eq(13)').text()+'" />');
			$(this).parent().parent().children(':eq(14)').html('<input type="text" onkeydown="this.onkeyup();" onkeyup="this.size=(this.value.length>4?this.value.length:4);" size="4" name="fx" value="'+$(this).parent().parent().children(':eq(14)').text()+'" />');
			
			return false;
		});
	});


	//收款保存
	$('.sksave').each(function(){
		$(this).click(function(){
			var mode='sk';
			var skdate=$('input[name="skrq"]');
			var hzbj=$('input[name="hzbj"]');
			var hzlx=$('input[name="hzlx"]');
			var tqhkqx=$('input[name="tqhkqx"]');
			var wyj=$('input[name="wyj"]');
			var fx=$('input[name="fx"]');
			var term=$(this).parent().parent().children(':eq(0)');
			var id=$(this).attr('href');
			var self=$(this);
			$.post($ajaxUrl+id,{mode:mode,skdate:skdate.val(),hzbj:hzbj.val(),hzlx:hzlx.val(),tqhkqx:tqhkqx.val(),wyj:wyj.val(),fx:fx.val(),term:term.text()},function(data){
				if(data.status)
				{
					alert('保存成功!');
					if(data.receive_date!='')
					{
						self.parent().parent().children(':eq(2)').html('已收');
					}
					self.parent().parent().children(':eq(1)').html(fmoney(data.tc_money,2));
					self.parent().parent().children(':eq(6)').html(fmoney(data.result_money,2));
					self.parent().parent().children(':eq(7)').html(fmoney(data.fac_hb,2));
					self.parent().parent().children(':eq(8)').html(fmoney(data.fac_hx,2));
					self.parent().parent().children(':eq(9)').html(skdate.val());
					self.parent().parent().children(':eq(10)').html(hzbj.val());
					self.parent().parent().children(':eq(11)').html(hzlx.val());
					self.parent().parent().children(':eq(12)').html(tqhkqx.val());
					self.parent().parent().children(':eq(13)').html(wyj.val());
					self.parent().parent().children(':eq(14)').html(fx.val());
					$('button').attr('disabled',false);
					self.hide();
					self.prev().show();
				}
				else
				{
					alert('数据无修改!');
					if(data.receive_date!='')
						self.parent().parent().children(':eq(2)').html('已收');
					self.parent().parent().children(':eq(1)').html(fmoney(data.tc_money,2));
					self.parent().parent().children(':eq(6)').html(fmoney(data.result_money,2));
					self.parent().parent().children(':eq(7)').html(fmoney(data.fac_hb,2));
					self.parent().parent().children(':eq(8)').html(fmoney(data.fac_hx,2));
					self.parent().parent().children(':eq(9)').html(skdate.val());
					self.parent().parent().children(':eq(10)').html(hzbj.val());
					self.parent().parent().children(':eq(11)').html(hzlx.val());
					self.parent().parent().children(':eq(12)').html(tqhkqx.val());
					self.parent().parent().children(':eq(13)').html(wyj.val());
					self.parent().parent().children(':eq(14)').html(fx.val());
					$('button').attr('disabled',false);
					self.hide();
					self.prev().show();
				}
			});
			return false;
		});
	});




	//收款明细页
	//修改
	$('.modify').each(function(){
	$(this).click(function(){
		if($isModify=='no')
		{
			alert('您没有此权限!');
			return false;
		}
		var self=$(this);
		$('button').each(function(){
			if($(this).attr('class')!=self.next().attr('class'))
				$(this).attr('disabled',true);
		});
		$(this).hide();
		$(this).next().show();
		$(this).parent().parent().children(':eq(9)').html('<input type="text" name="skdate" style="width:90px" value="'+$(this).parent().parent().children(':eq(9)').text()+'" />');
		$(this).parent().parent().children(':eq(12)').html('<input type="text" name="tqhkqx" style="width:90px" value="'+$(this).parent().parent().children(':eq(12)').text()+'" />');
		$(this).parent().parent().children(':eq(13)').html('<input type="text" name="wyj" style="width:90px" value="'+$(this).parent().parent().children(':eq(13)').text()+'" />');
		$(this).parent().parent().children(':eq(14)').html('<input type="text" name="fx" style="width:90px" value="'+$(this).parent().parent().children(':eq(14)').text()+'" />');
		return false;
	});
});

	
	//保存
	$('.save').each(function(){
	    $(this).attr("disabled", false);
		$(this).click(function(){
			if($('input[name="skdate"]').val()=='')
			{
				alert('请填写收款日期!');
				skdate.focus();
				return false;
			}
			$(this).attr("disabled", true);
			if($(this).attr('disabled'))
			{
				var mode="shsk";
				var skdate=$('input[name="skdate"]');
				var tqhkqx=$('input[name="tqhkqx"]');
				var wyj=$('input[name="wyj"]');
				var fx=$('input[name="fx"]');
				var term=$(this).parent().parent().children(':eq(0)').text();
				var id=$('.am-breadcrumb').children(':eq(1)').text();
				var self=$(this);
			

				$.post($ajaxUrl+id,{mode:mode,skdate:skdate.val(),tqhkqx:tqhkqx.val(),wyj:wyj.val(),fx:fx.val(),term:term},function(data){
					if(data.status==1)
					{
						alert('保存成功!');
						if(data.receive_date!='')
						{
							self.parent().parent().children(':eq(2)').html('已收');
						}
						self.parent().parent().children(':eq(1)').html(fmoney(data.tc_money,2));
						self.parent().parent().children(':eq(6)').html(fmoney(data.result_money,2));
						self.parent().parent().children(':eq(7)').html(fmoney(data.fac_hb,2));
						self.parent().parent().children(':eq(8)').html(fmoney(data.fac_hx,2));
						self.parent().parent().children(':eq(9)').html(skdate.val());
						self.parent().parent().children(':eq(12)').html(tqhkqx.val());
						self.parent().parent().children(':eq(13)').html(wyj.val());
						self.parent().parent().children(':eq(14)').html(fx.val());
						self.parent().parent().children(':eq(15)').html('待审核');
						$('button').attr('disabled',false);
						self.hide();
						self.parent().next().children(':eq(0)').hide();
					}
					if(data.status==0)
					{
						alert('数据无修改!');
						if(data.receive_date!='')
							self.parent().parent().children(':eq(2)').html('已收');
						self.parent().parent().children(':eq(1)').html(fmoney(data.tc_money,2));
						self.parent().parent().children(':eq(6)').html(fmoney(data.result_money,2));
						self.parent().parent().children(':eq(7)').html(fmoney(data.fac_hb,2));
						self.parent().parent().children(':eq(8)').html(fmoney(data.fac_hx,2));
						self.parent().parent().children(':eq(9)').html(skdate.val());
						self.parent().parent().children(':eq(12)').html(tqhkqx.val());
						self.parent().parent().children(':eq(13)').html(wyj.val());
						self.parent().parent().children(':eq(14)').html(fx.val());
						$('button').attr('disabled',false);
						self.hide();
						self.prev().show();
					}
					if(data.status==3)
					{
						alert('上一期审批未通过或正处于待审批状态，请等待...');
						location.reload();
						return false;
					}
				});
			}
			
			return false;
		});
	});

	
	//坏账填写
	$('.hzset').each(function(){
		$(this).click(function(){
			var self=$(this);
            if($isModify=='no')
            {
                alert('您没有此权限!');
                return false;
            }
			$('button').each(function(){
				if($(this).attr('class')!=self.next().attr('class'))
					$(this).attr('disabled',true);
			});
			$(this).next().show();
			$(this).hide();
			$(this).parent().parent().children(':eq(9)').html('<input type="text" name="skdate" style="width:90px" value="'+$(this).parent().parent().children(':eq(9)').text()+'" />');
			$(this).parent().parent().children(':eq(10)').html('<input type="text" name="hzbj" style="width:90px" value="'+$(this).parent().parent().children(':eq(10)').text()+'" />');
			$(this).parent().parent().children(':eq(11)').html('<input type="text" name="hzlx" style="width:90px" value="'+$(this).parent().parent().children(':eq(11)').text()+'" />');
		});
	});

	$('.hzsave').each(function(){
		$(this).attr('disabled',false);
		$(this).click(function(){
			if($('input[name="skdate"]').val()=='')
			{
				alert('请填写日期!');
				$('input[name="skdate"]').focus();
				return false;
			}
			if($('input[name="hzbj"]').val()==''||$('input[name="hzlx"]').val()=='')
			{
				alert('请填写坏账信息!');
				$('input[name="hzbj"]').focus();
				return false;
			}
			$(this).attr('disabled',true);
			if($(this).attr('disabled'))
			{
				var mode="shsk";
				var hzbj=$('input[name="hzbj"]');
				var hzlx=$('input[name="hzlx"]');
				var skdate=$('input[name="skdate"]');
				var id=$('.am-breadcrumb').children(':eq(1)').text();
				var term=$(this).parent().parent().children(':eq(0)').text();
				var self=$(this);
				

				$.post($ajaxUrl+id,{id:id,skdate:skdate.val(),mode:mode,id:id,hzbj:hzbj.val(),hzlx:hzlx.val(),term:term},function(data){
					if(data.status==1)
					{
						alert('保存成功!');
						$('.hzset').hide();
						$('.modify').hide();
						location.reload();
						self.hide();
					}
					if(data.status==3)
					{
						alert('上一期审批未通过或处于待审批状态，请等待...');
						location.reload();
						return false;
					}
				});
			}
		});
	});


	//审核按钮
	$('.preBtn').each(function(){
		var id=$(this).parent().parent().children(":eq(0)").text();
		var term=$(this).parent().parent().children(':eq(2)').text();
		$(this).click(function(){
			var str='<div id="win">';
					str+='<div id="title">审批设置<span id="close" onclick="hide(self)">X</span></div>';
					str+='<div id="content">';
						str+='<form action="#" method="post" name="prevForm" id="prevForm">';
							str+='<span id="title1">审批说明</span><br/>';
						str+='<textarea id="info" name="info"></textarea><br />';
						str+='<em id="em1">通过</em><input type="radio" checked="checked" name="prevCheck" class="prevCheck" value="2"/><em id="em2">不通过</em>';
						str+='<input type="radio" name="prevCheck" class="prevCheck" value="3" />';
						str+='<br/><input id="btn" type="submit" value="提交" />';
					str+='</form>';
				str+='</div>';
				str+='</div>';
				$('html').append(str);
				
				$('#btn').click(function(){
				$(this).attr('disabled',true);
				var checkValue=$('input[name="prevCheck"]:checked');
				var info=$('textarea[name="info"]');
				$.post($prev,{id:id,term:term,checkValue:checkValue.val(),info:info.val()},function(data){
					if(data.status)
					{
						alert('审批成功!');
						self.location.reload();
					}
					else
					{
						alert('审批失败!');
					}

					hide();
				});
				return false;
				});
			return false;
		});
	});


	//发送站内信
	$('.SendMessage').click(function(){
		var title=$('input[name="title"]');
		var content=$('textarea[name="content"]');
		var getid=$('select[name="getid"]');
		if(title.val()==''||content.val()==''||getid.val()=='')
		{
			alert('请填写完整信息!');
			return false;
		}
		
		$.post($SendUrl,{title:title.val(),content:content.val(),getid:getid.val()},function(data){
			alert(data);
			if(data.status)
			{
				alert('发送成功!');
				window.location.href="Message";
			}
			else
			{
				alert('发送失败!');
			}
		});
		return false;
	});
	//群发
	$('.SendMessages').click(function(){
		var title=$('input[name="titles"]');
		var content=$('textarea[name="contents"]');
		var getid=$('select[name="getids"] option:selected');
		var getidString="";
		$.each(getid,function(i,val){
			getidString+=val.value;
			if((i+1)!=getid.length)
				getidString+="@";
		});
		if(title.val()==''||content.val()==''||getid.val()=='')
		{
			alert('请填写完整信息!');
			return false;
		}
		
		$.post($SendUrl,{title:title.val(),content:content.val(),getid:getidString},function(data){
			alert(data);
			if(data.status)
			{
				alert('发送成功!');
				window.location.href="Message";
			}
			else
			{
				alert('发送失败!');
			}
		});
		return false;
	});

	//信息按钮
	$('.msgSwitchOn').click(function(){
		msgSwitchResult=0;
		$('.msgSwitchOff').show();
		$(this).hide();
		
	});
	$('.msgSwitchOff').click(function(){
		msgSwitchResult=1;
		$('.msgSwitchOn').show();
		$(this).hide();
	});
	$('.msgSaveOn').click(function(){
		msgSaveResult=0;
		$(this).hide();
		$('.msgSaveOff').show();
	});
	$('.msgSaveOff').click(function(){
		msgSaveResult=1;
		$(this).hide();
		$('.msgSaveOn').show();
	});


	//保存用户设置
	$('#doc-confirm-toggle').click(function(){
		var oldpsw=$('.oldpsw');
		var newpsw1=$('.newpsw1');
		var newpsw2=$('.newpsw2');
		if(oldpsw.val()!='')
		{
			if(oldpsw.val().length<6||oldpsw.val().length>15)
			{
				alert('密码只能是6-15位字符!');
				return false;
			}
			if(newpsw1.val()=='')
			{
				alert('请填写新密码!');
				newpsw1.focus();
				return false;
			}
			if(newpsw2.val()=='')
			{
				alert('请填写密码确认!');
				newpsw2.focus();
				return false;
			}
			if(newpsw2.val()!=newpsw1.val())
			{
				alert('两次密码不一致');
				return false;
			}
		}
		if(newpsw1.val()!='')
		{
			if(newpsw1.val().length<6||newpsw1.val().length>15)
			{
				alert('密码只能是6-15位字符!');
				return false;
			}
			if(oldpsw.val()=='')
			{
				alert('请填写旧密码!');
				oldpsw.focus();
				return false;
			}
			if(newpsw2.val()=='')
			{
				alert('请填写密码确认!');
				newpsw2.focus();
				return false;
			}
			if(newpsw2.val()!=newpsw1.val())
			{
				alert('两次密码不一致');
				return false;
			}
		}
		if(newpsw2.val()!='')
		{
			if(newpsw2.val().length<6||newpsw2.val().length>15)
			{
				alert('密码只能是6-15位字符!');
				return false;
			}
			if(oldpsw.val()=='')
			{
				alert('请填写旧密码!');
				oldpsw.focus();
				return false;
			}
			if(newpsw1.val()=='')
			{
				alert('请填写新密码!');
				newpsw2.focus();
				return false;
			}
			if(newpsw2.val()!=newpsw1.val())
			{
				alert('两次密码不一致');
				return false;
			}
		}

		$('#my-confirm').modal({
        relatedTarget: this,
        onConfirm: function() {
        	$.post($UserAjaxUrl,{oldpsw:oldpsw.val(),newpsw1:newpsw1.val(),newpsw2:newpsw2.val(),msgSwitchResult:msgSwitchResult,msgSaveResult:msgSaveResult},function(data){
        		if(data.url!=null)
        		{
        			alert(data.alert);
        			location.href=data.url;
        		}
        		else
        		{
        			alert(data.alert);
        			location.reload();
        		}
        		

        	});
        },
        onCancel: function() {
        }
      });
		return false;
	});

	var form=document.getElementsByTagName('form')[0];
	$('#checkAll').click(function(){
		for(var i=0;i<form.elements.length;i++)
		{
			if(form.elements[i].name!='select_all')
			{
				form.elements[i].checked=form.select_all.checked;
			}
		}
	});
	
});


//格式化金额
function fmoney(s, n) { 
n = n > 0 && n <= 20 ? n : 2; 
s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + ""; 
var l = s.split(".")[0].split("").reverse(), r = s.split(".")[1]; 
t = ""; 
for (i = 0; i < l.length; i++) { 
t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : ""); 
} 
return t.split("").reverse().join("") + "." + r; 
}
function hide(){  
    var winNode = $("#win");    
    winNode.remove();
}