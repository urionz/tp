<?php
/*
 * Dksq首页显示信息
 */
namespace Home\Model;
use Think\Model\ViewModel;
class Match0ViewModel extends ViewModel{
	public $viewFields=array(
		'Dksq_sq'=>array('*'),
		'Dksq_grzl'=>array('xingming','_on'=>'Dksq_sq.zjhm=Dksq_grzl.zjhm'),
		'User'=>array('xingming'=>'luruxingming','_on'=>'Dksq_sq.luru=User.username'),
	);
}
?>