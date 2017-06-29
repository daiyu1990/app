<?php
namespace Common\Controller;
use Think\Controller;
use Think\Auth;
class AdminController extends Controller {
    public function _initialize(){
        //parent::__construct();
		if(constant('APP_PHPUNIT'))return;
        //验证登陆,没有登陆则跳转到登陆页面
		$uid = session('userinfo.uid');
		if(empty($uid)){
            if(IS_AJAX){
                $this->ajaxReturn(array('status'=>'0','msg'=>L('session_out')));
            } else {
                $this->redirect('Login/index');
            }
            
        }
        $lasttime = session('last_access');
        if(!empty($lasttime) && (time()-session('last_access'))>3600){
            session(null);
            $this->redirect('Login/index');
        } else {
            session('last_access',time());
            // $_SESSION['last_access'] = time();
        }
        $baseinfo = D('Base')->where(array('code'=>'system_name'))->find();
        if($baseinfo['val']){
            C('SYSTEM_TITLE',$baseinfo['val']);
        }
        
        $cur = MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME;
		//权限验证
		if(!authCheck($cur,session('userinfo.uid')) && !in_array(session('userinfo.uid'),C('ADMINISTRATOR'))){
            // foreach ($_SESSION as $k => $v) {
            //     unset($_SESSION[$k]);
            // }
            session(null);
            cookie('userinfo',null);
            $this->error('无权限操作！ !',U('Login/index'));
        }
	}

}