<?php
/**
 * Created by coder meng.
 * User: 地区管理 汪
 * Date: 2017/3/14 16:35
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class RegionController extends AdminController{
    //地区管理
    public function region(){
        $this->title = '地区管理';
        $do = I('get.do');
        if($do == 'listTableData'){
            if(F('tree')){
                exit(\Admin\Model\RegionModel::treeList(F('tree')));
            }else{
                $datas = D('Region')->order('if(sort=0,99999,sort)')->select();
                $trees = \Admin\Model\RegionModel::getTree(0,$datas);
                F('tree',$trees);
                exit(\Admin\Model\RegionModel::treeList($trees));
            }
        }
        if(F('tree')){
            $this->trees = F('tree');
        }else{
            $datas = D('Region')->order('if(sort=0,99999,sort)')->select();
            $trees = \Admin\Model\RegionModel::getTree(0,$datas);
            $this->trees = $trees;
        }
        // $result = \Admin\Model\AuthModel::treeList2($trees);print_r($result);die;
        $this->display();
    }
    //添加地区
    public function add(){      //name:菜单添加
        $do = I('do');
        if(empty($do)){
            $datas = D('Region')->order('if(sort=0,99999,sort)')->select();
            if(F('tree')){
                $this->trees = F('tree');
            }else{
                $trees = \Admin\Model\RegionModel::getTree(0,$datas);
                $this->trees = $trees;
            }
        } elseif ($do == 'save'){
            if (!D('Region')->autoCheckToken($_POST)){
                exit(json_encode(array('status'=>0,'msg'=>'非法操作！')));
            }
            $row = I('post.');
            $data = D('Region')->getData($row['parent_id']);
            $row['level'] = $data['level']+1;
            //添加成功 更新缓存
            D('Region')->insertData($row);
            $datas = D('Region')->order('if(sort=0,99999,sort)')->select();
            $trees = \Admin\Model\RegionModel::getTree(0,$datas);
            F('tree',$trees);
            $content = '添加地区：【'.$row['name'].'】';
            action_log($content);
            // $this->redirect('Auth/index');
            exit(json_encode(array('status'=>1)));
        }
        $this->display();
    }
    //地区编辑
    public function edit(){
        $do = I('do');
        if(empty($do)){
            $id = I('get.id');
            if(!$id){
                $this->error('请选择要编辑的记录！');
                exit();
            }
            $info = D('Region')->where(array('id'=>$id))->find();
            if(!$info){
                $this->error('编辑记录不存在！');
            }
            $this->info = $info;
            if(F('tree')){
                $this->trees = F('tree');
            }else{
                $datas = D('Region')->order('if(ord=0,9999,ord)')->select();
                $trees = \Admin\Model\RegionModel::getTree(0,$datas);
                $this->trees = $trees;
            }

        } elseif ($do == 'save'){
            if (!D('Region')->autoCheckToken($_POST)){
                exit(json_encode(array('status'=>0,'msg'=>'非法操作！')));
            }
            $row = I('post.');
            //修改成功 更新缓存
            D('Region')->insertData($row);
            $datas = D('Region')->order('if(sort=0,99999,sort)')->select();
            $trees = \Admin\Model\RegionModel::getTree(0,$datas);
            F('tree',$trees);

            $content = '编辑地区：【'.$row['name'].'】';
            action_log($content);
            // $this->redirect('Auth/index');
            exit(json_encode(array('status'=>1)));
        }
        $this->display('add');
    }
    //地区删除
    public function del(){
        $id = I('get.id');
        if(!$id){
            exit(json_encode(array('state'=>0,'msg'=>'请选择要删除的记录！')));
        }
        $auth_count = D('Region')->where(array('parent_id'=>$id))->count();
        if($auth_count > 0){
            exit(json_encode(array('state'=>0,'msg'=>'有下级菜单不能删除！')));
        }
        $auth = D('Region')->where(array('id'=>$id))->find();
        D('Region')->where(array('id'=>$id))->delete();
        $datas = D('Region')->order('if(sort=0,99999,sort)')->select();
        $trees = \Admin\Model\RegionModel::getTree(0,$datas);
        F('tree',$trees);
        $content = '添加权限菜单：【'.$auth['name'].'】';
        action_log($content);
        exit(json_encode(array('state'=>1)));
    }
}