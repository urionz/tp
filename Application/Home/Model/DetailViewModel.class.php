<?php
namespace Home\Model;
use Think\Model\ViewModel;
class DetailViewModel extends ViewModel{
	public $viewFields=array(
		'Fhk_hk'=>array('*'),
		'Fhk_receive'=>array('*','_on'=>'Fhk_hk.agree_num=Fhk_receive.agree_num'),
	);
}
?>