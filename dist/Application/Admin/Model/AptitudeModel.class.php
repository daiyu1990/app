<?php
/**
 * @Author: Sincez
 * @Date:   2016-02-22 21:17:02
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-12-01 12:23:50
 */
namespace Admin\Model;
use Think\Model;
class AptitudeModel extends Model
{
    protected $tableName='aptitude';

//    protected $col = 'pid,name,title,type,status,condition,is_show,is_open,ord,class';


    public function getData($row){

//        dump($row);
        $map = array();
        if($row['name'] && $row['name']!=''){
            $map['name'] = array('eq',$row['name']);
        }

        if($row['type'] && $row['type']!=''){
            $map['type'] = array('eq',$row['type']);
        }

        if($row['level'] && $row['level']!=''){
            $map['level'] = array('eq',$row['level']);
        }


        $map['del'] = array('eq',0);

        if(session('userinfo.uid')!=1){
            $map['create_company']=array('eq',session('userinfo.company_id'));
        }

        $info = $this->where($map)->select();

//        dump($info);die;
        $type = array(
            1=>'企业资质',
            2=>'人员资质'
        );

        $level = array(
            1=>'初级',
            2=>'中级',
            3=>'高级'
        );

        $data = array();

        $time = time();


            foreach($info as $k=>$v){
                $v['a_type'] = $type[$v['type']];
                $v['level'] = $level[$v['level']];

                if(strtotime($v['daoqi'])>$time){
                    $v['is_daoqi'] = '有效';
                }else{
                    $v['is_daoqi'] = '无效';
                }

                if($v['type']==1){
                    $name = M('company')->find($v['connet']);
                    $v['connet_name'] = $name['name'];
                }else{
                    $name = M('users')->find($v['connet']);
                    $v['connet_name'] = $name['nicename'];
                }

                if($row['guanlian']==''){
                    $data[] = $v;
                }else{
                    if($v['connet_name']==$row['guanlian']){
                        $data[] = $v;
                    }
                }


            }

//        dump($data);die;
        return $data;
    }
}