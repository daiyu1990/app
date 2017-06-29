<?php
/**
 * @Author: Sincez
 * @Date:   2017-06-20 09:37:59
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-06-20 09:44:46
 */
namespace Api\Controller;
use Common\Controller\ApiController;

class MissionController extends ApiController
{


    /**
     * 任务提醒列表接口 POST方式
     * @return json 状态值描述，返回任务列表
     */
    public function mission_list(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $c_id = session('memberinfo.company_id');
//        $c_id = 15;

        $count = M('maintain')
                ->where(array('work_company'=>array('eq',$c_id),'work_user'=>array('eq',0),'del'=>array('eq',0)))
                ->count();

        $p = getpage($count,15);

        $data = M('maintain')
            ->field('id,code,name,create_time,type')
            ->where(array('work_company'=>array('eq',$c_id),'work_user'=>array('eq',0),'del'=>array('eq',0)))
            ->limit($p->firstRow, $p->listRows)
            ->select();

        if($data){
            $this->ajaxReturn(array('status'=>1,'msg'=>'获取任务提醒列表成功','data'=>$data));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取任务提醒列表失败',));
        }

    }


    /**
     * 任务详情接口 POST方式
     * @return json 状态值描述，返回新增工程状态
     */
    public function mission_detail(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $id = I('id');
        $info = M('maintain')
            ->alias('a')
            ->field('a.id,a.code,a.address,a.wenti,a.contact,a.mobile,a.level,a.status,a.start,a.end,
                    b.facility_number,b.facility_type,b.facility_model_number')
            ->join('left join box_facility_msg b on a.f_id=b.id')
            ->where(array('a.id'=>array('eq',$id)))
            ->find();

        if($info){
            $level = array(
                1=>'一般',
                2=>'紧急'
            );
            $status = array(
                0=>'待受理',
                1=>'已受理',
                2=>'待审核',
                3=>'已审核',
            );
            $type = array(
                1=>'塔式起重机',
                2=>'施工升降机',
            );

            $info['level'] = $level[$info['level']];
            $info['status'] = $status[$info['status']];
            $info['facility_type'] = $type[$info['facility_type']];

            $this->ajaxReturn(array('status'=>1,'msg'=>'获取任务详情成功','data'=>$info));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取任务详情失败',));
        }

    }

    /**
     * 受理任务接口 POST方式
     * @return json 状态值描述，返回任务受理状态
     */
    public function mission_accept(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $id = I('id');
        $uid = session('memberinfo.uid');
        $info = M('maintain')->find($id);

        if(!$info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'任务信息有误，受理失败'));
        }

        if($info['work_user']!=0){
            $this->ajaxReturn(array('status'=>0,'msg'=>'该任务已被其他人员受理'));
        }

        $res = M('maintain')->where(array('id'=>array('eq',$id)))->save(array('work_user'=>$uid,'status'=>1));
        if($res){
            $this->ajaxReturn(array('status'=>0,'msg'=>'任务受理失败'));
        }else{
            $this->ajaxReturn(array('status'=>1,'msg'=>'任务受理成功'));
        }
    }

    /**
     * 我的任务列表接口 POST方式
     * @return json 状态值描述，返回任务列表
     */
    public function my_mission(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $start = I('date');
        $date = strtotime($start)+86400;
        $end = date('Y-m-d H:i:s', $date);

        $c_id = session('memberinfo.company_id');
        $uid = session('memberinfo.uid');

        $data = M('maintain')
            ->field('id,code,name,start,mission_type')
            ->where(array(
                'work_company'=>array('eq',$c_id),
                'work_user'=>array('eq',$uid),
                'start'=>array(array('egt',$start),array('lt',$end)),
                'del'=>array('eq',0)
            ))
            ->select();
        $data1 = M('mission')
            ->field('id,code,name,start,mission_type')
            ->where(array(
                'create_uid'=>array('eq',$uid),
                'start'=>array(array('egt',$start),array('lt',$end)),
                'del'=>array('eq',0)
            ))
            ->select();

        foreach($data1 as $k=>$v){
            $data[] = $v;
        }


        if($data){
            $this->ajaxReturn(array('status'=>1,'msg'=>'获取我的任务列表成功','data'=>$data));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取我的任务列表失败',));
        }

    }


    /**
     * 添加任务接口 POST方式
     * @return json 状态值描述，返回任务列表
     */
    public function mission_add(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $row = array(
            'code' => time().rand(1000,9999),
            'name' => I('name'),
            'type' => I('type'),
            'level' => I('level'),
            'wenti' => I('wenti'),
            'start' => I('start'),
            'end' => I('end'),
            'create_uid' => session('memberinfo.uid')
        );

        $res = M('mission')->add($row);
        if($res){
            $this->ajaxReturn(array('status'=>1,'msg'=>'添加任务成功'));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'添加任务失败',));
        }

    }

    /**
     * 添加报修接口 POST方式
     * @return json 状态值描述，返回任务列表
     */
    public function maintain_add(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $f_id = M('facility_msg')->where(array('facility_number'=>array('eq',I('fac_code')),'status'=>array('eq',1),'del'=>array('eq',0)))->find();
        if(!$f_id){
            $this->ajaxReturn(array('status'=>0,'msg'=>'设备编号有误，请填写正确的设备编号',));
        }

        $c_id = M('company')->where(array('name'=>array('eq',I('company_name')),'status'=>array('eq',3),'is_del'=>array('eq',0)))->find();
        if(!$c_id){
            $this->ajaxReturn(array('status'=>0,'msg'=>'任务指派单位有误，请填写准确的单位名称',));
        }

        $row = array(
            'code' => time().rand(1000,9999),
            'name' => I('name'),
            'work_company' => $c_id['id'],
            'address' => I('address'),
            'f_id' => $f_id['id'],
            'contact' => I('contact'),
            'mobile' => I('mobile'),
            'wenti' => I('wenti'),
            'start' => I('start'),
            'end' => I('end'),
            'create_company' => session('memberinfo.company_id'),
            'create_time'=>date('Y-m-d H:i:s')
        );

        $res = M('maintain')->add($row);
        if($res){
            exit(json_encode(array('status'=>1,'msg'=>'添加报修成功')));
            die;
        }else{
            exit(json_encode(array('status'=>0,'msg'=>'添加报修失败，请重试')));
            die;
        }

    }

}