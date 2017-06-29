<?php
/**
 * Created by Whb
 * Author: Whb
 * Date: 2017/3/15
 * Time: 16:31
 */
namespace Admin\Model;
use Think\Model;
class OperatorModel extends Model
{

    public function getData($row,$do='create')
    {
        if ($row['type'] && $row['type'] != -1) {
            $map['a.station'] = array('EQ', $row['type']);
        }

        if (session()['userinfo']['company_id']!=0){
            $map['a.company_id'] = session()['userinfo']['company_id'];
        }

        $data = $this
            ->alias('a')
            ->field('a.*,b.name,c.nicename,c.mobile,c.person_code')
            ->join('left join box_company b on a.company_id=b.id')
            ->join('left join box_users c on a.uid=c.uid')
            ->where($map)
            ->select();
//        dump($this->getLastSql());
        return $data;

    }

    public function getOne($id){
        $data = $this
            ->alias('a')
            ->field('a.*,b.name,c.nicename,c.mobile,c.person_code,c.IDcard')
            ->join('left join box_company b on a.company_id=b.id')
            ->join('left join box_users c on a.uid=c.uid')
            ->where(array(
                'a.id'=>array('eq',$id)
            ))
            ->find();
//        dump($this->getLastSql());
        return $data;
    }
    public function getMsg(){
        if (session()['userinfo']['company_id']!=0){
            $map['a.company_id'] = session()['userinfo']['company_id'];
        }
        $map['d.name'] = '工程师';
        $data = $this->alias('a')
            ->field('a.*,b.name,c.nicename,c.mobile,c.person_code')
            ->join('left join box_company b on a.company_id=b.id')
            ->join('left join box_users c on a.uid=c.uid')
            ->join('left join box_code d on a.station = d.id')
            ->where($map)
            ->select();
        return $data;
    }


}