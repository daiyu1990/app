<?php
/**
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Think;
class LoginController extends Controller {

    public function check(){
        if (!IS_POST)
        {
            exit(json_encode(array('error'=>'非法操作！')));
        }
        # 验证码
        $verifycode = I('code');
        $verify = new \Think\Verify(array('reset'=>false));
        if(!empty($verifycode) && !$verify->check($verifycode)){
            exit(json_encode(array('error'=>'验证码错误！')));
        }
        exit(json_encode(array('ok'=>'')));
    }
    //后台注册
    public function register(){
        $this->title = '注册';
        $m = M('users');
        $do = I('do');
        if(IS_POST){

            if($do == 'send'){


                $users=D('Users')->where(array('username'=>I('mobile'),'del'=>0))->find();
                if($users){
                    $this->ajaxReturn(array('status'=>0,'msg'=>'该手机已被注册'));
                    exit();
                }

                $time = time();
                $code = rand(1000,9999);
                $send = sendTemplateSMS(I('mobile'),array($code,5),"1");
                if($send===true){
                    D('Users')->add(array('mobile'=>I('mobile'),'register_code'=>$code,'register_code_time'=>time()));
                    $this->ajaxReturn(array('status'=>1));
                    exit();
                }else{
                    $this->ajaxReturn(array('status'=>0,'msg'=>'发送失败，请重试'));
                    exit();
                }

            }
            if($do == 'check'){
                $info = $m->where(array('mobile'=>array('eq',I('mobile'))))->find();

                if(!$info){
                    exit(json_encode(array('msg'=>'该手机号错误，请重试','status'=>0)));
                }
                if($info['username'] == I('mobile')){
                    exit(json_encode(array('msg'=>'该手机号已被注册','status'=>0)));
                }

                $now = time();
                if($now-$info['register_code_time']>300){
                    $m->where(array('mobile'=>array('eq',I('mobile'))))->delete();
                    exit(json_encode(array('msg'=>'验证码已过期，请重新获取','status'=>0)));
                }

                if($info['register_code']!=I('code')){
                    exit(json_encode(array('msg'=>'验证码有误，请重新输入','status'=>0)));
                }

                $row = array(
                    'username'=>I('mobile'),
                    'type'=>1,
                    'status'=>0,
                    'check'=>1,
                    'active'=>1
                );



                if(I('pwd1') && I('pwd1')!=''){
                    $row['password'] = md5(I('pwd1').C('AUTH_kEY'));
                    $m->where(array('uid'=>array('eq',$info['uid'])))->save($row);
                }



                cookie('reg_uid',$info['uid']);
                cookie('reg_mobile',$info['mobile']);


                exit(json_encode(array('msg'=>'1','status'=>1)));
            }elseif($do == 'reg'){

                $is_reg = M('company')->where(array('company_code'=>array('eq',I('code')),'is_del'=>array('eq',0)))->find();
                if($is_reg){
                    exit(json_encode(array('msg'=>'该组织机构代码已被注册','status'=>0)));
                }

                $company_id = M('company')->add(array('name'=>I('company'),'company_code'=>I('code')));

                $row = array(
                    'company_id'=>$company_id,
                    'type'=>2,
                    'username'=>cookie('reg_mobile'),
                    'password'=>md5(I('pwd1').C('AUTH_kEY')),
                    'nicename'=>I('name'),
                    'email'=>I('email'),
                    'status'=>0
                );

                $rs = M('users')->where(array('uid'=>array('eq',cookie('reg_uid'))))->save($row);
//                dump($rs);
//                dump(M('users')->getlastsql());die;
                if($rs){
                    M('auth_group_access')->add(array('uid'=>cookie('reg_uid'),'group_id'=>22));
                    exit(json_encode(array('msg'=>'1','status'=>1)));
                }else{
                    exit(json_encode(array('msg'=>'注册失败，请重试','status'=>0)));
                }
            }
        }
        $getdata = D('Codetype')->getData(C('COMPANY_TYPE'));
        $this->company_type = D('Code')->getData($getdata);
        $this->display();
    }
    //后台登陆界面
    public function index() {
        $this->title = '登录';
        $userinfo = unserialize(cookie('userinfo'));//print_r($userinfo);die;
        if($userinfo){
            session('userinfo',$userinfo);
        }
        $uid = session('userinfo.uid');
        if($uid>0){//已经登录
            $url = D('Auth')->firstMenu();
            $this->redirect($url);
        }
        $do = I('do');
        if($do == 'login'){
//            dump(I('post.'));die;
            if (!IS_POST) {
                $this->ajaxReturn(array('status'=>0,'msg'=>'无权限操作'));
            }
            if (!D('User')->autoCheckToken($_POST)){
                $this->ajaxReturn(array('status'=>0,'msg'=>'非法操作'));
            }
//            $this->ajaxReturn(array('status'=>0,'msg'=>'13'));

            $username = I('post.username');
            $password = I('post.password');
//            $verify   = I('post.code');
            $ip = get_Ip();
            $result = D('user')->login(array('username'=>$username,'password'=>$password,'ip'=>$ip,'verify'=>$verify));
            if($result['state'] == 1){
                $ison = I('ison');
                if($ison){
                    $userinfo = D('User')->where(array('username'=>$username))->find();
                    $d = D('Access')->where(array('uid'=>$userinfo['uid']))->find();
                    $userinfo['groupid'] = $d['group_id'];
                    cookie('userinfo',serialize($userinfo));
                }
                $url = U('Index/index');
                $this->ajaxReturn(array('status'=>1,'url'=>$url));
            } else {
                $this->ajaxReturn(array('status'=>0,'msg'=>$result['msg']));
                // $this->error($result['msg'],U('Login/index'));
            }
            exit();
        }
        $this->display();
    }

    public function logout(){
        // foreach ($_SESSION as $k => $v) {
        //        unset($_SESSION[$k]);
        //    }
        cookie('userinfo',null);
        session(null);
        $this->redirect("Login/index");
    }
    public function set_pid(){
        if(!IS_GET){
            $this->error('请求方式有误');
            exit();
        }
        if(session('userinfo.uid') == 0){
            $this->success('请先登录系统！');
            exit();
        }
        if(I('pid')){
            $groupid = session('userinfo.groupid');
            switch ($groupid) {
                case 3:
                    $userinfo['pid'] = I('pid');
                    $user = D('Admin/Distributor')->where(array('uid'=>session('userinfo.uid')))->find();
                    session('memberinfo',$user);
                    $brandinfo = D('Admin/Brand')->where(array('id'=>$user['pid']))->find();
                    session('brandinfo',$brandinfo);
                    break;
                case 4:
                    $userinfo['pid'] = I('pid');
                    $user = D('Admin/Sales')->where(array('uid'=>session('userinfo.uid')))->find();
                    session('memberinfo',$user);
                    $brandinfo = D('Admin/Brand')->where(array('id'=>$user['brand_id']))->find();
                    session('brandinfo',$brandinfo);
                    break;
                default:
                    # code...
                    break;
            }
            // $_SESSION['']
            session('userinfo.brand_id',I('pid'));
            $this->success('品牌选择成功',U('Member/Story/index'));
        }
    }
    public function forgot(){
        $this->title = '忘记密码';
        $do = I('do');
        if($do == 'send'){


//            if(I('mobile')==1){
//                $this->ajaxReturn(array('status'=>0,'msg'=>'该还未注册'));die;
//            }else{
//                $this->ajaxReturn(array('status'=>1));die;
//            }

            $users=D('Users')->where(array('username'=>I('mobile'),'del'=>0))->find();
            if(!$users){
                $this->ajaxReturn(array('status'=>0,'msg'=>'该手机还未注册'));
                exit();
            }

            $time = time();
            $code = rand(1000,9999);
            $send = sendTemplateSMS(I('mobile'),array($code,5),"1");
            if($send===true){
                D('Users')->where(array('uid'=>$users['uid']))->save(array('phone_code'=>$code,'code_time'=>$time));
                $this->ajaxReturn(array('status'=>1));
                exit();
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'发送失败，请重试'));
                exit();
            }

        }elseif($do == 'check'){
            $users=D('Users')->where(array('mobile'=>I('mobile')))->find();


            if(!$users){
                $this->ajaxReturn(array('status'=>0,'msg'=>'该手机还未注册'));
                exit();
            }

            if(empty($users['phone_code'])){
                $this->ajaxReturn(array('status'=>0,'msg'=>'请先点击按钮获取验证码'));
                exit();
            }
            $time = time();
            $time = (int)$time - (int)$users['code_time'];

            if($time>300){
                D('Users')->where(array('mobile'=>I('mobile')))->save(array('code_time'=>''));
                $this->ajaxReturn(array('status'=>0,'msg'=>'验证码已过期，请重新获取验证码'));
                exit();
            }

            if(I('code')!=$users['phone_code']){
                $this->ajaxReturn(array('status'=>0,'msg'=>'验证码错误，请重新输入'));
                exit();
            }

            D('Users')->where(array('mobile'=>I('mobile')))->save(array('is_forget_pwd'=>1));
            $this->ajaxReturn(array('status'=>1));
            exit();

        }elseif($do == 'change_pwd'){
            if(strlen(I('pwd1'))<6){
                $this->ajaxReturn(array('status'=>0,'msg'=>'密码长度至少6位'));
                exit();
            }
            if(I('pwd1')!=I('pwd2')){
                $this->ajaxReturn(array('status'=>0,'msg'=>'两次密码输入不一致'));
                exit();
            }

            $users=D('Users')->where(array('mobile'=>I('mobile')))->find();
            if($users['is_forget_pwd']==0){
                $this->ajaxReturn(array('status'=>0,'msg'=>'非法操作'));
                exit();
            }

            $password = md5(I('pwd1').C('AUTH_kEY'));

            D('Users')->where(array('mobile'=>I('mobile')))->save(array('password'=>$password,'is_forget_pwd'=>0,'phone_code'=>'','code_time'=>''));

            $this->ajaxReturn(array('status'=>1));
            exit();
        }
        $this->display();
    }

    public function resetpw(){
        $this->title = '重设密码';
        if(IS_POST){
            if (!M()->autoCheckToken($_POST)){
                $this->error('非法操作！');
            }
            $returnurl = $_SERVER['HTTP_REFERER'];
            $url_info = M('resetpass_site')->where(array('url'=>$returnurl))->find();
            if(!$url_info){
                $this->error('非法操作！',U('Login/index'));
                exit();
            }
            if($url_info && $url_info['cz_num']>0){
                $this->error('此URL只能使用一次！',U('Login/index'));
                exit();
            }
            if(empty($_SESSION['u'])){
                $this->error('无权限操作！',U('Login/index'));
                exit();
            }
            $password = I('password');
            $password2 = I('password2');
            if($password!=$password2){
                $this->error(l('pwd_diff'));
                exit();
            }
            $data['password']=md5($password . C('AUTH_KEY'));
            if(M('users')->where(array('username'=>$_SESSION['u']))->setField(array('password'=>$data['password']))!==false)
            {
                unset($_SESSION['u']);
                M('resetpass_site')->where(array('id'=>$url_info['id']))->setInc('cz_num');
                $this->success('操作成功！',U('Login/index'));
            }
            exit();
        }
        $returnurl = C('HOST_MAIN').$_SERVER['REQUEST_URI'];
        $url_info = M('resetpass_site')->where(array('url'=>$returnurl))->find();
        if(empty($url_info)){
            $this->error(l('no_permission').l('access'),U('Login/index'));
            exit();
        }
        if(!empty($url_info) && $url_info['cz_num']>0){
            $this->error(l('url_use_one'),U('Login/index'));
            exit();
        }
        if(!I('p')){
            $this->error(l('no_permission').l('access'),U('Login/index'));
            exit();
        }
        $array = explode(',',base64_decode(I('p')));
        $user=M('users')->where(array('username'=>trim($array[0])))->find();
        $checkcode=md5($user['username'].'+'.$user['password'].'+'.$array[2]);
        if($checkcode!=$array[1]){
            $this->error(l('no_permisssion').l('access'),U('Login/index'));
            exit();
        }else{
            $_SESSION['u']=$user['username'];
            $this->assign('user',$user);
            $this->display();
        }
    }

    public function verify(){
        ob_clean();
        $Verify = new \Think\Verify(array('fontttf'=>'6.ttf','fontSize'=>15,'imageH'=>46,'length'=>4,'useCurve'=>false,'useNoise'=>false,'bg'=>array(255,255,255),'reset'=>false));
        $Verify->entry();
    }

//    public function test(){
//
//        $str = sendTemplateSMS("18637138796",array('1234','30'),"1");
//        dump($str);
//    }
}