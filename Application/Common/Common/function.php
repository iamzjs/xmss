<?php
function session_deal($name){
				session('admin',$name);
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
function MyFunc($name){
	echo 'welcome '.$name;
}
function PrintArray($array){
	dump($array);
}

function MyPage($model,$where,$per=3){
		$count      = $model->where($where)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,$per);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $model->where($where)->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		return array('show'=>$show,'list'=>$list);
}


?>