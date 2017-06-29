<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class UserController extends AdminController{
	protected $users_model,$role_model;

	function _initialize() {
        parent::_initialize();
		$this->users_model = D('User');
		$this->role_model = M("auth_group");
        $this->status = C('DEL_STATUS');
	}

    public function resetPass(){    //name:重置密码
        $uid = I('uid');
        if(!$uid){
            exit(json_encode(array('status'=>0,'msg'=>'请选择要重置密码的用户！')));
        }
        $groupid = session('userinfo.groupid');
        $brandid = session('userinfo.brand_id');
        if($groupid == 2){
            $disinfo = D('Distributor')->where(array('uid'=>$uid,'pid'=>$brandid))->find();
            if(!$disinfo){
               exit(json_encode(array('status'=>0,'msg'=>'请选择要重置密码的用户！'))); 
            }
        } elseif($groupid == 3){
            $saleinfo = D('Sales')->where(array('uid'=>$uid,'brand_id'=>$brandid))->find();
            if(!$saleinfo){
               exit(json_encode(array('status'=>0,'msg'=>'请选择要重置密码的用户！'))); 
            }
        }
        $password = md5('888888'.C('AUTH_KEY'));
        $this->users_model->where(array('uid'=>$uid))->save(array('password'=>$password));
        $content = '重置密码【用户UID：'.$uid.'】';
        action_log($content);
        exit(json_encode(array('status'=>1,'msg'=>'密码已经重置为888888！')));
    }   

	public function index(){	//name:用户管理
        $this->title = '用户管理';
        $do = I('do');
        if($do == 'setStatus'){
            $id = I('target');
            $where = array('uid'=>$id);
            $one = $this->users_model->where($where)->find();
            $this->users_model->where($where)->save(array('status'=>$one['status']?0:1));
            exit('ok');
        } elseif($do == 'listTableData'){
            // $where['del'] = 0;
            $groups = D('Group')->select();
            $groups = array_coltokey($groups,'id');
            $status = I('start_stop',-1);
            if($status>-1){
                $where['del'] = $status;
            }
            $groupid = I('group_id',0);
            if($groupid){
                $where[C('DB_PREFIX').'auth_group_access.group_id'] = $groupid;
            }
            $group_id = session('userinfo.groupid');
            if($group_id != 1){
                $where['from'] = session('userinfo.uid');
//                $where[C('DB_PREFIX').'users.uid'] = session('userinfo.uid');
                $where['_logic'] = 'and';
            }
            $users = $this->users_model->field(C('DB_PREFIX')."users.*,".C('DB_PREFIX')."auth_group_access.group_id")
                ->join(C('DB_PREFIX')."auth_group_access on ".C('DB_PREFIX')."users.uid=".C('DB_PREFIX')."auth_group_access.uid",'left')
                ->where($where)
                ->order("create_time DESC")
                ->select();
            $key = count($users);
            unset($where['from']);
            $where[C('DB_PREFIX').'users.uid'] = session('userinfo.uid');
            $users[$key]=M('users')->where($where)->find();
//                 echo $this->users_model->getLastsql();die;
            foreach($users as $k=>$v){
                $lasttime = $v['lasttime']?date('Y-m-d H:i:s',$v['lasttime']):'';
                $create_time = $v['create_time']?date('Y-m-d',strtotime($v['create_time'])):'';
                $operate = create_Url('Admin/Actionlog/loginLog','查看登录日志',array('uid'=>$v['username']),'class="m-r-5"');
                $operate .= create_Url('Admin/User/resetPass','重置密码',array('uid'=>$v['uid']),'class="m-r-5 reset"');
                if($v['group_id']!=2 && $v['group_id']!=3 && $v['group_id']!=4){
                    $operate .= create_Url('Admin/User/edit','编辑',array('uid'=>$v['uid']),'class="m-r-5"'); 
                }
                $operate .= create_Url('Admin/User/del',$v['del']==0?'归档':'恢复',array('uid'=>$v['uid']),' class="del"');
                $result[] = array($v['uid'],$v['username'],getGroupName($v['group_id'],$groups),$v['email'],$v['mobile'],$create_time,$lasttime,$operate);
            }
            $backData = array('data'=>$result?$result:array());
            exit(json_encode($backData));

        }
        $this->groups = D('Group')->where(array('del'=>0))->select();
		$this->display();
	}

    public function company(){
        $this->title = '公司列表';

        $getdata = D('Codetype')->getData(C('COMPANY_TYPE'));
        $this->company_type = D('Code')->getData($getdata);

        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');
            $info = D('company')->getData($row);

            foreach($info as $k=>$v){

                if($v['status']!=3){
                    break;
                }
                foreach($this->company_type as $k1=>$v1){
                    if($v1['val'] == $v['type']){
                        $v['type'] = $v1['name'];
                        break;
                    }
                }

                $operate = '';

                $operate .= create_Url('Admin/User/company','确定',array('id'=>$v['id'],'do'=>'chose'),'class="m-r-5 company"');

                $result[] = array($v['id'],$v['company_code'],$v['name'],$v['type'],$v['jiancheng'],$operate);
            }
            $backData = array('data'=>$result?$result:array());
            exit(json_encode($backData));

        }elseif($do == 'chose'){
            $id = I('id');
            $data = M('company')->find($id);
            exit(json_encode($data));
        }
        $this->display();
    }

	public function add(){      //name:用户添加
//        dump(session());die;
        $this->title = '添加用户';
        $do = I('do');
        if(empty($do)){
//            $groups = D('group')->where(array('del'=>0,'id'=>array('not in',array('2','3','4'))))->select();
            $groups = D('Company')->get_group(session()['userinfo']['company_id']);
            $this->groups = $groups;
        } elseif($do == 'getRoles'){
            $uid = session('userinfo.uid');
            $roles = D('Group')->select();
            $this->ajaxReturn($roles);
        } elseif($do == 'check'){
            $username = I('username');
            if(!empty($username)){
                $where['username'] = $username;
                $msg = '用户名';
            }
            $email = I('email');
            if(!empty($email)){
                $where['email'] = $email;
                $msg = '邮箱';
            }
            $mobile = I('mobile');
            if(!empty($mobile)){
                $where['mobile'] = $mobile;
                $msg = '该手机号码';
            }
            $uid = intval(I('uid',0));
            if($uid){
                $where['uid'] = array('NEQ',$uid);
            }
            $user = D('user')->where($where)->find();
            if(!$user){
                exit(json_encode(array('ok'=>'')));
            } else {
                exit(json_encode(array('error'=>$msg.'已存在！')));
            }
        }elseif($do == 'upload'){
            $oldimg = I('oldimg');
            if($oldimg!='/Public/IDcard/index_img/default.png')
            {
                unlink('.'.$oldimg);
            }
            $p = 'Public/Uploads/IDcard/';
            if(!file_exists($p))
            {
                @mkdir($p,0777);
            }
            $file_name = I('file_name');
            $maxsize = 31457280;
            $upload = new \Think\Upload();
            $upload->maxSize = $maxsize;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
//            $upload->rootPath = $p;

            $upload->rootPath = $p; // 非公开资源上传目录
            $upload->savepath = 'news';

            $upload->subName = $file_name;
            $upload->saveName = array('uniqid','');
            $upload->replace = true;
            $upload->autoSub  = true;
            $info = $upload->uploadOne($_FILES[$file_name]);
            if(!$info)
            {
                exit(json_encode(array('status'=>0,'msg'=>$upload->getError())));
            }
            $img ='/'. $p . $info['savepath'] . $info['savename'];
            exit(json_encode(array('status'=>1,'img'=>$img)));
        }elseif($do == 'get_group'){
            $groups = D('Company')->get_group(I('company_id'));
//            dump($groups);
            if($groups){
                exit(json_encode(array('status'=>1,'data'=>$groups)));
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'获取角色失败，请稍后再试')));
            }

        }elseif($do == 'save') {
            if (!D('User')->autoCheckToken($_POST)){
                $this->error('非法操作！');
                exit();
            }

//            dump(I('post.'));die;
            $row = I('post.');
            unset($row['do']);
            if(!$row['username']){
                $this->error('用户名不能为空！');
                exit();
            }
            if(!$row['email']){
                 $this->error('邮箱不能为空！');
                 exit();
            }
            if(!$row['password']){
                 $this->error('登录密码不能为空！');
                 exit();
            }
            if($row['password']!=$row['repassword']){
                 $this->error('两次输入密码不一致！');
                 exit();
            }
            // if(!$row['mobile']){
            //      $this->error('密码不能为空！');
            // }
            unset($map);
            $map['username']  =   $username;
            // $map['mobile']  =   $username;
            // $map['email']   =   $username;
            // $map['_logic']  =   'or';    
            $ucount = D('user')->where($map)->count();
            if($ucount){
                $this->error('用户已存在！');
                exit();
            }
            $row=array(
                'username'=>I('username'),
                'password'=>md5(I('password').C('AUTH_kEY')),
                'nicename'=>I('nicename'),
                'zizhi'=>I('zizhi'),
                'IDcard'=>I('IDcard'),
                'IDcard_zheng'=>I('picpath'),
                'IDcard_fan'=>I('picpath1'),
                'person_code'=>I('person_code'),
                'address'=>I('address'),
                'email'=>I('email'),
                'mobile'=>I('mobile'),
                'create_time'=>date('Y-m-d H:i:s'),
                'from'=>session()['userinfo']['uid'],

            );
            if(I('company_id') && !empty(I('company_id'))){
                $row['company_id']=I('company_id');
            }else{
                $row['company_id']=session()['userinfo']['company_id'];
            }

            $id = M('users')->add($row);
            if($id){
                $group = array(
                  'uid'=>$id,
                  'group_id'=>I('groups')
                );

                M('auth_group_access')->add($group);
            }else{
                $this->error('添加失败！');
            }
            action_log('添加用户：【 用户名：'.$row['username'].'】');
            $this->redirect('User/index');
            // $this->success('添加用户成功！');
            exit();
        }
        $company = M('company')->where(array('is_del'=>array('eq','0')))->select();
        $this->assign('company',$company);
        $this->display();
    }

    public function edit(){     //name:用户编辑
        $this->title = '编辑用户';
        $do = I('post.do');
        if(empty($do)){
            $uid = I('get.uid');
//            $groups = D('group')->where(array('del'=>0,'id'=>array('not in',array('2','3','4'))))->select();
//            $groups = D('group')->where(array('del'=>0))->select();


            $this->info = D('User')->where(array('uid'=>$uid))->find();

            $company_name = M('company')->find($this->info['company_id']);


            $this->info_company_name = $company_name['name'];

            $groups = D('Company')->get_group($this->info['company_id']);
//            dump(D('Company')->getlastsql());die;

            $this->groups = $groups;
            $result = D('Access')->where(array('uid'=>$uid))->select();
            $this->result = array_coltoarray($result,'group_id');
            $curuid = session('userinfo.uid');
//            if($uid != $curuid && in_array(1,$this->result)){
//                $this->error('无权限修改其他用户信息！');
//            }
        } elseif($do == 'save') {
            if (!D('User')->autoCheckToken($_POST)){
                $this->error('非法操作！');
            }
            $row = I('post.');

            $row['uid'] = I('post.uid');
            $curuid = session('userinfo.uid');
//            if($row['uid'] != $curuid && in_array(1,$row['groups'])){
//                $this->error('无权限修改其他用户信息！');
//                exit();
//            }
            $userinfo = $this->users_model->find($row['uid']);
            if($userinfo['username']!=$row['username']){
                $count = $this->users_model->where(array('username'=>$userinfo['username']))->count();
                if($count>0){
                    $this->error('用户名已存在！');
                    exit();
                }
            }


            if($row['password'] && $row['password']!=$row['repassword']){
                $this->error('两次输入密码不一致！');
                exit();
            }

            $row=array(
                'username'=>I('username'),
                'nicename'=>I('nicename'),
                'zizhi'=>I('zizhi'),
                'IDcard'=>I('IDcard'),
                'person_code'=>I('person_code'),
                'address'=>I('address'),
                'email'=>I('email'),
                'mobile'=>I('mobile'),

            );
            if(I('company_id') && !empty(I('company_id'))){
                $row['company_id']=I('company_id');
            }else{
                $row['company_id']=session()['userinfo']['company_id'];
            }

            if(!empty(I('picpath'))){
                $row['IDcard_zheng']=I('picpath');
            }
            if(!empty(I('picpath1'))){
                $row['IDcard_fan']=I('picpath1');
            }

            array_filter($row);


            $res = M('users')->where(array('uid'=>array('eq',I('uid'))))->save($row);

//            dump($res);
//            dump(M('users')->getlastsql());die;
            if($res !==false){
                M('auth_group_access')->where(array('uid'=>array('eq',I('uid'))))->save(array('group_id'=>I('groups')));
            }else{
                $this->error('编辑失败 ！');
            }
            $username = $row['username'];

            action_log('编辑用户：【 用户名：'.$username.'】');
//            $this->redirect('User/index');
             $this->success('编辑用户成功！','/User/index');
            exit();
        }
        $company = M('company')->where(array('is_del'=>array('eq','0')))->select();
        $this->assign('company',$company);
        $this->display('add');
    }

    public function del(){      //name:用户删除
        $uid = I('get.uid');
        if(!$uid){
            exit(json_encode(array('state'=>0,'msg'=>'请选择要删除的记录')));
        }
        if($uid == 1){
            exit(json_encode(array('state'=>0,'msg'=>'系统用户不能删除！')));
        }
        $user = D('user')->where(array('uid'=>$uid))->find();
        if($user['del']){
            D('user')->where(array('uid'=>$uid))->save(array('del'=>0));
            action_log('恢复用户：【 用户名：'.$user['username'].'】');
        } else {
            D('user')->where(array('uid'=>$uid))->save(array('del'=>1));
            action_log('删除用户：【 用户名：'.$user['username'].'】');
        }
        // D('user')->where(array('uid'=>$uid))->save(array('del'=>1));
        // // D('access')->where(array('uid'=>$uid))->delete();
        //  action_log('删除用户：【 用户名：'.$user['username'].'】');
        exit(json_encode(array('state'=>1)));
    }

    public function modifypass(){   //name:修改密码
        $this->title = '修改密码';
        $do = I('do');
        $group_arr = array('3','4');
        $this->group_arr = $group_arr;
        $group_id = session('userinfo.groupid');
        if(IS_POST && empty($do)){
            $type = I('type');
            if($type == 'pay' && !in_array($group_id,$group_arr)){
                exit(json_encode(array('status'=>0,'error'=>'无权修改！')));
            }
            $old = I('old');
            $password = md5($old.C('AUTH_KEY'));
            $where['username'] = session('userinfo.username');
            $user = D('User')->where($where)->find();
            $pay_password = I();
            if(($type == 'login' && $user['password']!=$password) || ($type == 'pay' && $user['pay_password'] != $password)){
                exit(json_encode(array('status'=>0,'error'=>'原始密码错误！')));
            }
            exit(json_encode(array('ok'=>'')));
        }
        if(IS_POST && $do == 'save'){
            $type = I('type');
            $group_arr = array('3','4');
            $group_id = session('userinfo.groupid');
            if($type == 'pay' && !in_array($group_id,$group_arr)){
                exit(json_encode(array('status'=>0,'error'=>'无权修改！')));
            }
            $old = I('old');
            $password = md5($old.C('AUTH_KEY'));
            $where['username'] = session('userinfo.username');
            $user = D('User')->where($where)->find();
            if(($type == 'login' && $user['password']!=$password) || ($type == 'pay' && $user['pay_password']!=$password)){
                exit(json_encode(array('status'=>0,'msg'=>'密码错误！')));
                // $this->error('原始密码错误！');
                // exit();
            }
            $pass = I('password');
            $pass2 = I('password2');
            if($pass!=$pass2){
                exit(json_encode(array('msg'=>'两次输入密码不一致！')));
                // $this->error('两次输入密码不一致！');
                // exit();
            }
            $newpass = md5($pass.C('AUTH_KEY'));
            if($type == 'login'){
                $data = array('password'=>$newpass);
            } elseif($type == 'pay'){
                $data = array('pay_password'=>$newpass);
            }
            D('User')->where(array('uid'=>$user['uid']))->save($data);
            if($type=='pay'){
                $content = '修改支付密码【用户名：'.$user['username'].'】';
                action_log($content);
                $this->ajaxReturn(array('status'=>2,'msg'=>'修改支付密码成功！'));
                //die(json_encode(array('status'=>2,'msg'=>'修改支付密码成功')));
            }
            session('userinfo',null);
            $content = '修改登录密码【用户名：'.$user['username'].'】';
            action_log($content);
            $this->ajaxReturn(array('status'=>1,'msg'=>'修改登陆密码成功,请重新登陆！'));
            // $this->redirect('User/modifypass');
        }
        $this->display();
    }
   
}