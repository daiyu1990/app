<?php
/**
 * @Author: Sincez
 * @Date:   2015-12-14 22:32:23
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-01-05 13:57:48
 */
namespace Admin\Model;
use Think\Model;
class UserModel extends Model{

    protected $tableName = 'users';

//    public $col = 'company,username,password,mobile,nicename,status,regtime,regip,lasttime,lastip,email,from';

    public function getUserinfo($row){
        if($row['uid']){
            $this->where(array('uid'=>$row['uid']));
        }
        if($row['username']){
            $this->where(array('username'=>$row['username']));
        }
        $data = $this->field(C('DB_PREFIX').'users.*,'.C('DB_PREFIX').'auth_group_access.group_id')
            ->join(C('DB_PREFIX').'auth_group_access on '.C('DB_PREFIX').'users.uid = '.C('DB_PREFIX').'auth_group_access.uid','left')
            ->find();
        return $data;
    }

    public function getData($row){
        if($row['not_uids']){
            $where[C('DB_PREFIX').'users.uid'] = array('not in',$row['not_uids']);
        }
        if($row['group_id']){
            $where['group_id'] = $row['group_id'];
        }
        if($row['del']>-1){
            $where['del'] = $row['del'];
        }
        $data = $this->field(C('DB_PREFIX').'users.*,'.C('DB_PREFIX').'auth_group_access.group_id')
            ->join(C('DB_PREFIX').'auth_group_access on '.C('DB_PREFIX').'users.uid='.C('DB_PREFIX').'auth_group_access.uid','left')
            ->where($where)
            ->select();
        return $data;
    }

    public function createUserAccount($data){
        if(!$data['username']){
            return array('status'=>0,'msg'=>'登录账号不能为空！');
            // $this->error('登录账号不能为空！');
            // exit();
        }
        if(!$data['uid'] && !$data['password']){
            return array('status'=>0,'msg'=>'登录密码不能为空！');
            // $this->error('登录密码不能为空！');
            // exit();
        }
        if($data['password']!=$data['password2']){
            return array('status'=>0,'msg'=>'两次输入登录密码不一致！');
            // $this->error('两次输入登录密码不一致！');
        }
        if(session('userinfo.groupid')>2){
            if(!$data['uid'] && !$data['pay_password']){
                return array('status'=>0,'msg'=>'支付密码不能为空！');
                // $this->error('支付密码不能为空！');
                // exit();
            }
            if($data['pay_password']!=$data['pay_password2']){
                return array('status'=>0,'msg'=>'两次输入支付密码不一致！');
                // $this->error('两次输入支付密码不一致！');
                // exit();
            }
        }

        $where = array('username'=>$data['username']);
        if($data['uid']){
            $where['uid'] = array('neq',$data['uid']);
        }
        $userCount = D('User')->where($where)->count();
        if($userCount){
            return array('status'=>0,'msg'=>'用户已存在！');
            // $this->error('用户已存在！');
            // exit();
        }
        $userData = array('username'=>$data['username'],'m_code'=>$data['m_code'],'email'=>$data['email'],'nicename'=>$data['nicename'],'regtime'=>time(),'regip'=>get_Ip(),'from'=>session('userinfo.uid'),'groups'=>array($data['group_id']));
        if($data['password']){
            $userData['password'] = md5($data['password'].C('AUTH_kEY'));
        } else {
            unset($userData['password']);
        }
        if($data['pay_password']){
            $userData['pay_password'] = md5($data['pay_password'].C('AUTH_kEY'));
        } else {
            unset($userData['pay_password']);
        }
        $userData['uid'] = $data['uid'];

        $uid = $this->insertData($userData);
        return array('status'=>1,'uid'=>$uid);
    }

    public function insertData($row){
        $data = array_bykeys($row,$this->col);
        if($row['uid']){
            $this->where(array('uid'=>$row['uid']))->save($data);
            $uid = $row['uid'];
            D('Admin/access')->where(array('uid'=>$row['uid']))->delete();
            foreach(array_filter($row['groups']) as $v){
                D('Admin/Access')->insertData(array('uid'=>$row['uid'],'group'=>$v));
            }
        } else {
            $uid = $this->add($data);
            D('Admin/Access')->where(array('uid'=>$uid))->delete();
            foreach(array_filter($row['groups']) as $v){
                D('Admin/Access')->insertData(array('uid'=>$uid,'group'=>$v));
            }
        }
        return $uid;
    }

