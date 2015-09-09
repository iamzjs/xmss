<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		//公司基本信息
		$corp_model = M('corpinfo');
		$corp = $corp_model->find();
		$this->assign('corp',$corp);
		//banner
		//公司新闻
		$news_model = M('news');
		$news_list = $news_model->limit(6)->select();
		$this->assign('news_list',$news_list);
		//公司产品
		$cat_model=M('category');
		$product_model = M('product');
		$cat_list = $cat_model->where('parentid=0')->select();
		$product_list=array();
		for($i=0;$i<count($cat_list);$i++){
			$cat = $cat_list[$i];
			//dump($cat);
			if($cat['childids']!=''){$where_p=array("categoryid in(".$cat['childids'].")","productthumb !=''");}
			else{$where_p=array("categoryid = ".$cat['id'],"productthumb !=''");}
			$pp = $product_model->where($where_p)->limit(6)->order('id desc')->select();
			$product['cat']= $cat;
			$product['products']= $pp;
			$product_list[]=$product;
		}
		//dump($product_list);		
		$this->assign('product_list',$product_list);
		//公司最新产品
		$where_pl = array('productthumb !=""');
		$prod_latest = $product_model->where($where_pl)->limit(6)->order('id desc')->select();
		//dump($prod_latest);
		$this->assign('prod_latest',$prod_latest);
		$this->display();
    }
	
	
}