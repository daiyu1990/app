<?php
/**
 * @Author: Sincez
 * @Date:   2015-12-14 22:37:45
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-12-17 16:30:38
 */
namespace Admin\Model;
use Think\Model;
class LoginlistModel extends Model{

    protected $tableName = 'loginlist'; 

    public $col = 'username,password,state,add_time,mac,ip';
    
    public function insertData($row){
        $data = array_bykeys($row,$this->col);
        $data['add_time'] = time();
        $this->add($data);
    }
    public function getData($row){
        if($row['uid']){
            $condition['username'] = $row['uid'];
        }
        if($row['sdate']){
            $condition['add_time'][] =  array('EGT',strtotime($row['sdate']));
        }
        if($row['edate']){
            $condition['add_time'][] = array('ELT',strtotime($row['edate'])+86399);
        }
        $result = $this ->where($condition)->order('id desc')->select();
        return $result;
    }
}