    public function login($row){
        $username = $row['username'];
        $password = $row['password'];
        $ip = $row['ip'];
        $verifycode = $row['verify'];
        $verify = new \Think\Verify();
        if(isset($row['verify']) && !$verify->check($verifycode)){
            return array('state' => 2 , 'msg'=>'验证码错误！');
        }
        if(!$username){
            D('loginlist')->insertData(array('username'=>$username,'password'=>$password,'state'=>2,'ip'=>$ip));
            return array('state' => 3 , 'msg'=>'用户名不能为空！');
        }
        if(!$password){
            D('loginlist')->insertData(array('username'=>$username,'password'=>$password,'state'=>3,'ip'=>$ip));
            return array('state' => 4 , 'msg'=>'密码不能为空！');
        }
        #判断登录次数
        $time = time();
        $logins = F('login');
        if($logins[$username]['count']>5 && $logins[$username]['locktime'] && (($time-$logins[$username]['locktime'])<=1800)){
            return array('state' => 4 , 'msg'=>'用户名或者密码错误达到最大次数，稍后再试！');
        }
        unset($map);
        $map['username']  =   $username;
        // $map['mobile']  =   $username;
        // $map['email']   =   $username;
        // $map['_logic']  =   'or';
        $rs = $this->where($map)->find();
        if(!$rs){
            $rs = $this->where(array('mobile'=>array('eq',$username)))->find();
        }
        if($rs['del'] == 1){
            return array('state' => 4 , 'msg'=>'用户无效！');
        }
        if($rs['status']==1){
            return array('state' => 4 , 'msg'=>'该用户已被禁止登陆！');
        }
        if($rs['password']!=md5($password.C('AUTH_kEY'))){
            D('loginlist')->insertData(array('username'=>$username,'password'=>$password,'state'=>4,'ip'=>$ip));
            if(!$logins){
                $logins[$username]['time'] = time();
                $logins[$username]['count'] = 1;
            }
            // print_r($logins);die;
            if($logins && ($time-$logins[$username]['time'])<=1800){
                $logins[$username]['time'] = time();
                $logins[$username]['count'] = $logins[$username]['count']+1;
            }

            if($logins[$username]['count'] >=5){
                $logins[$username]['locktime'] = time();
            }
            if($logins){
                F('login',$logins);
            }
            return array('state' => 5 , 'msg'=>'用户名或者密码错误！');
        }

        if($rs && $rs['status'] == 1){
            D('loginlist')->insertData(array('username'=>$username,'password'=>$password,'state'=>5,'ip'=>$ip));
            return array('state' => 6 , 'msg'=>'该用户已被禁止登录！');
        }
        $d = D('Access')->where(array('uid'=>$rs['uid']))->find();
        $rs['groupid'] = $d['group_id'];
        $gp = D('Group')->find($d['group_id']);
        if($gp && $gp['status'] == 0){
            D('loginlist')->insertData(array('username'=>$username,'password'=>$password,'state'=>6,'ip'=>$ip));
            return array('state' => 7 , 'msg'=>'该用户组已被禁止登录！');
        }
        cookie('PHPSESSID',null);
        session(null);
        cookie('PHPSESSID',session_id());

        if($rs['type']==1 && $rs['active']==0){
            $this->where(array('uid'=>array('eq',$rs['uid'])))->save(array('active'=>1));
            $rs = $this->find($rs['uid']);
        }
        session('userinfo',$rs);
        D('loginlist')->insertData(array('username'=>$username,'password'=>'******','state'=>1,'ip'=>$ip));
        $this->where(array('uid'=>$rs['uid']))
            ->save(array('lasttime'=>time(),'lastip'=>$ip));
        return array('state' => 1);
    }

