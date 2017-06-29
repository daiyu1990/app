<?php
/**
 * Created by Whb
 * Author: Whb
 * Date: 2017/3/15
 * Time: 16:31
 */
namespace Admin\Model;
use Think\Model;
class InformModel extends Model
{

    public function getData($row){
        $map = array();

        if($row['type']!=''){
            $map['b.facility_type'] = array('eq',$row['type']);
        }

        if($row['code']!=''){
            $map['a.code'] = array('eq',$row['code']);
        }

        if($row['fac_code']!=''){
            $map['b.equity_number'] = array('eq',$row['fac_code']);
        }

        if($row['fac_xinghao']!=''){
            $map['b.facility_model_number'] = array('eq',$row['fac_xinghao']);
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

        if(session('userinfo.uid')!=1){
            $map['a.create_company']=array('eq',session('userinfo.company_id'));
        }

        $map['a.del'] = array('eq',0);

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
                ->join('left join box_company d on a.c_id=d.id')
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

    public function getOne($id){
        $data = $this
            ->alias('a')
            ->field('a.*,
                     b.chanquan,b.beian_code,
                     c.facility_number,c.facility_type,c.facility_model_number,c.factory_date,
                     d.code as engin_code ,d.sheng_id,d.shi_id')
            ->join('left join box_record b on a.r_id=b.id')
            ->join('left join box_facility_msg c on a.f_id=c.id')
            ->join('left join box_engineering d on a.e_id=d.id')
            ->where(array(
                'a.id'=>array('eq',$id)
            ))
            ->find();

        $company = M('company')->find($data['chanquan']);
        $data['chanquan'] = $company['name'];

        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机',
        );

        $data['facility_type'] = $type[$data['facility_type']];



        $sheng  = M('region')->field('name')->find($data['sheng_id']);
        $shi  = M('region')->field('name')->find($data['shi_id']);
        $data['diqu'] = $sheng['name'].'-'.$shi['name'];

        $data['param'] = M('inform_param')->where(array('i_id'=>array('eq',$id)))->select();
        $data['oper'] = M('inform_oper')->where(array('i_id'=>array('eq',$id)))->select();

        return $data;
    }

    public function getDetail($id){
        $data = $this
            ->alias('a')
            ->field('a.*,
                     b.chanquan,b.beian_code,
                     c.facility_number,c.facility_type,c.facility_model_number,c.factory_date,
                     d.name as engin_name,d.code as engin_code ,d.sheng_id,d.shi_id')
            ->join('left join box_record b on a.r_id=b.id')
            ->join('left join box_facility_msg c on a.f_id=c.id')
            ->join('left join box_engineering d on a.e_id=d.id')
            ->where(array(
                'a.id'=>array('eq',$id)
            ))
            ->find();

        $company = M('company')->find($data['chanquan']);
        $data['chanquan'] = $company['name'];

        $company = M('company')->find($data['c_id']);
        $data['work_company'] = $company['name'];

        $type = array(
            1=>'塔式起重机',
            2=>'施工升降机',
        );
        $data['facility_type'] = $type[$data['facility_type']];

        $ins_type = array(
            1=>'安装',
            2=>'拆除',
        );
        $data['type'] = $ins_type[$data['type']];

        $sheng  = M('region')->field('name')->find($data['sheng_id']);
        $shi  = M('region')->field('name')->find($data['shi_id']);
        $data['diqu'] = $sheng['name'].'-'.$shi['name'];

        $data['param'] = M('inform_param')->where(array('i_id'=>array('eq',$id)))->select();
        $data['oper'] = M('inform_oper')->where(array('i_id'=>array('eq',$id)))->select();

        return $data;
    }


}