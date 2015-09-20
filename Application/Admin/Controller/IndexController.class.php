<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){
       $this->display();
    }
	
	public function mod(){
		$model = M('corpinfo');
		$corpinfo = $model->find();
		$this->assign('corpinfo',$corpinfo);
		$this->display();
	}
	public function update(){
		$model = D('corpinfo');
		$corpinfo = $model->create();
		$data['corpname'] = $_POST['corpname'];
		$data['contact'] = $_POST['contact'];
		//处理上传文件
		$config = array(
			'maxSize'    =>    3145728,
			'rootPath'   =>    './Uploads/',
			'savePath'   =>    '',
			'saveName'   =>    array('uniqid',''),
			//'saveName'   =>   date('Ymdhis').'_'.mt_rand(),
			//'saveName'   =>  'time',
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			'autoSub'    =>    true,
			'subName'    =>    array('date','Ymd'),
		);
		$upload = new \Think\Upload($config);// 实例化上传类
		if(!empty($_FILES['logo']['name'])){
			//$upload->saveName = date('Ymdhis').'_'.mt_rand();
			$info = $upload->uploadone($_FILES['logo']);
			if(!$info){
				$this->error($upload->getError());
			}
			else{
				$data['logo'] = $info['savepath'].$info['savename'];
			}
		}
		if(!empty($_FILES['banner']['name'])){
			//$upload->saveName = date('Ymdhis').'_'.mt_rand();
			$info2 = $upload->uploadone($_FILES['banner']);
			if(!$info2){
				$this->error($upload->getError());
			}
			else{
				$data['banner'] = $info2['savepath'].$info2['savename'];
			}
		}
		$result = $model->where('id=1')->save($data);
		if($result){
		$this->success('编辑成功!');
		}
		else{
			$this->error('编辑失败！');
		}
	}
	public function logout(){
		//session(null);
		unset($_SESSION['admin']);
		cookie('username',null);
		cookie('password',null);
		$this->success('注销成功，跳转到网站首页!',U('home/index/index'));
	}
	
	
	public function slides(){
			$this->display();
	}
	public function updateslides(){
		$model = D('slide');
		$corpinfo = $model->create();
		$data['name'] = $_POST['name'];
		//$data['contact'] = $_POST['contact'];
		//处理上传文件
		$config = array(
			'maxSize'    =>    3145728,
			'rootPath'   =>    './Uploads/',
			'savePath'   =>    '',
			'saveName'   =>    array('uniqid',''),
			//'saveName'   =>   date('Ymdhis').'_'.mt_rand(),
			//'saveName'   =>  'time',
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			'autoSub'    =>    true,
			'subName'    =>    array('date','Ymd'),
		);
		$upload = new \Think\Upload($config);// 实例化上传类
		
		if(!empty($_FILES['thumb']['name'])){
			$upload->saveName = date('Ymdhis').'_'.mt_rand();
			$info2 = $upload->uploadone($_FILES['thumb']);
			if(!$info2){
				$this->error($upload->getError());
			}
			else{
				$data['thumb'] = $info2['savepath'].$info2['savename'];
			}
		
		$result = $model->add($data);
		if($result){
		$this->success('上传成功!');
		}
		else{
			$this->error('上传失败！');
		}
	}
	}
	
}