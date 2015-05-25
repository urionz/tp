<?php
/*
 * 匹配视图模型2
 *住宅信息--住址，住宅电话，移动电话
 * */
namespace Home\Model;
use Think\Model\ViewModel;
class Match2ViewModel extends ViewModel{
	public $viewFields = array(
		'Dksq_sq'=>array('id','sqid'),
		'Dksq_zhuzai'=>array('adress','zztel','phone','_on'=>'Dksq_sq.zjhm=Dksq_zhuzai.zjhm'),//住宅信息
	);
}
?>