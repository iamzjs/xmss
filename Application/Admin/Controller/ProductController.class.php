<?php
namespace Admin\Controller;
use Think\Controller;
class ProductController extends BaseController {
    
	public function index(){
		$model = M('product');		
		/*
		$catid = I('get.catid');
		$count      = $model->where(array('categoryid'=>I('get.catid')))->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $model->where(array('categoryid'=>I('get.catid')))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('list',$list);*/
		$where = array('categoryid'=>I('get.catid'));
		$mypage = MyPage($model,$where,3);
		$this->assign('page',$mypage['show']);// 赋值分页输出
		$this->assign('list',$mypage['list']);
		$this->assign('catid',$catid);
		$this->display();
	}
	public function form(){
		$model = M('category');
		$one = $model->where(array('id'=>I('get.catid')))->find();
		$this->assign('one',$one);
		$this->display();
	}
	public function add(){
		$model = D('product');	
		$data = I('post.');
		//处理上传文件
		$config = array(
			'maxSize'    =>    3145728,
			'rootPath'   =>    './Uploads/',
			'savePath'   =>    '',
			//'saveName'   =>    array('uniqid',''),
			//'saveName'   =>   date('Ymdhis').'_'.mt_rand(),
			//'saveName'   =>  'time',
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			'autoSub'    =>    true,
			'subName'    =>    array('date','Ymd'),
		);
		$upload = new \Think\Upload($config);// 实例化上传类
		if(!empty($_FILES['productthumb']['name'])){
			$upload->saveName = date('Ymdhis').'_'.mt_rand();
			$info = $upload->uploadone($_FILES['productthumb']);
			if(!$info){
				$this->error($upload->getError());
			}
			else{
				$data['productthumb'] = $info['savepath'].$info['savename'];
				//dump($data);
			}
		}
		if(!$model->create($data)){
			$this->error($model->getError());
		}
		else{		
			//$model->content = preg_replace("/<[^><]*script[^><]*>/i",'',$model->content);
			$result = $model->add();
			if($result){
				$this->success('添加成功',U('form',array('catid'=>I('post.categoryid'))));
			}
			else{
				$this->error('添加失败');
			}
		}
	}
	public function mod(){
		$id = $_GET['id'];
		//dump($id);
		$model = M('product');
		$data = $model->where('id='.$id)->find();
		//$data['content'] = htmlspecialchars_decode($data['content']);
		
		$model = M('category');
		$cat = $model->where(array('id'=>$data['categoryid']))->find();
		$this->assign('cat',$cat);
		
		$this->assign('one',$data);
		$this->display();
		
	}
	public function update(){
		$model = D('product');
		$data = I('post.');
		
		//处理上传文件
		$config = array(
			'maxSize'    =>    3145728,
			'rootPath'   =>    './Uploads/',
			'savePath'   =>    '',
			//'saveName'   =>    array('uniqid',''),
			//'saveName'   =>   date('Ymdhis').'_'.mt_rand(),
			//'saveName'   =>  'time',
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			'autoSub'    =>    true,
			'subName'    =>    array('date','Ymd'),
		);
		$upload = new \Think\Upload($config);// 实例化上传类
		if(!empty($_FILES['productthumb']['name'])){
			$upload->saveName = date('Ymdhis').'_'.mt_rand();
			$info = $upload->uploadone($_FILES['productthumb']);
			if(!$info){
				$this->error($upload->getError());
			}
			else{
				$data['productthumb'] = $info['savepath'].$info['savename'];
				//dump($data);
			}
		}
		
		
		if(!$model->create($data)){
			$this->error($model->getError());
		}
		else{
			//dump($_POST);
			//dump($model->data());
			$catid = I('post.categoryid');
			
			$result = $model->save();
			if($result){
				$this->success('编辑成功！',U('index','catid='.$catid));
			}
			else{
				$this->error('编辑失败！');
			}
		}
	
		
	}
	
	public function del(){
		$model = M('product');
		$id = $_GET['id'];
		//$model->delete($id);
		$type = $model->where('id='.$id)->getField('type');
		//dump($type);
		$result = $model->where('id='.$id)->delete();
		if($result){
			$this->success('删除成功！',U('product/index','type='.$type));
		}
		else{
			$this->error('删除失败！');
			$this->error('删除失败！');
		}
		
	}
	
	public function search(){
			$model = M('product');
			$map['name'] = array('like','%'.I('post.search_key').'%');
			$list = $model->where($map)->select();
			$this->assign('list',$list);
			$this->display();
		
	}
	
}