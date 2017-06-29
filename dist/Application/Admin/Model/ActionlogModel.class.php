<?php
/**
 * @Author: Sincez
 * @Date:   2016-06-02 17:55:47
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-10-15 15:32:54
 */
namespace Admin\Model;
use Think\Model;
class ActionlogModel extends Model
{
    protected $tableName = 'action_log';
    protected $col = 'uid,add_time,remark,url,ip';

    public function insertData($row){
        $data = array_bykeys($row,$this->col);
        $this->add($data);
    }

    public function getData($row){
        if($row['uid']){
            $condition['a.uid'] = $row['uid'];
        }
        if($row['sdate']){
            $condition['add_time'][] =  array('EGT',strtotime($row['sdate']));
        }
        if($row['edate']){
            $condition['add_time'][] = array('ELT',strtotime($row['edate'])+86399);
        }
        $db_prefix = C('DB_PREFIX');
        $result = $this->field('a.*,u.username')
                        ->table($db_prefix.'action_log as a')
                        ->join($db_prefix.'users as u on a.uid=u.uid')
                        ->where($condition)->order('add_time desc')->select();
        return $result;
    }


}