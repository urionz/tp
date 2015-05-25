$(function(){
	$('.modify').each(function(){
		$(this).click(function(){
			$(this).hide();
			$(this).next().show();		
			$(this).parent().parent().children(':eq(1)').html('<input type="text" style="width:90px;" name="tc_money" placeholder="不填则自动生成" />');
			$(this).parent().parent().children(':eq(6)').html('<input type="text" name="result_money" style="width:90px" placeholder="不填则自动生成" />');
			$(this).parent().parent().children(':eq(7)').html('<input type="text" name="fac_hb" style="width:90px" placeholder="不填则自动生成" />');
			$(this).parent().parent().children(':eq(8)').html('<input type="text" name="fac_hx" style="width:90px" placeholder="不填则自动生成" />');
			$(this).parent().parent().children(':eq(9)').html('<input type="text" name="skdate" style="width:90px" value="'+$(this).parent().parent().children(':eq(9)').text()+'" />');
			$(this).parent().parent().children(':eq(10)').html('<input type="text" name="hzbj" style="width:90px" value="'+$(this).parent().parent().children(':eq(10)').text()+'" />');
			$(this).parent().parent().children(':eq(11)').html('<input type="text" name="hzlx" style="width:90px" value="'+$(this).parent().parent().children(':eq(11)').text()+'" />');
			$(this).parent().parent().children(':eq(12)').html('<input type="text" name="tqhkqx" style="width:90px" value="'+$(this).parent().parent().children(':eq(12)').text()+'" />');
			$(this).parent().parent().children(':eq(13)').html('<input type="text" name="wyj" style="width:90px" value="'+$(this).parent().parent().children(':eq(13)').text()+'" />');
			$(this).parent().parent().children(':eq(14)').html('<input type="text" name="fx" style="width:90px" value="'+$(this).parent().parent().children(':eq(14)').text()+'" />');

			return false;
		});
	});
	
	$('.save').each(function(){
		$(this).click(function(){
			var mode="sk";
			var tc_money=$('input[name="tc_money"]');
			var skdate=$('input[name="skdate"]');
			var hzbj=$('input[name="hzbj"]');
			var hzlx=$('input[name="hzlx"]');
			var result_money=$('input[name="result_money"]');
			var fac_hb=$('input[name="fac_hb"]');
			var fac_hx=$('input[name="fac_hx"]');
			var tqhkqx=$('input[name="tqhkqx"]');
			var wyj=$('input[name="wyj"]');
			var fx=$('input[name="fx"]');
			var term=$(this).parent().parent().children(':eq(0)').text()
			var id=$(this).attr('href');
			var self=$(this);
			
			
			$.post($ajaxUrl+id,{mode:mode,tc_money:tc_money.val(),skdate:skdate.val(),hzbj:hzbj.val(),hzlx:hzlx.val(),result_money:result_money.val(),fac_hb:fac_hb.val(),fac_hx:fac_hx.val(),tqhkqx:tqhkqx.val(),wyj:wyj.val(),fx:fx.val(),term:term},function(data){
				if(data.status)
				{
					alert('保存成功!');
					if(data.receive_date!='')
					{
						self.parent().parent().children(':eq(2)').html('已收');
					}
					self.parent().parent().children(':eq(1)').html(data.tc_money);
					self.parent().parent().children(':eq(6)').html(data.result_money);
					self.parent().parent().children(':eq(7)').html(data.fac_hb);
					self.parent().parent().children(':eq(8)').html(data.fac_hx);
					self.parent().parent().children(':eq(9)').html(skdate.val());
					self.parent().parent().children(':eq(10)').html(hzbj.val());
					self.parent().parent().children(':eq(11)').html(hzlx.val());
					self.parent().parent().children(':eq(12)').html(tqhkqx.val());
					self.parent().parent().children(':eq(13)').html(wyj.val());
					self.parent().parent().children(':eq(14)').html(fx.val());
					self.parent().parent().children(':eq(15)').html('待审批');
					self.hide();
					self.prev().show();
				}
				else
				{
					alert('数据无修改!');
					if(data.receive_date!='')
						self.parent().parent().children(':eq(2)').html('已收');
					//self.parent().parent().children(':eq(1)').html(fmoney(data.tc_money,2));
					self.parent().parent().children(':eq(6)').html(result_money.val());
					self.parent().parent().children(':eq(7)').html(fac_hb.val());
					self.parent().parent().children(':eq(8)').html(fac_hx.val());
					self.parent().parent().children(':eq(9)').html(skdate.val());
					self.parent().parent().children(':eq(10)').html(hzbj.val());
					self.parent().parent().children(':eq(11)').html(hzlx.val());
					self.parent().parent().children(':eq(12)').html(tqhkqx.val());
					self.parent().parent().children(':eq(13)').html(wyj.val());
					self.parent().parent().children(':eq(14)').html(fx.val());
					
					self.hide();
					self.prev().show();
				}
			});
			
			
			return false;
		});
	});
	
	
	$('.preBtn').each(function(){
		var id=$(this).attr('href');
		var term=$(this).parent().parent().children(':eq(2)').text();
		$(this).click(function(){
			var str='<div id="win">';
		 		str+='<div id="title">审批设置<span id="close" onclick="hide()">X</span></div>';
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
				var checkValue=$('input[name="prevCheck"]:checked');
				var info=$('textarea[name="info"]');
				$.post($prev,{id:id,term:term,checkValue:checkValue.val(),info:info.val()},function(data){
					alert(data.status);
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
});
function hide(){  
    var winNode = $("#win");    
    winNode.remove();
}