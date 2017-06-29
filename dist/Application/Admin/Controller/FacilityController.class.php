<?php
/**
 * Created by coder meng.
 * User: 设备管理
 * Date: 2017/3/15 14:55
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class FacilityController extends AdminController
{


//  设备列表
    public function fac_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');

            $info = D('Facilitymsg')->getData($row);


            foreach($info as $k=>$v){
                $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="fl check-item"><span class="fl"></span></label>';
                $chakan = '<a href="/Admin/Facility/fac_detail/id'.'/'. $v['id'] .'"  id="organ_check"><i class="organ-look"></i></a>';
                $bianji = '<a href="/Admin/Facility/fac_edit/id'.'/'.$v['id'] .'" id="organ_item"><i class="organ-editt"></i></a>';
                $zhuangtai = '<a href="" id="organ_check"><i class="equip_status"></i></a>';

                $result[] = array($check,$k+1,$v['facility_number'],$v['equity_number'],$v['facility_type'],$v['facility_model_number'],$v['status'],$v['is_record'],$chakan,$bianji,$zhuangtai);
            }
            $backData = array('data'=>$result?$result:array());


            exit(json_encode($backData));

        }elseif($do == 'del'){
//            删除设备操作
            $res = M('facility_msg')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

//        获取省份信息
        $sheng = D('Region')->get_sheng();

        $this->assign('sheng',$sheng);
        $this->title='设备列表';
        $this->display();
    }


//    设备审核列表
    public function c_fac_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');

            $info = D('Facilitymsg')->getData($row);


            foreach($info as $k=>$v){
                $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="fl check-item"><span class="fl"></span></label>';
                $chakan = '<a href="/Admin/Facility/c_fac_detail/id'.'/'. $v['id'] .'"  id="organ_check"><i class="organ-look"></i></a>';
                $bianji = '<a href="/Admin/Facility/fac_edit/id'.'/'.$v['id'] .'" id="organ_item"><i class="organ-editt"></i></a>';
                $zhuangtai = '<a href="" id="organ_check"><i class="equip_status"></i></a>';

                $result[] = array($check,$k+1,$v['facility_number'],$v['equity_number'],$v['facility_type'],$v['facility_model_number'],$v['status'],$v['is_record'],$chakan,$bianji,$zhuangtai);
            }
            $backData = array('data'=>$result?$result:array());


            exit(json_encode($backData));
        }elseif($do == 'del'){
            $res = M('facility_msg')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }




        $sheng = D('Region')->get_sheng();

        $this->assign('sheng',$sheng);
        $this->title='设备列表';
        $this->display('fac_list');
    }

//    设备添加
    public function fac_add(){

        $do = I('do');
        if($do == 'save'){
//            判断设备编号是否被使用
            $is_use = M('facility_msg')->where(array('facility_number'=>array('eq',I('code'))))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该设备编号已被使用')));
                die;
            }
            $row = array(
                'facility_number'=>I('code'),
                'facility_type'=>I('type'),
                'facility_model_number'=>I('xinghao'),
                'manufacturing_licence_number'=>I('xuke'),
                'make_company'=>I('zhizao'),
                'factory_date'=>I('chuchang'),
                'record_date'=>I('dengji'),
                'create_company'=>session('userinfo.company_id'),
                'create_time'=>date('Y-m-d H:i:s')
            );

            $id = M('facility_msg')->add($row);
            if($id){

//                判断并循环添加参数
                if(I('c_type')!=''){
                    $c_type = explode(',',I('c_type'));
                    $c_name = explode(',',I('c_name'));
                    $c_val = explode(',',I('c_val'));
                    $c_mark = explode(',',I('c_mark'));

                    foreach($c_type as $k=>$v){
                        $param = array(
                            'fid'=>$id,
                            'type'=>$v,
                            'name'=>$c_name[$k],
                            'value'=>$c_val[$k],
                            'mark'=>$c_mark[$k],
                        );
                        M('facility_parameter')->add($param);
                    }
                }


                exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'保存失败，请重试')));
                die;
            }
        }
//        获取公司信息
        $this->company = M('Company')
             ->field('id,name')
             ->where(array('is_del'=>array('eq',0)))
             ->select();

        $this->title = '添加设备';
        $this->display();
    }


//    设备修改
    public function fac_edit(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要修改的设备');
        }

        $do = I('do');
        if($do == 'save'){
            $is_use = M('facility_msg')->where(array('facility_number'=>array('eq',I('code')),'id'=>array('neq',I('id'))))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该设备编号已被使用')));
                die;
            }
            $row = array(
                'facility_number'=>I('code'),
                'facility_type'=>I('type'),
                'facility_model_number'=>I('xinghao'),
                'manufacturing_licence_number'=>I('xuke'),
                'make_company'=>I('zhizao'),
                'factory_date'=>I('chuchang'),
                'record_date'=>I('dengji'),
                'status'=>0,
            );

            $res = M('facility_msg')->where(array('id'=>array('eq',I('id'))))->save($row);
            if($res!==false){

                if(I('c_type')!=''){
                    $c_id = explode(',',I('c_id'));
                    $c_type = explode(',',I('c_type'));
                    $c_name = explode(',',I('c_name'));
                    $c_val = explode(',',I('c_val'));
                    $c_mark = explode(',',I('c_mark'));

                    foreach($c_type as $k=>$v){

                        if($c_id[$k]!=''){
                            $param = array(
                                'type'=>$v,
                                'name'=>$c_name[$k],
                                'value'=>$c_val[$k],
                                'mark'=>$c_mark[$k],
                            );
                            M('facility_parameter')->where(array('id'=>array('eq',$c_id[$k])))->save($param);
                        }else{
                            $param = array(
                                'fid'=>I('id'),
                                'type'=>$v,
                                'name'=>$c_name[$k],
                                'value'=>$c_val[$k],
                                'mark'=>$c_mark[$k],
                            );
                            M('facility_parameter')->add($param);
                        }

                    }
                }


                exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'保存失败，请重试')));
                die;
            }
        }elseif($do=='del_param'){
//            删除参数操作
            $re = M('facility_parameter')->where(array('id'=>array('eq',I('id'))))->delete();

            if($re){
                exit(json_encode(array('status'=>1,'msg'=>'已删除')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'删除失败，请重试')));
                die;
            }
        }
        $this->company = M('Company')
            ->field('id,name')
            ->where(array('is_del'=>array('eq',0)))
            ->select();

        $this->info = D('Facilitymsg')->getOne($id);

        $this->title = '修改设备';
        $this->display('fac_add');
    }

//  设备详情
    public function fac_detail(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的设备');
        }

        $this->info = D('Facilitymsg')->getDetail($id);
        $this->title = '设备详情';
        $this->display();
    }

//    设备审核
    public function c_fac_detail(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的设备');
        }
        $do = I('do');
        if($do == 'check'){
//            审核操作
            $data = I('data');
            $id = I('id');
            $res = M('facility_msg')->where(array('id'=>array('eq',$id)))->save(array('status'=>$data));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

        $this->info = D('Facilitymsg')->getDetail($id);
        $this->title = '设备详情';
        $this->display('fac_detail');
    }


}