<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function login(){
		$this->display();
	}
    public function index(){
		$admin['username']='admin';
		$admin['password']='123456';
		$modal = M('admin');
		$result = $modal->where("username='".$admin['username']."' and password='".$admin['password']."'")->find();
		if($result){
			session('admin',$admin['username']);
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
			$this->success('登录成功',U('index/mod'));
		}
		else{
			$this->error('信息不对',U('home/index/index'));
		}
		
     
    }
}