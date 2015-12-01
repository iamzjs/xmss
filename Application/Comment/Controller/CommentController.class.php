<?php
namespace Comment\Controller;
use Think\Controller;
class CommentController extends Controller {
    public function index(){
        $this->display();
    }
	public function dels(){
		$model = M('comment');
		$data = I('post.');
		for($i=0;$i<count($data['ids']);$i++){
			$model->delete($data['ids'][$i]);
		}
		$this->success('删除成功',U('index'));
	}
}