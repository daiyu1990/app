<?php
/**
 * @Author: Sincez
 * @Date:   2015-12-14 22:32:23
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-01-05 13:57:48
 */
namespace Admin\Model;
use Think\Model;
class UseModel extends Model{

    protected $tableName = 'use';


    public function getOne($id){
        $data = $this
            ->alias('a')
            ->field('a.*,
                     b.chanquan,
                     c.facility_number,c.facility_type,c.facility_model_number,c.factory_date,
                     d.code as engin_code ,d.sheng_id,d.shi_id,
                     e.terminal_model_number,e.terminal_company,e.factory_date as ter_chuchang')
            ->join('left join box_record b on a.r_id=b.id')
            ->join('left join box_facility_msg c on a.f_id=c.id')
            ->join('left join box_engineering d on a.e_id=d.id')
            ->join('left join box_terminal e on a.t_id=e.id')
            ->where(array(
                'a.id'=>array('eq',$id)
            ))
            ->find();

//        dump($data);
//        dump($this->getLastSql());die;

        $company = M('company')->find($data['chanquan']);
        $data['chanquan'] = $company['name'];

        $company = M('company')->find($data['terminal_company']);
        $data['terminal_company'] = $company['name'];

        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机',
        );

        $data['facility_type'] = $type[$data['facility_type']];



        $sheng  = M('region')->field('name')->find($data['sheng_id']);
        $shi  = M('region')->field('name')->find($data['shi_id']);
        $data['diqu'] = $sheng['name'].'-'.$shi['name'];

        $data['oper'] = M('use_oper')->where(array('use_id'=>array('eq',$id)))->select();

        return $data;
    }


    public function getData($row){
        $map = array();

        if($row['type']!=''){
            $map['b.facility_type'] = array('eq',$row['type']);
        }


        if($row['fac_code']!=''){
            $map['b.equity_number'] = array('eq',$row['fac_code']);
        }


        if($row['sheng']!=''){
            $map['c.sheng_id'] = array('eq',$row['sheng']);
        }

        if($row['shi']!=''){
            $map['c.shi_id'] = array('eq',$row['shi']);
        }

        if($row['status']!=''){
            $map['a.status'] = array('eq',$row['status']);
        }

        if($row['beian']!=''){
            $map['a.beian_status'] = array('eq',$row['beian']);
        }

        $map['a.del'] = array('eq',0);

        if(session('userinfo.uid')!=1){
            $map['a.create_company']=array('eq',session('userinfo.company_id'));
        }

        $data = $this
            ->alias('a')
            ->field(
                'a.*,
                 b.equity_number,b.facility_type,b.facility_model_number,
                 c.name as engin_name,c.sheng_id,c.shi_id,
                 d.name as company_name'
                )
            ->join('left join box_facility_msg b on a.f_id=b.id')
            ->join('left join box_engineering c on a.e_id=c.id')
            ->join('left join box_company d on a.use_company=d.id')
            ->where($map)
            ->select();

//        dump($data);
//        dump($this->getLastSql());die;
        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机',
        );

        $beian = array(
            1=>'已备案',
            2=>'未备案',
        );

        $status = array(
            0=>'待审核',
            1=>'已审核',
            2=>'被驳回',
        );

        foreach($data as $k=>$v){
            $data[$k]['facility_type'] = $type[$v['facility_type']];
            $data[$k]['beian_status'] = $beian[$v['beian_status']];
            $data[$k]['status'] = $status[$v['status']];

            $sheng  = M('region')->field('name')->find($v['sheng_id']);
            $shi  = M('region')->field('name')->find($v['shi_id']);
            $data[$k]['diqu'] = $sheng['name'].'-'.$shi['name'];

        }

//        dump($data);die;

        return $data;
    }

    public function getDetail($id){
        $data = $this
            ->alias('a')
            ->field('a.*,
                     b.chanquan,b.beian_code,
                     c.facility_number,c.facility_type,c.facility_model_number,c.factory_date,
                     d.name as engin_name,d.code as engin_code ,d.sheng_id,d.shi_id,
                     e.terminal_number,e.terminal_model_number,e.terminal_company,e.factory_date as ter_chuchang')
            ->join('left join box_record b on a.r_id=b.id')
            ->join('left join box_facility_msg c on a.f_id=c.id')
            ->join('left join box_engineering d on a.e_id=d.id')
            ->join('left join box_terminal e on a.t_id=e.id')
            ->where(array(
                'a.id'=>array('eq',$id)
            ))
            ->find();

//        dump($data);
//        dump($this->getLastSql());die;

        $company = M('company')->find($data['chanquan']);
        $data['chanquan'] = $company['name'];

        $company = M('company')->find($data['terminal_company']);
        $data['terminal_company'] = $company['name'];

        $company = M('company')->find($data['ins_company']);
        $data['ins_company'] = $company['name'];

        $company = M('company')->find($data['use_company']);
        $data['use_company'] = $company['name'];

        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机',
        );

        $data['facility_type'] = $type[$data['facility_type']];



        $sheng  = M('region')->field('name')->find($data['sheng_id']);
        $shi  = M('region')->field('name')->find($data['shi_id']);
        $data['diqu'] = $sheng['name'].'-'.$shi['name'];

        $beian = array(
            1=>'已备案',
            2=>'未备案'
        );

        $data['beian_status'] = $beian[$data['beian_status']];

        $data['oper'] = M('use_oper')->where(array('use_id'=>array('eq',$id)))->select();

        return $data;
    }


}