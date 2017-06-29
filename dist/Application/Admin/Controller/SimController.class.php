<?php
/**
 * Created by coder meng.
 * User: 设备管理
 * Date: 2017/3/15 14:55
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class SimController extends AdminController
{

    public function sim_list(){

        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');

            $info = D('Sim')->getData($row);


            foreach($info as $k=>$v){
                $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="fl check-item"><span class="fl"></span></label>';
                $chakan = '<a href="/Admin/Sim/sim_detail/id'.'/'. $v['id'] .'"  id="organ_check"><i class="organ-look"></i></a>';
                $bianji = '<a href="/Admin/Sim/sim_edit/id'.'/'.$v['id'] .'" id="organ_item"><i class="organ-editt"></i></a>';

                $result[] = array($check,$k+1,$v['code'],$v['yunying'],$v['xinhao'],$v['pay_date'],$v['expire_date'],$v['date'],$v['daoqi'],$v['status'],$chakan,$bianji);
            }
            $backData = array('data'=>$result?$result:array());


            exit(json_encode($backData));
        }elseif($do == 'del'){
            $res = M('sim')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

        $this->internet = M('code')->where(array('code'=>array('eq','Network_operator')))->select();

        $this->title = 'SIM卡列表';
    	$this->display();
    }

    public function c_sim_list(){

        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');

            $info = D('Sim')->getData($row);


            foreach($info as $k=>$v){
                $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="fl check-item"><span class="fl"></span></label>';
                $chakan = '<a href="/Admin/Sim/c_sim_detail/id'.'/'. $v['id'] .'"  id="organ_check"><i class="organ-look"></i></a>';
                $bianji = '<a href="/Admin/Sim/sim_edit/id'.'/'.$v['id'] .'" id="organ_item"><i class="organ-editt"></i></a>';

                $result[] = array($check,$k+1,$v['code'],$v['yunying'],$v['xinhao'],$v['pay_date'],$v['expire_date'],$v['date'],$v['daoqi'],$v['status'],$chakan,$bianji);
            }
            $backData = array('data'=>$result?$result:array());


            exit(json_encode($backData));
        }elseif($do == 'del'){
            $res = M('sim')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

        $this->internet = M('code')->where(array('code'=>array('eq','Network_operator')))->select();

        $this->title = 'SIM卡列表';
        $this->display('sim_list');
    }
    
    public function sim_add(){

        $do = I('do');
        if($do == 'save'){
            $is_use = M('sim')->where(array('code'=>array('eq',I('code'))))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该sim卡号已被添加')));
                die;
            }

            $start = strtotime(I('start'));
            $end = $start+ 30*86400*I('date');
            $end = date('Y-m-d',$end);

            $row = array(
                'ter_id'=>I('ter_id'),
                'code'=>I('code'),
                'yunying'=>I('yunying'),
                'pay_date'=>I('start'),
                'expire_date'=>$end,
                'date'=>I('date'),
                'create_time'=>date('Y-m-d H:i:s'),
                'create_company'=>session('userinfo.company_id')
            );

            $id = M('sim')->add($row);
            if($id){

                exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'保存失败，请重试')));
                die;
            }
        }

        $this->internet = M('code')->where(array('code'=>array('eq','Network_operator')))->select();
        $this->terminal = M('terminal')->where(array('del'=>array('eq',0),'status'=>array('eq',1)))->select();
        $this->title = '添加SIM卡';
    	$this->display();
    }

    public function sim_edit(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要修改的sim卡');
        }

        $do = I('do');
        if($do == 'save'){

            $is_use = M('sim')->where(array('code'=>array('eq',I('code')),'id'=>array('neq',I('id'))))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该sim卡号已被添加')));
                die;
            }
            $start = strtotime(I('start'));
            $end = $start+ 30*86400*I('date');
            $end = date('Y-m-d',$end);

            $row = array(
                'ter_id'=>I('ter_id'),
                'code'=>I('code'),
                'yunying'=>I('yunying'),
                'pay_date'=>I('start'),
                'expire_date'=>$end,
                'date'=>I('date'),
                'status'=>0
            );


            $id = M('sim')->where(array('id'=>array('eq',I('id'))))->save($row);
            if($id!==false){

                exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'保存失败，请重试')));
                die;
            }
        }

        $this->info = D('Sim')->getOne($id);
        $this->internet = M('code')->where(array('code'=>array('eq','Network_operator')))->select();
        $this->terminal = M('terminal')->where(array('del'=>array('eq',0),'status'=>array('eq',1)))->select();

        $this->title = '修改SIM卡';
        $this->display('sim_add');
    }


	public function sim_detail(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的SIM卡');
        }

        $this->info = D('Sim')->getDetail($id);

        $this->title = 'SIM卡详情';
        $this->display();
    }

    public function c_sim_detail(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的SIM卡');
        }
        $do = I('do');
        if($do == 'check'){
            $res = M('sim')->where(array('id'=>array('eq',I('id'))))->save(array('status'=>I('data')));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }


        $this->info = D('Sim')->getDetail($id);

        $this->title = 'SIM卡详情';
        $this->display('sim_detail');
    }


}