<?php
/**
 * Created by coder meng.
 * User: coder meng
 * Date: 2017/3/15 16:08
 */
namespace Admin\Model;
use Think\Model;
class FacilityparamModel extends Model{
    protected $tableName='facility_param';
    protected $col = 'load_moment,rated_load,amplitude_peak,rated_payload_capacity,largest_free_height,largest_raising_height,gauge,wheel_base,chassis_type,luffing_type,trolley_travlling_speed,largest_raising_speed,decline_speed,turning_speed,running_speed,remark';
    public function insertData($row){
        $data = array_bykeys($row,$this->col);
        if($row['pid']){
            $res = $this->where(array('pid'=>$row['pid']))->save($data);
        } else {
            $res =  $this->add($data);
        }
        return $res;
    }
}