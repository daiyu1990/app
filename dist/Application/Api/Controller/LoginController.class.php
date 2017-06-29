<?php
/**
 * @Author: Sincez
 * @Date:   2017-06-20 09:37:59
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-06-20 09:44:46
 */
namespace Api\Controller;
use Common\Controller\ApiController;

class LoginController extends ApiController
{
	/**
	 * 验证码接口 POST方式
	 * @return json 状态值描述，返回图片base64码
	 */
	public function verify_code(){
		ob_clean();
        $Verify = new \Think\Verify(array('fontttf'=>'6.ttf','fontSize'=>15,'imageH'=>46,'length'=>4,'useCurve'=>false,'useNoise'=>false,'bg'=>array(255,255,255),'reset'=>false));
        $imgbase64Code = $Verify->entry2();
        // $_SESSION['code'] = 1234;
        $arr = array('status'=>1,'img'=>$imgbase64Code,'scode'=>serialize($_SESSION));
        $this->ajaxReturn($arr);
	}

    /**
     * 登出接口 POST方式
     * @return json 状态值描述，
     */
	public function logout(){

		if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        cookie('PHPSESSID', null);
        session('memberinfo', null);
        cookie('memberinfo', null);

        $json = array(
            'status' => 1,
            'msg' => '退出登录成功'
        );
        $this->ajaxReturn($json);
	}


    /**
     * 登录接口 POST方式
     * @return json 状态值描述，返回登录状态
     */
    public function login(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $username = I('username');
        $password = I('password');
        $code = I('code');

        $json = array();
        $verify = new \Think\Verify();
        if(!empty($code) && !$verify->check($code)){

            $json['status'] = 0;
            $json['msg'] = '验证码错误';

        }else{

            $user = M('users')->where(array('username'=>array('eq',$username),'del'=>array('neq',1)))->find();

            if(!$user || $user['password']!=md5($password.C('AUTH_kEY'))){
                $json['status'] = 0;
                $json['msg'] = '用户名或密码错误';
            }else{
                $json['status'] = 1;
                $json['msg'] = '登录成功';

                session('memberinfo',$user);
            }
        }


        $this->ajaxReturn($json);

    }


    /**
     * 短信验证码接口 POST方式
     * @return json 状态值描述，返回发送验证码结果
     */
    public function sendMsgCode(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }
        $mobile = I('mobile');

        $user=M('users')->where(array('username'=>I('mobile'),'del'=>0))->find();
        if($user){
            $this->ajaxReturn(array('status'=>0,'msg'=>'该手机已被注册'));
            exit();
        }

        $time = time();
        $code = rand(1000,9999);
        $send = sendTemplateSMS(I('mobile'),array($code,5),"1");
        if($send===true){
            M('users')->add(array('mobile'=>I('mobile'),'register_code'=>$code,'register_code_time'=>time()));
            $this->ajaxReturn(array('status'=>1,'msg'=>'发送成功'));
            exit();
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'发送失败，请重试'));
            exit();
        }
    }


    /**
     * 个人注册接口 POST方式
     * @return json 状态值描述，返回个人注册结果
     */
    public function person_register(){

        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $mobile = I('mobile');
        $msgcode = I('msgcode');
        $password1 = I('password1');
        $password2 = I('password2');

        $info = M('users')->where(array('mobile'=>array('eq',$mobile),'del'=>array('eq',0)))->find();

        if(!$info){
            $this->ajaxReturn(array('msg'=>'该手机号错误，请重试','status'=>0));
        }
        if($info['username'] == $mobile){
            $this->ajaxReturn(array('msg'=>'该手机号已被注册','status'=>0));
        }

        $now = time();
        if($now-$info['register_code_time']>300){
            M('users')->where(array('mobile'=>array('eq',$mobile)))->delete();
            $this->ajaxReturn(array('msg'=>'验证码已过期，请重新获取','status'=>0));
        }

        if($info['register_code']!=$msgcode){
            $this->ajaxReturn(array('msg'=>'验证码有误，请重新输入','status'=>0));
        }

        if($password1!=$password2){
            $this->ajaxReturn(array('msg'=>'两次密码输入不一致','status'=>0));
        }

        $row = array(
            'username'=>$mobile,
            'type'=>1,
            'password'=>md5($password1.C('AUTH_kEY')),
            'status'=>0,
            'check'=>1,
            'active'=>1,
            'create_time'=>date('Y-m-d H:i:s')
        );

        M('users')->where(array('uid'=>array('eq',$info['uid'])))->save($row);

        $this->ajaxReturn(array('msg'=>'注册成功','status'=>1));

    }

    /**
     * 企业注册接口 POST方式
     * @return json 状态值描述，返回个人注册结果
     */
    public function company_register(){
        if(!IS_POST)
        {
            $arr = array('status'=>0, 'msg'=>'请求方式错误！');
            $this->ajaxReturn($arr);
        }

        $mobile = I('mobile');
        $msgcode = I('msgcode');
        $password1 = I('password1');
        $password2 = I('password2');
        $company_name = I('company_name');
        $code = I('code');
        $name = I('name');
        $email = I('email');

        $info = M('users')->where(array('mobile'=>array('eq',$mobile),'del'=>array('eq',0)))->find();

        if(!$info){
            $this->ajaxReturn(array('msg'=>'该手机号错误，请重试','status'=>0));
        }

        if($info['username'] == $mobile){
            $this->ajaxReturn(array('msg'=>'该手机号已被注册','status'=>0));
        }

        $now = time();
        if($now-$info['register_code_time']>300){
            M('users')->where(array('mobile'=>array('eq',$mobile)))->delete();
            $this->ajaxReturn(array('msg'=>'验证码已过期，请重新获取','status'=>0));
        }

        if($info['register_code']!=$msgcode){
            $this->ajaxReturn(array('msg'=>'验证码有误，请重新输入','status'=>0));
        }

        if($password1!=$password2){
            $this->ajaxReturn(array('msg'=>'两次密码输入不一致','status'=>0));
        }

        $is_reg = M('company')->where(array('company_code'=>array('eq',$code),'is_del'=>array('eq',0)))->find();
        if($is_reg){
            exit(json_encode(array('msg'=>'该组织机构代码已被注册','status'=>0)));
        }

        $company_id = M('company')->add(array('name'=>$company_name,'company_code'=>$code));

        $row = array(
            'company_id'=>$company_id,
            'type'=>2,
            'username'=>$mobile,
            'password'=>md5($password1.C('AUTH_kEY')),
            'nicename'=>$name,
            'email'=>$email,
            'status'=>0
        );

        $rs = M('users')->where(array('uid'=>array('eq',$info['uid'])))->save($row);

        if($rs){
            M('auth_group_access')->add(array('uid'=>$info['uid'],'group_id'=>22));
            exit(json_encode(array('msg'=>'1','status'=>1)));
        }else{
            exit(json_encode(array('msg'=>'注册失败，请重试','status'=>0)));
        }

        $this->ajaxReturn(array('msg'=>'注册成功','status'=>1));
    }


}