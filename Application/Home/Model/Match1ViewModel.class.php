<?php
/*
 * 匹配视图模型1
 *个人资料--姓名，证件号码
 * 配偶信息--姓名，电话，单位电话，单位名称，单位地址
 * */
namespace Home\Model;
use Think\Model\ViewModel;
class Match1ViewModel extends ViewModel{
	public $viewFields = array(
		'Dksq_sq'=>array('id','sqid'),
		'Dksq_grzl'=>array('xingming','zjhm','matexm','matephone','matedwtel','matedw','matedwdz','_on'=>'Dksq_sq.zjhm=Dksq_grzl.zjhm'),
	);
}
?>
