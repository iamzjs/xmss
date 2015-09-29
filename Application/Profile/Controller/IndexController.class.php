<?php
namespace Profile\Controller;
class IndexController extends ProfileController {
    public function index(){
		$uid = session('user.userid');
		$where = array('userid'=>$uid);
	   $comment_list = $this->comment_model->where($where)->select();
	   $one = $this->user_model->find($uid);
       $this->display();
    }
	public function login(){
		//dump(I('post.'));
		$model = M('user');
		$user['username']=I('post.username');
		$user['password']=I('post.password');		
		$where = array('username'=>$user['username'],
					   'password'=>$user['password']
					   );
					   
		$result = $model->where($where)->find();
		if($result){//POST验证成功
			session('user',$result);
			//dump($result);
			$result['success']=1;
			$this->ajaxReturn($result,"json");
		}
		else{
			
		}
    }
	public function logout(){
		session('user',null);
		$this->redirect('/');
	}
	public function add(){
		$data = I('post.');
		$data['hobby']=implode(',',$data['hobby']);
		if(!$this->user_model->create($data)){
			$this->error($this->user_model->getError());
		}
		
		else{		
			$result = $this->user_model->add();
			if($result){
				$this->success('注册成功',U('profile/index/index'));
			}
			else{
				$this->error('注册失败');
			}
		}
	}
	/*
	public function login(){
		if(session('?admin')){
			$this->redirect('/admin/index/mod');
		}
		else{
			$modal = M('admin');
			$admin['username']=I('post.name');
			$admin['password']=I('post.password');		
			$where = array('username'=>$admin['username'],
						   'password'=>$admin['password']
						   );
						   
			$result = $modal->where($where)->find();
			if($result){//POST验证成功
				session_deal($admin['username']);
				//判断用户是否勾选自动登录
				if(!empty($_POST['remember'])){
					//如果用户勾选，则将值存到Cookie中
					cookie('username',$admin['username'],3600*12);
					cookie('password',$admin['password'],3600*12);
				}
				else{
					//如果用户未勾选，则清空Cookie
					cookie('username',null);
					cookie('password',null);
				}
				
				$this->success('登录成功',U('index/mod'));
			}	
			else{//POST验证失败
				$this->redirect('/admin/login/form');
			}
		}
		
    }*/
   
	
}