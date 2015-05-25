<?php
/*
 * 匹配视图模型4
 * 房产信息--房产地址
 * */
namespace Home\Model;
use Think\Model\ViewModel;
class Match4ViewModel extends ViewModel{
	public $viewFields = array(
		'Dksq_sq'=>array('id','sqid'),
		'Dksq_fczl'=>array('fcdizhi','_on'=>'Dksq_sq.zjhm=Dksq_fczl.zjhm'),
	);
}
?>