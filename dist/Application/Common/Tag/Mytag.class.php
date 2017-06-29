<?php
/**
 * @Author: Sincez
 * @Date:   2016-11-19 21:41:39
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-12-21 11:17:44
 */
namespace Common\Tag;
use Think\Template\TagLib;

class Mytag extends TagLib
{
	protected $tags   =  array(
  		// 定义标签
		'Nav'    =>    array('attr'=>'id','close'=>1), // input标签
		'FinishedSearch'=>array('attr'=>'id','close'=>1),
		'FinishedOption'=>array('attr'=>'id','close'=>1),
		'FinishedPriceOption'=>array('attr'=>'id','close'=>1),
		'FinishedYellowOption'=>array('attr'=>'id','close'=>1),
		'FindSearch'=>array('attr'=>'id,url','close'=>1),
		'FindOption'=>array('attr'=>'id,url','close'=>1),
	);
	/*
	导购员导购平台商品类型导航获取
	 */
	public function _Nav($tag,$content){
		$id    =    $tag['id'];
		$uid = session('userinfo.uid');
		$brand_id = session('userinfo.brand_id');
		$is_show = 1;
		$str = '<?php ';
       	$str .= '$list = D("Admin/Goodstyperelation")->getCurList(array("uid"=>'.$uid.',"brand_id"=>'.$brand_id.',"is_show"=>'.$is_show.',"show_goodstype"=>1));';
       	$str .= 'foreach ($list as $'.$id.'): ?>';
       	$str .= $content;
       	$str .='<?php endforeach ?>';
       	return $str;
	}

	/**
	导购员平台 成品现货获取去见搜索和文本搜索框 
	*/
	public function _FinishedSearch($tag,$content){
		$turl = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		$info = D('Admin/Goodstype')->where(array('turl'=>$turl))->find();
		$id    =    $tag['id'];
		$brand_id = session('userinfo.brand_id');
		$is_show = 1;
		$is_search = 1;
		$search_type = '1,2';
		$str = '<?php ';
       	$str .= '$list = D("Admin/Paramset")->getSearchOption(array("goodstype_id"=>'.$info['id'].',"is_search"=>'.$is_search.',"search_type"=>array('.$search_type.'),"brand_id"=>'.$brand_id.',"is_show"=>'.$is_show.'));';
       	$str .= 'foreach ($list as $'.$id.'): ?>';
       	$str .= $content;
       	$str .='<?php endforeach ?>';
       	return $str;
	}

	public function _FinishedOption($tag,$content){

		$turl = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		$info = D('Admin/Goodstype')->where(array('turl'=>$turl))->find();
		$id    =    $tag['id'];
		$brand_id = session('userinfo.brand_id');
		$uid = session('userinfo.uid');
		$shows = D('Admin/Goodstyperelation')->getSaleset(array('uid'=>$uid,'brand_id'=>$brand_id,'is_show'=>1,'paramset_id'=>array('neq',0),'goodstype_id'=>$info['id'],'neq_col'=>array('intprice','discount')));//echo M()->getLastsql();die;//print_r($shows);die;
		// $shows = D('Admin/Goodstyperelation')->field('paramset_id')->where(array('uid'=>$uid,'brand_id'=>$brand_id,'is_show'=>1,'paramset_id'=>array('neq',0)))->select();
		if($shows){
			$sales = array_coltoarray($shows,'paramset_id');
		} else {
			if($info['id'] == 1 || $info['id']== 2){
				$sales = array('-111');
			}	
		}
		if($info['id'] != 3){
			$permission = D('Admin/Businessrelation')->getSelfBusiness(array('uid'=>$uid,'brand_id'=>$brand_id,'goodstype_id'=>$info['id']));
			if($permission){
				$pers = $permission;
			} else {
				$pers = array('-111');
			}
		}
		
		$is_show = 1;
		$is_search = 1;
		$search_type = '3,4';

		$str = '<?php ';
       	$str .= '$list = D("Admin/Paramsetvalue")->getSearchOption(array("goodstype_id"=>'.$info['id'].',"is_search"=>'.$is_search.',"search_type"=>array('.$search_type.'),"paramset_ids"=>array('.implode(',',$sales).'),"brand_id"=>'.$brand_id.',"is_show"=>'.$is_show.',"pers_id"=>array('.implode(',',$pers).')));';
       	$str .= 'foreach ($list as $'.$id.'): ?>';
       	$str .= $content;
       	$str .='<?php endforeach ?>';
       	return $str;
	}

