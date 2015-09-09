<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
	public function _initialize(){
		$this->checkAdmin();
	}
    private function checkAdmin(){
       //echo 'hello category';
	   if(!session('?admin')){
		   $this->error('无权限',U('home/index/index'));
	   }   
    }
}