<?php
/**
 * Created by Whb
 * Author: Whb
 * Date: 2017/3/15
 * Time: 16:31
 */
namespace Admin\Model;
use Think\Model;
class CompanyModel extends Model
{

    public function getData($row){

        $map = array();

//        dump($row);die;
        if($row['name']!=''){
            $map['name'] = array('eq',$row['name']);
        }

        if($row['code']!=''){
            $map['company_code'] = array('eq',$row['code']);
        }

        if($row['type']!=''){
            $map['type'] = array('eq',$row['type']);
        }

        if($row['sheng']!=''){
            $map['sheng_id'] = array('eq',$row['sheng']);
        }

        if($row['shi']!=''){
            $map['shi_id'] = array('eq',$row['shi']);
        }

        $map['is_del'] = array('eq','0');


        if(session('userinfo.uid')!=1){
            $map['id'] = array('eq',session('userinfo.company_id'));
        }

        $data = $this
            ->where($map)
            ->select();

        $type = D('Codetype')->getData('组织机构类型');
        $type = D('Code')->getData($type);

        $arr_type = array();
        foreach($type as $k=>$v){
            $arr_type[$v['val']] = $v['name'];
        }

        $status = D('Codetype')->getData(C('COMPANY_STATUS'));
        $status = D('Code')->getData($status);

        $arr_status = array();
        foreach($status as $k=>$v){
            $arr_status[$v['val']] = $v['name'];
        }


        foreach($data as $k=>$v){
            $data[$k]['type'] = $arr_type[$v['type']];
            $data[$k]['status'] = $arr_status[$v['status']];

            $sheng  = M('region')->field('name')->find($v['sheng_id']);
            $shi  = M('region')->field('name')->find($v['shi_id']);
            $data[$k]['diqu'] = $sheng['name'].'-'.$shi['name'];
        }

        return $data;
    }

    public function getOne($id){
        $info = $this->where(array('id'=>array('eq',$id)))->find();

        $info['section'] = M('company_section')->where(array('company_id'=>array('eq',$id)))->select();
        $info['zizhi'] = M('aptitude')->where(array('connet'=>array('eq',$id),'type'=>array('eq',1),'del'=>array('eq',0)))->select();
        return $info;
    }

    public function getDetail($id){

        $info = $this->find($id);

        $sheng  = M('region')->field('name')->find($info['sheng_id']);
        $shi  = M('region')->field('name')->find($info['shi_id']);
        $info['diqu'] = $sheng['name'].'-'.$shi['name'];

        $info['section'] = M('company_section')->where(array('company_id'=>array('eq',$id)))->select();

        $type = D('Codetype')->getData('组织机构类型');
        $type = D('Code')->getData($type);

        foreach($type as $k=>$v){
            if($v['val'] == $info['type']){
                $info['type'] = $v['name'];
                break;
            }
        }

        $info['apt'] = M('aptitude')->where(array('connet'=>array('eq',$id),'type'=>array('eq',1),'del'=>array('eq',0)))->select();
        foreach($info['apt'] as $k=>$v){
            if($v['level']==1){
                $info['apt'][$k]['level']='初级';
            }

            if($v['level']==2){
                $info['apt'][$k]['level']='中级';
            }

            if($v['level']==3){
                $info['apt'][$k]['level']='高级';
            }
        }

        return $info;
    }

    public function get_group($company_id){
        $type = $this->find($company_id);
        $group = $this->table('box_auth_group')
//                      ->field('id,title')
                      ->where(array(
                          'company_type'=>array('eq',$type['type']),
                          'del'=>array('eq',0)

                      ))
                      ->select();
        return $group;
    }
    public function getMsg($row){
        if($row['id']){
            $this->where(array('id'=>$row['id']));
        }
        $data = $this->field('id,name')->find();
        return $data;
    }

}