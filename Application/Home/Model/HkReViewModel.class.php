<?php
namespace Home\Model;
use Think\Model\ViewModel;
class HkReViewModel extends ViewModel{
	public $viewFields=array(
		'Fhk_receive'=>array('*'),
		'Fhk_hk'=>array('*','_on'=>'Fhk_hk.agree_num=Fhk_receive.agree_num'),
//		'Fhk_client'=>array('*','_on'=>'Fhk_client.agree_num=Fhk_hk.agree_num'),	
	);
}
?>