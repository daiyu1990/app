<?php
/**
 * @Author: Sincez
 * @Date:   2016-02-22 10:37:47
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-11-03 15:38:10
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;

class AuthController extends AdminController
{
    public function index(){    //name:菜单管理
        $this->title = '菜单管理';
        $do = I('do');
        if($do == 'up'){
            $id = I('id');
            $col = I('col');
            $val = I('val');
            D('Auth')->where(array('id'=>$id))->save(array($col=>$val));
            exit(json_encode(array('status'=>1)));
        } elseif($do == 'listTableData'){
            $datas = D('Auth')->order('if(ord=0,99999,ord)')->select();
            $trees = \Admin\Model\AuthModel::getTree(0,$datas);
            exit(\Admin\Model\AuthModel::treeList($trees));
        }
        $datas = D('Auth')->order('if(ord=0,99999,ord)')->select();
        $trees = \Admin\Model\AuthModel::getTree(0,$datas);
        $this->trees = $trees;
        // $result = \Admin\Model\AuthModel::treeList2($trees);print_r($result);die;
        $this->display();
    }

    public function scan(){     //name:更新菜单
        $this->title = '更新菜单';
        $do = I('do');
        if($do == 'scan'){
            $m = I('m');
            D('auth')->scanMenu($m);
            $content = '更新权限菜单：【模块：'.$m.'】';
            action_log($content);
            echo json_encode(array('state'=>1,'更新成功！'));
            exit();
        }
        $modules = scandir(APP_PATH);
        $this->modules = $modules;
        $this->display();
    }

    public function add(){      //name:菜单添加
        $do = I('do');
        if(empty($do)){
            $datas = D('Auth')->order('if(ord=0,9999,ord)')->select();
            $trees = \Admin\Model\AuthModel::getTree(0,$datas);
            $this->trees = $trees;
        } elseif ($do == 'save'){
            if (!D('Auth')->autoCheckToken($_POST)){
                exit(json_encode(array('status'=>0,'msg'=>'非法操作！')));
            }
            $row = I('post.');
            D('Auth')->insertData($row);
            $content = '添加权限菜单：【'.$row['title'].' '.$row['name'].'】';
            action_log($content);
            // $this->redirect('Auth/index');
            exit(json_encode(array('status'=>1)));
        }  elseif($do == 'choice_icon'){
            $this->display('choice_icon');
            exit();
        }
        $this->display();
    }

    public function edit(){     //name:菜单编辑
        $do = I('do');
        if(empty($do)){
            $id = I('get.id');
            if(!$id){
                $this->error('请选择要编辑的记录！');
                exit();
            }
            $info = D('Auth')->where(array('id'=>$id))->find();
            if(!$info){
                $this->error('编辑记录不存在！');
            }
            $this->info = $info;
            $datas = D('Auth')->order('if(ord=0,9999,ord)')->select();
            $trees = \Admin\Model\AuthModel::getTree(0,$datas);
            $this->trees = $trees;
        } elseif ($do == 'save'){
            if (!D('Auth')->autoCheckToken($_POST)){
                exit(json_encode(array('status'=>0,'msg'=>'非法操作！')));
            }
            $row = I('post.');
            D('auth')->insertData($row);
            $content = '编辑权限菜单：【'.$row['title'].' '.$row['name'].'】';
            action_log($content);
            // $this->redirect('Auth/index');
            exit(json_encode(array('status'=>1)));
        }
        $this->display('add');
    }

    public function del(){      //name:菜单删除
        $id = I('get.id');
        if(!$id){
            exit(json_encode(array('state'=>0,'msg'=>'请选择要删除的记录！')));
        }
        $auth_count = D('auth')->where(array('pid'=>$id))->count();
        if($auth_count > 0){
            exit(json_encode(array('state'=>0,'msg'=>'有下级菜单不能删除！')));
        }
        $auth = D('auth')->where(array('id'=>$id))->find();
        D('auth')->where(array('id'=>$id))->delete();
        $content = '添加权限菜单：【'.$auth['title'].' '.$auth['name'].'】';
        action_log($content);
        exit(json_encode(array('state'=>1)));
    }

}