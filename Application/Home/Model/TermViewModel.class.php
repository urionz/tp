<?php
/*
 * 匹配合同明细
 */
namespace Home\Model;
use Think\Model\ViewModel;
class TermViewModel extends ViewModel{
	public $viewFields=array(
		'Fhk_agree'=>array('*'),
		'Fhk_hk'=>array('*','_on'=>'Fhk_agree.agree_num=Fhk_hk.agree_num'),
	);
}
?>