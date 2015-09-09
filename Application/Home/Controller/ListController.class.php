<?php
namespace Home\Controller;
use Think\Controller;
class ListController extends Controller {
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
		
       //echo 'hello category';
	   $catid = I('get.catid');
	   $cat = $cat_model->find($catid);
	   $this->assign('cat',$cat);
	   $count      = $product_model->where(array('categoryid'=>$catid,"productthumb !=''"))->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $product_model->where(array('categoryid'=>$catid,"productthumb !=''"))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('list',$list);
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
		
		$model = M('news');		
		//$list = $model->where('type='.$_GET['type'])->select();
		$type = I('get.type');
		$count      = $model->where(array('type'=>$type))->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $model->where(array('type'=>$type))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('list',$list);
		$this->assign('type',$type);
		$this->display();
	}
	
}