<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{
    public function _initialize(){
        if(!session('?name')){
            redirect(U('Login/index'));
        }else{
            $user['xingming'] = session('xingming');
            $user['bumeng'] = session('bumeng');
            $user['username'] = session('name');
            $this->assign('user',$user);
            
            $MessageTable=M('UserMessage');
            $MessageCount=$MessageTable->where('getid='.session('uid').' and status=0')->count();
            $this->assign('MessageCount',$MessageCount);
            
            $daohang = 'Message';
            $this->assign('daohang',$daohang);  
        }
    }

    public function Manage(){

        $MessageItems='Manage';
        $this->assign('MessageItems',$MessageItems);
        $UserTable=M('User');
        $UserInfo=$UserTable->where('id='.session('uid'))->find();
        $this->assign('UserInfo',$UserInfo);
        $status=array();
        if(IS_AJAX)
        {
            $oldpsw = I('post.oldpsw')!=''?md5(I('post.oldpsw')):'';
            $newpsw1 = I('post.newpsw1')!=''?md5(I('post.newpsw1')):'';
            $newpsw2 = I('post.newpsw2')!=''?md5(I('post.newpsw2')):'';
            $data['msgSwitch']=I('post.msgSwitchResult');
            $data['msgSave']=I('post.msgSaveResult');
            if($newpsw1 != $newpsw2){
                $status['alert']='两次的密码不一致!';
                $this->ajaxReturn($status);
            }
            if(($oldpsw!=''&&$newpsw1!=''&&$newpsw2!=''))
            {
                if($oldpsw==$UserInfo['password'])
                    $data['password']=$newpsw1;
                else
                {
                    $status['alert']='旧密码不正确!';
                    $this->ajaxReturn($status);
                }
            }
            if($UserTable->where('id='.session('uid'))->data($data)->save())
            {
                $status['alert']='保存成功!';
                /*写入用户操作日志begin*/
                $log['chaozuo'] = '修改登录密码';
                $Userlog = new \Home\Common\Userlog();
                $Userlog->save($log);
                /*写入用户操作日志end*/
                if(isset($data['password']))
                {
                    $log['chaozuo'] = '修改成功!';
                    $Userlog = new \Home\Common\Userlog();
                    $Userlog->save($log);
                    /*写入用户操作日志end*/
                    session(null);
                    $status['url']='Login/index';
                }
            }
            else
                $status['alert']='保存失败!';
            $this->ajaxReturn($status);
        }
        $this->display();    
            
    }


    public function Message(){
        $MessageTable=M('UserMessage');
        $MessageCount=$MessageTable->where('(getid='.session('uid').' and status is not null) or (postid='.session('uid').' and status is null)')->select();
        $count = count($MessageCount);
        $Page = new \Think\Page($count,5);
        $Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show = $Page->show();// 分页显示输出
        $MessageInfo=$MessageTable->where('(getid='.session('uid').' and status is not null) or (postid='.session('uid').' and status is null)')->order('status asc,posttime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('message',$MessageInfo);
        $this->assign('page',$show);


        $UserTable=M('User');
        $UserInfo=$UserTable->select();
        $this->assign('UserInfo',$UserInfo);
        $MessageItems='Message';
        $this->assign('MessageItems',$MessageItems);

        $this->display();
    }

    public function scanMessage(){
        if(IS_GET)
        {
            $id=I('get.id');
            $MessageTable=M('UserMessage');
            $MessageInfo=$MessageTable->where('id='.$id.' and (postid='.session('uid').' or getid='.session('uid').')')->select();
            $this->assign('MessageInfo',$MessageInfo);

            if($MessageInfo[0]['getid']==session('uid'))//设置自己读取才可更新数据
            {
                if($MessageInfo[0]['status']!=1)
                {
                    $flag['status']=1;//标记已读
                    $flag['gettime']=time();
                    $MessageInfo=$MessageTable->where('id='.$id)->data($flag)->save();
                }
            }
            

            $UserTable=M('User');
            $UserInfo=$UserTable->select();
            $this->assign('UserInfo',$UserInfo);
            $MessageItems='Message';
            $this->assign('MessageItems',$MessageItems);

            $this->display();
        }
        else
        {
            $this->error('非法访问!');
        }
    }




    public function MessageSend(){
        $UserTable=M('User');
        $UserInfo=$UserTable->field('xingming,id,bumeng,msgSave')->where('id<>'.session('uid').' and msgSwitch=1')->select();
        $this->assign('UserInfo',$UserInfo);
        $MessageTable=M('UserMessage');

        if(IS_AJAX)
        {

            $data['postid']=session('uid');
            $data['getid']=I('post.getid');
            $arr=split('@', $data['getid']);
            $data['content']=I('post.content');
            $data['status']=0;
            $data['title']=I('post.title');
            $data['posttime']=time();
            if(strpos($data['getid'], '@'))
            {
                foreach($arr as $k=>$v)
                {
                    $data['getid']=$v;
                    if($MessageTable->create($data))
                    {
                        $MessageTable->add();
                        $data['status']=1;
                        //创建发件保存
                    
                        if($UserInfo[0]['msgSave']==1)
                        {
                            $data2['postid']=$data['postid'];
                            $data2['content']=$data['content'];
                            $data2['getid']=$data['getid'];
                            $data2['title']=$data['title'];
                            $data2['posttime']=$data['posttime'];
                            $MessageTable->add($data2);
                            $MessageTable->add($data2);
                        }
                    }
                }
            }
            else//单发
            {
                if($MessageTable->create($data))
                {
                    $MessageTable->add();
                    $data['status']=1;
                    //创建发件保存
                    
                    if($UserInfo[0]['msgSave']==1)
                    {
                        $data2['postid']=$data['postid'];
                        $data2['content']=$data['content'];
                        $data2['getid']=$data['getid'];
                        $data2['title']=$data['title'];
                        $data2['posttime']=$data['posttime'];
                        $MessageTable->add($data2);
                    }
                }
                else
                    $data['status']=0;
            }
            
            $this->ajaxReturn($data);
        }



        $MessageItems='MessageSend';
        $this->assign('MessageItems',$MessageItems);
        $this->display();
    }


    public function getMail(){
        $MessageItems='getMail';
        $this->assign('MessageItems',$MessageItems);

        $MessageTable=M('UserMessage');
        $MessageCount=$MessageTable->where('getid='.session('uid').' and status is not null')->select();
        $count = count($MessageCount);
        $Page = new \Think\Page($count,5);
        $Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show = $Page->show();// 分页显示输出
        $MessageInfo=$MessageTable->where('getid='.session('uid').' and status is not null')->order('status asc,posttime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('message',$MessageInfo);
        $this->assign('page',$show);


        $UserTable=M('User');
        $UserInfo=$UserTable->select();
        $this->assign('UserInfo',$UserInfo);




        $this->display();
    }

    public function postMail(){
        $MessageItems='postMail';
        $this->assign('MessageItems',$MessageItems);


        $MessageTable=M('UserMessage');
        $MessageCount=$MessageTable->where('postid='.session('uid').' and status is null')->select();
        $count = count($MessageCount);
        $Page = new \Think\Page($count,5);
        $Page->setConfig('theme',"共 %TOTAL_ROW% 条记录%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%");
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show = $Page->show();// 分页显示输出
        $MessageInfo=$MessageTable->where('postid='.session('uid').' and status is null')->order('status asc,posttime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('message',$MessageInfo);
        $this->assign('page',$show);


        $UserTable=M('User');
        $UserInfo=$UserTable->select();
        $this->assign('UserInfo',$UserInfo);


        $this->display();
    }


    public function MessageDelAction(){
        $delList=I('post.ids');
        // var_dump($delList);
        $MessageTable=M('UserMessage');
        if(!empty($delList))
        {
            foreach($delList as $v)
            {
                if($MessageTable->where('id='.$v)->delete())
                    $flag=1;
                else
                {
                    $flag=0;
                    break;
                }
            }
            if($flag)
                $this->success('删除成功!', U('User/Message'));
            else
                $this -> error('删除失败',U('User/Message'));   
        }
        
        if(isset($_GET['id']))
        {
            $info=$MessageTable->field('id')->where('((getid='.session('uid').' and status is not null) or postid='.session('uid').' and status is null) and id='.I('get.id'))->find();
            if($info['id']==I('get.id'))
            {
                if($MessageTable->where('id='.I('get.id'))->delete())
                    $this->success('删除成功!', U('User/Message'));
                else
                    $this -> error('删除失败',U('User/Message'));
            }
            else
                $this -> error('删除失败',U('User/Message'));
        }
    }
}
?>