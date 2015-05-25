<?php
namespace Home\Model;
use Think\Model\ViewModel;
class AgreeReceiveViewModel extends ViewModel{
	public $viewFields=array(
		'Fhk_agree'=>array('*'),
		'Fhk_receive'=>array('*','_on'=>'Fhk_agree.agree_num=Fhk_receive.agree_num'),
	);
}
?>