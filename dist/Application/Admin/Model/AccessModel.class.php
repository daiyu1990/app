<?php
/**
 * @Author: Sincez
 * @Date:   2016-02-25 22:35:59
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-02-25 22:37:48
 */
namespace Admin\Model;
use Think\Model;
class AccessModel extends Model{

    protected $tableName = 'auth_group_access'; 

    public function insertData($row){
        $data['uid'] = $row['uid'];
        $data['group_id'] = $row['group'];
        $this->add($data);
    }
}