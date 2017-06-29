<?php
/**
 * Created by coder meng.
 * User: 设备管理
 * Date: 2017/3/15 14:55
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class WarningController extends AdminController
{


    public function index(){


        $do = I('do');
        if($do == 'refresh') {
            $ter = I('ter');
            $ter = explode(',',$ter);

            $terminal_number=array();
            foreach($ter as $k=>$v){
                $terminal_number[]['terminal_number'] = $v;
            }
            $data = D('Warning')->getData(true,$terminal_number);
            $info = $data['info'];
            exit(json_encode($info));
            die;

        }elseif($do == 'get_warning'){
            $terminal = substr(I('terminal'),0,strlen(I('terminal'))-1);
            $terminal = explode(',',$terminal);

            $time = I('time');
            if($time==1){
                $time=date('Y-m-d');
                $type = 'day';
            }elseif($time==7){
                $time=strtotime(date('Y-m-d 00:00:00'))-(86400*6);
                $time = date('Y-m-d H:i:s',$time);
                $type = 'week';
            }elseif($time==30){
                $time=strtotime(date('Y-m-d 00:00:00'))-(86400*30);
                $time = date('Y-m-d H:i:s',$time);
                $type = 'month';
            }

            $data = D('Warning')->getWarning($terminal,$time,$type);

            exit(json_encode($data));
            die;
        }



//        $time = strtotime(date('Y-m-d'))-86400;
//        echo $time;
//        dump(time());die;


        $data = D('Warning')->getData(false,0);

//        dump($data);die;
        $info = $data['info'];
        $count = $data['count'];

//        dump($info);die;
        $this->info = $info;
        $this->count = $count;
        $this->title = '实时数据';
        $this->display();
    }
    
    public function data(){

        $do = I('do');
        if($do == 'refresh') {
            $ter = I('ter');
            $ter = explode(',',$ter);

            $terminal_number=array();
            foreach($ter as $k=>$v){
                $terminal_number[]['terminal_number'] = $v;
            }
            $data = D('Warning')->getData(true,$terminal_number);
            $info = $data['info'];
            exit(json_encode($info));
            die;

        }elseif($do == 'get_warning'){
            $terminal = substr(I('terminal'),0,strlen(I('terminal'))-1);
            $terminal = explode(',',$terminal);

            $time = I('time');
            if($time==1){
                $time=date('Y-m-d');
                $type = 'day';
            }elseif($time==7){
                $time=strtotime(date('Y-m-d 00:00:00'))-(86400*6);
                $time = date('Y-m-d H:i:s',$time);
                $type = 'week';
            }elseif($time==30){
                $time=strtotime(date('Y-m-d 00:00:00'))-(86400*30);
                $time = date('Y-m-d H:i:s',$time);
                $type = 'month';
            }

            $data = D('Warning')->getWarning($terminal,$time,$type);

            exit(json_encode($data));
            die;
        }



//        $time = strtotime(date('Y-m-d'))-86400;
//        echo $time;
//        dump(time());die;


        $data = D('Warning')->getData(false,0);

//        dump($data);die;
        $info = $data['info'];
        $count = $data['count'];

//        dump($info);die;
        $this->info = $info;
        $this->count = $count;
        $this->display();
    }


	public function warning(){
		$this->display();
	}
	
	public function monitor(){
		$this->display();
	}

}