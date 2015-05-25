<?php
namespace Home\Controller;
use Think\Controller;

class BorrowController extends Controller {
	/*控制器初始化*/
	public function _initialize(){
		if(!session('?name')){
        	redirect(U('Login/index'));
        }else{
        	$user['xingming'] = session('xingming');
			$user['bumeng'] = session('bumeng');
			$user['username'] = session('name');
			$this->assign('user',$user);
			

			//发标信息访问权限
			if(!auth_check('borrow')){
				$this->error('无访问权限');
			}
			
			$Borrow=D('Borrow');
			$maxScore = $Borrow->max('verify_time');//获取发标时间的最大值(数据截止日期)
			$this->assign('maxScore',$maxScore);

			//内信
			$MessageTable=M('UserMessage');
			$MessageCount=$MessageTable->where('getid='.session('uid').' and status=0')->count();
			$this->assign('MessageCount',$MessageCount);
			
			$daohang = 'borrow';
			$this->assign('daohang',$daohang);
        }
	}

	/*发标信息首页*/
	public function index() {
		$order = I($get.order);//排序的列
		$stu = I($get.stu);//1:顺序(asc)，2：倒序(desc)
		empty($order)?$order = 'id':$order = I($get.order);
		if(!empty($stu)){
			$stu == '1'?$stu = 'asc':$stu = 'desc';
		}else{
			$stu = 'desc';
		}
		$paixu = $order.' '.$stu;
		
		$Borrow=D('Borrow');
		$count = $Borrow->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$show = $Page->show();// 分页显示输出
		$list=$Borrow->order($paixu)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		
		$sumAccount = $Borrow->sum('account');//统计金额的和
		$this->assign('sumAccount',number_format($sumAccount));
		
		$this -> display();
	}
	
	/*车贷E通*/
	public function Ecar() {
		
		$map['name'] = array('like','C%');
		
		$Borrow=D('Borrow');
		$count = $Borrow->where($map)->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$show = $Page->show();// 分页显示输出
		$list=$Borrow->where($map)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		
		$sumAccount = $Borrow->where($map)->sum('account');//统计车贷E通金额的和
		$this->assign('sumAccount',number_format($sumAccount));
		
		$this -> display();
	}
	
	/*发标信息统计
	 * FORMAT(SUM(account),0) as money
	 * */
	public function tongji() {
		
		$sql_ = "SELECT
					 FROM_UNIXTIME(verify_time,'%Y-%m') as month,
					 FROM_UNIXTIME(verify_time,'%m') as yuefeng,
					 SUM(account) as money
				FROM tp_borrow ";
				
		$_sql = " GROUP BY month
				ORDER BY month";
		
		$Tongji = new \Think\Model(); // 实例化一个model对象 没有对应任何数据表
		$all2013 = $Tongji->query($sql_." where FROM_UNIXTIME(verify_time,'%Y') = 2013 ".$_sql);
		$this->assign('all2013',$all2013);
		
		//2013图表数据
		$tj2013['yuefeng'] = join(',', array_column($all2013,'yuefeng'));
		$tj2013['money'] = join(',', array_column($all2013,'money'));
		$this->assign('tj2013',$tj2013);
		
		
		$all2014 = $Tongji->query($sql_." where FROM_UNIXTIME(verify_time,'%Y') = 2014 ".$_sql);
		$ecar2014 = $Tongji->query($sql_."WHERE `name` LIKE 'C%' and FROM_UNIXTIME(verify_time,'%Y') = 2014 ".$_sql);
		$this->assign('all2014',$all2014);
		$this->assign('ecar2014',$ecar2014);
		
//		2014图标数据
		$tj2014['yuefeng'] = join(',', array_column($all2014,'yuefeng'));
		$tj2014['money'] = join(',', array_column($all2014,'money'));
		$tj2014['e_money'] = join(',', array_column($ecar2014,'money'));
		$this->assign('tj2014',$tj2014);
		
		
		$all2015 = $Tongji->query($sql_." where FROM_UNIXTIME(verify_time,'%Y') = 2015 ".$_sql);
		$ecar2015 = $Tongji->query($sql_."WHERE `name` LIKE 'C%' and FROM_UNIXTIME(verify_time,'%Y') = 2015 ".$_sql);
		$this->assign('all2015',$all2015);
		$this->assign('ecar2015',$ecar2015);
//		dump($all2015);
//		2015图标数据
		$tj2015['yuefeng'] = join(',', array_column($all2015,'yuefeng'));
		$tj2015['money'] = join(',', array_column($all2015,'money'));
		$tj2015['e_money'] = join(',', array_column($ecar2015,'money'));
		$this->assign('tj2015',$tj2015);
		
		
		
		$this -> display();
	}
	
	
}
?>













