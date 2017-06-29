<?php
/**
 * @Author: Sincez
 * @Date:   2017-06-20 09:37:59
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-06-20 09:44:46
 */
namespace Api\Controller;
use Common\Controller\ApiController;

class EngineeringController extends ApiController
{


    /**
     * 工程列表接口 POST方式
     * @return json 状态值描述，返回工程信息
     */
    public function engin_list(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $c_id = session('memberinfo.company_id');

        $count = M('engineering')
                ->where(array('company_id'=>array('eq',$c_id),'is_del'=>array('eq',0)))
                ->count();

        $p = getpage($count,15);

        $data = M('engineering')
            ->field('id,code,name,taji,shengjiangji')
            ->where(array('company_id'=>array('eq',$c_id),'is_del'=>array('eq',0)))
            ->limit($p->firstRow, $p->listRows)
            ->select();

        if($data){
            $this->ajaxReturn(array('status'=>1,'msg'=>'获取工程信息成功','data'=>$data));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取工程信息失败',));
        }

    }


    /**
     * 新增工程接口 POST方式
     * @return json 状态值描述，返回新增工程状态
     */
    public function engin_add(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $row = array(
            'code' => I('code'),
            'name' => I('name'),
            'address' => I('address'),
            'company_id'=>session('memberinfo.company_id'),
            'create_id'=>session('memberinfo.uid'),
        );


        $is_use = M('engineering')->where(array('code'=>array('eq',$row['code'])))->find();
        if($is_use){
            $this->ajaxReturn(array('status'=>0,'msg'=>'该工程编号已被使用',));
        }

        $res = M('engineering')->add($row);
        if($res){
            $this->ajaxReturn(array('status'=>1,'msg'=>'新增工程成功',));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'新增工程失败',));
        }



    }



}