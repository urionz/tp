$(function(){
	$('form').submit(function(){
		if($('.groupname').val()=="")
		{
			alert('组名称不能为空!');
			return false;
		}	
	});
	
	
	$('#orderOption').change(function(){
		if($(this).val()=="")
			location.href=$postUrl;
		else
			location.href=$postUrl+'/cx/'+$(this).val();
	});
	
	$('.term_option').each(function(){
		$(this).bind('change',function(){
			var confix=$(this).val().split('|');
			var agree_num=confix[0];
			var term=confix[1];
			var str='<div id="addDetail">';
		 		str+='<div id="title">添加明细<span id="close" onclick="hide()">X</span></div>';
		 		str+='<div id="content">';
		 			str+='<form action="#" method="post" name="addForm" id="addForm">';
		 				str+='还款期数:<input type="text" name="hkqs" id="text1" readonly value="'+term+'"/><br />';
						str+='还款日期:<input type="text" name="hkrq" id="text1" /><br />';
						str+='合同还本:<input type="text" name="hthb" id="text1" /><br />';
						str+='合同还息:<input type="text" name="hthx" id="text1" /><br />';
						str+='收款日期:<input type="text" name="skdate" id="text1" /><br />';
						str+='坏账本金:<input type="text" name="hzbj" id="text1" /><br />';
						str+='坏账利息:<input type="text" name="hzlx" id="text1" /><br />';
						str+='提前还款去息:<input type="text" name="tqhkqx" id="text1" /><br />';
						str+='违约金:<input type="text" name="wyj" id="text1" /><br />';
						str+='罚息:<input type="text" name="fx" id="text1" /><br />';
						str+='<br/><input id="btn" type="submit" value="提交" />';
					str+='</form>';
				str+='</div>';
			str+='</div>';
			if($(this).val()!=0)
			{
				$('html').append(str);
				$('#btn').click(function(){
					
				var hkqs=$('input[name="hkqs"]');
				var hkrq=$('input[name="hkrq"]');
				var hthb=$('input[name="hthb"]');
				var hthx=$('input[name="hthx"]');
				var skdate=$('input[name="skdate"]');
				var hzbj=$('input[name="hzbj"]');
				var hzlx=$('input[name="hzlx"]');
				var tqhkqx=$('input[name="tqhkqx"]');
				var wyj=$('input[name="wyj"]');
				var fx=$('input[name="fx"]');
				if(hkrq.val()=="")
				{
					alert('请填写还款日期！');
					hkrq.focus();
					return false;
				}
				if(hthb.val()=="")
				{
					alert('请填写合同还本！');
					hthb.focus();
					return false;
				}
				if(hthx.val()=="")
				{
					alert('请填写合同还息！');
					hthx.focus();
					return false;
				}
				//ajax
				$.post($ajaxUrl+agree_num,{hkqs:hkqs.val(),hkrq:hkrq.val(),hthb:hthb.val(),hthx:hthx.val(),skdate:skdate.val(),hzbj:hzbj.val(),hzlx:hzlx.val(),tqhkqx:tqhkqx.val(),wyj:wyj.val(),fx:fx.val()},function(data){
						if(data.status){
							alert('添加成功！');
						}
						else{
							alert('添加失败');
						}
						hide();
					});
					return false;
				});
			}
		});
	});
	
	
	$('.del').each(function(){
		$(this).click(function(){
			$result=confirm('确定删除？');
			if($result)
				return true;
			else
				return false;
		});
	});


	$('#export').click(function(){
		alert();
	});


	// if($('select[name="search"] option:selected').val()==1)
	// {	
		
	// }
	// var index=$('input[name="target"]').val().length;
	// $('select[name="search"]').change(function(){
	// 	if($(this).val()==2)
	// 	{

	// 	}
	// });

});