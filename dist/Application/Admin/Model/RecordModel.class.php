<?php
/**
 * Created by coder meng.
 * User: coder meng
 * Date: 2017/3/15 16:08
 */
namespace Admin\Model;
use Think\Model;
class RecordModel extends Model{
    protected $tableName='record';
//    protected $col = 'record_typeid,record_name,record_file,addtime,facilityid';
    public function insertData($row){
        $data = array_bykeys($row,$this->col);
        if($row['id']){
            if(!$row['record_file']){
                unset($data['record_file']);
            }
            $res = $this->where(array('id'=>$row['id']))->save($data);
        } else {
            $res = $this->add($data);
        }
        return $res;
    }



    public function getOne($id){

        $info = $this->alias('a')
                     ->field('a.*,b.license_code,b.sheng_id,b.shi_id,b.faren,b.faren_mobile,c.facility_number,
                              c.facility_model_number,c.facility_type,c.manufacturing_licence_number,c.factory_date,
                              c.make_company,c.facility_number
                            ')
                     ->join('left join box_company b on a.chanquan=b.id')
                     ->join('left join box_facility_msg c on a.fac_id=c.id')
                     ->where(array('a.id'=>array('eq',$id)))
                     ->find();
//        dump($this->getlastsql());

        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机',
        );

        $info['facility_type'] = $type[$info['facility_type']];

        $make = M('company')->find($info['make_company']);
        $info['make_company'] = $make['name'];

        $sheng  = M('region')->field('name')->find($info['sheng_id']);
        $shi  = M('region')->field('name')->find($info['shi_id']);
        $info['diqu'] = $sheng['name'].'-'.$shi['name'];

        $info['param'] =  M('facility_parameter')->where(array('fid'=>array('eq',$info['fac_id'])))->select();

//        dump($info);die;

        return $info;

    }


    public function getDetail($id){

        $info = $this->alias('a')
            ->field('a.*,b.name as company_name,b.license_code,b.sheng_id,b.shi_id,b.faren,b.faren_mobile,c.facility_number,
                              c.facility_model_number,c.facility_type,c.manufacturing_licence_number,c.factory_date,
                              c.make_company
                            ')
            ->join('left join box_company b on a.chanquan=b.id')
            ->join('left join box_facility_msg c on a.fac_id=c.id')
            ->where(array('a.id'=>array('eq',$id)))
            ->find();
//        dump($this->getlastsql());

        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机',
        );



        $info['facility_type'] = $type[$info['facility_type']];

        $make = M('company')->find($info['make_company']);
        $info['make_company'] = $make['name'];

        $sheng  = M('region')->field('name')->find($info['sheng_id']);
        $shi  = M('region')->field('name')->find($info['shi_id']);
        $info['diqu'] = $sheng['name'].'-'.$shi['name'];

        $laiyuan = array(
            1=>'自有',
            2=>'租赁'
        );
        $info['laiyuan'] = $laiyuan[$info['laiyuan']];

        $beian = array(
            1=>'已备案',
            2=>'未备案',
        );

        $info['beian'] = $beian[$info['beian_status']];

        $info['file'] = "/Admin/File/record_download/id/".$info['id'];

        $info['param'] =  M('facility_parameter')->where(array('fid'=>array('eq',$info['fac_id'])))->select();

//        dump($info);die;

        return $info;


    }

    public function getData($row){

        $map = array();

        if($row['type']!=''){
            $map['c.facility_type'] = array('eq',$row['type']);
        }

        if($row['chanquan']!=''){
            $map['a.beian_code'] = array('eq',$row['chanquan']);
        }

        if($row['code']!=''){
            $map['c.facility_number'] = array('eq',$row['code']);
        }

        if($row['status']!=''){
            $map['a.status'] = array('eq',$row['status']);
        }

        if($row['sheng']!=''){
            $map['b.sheng_id'] = array('eq',$row['sheng']);
        }

        if($row['shi']!=''){
            $map['b.shi_id'] = array('eq',$row['shi']);
        }

        if(session('userinfo.uid')!=1){
            $map['a.create_company']=array('eq',session('userinfo.company_id'));
        }

        $map['a.del'] = array('eq',0);
        $data = $this->alias('a')
                    ->field('a.*,b.name as company_name,b.sheng_id,b.shi_id,c.facility_number,
                             c.facility_model_number,c.facility_type')
                    ->join('left join box_company b on a.chanquan=b.id')
                    ->join('left join box_facility_msg c on a.fac_id=c.id')
                    ->where($map)
                    ->select();

//        dump($data);die;

        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机'
        );

        $status = array(
            0=>'待审核',
            1=>'已审核',
            2=>'被驳回',
        );

        $beian = array(
            1=>'已备案',
            2=>'未备案',
        );

        foreach($data as $k=>$v){
            $sheng  = M('region')->field('name')->find($v['sheng_id']);
            $shi  = M('region')->field('name')->find($v['shi_id']);
            $data[$k]['diqu'] = $sheng['name'].'-'.$shi['name'];

            $data[$k]['status'] = $status[$v['status']];
            $data[$k]['beian'] = $beian[$v['beian_status']];
            $data[$k]['facility_type'] = $type[$v['facility_type']];
        }


        return $data;

    }
}