<?php
/*
 * 员工信息控制器
 * */
namespace Home\Controller;
use Think\Controller;
class StaffController extends Controller {
	/*控制器初始化*/
	public function _initialize(){
		if(!session('?name')){
        	redirect(U('Login/index'));
        }else{
			$user['xingming'] = session('xingming');
			$user['bumeng'] = session('bumeng');
			$user['username'] = session('name');
			$this->assign('user',$user);
			
			//访问权限
			if(!auth_check('staff')){
				$this->error('无访问权限');
			}
			
			//内信
			$MessageTable=M('UserMessage');
			$MessageCount=$MessageTable->where('getid='.session('uid').' and status=0')->count();
			$this->assign('MessageCount',$MessageCount);

			$daohang = 'staff';
			$this->assign('daohang',$daohang);
			
        }
		
	}
	
	public function index(){
		$Staff = M('User');

		$count = $Staff->where('id!=1')->count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,13);// 实例化分页类 传入总记录数和每页显示的记录数
		$Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
		$Page->setConfig('prev','上一页');
		$Page->setConfig('next','下一页');
		$show = $Page->show();// 分页显示输出

		$list = $Staff->where('id!=1')->order('bumeng')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		
		$daohang2 = 'staff_index';
		$this->assign('daohang2',$daohang2);
		
