$(function(){
	
	$('#doc-confirm-toggle').click(function(){
		var self=$('form');
		var hth=$('input[name="hth"]');
        var hktype=$('.hktype');
        if($('.saler').val()==0)
        {
            alert('请选择一个业务员!');
            $('.saler').focus();
            return false;
        }
        if(hth.val()=='')
        {
            alert('请填写合同号!');
            hth.focus();
            return false;
        }
        if($('.fkje').val()=='')
        {
            alert('请填写放款金额!');
            $('.fkje').focus();
            return false;
        }
        if($('.qx').val()=='')
        {
            alert('请填写合同期限!');
            $('.qx').focus();
            return false;
        }
        if($('.lv').val()=='')
        {
            alert('请填写合同利率!');
            $('.lv').focus();
            return false;
        }
		if($('input[name="fkdate"]').val()=='')
		{
			alert('请设置放款时间!');
            $('input[name="fkdate"]').focus();
			return false;
		}
        if($('.hktype').val()==0)
        {
            alert('请选择放款方式!');
            $('.hktype').focus();
            return false;
        }
		if($('input[name="term_date"]').val()=='')
		{
			alert('请设置第一期还款时间!');
            $('input[name="term_date"]').focus();
			return false;
		}

		if($('.cname').val()==0)
        {
            alert('请填写客户名称!');
            $('.cname').focus();
            return false;
        }
        if($('.client_card').val()==0)
        {
            alert('请填写客户身份证号码!');
            $('.client_card').focus();
            return false;
        }

		$('#my-confirm').modal({
        relatedTarget: this,
        onConfirm: function() {
        	$.post($ajaxAddUrl,self.serialize(),function(data){
        		if(data.status==1)
        		{
        			window.location.href="scan/id/"+hth.val();
        		}
                if(data.status==3)
                {
                    alert('此合同号已存在!');
                    $('input[name="hth"]').focus();
                    return false;
                }
        		if(data.status==0)
        		{

        			alert('添加失败');
                    return false;
        		}
        	});
        },
        onCancel: function() {
        }
      });
		return false;
	});

});