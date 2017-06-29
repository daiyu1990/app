<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class OrganizationController extends AdminController{

//	组织机构列表
	public function organ_list(){
		$do = I('do');
		if($do == 'listTableData'){
//			获取搜索字段，带入model查询
			$row = I('get.');
			$info = D('Company')->getData($row);

			foreach($info as $k=>$v){

				$check = '<label class="select-checkwaring">'.
							'<input type="checkbox" value="'.$v['id'].'" class="fl check-item_waring"  name="check-item_waring">'.
						 '</label>';

				$chakan = '<a href="/Admin/Organization/organ_detail/id'.'/'. $v['id'] .'" id="organ_check" ><i class="organ-look"></i></a>';
				$xiugai = '<a href="/Admin/Organization/organ_edit/id'.'/'. $v['id'] .'" id="organ_item" ><i class="organ-editt"></i></a>';

				$result[] = array($check,$k+1,$v['name'],$v['type'],$v['diqu'],$v['contact'],$v['status'],$chakan,$xiugai);
			}
			$backData = array('data'=>$result?$result:array());
			exit(json_encode($backData));

		}elseif($do == 'del'){
//			删除企业操作
			$res = M('company')->where(array('id'=>array('IN',I('id'))))->save(array('is_del'=>1));
			if($res){
				exit(json_encode(array('status'=>1)));
				die;
			}else{
				exit(json_encode(array('status'=>0)));
				die;
			}
		}

//		获取组织机构类型
		$getdata = D('Codetype')->getData('组织机构类型');
		$this->type = D('Code')->getData($getdata);

//		获取省份信息
		$sheng = D('Region')->get_sheng();
		$this->assign('sheng',$sheng);


		$this->title = '组织机构列表';
		
		$this->display();
	}

//	组织机构审核列表
	public function c_organ_list(){
		$do = I('do');
		if($do == 'listTableData'){
			$row = I('get.');
			$info = D('Company')->getData($row);

			foreach($info as $k=>$v){

				$check = '<label class="select-checkwaring">'.
					'<input type="checkbox" value="'.$v['id'].'" class="fl check-item_waring"  name="check-item_waring">'.
					'</label>';

				$chakan = '<a href="/Admin/Organization/c_organ_detail/id'.'/'. $v['id'] .'" id="organ_check" ><i class="organ-look"></i></a>';
				$xiugai = '<a href="/Admin/Organization/organ_edit/id'.'/'. $v['id'] .'" id="organ_item" ><i class="organ-editt"></i></a>';

				$result[] = array($check,$k+1,$v['name'],$v['type'],$v['diqu'],$v['contact'],$v['status'],$chakan,$xiugai);
			}
			$backData = array('data'=>$result?$result:array());
			exit(json_encode($backData));

		}elseif($do == 'del'){
			$res = M('company')->where(array('id'=>array('IN',I('id'))))->save(array('is_del'=>1));
			if($res){
				exit(json_encode(array('status'=>1)));
				die;
			}else{
				exit(json_encode(array('status'=>0)));
				die;
			}
		}
		$getdata = D('Codetype')->getData('组织机构类型');
		$this->type = D('Code')->getData($getdata);

		$sheng = D('Region')->get_sheng();
		$this->assign('sheng',$sheng);

		$this->title = '组织机构列表';

		$this->display('organ_list');
	}

//	组织机构详情
	public function organ_detail(){
		$id = I('id');
		if(!$id){
			$this->error('请选择要查看的组织机构');
		}

		$this->info = D('Company')->getDetail($id);

		$this->title = '组织机构详情';
		$this->display();
	}

//	组织机构审核
	public function c_organ_detail(){
		$id = I('id');
		if(!$id){
			$this->error('请选择要查看的组织机构');
		}
		$do = I('do');
		if($do == 'check'){
			$data = I('data');
			$id = I('id');
			$res = M('company')->where(array('id'=>array('eq',$id)))->save(array('status'=>$data));
			if($res){
				$user = M('users')->where(array('type'=>array('eq',2),'company_id'=>array('eq',I('id'))))->find();
				$type = M('company')->find(I('id'));
				$group = M('auth_group')->where(array('company_type'=>array('eq',$type['type']),'title'=>array('eq','管理员')))->find();
				M('auth_group_access')->where(array('uid'=>array('eq',$user['uid'])))->save(array('group_id'=>$group['id']));

				exit(json_encode(array('status'=>1)));
				die;
			}else{
				exit(json_encode(array('status'=>0)));
				die;
			}
		}


		$this->info = D('Company')->getDetail($id);

		$this->title = '组织机构详情';
		$this->display('organ_detail');
	}

//	修改组织
	public function organ_edit(){

		$id = I('id');
		if(!$id){
			$this->error('请选择要编辑的组织机构');
			die;
		}
		$do = I('do');
		if($do == 'get_shi'){
//			根据传来的省份id获取城市
			$shi = D('Region')->get_shi(I('sheng'));
			if($shi){
				exit(json_encode(array('status'=>1,'data'=>$shi)));
			}else{
				exit(json_encode(array('status'=>0,'msg'=>'获取城市信息失败')));
			}
		}elseif($do == 'save1'){

			$row = I('post.');

//			判断文件格式
			if($_FILES && $_FILES['license']['size']>0 ){
				$file = explode('.',$_FILES['license']['name']);
				$ext = $file[count($file)-1];

				if($ext!='jpg' && $ext!='jpeg' && $ext!='png'){
					$this->error('营业执照文件格式错误，请上传 jpg， jpeg， png 格式的文件');
				}

			}


			$count = count(I('a_code'));

			for($i=1;$i<=$count;$i++){
				$zheng = 'a_zheng'.$i;
				$fan = 'a_fan'.$i;

				if($_FILES[$zheng]['size']>0){
					$file1 = explode('.',$_FILES[$zheng]['name']);
					$ext1 = $file1[count($file1)-1];
					if($ext1!='jpg' && $ext1!='jpeg' && $ext1!='png'){
						$this->error('证书正面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
					}
				}


				if($_FILES[$fan]['size']>0) {
					$file2 = explode('.', $_FILES[$fan]['name']);
					$ext2 = $file2[count($file2) - 1];
					if ($ext2 != 'jpg' && $ext2 != 'jpeg' && $ext2 != 'png') {
						$this->error('证书反面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
					}
				}
			}

//			上传文件
			$info = upFiles(null,'image');

			if($info){
				$res = '/Public/' . $info['license']['savepath'] . $info['license']['savename'];
			}

			if($_FILES && $_FILES['license']['size']>0 ) {
				$row['license'] = $res;
			}

//			证书正反面数组，用于添加
			$zhengshu = array();

			for($i=1;$i<=$count;$i++){
				$zheng = 'a_zheng'.$i;
				$fan = 'a_fan'.$i;
				if($_FILES[$zheng]['size']>0){
					$zhengshu[$i-1]['zheng'] = '/Public/' . $info[$zheng]['savepath'] . $info[$zheng]['savename'];

				}else{
					$zhengshu[$i-1]['zheng'] = '';
				}

				if($_FILES[$fan]['size']>0){
					$zhengshu[$i-1]['fan'] = '/Public/' . $info[$fan]['savepath'] . $info[$fan]['savename'];

				}else{
					$zhengshu[$i-1]['fan'] = '';
				}
			}


			$row['status'] = 1;

			unset($row['id']);
			unset($row['do']);
			unset($row['__hash__']);
			unset($row['sec_id']);
			unset($row['section_code']);
			unset($row['section_name']);
			unset($row['a_id']);
			unset($row['a_code']);
			unset($row['a_name']);
			unset($row['a_level']);
			unset($row['a_daoqi']);

			$res = M('company')->where(array('id'=>array('eq',I('id'))))->save($row);


			if($res!==false){
//				修改证书信息
				foreach(I('a_code') as $k=>$v){
					$info = array(
						'code'=>$v,
						'name'=>I('a_name')[$k],
						'level'=>I('a_level')[$k],
						'daoqi'=>I('a_daoqi')[$k],

					);

					if($zhengshu[$k]['zheng']!=''){
						$info['zheng']=$zhengshu[$k]['zheng'];
					}

					if($zhengshu[$k]['fan']!=''){
						$info['fan']=$zhengshu[$k]['fan'];
					}

					if(I('a_id')[$k]==''){
						$info['type'] = 1;
						$info['connet'] = I('id');
						$info['create_company'] = session('userinfo.company_id');

						M('aptitude')->add($info);
					}else{
						M('aptitude')->where(array('id'=>array('eq',I('a_id')[$k])))->save($info);
					}


				}

//				修改部门
				if(I('section_code') && count(I('section_code'))!=0) {

					$section_code = I('section_code');
					$section_name = I('section_name');
					$sec_id = I('sec_id');
					foreach ($section_code as $k => $v) {

						if($sec_id[$k]!=''){
							M('company_section')->where(array('id'=>array('eq',$sec_id[$k])))->save(array('code' => $v, 'name' => $section_name[$k]));
						}else{
							M('company_section')->add(array('company_id' => I('id'), 'code' => $v, 'name' => $section_name[$k]));
						}
					}
				}

				$this->success('保存成功');
			}else{
				$this->error('保存失败，请重试');
			}
		}elseif($do == 'del_sec'){
//			删除部门
			$sec_id = I('id');
			$res = M('company_section')->where(array('id'=>array('eq',$sec_id)))->delete();
			if($res){
				exit(json_encode(array('status'=>1,'msg'=>'删除成功')));
			}else{
				exit(json_encode(array('status'=>0,'msg'=>'删除失败，请重试')));
			}
		}elseif($do == 'del_apt'){
//			删除资质
			$apt_id = I('id');
			$res = M('aptitude')->where(array('id'=>array('eq',$apt_id)))->delete();
			if($res){
				exit(json_encode(array('status'=>1,'msg'=>'删除成功')));
			}else{
				exit(json_encode(array('status'=>0,'msg'=>'删除失败，请重试')));
			}
		}

//		公司信息
		$this->info = D('Company')->getOne($id);

//		省市信息
		$this->sheng = D('Region')->get_sheng();
		$this->shi = D('Region')->where(array('parent_id'=>array('eq',$this->info['sheng_id'])))->select();

//		组织机构类型
		$getdata = D('Codetype')->getData('组织机构类型');
		$this->type = D('Code')->getData($getdata);

		$this->title = '组织机构详情编辑';
		$this->display('organ_add');
	}


	public function organ_add(){
		$do = I('do');

		if($do == 'save1'){

//			判断文件格式
			$file = explode('.',$_FILES['license']['name']);
			$ext = $file[count($file)-1];

			if($ext!='jpg' && $ext!='jpeg' && $ext!='png'){
				$this->error('营业执照文件格式错误，请上传 jpg， jpeg， png 格式的文件');
			}

//			获取资质信息数量
			if(is_array(I('a_code'))){
				$count = count(I('a_code'));
			}else{
				$count = 0;
			}

//			判断资质文件格式
			for($i=1;$i<=$count;$i++){
				$zheng = 'a_zheng'.$i;
				$fan = 'a_fan'.$i;
				$file1 = explode('.',$_FILES[$zheng]['name']);
				$ext1 = $file1[count($file1)-1];
				$file2 = explode('.',$_FILES[$fan]['name']);
				$ext2 = $file2[count($file2)-1];

				if($ext1!='jpg' && $ext1!='jpeg' && $ext1!='png'){
					$this->error('证书正面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
				}

				if($ext2!='jpg' && $ext2!='jpeg' && $ext2!='png'){
					$this->error('证书反面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
				}
			}

//			上传文件
			$license = upFile('license');
			if($license==false){
				$this->error('文件上传错误，请重试');die;
			}
//


			$zhengshu = array();
			for($i=1;$i<=$count;$i++){
				$zheng = 'a_zheng'.$i;
				$fan = 'a_fan'.$i;
				$zhengshu[$i-1]['zheng'] = upFile($zheng);
				$zhengshu[$i-1]['fan'] = upFile($fan);

			}

			$row = I('post.');
			$row['license'] = $license;
			unset($row['id']);
			unset($row['do']);
			unset($row['__hash__']);
			unset($row['sec_id']);
			unset($row['section_code']);
			unset($row['section_name']);
			unset($row['a_id']);
			unset($row['a_code']);
			unset($row['a_name']);
			unset($row['a_level']);
			unset($row['a_daoqi']);

			$res = M('company')->add($row);

			if($res){

//				循环添加资质信息
				foreach(I('a_code') as $k=>$v){
					$info = array(
						'type'=>1,
						'connet'=>$res,
						'code'=>$v,
						'name'=>I('a_name')[$k],
						'level'=>I('a_level')[$k],
						'daoqi'=>I('a_daoqi')[$k],
						'zheng'=>$zhengshu[$k]['zheng'],
						'fan'=>$zhengshu[$k]['fan'],
						'create_company'=>session('userinfo.company_id')
					);

					M('aptitude')->add($info);
				}

//				循环添加部门
				if(I('section_code') && count(I('section_code'))!=0){
					$section_code = I('section_code');
					$section_name = I('section_name');
					foreach($section_code as $k=>$v){
						M('company_section')->add(array('company_id'=>$res,'code'=>$v,'name'=>$section_name[$k]));
					}
				}

				$this->success('保存成功');
			}else{
				$this->error('保存失败，请重试');
			}
		}



//		获取省份信息
		$this->sheng = D('Region')->get_sheng();

//		获取组织机构类型
		$getdata = D('Codetype')->getData('组织机构类型');
		$this->type = D('Code')->getData($getdata);

		$this->title = '组织机构添加';
		$this->display();
	}

//	人员列表
	public function person_list(){

		$do = I('do');
		if($do == 'listTableData'){
//			获取搜索参数，带入model查询
			$row = I('get.');
			$info = D('User')->getDatas($row);

			foreach($info as $k=>$v){

				$check = '<label class="select-checkwaring">'.
							'<input type="checkbox" value="'.$v['uid'].'" class="fl check-item_waring"  name="check-item_waring">'.
						 '</label>';

				$chakan = '<a href="/Admin/Organization/person_detail/id'.'/'. $v['uid'] .'" id="organ_check" ><i class="organ-look"></i></a>';
				$xiugai = '<a href="/Admin/Organization/person_edit/id'.'/'. $v['uid'] .'" id="organ_item" ><i class="organ-editt"></i></a>';

				$result[] = array($check,$k+1,$v['nicename'],$v['mobile'],$v['c_name'],$v['c_type'],$v['check'],$v['active'],$chakan,$xiugai);
			}
			$backData = array('data'=>$result?$result:array());
			exit(json_encode($backData));

		}elseif($do == 'del'){
//			删除人员
			$res = M('users')->where(array('uid'=>array('IN',I('id'))))->save(array('del'=>1));
			if($res){
				M('aptitude')
					->where(array(
						'connet'=>array('eq',I('id')),
						'type'=>array('eq',2),
					))->save(array('del'=>1));
				exit(json_encode(array('status'=>1)));
				die;
			}else{
				exit(json_encode(array('status'=>0)));
				die;
			}
		}
		$getdata = D('Codetype')->getData('组织机构类型');
		$this->type = D('Code')->getData($getdata);


		$this->title = '人员列表';


		$this->display();
	}

//	人员审核列表
	public function c_person_list(){

		$do = I('do');
		if($do == 'listTableData'){
			$row = I('get.');
			$info = D('User')->getDatas($row);

			foreach($info as $k=>$v){

				$check = '<label class="select-checkwaring">'.
					'<input type="checkbox" value="'.$v['uid'].'" class="fl check-item_waring"  name="check-item_waring">'.
					'</label>';

				$chakan = '<a href="/Admin/Organization/c_person_detail/id'.'/'. $v['uid'] .'" id="organ_check" ><i class="organ-look"></i></a>';
				$xiugai = '<a href="/Admin/Organization/person_edit/id'.'/'. $v['uid'] .'" id="organ_item" ><i class="organ-editt"></i></a>';

				$result[] = array($check,$k+1,$v['nicename'],$v['mobile'],$v['c_name'],$v['c_type'],$v['check'],$v['active'],$chakan,$xiugai);
			}
			$backData = array('data'=>$result?$result:array());
			exit(json_encode($backData));

		}elseif($do == 'del'){
			$res = M('users')->where(array('uid'=>array('IN',I('id'))))->save(array('del'=>1));
			if($res){
				M('aptitude')
					->where(array(
						'connet'=>array('eq',I('id')),
						'type'=>array('eq',2),
					))->save(array('del'=>1));
				exit(json_encode(array('status'=>1)));
				die;
			}else{
				exit(json_encode(array('status'=>0)));
				die;
			}
		}
		$getdata = D('Codetype')->getData('组织机构类型');
		$this->type = D('Code')->getData($getdata);


		$this->title = '人员列表';


		$this->display('person_list');
	}

//	人员添加
	public function person_add(){

		$do = I('do');

		if($do == 'save'){

//			判断手机号是否注册
			$is_register = M('users')->where(array('username'=>array('eq',I('mobile'))))->find();
			if($is_register){
				$this->error('该手机号已注册');
			}

//			判断文件格式
			$file1 = explode('.',$_FILES['IDcard_zheng']['name']);
			$ext = $file1[count($file1)-1];

			if($ext!='jpg' && $ext!='jpeg' && $ext!='png'){
				$this->error('身份证正面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
			}

			$file2 = explode('.',$_FILES['IDcard_fan']['name']);
			$ext = $file2[count($file2)-1];

			if($ext!='jpg' && $ext!='jpeg' && $ext!='png'){
				$this->error('身份证正面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
			}

//			获取资质信息数量，
			$count = count(I('a_code'));
			if(I('a_code')){

//				循环判断资质文件格式
				for($i=1;$i<=$count;$i++){
					$zheng = 'a_zheng'.$i;
					$fan = 'a_fan'.$i;
					$file1 = explode('.',$_FILES[$zheng]['name']);
					$ext1 = $file1[count($file1)-1];
					$file2 = explode('.',$_FILES[$fan]['name']);
					$ext2 = $file2[count($file2)-1];

					if($ext1!='jpg' && $ext1!='jpeg' && $ext1!='png'){
						$this->error('证书正面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
					}

					if($ext2!='jpg' && $ext2!='jpeg' && $ext2!='png'){
						$this->error('证书反面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
					}
				}
			}



//			上传文件
			$info = upFiles(null,'image');
//
			if($info){
//				身份证正反面上传地址
				$res1 = '/Public/' . $info['IDcard_zheng']['savepath'] . $info['IDcard_zheng']['savename'];
				$res2 = '/Public/' . $info['IDcard_fan']['savepath'] . $info['IDcard_fan']['savename'];

//				证书上传地址数组
				$zhengshu = array();
				for($i=1;$i<=$count;$i++){
					$zheng = 'a_zheng'.$i;
					$fan = 'a_fan'.$i;
					$zhengshu[$i-1]['zheng'] = '/Public/' . $info[$zheng]['savepath'] . $info[$zheng]['savename'];
					$zhengshu[$i-1]['fan'] = '/Public/' . $info[$fan]['savepath'] . $info[$fan]['savename'];

				}
			}

//			添加人员信息
			$row = array(
				'company_id'=>session('userinfo.company_id'),
				'nicename'=>I('name'),
				'username'=>I('mobile'),
				'mobile'=>I('mobile'),
				'password'=>md5(I('pwd1').C('AUTH_kEY')),
				'person_code'=>I('person_code'),
				'IDcard'=>I('IDcard'),
				'section'=>I('section'),
//				'duty'=>I('zhiwei'),
				'IDcard_zheng'=>$res1,
				'IDcard_fan'=>$res2,
				'type'=>1,
				'status'=>0,
				'check'=>0,
				'active'=>0
			);

			$id = M('users')->add($row);

			if($id){

//				添加职位，关联角色和权限
				M('auth_group_access')->add(array('uid'=>$id,'group_id'=>I('zhiwei')));

//				循环添加资质
				foreach(I('a_code') as $k=>$v){
					$info = array(
						'type'=>2,
						'connet'=>$id,
						'code'=>$v,
						'name'=>I('a_name')[$k],
						'level'=>I('a_level')[$k],
						'daoqi'=>I('a_daoqi')[$k],
						'zheng'=>$zhengshu[$k]['zheng'],
						'fan'=>$zhengshu[$k]['fan'],
						'create_company'=>session('userinfo.company_id')
					);

					M('aptitude')->add($info);
				}
				$this->success('保存成功');
			}else{
				$this->error('保存失败，请重试');
			}



		}


//		获取该角色所在公司的部门
		$this->section = M('company_section')->where(array('company_id'=>array('eq',session('userinfo.company_id'))))->select();

//		获取该角色所在公司的角色
		$this->group = D('Company')->get_group(session('userinfo.company_id'));

		$this->title = '添加人员';
		$this->display();
	}

//	修改人员
	public function person_edit(){

		$id = I('id');
		if(!$id){
			$this->error('请选择要修改的人员');
		}
		$do = I('do');

		if($do == 'save'){
//			dump(I('post.'));die;
			$is_register = M('users')->where(array('uid'=>array('neq',I('id')),'username'=>array('eq',I('mobile'))))->find();
			if($is_register){
				$this->error('该手机号已注册');
			}

			$row = array(
//				'company_id'=>session('userinfo.company_id'),
				'nicename'=>I('name'),
				'username'=>I('mobile'),
				'mobile'=>I('mobile'),
				'person_code'=>I('person_code'),
				'IDcard'=>I('IDcard'),
				'section'=>I('section'),
//				'duty'=>I('zhiwei'),
				'type'=>1,
				'status'=>0,
				'check'=>0,
				'active'=>0
			);

			if(I('pwd1')!=''){
				$row['password']=md5(I('pwd1').C('AUTH_kEY'));
			}


			if($_FILES['IDcard_zheng']['size']>0){
				$file1 = explode('.', $_FILES['IDcard_zheng']['name']);
				$ext = $file1[count($file1) - 1];

				if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
					$this->error('身份证正面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
				}

			}

			if($_FILES['IDcard_fan']['size']>0){
				$file2 = explode('.', $_FILES['IDcard_fan']['name']);
				$ext = $file2[count($file2) - 1];

				if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'png') {
					$this->error('身份证正面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
				}

			}



			$info = upFiles(null, 'image');

			if ($info) {
				$res1 = '/Public/' . $info['IDcard_zheng']['savepath'] . $info['IDcard_zheng']['savename'];
				if($res1!='/Public/'){
					$row['IDcard_zheng'] = $res1;
				}
				$res2 = '/Public/' . $info['IDcard_fan']['savepath'] . $info['IDcard_fan']['savename'];
				if($res1!='/Public/'){
					$row['IDcard_fan'] = $res2;
				}
			}


			$count = count(I('a_code'));

			for($i=1;$i<=$count;$i++){
				$zheng = 'a_zheng'.$i;
				$fan = 'a_fan'.$i;

				if($_FILES[$zheng]['size']>0){
					$file1 = explode('.',$_FILES[$zheng]['name']);
					$ext1 = $file1[count($file1)-1];
					if($ext1!='jpg' && $ext1!='jpeg' && $ext1!='png'){
						$this->error('证书正面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
					}
				}


				if($_FILES[$fan]['size']>0) {
					$file2 = explode('.', $_FILES[$fan]['name']);
					$ext2 = $file2[count($file2) - 1];
					if ($ext2 != 'jpg' && $ext2 != 'jpeg' && $ext2 != 'png') {
						$this->error('证书反面文件格式错误，请上传 jpg， jpeg， png 格式的文件');
					}
				}
			}

			$zhengshu = array();

			for($i=1;$i<=$count;$i++){
				$zheng = 'a_zheng'.$i;
				$fan = 'a_fan'.$i;
				if($_FILES[$zheng]['size']>0){
					$zhengshu[$i-1]['zheng'] = '/Public/' . $info[$zheng]['savepath'] . $info[$zheng]['savename'];

				}else{
					$zhengshu[$i-1]['zheng'] = '';
				}

				if($_FILES[$fan]['size']>0){
					$zhengshu[$i-1]['fan'] = '/Public/' . $info[$fan]['savepath'] . $info[$fan]['savename'];

				}else{
					$zhengshu[$i-1]['fan'] = '';
				}
			}

			$id = M('users')->where(array('uid'=>array('eq',I('id'))))->save($row);
//			dump($id);
//			dump(M('users')->getlastsql());die;
			if($id!==false){

				M('auth_group_access')->where(array('uid'=>array('eq',I('id'))))->save(array('group_id'=>I('zhiwei')));

				foreach(I('a_code') as $k=>$v){
					$info = array(
						'code'=>$v,
						'name'=>I('a_name')[$k],
						'level'=>I('a_level')[$k],
						'daoqi'=>I('a_daoqi')[$k],

					);

					if($zhengshu[$k]['zheng']!=''){
						$info['zheng']=$zhengshu[$k]['zheng'];
					}

					if($zhengshu[$k]['fan']!=''){
						$info['fan']=$zhengshu[$k]['fan'];
					}

					if(I('a_id')[$k]==''){
						$info['type'] = 2;
						$info['connet'] = I('id');
						$info['create_company'] = session('userinfo.company_id');

						M('aptitude')->add($info);
					}else{
						M('aptitude')->where(array('id'=>array('eq',I('a_id')[$k])))->save($info);
					}


				}
				$this->success('保存成功');
			}else{
				$this->error('保存失败，请重试');
			}



		}elseif($do == 'del_apt'){
			$apt_id = I('id');
			$res = M('aptitude')->where(array('id'=>array('eq',$apt_id)))->delete();
			if($res){
				exit(json_encode(array('status'=>1,'msg'=>'删除成功')));
			}else{
				exit(json_encode(array('status'=>0,'msg'=>'删除失败，请重试')));
			}
		}



		$info = M('users')->find($id);
		$info['group'] = M('auth_group_access')->where(array('uid'=>array('eq',$id)))->find();
		$info['zizhi'] = M('aptitude')->where(array('type'=>array('eq',2),'connet'=>array('eq',$id)))->select();
		$this->assign('info',$info);


//		需要时改成当前用户的公司id
		$this->section = M('company_section')->where(array('company_id'=>array('eq',session('userinfo.company_id'))))->select();

//		$this->section = M('company_section')->where(array('company_id'=>array('eq',15)))->select();

//		$this->group = D('Company')->get_group(15);

		$this->group = D('Company')->get_group(session('userinfo.company_id'));

		$this->title = '修改人员';
		$this->display('person_add');
	}

//	人员详情
	public function person_detail(){

		$id = I('id');
		if(!$id){
			$this->error('请选择要查看的人员');
		}

		$this->info = D('User')->getDetail($id);
//		dump($this->info);die;
		$this->title = '人员个人信息';
		$this->display();
	}

//	人员审核
	public function c_person_detail(){

		$id = I('id');
		if(!$id){
			$this->error('请选择要查看的人员');
		}
		$do = I('do');
		if($do == 'check'){
//			审核操作
			$data = I('data');
			$id = I('id');
			$res = M('users')->where(array('uid'=>array('eq',$id)))->save(array('check'=>$data));
			if($res!==false){
				exit(json_encode(array('status'=>1)));
				die;
			}else{
				exit(json_encode(array('status'=>0)));
				die;
			}
		}

		$this->info = D('User')->getDetail($id);
//		dump($this->info);die;
		$this->title = '人员个人信息';
		$this->display('person_detail');
	}
	
	public function checking(){
		
		$this->display();
	}
}
?>