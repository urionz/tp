<?php
namespace Home\Controller;
use Think\Controller;
class FhkController extends Controller{
	public function _initialize(){
		if(!session('?name')){
        	redirect(U('Login/index'));
        }else{
        	$user['xingming'] = session('xingming');
			$user['bumeng'] = session('bumeng');
			$user['username'] = session('name');
			$this->assign('user',$user);
			
			//内信
			$MessageTable=M('UserMessage');
			$MessageCount=$MessageTable->where('getid='.session('uid').' and status=0')->count();
			$this->assign('MessageCount',$MessageCount);

			//权限
			if(!auth_check('fhk'))
				$this->error('无访问权限');
			if(!auth_check('fhk_modify'))
				$this->assign('isModify','no');

			$daohang = 'fhk';
			$this->assign('daohang',$daohang);
        }
	}


	


	
	public function index(){
		//注入栏目
		$Items='index';
		$this->assign('Items',$Items);

		$user=M('User');
		$userInfo=$user->field('id,xingming')->select();
		$this->assign('userinfo',$userInfo);

		//排序
		$order=empty(I('get.order'))?'agree_num':I('get.order');
		$role=empty(I('get.role'))?'desc':I('get.role');
		$orderby=$order.' '.$role;

		//查找
		$searchType=null;
		$searchTarget=null;
		if(isset($_POST['search']))
		{
			if($_POST['search']==1)
				$searchType='Fhk_agree.agree_num';
			if($_POST['search']==2)
				$searchType='cname';
		}
		$searchTarget=isset($_POST['target'])?I('post.target'):null;
		if($searchType!=null&&$searchTarget!=null)
			$search=$searchType.'="'.$searchTarget.'"';

		$Data=D('AgreeHkView');
		$count = $Data->count();
		$Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$show = $Page->show();// 分页显示输出
		$Datas=$Data->order($orderby)->where($search)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$Datas);
		$this->assign('page',$show);
	

		$out=$Data->select();
		//导出
		if(isset($_GET['action'])&&$_GET['action']=='export')
		{
			foreach($out as $k=>$v)
			{
				if($v['fk_type']==1)
					$out[$k]['fk_type']='信用';
				if($v['fk_type']==2)
					$out[$k]['fk_type']='抵押';
				if($v['fk_type']==3)
					$out[$k]['fk_type']='担保';
				if($v['status']==1)
					$out[$k]['status']='执行完毕';
				else
					$out[$k]['status']='执行中';
				$out[$k]['fk_date']=date('Y-m-d',$v['fk_date']);
			}
			$cellTitle=array(
				'编号','客户名称',
				'身份证号码','合同号',
				'放款金额','放款类型',
				'期限','利率',
				'放款日期','业务员',
				'还款方式','备注',
				'状态',
			);
			$keyName=array(
				'id','cname',
				'id_card','agree_num',
				'fk_money','fk_type',
				'limit_time','rate',
				'fk_date','saler',
				'hk_method','info',
				'status',
			);
			download($out,$cellTitle,$keyName,'合同信息');
		}

