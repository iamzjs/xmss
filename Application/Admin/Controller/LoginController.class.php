<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function login(){
		$this->display();
	}
    public function index(){
		$modal = M('admin');
		$admin['username']=I('post.name');
		$admin['password']=I('post.password');
		if(empty($admin['username'])&&empty($admin['password'])){
			//判断Session是否为空
			if(!session('?admin')){
				//判断Cookie是否存在
				if((!cookie('username'))||(!cookie('password'))){				
					$this->redirect('/home/index/index/re/1');
				}
				else{//cookie非空
					$where = array('username'=>cookie('username'),
						   'password'=>cookie('password')
						   );
						   
					$result = $modal->where($where)->find();
					
					//Cookie验证是否成功
					if($result){
						$this->session_deal(cookie('username'));
						$this->redirect('/admin/index/mod');
					}
					else{
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
		else{
			
			$where = array('username'=>$admin['username'],
						   'password'=>$admin['password']
						   );
						   
			$result = $modal->where($where)->find();
			if($result){
				$this->session_deal($admin['username']);
				//判断用户是否勾选自动登录
				if(!empty($_POST['remember'])){
					cookie('username',$admin['username'],3600*12);
					cookie('password',$admin['password'],3600*12);
				}
				else{
					cookie('username',null);
					cookie('password',null);
				}
				
				$this->success('登录成功',U('index/mod'));
			}	
			else{
				$this->redirect('/home/index/index/re/1');
			}
		}
		
     
    }
	
	private function session_deal($name){
				session('admin',$name);
				$modal2 = M('category');
				$parentlist = $modal2->where('parentid=0')->select();
				$catlist=array();
				for($i=0;$i<count($parentlist);$i++){
					$cat = array();
					$cat['catid'] = $parentlist[$i]['id'];
					$cat['name'] = $parentlist[$i]['name'];
					$cat['subcat'] = $modal2->where('parentid='.$parentlist[$i]['id'])->select();
					$catlist[]=$cat;
					
				}
				session('catlist',$catlist);
	}
}