<?php

namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class IndexController extends AdminController {
    public function index()
    {       //name:后台首页
        $this->title = '首页';
        $this->user = session('userinfo');   
        $this->display();
    }
    public function base(){     //name:系统设置
    	$this->title = '系统设置';
        $do = I('do');
        if($do == 'save'){
            $row['system_name'] = I('post.system_name');
            $add_time = time();
            $p = C('UPLOAD_PATH');
            if(!file_exists($p)){
                @mkdir($p,0777);
                // chmod($p,'0777');
            }
            if($_FILES['logo']['error'] != 4){
                $upload = new \Think\Upload();  // 实例化上传类
                $upload->maxSize = 31457280;    // 设置附件上传大小  30M
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
                $upload->rootPath = C('UPLOAD_PATH'); // 非公开资源上传目录
                $upload->subName = 'logo';
                $upload->saveName = array('uniqid','');
                $upload->replace = true;
                $upload->autoSub  = true;
                $upload->subName  = array('date','Ymd');
                $info = $upload->uploadOne($_FILES['logo']);
                $img = C('UPLOAD_PATH_ROOT') . $info['savepath'] . $info['savename'];
                $row['logo'] = $img;
            }
            $uid = session('userinfo.uid');
            foreach($row as $k=>$v){
                D('Base')->where(array('uid'=>$uid,'code'=>$k))->delete();
                D('Base')->add(array('code'=>$k,'val'=>$v,'uid'=>$uid,'add_time'=>$add_time));
            }
            // $content = '修改系统设置：【'.$row['name'].' '.$row['phone'].'】';
            // action_log($content);
            $this->redirect('Index/index');
            exit();
        }
        $this->info = D('Base')->getInfo();
        $this->display();
    }

}
