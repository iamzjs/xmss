<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function form(){
		$this->display();
	}
	
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
		
    }
    public function index(){
		$modal = M('admin');
		$admin['username']=I('post.name');
		$admin['password']=I('post.password');
		//判断用户是否提交了表单，如果提交了，则POST不为空
		if(empty($admin['username'])&&empty($admin['password'])){
			//如果用户没有提交表单，用户直接打开当前的文件admin/login/index
			
			if(!session('?admin')){//Session为空
				//判断Cookie是否存在
				if((!cookie('username'))||(!cookie('password'))){	
					//如果Cookie不存在，直接跳转到网站首页，并打开登录框
					$this->redirect('/home/index/index/re/1');
				}
				else{//cookie非空
					$where = array('username'=>cookie('username'),
						   'password'=>cookie('password')
						   );
						   
					$result = $modal->where($where)->find();
					
					//Cookie验证是否成功
					if($result){
						//验证成功，进行Session赋值，然后跳转其他管理页面
						session_deal(cookie('username'));
						$this->redirect('/admin/index/mod');
					}
					else{
						//Cookie验证失败，清空Cookie，跳转到网站首页并弹出登录框
						cookie('username',null);
						cookie('password',null);
						$this->redirect('/home/index/index/re/1');
					}
					
				}
			}
			else{//Session非空
				$this->redirect('/admin/index/mod');
			}
		}
		else{//POST表单非空
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
				$this->redirect('/home/index/index/re/1');
			}
		}
		
     
    }
	
	
}