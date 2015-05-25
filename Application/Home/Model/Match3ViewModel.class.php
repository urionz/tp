<?php
/*
 * 匹配视图模型3
 * 单位信息--单位名称，地址，电话
 * */
namespace Home\Model;
use Think\Model\ViewModel;
class Match3ViewModel extends ViewModel{
	public $viewFields = array(
		'Dksq_sq'=>array('id','sqid'),
		'Dksq_zyzl'=>array('dwmc','dwdz','dwtel','_on'=>'Dksq_sq.zjhm=Dksq_zyzl.zjhm'),//职业资料
	);
}
?>
