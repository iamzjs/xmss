<?php
namespace Admin\Controller;
use Think\Controller;
class CommentController extends BaseController {
	public function _initialize(){
		$this->model=D('comment');
	}
	public function index(){
		$where = array('1'=>'1');
		$sql = "select c.*,u.name username,p.name productname from comment c left join user u on c.userid=u.id left join product p on c.resourseid=p.id";
		$mypage = MyPageSql($this->model,$where,$sql,6);
		$this->assign('page',$mypage['show']);// 赋值分页输出
		$this->assign('list',$mypage['list']);
		
		$this->display();
	}
	public function form(){
		$one = $this->model->find(I('get.id'));
		$this->assign('one',$one);
		$this->display();
	}
	public function add(){
		if(!$this->model->create()){
			$this->error($model->getError());
		}
		else{	
			$result = $this->model->field('reply')->save();
			if($result){
				$this->success('回复成功',U('index'));
			}
			else{
				$this->error('回复失败');
			}
		}
	}
	
	public function del(){
		$id = $_GET['id'];
		$result = $this->model->delete($id);
		if($result){
			$this->success('删除成功！',U('comment/index'));
		}
		else{
			$this->error('删除失败！');
		}
		
	}
	public function dels(){
		$ids = $_POST['id'];
		for($i=0;$i<count($ids);$i++){
			$result = $this->model->delete($ids[$i]);
		}		
		$this->success('删除成功！',U('comment/index'));
		
		
	}
	public function search(){
			$map['name'] = array('like','%'.I('post.search_key').'%');
			$list = $this->model->where($map)->select();
			$this->assign('list',$list);
			$this->display();
		
	}
	public function valid(){
		$id = $_GET['id'];
		$isvalid = $_GET['isvalid']==1?0:1;
		$result = $this->model->save(array('id'=>$id,'isvalid'=>$isvalid));
		$this->redirect('/admin/comment/index');
		
	}
	
}