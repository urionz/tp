<?php
/*
 * 匹配视图模型5
 *联系人资料--姓名，移动电话，住宅电话，单位电话，住址，单位
 * */
namespace Home\Model;
use Think\Model\ViewModel;
class Match5ViewModel extends ViewModel{
	public $viewFields = array(
		'Dksq_sq'=>array('id','sqid'),
		'Dksq_nxrzl'=>array('nxname','nxphone','nxzztel','nxdwtel','nxzhuzhi','nxdwmc','_on'=>'Dksq_sq.zjhm=Dksq_nxrzl.zjhm'),
	);
}
?>
