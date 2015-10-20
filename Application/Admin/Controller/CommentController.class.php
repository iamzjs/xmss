<?php
namespace Admin\Controller;
use Think\Controller;
class CommentController extends BaseController {
	public function index(){
		$this->model=D('comment');
		$where = array('1'=>'1');
		$sql = "select c.*,u.name username,p.name productname from comment c left join user u on c.userid=u.id left join product p on c.resourseid=p.id";
		$mypage = MyPageSql($this->model,$where,$sql,6);
		$this->assign('page',$mypage['show']);// 赋值分页输出
		$this->assign('list',$mypage['list']);
		
		$this->display();
	}
	public function form(){
		$this->model=D('comment');
		$one = $this->model->find(I('get.id'));
		$this->assign('one',$one);
		$this->display();
	}
	public function add(){
		$this->model=D('comment');
		if(!$this->model->create()){
			$this->error($this->model->getError());
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
		$this->model=D('comment');
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
		$this->model=D('comment');
		$ids = $_POST['id'];
		for($i=0;$i<count($ids);$i++){
			$result = $this->model->delete($ids[$i]);
		}		
		$this->success('删除成功！',U('comment/index'));
		
		
	}
	public function search(){
		$this->model=D('comment');
			$map['name'] = array('like','%'.I('post.search_key').'%');
			$list = $this->model->where($map)->select();
			$this->assign('list',$list);
			$this->display();
		
	}
	public function valid(){
		$this->model=D('comment');
		$id = $_GET['id'];
		$isvalid = $_GET['isvalid']==1?0:1;
		$result = $this->model->save(array('id'=>$id,'isvalid'=>$isvalid));
		$this->redirect('/admin/comment/index');
		
	}
	
}