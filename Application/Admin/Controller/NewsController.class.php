<?php
namespace Admin\Controller;
use Think\Controller;
class NewsController extends BaseController {
	
	public function index(){
		$this->model=D('news');
		//$model = M('news');		
		//$list = $model->where('type='.$_GET['type'])->select();
		/*
		$count      = $model->where(array('type'=>I('get.type')))->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $model->where(array('type'=>I('get.type')))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();		
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('list',$list);*/
		$where = array('type'=>I('get.type'));
		$mypage = MyPage($this->model,$where,4);
		$this->assign('page',$mypage['show']);// 赋值分页输出
		$this->assign('list',$mypage['list']);
		$this->display();
	}
	public function form(){
		$this->display();
	}
	public function add(){
		$this->model=D('news');		
		if(!$this->model->create()){
			$this->error($this->model->getError());
		}
		else{		
			//$model->content = preg_replace("/<[^><]*script[^><]*>/i",'',$model->content);
			$result = $this->model->add();
			if($result){
				$this->success('添加成功',U('form'));
			}
			else{
				$this->error('添加失败');
			}
		}
	}
	public function mod(){
		$this->model=D('news');
		$id = $_GET['id'];
		//dump($id);
		//$model = M('news');
		$data = $this->model->where('id='.$id)->find();
		$data['content'] = htmlspecialchars_decode($data['content']);
		$this->assign('one',$data);
		$this->display();
		
	}
	public function update(){
		$this->model=D('news');
		
		if(!$this->model->create()){
			$this->error($this->model->getError());
		}
		else{
			//dump($_POST);
			//dump($model->data());
			$type = I('post.type');
			//过滤script
			//$preg = "/<script[\s\S]*?<\/script>/i";
			//$model->content= preg_replace($preg,"",$model->content,3);    //第四个参数中的3表示替换3次，默认是-1，替换全部
			$result = $this->model->save();
			if($result){
				$this->success('编辑成功！',U('index','type='.$type));
			}
			else{
				$this->error('编辑失败！');
			}
		}
	
		
	}
	
	public function del(){
		$this->model=D('news');
		$id = $_GET['id'];
		//$model->delete($id);
		$type = $this->model->where('id='.$id)->getField('type');
		//dump($type);
		$result = $this->model->where('id='.$id)->delete();
		if($result){
			$this->success('删除成功！',U('news/index','type='.$type));
		}
		else{
			$this->error('删除失败！');
		}
		
	}
	public function dels(){
		$this->model=D('news');
		$ids = $_POST['id'];
		//$model->delete($id);
		$type = $this->model->where('id='.$ids[0])->getField('type');
		//dump($type);
		for($i=0;$i<count($ids);$i++){
			$result = $this->model->where('id='.$ids[$i])->delete();
		}		
		$this->success('删除成功！',U('news/index','type='.$type));
		
		
	}
	public function search(){
			$this->model=D('news');
			$map['name'] = array('like','%'.I('post.search_key').'%');
			$list = $this->model->where($map)->select();
			$this->assign('list',$list);
			$this->display();
		
	}
	
}