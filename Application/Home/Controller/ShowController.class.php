<?php
namespace Home\Controller;
use Home\Controller\HomeController;
class ShowController extends HomeController {
    public function index(){
		$product_id = I('get.id');
		$one = $this->product_model->find($product_id );
		$this->assign('one',$one);
		$this->display();
    }
	
	public function news(){
		$news_id = I('get.id');
		$one = $this->news_model->find($news_id );
		$this->assign('one',$one);
		$this->display();
	}
	
	public function contact(){
		$this->display();
	}
	
}