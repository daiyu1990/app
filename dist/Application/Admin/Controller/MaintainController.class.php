<?php
/**
 * Created by coder meng.
 * User: 设备管理
 * Date: 2017/3/15 14:55
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class MaintainController extends AdminController
{


  //维保管理
   
   	public function mainrecord_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');
            $info = D('Maintain')->getData($row);

            foreach($info as $k=>$v){

                $check = '<label class="select-checkwaring">'.
                    '<input type="checkbox" value="'.$v['id'].'" class="fl check-item_waring"  name="check-item_waring">'.
                    '</label>';

                $chakan = '<a href="/Admin/Maintain/mainrecord_detail/id'.'/'. $v['id'] .'" id="organ_check" ><i class="organ-look"></i></a>';
                $xiugai = '<a href="/Admin/Maintain/mainrecord_edit/id'.'/'. $v['id'] .'" id="organ_item" ><i class="organ-editt"></i></a>';

                $result[] = array($check,$k+1,$v['code'],$v['type'],$v['level'],$v['name'],$v['facility_number'],$v['contact'],$v['mobile'],$v['status'],$chakan,$xiugai);
            }
            $backData = array('data'=>$result?$result:array());
            exit(json_encode($backData));

        }elseif($do == 'del'){
            $res = M('maintain')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }
        $this->sheng = D('Region')->get_sheng();

        $this->title='维保列表';
        $this->display();
    }
    
    public function mainrecord_detail(){
    	$id = I('id');
        if(!$id){
            $this->error('请选择要查看的维保详情');
        }
        $this->info = D('Maintain')->getDetail($id);
        $this->title = '维保详情';
    	$this->display();
    }
    
    public function mainrecord_add(){

        $do = I('do');
        if($do == 'save'){
//            dump(I('post.'));die;
            $row = I('post.');
            $row['code'] = time().rand(1000,9999);
            $row['create_company'] = session('userinfo.company_id');
            $row['create_time'] = date('Y-m-d H:i:s');
            unset($row['do']);
            unset($row['__hash__']);


            $id = M('maintain')->add($row);
            if($id){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }
        $this->beian = M('record')->where(array('status'=>array('eq',1),'del'=>array('eq',0)))->select();
        $this->company = M('company')->where(array('status'=>array('eq',3),'is_del'=>array('eq',0)))->select();
        $this->title = "添加报修";
    	$this->display();
    }

    public function mainrecord_edit(){

        $id = I('id');
        if(!$id){
            $this->error('请选择要修改的报修信息');
        }
        $do = I('do');
        if($do == 'save'){
//            dump(I('post.'));die;
            $row = I('post.');

            unset($row['id']);
            unset($row['do']);
            unset($row['__hash__']);


            $res = M('maintain')->where(array('id'=>array('eq',I('id'))))->save($row);
            if($res!==false){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }
        $this->info = D('Maintain')->getOne($id);
        $this->beian = M('record')->where(array('status'=>array('eq',1),'del'=>array('eq',0)))->select();
        $this->company = M('company')->where(array('status'=>array('eq',3),'is_del'=>array('eq',0)))->select();
        $this->title = "添加报修";
        $this->display('mainrecord_add');
    }
    
    public function equiprepair_detail(){
    	
    	$this->display('');
    }
    
    public function main_plan(){
    	
    	$this->display();
    }
    
    public function manage_parts(){
    	
    	$this->display();
    }

}