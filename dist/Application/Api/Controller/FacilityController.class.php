<?php
/**
 * @Author: Sincez
 * @Date:   2017-06-20 09:37:59
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-06-20 09:44:46
 */
namespace Api\Controller;
use Common\Controller\ApiController;

class FacilityController extends ApiController
{


    /**
     * 设备列表接口 POST方式
     * @return json 状态值描述，返回设备信息
     */
    public function fac_list(){

        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $c_id = session('memberinfo.company_id');

        $count = M('facility_msg')
                ->field('id,facility_number ,equity_number ')
                ->where(array('create_company'=>array('eq',$c_id),'del'=>array('eq',0)))
                ->count();

        $p = getpage($count,15);

        $data = M('facility_msg')
                ->field('id,facility_number ,equity_number ')
                ->where(array('create_company'=>array('eq',$c_id),'del'=>array('eq',0)))
                ->limit($p->firstRow, $p->listRows)
                ->select();



        foreach($data as $k=>$v){

            if(strlen($v['equity_number'])==0){
                $data[$k]['equity_number'] = '--';
            }
            $ol = M('use')
                    ->alias('a')
                    ->join('left join box_crane_msgid b on a.t_id=b.did')
                    ->where(array('a.f_id'=>array('eq',$v['id'])))
                    ->find();
            if($ol){
                $data[$k]['is_on'] = '在线';
            }else{
                $data[$k]['is_on'] = '离线';
            }
        }

        if($data){
            $this->ajaxReturn(array('status'=>1,'msg'=>'获取设备信息成功','data'=>$data));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取设备信息失败',));
        }

    }


    /**
     * 新增设备接口 POST方式
     * @return json 状态值描述，返回新增设备状态
     */
    public function fac_add(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }
        $row = array(
          'facility_number' =>I('code'),
          'facility_type' =>I('type'),
          'facility_model_number' =>I('xinghao'),
          'manufacturing_licence_number' =>I('xuke'),
          'create_company'=>session('memberinfo.company_id')
        );

        $is_use = M('facility_msg')->where(array('facility_number'=>array('eq',$row['facility_number'])))->find();
        if($is_use){
            $this->ajaxReturn(array('status'=>0,'msg'=>'该设备编号已被使用'));
        }

        $res = M('facility_msg')->add($row);
        if($res){
            $this->ajaxReturn(array('status'=>1,'msg'=>'新增设备成功'));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'新增设备失败',));
        }
    }


    /**
     * 设备详情接口 POST方式
     * @return json 状态值描述，返回设备详情
     */
    public function fac_detail(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }
        $id = I('id');


        $res = M('facility_msg')
                ->alias('a')
                ->field('a.id,a.facility_number,a.facility_model_number,a.facility_type,a.manufacturing_licence_number,a.factory_date,a.record_date,
                        b.name')
                ->join('left join box_company b on a.make_company=b.id')
                ->where(array('a.id'=>array('eq',$id)))
                ->find();


        if($res){
            $type = array(
                1=>'塔式起重机',
                2=>'施工升降机',
            );

            $res['facility_type'] = $type[$res['facility_type']];
            $this->ajaxReturn(array('status'=>1,'msg'=>'获取设备详情成功','data'=>$res));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取设备详情失败',));
        }
    }




}