<?php
/*
 * 用户组成员信息
 *user--姓名，编号，部门
 * */
namespace Home\Model;
use Think\Model\ViewModel;
class CyinfoViewModel extends ViewModel{
	public $viewFields = array(
		'Auth_group_access'=>array('*'),
		'User'=>array('username','xingming','bumeng','_on'=>'Auth_group_access.uid=User.id'),
	);
}
?>
