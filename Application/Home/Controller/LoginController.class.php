<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function index() {
		if(session('?name')){
			redirect(U('Index/index'));
		}else{
			$this -> display();
		}	
	}

	public function login() {
		$user = I('post.username');
		$psw = md5(I('post.password'));
		$verify = I('post.verify');
		
		if ($this -> check_verify($verify, $id = '')) {
  			$User = M('User');
  			$con['username'] = $user;
  			$con['password'] = $psw;
  			$UStatus=$User->where($con)->field('status')->select();
  			// var_dump($UStatus);
  			if($UStatus[0]['status']==100||$UStatus[0]['status']==1)
  			{
  				$this->error('您没有登陆权限!');
  				exit;
  			}
			$data = $User->where($con)->find();
			if($data != null){
				session('name',$user);
				session('xingming',$data['xingming']);
				session('bumeng',$data['bumeng']);
				session('uid',$data['id']);
				
				/*写入用户操作日志begin*/
				$log['chaozuo'] = '登录系统';
				$Userlog = new \Home\Common\Userlog();
				$Userlog->save($log);
				/*写入用户操作日志end*/
				
				$this->success('登录成功', U('Index/index'));
			}else{
				$this -> error('用户名或密码错误！',U('Login/index'));
			}
		}else{
			$this -> error('验证码不正确！');
		}
		
	}
	
	//退出登录
	public function tuichu() {
		/*写入用户操作日志begin*/
		$log['chaozuo'] = '退出登录';
		$Userlog = new \Home\Common\Userlog();
		$Userlog->save($log);
		/*写入用户操作日志end*/
		session(null);
		$this->success('退出成功', U('Login/index'));
	}

	//生成验证码
	public function verify() {
		$config = array(
		'length' => 4, // 验证码位数
		'useNoise' => false, // 关闭验证码杂点
		);
		$Verify = new \Think\Verify($config);
		$Verify->codeSet = '0123456789';//设置验证码为纯数字
		$Verify -> entry();
	}

	// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
	function check_verify($code, $id = '') {
		$verify = new \Think\Verify();
		return $verify -> check($code, $id);
	}
}
?>
