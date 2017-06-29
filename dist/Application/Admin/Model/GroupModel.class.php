<?php
/**
 * @Author: Sincez
 * @Date:   2015-12-21 16:58:51
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-11-22 18:13:54
 */
namespace Admin\Model;
use Think\Model;
class GroupModel extends Model
{
    protected $tableName='auth_group';

    public function insertData($row){
        $data['title'] = $row['title'];
        // $data['status'] = $row['status'];
        if($row['describe']){
            $data['describe'] = $row['describe'];
        }
        // $data['ord'] = $row['ord'];
        if($row['rules']){
            $data['rules'] = $row['rules'];
        }
        if($row['uid']){
            $data['uid'] = $row['uid'];
        }
        if($row['company_type']){
            $data['company_type'] = $row['company_type'];
        }
        
        if($row['id']){
            $this->where(array('id'=>$row['id']))->save($data);
            $gid = $row['id'];
        } else {
            $gid = $this->add($data);
        }
        return $gid;
    }
}