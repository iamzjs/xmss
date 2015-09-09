<?php
namespace Admin\Controller;
use Think\Controller;
class MenuWidget extends Controller {
    
	public function menu(){
		//$model = M('category');		
		//$list = $model->where('type='.$_GET['type'])->select();
		$model = M();
		
		$sql2="select c1.*,c2.name parentname from category c1 
	  left join category c2 on c1.parentid = c2.id
	  where c1.parentid=".I('get.parentid')
	  ." order by id desc limit ".$Page->firstRow.",".$Page->listRows;
		//dump($sql2);
		$list = $model->query($sql2);
		//return $list;
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
				$this->success('编辑成功！',U('index','parentid='.$parentid));
			}
			else{
				$this->error('编辑失败！');
			}
		}
	
		
	}
	
	public function del(){
		$model = M('category');
		$id = $_GET['id'];
		//$model->delete($id);
		$parentid = $model->where('id='.$id)->getField('parentid');
		//dump($type);
		$result = $model->where('id='.$id)->delete();
		if($result){
			$this->success('删除成功！',U('category/index','parentid='.$parentid));
		}
		else{
			$this->error('删除失败！');
			$this->error('删除失败！');
		}
		
	}
	
}