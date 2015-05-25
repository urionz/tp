<?php
namespace Home\Model;
use Think\Model\ViewModel;
class AgreeHkViewModel extends ViewModel{
	public $viewFields=array(
		'Fhk_client'=>array('*'),
		'Fhk_agree'=>array('*','_on'=>'Fhk_client.agree_num=Fhk_agree.agree_num'),
//		'Fhk_hk'=>array('*','_on'=>'Fhk_hk.agree_num=Fhk_agree.agree_num'),
	);
}
?>