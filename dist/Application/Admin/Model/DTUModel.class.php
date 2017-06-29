<?php
/**
 * Created by coder meng.
 * User: coder meng
 * Date: 2017/3/15 16:08
 */
namespace Admin\Model;
use Think\Model;
class DTUModel extends Model{
    protected $tableName='dtu';

    public function getOne($id){
        $info = $this->find($id);

        return $info;
    }

    public function getDetail($id){
        $info = $this->alias('a')
                    ->field('a.*,b.name as company_name')
                    ->join('left join box_company b on a.make_company=b.id')
                    ->where(array('a.id'=>array('eq',$id)))
                    ->find();

        $type = M('code')->where(array('code'=>array('eq','dtu_type')))->select();

        foreach($type as $k=>$v){
            if($info['type']==$v['val']){
                $info['type'] = $v['name'];
                break;
            }
        }



        return $info;

    }

    public function getData($row){
        $map = array();
        if($row['code']!=''){
            $map['a.code'] = array('eq',$row['code']);
        }

        if($row['type']!=''){
            $map['a.type'] = array('eq',$row['type']);
        }

        if($row['start']!='' && $row['end']!=''){
            $map['a.chuchang'] = array(array('egt',$row['start']),array('elt',$row['end']));
        }elseif($row['start']!=''){
            $map['a.chuchang'] = array('egt',$row['start']);
        }elseif($row['end']!=''){
            $map['a.chuchang'] = array('elt',$row['end']);
        }

        if(session('userinfo.uid')!=1){
            $map['create_company']=array('eq',session('userinfo.company_id'));
        }

        $map['del'] = array('eq',0);

        $data = $this->alias('a')
                     ->field('a.*,b.name as company_name')
                     ->join('left join box_company b on a.make_company=b.id')
                     ->where($map)
                     ->select();

        $type = M('code')->where(array('code'=>array('eq','dtu_type')))->select();
        $type_arr = array();
        foreach($type as $k=>$v){
            $type_arr[$v['val']] = $v['name'];
        }


        $status = array(
            0 => '待审核',
            1 => '已审核',
            2 => '被驳回'
        );

        $fac_type = array(
            1 => '塔式起重机',
            2 => '施工升降机'
        );

        foreach($data as $k=>$v){

            $fac = M('facility_msg')->where(array('facility_number'=>array('eq',$v['fac_code'])))->find();

            $data[$k]['fac_type'] = $fac_type[$fac['facility_type']];
            $data[$k]['type'] = $type_arr[$v['type']];
            $data[$k]['status'] = $status[$v['status']];

        }

        return $data;
    }
}