		$this->display();
	}
	
	/***************添加/修改员工信息开始***************************/
	public function add(){
		$uid = I($get.sq);
		
		if($uid != null){//修改页
			$Staff = M('User');
			$tj_sq['id'] = $uid;
			$sq = $Staff->where($tj_sq)->find();
			$this->assign('list',$sq);
			
			$daohang2 = 'staff_index';
			$this->assign('daohang2',$daohang2);
			
			$this->display();
		}else{//添加页
		
			$daohang2 = 'staff_index';
			$this->assign('daohang2',$daohang2);
		
			$this->display();
		}
	}

	public function info_add(){
		//获取员工详细信息
		$uid = I('get.sq');
		$UserInfoTable=M('user_info');
		$is_exits=$UserInfoTable->where('user_id='.$uid)->select();
		$this->assign('is_exits',$is_exits);
		// var_dump($is_exits);

		$UserTable=M('User');
		$UserInfo=$UserTable->where('id='.$uid)->select();
		$this->assign('UserInfo',$UserInfo);
		// var_dump($UserInfo);
		$this->display();
	}

	public function info_addAction(){
		if(IS_POST)
		{
			$type=I('get.type');
			$UserInfoTable=M('User_info');
			$id=I('post.id');
			$data['user_id']=$id;
			$data['sex']=I('post.sex');
			$data['nation']=I('post.nation');
			$data['birth_place']=I('post.birth_place');
			$data['birth']=strtotime(I('post.birth'));
			$data['edu_level']=I('post.edu_level');
			$data['is_marriage']=I('post.is_marriage');
			$data['health_status']=I('post.health_status');
			$data['political_status']=I('post.political_status');
			$data['addr']=I('post.addr');
			$data['h_tel']=I('post.h_tel');
			$data['phone']=I('post.phone');
			$data['emer_contact_pers']=I('post.emer_contact_pers');
			$data['relationship']=I('post.relationship');
			$data['emer_contact_phone']=I('post.emer_contact_phone');
			$data['position']=I('post.position');
			$data['salery']=I('post.salery');
			$data['hobby']=I('post.hobby');
			$data['speciality']=I('post.speciality');
			$data['wish']=I('post.wish');
			$data['career_wish']=I('post.career_wish');
			$data['birth_place_addr']=I('post.birth_place_addr');
			$data['self_assi']=I('post.self_assi');
			$data['remark']=I('post.remark');
			$data['grxx']=I('post.grxx');
			$data['his_work']=I('post.his_work');

			if($type=='modify')
				if($UserInfoTable->where('user_id='.$id)->save($data))
					$this->success('修改成功!',U('Staff/ViewInfo','','').'/sq/'.$id);
				else
					$this->error('数据无修改!',U('Staff/ViewInfo','','').'/sq/'.$id);
			elseif($type=='add')
				if($UserInfoTable->data($data)->add())
					$this->success('添加成功!',U('Staff/ViewInfo','','').'/sq/'.$id);
				else
					$this->error('添加失败!',U('Staff/index'));
		}
	}

	public function ViewInfo(){
		$uid=I('get.sq');
		$UserInfoTable=M('user_info');
		$is_exits=$UserInfoTable->where('user_id='.$uid)->select();
		
		if($is_exits)
		{
			$this->assign('is_exits',$is_exits);
			$UserTable=M('User');
			$UserInfo=$UserTable->where('id='.$uid)->select();
			$this->assign('UserInfo',$UserInfo);
			$this->display();
		}
		else
			$this->success('您还没有添加任何信息，请添加..',U('Staff/info_add','','').'/sq/'.$uid);
	}
	
	public function addAction(){
		if(!IS_POST){
			$this->error('页面不存在！',U('Index/index'));
		}
		
		$post = I('post.');
		if($post['sfid'] == null){
			$this->error('证件号码不能为空！');
		}
		
		$Staff = M('User');
		
		$userid = "xbd".$post['bumeng'].substr($post['sfid'], -4);
		$sq['username'] = $userid;
		$sq['xingming'] = $post['xingming'];
		$sq['bumeng'] = $post['bumeng'];
		$sq['sfid'] = $post['sfid'];
		$sq['status'] = $post['status'];
		$sq['rzdate'] = mk_time($post['rzdate']);
		$sq['lzdate'] = mk_time($post['lzdate']);
		
		$gxtj[id] = $post['id'];
		if(!empty($gxtj[id])){//修改
			$Staff->where($gxtj)->setField($sq);
		
			/*写入用户操作日志begin*/
			$log['chaozuo'] = '修改id为['.$post['id'].']的员工信息';
			$Userlog = new \Home\Common\Userlog();
			$Userlog->save($log);
			/*写入用户操作日志end*/
		
			$this->success('修改成功',U('Staff/index'));
		}else{//添加
			$only_tj['sfid'] = $post['sfid'];
			if($Staff->where($only_tj)->find() != null){
				$this->error('证件号码已存在！');
			}
			
			$user_tj['username'] = $userid;
			if($Staff->where($user_tj)->find() != null){
				$this->error('员工编号已存在！');
			}
			
			$sq['password'] = md5('123456');
			$Staff->add($sq);
			/*写入用户操作日志begin*/
			$log['chaozuo'] = '新增员工';
			$Userlog = new \Home\Common\Userlog();
			$Userlog->save($log);
			/*写入用户操作日志end*/		
			$this->success('添加成功',U('Staff/index'));
		}
		
	}
	/***************添加/修改员工信息结束***************************/

	
//	重置登录密码
	public function czmm(){
		$uid = I($get.sq);

		if(empty($uid)){
			$this->error('页面不存在！',U('Index/index'));
		}
		
		$gxtj[id] = $uid;
		$Staff = M('User');
		$sq['password'] = md5('123456');
		$asdf = $Staff->where($gxtj)->setField($sq);
		if($asdf){
			/*写入用户操作日志begin*/
			$log['chaozuo'] = '重置id为['.$uid.']的登录密码';
			$Userlog = new \Home\Common\Userlog();
			$Userlog->save($log);
			/*写入用户操作日志end*/
			$this->success('密码重置成功',U('Staff/index'));
		}elseif($asdf == 0){
			$this->success('密码为默认密码，无需重置',U('Staff/index'));
		}else{
			$this->error('密码重置失败',U('Staff/index'));
		}
	}
	
	
	//用户操作记录
	public function ulog(){
		$Userlog = new \Home\Common\Userlog();
		$data =  $Userlog->chakan();
		$list = $data['list'];
		$show = $data['show'];
		
		$this->assign('list',$list);
		$this->assign('page',$show);// 赋值分页输出
		
		$daohang2 = 'staff_ulog';
		$this->assign('daohang2',$daohang2);
		
		$this->display();
	}
	
}
?>













