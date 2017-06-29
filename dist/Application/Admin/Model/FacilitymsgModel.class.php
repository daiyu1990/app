<?php
/**
 * Created by coder meng.
 * User: coder meng
 * Date: 2017/3/15 16:08
 */
namespace Admin\Model;
use Think\Model;
class FacilitymsgModel extends Model{
    protected $tableName='facility_msg';
//    protected $col = 'equity_number,facility_type,factory_date,record_date,buy_date,facility_number,equity_certification_number,facility_source,facility_model_number,manufacturing_licence_number,supervise_verify_number,terminal_make_company';

    public function insertData($row){
        if($row){
            $row['factory_date'] = strtotime($row['factory_date']);
            $row['buy_date'] = strtotime($row['buy_date']);
        }
        $data = array_bykeys($row,$this->col);
        if($row['mid']){
            $res = $this->where(array('mid'=>$row['mid']))->save($data);
        } else {
            $data['record_date'] = time();
            $res =  $this->add($data);
        }
        return $res;
    }
    public function getData($row){
        $map = array();

        if($row['type']!=''){
            $map['facility_type'] = array('eq',$row['type']);
        }

        if($row['chanquan']!=''){
            $map['equity_number'] = array('eq',$row['chanquan']);
        }

        if($row['shebei']!=''){
            $map['facility_number'] = array('eq',$row['shebei']);
        }

        if($row['status']!=''){
            $map['status'] = array('eq',$row['status']);
        }


        $map['del'] = array('eq',0);

        if(session('userinfo.uid')!=1){
            $map['create_company']=array('eq',session('userinfo.company_id'));
        }

        $data = $this->where($map)->select();

        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机',
        );

        $status = array(
            0=>'待审核',
            1=>'已审核',
            2=>'已驳回'
        );

        $record = array(
            0=>'未备案',
            1=>'已备案'
        );

        foreach($data as $k=>$v){
            $data[$k]['facility_type'] = $type[$v['facility_type']];
            $data[$k]['status'] = $status[$v['status']];
            $data[$k]['is_record'] = $record[$v['is_record']];

        }

        return $data;
    }

    public function getOne($id){
        $info = $this->find($id);
        $info['param'] = M('facility_parameter')->where(array('fid'=>array('eq',$id)))->select();

        return $info;
    }

    public function getDetail($id){
        $info = $this->alias('a')
                     ->field('a.*,b.name as company_name')
                     ->join('left join box_company b on a.make_company=b.id')
                     ->where(array('a.id'=>array('eq',$id)))
                     ->find();

        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机',
        );


        $info['facility_type'] = $type[$info['facility_type']];



        $info['param'] = M('facility_parameter')->where(array('fid'=>array('eq',$id)))->select();

        return $info;
    }
}