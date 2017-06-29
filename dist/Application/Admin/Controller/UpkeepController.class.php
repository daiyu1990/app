<?php
/**
 * Created by coder meng.
 * User: 设备管理
 * Date: 2017/3/15 14:55
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class UpkeepController extends AdminController
{
    //设备列表
    public function index(){
        $this->title = '维保记录';
        $do = I('do');
        if($do == 'listTableData'){
            //判断是否为平台 否则只能看到本单位下面的记录
            $id = session('userinfo.uid');
            $where['type'] = 2;
            if($id != 1){
                $where['company_id'] = session('userinfo.company_id');
            }
            $codes = D('task')->where($where)->order('starttime desc')->select();
            foreach($codes as $v){
                //查询设备编号类型
                $res['id'] = $v['facility_id'];
                $res['field'] = 'facility_type,facility_number';
                $info = D('Facilitymsg')->getData($res);
                //查询设备类型
               /* $da['id'] = $info['facility_type'];
                $resda = D('Code')->getData($da);*/
                //查询公司
                if($v['company_id'] == 0){
                    $company['name'] = '平台';
                }else{
                    $row['id'] = $v['company_id'];
                    $company = D('Company')->getMsg($row);
                }
                //查询任务类型
                $task['id'] = $v['task_typeid'];
                $resa = D('Code')->getData($task);
                //审核状态
                if($v['level'] == 1){
                    $str = '低';
                }elseif($v['level'] == 2){
                    $str = '中';
                }elseif($v['level'] == 3){
                    $str = '高';
                }else{
                    $str = '紧急';
                }
                if($v['status'] == 0){
                    $status = '待处理';
                }elseif($v['status'] == 1){
                    $status = '进行中';
                }elseif($v['status'] == 2){
                    $status = '已完成';
                }
                $op = create_Url('Admin/Upkeep/edit','编辑',array('id'=>$v['id']),'class="edit m-r-5" ');
                $op .= '<br/>'.create_Url('Admin/Upkeep/del','删除',array('id'=>$v['id']),'class="del m-r-5"');
                $result[] = array($v['id'],$v['task_number'],$resa['name'],$str,$v['task_name'],$info['facility_number'],$company['name'],$v['linkphone'],date('Y-m-d H:i:s',$v['starttime']),date('Y-m-d H:i:s',$v['endtime']),$status,$op);
            }
            $backData = array('data'=>$result?$result:array());
            exit(json_encode($backData));
        }
        $this->display();
    }
    //添加保养计划
    public function add(){
        $this->title = '保养计划';
        $do = I('do');
        if($do == 'save'){
            $data = I('post.');
            if($data){
                $data['starttime'] = strtotime($data['starttime']);
                $data['endtime'] = strtotime($data['endtime']);
                $data['type'] = 2;
                $data['task_number'] = date('Ymd',time()).rand(1000,9999);
                if(!$data['company_id']){
                    unset($data['company_id']);
                }
            }
            if(D('Maintain')->insertData($data)){
                $this->redirect('/Admin/Upkeep/index');
            }else{
                $this->error('添加失败！');
            }
        }
        //设备编号
        $row['field'] = 'mid,facility_number';
        $this->data = D('Facilitymsg')->getData($row);
        //设备类型
        $getdata = D('Codetype')->getData(C('DEVSE_TYPE'));
        $this->type = D('Code')->getData($getdata);
        //任务类型
        $taskdata = D('Codetype')->getData(C('TASK_TYPE'));
        $this->tasktype = D('Code')->getData($taskdata);
        //任务指派
        $this->linkman = D('Operator')->getMsg();
        $this->display();
    }
    //查询设备类型
    public function ajaxMsg(){
        $row['id'] = I('id');
        $row['field'] = 'facility_type';
        $data = D('Facilitymsg')->getData($row);
        $res['id'] = $data['facility_type'];
        $type = D('Code')->getData($res);
        $msg = D('Inform')->getMsg($row['id']);
        $type['address'] = $msg['address'];
        $type['company'] = $msg['name'];
        $this->ajaxReturn($type);
    }
    //编辑设备
    public function edit(){
        $this->title = '编辑保养计划';
        $do = I('do');
        $id = I('get.id');
        if(empty($do)){
            $info = D('Maintain')->where(array('id'=>$id))->find();
            if(!$info){
                $this->error('编辑记录不存在！');
            }
            //查询设备编号类型
            $res['id'] = $info['facility_id'];
            $res['field'] = 'facility_type,facility_number';
            $msg = D('Facilitymsg')->getData($res);
            //查询设备类型
            $da['id'] = $msg['facility_type'];
            $resda = D('Code')->getData($da);
            $dat['id'] = $info['appoint_id'];
            $this->companymsg = D('Company')->getMsg($dat);
            $this->typename = $resda;
            $this->info = $info;
        } elseif ($do == 'save'){
            $data = I('post.');
            if($data){
                $data['starttime'] = strtotime($data['starttime']);
                $data['endtime'] = strtotime($data['endtime']);
            }
            if(D('Maintain')->insertData($data)){
                $this->redirect('/Admin/Upkeep/index');
            }else{
                $this->error('修改失败！');
            }
        }
        //设备编号
        $row['field'] = 'mid,facility_number';
        $this->data = D('Facilitymsg')->getData($row);
        //设备类型
        $getdata = D('Codetype')->getData(C('DEVSE_TYPE'));
        $this->type = D('Code')->getData($getdata);
        //任务类型
        $taskdata = D('Codetype')->getData(C('TASK_TYPE'));
        $this->tasktype = D('Code')->getData($taskdata);
        //任务指派
        $this->linkman = D('Operator')->getData();
        $this->display('add');
    }
    //删除设备
    public function del(){
        $id = I('id');
        if(!$id){
            exit(json_encode(array('status'=>0,'msg'=>'请选择要删除的记录！')));
        }
        $res = D('Maintain')->where(array('id'=>$id))->find();
        if(!$res){
            exit(json_encode(array('status'=>0,'msg'=>'删除的记录不存在！')));
        }else{
            D('Maintain')->where(array('id'=>$id))->delete();
        }
        $content = '删除维保记录';
        action_log($content);
        exit(json_encode(array('status'=>1)));
    }
    //审核
    public function check(){
        $id = I('get.id');
        $this->info = D('File')->where(array('id'=>$id))->field('id,status,cause')->find();
        $do = I('do');
        if($do == 'save'){
            $info = D('File')->create();
            if($info){
                D('File')->where(array('id'=>$_POST['fid']))->save($info);
            }
            $content = '审核技术资料';
            action_log($content);
            exit(json_encode(array('status'=>1)));
        }
        $this->display();
    }

}