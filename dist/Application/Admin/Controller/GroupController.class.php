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
class GroupController extends AdminController
{
    function _initialize() {
        parent::_initialize();
        $this->status = C('DEL_STATUS');
    }
    public function index(){    //name:用户组管理
        $this->title = '角色管理';
        $do = I('do');
        if($do == 'listTableData'){
            $status = I('start_stop',-1);
            if($status>-1){
                $where['del'] = $status;
            }

            $groups = D('Group')->where($where)->select();
            $getdata = D('Codetype')->getData('组织机构类型');
            $company_type = D('Code')->getData($getdata);
            foreach($groups as $k=>$v){

                foreach($company_type as $k1=>$v1){
                    if($v1['val'] == $v['company_type']){
                        $v['company_type'] = $v1['name'];
                        break;
                    }
                }

                $operate = '';
                $operate .= create_Url('Admin/Group/edit','编辑',array('id'=>$v['id']),'class="m-r-5"');
                $operate .='&nbsp;';
                $operate .= create_Url('Admin/Group/del',$v['del']==0?'归档':'恢复',array('id'=>$v['id']),'class="del"');
                $switch = '';
                $switch = '<div class="bootstrap-switch bootstrap-switch-mini">
                              <input target="'.$v['id'].'" type="checkbox" '.($v['status']?'checked':'').' />
                          </div>';
                $result[] = array($v['id'],$v['title'],$v['company_type'],$v['describe'],date('Y-m-d',strtotime($v['creattime'])),$operate);
            }
            $backData = array('data'=>$result?$result:array());
            exit(json_encode($backData));
        }
        $this->display();
    }

    public function add(){      //name:用户组添加
        $this->title = '添加角色';
        $do = I('do');
        // $group = D('Group')->find(session('userinfo.groupid'));
        // $where['id'] = array('in',explode(',',$group['rules']));
        $menus = D('Auth')->field('id,pid as pId,title as name')->where(array('id'=>array('gt',1)))->order('if(ord=0,9999,ord)')->select();
        $this->menus = json_encode($menus);
        if($do == 'layer'){
            $this->display('addPageHtml');
            exit();
        } elseif($do == 'save'){
            if (!D('Group')->autoCheckToken($_POST)){
                $this->error('非法操作！');
            }
//            dump(I('post.'));die;
            $row['title'] = I('title');
            $row['company_type']=I('company_type');
            $row['describe'] = I('describe');
            $row['status'] = 1;
            $row['rules'] = I('rules');
            $row['uid'] = session('userinfo.uid');
            $gid = D('Group')->insertData($row);
            $content = '添加角色：【 角色名称：'.$row['title'].'】';
            action_log($content);
            $this->redirect('Group/index');
            // $this->success('用户组添加成功！');
            exit();
        }
        $getdata = D('Codetype')->getData('company_type');
        $this->company_type = D('Code')->getData($getdata);
        $this->display();
    }

    public function edit(){     //name:用户组编辑
        $this->title = '编辑角色';
        $do = I('do');
        // $group = D('Group')->find(session('userinfo.groupid'));
        // $where['id'] = array('in',explode(',',$group['rules']));
        $menus = D('Auth')->field('id,pid as pId,title as name')->where(array('id'=>array('gt',1)))->order('if(ord=0,9999,ord)')->select();
        $this->menus = json_encode($menus);
        if(empty($do)){
            $id = I('id');
            if(!$id){
                $this->error('请选择要编辑的记录！');
                exit();
            }
            $info = D('Group')->where(array('id'=>$id))->find();
            if(session('userinfo.groupid')!=1 && $info['uid']!=session('userinfo.uid')){
                $this->error('非法操作！');
                exit();
            }
            $this->info = $info;
        } elseif($do == 'save') {
            if (!D('Group')->autoCheckToken($_POST)){
                $this->error('非法操作！');
                exit();
            }
            $row['id'] = I('id');
            $info = D('Group')->find($row['id']);
            if($info['uid']!=session('userinfo.uid')){
                $this->error('非法操作！');
                exit();
            }
            $row['title'] = I('title');
            $row['company_type']=I('company_type');

            $row['describe'] = I('describe');

            $row['rules'] = I('rules');
            D('Group')->insertData($row);
            $content = '编辑角色：【 角色名称：'.$row['title'].'】';
            action_log($content);
            $this->redirect('Group/index');
            // $this->success('用户组编辑成功！');
            exit();
        }
        $getdata = D('Codetype')->getData('组织机构类型');
//        dump($getdata);die;
        $this->company_type = D('Code')->getData($getdata);
        $this->display('add');
    }

    public function del(){      //name:用户组删除
        $id = I('id');
        if(!$id){
            //$this->error(l('choose_del_w'));
             exit(json_encode(array('status'=>0,'msg'=>'请选择要删除的记录！')));
        }
        if($id<=1)
        {
            exit(json_encode(array('status'=>0,'msg'=>'系统角色不能删除！')));
        }
        $r = D('access')->field('sj_auth_group_access.*')
                    ->join('sj_users on sj_auth_group_access.uid=sj_users.uid','left')
                    ->where(array('group_id'=>$id,'sj_users.del'=>0))->find();
        if($r)
        {
            exit(json_encode(array('status'=>0,'msg'=>'该角色下存在使用用户，不能删除！')));
        }
        $group = D('group')->where(array('id'=>$id))->find();
        if($group['uid']!=session('userinfo.uid')){
            exit(json_encode(array('status'=>0,'msg'=>'非法操作！')));
        }
        if($group['del']){
            D('group')->where(array('id'=>$id))->save(array('del'=>0));
            $content = '恢复角色：【 角色名称：'.$group['title'].'】';
        } else {
           D('group')->where(array('id'=>$id))->save(array('del'=>1));
            $content = '删除角色：【 角色名称：'.$group['title'].'】';     
        }
        
        action_log($content);
        exit(json_encode(array('status'=>1)));
        // exit(json_encode(array('status'=>1)));
    }
}