<?php
namespace Home\Controller;
use Think\Controller;
class HomeController extends Controller {
	public $corp_model;
	public $slide_model;
	public $news_model;
	public $product_model;
	public $category_model;
	public $cat_model;
	public function _initialize(){
		$this->corp_model=M('corpinfo');
		$this->cat_model=M('category');
		$this->slide_model = M('slide');
		$this->news_model = M('news');
		$this->product_model = M('product');
		//公司基本信息
		$corp = $this->corp_model->find();
		$this->assign('corp',$corp);	
		//banner        
		$slides =  $this->slide_model->select();
		$this->assign('slides',$slides);
		//公司新闻		
		$news_list = $this->news_model->limit(6)->select();
		$this->assign('news_list',$news_list);
		
		//公司最新产品		
		$where_pl = array('productthumb !=""');
		$prod_latest = $this->product_model->where($where_pl)->limit(6)->order('id desc')->select();
		$this->assign('prod_latest',$prod_latest);
	}	
}