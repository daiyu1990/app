<?php
/**
 * @Author: Sincez
 * @Date:   2017-06-20 09:37:59
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-06-20 09:44:46
 */
namespace Api\Controller;
use Common\Controller\ApiController;

class FileController extends ApiController
{


    /**
     * 设备资料接口 POST方式
     * @return json 状态值描述，返回设备资料
     */
    public function fac_file(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $c_id = session('memberinfo.company_id');

        $count = M('file')
                ->where(array(
                    'type'=>array('eq',1),  
                    'create_company'=>array('eq',$c_id),
                    'del'=>array('eq',0)
                ))
                ->count();

        $p = getpage($count,15);

        $data = M('file')
                ->field('id,code,name,file')
                ->where(array(
                    'type'=>array('eq',1),
                    'create_company'=>array('eq',$c_id),
                    'del'=>array('eq',0)
                ))
                ->limit($p->firstRow, $p->listRows)
                ->select();

        if($data){
            $this->ajaxReturn(array('status'=>1,'msg'=>'获取设备资料成功','data'=>$data));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取设备资料失败',));
        }

    }

    /**
     * 终端资料接口 POST方式
     * @return json 状态值描述，返回终端资料
     */
    public function ter_file(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $c_id = session('memberinfo.company_id');

        $count = M('file')
            ->where(array(
                'type'=>array('eq',2),
                'create_company'=>array('eq',$c_id),
                'del'=>array('eq',0)
            ))
            ->count();

        $p = getpage($count,15);

        $data = M('file')
            ->field('id,code,name,file')
            ->where(array(
                'type'=>array('eq',2),
                'create_company'=>array('eq',$c_id),
                'del'=>array('eq',0)
            ))
            ->limit($p->firstRow, $p->listRows)
            ->select();

        if($data){
            $this->ajaxReturn(array('status'=>1,'msg'=>'获取终端资料成功','data'=>$data));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取终端资料失败',));
        }
    }


    /**
     * 企业资料接口 POST方式
     * @return json 状态值描述，返回企业资料
     */
    public function company_file(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $c_id = session('memberinfo.company_id');

        $count = M('file')
            ->where(array(
                'type'=>array('eq',3),
                'create_company'=>array('eq',$c_id),
                'del'=>array('eq',0)
            ))
            ->count();

        $p = getpage($count,15);

        $data = M('file')
            ->field('id,code,name,file')
            ->where(array(
                'type'=>array('eq',3),
                'create_company'=>array('eq',$c_id),
                'del'=>array('eq',0)
            ))
            ->limit($p->firstRow, $p->listRows)
            ->select();

        if($data){
            $this->ajaxReturn(array('status'=>1,'msg'=>'获取企业资料成功','data'=>$data));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取企业资料失败',));
        }
    }


    /**
     * 备案信息接口 POST方式
     * @return json 状态值描述，返回设备备案信息
     */
    public function fac_record(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $c_id = session('memberinfo.company_id');

        $count = M('facility_msg')
            ->where(array(
                'create_company'=>array('eq',$c_id),
                'del'=>array('eq',0)
            ))
            ->count();

        $p = getpage($count,15);

        $data = M('facility_msg')
            ->field('id,facility_number,equity_number,is_record')
            ->where(array(
                'create_company'=>array('eq',$c_id),
                'del'=>array('eq',0)
            ))
            ->limit($p->firstRow, $p->listRows)
            ->select();

        if($data){

            foreach($data as $k=>$v){
                if($v['is_record']==1){
                    $data[$k]['is_record'] = '已备案';
                }else{
                    $data[$k]['is_record'] = '未备案';
                    $data[$k]['equity_number'] = '--';
                }
            }

            $this->ajaxReturn(array('status'=>1,'msg'=>'获取备案信息成功','data'=>$data));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取备案信息失败',));
        }


    }




//    public function file_download(){
//        if(!IS_POST)
//        {
//            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
//            $this->ajaxReturn($arr);
//        }
//        $id = I('id');
//        $files = M('file')->find($id);
//        $file = getcwd().$files['file'];
//        if(is_file($file)) {
//            header("Content-Type: application/force-download");
//            header("Content-Disposition: attachment; filename=".basename($file));
//            readfile($file);
//            exit;
//        }else{
//            echo "文件不存在！";
//            exit;
//        }
//    }


    /**
     * 通讯录接口 POST方式
     * @return json 状态值描述，返回通讯录信息
     */
    public function contact(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }
        $cid = session('memeberinfo.company_id');
        $uid = session('memeberinfo.uid');

        $data = M('users')
                ->field('uid as id,nicename,mobile')
                ->where(array(
                    'company_id'=>array('eq',$cid),
                    'del'=>array('eq',0),
                    'uid'=>array('neq',$uid)
                ))
                ->select();
        if($data){
            $this->ajaxReturn(array('status'=>1,'msg'=>'获取通讯录成功','data'=>$data));
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'获取通讯录失败',));
        }
    }

}