<?php
namespace Home\Controller;
use Think\Controller;

class DksqController extends Controller {
	/*控制器初始化*/
	public function _initialize(){
		if(!session('?name')){
        	redirect(U('Login/index'));
        }else{
        	$user['xingming'] = session('xingming');
			$user['bumeng'] = session('bumeng');
			$user['username'] = session('name');
			$this->assign('user',$user);
			

			//贷款申请访问权限
			if(!auth_check('dksq')){
				$this->error('无访问权限');
			}


			//内信
			$MessageTable=M('UserMessage');
			$MessageCount=$MessageTable->where('getid='.session('uid').' and status=0')->count();
			$this->assign('MessageCount',$MessageCount);
			
			$daohang = 'dksq';
			$this->assign('daohang',$daohang);
        }
	}

	/*贷款申请首页（申请列表）*/
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
		
		$Dksq_sq=D('Match0View');
		$count = $Dksq_sq->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$show = $Page->show();// 分页显示输出
		$list=$Dksq_sq->order($paixu)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		
		$daohang2 = 'dksq_index';
		$this->assign('daohang2',$daohang2);
		
		$this -> display();
	}
	
	
	/*申请人列表*/
	public function sqrlist() {
		$p = I($get.p);//当前页码
		$xg = I($get.xg);
		 if(!empty($xg)){//用于证件号码修改
		 	$this->assign('xg',$xg);
		 }
		 $this->assign('p',$p);
		 
		
		$Dksq_grzl = M('Dksq_grzl');
		$count = $Dksq_grzl->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$show = $Page->show();// 分页显示输出
		
		$list=$Dksq_grzl->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		
		$daohang2 = 'dksq_sqrlist';
		$this->assign('daohang2',$daohang2);
		
		$this -> display();
	}
	
	/*申请人修改证件号码*/
	public function zjhmxiugai(){
		if(!IS_POST){
			$this->error('页面不存在！',U('Index/index'));
		}
		
		$post = I('post.');
		
		if($post['newzjhm'] == null){
			$this->error('证件号码不能为空！');
		}
			
		$Dksq_grzl = M('Dksq_grzl');
		$new_tj['zjhm'] = $post['newzjhm'];
		if($Dksq_grzl->where($new_tj)->find() != null){
			$this->error('证件号码已存在！');
		}
		
		$old_tj['id'] = $post['grzl_id'];
		
		//(更新时外键约束（CASCADE），只需更新个人资料表)
		if($Dksq_grzl->where($old_tj)->setField($new_tj)){
			
			/*写入用户操作日志begin*/
			$log['chaozuo'] = '修改申请人ID为['.$post['grzl_id'].']的证件号码';
			$Userlog = new \Home\Common\Userlog();
			$Userlog->save($log);
			/*写入用户操作日志end*/
			
			$p = $post['p'];//当前页码
			$this->success('证件号码修改成功',U('Dksq/sqrlist','','').'?p='.$p);
		}
			
	}
	
	
	/*ajax审批*/
	public function prev(){
		//贷款申请审批权限
			if(!auth_check('dksq_shengpi')){
				$data['spqx']=0;
				$this->ajaxReturn($data);
			}
		
		if(IS_AJAX)
		{
			$sq['id']=I('get.sq');
			$Dksq_sq=M('Dksq_sq');
			$is_modify=$Dksq_sq->where($sq)->getField('result');//获取result的字段值，如果为0待审批状态则审批
			if($is_modify==0)
			{
				$checkValue=I('post.checkValue');
				$data=array(
					'prevlimit'=>I('post.prevLimit'),
					'pretime'=>I('post.deadLine'),
					'result'=>$checkValue,
				);
				if($checkValue!=2)
				{
					$data['prevlimit']==""?$this->error('请设置审批额度!'):'';
					$data['pretime']==""?$this->error('请设置审批期限!'):'';
				}else{
					$data['prevlimit']="";
					$data['pretime']="";
				}
				$Dksq_sq=M('Dksq_sq');
				if($Dksq_sq->where($sq)->data($data)->save()){
					$data['sqid']=M('Dksq_sq')->where($sq)->getField('sqid');
					$data['hkstatus']=M('Dksq_sq')->where($sq)->getField('hkstatus');
					$data['status']=1;
					
					/*写入用户操作日志begin*/
					$log['chaozuo'] = '审批申请ID为['.$sq['id'].']的借款';
					$Userlog = new \Home\Common\Userlog();
					$Userlog->save($log);
					/*写入用户操作日志end*/
					
						$this->ajaxReturn($data);
				}
			}else
				$data['status']=0;
			$this->ajaxReturn($data);
		}
		else
		{
			$this->error('非法访问!');
		}
	}
	
	
	
	/*贷款申请添加-修改*/
	public function add(){
		$id = I($get.sq);
		
		if($id != null){//修改页
			//贷款申请修改权限
			if(!auth_check('dksq_xiugai')){
				$this->error('无修改权限');
			}
			
			
			$Dksq_sq = M('Dksq_sq');
			$tj_sq['id'] = $id;
			$sq = $Dksq_sq->where($tj_sq)->find();
			
//			$quanxian = session('quanxian');
//			if($sq['luru'] != session('name') & $quanxian != 200 & $quanxian != 21){
//				$this->error('只能修改自己录入的资料');
//			}
			
			$this->assign('list',$sq);
			
			$tj['zjhm'] = $sq['zjhm'];
			// 个人资料
			$Dksq_grzl = M('Dksq_grzl');
			$grzl = $Dksq_grzl->where($tj)->find();
			$this->assign('grzl',$grzl);
			
			//住宅信息
			$Dksq_zhuzai = M('Dksq_zhuzai');
			$zhuzai = $Dksq_zhuzai->where($tj)->select();
			$this->assign('zhuzai',$zhuzai);
			
			//职业资料
			$Dksq_zyzl = M('Dksq_zyzl');
			$danwei = $Dksq_zyzl->where($tj)->select();
			$this->assign('danwei',$danwei);
			
	//		房产资料
			$Dksq_fczl = M('Dksq_fczl');
			$fczl = $Dksq_fczl->where($tj)->find();
			$this->assign('fczl',$fczl);
			
	//		联系人资料
			$Dksq_nxrzl = M('Dksq_nxrzl');
			$nxrzl = $Dksq_nxrzl->where($tj)->select();
			$this->assign('lxr',$nxrzl);
			
			$daohang2 = 'dksq_index';
			$this->assign('daohang2',$daohang2);
			
			$this->display();
		}else{//添加页
			//贷款申请添加权限
			if(!auth_check('dksq_add')){
				$this->error('无添加权限');
			}
			
			$daohang2 = 'dksq_index';
			$this->assign('daohang2',$daohang2);
			
			$this->display();
		}
	}
	/*贷款申请添加---提交*/
	public function addAction(){
		if(!IS_POST){
			$this->error('页面不存在！',U('Index/index'));
		}

		$post = I('post.');
		
		//贷款申请基本信息
		$sq['sqid'] = $post['sqid'];
		$sq['sqtype'] = $post['sqtype'];
		$sq['sqje'] = $post['sqje'];
		$sq['qixian'] = $post['qixian'];
		$sq['yongtu'] = $post['yongtu'];
		$sq['laiyuan'] = $post['laiyuan'];
		$mdate = mk_time($post['sqdate']);
		$sq['sqdate'] = $mdate;
		$sq['hkstatus']=$post['hkstatus'];
		//个人资料
		$grzl['xingming'] = $post['xingming'];
		$grzl['age'] = $post['age'];
		$grzl['sex'] = $post['sex'];
		$grzl['hyzk'] = $post['hyzk'];
		$grzl['zjtype'] = $post['zjtype'];
		$grzl['sbhm'] = $post['sbhm'];
		$grzl['jzz'] = $post['jzz'];
		$grzl['csdate'] = mk_time($post['csdate']);
		$grzl['hukou'] = $post['hukou'];
		$grzl['jiguan'] = $post['jiguan'];
		$grzl['jycd'] = $post['jycd'];
		$grzl['email'] = $post['email'];
		$grzl['zxdk'] = $post['zxdk'];
		//配偶资料
		$grzl['matexm'] = $post['matexm'];
		$grzl['mateage'] = $post['mateage'];
		$grzl['matephone'] = $post['matephone'];
		$grzl['matemsr'] = $post['matemsr'];
		$grzl['matedw'] = $post['matedw'];
		$grzl['matedwdz'] = $post['matedwdz'];
		$grzl['matezw'] = $post['matezw'];
		$grzl['matedwtel'] = $post['matedwtel'];
		//房产资料
		$fczl['fcdizhi'] = $post['fcdizhi'];
		$fczl['gmtype'] = $post['gmtype'];
		$fczl['gmdate'] = mk_time($post['gmdate']);
		$fczl['mianji'] = $post['mianji'];
		$fczl['bank'] = $post['bank'];
		$fczl['goumai'] = $post['goumai'];
		$fczl['dknianxian'] = $post['dknianxian'];
		$fczl['mhuankuan'] = $post['mhuankuan'];
		$fczl['dkze'] = $post['dkze'];
		$fczl['yue'] = $post['yue'];
		
		
		$gxtj[id] = $post['id'];
		if(!empty($gxtj[id])){//修改
			$xiugai_tj['zjhm'] = $post['zjhm'];	
			//个人资料//配偶资料
				$Dksq_grzl = M('Dksq_grzl');
				$Dksq_grzl->where($xiugai_tj)->setField($grzl);
			//贷款申请基本信息
				$Dksq_sq = M('Dksq_sq');
  				$Dksq_sq->where($xiugai_tj)->setField($sq);
			//住宅信息
				$Dksq_zhuzai = M('Dksq_zhuzai');
				$zhuzaiid_1['id'] = $post['zhuzaiid_1'];
				$zhuzaiid_2['id'] = $post['zhuzaiid_2'];
				
				$zhuzai1['adress'] = $post['adress_1'];
				$zhuzai1['jzsj'] = $post['jzsj_1'];
				$zhuzai1['zztel'] = $post['zztel_1'];
				$zhuzai1['phone'] = $post['phone_1'];
				$zhuzai1['zztype'] = $post['zztype_1'];
				$zhuzai1['myhk'] = $post['myhk_1'];
				$zhuzai1['ysjz'] = $post['ysjz_1'];
				
				$zhuzai2['adress'] = $post['adress_2'];
				$zhuzai2['jzsj'] = $post['jzsj_2'];
				$zhuzai2['zztel'] = $post['zztel_2'];
				$zhuzai2['phone'] = $post['phone_2'];
				$zhuzai2['zztype'] = $post['zztype_2'];
				$zhuzai2['myhk'] = $post['myhk_2'];
				$zhuzai2['ysjz'] = $post['ysjz_2'];
				
				$Dksq_zhuzai->where($zhuzaiid_1)->setField($zhuzai1);//更新住宅一
				
				if(empty($zhuzaiid_2['id'])){//住宅二是新增
					if($post['adress_2'] != null){
						$zhuzai2['zjhm'] = $post['zjhm'];
						$Dksq_zhuzai->add($zhuzai2);
					}
				}else{//住宅二是修改
					$Dksq_zhuzai->where($zhuzaiid_2)->setField($zhuzai2);//更新住宅二
				}
				
				//职业资料/公司资料
				$Dksq_zyzl = M('Dksq_zyzl');
				$zyzlid_1['id'] = $post['zyzlid_1'];
				$zyzlid_2['id'] = $post['zyzlid_2'];
				
					$zyzl1['dwmc'] = $post['dwmc_1'];
					$zyzl1['dwyb'] = $post['dwyb_1'];
					$zyzl1['dwdz'] = $post['dwdz_1'];
					$zyzl1['dwxingzi'] = $post['dwxingzi_1'];
					$zyzl1['dwtel'] = $post['dwtel_1'];
					$zyzl1['dwcz'] = $post['dwcz_1'];
					$zyzl1['wangzhi'] = $post['wangzhi_1'];
					$zyzl1['zhiwu'] = $post['zhiwu_1'];
					$zyzl1['hylb'] = $post['hylb_1'];
					$zyzl1['fwns'] = $post['fwns_1'];
					$zyzl1['bumen'] = $post['bumen_1'];
					$zyzl1['mshouru'] = $post['mshouru_1'];
					$zyzl1['mzxdate'] = $post['mzxdate_1'];
					$zyzl1['zftype'] = $post['zftype_1'];
					$zyzl1['gttype'] = $post['gttype_1'];
					$zyzl1['gongshangnum'] = $post['gongshangnum_1'];
					$zyzl1['jycs'] = $post['jycs_1'];
					$zyzl1['yuegong'] = $post['yuegong_1'];
					$zyzl1['cldate'] = mk_time($post['cldate_1']);
					$zyzl1['guoshuinum'] = $post['guoshuinum_1'];
					$zyzl1['guyuan'] = $post['guyuan_1'];
					$zyzl1['yingli'] = $post['yingli_1'];
				$Dksq_zyzl->where($zyzlid_1)->setField($zyzl1);//更新单位一
				
					$zyzl2['dwmc'] = $post['dwmc_2'];
					$zyzl2['dwyb'] = $post['dwyb_2'];
					$zyzl2['dwdz'] = $post['dwdz_2'];
					$zyzl2['dwxingzi'] = $post['dwxingzi_2'];
					$zyzl2['dwtel'] = $post['dwtel_2'];
					$zyzl2['dwcz'] = $post['dwcz_2'];
					$zyzl2['wangzhi'] = $post['wangzhi_2'];
					$zyzl2['zhiwu'] = $post['zhiwu_2'];
					$zyzl2['hylb'] = $post['hylb_2'];
					$zyzl2['fwns'] = $post['fwns_2'];
					$zyzl2['bumen'] = $post['bumen_2'];
					$zyzl2['mshouru'] = $post['mshouru_2'];
					$zyzl2['mzxdate'] = $post['mzxdate_2'];
					$zyzl2['zftype'] = $post['zftype_2'];
					$zyzl2['gttype'] = $post['gttype_2'];
					$zyzl2['gongshangnum'] = $post['gongshangnum_2'];
					$zyzl2['jycs'] = $post['jycs_2'];
					$zyzl2['yuegong'] = $post['yuegong_2'];
					$zyzl2['cldate'] = mk_time($post['cldate_2']);
					$zyzl2['guoshuinum'] = $post['guoshuinum_2'];
					$zyzl2['guyuan'] = $post['guyuan_2'];
					$zyzl2['yingli'] = $post['yingli_2'];
					
				
				if(empty($zyzlid_2['id'])){//单位二是新增
					if($post['dwmc_2'] != null){
						$zyzl2['zjhm'] = $post['zjhm'];
						$Dksq_zyzl->add($zyzl2);
					}
				}else{//单位二是修改
					$Dksq_zyzl->where($zyzlid_2)->setField($zyzl2);//更新住宅二
				}
				
//				房产资料
				$Dksq_fczl = M('Dksq_fczl');
  				$Dksq_fczl->where($xiugai_tj)->setField($fczl);
				
//				联系人资料
				$Dksq_nxrzl = M('Dksq_nxrzl');
				$lxrid_1['id'] = $post['lxrid_1'];
				$lxrid_2['id'] = $post['lxrid_2'];
				$lxrid_3['id'] = $post['lxrid_3'];
				
					$lxr1['nxname'] = $post['nxname_1'];
					$lxr1['nxguanxi'] = $post['nxguanxi_1'];
					$lxr1['nxage'] = $post['nxage_1'];
					$lxr1['nxzztel'] = $post['nxzztel_1'];
					$lxr1['nxphone'] = $post['nxphone_1'];
					$lxr1['nxzhuzhi'] = $post['nxzhuzhi_1'];
					$lxr1['nxdwmc'] = $post['nxdwmc_1'];
					$lxr1['nxzhiwu'] = $post['nxzhiwu_1'];
					$lxr1['nxdwtel'] = $post['nxdwtel_1'];
				
				$Dksq_nxrzl->where($lxrid_1)->setField($lxr1);//更新联系人一
				
					$lxr2['nxname'] = $post['nxname_2'];
					$lxr2['nxguanxi'] = $post['nxguanxi_2'];
					$lxr2['nxage'] = $post['nxage_2'];
					$lxr2['nxzztel'] = $post['nxzztel_2'];
					$lxr2['nxphone'] = $post['nxphone_2'];
					$lxr2['nxzhuzhi'] = $post['nxzhuzhi_2'];
					$lxr2['nxdwmc'] = $post['nxdwmc_2'];
					$lxr2['nxzhiwu'] = $post['nxzhiwu_2'];
					$lxr2['nxdwtel'] = $post['nxdwtel_2'];
				if(empty($lxrid_2['id'])){//联系人二是新增
					if($post['nxname_2'] != null){
						$lxr2['zjhm'] = $post['zjhm'];
						$Dksq_nxrzl->add($lxr2);
					}
				}else{//联系人二是修改
					$Dksq_nxrzl->where($lxrid_2)->setField($lxr2);//更新联系人二
				}
				
					$lxr3['nxname'] = $post['nxname_3'];
					$lxr3['nxguanxi'] = $post['nxguanxi_3'];
					$lxr3['nxage'] = $post['nxage_3'];
					$lxr3['nxzztel'] = $post['nxzztel_3'];
					$lxr3['nxphone'] = $post['nxphone_3'];
					$lxr3['nxzhuzhi'] = $post['nxzhuzhi_3'];
					$lxr3['nxdwmc'] = $post['nxdwmc_3'];
					$lxr3['nxzhiwu'] = $post['nxzhiwu_3'];
					$lxr3['nxdwtel'] = $post['nxdwtel_3'];
				if(empty($lxrid_3['id'])){//联系人三是新增
					if($post['nxname_3'] != null){
						$lxr3['zjhm'] = $post['zjhm'];
						$Dksq_nxrzl->add($lxr3);
					}
				}else{//联系人三是修改
					$Dksq_nxrzl->where($lxrid_3)->setField($lxr3);//更新联系人三
				}
				
			/*写入用户操作日志begin*/
			$log['chaozuo'] = '修改申请ID为['.$post['id'].']的借款信息';
			$Userlog = new \Home\Common\Userlog();
			$Userlog->save($log);
			/*写入用户操作日志end*/
				
			$this->success('修改成功',U('Dksq/index'));
		}else{//添加
			if($post['zjhm'] == null){
				$this->error('证件号码不能为空！');
			}
			
			$Dksq_grzl = M('Dksq_grzl');
			$only_tj['zjhm'] = $post['zjhm'];
			if($Dksq_grzl->where($only_tj)->find() != null){
				$this->error('证件号码已存在！');
			}
			
			//个人资料//配偶资料
				$grzl['zjhm'] = $post['zjhm'];
				$Dksq_grzl->add($grzl);
			//贷款申请基本信息
			$Dksq_sq = M('Dksq_sq');
				$sq['zjhm'] = $post['zjhm'];
				$luru = session('name');
				$sq['luru'] = $luru;
				$sq['lurutime'] = NOW_TIME;
  			$Dksq_sq->add($sq);
			//住宅信息
			$Dksq_zhuzai = M('Dksq_zhuzai');
				$zhuzai[] = array(
					'zjhm'=>$post['zjhm'],
					'adress'=>$post['adress_1'],
					'jzsj'=>$post['jzsj_1'],
					'zztel'=>$post['zztel_1'],
					'phone'=>$post['phone_1'],
					'zztype'=>$post['zztype_1'],
					'myhk'=>$post['myhk_1'],
					'ysjz'=>$post['ysjz_1'],
					);
				if($post['adress_2'] != null){
					$zhuzai[] = array(
					'zjhm'=>$post['zjhm'],
					'adress'=>$post['adress_2'],
					'jzsj'=>$post['jzsj_2'],
					'zztel'=>$post['zztel_2'],
					'phone'=>$post['phone_2'],
					'zztype'=>$post['zztype_2'],
					'myhk'=>$post['myhk_2'],
					'ysjz'=>$post['ysjz_2'],
					);
				}
			$Dksq_zhuzai->addAll($zhuzai);
			//职业资料、公司资料
			$Dksq_zyzl = M('Dksq_zyzl');
				$zyzl[] = array(
					'zjhm'=>$post['zjhm'],
					'dwmc'=>$post['dwmc_1'],
					'dwyb'=>$post['dwyb_1'],
					'dwdz'=>$post['dwdz_1'],
					'dwxingzi'=>$post['dwxingzi_1'],
					'dwtel'=>$post['dwtel_1'],
					'dwcz'=>$post['dwcz_1'],
					'wangzhi'=>$post['wangzhi_1'],
					'zhiwu'=>$post['zhiwu_1'],
					'hylb'=>$post['hylb_1'],
					'fwns'=>$post['fwns_1'],
					'bumen'=>$post['bumen_1'],
					'mshouru'=>$post['mshouru_1'],
					'mzxdate'=>$post['mzxdate_1'],
					'zftype'=>$post['zftype_1'],
					'gttype'=>$post['gttype_1'],
					'gongshangnum'=>$post['gongshangnum_1'],
					'jycs'=>$post['jycs_1'],
					'yuegong'=>$post['yuegong_1'],
					'cldate'=>mk_time($post['cldate_1']),
					'guoshuinum'=>$post['guoshuinum_1'],
					'guyuan'=>$post['guyuan_1'],
					'yingli'=>$post['yingli_1'],
				);
				if($post['dwmc_2'] !=null){
					$zyzl[] = array(
					'zjhm'=>$post['zjhm'],
					'dwmc'=>$post['dwmc_2'],
					'dwyb'=>$post['dwyb_2'],
					'dwdz'=>$post['dwdz_2'],
					'dwxingzi'=>$post['dwxingzi_2'],
					'dwtel'=>$post['dwtel_2'],
					'dwcz'=>$post['dwcz_2'],
					'wangzhi'=>$post['wangzhi_2'],
					'zhiwu'=>$post['zhiwu_2'],
					'hylb'=>$post['hylb_2'],
					'fwns'=>$post['fwns_2'],
					'bumen'=>$post['bumen_2'],
					'mshouru'=>$post['mshouru_2'],
					'mzxdate'=>$post['mzxdate_2'],
					'zftype'=>$post['zftype_2'],
					'gttype'=>$post['gttype_2'],
					'gongshangnum'=>$post['gongshangnum_2'],
					'jycs'=>$post['jycs_2'],
					'yuegong'=>$post['yuegong_2'],
					'cldate'=>mk_time($post['cldate_2']),
					'guoshuinum'=>$post['guoshuinum_2'],
					'guyuan'=>$post['guyuan_2'],
					'yingli'=>$post['yingli_2'],
					);
				}
			$Dksq_zyzl->addAll($zyzl);
				
			//房产资料
			$Dksq_fczl = M('Dksq_fczl');
				$fczl['zjhm'] = $post['zjhm'];
  			$Dksq_fczl->add($fczl);
				
			//联系人资料
			$Dksq_nxrzl = M('Dksq_nxrzl');
				$nxrzl[] = array(
					'zjhm'=>$post['zjhm'],
					'nxname'=>$post['nxname_1'],
					'nxguanxi'=>$post['nxguanxi_1'],
					'nxage'=>$post['nxage_1'],
					'nxzztel'=>$post['nxzztel_1'],
					'nxphone'=>$post['nxphone_1'],
					'nxzhuzhi'=>$post['nxzhuzhi_1'],
					'nxdwmc'=>$post['nxdwmc_1'],
					'nxzhiwu'=>$post['nxzhiwu_1'],
					'nxdwtel'=>$post['nxdwtel_1'],
				);
				if($post['nxname_2'] !=null){
					$nxrzl[] = array(
					'zjhm'=>$post['zjhm'],
					'nxname'=>$post['nxname_2'],
					'nxguanxi'=>$post['nxguanxi_2'],
					'nxage'=>$post['nxage_2'],
					'nxzztel'=>$post['nxzztel_2'],
					'nxphone'=>$post['nxphone_2'],
					'nxzhuzhi'=>$post['nxzhuzhi_2'],
					'nxdwmc'=>$post['nxdwmc_2'],
					'nxzhiwu'=>$post['nxzhiwu_2'],
					'nxdwtel'=>$post['nxdwtel_2'],
				);
				}
				if($post['nxname_3'] !=null){
					$nxrzl[] = array(
					'zjhm'=>$post['zjhm'],
					'nxname'=>$post['nxname_3'],
					'nxguanxi'=>$post['nxguanxi_3'],
					'nxage'=>$post['nxage_3'],
					'nxzztel'=>$post['nxzztel_3'],
					'nxphone'=>$post['nxphone_3'],
					'nxzhuzhi'=>$post['nxzhuzhi_3'],
					'nxdwmc'=>$post['nxdwmc_3'],
					'nxzhiwu'=>$post['nxzhiwu_3'],
					'nxdwtel'=>$post['nxdwtel_3'],
				);
				}
			$adddksq = $Dksq_nxrzl->addAll($nxrzl);
			
			/*写入用户操作日志begin*/
			$log['chaozuo'] = '添加借款申请信息';
			$Userlog = new \Home\Common\Userlog();
			$Userlog->save($log);
			/*写入用户操作日志end*/
			
			$this->success('添加成功',U('Dksq/index'));
		}	
	}

	/*贷款申请查看*/
	public function chakan(){
		//贷款申请查看权限
			if(!auth_check('dksq_chakan')){
				$this->error('无查看权限');
			}
		
		$id = I('get.sq');//申请id

		$Dksq_sq = M('Dksq_sq');
		$tj_sq['id'] = $id;
		$sq = $Dksq_sq->where($tj_sq)->find();
		$this->assign('list',$sq);
		
		$tj['zjhm'] = $sq['zjhm'];
		// 个人资料
		$Dksq_grzl = M('Dksq_grzl');
		$grzl = $Dksq_grzl->where($tj)->find();
		$this->assign('grzl',$grzl);
		
		//住宅信息
		$Dksq_zhuzai = M('Dksq_zhuzai');
		$zhuzai = $Dksq_zhuzai->where($tj)->select();
		$this->assign('zhuzai',$zhuzai);
		
		//职业资料
		$Dksq_zyzl = M('Dksq_zyzl');
		$danwei = $Dksq_zyzl->where($tj)->select();
		$this->assign('danwei',$danwei);
		
//		房产资料
		$Dksq_fczl = M('Dksq_fczl');
		$fczl = $Dksq_fczl->where($tj)->find();
		$this->assign('fczl',$fczl);
		
//		联系人资料
		$Dksq_nxrzl = M('Dksq_nxrzl');
		$nxrzl = $Dksq_nxrzl->where($tj)->select();
		$this->assign('lxr',$nxrzl);
		
		$this->display();
	}

	/*贷款申请删除*/
	public function shanchu(){
		//贷款申请删除权限
			if(!auth_check('dksq_sanchu')){
				$this->error('无删除权限');
			}
		
		$id = I('get.sq');//申请id
		
		$Dksq_sq = M('Dksq_sq');
		$tj_sq['id'] = $id;
		$sq = $Dksq_sq->where($tj_sq)->find();
		$tj['zjhm'] = $sq['zjhm'];
		
		$delsq = $Dksq_sq->where($tj_sq)->delete();
		
		//住宅信息
		$Dksq_zhuzai = M('Dksq_zhuzai');
		$zhuzai = $Dksq_zhuzai->where($tj)->delete();
		//职业资料
		$Dksq_zyzl = M('Dksq_zyzl');
		$danwei = $Dksq_zyzl->where($tj)->delete();
//		房产资料
		$Dksq_fczl = M('Dksq_fczl');
		$fczl = $Dksq_fczl->where($tj)->delete();
//		联系人资料
		$Dksq_nxrzl = M('Dksq_nxrzl');
		$nxrzl = $Dksq_nxrzl->where($tj)->delete();
		
		// 个人资料
		$Dksq_grzl = M('Dksq_grzl');
		$grzl = $Dksq_grzl->where($tj)->delete();
		
		if($delsq && $grzl && $zhuzai && $danwei && $fczl && $nxrzl){
			
			/*写入用户操作日志begin*/
			$log['chaozuo'] = '删除申请ID为['.$id.']的借款信息';
			$Userlog = new \Home\Common\Userlog();
			$Userlog->save($log);
			/*写入用户操作日志end*/
			
			$this->success('删除成功！',U('Dksq/index'));
		}
	}
	
	/****************************贷款申请匹配开始********************/
	 public function match(){
	 	//贷款申请匹配权限
			if(!auth_check('dksq_match')){
				$this->error('无匹配权限');
			}
		
		$daohang2 = 'dksq_index';
		$this->assign('daohang2',$daohang2);
		
	 	$this->display();
	 }
	 
	 /*
	  * 自定义匹配函数
	  * $pbx--匹配字段
	  * $matchView--匹配视图模型
	  */
	 private function myMatch($pbx,$matchView){
	 	$post = I('post.');
	 	if($post[$pbx]){
			$tj[$pbx] = $post[$pbx];
			$data['da'] = $matchView->where($tj)->select();
		}else{
			$data['da'] = null;
		}
		return $data['da'];
	 }
	 
