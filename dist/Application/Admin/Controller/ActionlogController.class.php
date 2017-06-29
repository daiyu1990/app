<?php
/**
 * @Author: Sincez
 * @Date:   2016-06-02 21:57:45
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-01-05 16:07:07
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class ActionlogController extends AdminController
{
    public function index(){    //name:操作日志 
        $this->title = '操作日志';
        $do = I('do');
        if($do == 'listTableData'){
            $sdate = I('sdate');
            $edate = I('edate');
            $uid = session('userinfo.uid');
            $data = array('sdate'=>$sdate,'edate'=>$edate);
            $lists = D('Actionlog')->getData($data);
            foreach($lists as $k=>$v){
                $result[] = array('',$v['createtime'],$v['username'],'<div style="word-break: break-all;width:60%;margin:0 auto;">'.$v['remark'].'</div>');
            }
            $backData = array('data'=>$result?$result:array());
            $this->ajaxReturn($backData);
        }
        $this->display();
    }
    public function loginLog(){     //name:登录日记
        $this->title = '登录日志';
        $uid = I('uid');
        $do = I('do');
        if($uid)
        {
            $this->uid = $uid;
        }else{
            $this->uid = 0;
        }
        if($do == 'listTableData'){
            $lstate = C('LOGIN_STATE');
            $sdate = I('sdate');
            $edate = I('edate');
            $uid = I('uid');

            $data = array('sdate'=>$sdate,'edate'=>$edate);
            if($uid){
                $data['uid'] = $uid;
            }

            $lists = D('Loginlist')->getData($data);
            $i = 1;
            foreach($lists as $k=>$v){
                $result[] = array($k+1,date('Y-m-d H:i:s',$v['add_time']),$v['username'],$lstate[$v['state']]);
            }
            $backData = array('data'=>$result?$result:array());
            $this->ajaxReturn($backData);
        }
        $this->display();

    }
}