	public function _FinishedYellowOption($tag,$content){

		$turl = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		$info = D('Admin/Goodstype')->where(array('turl'=>$turl))->find();
		$id    =    $tag['id'];
		$brand_id = session('userinfo.brand_id');
		$is_show = 1;
		$is_search = 1;
		$search_type = '3,4';

		$str = '<?php ';
       	$str .= '$list = D("Admin/Paramsetvalue")->getSearchOption(array("goodstype_id"=>'.$info['id'].',"is_search"=>'.$is_search.',"search_type"=>array('.$search_type.'),"col_name"=>"yellow","brand_id"=>'.$brand_id.',"is_show"=>'.$is_show.'));';
       	$str .= 'foreach ($list as $'.$id.'): ?>';
       	$str .= $content;
       	$str .='<?php endforeach ?>';
       	return $str;
	}

	public function _FinishedPriceOption($tag,$content){

		$turl = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		$info = D('Admin/Goodstype')->where(array('turl'=>$turl))->find();
		$id    =    $tag['id'];
		$brand_id = session('userinfo.brand_id');
		$is_show = 1;
		$is_search = 1;
		$search_type = '3,4';

		$str = '<?php ';
       	$str .= '$list = D("Admin/Paramsetvalue")->getSearchOption(array("goodstype_id"=>'.$info['id'].',"is_search"=>'.$is_search.',"search_type"=>array('.$search_type.'),"col_name"=>"price","brand_id"=>'.$brand_id.',"is_show"=>'.$is_show.'));';
       	$str .= 'foreach ($list as $'.$id.'): ?>';
       	$str .= $content;
       	$str .='<?php endforeach ?>';
       	return $str;
	}

	/**
	导购员平台 成品现货获取去见搜索和文本搜索框
	 */
	public function _FindSearch($tag,$content){
		$turl = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.$tag['url'];
		$info = D('Admin/Goodstype')->where(array('turl'=>$turl))->find();
		$id    =    $tag['id'];
		$brand_id = session('userinfo.brand_id');
		$is_show = 1;
		$is_search = 1;
		$search_type = '1,2';
		$str = '<?php ';
		$str .= '$list = D("Admin/Paramset")->getSearchOption(array("goodstype_id"=>'.$info['id'].',"is_search"=>'.$is_search.',"search_type"=>array('.$search_type.'),"brand_id"=>'.$brand_id.',"is_show"=>'.$is_show.'));';
		$str .= 'foreach ($list as $'.$id.'): ?>';
		$str .= $content;
		$str .='<?php endforeach ?>';
		return $str;
	}

	public function _FindOption($tag,$content){

		$turl = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.$tag['url'];
		$info = D('Admin/Goodstype')->where(array('turl'=>$turl))->find();
		$id    =    $tag['id'];
		$brand_id = session('userinfo.brand_id');
		$uid = session('userinfo.uid');
		// $sales = D('Admin/Businessrelation')->getSelfBusiness(array('uid'=>$uid,'brand_id'=>$brand_id));
		$is_show = 1;
		$is_search = 1;
		$search_type = '3,4';

		$str = '<?php ';
		$str .= '$list = D("Admin/Paramsetvalue")->getSearchOption(array("goodstype_id"=>'.$info['id'].',"is_search"=>'.$is_search.',"search_type"=>array('.$search_type.'),"detail_ids"=>array('.implode(',',$sales).'),"brand_id"=>'.$brand_id.',"is_show"=>'.$is_show.'));';
		$str .= 'foreach ($list as $'.$id.'): ?>';
		$str .= $content;
		$str .='<?php endforeach ?>';
		return $str;
	}
}
