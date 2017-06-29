<?php
/**
 * Created by Whb
 * Author: Whb
 * Date: 2017/3/15
 * Time: 16:31
 */
namespace Admin\Model;
use Think\Model;
class EngineeringModel extends Model
{

    public function getData($row){


        $map = array();

        if($row['code']!=''){
            $map['code'] = array('eq',$row['code']);
        }

        if($row['name']!=''){
            $map['name'] = array('eq',$row['name']);
        }

        if($row['sheng']!=0){
            $map['sheng_id'] = array('eq',$row['sheng']);
        }

        if($row['shi']!=0){
            $map['shi_id'] = array('eq',$row['shi']);
        }

        if($row['start']!='' && $row['end']!=''){
            $map['create_time'] = array(array('egt',$row['start']),array('elt',$row['end']));
        }elseif($row['start']!=''){
            $map['create_time'] = array('egt',$row['start']);
        }elseif($row['end']!=''){
            $map['create_time'] = array('elt',$row['end']);
        }

        if(session('userinfo.uid')!=1){
            $map['company_id']=array('eq',session('userinfo.company_id'));
        }

        $map['is_del'] = array('eq',0);

        $info = M('engineering')
                ->field('id,code,name,sheng_id,shi_id,jianshe,chengjian,taji,shengjiangji,status')
                ->where($map)
                ->select();

        $status = D('Code')->where(array('code'=>array('eq','engin_status')))->select();
        $arr_status = array();
        foreach($status as $k=>$v){
            $arr_status[$v['val']] = $v['name'];
        }


        foreach($info as $k=>$v){
            $sheng  = M('region')->field('name')->find($v['sheng_id']);
            $shi  = M('region')->field('name')->find($v['shi_id']);
            $jianshe = M('company')->field('name')->find($v['jianshe']);
            $chengjian = M('company')->field('name')->find($v['chengjian']);

            $info[$k]['diqu'] = $sheng['name'].'-'.$shi['name'];
            $info[$k]['jianshe'] = $jianshe['name'];
            $info[$k]['chengjian'] = $chengjian['name'];
            $info[$k]['status'] = $arr_status[$v['status']];

        }

//        dump($info);die;
//        $page = $p->show();

        return $info;
    }

    public function getOne($id){
        $info = M('engineering')
            ->where(array('id'=>array('eq',$id)))
            ->find();

        return $info;

    }

    public function getDetail($id){
        $info = M('engineering')
            ->where(array('id'=>array('eq',$id)))
            ->find();

        $sheng  = M('region')->field('name')->find($info['sheng_id']);
        $shi  = M('region')->field('name')->find($info['shi_id']);
        $jianshe = M('company')->field('name')->find($info['jianshe']);
        $chengjian = M('company')->field('name')->find($info['chengjian']);
        $jianli = M('company')->field('name')->find($info['jianli']);
        $anjianzhan = M('company')->field('name')->find($info['anjianzhan']);

        $info['diqu'] = $sheng['name'].'-'.$shi['name'];
        $info['jianshe'] = $jianshe['name'];
        $info['chengjian'] = $chengjian['name'];
        $info['jianli'] = $jianli['name'];
        $info['anjianzhan'] = $anjianzhan['name'];


        return $info;

    }

    public function get_group($company_id){
        $type = $this->find($company_id);
        $group = $this->table('box_auth_group')
                      ->field('id,title')
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