<?php
/**
 * Created by coder meng.
 * User: 设备管理
 * Date: 2017/3/15 14:55
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class TerminalController extends AdminController
{


//  终端列表
    public function term_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');

            $info = D('Terminal')->getData($row);


            foreach($info as $k=>$v){
                $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="fl check-item"><span class="fl"></span></label>';
                $chakan = '<a href="/Admin/Terminal/term_detail/id'.'/'. $v['id'] .'"  id="organ_check"><i class="organ-look"></i></a>';
                $bianji = '<a href="/Admin/Terminal/term_edit/id'.'/'.$v['id'] .'" id="organ_item"><i class="organ-editt"></i></a>';

                $result[] = array($check,$k+1,$v['terminal_number'],$v['terminal_model_number'],'',empty($v['factory_date'])?'':substr($v['factory_date'],0,10),$v['status'],$v['ol'],$chakan,$bianji);
            }
            $backData = array('data'=>$result?$result:array());


            exit(json_encode($backData));
        }elseif($do == 'del'){
//            删除操作
            $res = M('terminal')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }


        $this->title='终端列表';
        $this->display();
    }

//    终端审核列表
    public function c_term_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');

            $info = D('Terminal')->getData($row);


            foreach($info as $k=>$v){
                $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="fl check-item"><span class="fl"></span></label>';
                $chakan = '<a href="/Admin/Terminal/c_term_detail/id'.'/'. $v['id'] .'"  id="organ_check"><i class="organ-look"></i></a>';
                $bianji = '<a href="/Admin/Terminal/term_edit/id'.'/'.$v['id'] .'" id="organ_item"><i class="organ-editt"></i></a>';

                $result[] = array($check,$k+1,$v['terminal_number'],$v['terminal_model_number'],'',empty($v['factory_date'])?'':substr($v['factory_date'],0,10),$v['status'],$v['ol'],$chakan,$bianji);
            }
            $backData = array('data'=>$result?$result:array());


            exit(json_encode($backData));
        }elseif($do == 'del'){
            $res = M('terminal')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

        $this->title='终端列表';
        $this->display('term_list');
    }

//    终端添加
	public function term_add(){

        $do = I('do');
        if($do == 'save'){
//            判断终端编号是否被使用
            $is_use = M('terminal')->where(array('terminal_number'=>array('eq',I('code'))))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该终端编号已被使用')));
                die;
            }

            $row = array(
                'terminal_number'=>I('code'),
                'type'=>I('type'),
                'terminal_model_number'=>I('xinghao'),
                'qualified_number'=>I('hege'),
                'terminal_company'=>I('zhizao'),
                'factory_date'=>I('chuchang'),
                'record_date'=>I('dengji'),
                'create_company'=>session('userinfo.company_id'),
                'create_time'=>date('Y-m-d H:i:s')
            );

            $id = M('terminal')->add($row);
            if($id){
//                判断并循环添加组建信息
                if(is_array(I('z_name'))){
                    $z_name = explode(',',I('z_name'));
                    $z_count = explode(',',I('z_count'));
                    $z_mark = explode(',',I('z_mark'));

                    foreach($z_name as $k=>$v){
                        $param = array(
                            'tid'=>$id,
                            'name'=>$v,
                            'count'=>$z_count[$k],
                            'mark'=>$z_mark[$k],
                        );
                        M('terminal_assembly')->add($param);
                    }
                }

                exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'保存失败，请重试')));
                die;
            }
        }

//        企业信息
        $this->company = M('Company')
            ->field('id,name')
            ->where(array('is_del'=>array('eq',0)))
            ->select();

        $this->title = "添加终端";
        $this->display();
	}

//    终端修改
    public function term_edit(){

        $id = I('id');
        if(!$id){
            $this->error('请选择要修改的终端');
        }
        $do = I('do');
        if($do == 'save'){
            $is_use = M('terminal')->where(array('terminal_number'=>array('eq',I('code')),'id'=>array('neq',I('id'))))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该终端编号已被使用')));
                die;
            }

            $row = array(
                'terminal_number'=>I('code'),
                'type'=>I('type'),
                'terminal_model_number'=>I('xinghao'),
                'qualified_number'=>I('hege'),
                'terminal_company'=>I('zhizao'),
                'factory_date'=>I('chuchang'),
                'record_date'=>I('dengji'),
                'create_company'=>session('userinfo.company_id'),
                'status'=>0
            );

            $id = M('terminal')->where(array('id'=>array('eq',I('id'))))->save($row);
            if($id!==false){
                if(is_array(I('z_name'))) {
                    $z_id = explode(',', I('z_id'));
                    $z_name = explode(',', I('z_name'));
                    $z_count = explode(',', I('z_count'));
                    $z_mark = explode(',', I('z_mark'));

                    foreach ($z_name as $k => $v) {

                        if ($z_id[$k] == '') {
                            $param = array(
                                'tid' => I('id'),
                                'name' => $v,
                                'count' => $z_count[$k],
                                'mark' => $z_mark[$k],
                            );
                            M('terminal_assembly')->add($param);
                        } else {
                            $param = array(
                                'name' => $v,
                                'count' => $z_count[$k],
                                'mark' => $z_mark[$k],
                            );
                            M('terminal_assembly')->where(array('id' => $z_id[$k]))->save($param);
                        }

                    }
                }
                exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'保存失败，请重试')));
                die;
            }
        }elseif($do=='del_ass'){
//            删除组建信息
            $re = M('terminal_assembly')->where(array('id'=>array('eq',I('id'))))->delete();

            if($re){
                exit(json_encode(array('status'=>1,'msg'=>'已删除')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'删除失败，请重试')));
                die;
            }
        }

        $this->info = D('Terminal')->getOne($id);

        $this->company = M('Company')
            ->field('id,name')
            ->where(array('is_del'=>array('eq',0)))
            ->select();

        $this->title = "修改终端";
        $this->display('term_add');
    }

//    终端详情
	public function term_detail(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的终端');
        }

        $this->info = D('Terminal')->getDetail($id);
        $this->title = '终端详情';
        $this->display();
	}

//  终端审核
    public function c_term_detail(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的终端');
        }
        $do = I('do');
        if($do == 'check'){
//            审核操作
            $res = M('terminal')->where(array('id'=>array('eq',I('id'))))->save(array('status'=>I('data')));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

        $this->info = D('Terminal')->getDetail($id);
        $this->title = '终端详情';
        $this->display('term_detail');
    }


}