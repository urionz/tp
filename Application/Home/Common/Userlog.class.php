<?php
namespace Home\Common;
/**
 * 用户操作日志类
 */
class Userlog {
	
	private $uid;
	
	public function __construct() {
		C('UID',session('uid'));//当前登录用户的id
        $this->uid  = C(UID);
    }
	
	//保存日志信息
	public function save($record){
		
		isset($record['chaozuo'])?$czlr=$record['chaozuo']:$czlr='';
		
		$ulog = array(
			'uid' => $this->uid,//操作用户id
		    'time'   => NOW_TIME,//操作时间
		    'czlr'   => $czlr,//操作内容
		    'ip'  => get_client_ip(),//操作电脑ip
		);
		
		if($this->uid != 1){
			$User_log = M('User_log');
			$User_log->add($ulog);
		}
		
	}
	
	//查看日志
	public function chakan(){
		$User_log = M('User_log');
		
		$count = $User_log->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		
		$data['show'] = $Page->show();// 分页显示输出
		$data['list'] = $User_log
				->alias('a')
				->field('a.*,b.xingming,b.bumeng')
				->join('__USER__ b ON a.uid = b.id')
				->order('logid desc')
				->limit($Page->firstRow.','.$Page->listRows)
				->select();
//		echo $User_log->_sql();
		return $data;
	}

}