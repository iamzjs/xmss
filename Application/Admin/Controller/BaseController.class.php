<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
	private $model;
	public function _initialize(){
		$this->checkAdmin();
	}
    private function checkAdmin(){
	   if(!session('?admin')){
		   //$this->error('无权限',U('home/index/index'));
		   $this->redirect('admin/login/form');
	   }
    }
}