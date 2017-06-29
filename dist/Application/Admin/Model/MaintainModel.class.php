<?php
/**
 * Created by coder meng.
 * User: coder meng
 * Date: 2017/3/15 16:08
 */
namespace Admin\Model;
use Think\Model;
class MaintainModel extends Model{
    protected $tableName='maintain';
//    protected $col = 'facility_id,remark,task_number,task_name,task_typeid,company_id,linkman,linkphone,status,level,appoint_id,address,starttime,type,endtime,duplicate_tasks,remind_date';


    public function getOne($id){
        $data = $this->alias('a')
                     ->field('a.*,b.facility_type,b.facility_number')
                     ->join('left join box_facility_msg b on a.f_id=b.id')
                     ->where(array('a.id'=>array('eq',$id)))
                     ->find();

        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机'
        );

        $data['facility_type'] = $type[$data['facility_type']];

        return $data;
    }

    public function getData($row){
        $map = array();

        if($row['type']!=''){
            $map['a.type'] = array('eq',$row['type']);
        }

        if($row['level']!=''){
            $map['a.level'] = array('eq',$row['level']);
        }

        if($row['status']!=''){
            $map['a.status'] = array('eq',$row['status']);
        }

        if($row['code']!=''){
            $map['a.code'] = array('eq',$row['code']);
        }

        if($row['fac_code']!=''){
            $map['b.facility_number'] = array('eq',$row['fac_code']);
        }

        if($row['contact']!=''){
            $map['a.contact'] = array('eq',$row['contact']);
        }

        if($row['mobile']!=''){
            $map['a.mobile'] = array('eq',$row['mobile']);
        }

        if(session('userinfo.uid')!=1){
            $map['a.create_company']=array('eq',session('userinfo.company_id'));
        }



        $map['a.del'] = array('eq',0);

        $data = $this->alias('a')
                     ->field('a.*,b.facility_number')
                     ->join('left join box_facility_msg b on a.f_id=b.id')
                     ->where($map)
                     ->select();

//        dump($this->getlastsql());
//        dump($data);die;


        $type = array(
            1=>'设备报修',
            2=>'设备保养',
            3=>'设备巡检',
            4=>'设备咨询'
        );

        $level = array(
            1=>'低',
            2=>'中',
            3=>'高',
            4=>'紧急',
        );

        $status = array(
            0=>'待受理',
            1=>'已受理',
            2=>'待审核',
            3=>'已审核'
        );

        foreach($data as $k=>$v){
            $data[$k]['type'] = $type[$v['type']];
            $data[$k]['level'] = $level[$v['level']];
            $data[$k]['status'] = $status[$v['status']];
        }

        return $data;
    }


    public function getDetail($id){
        $data = $this->alias('a')
            ->field('a.*,b.facility_type,b.facility_number,c.beian_code,d.name as company_name')
            ->join('left join box_facility_msg b on a.f_id=b.id')
            ->join('left join box_record c on a.r_id=c.id')
            ->join('left join box_company d on a.work_company=d.id')
            ->where(array('a.id'=>array('eq',$id)))
            ->find();

        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机'
        );

        $m_type = array(
            1=>'设备报修',
            2=>'设备保养',
            3=>'设备巡检',
            4=>'设备咨询'
        );

        $level = array(
            1=>'低',
            2=>'中',
            3=>'高',
            4=>'紧急',
        );

        $status = array(
            0=>'待受理',
            1=>'已受理',
            2=>'待审核',
            3=>'已审核'
        );

        $data['facility_type'] = $type[$data['facility_type']];
        $data['type'] = $m_type[$data['type']];
        $data['level'] = $level[$data['level']];
        $data['status'] = $status[$data['status']];

//        dump($data);die;
        return $data;


    }
}