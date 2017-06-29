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
class CompanyController extends AdminController{

    public function index(){
        $this->title = '公司管理';

        $getdata = D('Codetype')->getData(C('COMPANY_TYPE'));
        $this->company_type = D('Code')->getData($getdata);

        $getdata = D('Codetype')->getData(C('COMPANY_STATUS'));
        $this->company_status = D('Code')->getData($getdata);

        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');
            $info = D('company')->getData($row);



            foreach($info as $k=>$v){

                foreach($this->company_type as $k1=>$v1){
                    if($v1['val'] == $v['type']){
                        $v['type'] = $v1['name'];
                        break;
                    }
                }

                foreach($this->company_status as $k1=>$v1){
                    if($v1['val'] == $v['status']){
                        $status = $v1['name'];
                        break;
                    }
                }

                $operate = '';
                $operate = create_Url('Admin/Company/edit','修改',array('id'=>$v['id']),'class="m-r-5"');
                $operate .= create_Url('Admin/Company/del','删除',array('id'=>$v['id']),'class="m-r-5 del_company"');
                if($v['status']==1){
                    $operate .= create_Url('Admin/Company/check','审核',array('id'=>$v['id']),'class="m-r-5"');

                }

                $result[] = array($v['id'],$v['name'],$v['type'],$v['jiancheng'],$v['create_time'],$status,$operate);
            }
            $backData = array('data'=>$result?$result:array());

            exit(json_encode($backData));

        }


        $this->display();
    }

    public function check(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要审核的公司',U('Admin/Company/index'));
            die;
        }

        $do = I('do');
        if($do == 'check'){
            $is_pass = I('is_pass');
            if($is_pass == 'yes'){
                if(M('company')->where(array('id'=>array('eq',$id)))->save(array('status'=>'3'))){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'提交成功，审核已通过'));
                    die;
                }else{
                    $this->ajaxReturn(array('status'=>0,'msg'=>'提交失败，请重试'));
                    die;
                }
            }else{
                if(M('company')->where(array('id'=>array('eq',$id)))->save(array('status'=>'2'))){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'提交成功，审核未通过'));
                    die;
                }else{
                    $this->ajaxReturn(array('status'=>0,'msg'=>'提交失败，请重试'));
                    die;
                }
            }

        }

        $info = M('company')->find($id);
        if(!$info){
            $this->error('非法操做',U('Admin/Company/index'));
            die;
        }

        $getdata = D('Codetype')->getData(C('COMPANY_TYPE'));
        $company_type = D('Code')->getData($getdata);

        foreach($company_type as $k=>$v){
            if($v['val'] == $info['type']){
                $info['type']=$v['name'];
                break;
            }
        }


        $this->title='审核公司信息';

        $this->assign('info',$info);
        $this->display();
    }



    public function add(){

        $do = I('do');
        if($do == 'save'){
            $res = M('company')->where(array('name'=>array('eq',I('name'))))->find();
            if(!$res){
                $row = array(
                    'name'=>I('name'),
                    'type'=>I('type'),
                    'jiancheng'=>I('jiancheng'),
                    'address'=>I('address'),
                    'company_code'=>I('company_code'),
                    'faren'=>i('faren'),
                    'faren_mobile'=>I('faren_mobile'),
                    'jishu'=>I('jishu'),
                    'jishu_mobile'=>I('jishu_mobile'),
                    'guanli'=>I('guanli'),
                    'guanli_mobile'=>I('guanli_mobile'),
                    'create_time'=>date('Y-m-d H:i:s')
                );

                M('company')->add($row);

                $this->success('添加成功',u('Admin/Company/index'));
                die;
            }else{
                $this->error('该公司已添加',U('Admin/Company/add'));
                die;
            }
        }

        $this->company_type=C('COMPANY_TYPE');
        $this->title = '添加公司';
        $this->display();
    }

    public function edit(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要修改的公司',U('Admin/Company/index'));
            die;
        }

        $do = I('do');
        if($do == 'save'){
            $row = array(
                'name'=>I('name'),
                'type'=>I('type'),
                'jiancheng'=>I('jiancheng'),
                'address'=>I('address'),
                'company_code'=>I('company_code'),
                'faren'=>i('faren'),
                'faren_mobile'=>I('faren_mobile'),
                'jishu'=>I('jishu'),
                'jishu_mobile'=>I('jishu_mobile'),
                'guanli'=>I('guanli'),
                'guanli_mobile'=>I('guanli_mobile'),
            );

            M('company')->where(array('id'=>array('eq',$id)))->save($row);
            $this->success('修改成功',U('Admin/Company/index'));
            die;
        }

        $info = M('company')->find($id);
        if(!$info){
            $this->error('非法操做',U('Admin/Company/index'));
            die;
        }

        $this->title='修改公司信息';
        $this->company_type=C('COMPANY_TYPE');
        $this->assign('info',$info);
        $this->display('add');
    }

    public function del(){
        $id = I('id');
        if(!$id){
            exit(json_encode(array('status'=>0,'msg'=>'请选择要删除的公司！')));
        }
        $do = I('do');
        if($do=='delete'){
            $info = M('company')->where(array('id'=>array('eq',$id)))->save(array('is_del'=>'1'));
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