//	 资料匹配
	public function match_grzl(){
		if(!IS_POST){
			$this->error('页面不存在！',U('Index/index'));
		}
		
		$Match1View = D('Match1View');
		$data['xm'] = $this->myMatch('xingming',$Match1View);//		姓名匹配
		$data['hm'] = $this->myMatch('zjhm',$Match1View);//		证件号码匹配
		//配偶资料匹配
		$data['matexm'] = $this->myMatch('matexm',$Match1View);//姓名
		$data['matephone'] = $this->myMatch('matephone',$Match1View);  //联络电话
		$data['matedwtel'] = $this->myMatch('matedwtel',$Match1View); //单位电话
		$data['matedw'] = $this->myMatch('matedw',$Match1View);  //单位名称
		$data['matedwdz'] = $this->myMatch('matedwdz',$Match1View); //单位地址
		
		$Match2View = D('Match2View');
		$data['adress'] = $this->myMatch('adress',$Match2View);//		住宅地址匹配
		$data['zztel'] = $this->myMatch('zztel',$Match2View);  //住宅电话
		$data['phone'] = $this->myMatch('phone',$Match2View); //移动电话
		
		$Match3View = D('Match3View');
		$data['dwmc'] = $this->myMatch('dwmc',$Match3View);//单位名称
		$data['dwdz'] = $this->myMatch('dwdz',$Match3View);  //单位地址
		$data['dwtel'] = $this->myMatch('dwtel',$Match3View); //单位电话
		
		$Match4View = D('Match4View');
		$data['fcdizhi'] = $this->myMatch('fcdizhi',$Match4View);//房产地址
		
		$Match5View = D('Match5View');
		//联系人资料匹配
		$data['nxname'] = $this->myMatch('nxname',$Match5View);//
		$data['nxphone'] = $this->myMatch('nxphone',$Match5View);//
		$data['nxzztel'] = $this->myMatch('nxzztel',$Match5View);//
		$data['nxdwtel'] = $this->myMatch('nxdwtel',$Match5View);//
		$data['nxzhuzhi'] = $this->myMatch('nxzhuzhi',$Match5View);//
		$data['nxdwmc'] = $this->myMatch('nxdwmc',$Match5View);//
		
		
		$this->ajaxReturn($data);
		
	}
	/****************************贷款申请匹配结束********************/
}
?>













