<?php

/*
 * 用户匹配全部合同信息
 */
namespace Home\Model;
use Think\Model\ViewModel;
class ClientAgreeViewModel extends ViewModel{
	public $viewFields=array(
		'Fhk_client'=>array('*'),
		'Fhk_agree'=>array('*','_on'=>'Fhk_client.agree_num=Fhk_agree.agree_num'),
		'Fhk_hk'=>array(
			'hk_date','hk_term','agree_hk','agree_hb','agree_hx','_on'=>'Fhk_agree.agree_num=Fhk_hk.agree_num',
		),
		'Fhk_receive'=>array(
			'*','_on'=>'Fhk_receive.agree_num=Fhk_hk.agree_num',
		)
	);
}




?>

