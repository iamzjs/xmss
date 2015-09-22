<?php
namespace Home\Controller;
use Home\Controller\HomeController;
class IndexController extends HomeController {
    public function index(){
		//公司产品		
		$cat_list = $this->cat_model->where('parentid=0')->select();
		$product_list=array();
		for($i=0;$i<count($cat_list);$i++){
			$cat = $cat_list[$i];
			//dump($cat);
			if($cat['childids']!=''){$where_p=array("categoryid in(".$cat['childids'].")","productthumb !=''");}
			else{$where_p=array("categoryid = ".$cat['id'],"productthumb !=''");}
			$pp = $this->product_model->where($where_p)->limit(6)->order('id desc')->select();
			$product['cat']= $cat;
			$product['products']= $pp;
			$product_list[]=$product;
		}
		//dump($product_list);		
		$this->assign('product_list',$product_list);
		
		//后台管理员登录失败
		$re = I('get.re');
		$re=empty($re)?0:1;
		/*if(!empty($re)){
			$re=1;
		}
		else{
			$re=0;
		}*/
		$this->assign('re',$re);
		$this->display();
    }
	
	public function add(){
		$user_model = D('Admin/user');	
		$data = I('post.');
		$data['hobby']=implode(',',$data['hobby']);
		if(!$user_model->create($data)){
			$this->error($user_model->getError());
		}
		
		else{		
			$result = $user_model->add();
			if($result){
				$this->success('添加成功',U('home/index/index'));
			}
			else{
				$this->error('添加失败');
			}
		}
	}
	
}