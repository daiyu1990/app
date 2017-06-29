<?php
/**
 * @Author: Sincez
 * @Date:   2016-10-27 10:09:14
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-03-16 13:30:22
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Think;
class CodeController extends Controller
{
	public function index(){	//name:选项管理
		$this->title = '选项管理';
		$do = I('do');
		if($do == 'listTableData'){
			$codes = D('Codetype')->order('if(ord=0,99999,ord)')->select();
			foreach($codes as $v){
				$op = create_Url('Admin/Code/add','添加子项',array('do'=>'option','cid'=>$v['id']),'class="m-r-5"');
				$op .= create_Url('Admin/Code/del','删除',array('id'=>$v['id']),'class="del m-r-5"');
				$op .= create_Url('Admin/Code/index','生成缓存',array('do'=>'createCache','code'=>$v['code']));
				$result[] = array($v['id'],$v['name'],$v['code'],$v['ord'],$v['create_time'],$op);
			}
			$backData = array('data'=>$result?$result:array());
            exit(json_encode($backData));
		} elseif($do == 'createCache'){
			$code = I('code');
			$codes = D('Code')->where(array('code'=>$code))->order('if(ord=0,99999,ord)')->select();
			$codes = array_coltokey($codes,'id');
			F($code,$codes);
			$this->success('生成缓存成功！');
			exit();
		}
		$this->display();
	}

	public function add(){		//选项添加
		$this->title = '选项添加';
		$do = I('do');
		if($do == 'save'){
			if (!D('Codetype')->autoCheckToken($_POST)){
				$this->error('非法操作！');
			}
			$row = I('post.');
			if(!$row['name']){
				$this->error('选项名称不能为空！');
				exit();
			}
			if(!$row['code']){
				$this->error('选项代码不能为空！');
				exit();
			}
			if($row['id']){
				$count = D('Codetype')->where(array('code'=>$row['code'],'id'=>array('neq',$row['id'])))->count();
				if($count>0){
					$this->error('选项代码已存在，请更换！');
					exit();
				}
				$data = array('code'=>$row['code']);
				$where = array('code'=>$row['code']);
				if($row['is_system']){
					$data['is_system'] = 1;
					$where['uid'] = array('eq',0);
				}
				D('Code')->where($where)->save($data);
			}
			$cid = D('Codetype')->insertData($row);
			$this->redirect('Admin/Code/add/do/option/cid/'.$cid);
		} elseif($do == 'option'){
			$cid = I('cid');
			if(!$cid){
				$this->error('请先选择要添加的选项！');
				exit();
			}
			$this->info = D('Codetype')->find($cid);
			$this->options = D('Codetype')->order('if(ord=0,99999,ord)')->select();
			$codes = D('Code')->where(array('code'=>$this->info['code']))->order('ord asc')->select();
            $this->codess = \Admin\Model\CodeModel::getTree(0, $codes);
			$this->display('option_set');
			exit();
		} elseif($do == 'saveChild'){
			// if (!D('Code')->autoCheckToken($_POST)){
			// 	$this->error('非法操作！');
			// }
			$row = I('post.');
			if(!$row['name']){
				$this->error('选项名称不能为空！');
				exit();
			}
			if(!is_numeric($row['val']) && !$row['val']){
				$this->error('选项值不能为空！');
				exit();
			}
			if($row['pid']){
				$code = D('Code')->find($row['pid']);
				$row['trees'] = $code['trees'].','.$row['pid'];
			} else {
				$row['trees'] = 0;
			}
			$codetype = D('Codetype')->where(array('code'=>$row['code']))->find();
			// $row['is_system'] = $codetype['is_system'];
			D('Code')->insertData($row);
			$this->redirect(returnUrl());
		} elseif($do == 'up'){
			$row = I('get.');
			if(!$row['id']){
				exit(json_encode(array('status'=>0,'msg'=>'请选择要编辑的记录！')));
			}
			if(!$row['name']){
				exit(json_encode(array('status'=>0,'msg'=>'选项名称不能为空！')));
			}
			if(!is_numeric($row['val']) && !$row['val']){
				exit(json_encode(array('status'=>0,'msg'=>'选项值不能为空！')));
			}
			$row['modify_time'] = time();
			D('Code')->insertData($row);
			exit(json_encode(array('status'=>1)));
		} elseif($do == 'listTableData'){
			$code = I('code');
			$pid = I('pid');
			$codetype = D('Codetype')->where(array('code'=>$code))->find();
			$codes = F($code);
			if(!$codes){
				$codes = D('Code')->where(array('code'=>$code))->order('if(ord=0,99999,ord)')->select();
			}
			
			if ($pid) {
				$co = D('Code')->find($pid);
                $cod[$co['id']] = $co;
                $cod[$pid]['tree'] = \Admin\Model\CodeModel::getTree($pid, $codes);
            } else {
                $cod = \Admin\Model\CodeModel::getTree(0, $codes);
            }
            $this->codes = $cod;
            // $this->codess = \Admin\Model\CodeModel::getTree(0, $codes);
            exit(\Admin\Model\CodeModel::treeList($this->codes));

		} elseif($do == 'del'){
			$id = I('id');
			if(!$id){
				exit(json_encode(array('status'=>0,'msg'=>'请选择要删除的记录！')));
			}
			D('Code')->delete($id);
			exit(json_encode(array('status'=>1)));
		}
		$id = I('id');
		if($id){
			$this->info = D('Codetype')->find($id);
		} elseif($do == 'getSelfandChild'){
			$cid = I('cid');
			if(!$cid){
				exit('请先选择要添加的选项！');
			}
			$this->info = D('Codetype')->find($cid);
			$this->options = D('Codetype')->order('if(ord=0,99999,ord)')->select();
			$codes = D('Code')->where(array('code'=>$this->info['code']))->order('ord asc')->select();
            $this->codess = \Admin\Model\CodeModel::getTree(0, $codes);
            exit(\Admin\Model\CodeModel::treeSel($this->codess, I('pid')?array(I('pid')):0, null, '─'));
		}
		$this->display();
	}

	public function del(){
		$id = I('id');
		if(!$id){
			exit(json_encode(array('status'=>0,'msg'=>'请选择要删除的记录！')));
		}
		$ctinfo = D('Codetype')->find($id);
		D('Code')->where(array('code'=>$ctinfo['code']))->delete();
		D('Codetype')->delete($id);
		exit(json_encode(array('status'=>1)));
	}
}