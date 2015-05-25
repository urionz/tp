<?php
namespace Home\Model;
use Think\Model\ViewModel;
class RCViewModel extends ViewModel{
	public $viewFields=array(
		'Fhk_client'=>array('*'),
		'Fhk_receive_log'=>array('*','_on'=>'Fhk_client.agree_num=Fhk_receive_log.agree_num'),
	);
}
?>