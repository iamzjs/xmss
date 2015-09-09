<?php
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends BaseController {
    
	public function index(){
		//$model = M('category');		
		//$list = $model->where('type='.$_GET['type'])->select();
		$model = M();
		$sql="select count(*) num from category c1 
		      left join category c2 on c1.parentid = c2.id
			  where c1.parentid=".I('get.parentid');
		//dump($sql);	  
	  	$num      = $model->query($sql);// 查询满足要求的总记录数
		$count = $num[0]['num'];
		//dump($count);
		$Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$sql2="select c1.*,c2.name parentname from category c1 
	  left join category c2 on c1.parentid = c2.id
	  where c1.parentid=".I('get.parentid')
	  ." order by id desc limit ".$Page->firstRow.",".$Page->listRows;
		//dump($sql2);
		$list = $model->query($sql2);
		//dump($list);
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('list',$list);
		$this->display();
	}
	public function form(){
		$model = M('category');
		$data = $model->where('parentid=0')->select();
		$this->assign('list',$data);
		$this->display();
	}
	public function add(){
		$model = D('category');		
		if(!$model->create()){
			$this->error($model->getError());
		}
		else{		
			//$model->content = preg_replace("/<[^><]*script[^><]*>/i",'',$model->content);
			
			$result = $model->add();
			if($result){
				//获取parentid
				$parentid = I('post.parentid');
				//获取parentid类型的所有子类型
				$data = $model->where('parentid='.$parentid)->select();
				foreach($data as $key=>$value){
					$data0[] = $value['id'];					
				}
				//转换成 5,6字符串
				$str = implode(',',$data0);
				//更新parentid类型的childids字段
				$list['childids'] = $str;
				$model->where('id='.$parentid)->save($list);
				$this->catlist();
				$this->success('添加成功',U('form'));
			}
			else{
				$this->error('添加失败');
			}
		}
	}
	public function mod(){
		$id = $_GET['id'];
		//dump($id);
		$model = M('category');
		$data = $model->where('id='.$id)->find();
		//$data['content'] = htmlspecialchars_decode($data['content']);
		$data2 = $model->where('parentid=0')->select();
		$this->assign('list',$data2);
		$this->assign('one',$data);
		//dump($data2);
		$this->display();
		
	}
	public function update(){
		$model = D('category');
		
		if(!$model->create()){
			$this->error($model->getError());
		}
		else{
			//dump($_POST);
			//dump($model->data());
			//$parentid = I('post.parentid');
			//过滤script
			//$preg = "/<script[\s\S]*?<\/script>/i";
			//$model->content= preg_replace($preg,"",$model->content,3);    //第四个参数中的3表示替换3次，默认是-1，替换全部
			$result = $model->save();
			if($result){
				//获取parentid
				$parentid = I('post.parentid');
				//获取parentid类型的所有子类型
				$pdata = $model->where('parentid=0')->select();
				//dump($pdata);
				foreach($pdata as $pkey=>$pvalue){
					$data = $model->where('parentid='.$pvalue['id'])->select();
					//dump($data);
					$list = array();
					$data0=array();
					if(isset($data)){
						
						foreach($data as $key=>$value){
							$data0[] = $value['id'];					
						}
						//转换成 5,6字符串
						$str = implode(',',$data0);
						//dump($str);
						//更新parentid类型的childids字段
						$list['childids'] = $str;
					}
					else
					{
						$list['childids']='';
					}
					$model->where('id='.$pvalue['id'])->save($list);
				}
				$this->catlist();
				$this->success('编辑成功！',U('index','parentid='.$parentid));
			}
			else{
				$this->error('编辑失败！');
			}
		}
	
		
	}
	
	public function del(){
		$model = M('category');
		$product_model = M('product');
		$id = $_GET['id'];
		//$model->delete($id);
		$parentid = $model->where('id='.$id)->getField('parentid');
		//dump($type);
		$cat = $model->where('id='.$id)->find();
		//判断是否有子类
		if(!empty($cat[childids])){
			$this->error('该类有子类别，请先删除子类别！');
		}
		else{
			$count = $product_model->where(array('categoryid'=>$id))->count();// 查询满足要求的总记录数
			if($count>0){
				$this->error('该类有产品存在，请先删除该类别下的产品！');
			}
		}
		$result = $model->where('id='.$id)->delete();
		if($result){
			$this->catlist();
			$this->success('删除成功！',U('category/index','parentid='.$parentid));
		}
		else{
			$this->error('删除失败！');
		}
		
	}
	
	public function search(){
			$model = M('category');
			$map['name'] = array('like','%'.I('post.search_key').'%');
			$list = $model->where($map)->select();
			$this->assign('list',$list);
			$this->display();
		
	}
	private function catlist(){
			$modal2 = M('category');
			$parentlist = $modal2->where('parentid=0')->select();
			$catlist=array();
			for($i=0;$i<count($parentlist);$i++){
				$cat = array();
				$cat['catid'] = $parentlist[$i]['id'];
				$cat['name'] = $parentlist[$i]['name'];
				$cat['subcat'] = $modal2->where('parentid='.$parentlist[$i]['id'])->select();
				$catlist[]=$cat;
				
			}
			session('catlist',$catlist);
			
	}
	
}