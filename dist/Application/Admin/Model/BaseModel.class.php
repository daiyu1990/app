<?php
/**
 * @Author: Sincez
 * @Date:   2016-06-03 22:05:14
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-07-20 09:50:06
 */
namespace Admin\Model;
use Think\Model;
class BaseModel extends Model
{
    protected $tableName = 'baseinfo';

    public function getInfo(){
        $where['uid'] = session('userinfo.uid');
        $data = $this->where($where)->select();
        foreach($data as $v){
            $result[$v['code']] = $v['val'];
        }
        return $result;
    }

}