<?php
/**
 * Created by coder meng.
 * User: coder meng
 * Date: 2017/3/15 16:08
 */
namespace Admin\Model;
use Think\Model;
class FileModel extends Model{
    protected $tableName='file';
//    protected $col = 'data_number,data_name,data_typeid,facilityid,addtime,userid,status,cause,file_path';
    public function insertData($row){
        $data = array_bykeys($row,$this->col);
        if($row['id']){
            if(!$row['file_path']){
                unset($data['file_path']);
            }
            $res = $this->where(array('id'=>$row['id']))->save($data);
        } else {
            $res = $this->add($data);
        }
        return $res;
    }


    public function getDetail($id){
        $info = $this->find($id);

        if($info['type']==1){
            $fac_info = M('facility_msg')->where(array('facility_number'=>array('eq',$info['connet'])))->find();

            $type = array(
                1=>'塔式升降机',
                2=>'施工起重机'
            );

            $info['b_type'] = $type[$fac_info['facility_type']];
        }elseif($info['type']==2){
            $ter_info = M('terminal')->where(array('terminal_number'=>array('eq',$info['connet'])))->find();

            $type = array(
                1=>'塔式升降机安全监控系统',
                2=>'施工起重机安全监控系统'
            );

            $info['b_type'] = $type[$ter_info['type']];
        }elseif($info['type']==3){
            $com_info = M('company')->where(array('id'=>array('eq',$info['connet'])))->find();

            $type = D('Codetype')->getData(C('COMPANY_TYPE'));
            $type = D('Code')->getData($type);

            foreach($type as $k=>$v){
                if($v['val']==$com_info['type']){
                    $info['b_type'] = $v['name'];
                    break;
                }
            }
            $info['connet'] = $com_info['name'];
        }

        $status = array(
            0=>'待审核',
            1=>'已审核',
            2=>'被驳回',
        );

        $info['status_code'] = $info['status'];
        $info['status'] = $status[$info['status']];
        $info['name'] = '<a href="/Admin/File/download/id/'.$info['id'].'" style="color:#2164ff">'.$info['name'].'</a>';

        return $info;
    }

    public function getData($row){

        $map = array();
        $map['a.del'] = array('eq',0);

        $status = array(
            0=>'待审核',
            1=>'已审核',
            2=>'被驳回',
        );

        if($row['type']==1){
            $map['a.type'] = array('eq',1);
            if($row['name1']!=''){
                $map['a.name'] = array('eq',$row['name1']);
            }
            if($row['fac_code']!=''){
                $map['a.connet'] = array('eq',$row['fac_code']);
            }
            if($row['fac_type']!=''){
                $map['b.facility_type'] = array('eq',$row['fac_type']);
            }

            if(session('userinfo.uid')!=1){
                $map['a.create_company']=array('eq',session('userinfo.company_id'));
            }

            $data = $this->alias('a')
                         ->field('a.*,b.facility_type as b_type')
                         ->join('left join box_facility_msg b on a.connet=b.facility_number')
                         ->where($map)
                         ->select();
//
//            dump($data);
//            dump($this->getlastsql());die;
            $type = array(
                1=>'塔式起重机',
                2=>'施工升降机',
            );

            foreach($data as $k=>$v){
                $data[$k]['b_type'] = $type[$v['b_type']];
                $data[$k]['status'] = $status[$v['status']];
            }

            return $data;
        }

        if($row['type']==2){
            $map['a.type'] = array('eq',2);
            if($row['name2']!=''){
                $map['a.name'] = array('eq',$row['name2']);
            }
            if($row['ter_code']!=''){
                $map['a.connet'] = array('eq',$row['ter_code']);
            }
            if($row['ter_type']!=''){
                $map['b.type'] = array('eq',$row['ter_type']);
            }

            if(session('userinfo.uid')!=1){
                $map['a.create_company']=array('eq',session('userinfo.company_id'));
            }

            $data = $this->alias('a')
                ->field('a.*,b.type as b_type')
                ->join('left join box_terminal b on a.connet=b.terminal_number')
                ->where($map)
                ->select();


            $type = array(
                1=>'塔式起重机安全监控系统',
                2=>'施工升降机安全监控系统',
            );

            foreach($data as $k=>$v){
                $data[$k]['b_type'] = $type[$v['b_type']];
                $data[$k]['status'] = $status[$v['status']];
            }

            return $data;
        }

        if($row['type']==3){
            $map['a.type'] = array('eq',3);
            if($row['name3']!=''){
                $map['a.name'] = array('eq',$row['name3']);
            }

            if(session('userinfo.uid')!=1){
                $map['a.create_company']=array('eq',session('userinfo.company_id'));
            }


            $data = $this->alias('a')
                ->field('a.*,b.name as b_name, b.type as b_type')
                ->join('left join box_company b on a.connet=b.id')
                ->where($map)
                ->select();

            $type = D('Codetype')->getData(C('COMPANY_TYPE'));
            $type = D('Code')->getData($type);

            $arr_type = array();
            foreach($type as $k=>$v){
                $arr_type[$v['val']] = $v['name'];
            }

            foreach($data as $k=>$v){
                $data[$k]['b_type'] = $arr_type[$v['b_type']];
                $data[$k]['status'] = $status[$v['status']];
                $data[$k]['connet'] = $v['b_name'];
            }

            return $data;
        }

    }
}