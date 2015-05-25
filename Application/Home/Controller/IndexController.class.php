<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function _before_index(){
        if(!session('?name')){
        	redirect(U('Login/index'));
        }else{
            
        }
    }
	
	public function index() {
		
		$this -> display();
	}
}
?>
