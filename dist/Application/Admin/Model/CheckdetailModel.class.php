<?php
/**
 * Created by Whb
 * Author: Whb
 * Date: 2017/3/15
 * Time: 16:31
 */
namespace Admin\Model;
use Think\Model;
class CheckdetailModel extends Model
{

    protected $tableName = 'check_detail';


    public function getData($id){
        $info = $this->field('a.*,b.nicename')
                     ->alias('a')
                     ->join('left join box_users b on a.check_id=b.uid')
                     ->where(array('a.eng_id'=>array('eq',$id)))
                     ->order('a.id DESC')
                     ->select();
        return $info;
    }



}