<?php
/**
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class EngineeringController extends AdminController {







//  添加工程
    public function engin_add(){

        $do = I('do');
        if($do == 'get_shi'){
//          根据省份获取城市信息
            $shi = D('Region')->get_shi(I('sheng'));
            if($shi){
                exit(json_encode(array('status'=>1,'data'=>$shi)));
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'获取城市信息失败')));
            }
        }elseif($do == 'save'){
//          判断工程编号是否重复
            $is_use = M('engineering')->where(array('code'=>array('eq',I('code')),'is_del'=>array('eq',0)))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该工程编号已被使用')));
                die;
            }

            $row = I('post.');
            unset($row['__hash__']);
            unset($row['do']);
            $row['company_id']=session()['userinfo']['company_id'];
            $row['create_id']=session()['userinfo']['uid'];
            $row['create_time']=date('Y-m-d H:i:s');
            $row['status']=5;


            if(strtotime($row['end_time'])<strtotime($row['start_time'])){
                exit(json_encode(array('status'=>0,'msg'=>'计划竣工时间不能早于计划开工时间')));
                die;
            }

            $res = M('Engineering')->add($row);
            if($res){
                exit(json_encode(array('status'=>1,'msg'=>'工程添加成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'工程添加失败')));
                die;
            }


        }

//      企业列表
        $company = M('Company')
            ->field('id,name')
            ->where(array('is_del'=>array('eq',0)))
            ->select();

        $this->assign('company',$company);

//        省份信息
        $sheng = D('Region')->get_sheng();

        $this->assign('sheng',$sheng);
        $this->title='新增工程';
        $this->display('engin_edit');
    }


//    工程列表
    public function engin_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');

            $info = D('Engineering')->getData($row);


            foreach($info as $k=>$v){
                $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="fl check-item"><span class="fl">'. ($k+1) .'</span></label>';
                $chakan = '<a href="/Admin/Engineering/engin_detail/id'.'/'. $v['id'] .'" id="organ_check"><i class="organ-look"></i></a>';
                $bianji = '<a href="/Admin/Engineering/engin_edit/id'.'/'.$v['id'] .'" id="organ_item"><i class="organ-editt"></i></a>';


                $result[] = array($check,$v['code'],$v['name'],$v['diqu'],$v['jianshe'],$v['chengjian'],$v['taji'],$v['shengjiangji'],$v['status'],$chakan,$bianji);
            }
            $backData = array('data'=>$result?$result:array());


            exit(json_encode($backData));
        }elseif($do == 'del'){

//          删除工程操作
            $res = M('engineering')->where(array('id'=>array('IN',I('id'))))->save(array('is_del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }


//        $getdata = D('Codetype')->getData(C('ENGIN_STATUS'));
//        $this->type = D('Code')->getData($getdata);
//        $this->assign('engin_status',$this->type);
        $sheng = D('Region')->get_sheng();

        $this->assign('sheng',$sheng);

        $this->title = '工程列表';
        $this->display();
    }


//    工程审核列表
    public function c_engin_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');

            $info = D('Engineering')->getData($row);


            foreach($info as $k=>$v){
                $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="fl check-item"><span class="fl">'. ($k+1) .'</span></label>';
                $chakan = '<a href="/Admin/Engineering/c_engin_detail/id'.'/'. $v['id'] .'"  id="organ_check"><i class="organ-look"></i></a>';
                $bianji = '<a href="/Admin/Engineering/engin_edit/id'.'/'.$v['id'] .'" id="organ_item"><i class="organ-editt"></i></a>';


                $result[] = array($check,$v['code'],$v['name'],$v['diqu'],$v['jianshe'],$v['chengjian'],$v['taji'],$v['shengjiangji'],$v['status'],$chakan,$bianji);
            }
            $backData = array('data'=>$result?$result:array());


            exit(json_encode($backData));
        }elseif($do == 'del'){
            $res = M('engineering')->where(array('id'=>array('IN',I('id'))))->save(array('is_del'=>1));
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

        $this->title = '工程列表';
        $this->display('engin_list');
    }

//    工程修改
    public function engin_edit(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要编辑的工程');
            die;
        }

        $do = I('do');
        if($do == 'get_shi'){
            $shi = D('Region')->get_shi(I('sheng'));
            if($shi){
                exit(json_encode(array('status'=>1,'data'=>$shi)));
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'获取城市信息失败')));
            }
        }elseif($do == 'save'){
            $is_use = M('engineering')->where(array('code'=>array('eq',I('code')),'is_del'=>array('eq',0),'id'=>array('neq',I('id'))))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该工程编号已被使用')));
                die;
            }
            $row = I('post.');
            $row['status'] = 3;
            $engin_id = $row['id'];
            unset($row['__hash__']);
            unset($row['do']);
            unset($row['id']);


            if(strtotime($row['end_time'])<strtotime($row['start_time'])){
                exit(json_encode(array('status'=>0,'msg'=>'计划竣工时间不能早于计划开工时间')));
                die;
            }

            $res = M('Engineering')->where(array('id'=>array('eq',$engin_id)))->save($row);
            if($res){
                exit(json_encode(array('status'=>1,'msg'=>'工程修改成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'工程修改失败')));
                die;
            }


        }

        $company = M('Company')
            ->field('id,name')
            ->where(array('is_del'=>array('eq',0)))
            ->select();

        $this->assign('company',$company);

        $info = D('Engineering')->getOne($id);
        $this->assign('info',$info);

        $sheng = D('Region')->get_sheng();
        $shi = D('Region')->where(array('parent_id'=>array('eq',$info['sheng_id'])))->select();
        $this->assign('sheng',$sheng);
        $this->assign('shi',$shi);


        $this->display();
    }


//    工程详情
    public function engin_detail(){

        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的工程');
            die;
        }

        $info = D('Engineering')->getDetail($id);

        $this->assign('info',$info);
        $this->title='工程详情';
        $this->display();
    }

//    工程审核
    public function c_engin_detail(){

        $id = I('id');

        if(!$id){
            $this->error('请选择要查看的工程');
            die;
        }
        $do = I('do');
        if($do == 'check'){
//            审核操作
            $data = I('data');
            $id = I('id');
            $res = M('engineering')->where(array('id'=>array('eq',$id)))->save(array('status'=>$data));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

        M('engineering')->where(array('id'=>array('eq',$id)))->save(array('status'=>1));
        $info = D('Engineering')->getDetail($id);

        $this->assign('info',$info);
        $this->title='工程详情';
        $this->display('engin_detail');
    }



}

