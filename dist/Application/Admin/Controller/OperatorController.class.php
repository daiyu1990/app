<?php
/**
 * @Author: Sincez
 * @Date:   2015-12-21 16:52:29
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-12-06 19:16:36
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class OperatorController extends AdminController{

    public function index(){
        $this->title = '作业人员列表';
        $do = I('do');
        $getdata = D('Codetype')->getData(C('STATION'));
        $this->station = D('Code')->getData($getdata);

        if($do == 'listTableData'){
            $row = I('get.');
            $info = D('operator')->getData($row);
            foreach($info as $k=>$v){

                foreach($this->station as $k1=>$v1){
                    if($v['station']==$v1['id']){
                        $station = $v1['name'];
                    }
                }
                $operate = '';
                $operate = create_Url('Admin/Operator/edit','修改',array('id'=>$v['id']),'class="m-r-5"');
                $operate .= create_Url('Admin/Operator/del','删除',array('id'=>$v['id']),'class="m-r-5 del_operator"');

                $result[] = array($v['id'],$v['nicename'],$v['mobile'],$station,$v['work_code'],$v['name'],$operate);
            }
            $backData = array('data'=>$result?$result:array());
            exit(json_encode($backData));

        }

        $this->display();
    }



    public function add(){

        $do = I('do');
        if($do == 'save'){
            $res = M('operater')->where(array('uid'=>array('eq',I('uid'))))->find();
            if($res!=null || $res!=false){
                $this->error('该用户已是特种工作人员',U('Admin/Operator/add'));
                die;
            }
            $row = array(
                'uid'=>I('uid'),
                'station'=>I('station'),
                'work_code'=>I('work_code'),
                'company_id'=>session()['userinfo']['company_id'],
                'create_uid'=>session()['userinfo']['uid'],
                'create_time'=>date('Y-m-d H:i:s')
            );
            if(M('operator')->add($row)){
                $this->success('添加成功',U('Admin/Operator/index'));
                die;
            }else{
                $this->error('添加失败',U('Admin/Operator/add'));
                die;
            }
        }

        $getdata = D('Codetype')->getData(C('STATION'));
        $this->station = D('Code')->getData($getdata);
        $this->title = '添加特种工作人员';
        $this->display();
    }

    public function user(){
        $this->title = '用户列表';
        $do = I('do');
        if($do == 'listTableData'){

            $type = session()['userinfo']['company_id'];
            if($type != 0){
                $info = M('users')->where(array('del'=>array('eq',0),'company_id'=>array('eq',$type)))->select();

            }else{
                $info = M('users')->where(array('del'=>array('eq',0)))->select();

            }
            foreach($info as $k=>$v){
                $operate = '';

                $operate .= create_Url('Admin/Operator/user','确定',array('id'=>$v['uid'],'do'=>'chose'),'class="m-r-5 user"');

                $result[] = array($v['uid'],$v['username'],$v['nicename'],$v['mobile'],$v['IDcard'],$operate);
            }
            $backData = array('data'=>$result?$result:array());
            exit(json_encode($backData));

        }elseif($do == 'chose'){
            $id = I('id');
            $data = M('users')->find($id);
            exit(json_encode($data));
        }
        $this->display();
    }

    public function edit(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要修改的人员',U('Admin/Operator/index'));
        }
        $do = I('do');
        if($do == 'save'){

            $row = array(
                'id'=>I('id'),
                'uid'=>I('uid'),
                'station'=>I('station'),
                'work_code'=>I('work_code'),
                'company_id'=>session()['userinfo']['company_id'],

            );
            if(M('operator')->save($row)){
                $this->success('修改成功',U('Admin/Operator/index'));
                die;
            }else{
                $this->error('修改失败',U('Admin/Operator/add'));
                die;
            }
        }

        $getdata = D('Codetype')->getData(C('STATION'));
        $this->station = D('Code')->getData($getdata);
        $this->info = D('Operator')->getOne($id);
//        dump($this->info);die;
        $this->title = '添加特种工作人员';
        $this->display('add');
    }

    public function del(){
        $id = I('id');
        if(!$id){
            exit(json_encode(array('status'=>0,'msg'=>'请选择要删除的人员！')));
        }
        $do = I('do');
        if($do=='delete'){
            $info = M('operator')->where(array('id'=>array('eq',$id)))->delete();
            if($info==1){
                exit(json_encode(array('status'=>1)));
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'非法操作！')));
            }
        }else{
            exit(json_encode(array('status'=>0,'msg'=>'非法操作！')));
        }

    }


}