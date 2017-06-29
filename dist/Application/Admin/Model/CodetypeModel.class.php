<?php
/**
 * @Author: Sincez
 * @Date:   2016-10-27 17:21:12
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-11-04 12:47:30
 */
namespace Admin\Model;
use Think\Model;
class CodetypeModel extends Model
{
	protected $tableName = 'code_type';

	protected $col = 'name,code,is_system,ord';

	public function insertData($row){
		$data = array_bykeys($row, $this->col);
		if($row['id']){
			$cid = $row['id'];
			$this->where(array('id'=>$row['id']))->save($data);
		} else {
			$cid = $this->add($data);
		}
		return $cid;
	}
	public function getData($res){
		if($res){
			$data = $this->where(array('name'=>$res))->field('code')->find();
		}

		return $data;
	}
}