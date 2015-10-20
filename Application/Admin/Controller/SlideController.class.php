<?php
namespace Admin\Controller;
use Think\Controller;
class SlideController extends BaseController {
    public function index(){
		$this->model=D('slide');		
		$list = $this->model->order('id desc')->select();
		$this->assign('list',$list);
		$this->display();
	}
	public function form(){
			$this->display();
	}
	public function add(){
		$this->model=D('slide');
		$corpinfo = $this->model->create();
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
		
			$result = $this->model->add($data);
			if($result){
			$this->success('添加成功!');
			}
			else{
				$this->error('添加失败！');
			}
		}
	}
	
	
	public function mod(){
		$id = $_GET['id'];
		$this->model=D('slide');
		$data = $this->model->where('id='.$id)->find();		
		$this->assign('one',$data);
		$this->display();
		
	}
	public function update(){
		$this->model=D('slide');
		$this->model->create();
		$data['id'] = $_POST['id'];
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
		
			
		}
		$result = $this->model->save($data);
			
			if($result){
			$this->success('编辑成功!',U('admin/slide/index'));
			}
			else{
				$this->error('编辑失败！');
			}
	}
	
	public function del(){
		$this->model=D('slide');
		$id = $_GET['id'];
		//$model->delete($id);
		
		$result = $this->model->where('id='.$id)->delete();
		if($result){
			$this->success('删除成功！',U('slide/index'));
		}
		else{
			$this->error('删除失败！');
		}
		
	}
	
	public function dels(){
		$this->model=D('slide');
		$ids = $_POST['id'];
		//$model->delete($id);
		
		for($i=0;$i<count($ids);$i++){
			$result = $this->model->where('id='.$ids[$i])->delete();
		}		
		$this->success('删除成功！',U('slide/index'));
		
		
	}
	
}