<?php
/**
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class EquipmentController extends AdminController {

//	Dtu列表
	public function DTU_list(){
		$do = I('do');
		if($do == 'listTableData'){
			$row = I('get.');

			$info = D('DTU')->getData($row);


			foreach($info as $k=>$v){
				$check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="fl check-item"><span class="fl"></span></label>';
				$chakan = '<a href="/Admin/Equipment/DTU_detail/id'.'/'. $v['id'] .'"  id="organ_check"><i class="organ-look"></i></a>';
				$bianji = '<a href="/Admin/Equipment/DTU_edit/id'.'/'.$v['id'] .'" id="organ_item"><i class="organ-editt"></i></a>';

				$result[] = array($check,$k+1,$v['code'],$v['type'],$v['xinghao'],$v['company_name'],$v['plc'],$v['fac_code'],$v['fac_type'],$v['status'],$chakan,$bianji);
			}
			$backData = array('data'=>$result?$result:array());


			exit(json_encode($backData));
		}elseif($do == 'del'){
//			删除操作
			$res = M('dtu')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
			if($res){
				exit(json_encode(array('status'=>1)));
				die;
			}else{
				exit(json_encode(array('status'=>0)));
				die;
			}
		}

//		dtu类型
		$this->type = M('code')->where(array('code'=>array('eq','dtu_type')))->select();

		$this->title = 'DTU列表';
		$this->display();
	}

//	dtu审核列表
	public function c_DTU_list(){
		$do = I('do');
		if($do == 'listTableData'){
			$row = I('get.');

			$info = D('DTU')->getData($row);


			foreach($info as $k=>$v){
				$check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="fl check-item"><span class="fl"></span></label>';
				$chakan = '<a href="/Admin/Equipment/c_DTU_detail/id'.'/'. $v['id'] .'"  id="organ_check"><i class="organ-look"></i></a>';
				$bianji = '<a href="/Admin/Equipment/DTU_edit/id'.'/'.$v['id'] .'" id="organ_item"><i class="organ-editt"></i></a>';

				$result[] = array($check,$k+1,$v['code'],$v['type'],$v['xinghao'],$v['company_name'],$v['plc'],$v['fac_code'],$v['fac_type'],$v['status'],$chakan,$bianji);
			}
			$backData = array('data'=>$result?$result:array());


			exit(json_encode($backData));
		}elseif($do == 'del'){
			$res = M('dtu')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
			if($res){
				exit(json_encode(array('status'=>1)));
				die;
			}else{
				exit(json_encode(array('status'=>0)));
				die;
			}
		}

		$this->type = M('code')->where(array('code'=>array('eq','dtu_type')))->select();

		$this->title = 'DTU列表';
		$this->display('DTU_list');
	}

//	添加Dtu
	public function DTU_add(){

		$do = I('do');
		if($do == 'save'){
//			判断dtu编号是否已被使用
			$is_use = M('dtu')->where(array('code'=>array('eq',I('code'))))->find();
			if($is_use){
				exit(json_encode(array('status'=>0,'msg'=>'该DTU编号已被使用')));
				die;
			}
			$row = array(
				'code'=>I('code'),
				'type'=>I('type'),
				'xinghao'=>I('xinghao'),
				'make_company'=>I('zhizao'),
				'plc'=>I('plc'),
				'fac_code'=>I('fac_code'),
				'chuchang'=>I('chuchang'),
				'create_time'=>date('Y-m-d H:i:s'),
				'create_company'=>session('userinfo.company_id')
			);
			$id = M('dtu')->add($row);
			if($id){
				exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
				die;
			}else{
				exit(json_encode(array('status'=>0,'msg'=>'保存失败')));
				die;
			}
		}
//		企业信息
		$company = M('Company')
			->field('id,name')
			->where(array('is_del'=>array('eq',0)))
			->select();

		$this->assign('company',$company);

//		dtu类型
		$this->type = M('code')->where(array('code'=>array('eq','dtu_type')))->select();

//		设备列表
		$this->fac = M('facility_msg')->where(array('del'=>array('eq',0),'status'=>array('eq',1)))->select();
		$this->title = '添加DTU';
		$this->display();
	}

//	设备修改
	public function DTU_edit(){

		$id = I('id');
		if(!$id){
			$this->error('请选择要修改的DTU');
		}
		$do = I('do');
		if($do == 'save'){
			$is_use = M('dtu')->where(array('code'=>array('eq',I('code')),'id'=>array('neq',I('id'))))->find();
			if($is_use){
				exit(json_encode(array('status'=>0,'msg'=>'该DTU编号已被使用')));
				die;
			}

			$row = array(
				'code'=>I('code'),
				'type'=>I('type'),
				'xinghao'=>I('xinghao'),
				'make_company'=>I('zhizao'),
				'plc'=>I('plc'),
				'fac_code'=>I('fac_code'),
				'chuchang'=>I('chuchang'),
				'status'=>0
			);
			$res = M('dtu')->where(array('id'=>array('eq',I('id'))))->save($row);
			if($res!==false){
				exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
				die;
			}else{
				exit(json_encode(array('status'=>0,'msg'=>'保存失败')));
				die;
			}
		}

		$this->info = D('DTU')->getOne($id);

		$company = M('Company')
			->field('id,name')
			->where(array('is_del'=>array('eq',0)))
			->select();

		$this->assign('company',$company);

		$this->fac = M('facility_msg')->where(array('del'=>array('eq',0),'status'=>array('eq',1)))->select();

		$this->type = M('code')->where(array('code'=>array('eq','dtu_type')))->select();
		$this->title = '修改DTU';
		$this->display('DTU_add');
	}

//	Dtu详情
	public function DTU_detail(){
		$id = I('id');
		if(!$id){
			$this->error('请选择要修改的DTU');
		}

		$this->info = D('DTU')->getDetail($id);

		$this->title = 'DTU详情';
		$this->display();
	}

//	设备审核详情
	public function c_DTU_detail(){
		$id = I('id');
		if(!$id){
			$this->error('请选择要修改的DTU');
		}
		$do = I('do');
		if($do == 'check'){
//			审核操作
			$res = M('dtu')->where(array('id'=>array('eq',I('id'))))->save(array('status'=>I('data')));

			if($res){
				exit(json_encode(array('status'=>1)));
				die;
			}else{
				exit(json_encode(array('status'=>0)));
				die;
			}
		}

		$this->info = D('DTU')->getDetail($id);

		$this->title = 'DTU详情';
		$this->display('DTU_detail');
	}


}