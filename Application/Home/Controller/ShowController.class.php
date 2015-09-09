<?php
namespace Home\Controller;
use Think\Controller;
class ShowController extends Controller {
    public function index(){
		$cat_model = M('category');
	   $product_model = M('product');
	   
		//公司基本信息
		$corp_model = M('corpinfo');
		$corp = $corp_model->find();
		$this->assign('corp',$corp);
		//banner
		//公司新闻
		$news_model = M('news');
		$news_list = $news_model->limit(6)->select();
		$this->assign('news_list',$news_list);
		//公司最新产品
		$where_pl = array('productthumb !=""');
		$prod_latest = $product_model->where($where_pl)->limit(6)->order('id desc')->select();
		//dump($prod_latest);
		$this->assign('prod_latest',$prod_latest);
		
		

		$product_id = I('get.id');
		$one = $product_model->find($product_id );
		$this->assign('one',$one);
		$this->display();
    }
	
	public function news(){
		$cat_model = M('category');
	   $product_model = M('product');
	   
		//公司基本信息
		$corp_model = M('corpinfo');
		$corp = $corp_model->find();
		$this->assign('corp',$corp);
		//banner
		//公司新闻
		$news_model = M('news');
		$news_list = $news_model->limit(6)->select();
		$this->assign('news_list',$news_list);
		//公司最新产品
		$where_pl = array('productthumb !=""');
		$prod_latest = $product_model->where($where_pl)->limit(6)->order('id desc')->select();
		//dump($prod_latest);
		$this->assign('prod_latest',$prod_latest);
		
		
		$news_id = I('get.id');
		$one = $news_model->find($news_id );
		$this->assign('one',$one);
		$this->display();
	}
	
	public function contact(){
		$cat_model = M('category');
	   $product_model = M('product');
	   
		//公司基本信息
		$corp_model = M('corpinfo');
		$corp = $corp_model->find();
		$this->assign('corp',$corp);
		//banner
		//公司新闻
		$news_model = M('news');
		$news_list = $news_model->limit(6)->select();
		$this->assign('news_list',$news_list);
		//公司最新产品
		$where_pl = array('productthumb !=""');
		$prod_latest = $product_model->where($where_pl)->limit(6)->order('id desc')->select();
		//dump($prod_latest);
		$this->assign('prod_latest',$prod_latest);
		
		
		$this->display();
	}
	
}