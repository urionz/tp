<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class AuthController extends Controller{
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
			if(!auth_check('auth')){
				$this->error('无访问权限');
			}

			//内信
			$MessageTable=M('UserMessage');
			$MessageCount=$MessageTable->where('getid='.session('uid').' and status=0')->count();
			$this->assign('MessageCount',$MessageCount);
			
			$daohang = 'auth';
			$this->assign('daohang',$daohang);
        }
	}
	
	
	
	
	
	
//	用户组列表
	public function index(){
		$Auth_group = M('Auth_group');
		$count = $Auth_group->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$show = $Page->show();// 分页显示输出
		$list = $Auth_group->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		$this->display();
	}
	
	//	添加用户组
	public function groupAdd(){
		
		if(IS_POST)
		{
			$Auth_group=M('Auth_group');
			$data=array(
				'title'=>I('post.groupname'),
				'rules'=>join(',',I('post.rulesbox')),
				'info'=>I('post.info'),
			);
			if($Auth_group->data($data)->add())
			{
				$this->success('添加成功!',U('Auth/index'));
				die();
			}
			else
			{
				$this->error('添加失败!');
				die();
			}
		}
		
		$Auth_rule=M('Auth_rule');
		$list=$Auth_rule->select();
		$this->assign('rules',$list);
		$this->display();
	}
	
	/************************用户组权限管理开始************************/
	//查看用户组权限
	public function groupCk(){
		//获取权限列表
		$Auth_rule = M('Auth_rule');
		$list = $Auth_rule->field('id,condition,title,info')->select();
		$this->assign('list',$list);
		
		//获取当前用户组的信息
		$id = I('get.sq');
		$Auth_group = M('Auth_group');
		$tj['id'] = $id;
		$gxg = $Auth_group->where($tj)->find();
		$this->assign('group',$gxg);
		
		$this->display();
	}
	
	//修改用户组权限
	public function groupXg(){
		if(!IS_POST){
			$this->error('页面不存在！',U('Index/index'));
		}

		//$post = I('post.');
		$tj['id'] = I('post.id');
		$rules=I('post.rulesbox');
		$groupInfo=array(
			'title'=>I('post.yhzname'),
			'status'=>I('post.yhzstatus'),
			'rules'=>join(',',$rules),
			'info'=>I('post.info'),
		);
		$Auth_group = M('Auth_group');
		if($Auth_group->where($tj)->data($groupInfo)->save())
		{
			$this->success('修改成功',U('Auth/index'));
		}
				
		//$rules = array_slice($post, 1);
		
		//$str = implode(',', $rules);
//		dump($str);
//		var_dump($str);
//		die;
//		$Auth_group = M('Auth_group');
//		$Auth_group->rules = $str;
//		$issave = $Auth_group->where($tj)->save();
//		if($issave == 1){
//			$this->success('修改成功',U('Auth/index'));
//		}
	}
	/***********************用户组权限管理结束************************/
	
	/***********************用户组成员管理开始*************************/
	//成员列表
	public function accessList(){
		$groupid = I($get.sq);
		
		//查询用户组的名称
		$tj_group['id'] = $groupid;
		$Auth_group = M('Auth_group');
		$group = $Auth_group->where($tj_group)->field('id,title')->find();
		$this->assign('group',$group);
		
		//查询所属成员
		$tj_access['group_id'] = $groupid;
		$Cyinfo = D('CyinfoView');
		$count = $Cyinfo->where($tj_access)->count();// 查询满足要求的总记录数
		
		$Page = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$show = $Page->show();// 分页显示输出
		$list = $Cyinfo->where($tj_access)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		
		$this->display();
	}
	
	//添加成员
	public function AccessAdd(){
		
		
		//添加组成员
		if(IS_POST){
			$list=I('post.selects');
			$group_access=M('Auth_group_access');
			$flag=1;
			$array=array();
			foreach($list as $v){
				$data=array(
					'group_id'=>I('post.sq'),
					'uid'=>$v,
				);
				$array[]=$temp=$group_access->create($data);
				if(empty($temp))
					return $flag=0;
			}
			if($flag)
			{
				$group_access->addAll($array);
				$this->success('添加成功!',U('Auth/accessList','','').'/sq/'.I('post.sq'));
				die;
			}
			else
				$this->error('添加失败!');
			
		}
		
		
		
		if(isset($_GET['sq']))
		{
			/*注入当前组信息*/
			$tj['id']=I('get.sq');
			$group=M('Auth_group');
			$groupInfo=$group->where($tj)->find();
			$this->assign('groupInfo',$groupInfo);
			
			
			
			/*注入部门信息*/
			$bumen=M('User');
			$bumens=$bumen->distinct(true)->field('bumeng')->where("bumeng<>''")->order('bumeng')->select();
			$this->assign('bumens',$bumens);
			
			
			
			
			/*注入用户信息*/
			$Sql="SELECT
						 id,
						 bumeng 
					FROM
						 tp_user 
					WHERE id NOT IN(
									SELECT 
											uid 
										FROM 
											tp_auth_group_access 
										WHERE 
											group_id=".$tj['id'].") AND id != 1;
				";//查询数据，获取分页count值
			$m=M();
			$userlist=$m->query($Sql);
			$count=count($userlist);
			$Page=new \Think\Page($count,15);
			$Sql="SELECT
			 			username,
						xingming,
						id,
						bumeng
					FROM 
						tp_user 
					WHERE (
							id NOT IN(
										SELECT
											 	uid 
											FROM
												tp_auth_group_access 
											WHERE 
												group_id=".$tj['id']."
									 )
						  )AND id != 1
					LIMIT ".$Page->firstRow.",".$Page->listRows." ;
				 ";//分页查询sql
			$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
			$Page->setConfig('prev','上一页');
			$Page->setConfig('next','下一页');
			$show = $Page->show();// 分页显示输出
			
			
			$list=$m->query($Sql);
	
			$this->assign('list',$list);
			$this->assign('page',$show);
			
			
			/*按条件筛选用户*/
			if(isset($_GET['cx']))
			{
				$condition=I('get.cx');
				$Sql="SELECT
						 id,
						 bumeng 
					FROM
						 tp_user 
					WHERE 
						(
							id NOT IN(
									SELECT 
											uid 
										FROM 
											tp_auth_group_access 
										WHERE 
											group_id=".$tj['id']."
									 )
						)
					AND
						bumeng=".$condition.";
				";//查询数据，获取分页count值
				$userlist=$m->query($Sql);
				$count=count($userlist);
				$Page=new \Think\Page($count,15);
				$Sql="SELECT 
							username,
							xingming,
							id,
							bumeng
						FROM 
							tp_user 
						WHERE (
								id NOT IN(
											SELECT
												 	uid 
												FROM
													tp_auth_group_access 
												WHERE 
													group_id=".$tj['id']."
										 )
							  )
						AND
							bumeng=".$condition."
						LIMIT ".$Page->firstRow.",".$Page->listRows.";
					 ";//分页查询sql
				$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
				$Page->setConfig('prev','上一页');
				$Page->setConfig('next','下一页');
				$show = $Page->show();// 分页显示输出
				
				
				$list=$m->query($Sql);
				
				$this->assign('condition',$condition);
				$this->assign('list',$list);
				$this->assign('page',$show);	
			}
			
			
			$this->display();
			
			
		}else
		{
			$this->error('错误访问！');
		}
		
		
		
	}
	
	
	
	//删除成员
	public function accessSanchu(){
		$uid = I($get.u);
		$groupid = I($get.g);
		$tj_sc['uid'] = $uid;
		$tj_sc['group_id'] = $groupid;
//		dump($tj_sc);
		$Auth_group_access = M('Auth_group_access');
		$issc= $Auth_group_access->where($tj_sc)->delete();
		if($issc){
			$this->success('删除成功！',U('Auth/accessList','','').'?sq='.$groupid);
		}
		
	}
	/***********************用户组成员管理结束************************/
}
?>



