		//姓名模糊查询
		if(IS_AJAX)
		{
			
			$clientTable=M('Fhk_client');
			$keywords=I('post.keywords');
			$method=I('post.method');
			if($method==1)
				$clientInfo=$clientTable->distinct(true)->where('agree_num like "%'.$keywords.'%"')->field('agree_num')->select();
			if($method==2)
				$clientInfo=$clientTable->distinct(true)->where('cname like "%'.$keywords.'%"')->field('cname')->select(); 
			$this->ajaxReturn(json_encode($clientInfo));
			
		}
		$this->display();

	}
	
	
	
	public function add(){
		$user=M('User');
		$salerList=$user->field('xingming,bumeng,id')->select();

		$Items='add';
		$this->assign('Items',$Items);

		$this->assign('salerList',$salerList);
		$this->display();
	}
	
	public function addAction(){
		if(IS_AJAX)
		{
			
			/*合同表录入*/
			$agreeinfo['agree_num']=I('post.hth')!=''?I('post.hth'):$this->error('请填写合同号！');
			$is_in=M('Fhk_agree');
			if($is_in->where('agree_num="'.$agreeinfo['agree_num'].'"')->find())
			{
				$flag['status']=3;
				$this->ajaxReturn($flag);
			}
			$agreeinfo['fk_money']=I('post.fkje')!=''?I('post.fkje'):$this->error('请填写放款金额！');
			$agreeinfo['fk_type']=I('post.fklx')!=0?I('post.fklx'):$this->error('请填写放款类型！');
			$agreeinfo['limit_time']=I('post.qx')!=''?I('post.qx'):$this->error('请填写期限！');
			$agreeinfo['rate']=I('post.lv')!=''?I('post.lv'):$this->error('请填写利率！');
			$agreeinfo['fk_date']=I('post.fkdate')!=''?strtotime(I('post.fkdate')):$this->error('请填写放款时间！');
			$agreeinfo['info']=I('post.agreeinfo');
			$agreeinfo['saler']=I('post.saler')!='0'?I('post.saler'):$this->error('请选择业务员!');
			
			$type=I('post.hktype')!=0?I('post.hktype'):$this->error('请选择还款方式');
			
			$hk_date=I('post.term_date')!=''?strtotime(I('post.term_date')):$this->error('请填写还款日期！');
			$MD=$hk_date;
			if($type==1)
			{
				//合同表开始
				$flag['status']=1;
				$agreeinfo['hk_method']='等额本息';
				if(!empty($agreeinfo))
				{
					$agreeTable=M('Fhk_agree');
					if($agreeTable->create($agreeinfo))
						$agreeTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
				}
				
				
				
				$skinfo['agree_num']=$hkinfo['agree_num']=$agreeinfo['agree_num'];
				
				$hkTable=M('Fhk_hk');
			
			
				$skTable=M('Fhk_receive');
				$rest=$agreeinfo['fk_money'];
				for($i=1;$i<=$agreeinfo['limit_time'];$i++)
				{
					$skinfo['receive_term']=$hkinfo['hk_term']=$agreeinfo['limit_time'].'-'.$i;
					
					$hkinfo['hk_date']=$i==1?$MD:$MD+86400*date('t',$MD);
					$MD=$hkinfo['hk_date'];
					if($i==1)
					{
						$hkinfo['agree_hx']=$agreeinfo['rate']*$agreeinfo['fk_money'];//第一月合同还本
						$arg=pow(1+$agreeinfo['rate'], $agreeinfo['limit_time']-($i-1));
						$arg2=pow(1+$agreeinfo['rate'],$agreeinfo['limit_time']-($i-1))-1;

						$hkinfo['agree_hb']=(($agreeinfo['fk_money']*$agreeinfo['rate']*$arg)/($arg2))-$hkinfo['agree_hx'];
					}
					
					else
					{
						$rest=$rest-$hkinfo['agree_hb'];
						$hkinfo['agree_hx']=$agreeinfo['rate']*$rest;
						
						$arg=pow(1+$agreeinfo['rate'], $agreeinfo['limit_time']-($i-1));
						$arg2=pow(1+$agreeinfo['rate'],$agreeinfo['limit_time']-($i-1))-1;
						$hkinfo['agree_hb']=(($rest*$agreeinfo['rate']*$arg)/($arg2))-$hkinfo['agree_hx'];
					}
					$hkinfo['agree_hk']=$hkinfo['agree_hb']+$hkinfo['agree_hx'];
					if($hkTable->create($hkinfo))
						$hkTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
					
					$skinfo['receive_num']='sk'.time().$agreeinfo['limit_time'].'-'.$i;
					$skinfo['fac_hb']=$hkinfo['agree_hb'];
					$skinfo['fac_hx']=$hkinfo['agree_hx'];
					$skinfo['result_money']=$hkinfo['agree_hb']+$hkinfo['agree_hx'];
					
					
					if($skTable->create($skinfo))
						$skTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
				}
			}
			if($type==2)
			{
				//合同表开始
				$agreeinfo['hk_method']='等本等息';
				$flag['status']=1;
				if(!empty($agreeinfo))
				{
					$agreeTable=M('Fhk_agree');
					if($agreeTable->create($agreeinfo))
						$agreeTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
				}
				
				
				
				$skinfo['agree_num']=$hkinfo['agree_num']=$agreeinfo['agree_num'];
				
				$hkTable=M('Fhk_hk');
			
			
				$skTable=M('Fhk_receive');
				$hkinfo['agree_hx']=$agreeinfo['rate']*$agreeinfo['fk_money'];
				$hkinfo['agree_hb']=$agreeinfo['fk_money']/$agreeinfo['limit_time'];
				for($i=1;$i<=$agreeinfo['limit_time'];$i++)
				{
					$skinfo['receive_term']=$hkinfo['hk_term']=$agreeinfo['limit_time'].'-'.$i;
					$hkinfo['hk_date']=$i==1?$MD:$MD+86400*date('t',$MD);
					$MD=$hkinfo['hk_date'];
					
					$hkinfo['agree_hk']=$hkinfo['agree_hb']+$hkinfo['agree_hx'];
					if($hkTable->create($hkinfo))
						$hkTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
					$skinfo['receive_num']='sk'.time().$agreeinfo['limit_time'].'-'.$i;
					$skinfo['result_money']=$hkinfo['agree_hb']+$hkinfo['agree_hx'];
					$skinfo['fac_hb']=$hkinfo['agree_hb'];
					$skinfo['fac_hx']=$hkinfo['agree_hx'];
					
					if($skTable->create($skinfo))
						$skTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
				}
			}
			if($type==3)
			{
				//合同表开始
				$agreeinfo['hk_method']='到期本息';
				$flag['status']=1;
				if(!empty($agreeinfo))
				{
					$agreeTable=M('Fhk_agree');
					if($agreeTable->create($agreeinfo))
						$agreeTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
				}
				
				
				
				$skinfo['agree_num']=$hkinfo['agree_num']=$agreeinfo['agree_num'];
				
				$hkTable=M('Fhk_hk');
			
			
				$skTable=M('Fhk_receive');
				for($i=1;$i<=$agreeinfo['limit_time'];$i++)
				{
					$skinfo['receive_term']=$hkinfo['hk_term']=$agreeinfo['limit_time'].'-'.$i;
					$hkinfo['hk_date']=$i==1?$MD:$MD+86400*date('t',$MD);
					$MD=$hkinfo['hk_date'];
					
					$hkinfo['agree_hx']=0;
					$hkinfo['agree_hb']=0;
					if($i==$agreeinfo['limit_time'])
					{
						$hkinfo['agree_hx']=$agreeinfo['fk_money']*$agreeinfo['rate']*$agreeinfo['limit_time'];
						$hkinfo['agree_hb']=$agreeinfo['fk_money'];
					}
					$hkinfo['agree_hk']=$hkinfo['agree_hb']+$hkinfo['agree_hx'];
					if($hkTable->create($hkinfo))
						$hkTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
					
					$skinfo['receive_num']='sk'.time().$agreeinfo['limit_time'].'-'.$i;
					$skinfo['result_money']=$hkinfo['agree_hb']+$hkinfo['agree_hx'];
					$skinfo['fac_hb']=$hkinfo['agree_hb'];
					$skinfo['fac_hx']=$hkinfo['agree_hx'];
					
					if($skTable->create($skinfo))
						$skTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
				}
			}
			if($type==4)
			{
				//合同表开始
				$agreeinfo['hk_method']='先息后本';
				$flag['status']=1;
				if(!empty($agreeinfo))
				{
					$agreeTable=M('Fhk_agree');
					if($agreeTable->create($agreeinfo))
						$agreeTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
				}
				
				
				
				$skinfo['agree_num']=$hkinfo['agree_num']=$agreeinfo['agree_num'];
				
				$hkTable=M('Fhk_hk');
			
			
				$skTable=M('Fhk_receive');
				
				$hkinfo['agree_hb']=0;
				$hkinfo['agree_hx']=$agreeinfo['fk_money']*$agreeinfo['rate'];
				for($i=1;$i<=$agreeinfo['limit_time'];$i++)
				{
					$skinfo['receive_term']=$hkinfo['hk_term']=$agreeinfo['limit_time'].'-'.$i;
					$hkinfo['hk_date']=$i==1?$MD:$MD+86400*date('t',$MD);
					$MD=$hkinfo['hk_date'];
					
					if($i==$agreeinfo['limit_time'])
					{
						$hkinfo['agree_hb']=$agreeinfo['fk_money'];
					}
					$hkinfo['agree_hk']=$hkinfo['agree_hb']+$hkinfo['agree_hx'];
					if($hkTable->create($hkinfo))
						$hkTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
					
					$skinfo['receive_num']='sk'.time().$agreeinfo['limit_time'].'-'.$i;
					$skinfo['result_money']=$hkinfo['agree_hb']+$hkinfo['agree_hx'];
					$skinfo['fac_hb']=$hkinfo['agree_hb'];
					$skinfo['fac_hx']=$hkinfo['agree_hx'];
					
					if($skTable->create($skinfo))
						$skTable->add();
					else
					{
						$flag['status']=0;
						$this->ajaxReturn($flag);
					}
				}
			}
			
			
			
			$clientinfo['cname']=I('post.cname')!=''?I('post.cname'):$this->error('请填写用户信息！');
			$clientinfo['id_card']=I('post.client_card')!=''?I('post.client_card'):$this->error('请填写用户信息！');
			$clientTable=M('Fhk_client');
			$insert['agree_num']=$agreeinfo['agree_num'];
			$insert['cname']=$clientinfo['cname'];
			$insert['id_card']=$clientinfo['id_card'];
			if($clientTable->create($insert))
				$clientTable->add();
			else
			{
				$flag['status']=0;
				$this->ajaxReturn($flag);
			}
			/*客户表录入end*/
			$this->ajaxReturn($flag);
		}
	}


	public function ajaxAction(){
		if(IS_AJAX)
		{
			$mode=I('post.mode');
			$id=I('get.id');
			$receiveTable=M('Fhk_receive');
			$agreeTable=M('Fhk_agree');
			$sklogTable=M('Fhk_receive_log');
			$hkTable=M('Fhk_hk');
			if($mode=='hk')
			{
				$hk_term=I('post.term');
				$ajaxData['agree_hb']=I('post.hthb')!=''?str_replace(',', '', I('post.hthb')):null;
				$ajaxData['agree_hx']=I('post.hthx')!=''?str_replace(',', '', I('post.hthx')):null;
				$ajaxData['hk_date']=I('post.hk_date')!=''?strtotime(I('post.hk_date')):null;
				$ajaxData['agree_hk']=$ajaxData['agree_hb']+$ajaxData['agree_hx'];
				$receiveInfo=$receiveTable->where('agree_num="'.$id.'" and receive_term="'.$hk_term.'"')->find();
				$reData['fac_hx']=$ajaxData['agree_hx']-$receiveInfo[0]['hzlx']-$receiveInfo[0]['tqhkqx']+$receiveInfo[0]['wyj']+$receiveInfo[0]['fx'];
				$reData['fac_hb']=$ajaxData['agree_hb']-$receiveInfo[0]['hz_bj'];
				$reData['result_money']=$reData['fac_hx']+$reData['fac_hb'];
				if($hkTable->where('agree_num="'.$id.'" and hk_term="'.$hk_term.'"')->save($ajaxData))
				{
					$receiveTable->where('agree_num="'.$id.'" and receive_term="'.$hk_term.'"')->save($reData);
					$ReturnData['hk_date']=date('Y-m-d',$ajaxData['hk_date']);
					$ReturnData['agree_hk']=$ajaxData['agree_hk'];
					$ReturnData['fac_hb']=$reData['fac_hb'];
					$ReturnData['fac_hx']=$reData['fac_hx'];
					$ReturnData['result_money']=$reData['result_money'];
					$ReturnData['status']=1;
				}
				else
				{
					$ReturnData['hk_date']=date('Y-m-d',$ajaxData['hk_date']);
					$ReturnData['agree_hk']=$ajaxData['agree_hk'];
					$ReturnData['fac_hb']=$reData['fac_hb'];
					$ReturnData['fac_hx']=$reData['fac_hx'];
					$ReturnData['status']=0;
				}
				$this->ajaxReturn($ReturnData);
			}


			if($mode=="sk")
			{
				$sk_term=I('post.term');
				$hkinfo=$hkTable->where('agree_num="'.$id.'" and hk_term="'.$sk_term.'"')->select();
				$skinfo=$receiveTable->where('agree_num="'.$id.'" and receive_term="'.$sk_term.'"')->select();
				$agreeInfo=$agreeTable->where('agree_num="'.$id.'"')->select();

				$ajaxData['agree_num']=$id;
				$ajaxData['receive_term']=$sk_term;

				$ajaxData['receive_date']=I('post.skdate')!=''?strtotime(I('post.skdate')):null;
				$ajaxData['hz_bj']=I('post.hzbj')!=''?str_replace(',', '', I('post.hzbj')):null;
				$ajaxData['hzlx']=I('post.hzlx')!=''?str_replace(',', '', I('post.hzlx')):null;
				$ajaxData['tqhkqx']=I('post.tqhkqx')!=''?str_replace(',', '', I('post.tqhkqx')):null;
				$ajaxData['wyj']=I('post.wyj')!=''?str_replace(',', '', I('post.wyj')):null;
				$ajaxData['fx']=I('post.fx')!=''?str_replace(',', '', I('post.fx')):null;
				$ajaxData['result_money']=$hkinfo[0]['agree_hb']+$hkinfo[0]['agree_hx']-$ajaxData['hzlx']-$ajaxData['hz_bj']-$ajaxData['tqhkqx']+$ajaxData['wyj']+$ajaxData['fx'];
				$ajaxData['fac_hx']=$hkinfo[0]['agree_hx']-$ajaxData['hzlx']-$ajaxData['tqhkqx']+$ajaxData['wyj']+$ajaxData['fx'];
				$ajaxData['fac_hb']=$hkinfo[0]['agree_hb']-$ajaxData['hz_bj'];
				$ajaxData['pre_status']=2;
				if($ajaxData['hz_bj']==null&&$ajaxData['hzlx']==null)
				{
					if($ajaxData['receive_date']!=null)
					{

						$rate=0.08;
						// if($agreeInfo[0]['fk_type']==1)//信用标
						// {
						// 	$a=split('-',$ajaxData['receive_term'],2);
						// 	for($i=0;$i<$agreeInfo[0]['limit_time'];$i++)
						// 	{
						// 		$start=0.08;
						// 		if($a[1]==($i+1))
						// 			$rate=$start+$i*0.005;
						// 	}

						// }
						if(floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))<=3)
							$ajaxData['tc_money']=$ajaxData['fac_hx']*$rate;
						if(floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))>3&&floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))<=10)
							$ajaxData['tc_money']=$ajaxData['fac_hx']*($rate-0.01);
						if(floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))>10&&floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))<=20)
							$ajaxData['tc_money']=$ajaxData['fac_hx']*($rate-0.02);
						if(floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))>20&&floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))<=30)
							$ajaxData['tc_money']=$ajaxData['fac_hx']*($rate-0.03);
						if(floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))>30)
							$ajaxData['tc_money']=0;
					}
				}
				if($receiveTable->where('agree_num="'.$id.'" and receive_term="'.$sk_term.'"')->data($ajaxData)->save())
					$ajaxData['status']=1;
				else
					$ajaxData['status']=0;
			}

			
			
			if($mode=='shsk')
			{
				$sk_term=I('post.term');
				$hkinfo=$hkTable->where('agree_num="'.$id.'" and hk_term="'.$sk_term.'"')->select();
				$PreTerm=explode('-',$sk_term);
				if($PreTerm[1]!=1)
				{
					$PreTerm[0]=$PreTerm[0]."-".($PreTerm[1]-1);
					$Preskinfo=$receiveTable->field('pre_status')->where('agree_num="'.$id.'" and receive_term="'.$PreTerm[0].'"')->select();
					if($Preskinfo[0]['pre_status']==1||$Preskinfo[0]['pre_status']==3||$Preskinfo[0]['pre_status']==null)
					{
						$ajaxData['status']=3;
						$this->ajaxReturn($ajaxData);
					}
				}
				
				$skinfo=$receiveTable->where('agree_num="'.$id.'" and receive_term="'.$sk_term.'"')->select();
				$agreeInfo=$agreeTable->where('agree_num="'.$id.'"')->select();	
				$ajaxData['agree_num']=$id;
				$ajaxData['receive_term']=$sk_term;

				$ajaxData['receive_date']=I('post.skdate')!=''?strtotime(I('post.skdate')):null;
				$ajaxData['hz_bj']=I('post.hzbj')!=''?str_replace(',', '', I('post.hzbj')):null;
				$ajaxData['hzlx']=I('post.hzlx')!=''?str_replace(',', '', I('post.hzlx')):null;
				$ajaxData['tqhkqx']=I('post.tqhkqx')!=''?str_replace(',', '', I('post.tqhkqx')):null;
				$ajaxData['wyj']=I('post.wyj')!=''?str_replace(',', '', I('post.wyj')):null;
				$ajaxData['fx']=I('post.fx')!=''?str_replace(',', '', I('post.fx')):null;
				$ajaxData['pre_status']=1;//1为待审核状态
				$ajaxData['op_time']=time();
				$ajaxData['operator']=session('xingming');
				$ajaxData['result_money']=$hkinfo[0]['agree_hb']+$hkinfo[0]['agree_hx']-$ajaxData['hzlx']-$ajaxData['hz_bj']-$ajaxData['tqhkqx']+$ajaxData['wyj']+$ajaxData['fx'];
				$ajaxData['fac_hb']=$hkinfo[0]['agree_hb']-$ajaxData['hz_bj'];
				$ajaxData['fac_hx']=$hkinfo[0]['agree_hx']-$ajaxData['hzlx']-$ajaxData['tqhkqx']+$ajaxData['wyj']+$ajaxData['fx'];
				

				if($ajaxData['hz_bj']==null&&$ajaxData['hzlx']==null)
				{
					//提成计算
					if($ajaxData['receive_date']!=null)
					{

						$rate=0.08;
						// if($agreeInfo[0]['fk_type']==1)//信用标
						// {
						// 	$rate=$rate+0.005*($agreeInfo[0]['limit_time']-1);
						// }
						if(floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))<=3)
							$ajaxData['tc_money']=$ajaxData['fac_hx']*$rate;
						if(floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))>3&&floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))<=10)
							$ajaxData['tc_money']=$ajaxData['fac_hx']*($rate-0.01);
						if(floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))>10&&floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))<=20)
							$ajaxData['tc_money']=$ajaxData['fac_hx']*($rate-0.02);
						if(floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))>20&&floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))<=30)
							$ajaxData['tc_money']=$ajaxData['fac_hx']*($rate-0.03);
						if(floor(($ajaxData['receive_date']-$hkinfo[0]['hk_date'])/(60*60*24))>30)
							$ajaxData['tc_money']=0;
					}
				}
				if($sklogTable->where('agree_num="'.$id.'" and receive_term="'.$sk_term.'"')->find())//审批未通过后修改再审批
				{
					$modifyData['receive_date']=$ajaxData['receive_date'];
					$modifyData['hz_bj']=$ajaxData['hz_bj'];
					$modifyData['hzlx']=$ajaxData['hzlx'];
					$modifyData['tqhkqx']=$ajaxData['tqhkqx'];
					$modifyData['wyj']=$ajaxData['wyj'];
					$modifyData['fx']=$ajaxData['fx'];
					$modifyData['pre_status']=$ajaxData['pre_status'];
					if($sklogTable->where('agree_num="'.$id.'" and receive_term="'.$sk_term.'"')->save($modifyData))
					{
						$ajaxData['status']=1;
						$skdata['pre_status']=1;
						$receiveTable->where('agree_num="'.$id.'" and receive_term="'.$sk_term.'"')->save($skdata);
					}
					else
					{
						$ajaxData['status']=0;
					}
				}
				else
				{
					if($sklogTable->data($ajaxData)->add())
					{
						$ajaxData['status']=1;
						$skdata['pre_status']=1;
						$receiveTable->where('agree_num="'.$id.'" and receive_term="'.$sk_term.'"')->save($skdata);
					}
					else
					{
						$ajaxData['status']=0;
					}
				}
			}
			if($mode=='agree')
			{
				$clientTable=M('Fhk_client');
				$data['cname']=I('post.client');
				$data['id_card']=I('post.id_card');
				$tj['agree_num']=I('post.id');
				$clientTable->where($tj)->data($data)->save();
				$ajaxData['fk_money']=str_replace(',', '', I('post.fk_money'));
				$ajaxData['fk_type']=I('post.fk_type');
				if(strpos(I('post.fk_rate'),'%'))
				{
					$rate=explode('%',I('post.fk_rate'));
					$ajaxData['rate']=$rate[0]/100;
				}
				else
					$ajaxData['rate']=I('post.fk_rate');
				$ajaxData['fk_date']=strtotime(I('post.fk_date'));
				$ajaxData['info']=I('post.info');
				$ajaxData['saler']=I('post.saler');



				if(I('post.hk_type')==1)
					$ajaxData['hk_method']='等额本息';
				if(I('post.hk_type')==2)
					$ajaxData['hk_method']='等本等息';
				if(I('post.hk_type')==3)
					$ajaxData['hk_method']='到期本息';
				if(I('post.hk_type')==4)
					$ajaxData['hk_method']='先息后本';
				
				$agreeTable=M('Fhk_agree');
				if($agreeTable->where($tj)->data($ajaxData)->save())
					$ajaxData['status']=1;
				else
					$ajaxData['status']=0;
			}
			$this->ajaxReturn($ajaxData);
			
		}
		else
		{
			$this->error('错误的访问!');
		}
	}



	public function scan(){
		if(isset($_GET['id']))
		{
			$tj['agree_num']=I('get.id');
			$list=D('ClientAgreeView');
			$lists=$list->where('Fhk_agree.agree_num ="'.$tj['agree_num'].'" and Fhk_hk.hk_term=Fhk_receive.receive_term')->group('Fhk_hk.hk_term')->order('Fhk_receive.id')->select();
			

			$user=M('User');
			$userInfo=$user->field('id,xingming,status')->select();
			$this->assign('userinfo',$userInfo);

			$_json=json_encode($userInfo);//传入js
			$this->assign('_json',$_json);
			

	
			//用户信息
			$client=M('Fhk_client');
			$clients=$client->where('agree_num="'.$tj['agree_num'].'"')->field('id,cname,id_card')->select();
			$this->assign('clients',$clients);
			
			//注入栏目
			$Items='index';
			$this->assign('Items',$Items);


			$this->assign('lists',$lists);
			// var_dump($lists);
			$this->display();
		}
		else
		{
			$this->error('错误的访问!');
		}
	}

	public function _before_deleteAction(){
		if(!auth_check('fhk_del'))
			$this->error('没有权限，无法进行此操作!');
	}
	
	
	public function deleteAction(){
		if(IS_GET)
		{
			if(isset($_GET['id']))
			{
				$agree_num=I('get.id');
				$agreeTable=M('Fhk_agree');
				$reTable=M('Fhk_receive');
				$ReLogTable=M('Fhk_receive_log');
				$clientTable=M('Fhk_client');
				$hkTable=M('Fhk_hk');
				$result=$ReLogTable->where('agree_num="'.$agree_num.'"')->find();
				if(empty($result))
				{
					if($reTable->where('agree_num="'.$agree_num.'"')->delete()&&$hkTable->where('agree_num="'.$agree_num.'"')->delete()&&$clientTable->where('agree_num="'.$agree_num.'"')->delete()&&$agreeTable->where('agree_num="'.$agree_num.'"')->delete())
						$this->success('删除成功!');
					else
						$this->error('删除失败!');
				}
				else
					if($ReLogTable->where('agree_num="'.$agree_num.'"')->delete()&&$reTable->where('agree_num="'.$agree_num.'"')->delete()&&$hkTable->where('agree_num="'.$agree_num.'"')->delete()&&$clientTable->where('agree_num="'.$agree_num.'"')->delete()&&$agreeTable->where('agree_num="'.$agree_num.'"')->delete())
						$this->success('删除成功!');
					else
						$this->error('删除失败!');
				
			}
		}
		else
		{
			$this->error('错误的访问!');
		}
	}



	public function sk(){
		if(isset($_GET['id']))
		{
			$tj['agree_num']=I('get.id');
			$list=D('ClientAgreeView');
			$lists=$list->where('Fhk_agree.agree_num ="'.$tj['agree_num'].'" and Fhk_hk.hk_term=Fhk_receive.receive_term')->group('Fhk_hk.hk_term')->order('Fhk_receive.id')->select();
		
			$ReLogTable=M('Fhk_receive_log');
			$ReLogInfo=$ReLogTable->where('agree_num ="'.$tj['agree_num'].'"')->select();
	
			//用户信息
			$client=M('Fhk_client');
			$clients=$client->where('agree_num="'.$tj['agree_num'].'"')->select();
			$this->assign('clients',$clients);

			//注入栏目
			$Items='index';
			$this->assign('Items',$Items);
			
			$this->assign('lists',$lists);
			$this->assign('ReLogInfo',$ReLogInfo);

			$this->display();
		}
		else
		{
			$this->error('错误的访问!');
		}
		
	}

	public function _before_pre(){
		//注入栏目
		$Items='pre';
		$this->assign('Items',$Items);
		//权限
		if(!auth_check('fhk_prev'))
			$this->error('无访问权限');
	}
	
	
	public function pre(){
		$reTable=D('RCView');
		$reInfo=$reTable->where('pre_status=1')->select();
		$this->assign('reInfo',$reInfo);
		$this->display();
	}
	
	
	public function preAction(){
		$tj['agree_num']=I('post.id');
		$tj['receive_term']=I('post.term');
		$ReLogTable=M('Fhk_receive_log');
		$ReLogData['pre_status']=I('post.checkValue');
		$ReLogData['pre_info']=I('post.info')==''?null:I('post.info');
		$ReTable=M('Fhk_receive');
		$agreeTable=M('Fhk_agree');
		$MessageTable=M('User_message');
		$UserTable=M('User');
		$ReLogTable->where('agree_num="'.$tj['agree_num'].'" and receive_term="'.$tj['receive_term'].'"')->data($ReLogData)->save();
		$ReInfo=$ReTable->where('agree_num="'.$tj['agree_num'].'" and receive_term="'.$tj['receive_term'].'"')->select();
		$ReLogInfo=$ReLogTable->where('agree_num="'.$tj['agree_num'].'" and receive_term="'.$tj['receive_term'].'"')->select();
		if($ReLogData['pre_status']==2)//通过
		{
			$ReData['result_money']=$ReLogInfo[0]['result_money'];
			$ReData['tc_money']=$ReLogInfo[0]['tc_money'];
			$ReData['fac_hb']=$ReLogInfo[0]['fac_hb'];
			$ReData['fac_hx']=$ReLogInfo[0]['fac_hx'];
			$ReData['receive_date']=$ReLogInfo[0]['receive_date'];
			$ReData['hz_bj']=$ReLogInfo[0]['hz_bj'];
			$ReData['hzlx']=$ReLogInfo[0]['hzlx'];
			$ReData['tqhkqx']=$ReLogInfo[0]['tqhkqx'];
			$ReData['wyj']=$ReLogInfo[0]['wyj'];
			$ReData['fx']=$ReLogInfo[0]['fx'];
			$ReData['pre_status']=$ReLogData['pre_status'];
			if($ReTable->where('agree_num="'.$tj['agree_num'].'" and receive_term="'.$tj['receive_term'].'"')->data($ReData)->save())
				$ReData['status']='1';
			else
				$ReData['status']='0';

			$info="通过!";


			if($ReLogInfo[0]['hz_bj']!=null||$ReLogInfo[0]['hzlx']!=null)//设置坏账
			{
				$set['status']=1;
				$agreeTable->where('agree_num="'.$tj['agree_num'].'"')->save($set);
				$term=explode('-',$tj['receive_term']);
				$length=$term[0];
				for($i=1;$i<=$length;$i++)
				{
					if($i>$term[1])
					{
						$L=$ReTable->where('agree_num="'.$tj['agree_num'].'" and receive_term="'.$term[0].'-'.$i.'"')->select();
						$G['receive_date']=$ReLogInfo[0]['receive_date'];
						$G['hz_bj']=$L[0]['fac_hb'];
						$G['hzlx']=$L[0]['fac_hx'];
						$G['pre_status']=$ReLogData['pre_status'];
						if($ReTable->where('agree_num="'.$tj['agree_num'].'" and receive_term="'.$term[0].'-'.$i.'"')->save($G))
							$ReData['status']='1';
						else
							$ReData['status']='0';
					}
				}
				$this->ajaxReturn($ReData);
			}

		}
		if($ReLogData['pre_status']==3)//不通过
		{
			

			$ReLogTable->where('agree_num="'.$tj['agree_num'].'" and receive_term="'.$tj['receive_term'].'"')->data($ReLogData)->save();
			$save['pre_status']=3;
			if($ReTable->where('agree_num="'.$tj['agree_num'].'" and receive_term="'.$tj['receive_term'].'"')->data($save)->save())
				$ReData['status']='1';
			else
				$ReData['status']='0';
			$info="未通过!";
		}
		$endCountInfo=$ReTable->where('agree_num="'.$tj['agree_num'].'" and receive_date is null')->select();
		if(empty($endCountInfo))//标记合同状态为执行完毕
		{
			$set['status']=1;
			$agreeTable->where('agree_num="'.$tj['agree_num'].'"')->save($set);
		}
		$getid=$UserTable->field('id')->where('xingming="'.$ReLogInfo[0]['operator'].'"')->select();
		$MessageData['postid']=session('uid');
		$MessageData['getid']=$getid[0]['id'];
		$MessageData['title']="放还款审核回执";
		$MessageData['content']=$ReLogData['pre_info']==''?null:'<b style="color:red;">审批结果--'.$info.'</b><br/>内容：<br/>'.$ReLogData['pre_info'];
		$MessageData['status']=0;//标记为未读
		$MessageData['posttime']=time();
		$MessageTable->data($MessageData)->add();

		$this->ajaxReturn($ReData);
	}
	
	
	public function clientView(){

		//注入栏目
		$Items='clientView';
		$this->assign('Items',$Items);

		$user=M('User');
		$userInfo=$user->field('id,xingming')->select();
		$this->assign('userinfo',$userInfo);

		$order=empty(I('get.order'))?'id':I('get.order');
		if(!empty(I('get.role')))
		{
			if(I('get.role')=='desc')
				$role=SORT_DESC;
			else
				$role=SORT_ASC;
		}
		$searchTarget=null;
		if(isset($_POST['target'])&&$_POST['target']!='')
			$searchTarget=I('post.target');

		$HkReView=D('HkReView');
		$AgreeHkView=D('AgreeHkView');
		
		$AgreeHkInfo=$AgreeHkView->where('status<>1')->select();
		$HkReInfo=$HkReView->order($orderby)->where('Fhk_hk.hk_term=Fhk_receive.receive_term')->select();
		
		//业务员单数统计
		$AgreeModel=M();
		$SaCount=$AgreeModel->query('select count(saler) count,saler from tp_fhk_agree where status<>1 group by saler;');
		$this->assign('SaCount',$SaCount);
		//客户统计
		$Ctable=M('Fhk_client');
		$CCount=$Ctable->field('cname')->distinct(true)->count();
		$this->assign('CCount',$CCount);
		

		foreach($AgreeHkInfo as $ko=>$vo)
		{
			$outVal[$ko]['ResultMoney']=0;
			$outVal[$ko]['AgreeHk']=0;
			$outVal[$ko]['HzJe']=0;
			$outVal[$ko]['Tqqx']=0;
			$outVal[$ko]['Wyj']=0;
			$outVal[$ko]['Fx']=0;
			$outVal[$ko]['YhJe']=0;
			$outVal[$ko]['YsJe']=0;
			$outVal[$ko]['DsJe']=0;
			$outVal[$ko]['YhJe']=0;
			$outVal[$ko]['agree_num']=$vo['agree_num'];
            $outVal[$ko]['cname']=$vo['cname'];
            $outVal[$ko]['saler']=$vo['saler'];
            $outVal[$ko]['status']=$vo['status'];
			foreach($HkReInfo as $k=>$v)
			{
				if($vo['agree_num']==$v['agree_num'])
				{
					$outVal[$ko]['ResultMoney']+=$v['result_money'];
					$Sum['ResultMoneySum']+=$v['result_money'];
					$outVal[$ko]['AgreeHk']+=$v['agree_hk'];
					$Sum['AgreeHkSum']+=$v['agree_hk'];
					$outVal[$ko]['HzJe']+=$v['hz_bj'];
					$Sum['HzJeSum']+=$v['hz_bj'];
					$outVal[$ko]['Tqqx']+=$v['tqhkqx'];
					$Sum['TqqxSum']+=$v['tqhkqx'];
					$outVal[$ko]['Wyj']+=$v['wyj'];
					$Sum['WyjSum']+=$v['wyj'];
					$outVal[$ko]['Fx']+=$v['fx'];
					$Sum['FxSum']+=$v['fx'];
					if(!empty($v['receive_date']))
					{
						$YhTop+=(floor(($v['receive_date']-$v['hk_date'])/(60*60*24))*$v['result_money']);
						$outVal[$ko]['YhJe']+=$v['result_money'];
						$Sum['YhJe']+=$v['result_money'];
					}
					else
					{
						if(time() > $v['hk_date'])//应收
						{
							$YsTop+=(floor((time()-$v['hk_date'])/(60*60*24))*$v['result_money']);
							$outVal[$ko]['YsJe']+=$v['result_money'];
							$Sum['YsJe']+=$v['result_money'];
						}
						if(time() < $v['hk_date'])//待收
						{
							$DsTop+=(floor((time()-$v['hk_date'])/(60*60*24))*$v['result_money']);
							$outVal[$ko]['DsJe']+=$v['result_money'];
							$Sum['DsJe']+=$v['result_money'];
						}
					}
					
				}
			}
			$outVal[$ko]['HkJs']=$outVal[$ko]['YhJe']==0?0:$YhTop/$outVal[$ko]['YhJe'];
			$Sum['HkJsSum']+=$outVal[$ko]['HkJs'];
			$outVal[$ko]['YsJs']=$outVal[$ko]['YsJe']==0?0:$YsTop/$outVal[$ko]['YsJe'];
			$Sum['YsJsSum']+=$outVal[$ko]['YsJs'];
			$outVal[$ko]['DsJs']=$outVal[$ko]['DsJe']==0?0:$DsTop/$outVal[$ko]['DsJe'];
			$Sum['DsJsSum']+=$outVal[$ko]['DsJs'];
			$outVal[$ko]['Yhzb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['YhJe']/$outVal[$ko]['ResultMoney']*100,2).'%';
			$outVal[$ko]['Yszb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['YsJe']/$outVal[$ko]['ResultMoney']*100,2).'%';
			$outVal[$ko]['Dszb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['DsJe']/$outVal[$ko]['ResultMoney']*100,2).'%';
		}
		$outVal=multi_array_sort($outVal,$order,$role);//排序
		//按姓名查找
		if($searchTarget!=null)
		{
			foreach ($outVal as $key => $value)
			{
				# code...
				if($outVal[$key]['cname']!=$searchTarget)
					unset($outVal[$key]);	
			}
		}
		//导出
		if(isset($_GET['action'])&&$_GET['action']=='export')
		{
			foreach($outVal as $k=>$v)
			{
				$outVal[$k]['DsJs']=floor($v['DsJs']);
				$outVal[$k]['HkJs']=floor($v['HkJs']);
				$outVal[$k]['YsJs']=floor($v['YsJs']);
			}
			$cellTitle=array(
				'合同号','客户名称',
				'业务员','结算金额',
				'合同还款','提前去息',
				'违约金','罚息',
				'已还金额','已还占比',
				'还款均时','应收金额',
				'应收占比','逾期均时',
				'待收金额','待收占比',
				'到期均时'
			);
			$keyName=array(
				'agree_num','cname',
				'saler','ResultMoney',
				'AgreeHk','Tqqx',
				'Wyj','Fx',
				'YhJe','Yhzb',
				'HkJs','YsJe',
				'Yszb','YsJs',
				'DsJe','Dszb',
				'DsJs'
			);
			download($outVal,$cellTitle,$keyName,'客户账款');
		}
		$count=count($outVal);
		$Sum['CCount']=$count;
		$Page = new \Think\Page($count,10);
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		
		$outVal=array_slice($outVal, $Page->firstRow,$Page->listRows);

		$show = $Page->show();
		$this->assign('page',$show);
		$this->assign('out',$outVal);
		$this->assign('Sum',$Sum);
		
		
		$this->display();
	}
	
	
	public function DsList(){

		//注入栏目
		$Items='DsList';
		$this->assign('Items',$Items);


        $ClientAgree=D('ClientAgreeView');
        $ClientAgreeInfo=$ClientAgree->where('Fhk_hk.hk_term=Fhk_receive.receive_term and receive_date is null and '.time().'<hk_date')->group('Fhk_hk.agree_num')->select();
        $ClientAgreeInfo2=$ClientAgree->where('Fhk_hk.hk_term=Fhk_receive.receive_term and receive_date is null and '.time().'<hk_date')->select();
        foreach($ClientAgreeInfo as $ko=>$vo)
        {
            $Dqjs_Top=0;
            $outVal[$ko]['ResultMoney']=0;
            $outVal[$ko]['Lx']=0;
            $outVal[$ko]['Bj']=0;
            $outVal[$ko]['OneMonth']=0;
            $outVal[$ko]['ThreeMonth']=0;
            $outVal[$ko]['SixMonth']=0;
            $outVal[$ko]['OneYear']=0;
            $outVal[$ko]['OutOfOneYear']=0;
            $MaxTime=0;
            $outVal[$ko]['agree_num']=$vo['agree_num'];
            $outVal[$ko]['cname']=$vo['cname'];
            foreach($ClientAgreeInfo2 as $k=>$v)
            {
                if($v['agree_num']==$vo['agree_num'])
                {
                    $Dqjs_Top+=$v['result_money']*floor((time()-$v['hk_date'])/(60*60*24));
                    $outVal[$ko]['ResultMoney']+=$v['result_money'];
                    $outVal[$ko]['Lx']+=$v['fac_hx'];
                    $outVal[$ko]['Bj']+=$v['fac_hb'];
                    $Sum['BjSum']+=$v['fac_hb'];
                    $Sum['ResultMoneySum']+=$v['result_money'];
                    $Sum['LxSum']+=$v['fac_hx'];
                    if(floor((time()-$v['hk_date'])/(60*60*24))<$MaxTime)
                    {
                        $MaxTime=floor((time()-$v['hk_date'])/(60*60*24));
                        $outVal[$ko]['MaxDate']=$v['hk_date'];
                    }
                    if((floor((time()-$v['hk_date'])/(60*60*24)) >= -30) && ((floor((time()-$v['hk_date'])/(60*60*24))< -7)))//一月内
                    {
                        $outVal[$ko]['OneMonth']+=$v['result_money'];
                        $Sum['OneMonthSum']+=$v['result_money'];
                    }
                    if((floor((time()-$v['hk_date'])/(60*60*24)) >= -91) && ((floor((time()-$v['hk_date'])/(60*60*24))< -30)))//三月内
                    {
                        $outVal[$ko]['ThreeMonth']+=$v['result_money'];
                        $Sum['ThreeMonthSum']+=$v['result_money'];
                    }
                    if((floor((time()-$v['hk_date'])/(60*60*24)) >= -182) && ((floor((time()-$v['hk_date'])/(60*60*24)) < -91)))//六月内
                    {
                        $outVal[$ko]['SixMonth']+=$v['result_money'];
                        $Sum['SixMonthSum']+=$v['result_money'];
                    }
                    if((floor((time()-$v['hk_date'])/(60*60*24)) >= -365) && ((floor((time()-$v['hk_date'])/(60*60*24)) < -182)))//一年
                    {
                        $outVal[$ko]['OneYear']+=$v['result_money'];
                        $Sum['OneYearSum']+=$v['result_money'];
                    }
                    if(floor((time()-$v['hk_date'])/(60*60*24)) < -365)//一年外
                    {
                        $outVal[$ko]['OutOfOneYear']+=$v['result_money'];
                        $Sum['OutOfOneYearSum']+=$v['result_money'];
                    }
                }
            }
            $outVal[$ko]['Dqjs']=$outVal[$ko]['ResultMoney']==0?0:$Dqjs_Top/$outVal[$ko]['ResultMoney'];
            $outVal[$ko]['OneMonthZb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['OneMonth']/$outVal[$ko]['ResultMoney']*100,2).'%';
            $outVal[$ko]['ThreeMonthZb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['ThreeMonth']/$outVal[$ko]['ResultMoney']*100,2).'%';
            $outVal[$ko]['SixMonthZb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['SixMonth']/$outVal[$ko]['ResultMoney']*100,2).'%';
            $outVal[$ko]['OneYearZb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['OneYear']/$outVal[$ko]['ResultMoney']*100,2).'%';
            $outVal[$ko]['OutOfOneYearZb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['OutOfOneYear']/$outVal[$ko]['ResultMoney']*100,2).'%';
        }

        //导出
		if(isset($_GET['action'])&&$_GET['action']=='export')
		{
			foreach($outVal as $k=>$v)
			{
				$outVal[$k]['Dqjs']=floor($v['Dqjs']);
				$outVal[$k]['MaxDate']=date('Y-m-d',$v['MaxDate']);
				$outVal[$k]['YsJs']=floor($v['YsJs']);
			}
			$cellTitle=array(
				'合同号','客户名称',
				'到期均时','最后日期',
				'结算金额','一月内到期',
				'3月内到期','6月内到期',
				'1年内到期','1年以上到期',
				'一月内占比','3月内占比',
				'6月内占比','1年内占比',
				'1年以上占比','总待收本金',
				'总待收利息',
			);
			$keyName=array(
				'agree_num','cname',
				'Dqjs','MaxDate',
				'ResultMoney','OneMonth',
				'ThreeMonth','SixMonth',
				'OneYear','OutOfOneYear',
				'OneMonthZb','ThreeMonthZb',
				'SixMonthZb','OneYearZb',
				'OutOfOneYearZb','Bj',
				'Lx',
			);
			download($outVal,$cellTitle,$keyName,'待收清单');
		}
        
        
		$count=count($outVal);
		$Sum['CCount']=$count;
		$Page = new \Think\Page($count,10);
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		
		$outVal=array_slice($outVal, $Page->firstRow,$Page->listRows);



		$show = $Page->show();
		$this->assign('page',$show);
		$this->assign('out',$outVal);
		$this->assign('Sum',$Sum);
		
		
		$this->display();
	}
	
	public function YsList(){

		//注入栏目
		$Items='YsList';
		$this->assign('Items',$Items);



		$ClientAgree=D('ClientAgreeView');
        $ClientAgreeInfo=$ClientAgree->where('Fhk_hk.hk_term=Fhk_receive.receive_term and receive_date is null and '.time().'>hk_date')->group('Fhk_hk.agree_num')->select();
        $ClientAgreeInfo2=$ClientAgree->where('Fhk_hk.hk_term=Fhk_receive.receive_term and receive_date is null and '.time().'>hk_date')->select();
        foreach($ClientAgreeInfo as $ko=>$vo)
        {
        	$Yqjs_Top=0;
        	$outVal[$ko]['MaxTime']=0;
        	$Yqjs_Top=0;
			$outVal[$ko]['ResultMoney']=0;
			$outVal[$ko]['OneWeek']=0;
			$outVal[$ko]['OneMonth']=0;
			$outVal[$ko]['ThreeMonth']=0;
			$outVal[$ko]['OutOfThreeMonth']=0;
			$outVal[$ko]['Lx']=0;
			$outVal[$ko]['Bj']=0;
			$outVal[$ko]['agree_hk']=0;
			$outVal[$ko]['agree_num']=$vo['agree_num'];
            $outVal[$ko]['cname']=$vo['cname'];
            $outVal[$ko]['CalcFx']=0;

            foreach($ClientAgreeInfo2 as $k=>$v)
            {
            	
                if($v['agree_num']==$vo['agree_num'])
                {
                    $Yqjs_Top+=$v['result_money']*floor((time()-$v['hk_date'])/(60*60*24));
                    $outVal[$ko]['ResultMoney']+=$v['result_money'];
                    $Sum['ResultMoneySum']+=$v['result_money'];
                    $Sum['LxSum']+=$v['fac_hx'];
                    $outVal[$ko]['Lx']+=$v['fac_hx'];
                    $Sum['BjSum']+=$v['fac_hb'];
                    $outVal[$ko]['Bj']+=$v['fac_hb'];
                    $outVal[$ko]['agree_hk']+=$v['agree_hk'];
                    $Sum['agree_hkSum']+=$v['agree_hk'];
                    if(floor((time()-$v['hk_date'])/(60*60*24))>$outVal[$ko]['MaxTime'])
						$outVal[$ko]['MaxTime']=floor((time()-$v['hk_date'])/(60*60*24));
					if((floor((time()-$v['hk_date'])/(60*60*24)) >= 0) && ((floor((time()-$v['hk_date'])/(60*60*24)) <= 7)))
					{
						$Sum['OneWeekSum']+=$v['result_money'];
						$outVal[$ko]['OneWeek']+=$v['result_money'];
					}
					if(floor((time()-$v['hk_date'])/(60*60*24)) <= 15)
					{
						$outVal[$ko]['CalcFx']+=$v['result_money']*0.04*floor((time()-$v['hk_date'])/(60*60*24));
						$Sum['CalcFxSum']+=$v['result_money']*0.04*floor((time()-$v['hk_date'])/(60*60*24));
					}
					if(floor((time()-$v['hk_date'])/(60*60*24)) > 15)
					{
						$outVal[$ko]['CalcFx']+=$v['result_money']*0.05*floor((time()-$v['hk_date'])/(60*60*24));
						$Sum['CalcFxSum']+=$v['result_money']*0.05*floor((time()-$v['hk_date'])/(60*60*24));
					}
					if((floor((time()-$v['hk_date'])/(60*60*24)) > 7) and ((floor((time()-$v['hk_date'])/(60*60*24)) <= 30)))
					{
						$Sum['OneMonthSum']+=$v['result_money'];
						$outVal[$ko]['OneMonth']+=$v['result_money'];
					}
					if((floor((time()-$v['hk_date'])/(60*60*24)) >= 30) and ((floor((time()-$v['hk_date'])/(60*60*24)) <= 91)))
					{
						$Sum['ThreeMonthSum']+=$v['result_money'];
						$outVal[$ko]['ThreeMonth']+=$v['result_money'];
					}
					if(floor((time()-$v['hk_date'])/(60*60*24)) > 91)
					{
						$Sum['OutOfThreeMonthSum']+=$v['result_money'];
						$outVal[$ko]['OutOfThreeMonth']+=$v['result_money'];
					}
                }
            }
            $outVal[$ko]['Yqjs']=$outVal[$ko]['ResultMoney']==0?0:$Yqjs_Top/$outVal[$ko]['ResultMoney'];
            $outVal[$ko]['OneWeekZb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['OneWeek']/$outVal[$ko]['ResultMoney']*100,2).'%';
            $outVal[$ko]['OneMonthZb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['OneMonth']/$outVal[$ko]['ResultMoney']*100,2).'%';
            $outVal[$ko]['ThreeMonthZb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['ThreeMonth']/$outVal[$ko]['ResultMoney']*100,2).'%';
            $outVal[$ko]['OutOfThreeMonthZb']=$outVal[$ko]['ResultMoney']==0?0:round($outVal[$ko]['OutOfThreeMonth']/$outVal[$ko]['ResultMoney']*100,2).'%';
        }

        //导出
		if(isset($_GET['action'])&&$_GET['action']=='export')
		{
			foreach($outVal as $k=>$v)
			{
				$outVal[$k]['Yqjs']=floor($v['Yqjs']);
			}
			$cellTitle=array(
				'合同号','客户名称',
				'逾期均时','最长逾期',
				'总应收金额','合同金额',
				'一周内金额','逾1月内',
				'逾3月内','逾3月外',
				'一周内比','1月内比',
				'3月内比','3月外比',
				'总逾利息','总逾本金',
				'计算罚息'
			);
			$keyName=array(
				'agree_num','cname',
				'Yqjs','MaxTime',
				'ResultMoney','agree_hk',
				'OneWeek','OneMonth',
				'ThreeMonth','OutOfThreeMonth',
				'OneWeekZb','OneMonthZb',
				'ThreeMonthZb','OutOfThreeMonthZb',
				'Lx','Bj',
				'CalcFx'
			);
			download($outVal,$cellTitle,$keyName,'应收清单');
		}
		$count=count($outVal);
		$Sum['CCount']=$count;
		$Page = new \Think\Page($count,10);
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		
		$outVal=array_slice($outVal, $Page->firstRow,$Page->listRows);

		$show = $Page->show();
		$this->assign('page',$show);
		$this->assign('out',$outVal);
		$this->assign('Sum',$Sum);

		
		$this->display();
		
	}


	public function YsDetail(){

		$ClientAgree=D('ClientAgreeView');
		$count=$ClientAgree->where('Fhk_hk.hk_term=Fhk_receive.receive_term and receive_date is null and hk_date<'.time())->count();
		$Page = new \Think\Page($count,10);
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$show = $Page->show();
		$ClientAgreeInfo=$ClientAgree->where('Fhk_hk.hk_term=Fhk_receive.receive_term and receive_date is null and hk_date<'.time())->limit($Page->firstRow.','.$Page->listRows)->select();



		$this->assign('ClientAgreeInfo',$ClientAgreeInfo);
		$this->assign('page',$show);

		//注入栏目
		$Items='YsList';
		$this->assign('Items',$Items);

		$out=$ClientAgree->where('Fhk_hk.hk_term=Fhk_receive.receive_term and receive_date is null and hk_date<'.time())->select();

		//导出
		if(isset($_GET['action'])&&$_GET['action']=='export')
		{
			foreach($out as $ko=>$vo)
			{
				$outVal[$ko]['agree_num']=$vo['agree_num'];
				$outVal[$ko]['hk_term']=$vo['hk_term'];
				$outVal[$ko]['ResultMoney']=$vo['result_money'];
				$outVal[$ko]['Htje']=$vo['result_money'];
				$outVal[$ko]['hzSum']=$vo['hz_bj']+$vo['hzlx'];
				$outVal[$ko]['fx']=$vo['fx'];
				$outVal[$ko]['hk_date']=date('Y-m-d',$vo['hk_date']);
				if(time() > $vo['hk_date'])
					$outVal[$ko]['Yqts']=floor((time()-$vo['hk_date'])/(60*60*24));
				else
					$outVal[$ko]['Yqts']=floor((time()-$vo['hk_date'])/(60*60*24));
			}
			$cellTitle=array(
				'合同号','还款期数',
				'结算金额','合同金额',
				'坏账金额','逾息罚息',
				'应收日期','逾期天数',
			);
			$keyName=array(
				'agree_num','hk_term',
				'ResultMoney','Htje',
				'hzSum','fx',
				'hk_date','Yqts',
			);
			download($outVal,$cellTitle,$keyName,'应收明细');
		}

		$this->display();
	}
	
	public function AlreadyList(){
		

		//注入栏目
		$Items='AlreadyList';
		$this->assign('Items',$Items);

		$startTime=empty(I('post.starttime'))?'1 and ':'receive_date>'.strtotime(I('post.starttime')).' and ';
		$endTime=empty(I('post.endtime'))?'1':'receive_date<'.strtotime(I('post.endtime'));
		$search=$startTime.$endTime;

		$ClientAgree=D('ClientAgreeView');
        $ClientAgreeInfo=$ClientAgree->where('Fhk_hk.hk_term=Fhk_receive.receive_term and receive_date is not null and '.$search)->group('Fhk_hk.agree_num')->select();
        $ClientAgreeInfo2=$ClientAgree->where('Fhk_hk.hk_term=Fhk_receive.receive_term and receive_date is not null and '.$search)->select();
        foreach($ClientAgreeInfo as $ko=>$vo)
        {
        	$Ysjs_Top=0;
        	$outVal[$ko]['ResultMoney']=0;
        	$outVal[$ko]['FacHb']=0;
        	$outVal[$ko]['FacHx']=0;
        	$outVal[$ko]['AgreeHb']=0;
        	$outVal[$ko]['AgreeHx']=0;
        	$outVal[$ko]['HzBj']=0;
        	$outVal[$ko]['HzLx']=0;
        	$outVal[$ko]['Tqqx']=0;
        	$outVal[$ko]['Wyj']=0;
        	$outVal[$ko]['Fx']=0;
        	$outVal[$ko]['agree_num']=$vo['agree_num'];
            $outVal[$ko]['cname']=$vo['cname'];
            foreach($ClientAgreeInfo2 as $k=>$v)
            {
                if($v['agree_num']==$vo['agree_num'])
                {
                    $Ysjs_Top+=$v['result_money']*floor(($v['receive_date']-$v['hk_date'])/(60*60*24));
                    $outVal[$ko]['ResultMoney']+=$v['result_money'];
                    $Sum['ResultMoneySum']+=$v['result_money'];
                    $outVal[$ko]['FacHb']+=$v['fac_hb'];
                    $Sum['FacHbSum']+=$v['fac_hb'];
                    $outVal[$ko]['FacHx']+=$v['fac_hx'];
                    $Sum['FacHxSum']+=$v['fac_hx'];
                    $outVal[$ko]['AgreeHb']+=$v['agree_hb'];
                    $Sum['AgreeHbSum']+=$v['agree_hb'];
                    $outVal[$ko]['AgreeHx']+=$v['agree_hx'];
                    $Sum['AgreeHxSum']+=$v['agree_hx'];
                    $outVal[$ko]['HzBj']+=$v['hz_bj'];
                    $Sum['HzBjSum']+=$v['hz_bj'];
                    $outVal[$ko]['HzLx']+=$v['hzlx'];
					$Sum['HzLxSum']+=$v['hzlx'];
					$outVal[$ko]['Tqqx']+=$v['tqhkqx'];
					$Sum['TqqxSum']+=$v['tqhkqx'];
					$outVal[$ko]['Wyj']+=$v['wyj'];
					$Sum['WyjSum']+=$v['wyj'];
					$outVal[$ko]['Fx']+=$v['fx'];
					$Sum['FxSum']+=$v['fx'];
                }
            }
            $outVal[$ko]['Ysjs']=$outVal[$ko]['ResultMoney']==0?0:$Ysjs_Top/$outVal[$ko]['ResultMoney'];
        }

        //导出
		if(isset($_GET['action'])&&$_GET['action']=='export')
		{
			foreach($outVal as $k=>$v)
			{
				$outVal[$k]['Ysjs']=floor($v['Ysjs']);
			}
			$cellTitle=array(
				'合同号','客户名称',
				'结算金额','实际还本',
				'实际还息','合同还本',
				'合同还息','坏账本金',
				'坏账利息','提前去息',
				'违约金','逾息罚息',
				'收款均时',
			);
			$keyName=array(
				'agree_num','cname',
				'ResultMoney','FacHb',
				'FacHx','AgreeHb',
				'AgreeHx','HzBj',
				'HzLx','Tqqx',
				'Wyj','Fx',
				'Ysjs',
			);
			download($outVal,$cellTitle,$keyName,'已收清单');
		}
        
		$count=count($outVal);
		$Sum['CCount']=$count;
		$Page = new \Think\Page($count,10);
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		
		$outVal=array_slice($outVal, $Page->firstRow,$Page->listRows);


		

		$show = $Page->show();
		$this->assign('page',$show);
		$this->assign('out',$outVal);
		$this->assign('Sum',$Sum);

		
		$this->display();
	}
	
	
	public function TcList(){

		//注入栏目
		$Items='TcList';
		$this->assign('Items',$Items);

		$user=M('User');
		$userInfo=$user->field('id,xingming')->select();
		$this->assign('userinfo',$userInfo);

		$startTime=empty(I('post.starttime'))?'1 and ':'tp_fhk_receive.receive_date>'.strtotime(I('post.starttime')).' and ';
		$endTime=empty(I('post.endtime'))?'1':'tp_fhk_receive.receive_date<'.strtotime(I('post.endtime'));
		$search=$startTime.$endTime;

		$ReAgreeModel=D();
		$ReAgreeInfo=$ReAgreeModel->query("
			SELECT 
				sum(tc_money) as tc_sum,tp_fhk_agree.agree_num,saler,tp_user.id
			FROM 
				tp_fhk_receive join tp_fhk_agree join tp_user
			ON 
				tp_fhk_agree.agree_num=tp_fhk_receive.agree_num and tp_user.id=tp_fhk_agree.saler
			AND
				".$search."
			GROUP BY
				tp_fhk_agree.saler;
		");

		// var_dump($ReAgreeInfo);
		$this->assign('ReAgreeInfo',$ReAgreeInfo);
		$this->display();
	}

	public function TcDetail(){
		$id=I('get.id');
		$startTime=empty(I('post.starttime'))?'1 and ':'receive.receive_date>'.strtotime(I('post.starttime')).' and ';
		$endTime=empty(I('post.endtime'))?'1':'receive.receive_date<'.strtotime(I('post.endtime'));
		$search=$startTime.$endTime;
		$Model=M();
		$Details=$Model->query("
			SELECT
				agree.agree_num,cname,fk_type,hk_term,tc_money,result_money,fac_hx,receive_date,hk_date,saler
			FROM
				(
					(
						tp_fhk_agree agree 
					LEFT JOIN 
						tp_fhk_receive receive 
					ON 
						agree.agree_num=receive.agree_num
					AND
						".$search."
					)
						LEFT JOIN 
							tp_fhk_client client 
						ON 
							client.agree_num=agree.agree_num
				)
					LEFT JOIN 
						tp_fhk_hk hk 
					ON 
						receive.agree_num=hk.agree_num
					AND
						hk_term=receive_term
					WHERE
						saler=(
								SELECT 
									id 
								FROM 
									tp_user 
								WHERE 
									tp_user.id=".$id."
								AND 
									tc_money IS NOT NULL 
								AND 
									tc_money<>0
								)
					GROUP BY hk.hk_term;
		");
		//导出
		if(isset($_GET['action'])&&$_GET['action']=='export')
		{
			foreach($Details as $k=>$v)
			{
				$export[$k]['agree_num']=$v['agree_num'];
				$export[$k]['hk_term']=$v['hk_term'];
				$export[$k]['tc_money']=$v['tc_money'];
				$export[$k]['cname']=$v['cname'];
				if($v['fk_type']==1)
					$export[$k]['fk_type']='信用';
				if($v['fk_type']==2)
					$export[$k]['fk_type']='抵押';
				if($v['fk_type']==2)
					$export[$k]['fk_type']='担保';
				$export[$k]['result_money']=$v['result_money'];
				$export[$k]['fac_hx']=$v['fac_hx'];
				$export[$k]['dis_day']=floor(($v['receive_date']-$v['hk_date'])/(60*60*24));
			}
			$cellTitle=array(
				'合同号','期数',
				'提成金额','客户名称',
				'放款类型','结算金额',
				'实际利息','距离日期',
			);
			$keyName=array(
				'agree_num','hk_term',
				'tc_money','cname',
				'fk_type','result_money',
				'fac_hx','dis_day',
			);
			
			download($export,$cellTitle,$keyName,$Details[0]['saler'].'提成明细');
		}
		$count=count($Details);
		$Page = new \Think\Page($count,10);
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$show = $Page->show();
		$outVal=$Model->query("
			SELECT
				agree.agree_num,cname,fk_type,hk_term,tc_money,result_money,fac_hx,receive_date,hk_date,saler
			FROM
				(
					(
						tp_fhk_agree agree 
					LEFT JOIN 
						tp_fhk_receive receive 
					ON
					 	agree.agree_num=receive.agree_num
					AND
						".$search."
					)
						LEFT JOIN 
							tp_fhk_client client 
						ON 
							client.agree_num=agree.agree_num
				)
					LEFT JOIN 
						tp_fhk_hk hk 
					ON 
						receive.agree_num=hk.agree_num
					AND
						hk_term=receive_term
					WHERE
						saler=(
								SELECT 
									id 
								FROM 
									tp_user 
								WHERE 
									tp_user.id=".$id."
								AND 
									tc_money IS NOT NULL 
								AND 
									tc_money<>0
								)
			GROUP BY hk.hk_term
			ORDER BY receive.receive_date ASC
			LIMIT ".$Page->firstRow.",".$Page->listRows.";
		");
		
		
		$this->assign('outVal',$outVal);
		$this->assign('page',$show);
		$this->display();
	}
}
?>