    public function reg($row)
    {
        $verify = new \Think\Verify();
        if(isset($row['verify']) && !$verify->check($row['verify'])){
            //return array('state' => 2 , 'msg'=>l('verify_code').l('wrong'));
        }
        if(!$row['username']){
            return array('state' => 3 , 'msg'=>l('user').l('no_empty'));
        }
        if(!$row['password']){
            return array('state' => 4 , 'msg'=>l('pwd').l('no_empty'));
        }
        if(!$row['mobile']){
            return array('state' => 4 , 'msg'=>l('mobile').l('no_empty'));
        }
        if(!$row['email']){
            return array('state' => 4 , 'msg'=>l('email').l('no_empty'));
        }
        if(D('User')->where(array('username'=>$row['username']))->find())
        {
            return array('state' => 4 , 'msg'=>l('username').l('is_exits'));
        }
        if(D('User')->where(array('mobile'=>$row['mobile']))->find())
        {
            return array('state' => 4 , 'msg'=>l('mobile').l('is_exits'));
        }
        if(D('User')->where(array('email'=>$row['email']))->find())
        {
            return array('state' => 4 , 'msg'=>l('email').l('is_exits'));
        }
        unset($row['verify']);
        $row['regtime'] = time();
        $row['groups'] = $row['groups']?$row['groups']:array(2);
        $row['nicename'] = '';
        $row['password'] = md5($row['password'].C('AUTH_kEY'));
        $result = $this->insertData($row);
        return array('state' => 1);
    }


    public function getDatas($row){
        $map = array();

//        $row['a.company_id']=array('eq',session('userinfo.company_id'));

        if($row['name']!=''){
            $map['a.nicename']=array('eq',$row['name']);
        }

        if($row['mobile']!=''){
            $map['a.mobile']=array('eq',$row['mobile']);
        }

        if($row['check']!=''){
            $map['a.check']=array('eq',$row['check']);
        }

        if($row['c_name']!=''){
            $map['b.name']=array('eq',$row['c_name']);
        }

        if($row['c_type']!=''){
            $map['b.type']=array('eq',$row['c_type']);
        }

        if($row['active']!=''){
            $map['a.active']=array('eq',$row['active']);
        }

        if(session('userinfo.uid')!=1){
            $map['company_id']=array('eq',session('userinfo.company_id'));
        }


        $map['a.del']=array('eq',0);

        $data = $this->alias('a')
            ->field('a.*,b.name as c_name,b.type as c_type')
            ->join('left join box_company b on a.company_id=b.id')
            ->where($map)
            ->select();

        $check = C('USER_CHECK');
        $active = C('USER_ACTIVE');

        $type = D('Codetype')->getData('组织机构类型');
        $type = D('Code')->getData($type);

        $arr_type = array();
        foreach($type as $k=>$v){
            $arr_type[$v['val']] = $v['name'];
        }

        foreach($data as $k=>$v){
            $data[$k]['c_type'] = $arr_type[$v['c_type']];
            $data[$k]['check'] = $check[$v['check']];
            $data[$k]['active'] = $active[$v['active']];
        }

        return $data;

    }

    public function getDetail($id){

        $info = $this->alias('a')
            ->field('a.*,b.name as c_name,b.type as c_type,b.address,c.name as s_name')
            ->join('left join box_company b on a.company_id=b.id')
            ->join('left join box_company_section c on a.section=c.id')
            ->where(array('a.uid'=>array('eq',$id)))
            ->find();


        $info['apt'] = M('aptitude')
            ->where(array(
                'connet'=>array('eq',$id),
                'type'=>array('eq',2),
                'del'=>array('eq',0),
            ))
            ->select();

        $type = D('Codetype')->getData('组织机构类型');
        $type = D('Code')->getData($type);

        foreach($type as $k=>$v){
            if($v['val']==$info['c_type']){
                $info['c_type'] = $v['name'];
                break;
            }
        }

        $group = M('auth_group_access')
            ->field('a.uid,b.*')
            ->alias('a')
            ->join('left join box_auth_group b on a.group_id=b.id')
            ->where(array('a.uid'=>array('eq',$id)))
            ->find();
        $info['group'] = $group['title'];

        return $info;

    }


}