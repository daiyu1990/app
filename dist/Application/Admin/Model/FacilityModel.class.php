<?php
/**
 * Created by coder meng.
 * User: coder meng
 * Date: 2017/3/15 16:08
 */
namespace Admin\Model;
use Think\Model;
class FacilityModel extends Model{
    protected $tableName='facility';
    protected $col = 'terminal_number,project_name,project_number,install_company,equity_company,facility_msgid,technical_paramid,supervisor_company,use_company,project_name,safe_supervise_site,install_status';
    public function insertData($row){
        $data = array_bykeys($row,$this->col);
        if($row['id']){
            $res = $this->where(array('id'=>$row['id']))->save($data);
        } else {
            $res = $this->add($data);
        }
        return $res;
    }
}