<?php
/**
 * Created by coder meng.
 * User: 设备管理
 * Date: 2017/3/15 14:55
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class FileController extends AdminController
{

    
    
    public function file_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');

            $info = D('File')->getData($row);


            foreach($info as $k=>$v){
                $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="check_all"><span class="fl"></span></label>';

                $file = '<a href="/Admin/File/download/id/'.$v['id'].'" style="color:#2164ff">'.$v['name'].'</a>';
//                $chakan = '<a data="'.$v["id"].'"  class="shenhe" id="organ_check"><i class="organ-look"></i></a>';
                $bianji = '<a data="'.$v['id'].'" class="bianji" id="organ_item"><i class="organ-editt"></i></a>';

                $result[] = array($check,$k+1,$v['code'],$file,$v['connet'],$v['b_type'],$v['status'],$bianji);
            }
            $backData = array('data'=>$result?$result:array());


            exit(json_encode($backData));
        }elseif($do=='add'){
            $info = upFiles();
            if($info){
                $file = '/Public/' . $info['file']['savepath'] . $info['file']['savename'];
            }
            $code = time().rand(1000,9999);
            $row = array(
                'type'=>I('type'),
                'connet'=>I('connet'),
                'code'=>$code,
                'name'=>I('name'),
                'file'=>$file,
                'create_company'=>session('userinfo.company_id'),
                'create_user'=>session('userinfo.uid'),
                'create_time'=>date('Y-m-d H:i:s')
            );
            if(I('type')==3){
                $row['connet'] = session('userinfo.company_id');
            }
            $id = M('file')->add($row);
            if($id){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }elseif($do=='edit'){

            $row = array(

                'connet'=>I('connet'),
                'name'=>I('name'),
                'status'=>0,
            );
            if(I('type')==3){
                unset($row['connet']);
            }
            if($_FILES && $_FILES['file']['error']==0){
                $info = upFiles();
                if($info){
                    $row['file'] = '/Public/' . $info['file']['savepath'] . $info['file']['savename'];
                    $file =  M('file')->find(I('id'));
                    $file = $file['file'];
                }
            }

            $res =  M('file')->where(array('id'=>array('eq',I('id'))))->save($row);
            if($res!==false){
                if($row['file']!=''){
                    @unlink($file);
                }
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }elseif($do=='getOne'){

            $data = M('file')->find(I('id'));
            if($data){
                exit(json_encode(array('status'=>1,'data'=>$data)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }elseif($do=='getDetail'){
            $data = D('file')->getDetail(I('id'));
            if($data){
                exit(json_encode(array('status'=>1,'data'=>$data)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }elseif($do=='check'){
            $id = I('id');

            $res = M('file')->where(array('id'=>array('eq',$id)))->save(array('status'=>I('data')));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }elseif($do == 'del'){
            $res = M('file')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }


        $this->title = '技术资料';
        $this->display();
    }

    public function c_file_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');

            $info = D('File')->getData($row);


            foreach($info as $k=>$v){
                $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="check_all"><span class="fl"></span></label>';

                $file = '<a href="/Admin/File/download/id/'.$v['id'].'" style="color:#2164ff">'.$v['name'].'</a>';
                $chakan = '<a data="'.$v["id"].'"  class="shenhe" id="organ_check"><i class="organ-look"></i></a>';
                $bianji = '<a data="'.$v['id'].'" class="bianji" id="organ_item"><i class="organ-editt"></i></a>';

                $result[] = array($check,$k+1,$v['code'],$file,$v['connet'],$v['b_type'],$v['status'],$bianji,$chakan);
            }
            $backData = array('data'=>$result?$result:array());


            exit(json_encode($backData));
        }elseif($do=='add'){
            $info = upFiles();
            if($info){
                $file = '/Public/' . $info['file']['savepath'] . $info['file']['savename'];
            }
            $code = time().rand(1000,9999);
            $row = array(
                'type'=>I('type'),
                'connet'=>I('connet'),
                'code'=>$code,
                'name'=>I('name'),
                'file'=>$file,
                'create_company'=>session('userinfo.company_id'),
                'create_user'=>session('userinfo.uid'),
                'create_time'=>date('Y-m-d H:i:s')
            );
            if(I('type')==3){
                $row['connet'] = session('userinfo.company_id');
            }
            $id = M('file')->add($row);
            if($id){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }elseif($do=='edit'){

            $row = array(

                'connet'=>I('connet'),
                'name'=>I('name'),
                'status'=>0,
            );
            if(I('type')==3){
                unset($row['connet']);
            }
            if($_FILES && $_FILES['file']['error']==0){
                $info = upFiles();
                if($info){
                    $row['file'] = '/Public/' . $info['file']['savepath'] . $info['file']['savename'];
                    $file =  M('file')->find(I('id'));
                    $file = $file['file'];
                }
            }

            $res =  M('file')->where(array('id'=>array('eq',I('id'))))->save($row);
            if($res!==false){
                if($row['file']!=''){
                    @unlink($file);
                }
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }elseif($do=='getOne'){

            $data = M('file')->find(I('id'));
            if($data){
                exit(json_encode(array('status'=>1,'data'=>$data)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }elseif($do=='getDetail'){
            $data = D('file')->getDetail(I('id'));
            if($data){
                exit(json_encode(array('status'=>1,'data'=>$data)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }elseif($do=='check'){
            $id = I('id');

            $res = M('file')->where(array('id'=>array('eq',$id)))->save(array('status'=>I('data')));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }elseif($do == 'del'){
            $res = M('file')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

        $this->title = '技术资料';
        $this->display('file_list');
    }

    public function download(){
        $id = I('get.id');
        $file = M('file')->find($id);
        $res = download_file($_SERVER['DOCUMENT_ROOT'].$file['file']);
        if(!$res){
            $this->error('文件不存在！');
        }
    }
    


    //产权备案
    
    public function record_list(){
        $do = I('do');
        if($do == 'listTableData') {
            $row = I('get.');
            $info = D('Record')->getData($row);

            foreach ($info as $k => $v) {

                $check = '<label class="select-checkwaring">' .
                    '<input type="checkbox" value="' . $v['id'] . '" class="fl check-item_waring"  name="check-item_waring">' .
                    '</label>';

                $chakan = '<a href="/Admin/File/record_detail/id' . '/' . $v['id'] . '" id="organ_check" ><i class="organ-look"></i></a>';
                $xiugai = '<a href="/Admin/File/record_edit/id' . '/' . $v['id'] . '" id="organ_item" ><i class="organ-editt"></i></a>';

                $result[] = array($check, $k + 1, $v['facility_number'], $v['beian_code'], $v['facility_type'], $v['facility_model_number'], $v['company_name'], $v['diqu'], $v['status'], $v['beian'], $chakan, $xiugai);
            }
            $backData = array('data' => $result ? $result : array());
            exit(json_encode($backData));

        }elseif($do == 'del'){
            $res = M('record')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

        $sheng = D('Region')->get_sheng();
        $this->assign('sheng',$sheng);

        $this->title = '产权备案列表';

    	$this->display();
    }


    public function c_record_list(){
        $do = I('do');
        if($do == 'listTableData') {
            $row = I('get.');
            $info = D('Record')->getData($row);

            foreach ($info as $k => $v) {

                $check = '<label class="select-checkwaring">' .
                    '<input type="checkbox" value="' . $v['id'] . '" class="fl check-item_waring"  name="check-item_waring">' .
                    '</label>';

                $chakan = '<a href="/Admin/File/c_record_detail/id' . '/' . $v['id'] . '" id="organ_check" ><i class="organ-look"></i></a>';
                $xiugai = '<a href="/Admin/File/record_edit/id' . '/' . $v['id'] . '" id="organ_item" ><i class="organ-editt"></i></a>';

                $result[] = array($check, $k + 1, $v['facility_number'], $v['beian_code'], $v['facility_type'], $v['facility_model_number'], $v['company_name'], $v['diqu'], $v['status'], $v['beian'], $chakan, $xiugai);
            }
            $backData = array('data' => $result ? $result : array());
            exit(json_encode($backData));

        }elseif($do == 'del'){
            $res = M('record')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

        $sheng = D('Region')->get_sheng();
        $this->assign('sheng',$sheng);

        $this->title = '产权备案列表';

        $this->display('record_list');
    }
    
    public function record_add(){

        $do = I('do');

        if($do == 'get_company'){
            $data = M('company')->find(I('id'));
            $sheng  = M('region')->field('name')->find($data['sheng_id']);
            $shi  = M('region')->field('name')->find($data['shi_id']);
            $data['diqu'] = $sheng['name'].'-'.$shi['name'];

            exit(json_encode(array('status'=>1,'data'=>$data)));
            die;
        }else if($do == 'get_fac'){
            $data = M('facility_msg')->find(I('id'));
            if($data['facility_type']==1){
                $data['facility_type'] = '塔式起重机';
            }elseif($data['facility_type']==2){
                $data['facility_type'] = '施工升降机';
            }
            $make = M('company')->find($data['make_company']);
            $data['make_company'] = $make['name'];
            $param = M('facility_parameter')->where(array('fid'=>array('eq',I('id'))))->select();

            exit(json_encode(array('status'=>1,'data'=>$data,'param'=>$param)));
            die;

        }else if($do == 'save'){
            $is_use = M('record')->where(array('beian_code'=>array('eq',I('beian_code'))))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该产权备案编号已被使用')));
                die;
            }
            $row = I('post.');
            unset($row['do']);
            unset($row['__hash__']);

            if($_FILES && $_FILES['license']['size']>0 ){
                $info = upFiles(null,'image');

                if($info){
                    $row['file'] = '/Public/' . $info['file']['savepath'] . $info['file']['savename'];
                }

            }else{
                $row['file'] = '';
            }

            $row['create_company'] = session('userinfo.company_id');
            $row['create_time'] = date('Y-m-d H:i:s');

//            dump($row);die;
            $id = M('record')->add($row);

            if($id){
                M('facility_msg')->where(array('id'=>array('eq',I('fac_id'))))->save(array('equity_number'=>I('beian_code'),'is_record'=>1));
                exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'保存失败')));
                die;
            }
        }


        $this->company = M('company')->where(array('is_del'=>array('eq',0),'status'=>array('eq',3)))->select();
        $this->fac = M('facility_msg')->where(array('del'=>array('eq',0),'status'=>array('eq',1),'is_record'=>array('eq',0)))->select();

        $this->title = '添加备案';
    	$this->display();
    }


    public function record_edit(){

        $id = I('id');
        if(!$id){
            $this->error('请选择要修改的备案');
        }
        $do = I('do');

        if($do == 'get_company'){
            $data = M('company')->find(I('id'));
            $sheng  = M('region')->field('name')->find($data['sheng_id']);
            $shi  = M('region')->field('name')->find($data['shi_id']);
            $data['diqu'] = $sheng['name'].'-'.$shi['name'];

            exit(json_encode(array('status'=>1,'data'=>$data)));
            die;
        }else if($do == 'get_fac'){
            $data = M('facility_msg')->find(I('id'));
            if($data['facility_type']==1){
                $data['facility_type'] = '塔式起重机';
            }elseif($data['facility_type']==2){
                $data['facility_type'] = '施工升降机';
            }
            $make = M('company')->find($data['make_company']);
            $data['make_company'] = $make['name'];
            $param = M('facility_parameter')->where(array('fid'=>array('eq',I('id'))))->select();

            exit(json_encode(array('status'=>1,'data'=>$data,'param'=>$param)));
            die;

        }else if($do == 'save'){
            $is_use = M('record')->where(array('beian_code'=>array('eq',I('beian_code')),'id'=>array('neq',I('id'))))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该产权备案编号已被使用')));
                die;
            }
            $row = I('post.');

            unset($row['id']);
            unset($row['do']);
            unset($row['__hash__']);
            $row['status'] = 0;

            if($_FILES && $_FILES['license']['size']>0 ){
                $info = upFiles(null,'image');

                if($info){
                    $row['file'] = '/Public/' . $info['file']['savepath'] . $info['file']['savename'];
                }

            }else{
                $row['file'] = '';
            }


//            dump($row);die;
            $info = M('record')->find(I('id'));
            $res = M('record')->where(array('id'=>array('eq',I('id'))))->save($row);

            if($res!==false){
                M('facility_msg')->where(array('id'=>array('eq',$info['fac_id'])))->save(array('equity_number'=>'','is_record'=>0));
                M('facility_msg')->where(array('id'=>array('eq',I('fac_id'))))->save(array('equity_number'=>I('beian_code'),'is_record'=>1));
                exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'保存失败')));
                die;
            }
        }

        $this->info = D('Record')->getOne($id);

        $this->company = M('company')->where(array('is_del'=>array('eq',0),'status'=>array('eq',3)))->select();
        $this->fac = M('facility_msg')->where(array('del'=>array('eq',0),'status'=>array('eq',1),'is_record'=>array('eq',0)))->select();

        $this->title = '修改备案';
        $this->display('record_add');
    }


    public function record_detail(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的产权备案信息');
        }

        $this->info = D('Record')->getDetail($id);

        $this->title = '产权备案详情';
        $this->display();
    }


    public function c_record_detail(){
    	$id = I('id');
        if(!$id){
            $this->error('请选择要查看的产权备案信息');
        }
        $do = I('do');
        if($do == 'check'){
            $data = I('data');
            $id = I('id');
            $res = M('record')->where(array('id'=>array('eq',$id)))->save(array('status'=>$data));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }
        $this->info = D('Record')->getDetail($id);

        $this->title = '产权备案详情';
    	$this->display('record_detail');
    }


    public function record_download(){
        $id = I('get.id');
        $file = M('record')->find($id);
        $res = download_file($_SERVER['DOCUMENT_ROOT'].$file['file']);
        if(!$res){
            $this->error('文件不存在！');
        }
    }
    
    
   //安拆告知

	public function install_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');
            $info = D('Inform')->getData($row);

            foreach($info as $k=>$v){

                $check = '<label class="select-checkwaring">'.
                    '<input type="checkbox" value="'.$v['id'].'" class="fl check-item_waring"  name="check-item_waring">'.
                    '</label>';

                $chakan = '<a href="/Admin/File/install_detail/id'.'/'. $v['id'] .'" id="organ_check" ><i class="organ-look"></i></a>';
                $xiugai = '<a href="/Admin/File/install_edit/id'.'/'. $v['id'] .'" id="organ_item" ><i class="organ-editt"></i></a>';

                $result[] = array($check,$k+1,$v['equity_number'],$v['facility_type'],$v['facility_model_number'],$v['engin_name'],$v['diqu'],$v['company_name'],$v['code'],$v['status'],$v['beian_status'],$chakan,$xiugai);
            }
            $backData = array('data'=>$result?$result:array());
            exit(json_encode($backData));

        }elseif($do == 'del'){
            $res = M('inform')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }
        $this->sheng = D('Region')->get_sheng();


        $this->title = '安拆告知列表';


    	$this->display();
    }

    public function c_install_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');
            $info = D('Inform')->getData($row);

            foreach($info as $k=>$v){

                $check = '<label class="select-checkwaring">'.
                    '<input type="checkbox" value="'.$v['id'].'" class="fl check-item_waring"  name="check-item_waring">'.
                    '</label>';

                $chakan = '<a href="/Admin/File/c_install_detail/id'.'/'. $v['id'] .'" id="organ_check" ><i class="organ-look"></i></a>';
                $xiugai = '<a href="/Admin/File/install_edit/id'.'/'. $v['id'] .'" id="organ_item" ><i class="organ-editt"></i></a>';

                $result[] = array($check,$k+1,$v['equity_number'],$v['facility_type'],$v['facility_model_number'],$v['engin_name'],$v['diqu'],$v['company_name'],$v['code'],$v['status'],$v['beian_status'],$chakan,$xiugai);
            }
            $backData = array('data'=>$result?$result:array());
            exit(json_encode($backData));

        }elseif($do == 'del'){
            $res = M('inform')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }
        $this->sheng = D('Region')->get_sheng();


        $this->title = '安拆告知列表';


        $this->display('install_list');
    }
    
    public function install_add(){

        $do = I('do');
        if($do == 'get_record'){
            $data = M('record')->alias('a')
                               ->field('a.chanquan,b.name,c.*')
                               ->join('left join box_company b on a.chanquan=b.id')
                               ->join('left join box_facility_msg c on a.fac_id=c.id')
                               ->where(array('a.id'=>array('eq',I('id'))))
                               ->find();
            $type = array(
                1 => '塔式起重机',
                2 => '施工升降机',
            );

            $data['facility_type'] = $type[$data['facility_type']];

            exit(json_encode(array('status'=>1,'data'=>$data)));
            die;
        }elseif($do == 'get_engin'){
            $data = M('engineering')->find(I('id'));

            $sheng  = M('region')->field('name')->find($data['sheng_id']);
            $shi  = M('region')->field('name')->find($data['shi_id']);
            $data['diqu'] = $sheng['name'].'-'.$shi['name'];

            exit(json_encode(array('status'=>1,'data'=>$data)));
            die;
        }elseif($do=='save'){
            $is_use = M('inform')->where(array('code'=>array('eq',I('code')),'del'=>array('eq',0)))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该安拆告知编号已被使用')));
                die;
            }
//            dump(I('post.'));
//            dump($_FILES);die;

            $row = I('post.');

            $count = count(I('p_name'));

            $info = upFiles(null);
//
            if($info){


                $p_file = array();
                for($i=1;$i<=$count;$i++){
                    $file = 'p_file'.$i;
                    $p_file[$i-1] = '/Public/' . $info[$file]['savepath'] . $info[$file]['savename'];

                }

                if($_FILES['file']['size']>0){
                    $row['file'] = '/Public/' . $info['file']['savepath'] . $info['file']['savename'];
                }
            }

            unset($row['do']);
            unset($row['__hash__']);
            unset($row['header-styling']);
            unset($row['p_name']);
            unset($row['p_id']);
            unset($row['o_id']);
            unset($row['o_name']);
            unset($row['o_gangwei']);
            unset($row['o_IDcard']);
            unset($row['o_mobile']);

            $row['create_time'] = date('Y-m-d H:i:s');
            $row['create_company'] = session('userinfo.company_id');

            $id = M('inform')->add($row);

            if($id){

                M('record')->where(array('id'=>array('eq',I('r_id'))))->save(array('is_install'=>1));

                foreach(I('p_name') as $k=>$v){
                    $info = array(
                        'i_id'=>$id,
                        'name'=>$v,
                        'file'=>$p_file[$k]
                    );

                    M('inform_param')->add($info);
                }

                foreach(I('o_name') as $k=>$v){
                    $info = array(
                        'i_id'=>$id,
                        'name'=>$v,
                        'gangwei'=>I('o_gangwei')[$k],
                        'IDcard'=>I('o_IDcard')[$k],
                        'mobile'=>I('o_mobile')[$k],
                    );

                    M('inform_oper')->add($info);
                }

                exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'保存失败，请重试')));
                die;
            }
        }

        $this->beian = M('record')->where(array('status'=>array('eq',1),'is_install'=>array('eq',0),'del'=>array('eq',0)))->select();
        $this->engin = M('engineering')->where(array('status'=>array('eq',4),'is_del'=>array('eq',0)))->select();
        $this->company = M('company')->where(array('status'=>array('eq',3),'is_del'=>array('eq',0)))->select();
        $this->title = "新增安拆告知";
    	$this->display();
    }



    public function install_edit(){

        $id = I('id');
        if(!$id){
            $this->error('请选择要修改的安拆告知');
        }
        $do = I('do');
        if($do == 'get_record'){
            $data = M('record')->alias('a')
                ->field('a.chanquan,b.name,c.*')
                ->join('left join box_company b on a.chanquan=b.id')
                ->join('left join box_facility_msg c on a.fac_id=c.id')
                ->where(array('a.id'=>array('eq',I('id'))))
                ->find();
            $type = array(
                1 => '塔式起重机',
                2 => '施工升降机',
            );

            $data['facility_type'] = $type[$data['facility_type']];

            exit(json_encode(array('status'=>1,'data'=>$data)));
            die;
        }elseif($do == 'get_engin'){
            $data = M('engineering')->find(I('id'));

            $sheng  = M('region')->field('name')->find($data['sheng_id']);
            $shi  = M('region')->field('name')->find($data['shi_id']);
            $data['diqu'] = $sheng['name'].'-'.$shi['name'];

            exit(json_encode(array('status'=>1,'data'=>$data)));
            die;
        }elseif($do == 'del_param'){
            $res = M('inform_param')->where(array('id'=>array('eq',I('id'))))->delete();
            if($res){
                exit(json_encode(array('status'=>1,'msg'=>'删除成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'删除失败，请重试')));
                die;
            }

        }elseif($do == 'del_oper'){
            $res = M('inform_oper')->where(array('id'=>array('eq',I('id'))))->delete();
            if($res){
                exit(json_encode(array('status'=>1,'msg'=>'删除成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'删除失败，请重试')));
                die;
            }

        }elseif($do=='save'){
            $is_use = M('inform')->where(array('code'=>array('eq',I('code')),'id'=>array('neq',I('id')),'del'=>array('eq',0)))->find();
            if($is_use){
                exit(json_encode(array('status'=>0,'msg'=>'该安拆告知编号已被使用')));
                die;
            }

            $row = array(
                'r_id'=>I('r_id'),
                'f_id'=>I('f_id'),
                'e_id'=>I('e_id'),
                'c_id'=>I('c_id'),
                'code'=>I('code'),
                'address'=>I('address'),
                'type'=>I('type'),
                'work_time'=>I('work_time'),
                'beian_status'=>I('beian_status'),
                'beian_time'=>I('beian_time'),
                'status'=>0
            );

            $count = count(I('p_name'));

            $info = upFiles(null);
//
            if($info){


                $p_file = array();
                for($i=1;$i<=$count;$i++){
                    $file = 'p_file'.$i;
                    if($_FILES[$file]['size']>0){
                        $p_file[$i-1] = '/Public/' . $info[$file]['savepath'] . $info[$file]['savename'];
                    }else{
                        $p_file[$i-1] = '';
                    }


                }

                if($_FILES['file']['size']>0){
                    $row['file'] = '/Public/' . $info['file']['savepath'] . $info['file']['savename'];
                }
            }

            $old_data = M('inform')->find(I('id'));
            $res = M('inform')->where(array('id'=>array('eq',I('id'))))->save($row);


            if($res!==false){
                M('record')->where(array('id'=>array('eq',$old_data['r_id'])))->save(array('is_install'=>0));
                M('record')->where(array('id'=>array('eq',I('r_id'))))->save(array('is_install'=>1));
                foreach(I('p_name') as $k=>$v){

                    if(I('p_id')[$k]==''){
                        $info = array(
                            'i_id'=>I('id'),
                            'name'=>$v,
                            'file'=>$p_file[$k]
                        );

                        M('inform_param')->add($info);
                    }else{
                        $info = array(
                            'name'=>$v,
                            'file'=>$p_file[$k]
                        );

                        M('inform_param')->where(array('id'=>array('eq',I('p_id'))))->save($info);
                    }

                }

                foreach(I('o_name') as $k=>$v){
                    if(I('o_id')[$k]==''){
                        $info = array(
                            'i_id'=>I('id'),
                            'name'=>$v,
                            'gangwei'=>I('o_gangwei')[$k],
                            'IDcard'=>I('o_IDcard')[$k],
                            'mobile'=>I('o_mobile')[$k],
                        );
                        M('inform_oper')->add($info);
                    }else{
                        $info = array(
                            'name'=>$v,
                            'gangwei'=>I('o_gangwei')[$k],
                            'IDcard'=>I('o_IDcard')[$k],
                            'mobile'=>I('o_mobile')[$k],
                        );
                        M('inform_oper')->where(array('id'=>array('eq',I('o_id'))))->save($info);
                    }

                }

                exit(json_encode(array('status'=>1,'msg'=>'保存成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'保存失败，请重试')));
                die;
            }
        }
        $this->info = D('Inform')->getOne($id);
        $this->beian = M('record')->where(array('status'=>array('eq',1),'is_install'=>array('eq',0),'del'=>array('eq',0)))->select();
        $this->engin = M('engineering')->where(array('status'=>array('eq',4),'is_del'=>array('eq',0)))->select();
        $this->company = M('company')->where(array('status'=>array('eq',3),'is_del'=>array('eq',0)))->select();
        $this->title = "修改安拆告知";
        $this->display('install_add');
    }
    
    public function install_detail(){

        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的安拆告知详情');
        }

        $this->info = D('Inform')->getDetail($id);

        $this->title = '安拆告知详情';
    	$this->display();
    }

    public function c_install_detail(){

        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的安拆告知详情');
        }
        $do = I('do');
        if($do=='check'){
            $res = M('inform')->where(array('id'=>array('eq',I('id'))))->save(array('status'=>I('data')));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

        $this->info = D('Inform')->getDetail($id);

        $this->title = '安拆告知详情';
        $this->display('install_detail');
    }



    public function install_download(){
        $id = I('get.id');
        $file = M('inform_param')->find($id);
        $res = download_file($_SERVER['DOCUMENT_ROOT'].$file['file']);
        if(!$res){
            $this->error('文件不存在！');
        }
    }

    public function installs_download(){
        $id = I('get.id');
        $file = M('inform')->find($id);
        $res = download_file($_SERVER['DOCUMENT_ROOT'].$file['file']);
        if(!$res){
            $this->error('文件不存在！');
        }
    }
    
   
   //使用登记
   
   public function registration_list(){
       $do = I('do');
       if($do == 'listTableData'){
           $row = I('get.');
           $info = D('Use')->getData($row);

           foreach($info as $k=>$v){

               $check = '<label class="select-checkwaring">'.
                   '<input type="checkbox" value="'.$v['id'].'" class="fl check-item_waring"  name="check-item_waring">'.
                   '</label>';

               $chakan = '<a href="/Admin/File/registration_detail/id'.'/'. $v['id'] .'" id="organ_check" ><i class="organ-look"></i></a>';
               $xiugai = '<a href="/Admin/File/registration_edit/id'.'/'. $v['id'] .'" id="organ_item" ><i class="organ-editt"></i></a>';

               $result[] = array($check,$k+1,$v['equity_number'],$v['facility_type'],$v['facility_model_number'],$v['engin_name'],$v['diqu'],$v['company_name'],$v['status'],$v['beian_status'],$chakan,$xiugai);
           }
           $backData = array('data'=>$result?$result:array());
           exit(json_encode($backData));

       }elseif($do == 'del'){
           $res = M('use')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
           if($res){
               exit(json_encode(array('status'=>1)));
               die;
           }else{
               exit(json_encode(array('status'=>0)));
               die;
           }
       }
       $this->sheng = D('Region')->get_sheng();

       $this->title = '使用登记列表';
    	$this->display();
    }

    public function c_registration_list(){
        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');
            $info = D('Use')->getData($row);

            foreach($info as $k=>$v){

                $check = '<label class="select-checkwaring">'.
                    '<input type="checkbox" value="'.$v['id'].'" class="fl check-item_waring"  name="check-item_waring">'.
                    '</label>';

                $chakan = '<a href="/Admin/File/c_registration_detail/id'.'/'. $v['id'] .'" id="organ_check" ><i class="organ-look"></i></a>';
                $xiugai = '<a href="/Admin/File/registration_edit/id'.'/'. $v['id'] .'" id="organ_item" ><i class="organ-editt"></i></a>';

                $result[] = array($check,$k+1,$v['equity_number'],$v['facility_type'],$v['facility_model_number'],$v['engin_name'],$v['diqu'],$v['company_name'],$v['status'],$v['beian_status'],$chakan,$xiugai);
            }
            $backData = array('data'=>$result?$result:array());
            exit(json_encode($backData));

        }elseif($do == 'del'){
            $res = M('use')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }
        $this->sheng = D('Region')->get_sheng();

        $this->title = '使用登记列表';
        $this->display('registration_list');
    }
    
    public function registration_add(){
        $do = I('do');
        if($do == 'get_term'){
            $data = M('terminal')->alias('a')
                ->field('a.*,b.name as company_name')
                ->join('left join box_company b on a.terminal_company=b.id')
                ->where(array('a.id'=>array('eq',I('id'))))
                ->find();


            exit(json_encode(array('status'=>1,'data'=>$data)));
            die;
        }elseif($do=='save'){
//            dump(I('post.'));
//            dump($_FILES);die;

            $row = array(
                'r_id'=>I('r_id'),
                'f_id'=>I('f_id'),
                't_id'=>I('t_id'),
                'e_id'=>I('e_id'),
                'ins_company'=>I('ins_company'),
                'ins_contact'=>I('ins_contact'),
                'ins_mobile'=>I('ins_mobile'),
                'use_company'=>I('use_company'),
                'use_contact'=>I('use_contact'),
                'use_mobile'=>I('use_mobile'),
                'beian_status'=>I('beian_status'),
                'beian_time'=>I('beian_time'),
                'create_company'=>session('userinfo.company_id'),
                'create_time'=>date('Y-m-d H:i:s')
            );


            if($_FILES['file']['size']>0){
                $info = upFiles(null);
                if($info) {
                    $row['file'] = '/Public/' . $info['file']['savepath'] . $info['file']['savename'];
                }
            }


            $id = M('use')->add($row);
            if($id){
                foreach(I('o_name') as $k=>$v){
                    $info = array(
                        'use_id'=>$id,
                        'name'=>$v,
                        'gangwei'=>I('o_gangwei')[$k],
                        'IDcard'=>I('o_IDcard')[$k],
                        'mobile'=>I('o_mobile')[$k],
                    );
                    M('use_oper')->add($info);
                }

                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }

        $this->beian = M('record')->where(array('status'=>array('eq',1),'del'=>array('eq',0)))->select();
        $this->term = M('terminal')->where(array('status'=>array('eq',1),'del'=>array('eq',0)))->select();
        $this->engin = M('engineering')->where(array('status'=>array('eq',4),'is_del'=>array('eq',0)))->select();
        $this->company = M('company')->where(array('status'=>array('eq',3),'is_del'=>array('eq',0)))->select();
        $this->title = "新增使用登记";

    	$this->display();
    }


    public function registration_edit(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要修改的使用登记');
        }
        $do = I('do');
        if($do == 'get_term'){
            $data = M('terminal')->alias('a')
                ->field('a.*,b.name as company_name')
                ->join('left join box_company b on a.terminal_company=b.id')
                ->where(array('a.id'=>array('eq',I('id'))))
                ->find();


            exit(json_encode(array('status'=>1,'data'=>$data)));
            die;
        }elseif($do=='save'){
//            dump(I('post.'));
//            dump($_FILES);die;

            $row = array(
                'r_id'=>I('r_id'),
                'f_id'=>I('f_id'),
                't_id'=>I('t_id'),
                'e_id'=>I('e_id'),
                'ins_company'=>I('ins_company'),
                'ins_contact'=>I('ins_contact'),
                'ins_mobile'=>I('ins_mobile'),
                'use_company'=>I('use_company'),
                'use_contact'=>I('use_contact'),
                'use_mobile'=>I('use_mobile'),
                'beian_status'=>I('beian_status'),
                'beian_time'=>I('beian_time'),
                'status'=>0,

            );


            if($_FILES['file']['size']>0){
                $info = upFiles(null);
                if($info) {
                    $row['file'] = '/Public/' . $info['file']['savepath'] . $info['file']['savename'];
                }
            }


            $res = M('use')->where(array('id'=>array('eq',I('id'))))->save($row);

            if($res!==false){
                foreach(I('o_name') as $k=>$v){
                    if(I('o_id')[$k]==''){
                        $info = array(
                            'use_id'=>$id,
                            'name'=>$v,
                            'gangwei'=>I('o_gangwei')[$k],
                            'IDcard'=>I('o_IDcard')[$k],
                            'mobile'=>I('o_mobile')[$k],
                        );
                        M('use_oper')->add($info);
                    }else{
                        $info = array(
                            'name'=>$v,
                            'gangwei'=>I('o_gangwei')[$k],
                            'IDcard'=>I('o_IDcard')[$k],
                            'mobile'=>I('o_mobile')[$k],
                        );
                        M('use_oper')->where(array('id'=>array('eq',I('o_id'))))->save($info);
                    }

                }

                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }elseif($do == 'del_oper'){
            $res = M('use_oper')->where(array('id'=>array('eq',I('id'))))->delete();
            if($res){
                exit(json_encode(array('status'=>1,'msg'=>'删除成功')));
                die;
            }else{
                exit(json_encode(array('status'=>0,'msg'=>'删除失败，请重试')));
                die;
            }

        }
        $this->info = D('Use')->getOne($id);
        $this->beian = M('record')->where(array('status'=>array('eq',1),'del'=>array('eq',0)))->select();
        $this->term = M('terminal')->where(array('status'=>array('eq',1),'del'=>array('eq',0)))->select();
        $this->engin = M('engineering')->where(array('status'=>array('eq',4),'is_del'=>array('eq',0)))->select();
        $this->company = M('company')->where(array('status'=>array('eq',3),'is_del'=>array('eq',0)))->select();
        $this->title = "修改使用登记";

        $this->display('registration_add');
    }
    
    public function registration_detail(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的使用登记详情');
        }
        $this->info = D('Use')->getDetail($id);

        $this->title = "使用登记详情";
    	$this->display();
    }

    public function c_registration_detail(){
        $id = I('id');
        if(!$id){
            $this->error('请选择要查看的使用登记详情');
        }
        $do = I('do');
        if($do == 'check'){
            $res = M('use')->where(array('id'=>array('eq',I('id'))))->save(array('status'=>I('data')));
            if($res){
                if(I('data')==1){
                    $id = M('use')->find(I('id'));
                    $count = M('engineering')->find($id['e_id']);
                    $type = M('facility_msg')->find($id['f_id']);
                    if($type['facility_type']==1){
                        $count = $count['taji']+1;
                        M('engineering')->where(array('id'=>array('eq',$id['e_id'])))->save(array('taji'=>$count));
                    }else{
                        $count = $count['shengjiangji']+1;
                        M('engineering')->where(array('id'=>array('eq',$id['e_id'])))->save(array('shengjiangji'=>$count));
                    }
                }
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }
        $this->info = D('Use')->getDetail($id);

        $this->title = "使用登记详情";
        $this->display('registration_detail');
    }


    public function reg_download(){
        $id = I('get.id');
        $file = M('use')->find($id);
        $res = download_file($_SERVER['DOCUMENT_ROOT'].$file['file']);
        if(!$res){
            $this->error('文件不存在！');
        }
    }





	  //资质管理
   
   public function aptitude_list(){


       $do = I('do');
       if($do == 'listTableData'){
           $row = I('get.');

           $info = D('Aptitude')->getData($row);


           foreach($info as $k=>$v){
               $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="check_all"><span class="fl"></span></label>';
               if($v['type']==1){
                   $chakan = '<a href="/Admin/Organization/organ_detail/id'.'/'. $v['connet'] .'"   class="shenhe" id="organ_check"><i class="organ-look"></i></a>';
                   $bianji = '<a href="/Admin/Organization/organ_edit/id'.'/'. $v['connet'] .'"  class="bianji" id="organ_item"><i class="organ-editt"></i></a>';
               }else{
                   $chakan = '<a href="/Admin/Organization/person_detail/id'.'/'. $v['connet'] .'"   class="shenhe" id="organ_check"><i class="organ-look"></i></a>';
                   $bianji = '<a href="/Admin/Organization/person_edit/id'.'/'. $v['connet'] .'"  class="bianji" id="organ_item"><i class="organ-editt"></i></a>';
               }


               $result[] = array($check,$k+1,$v['code'],$v['a_type'],$v['name'],$v['level'],$v['connet_name'],$v['daoqi'],$v['is_daoqi'],$chakan,$bianji);
           }
           $backData = array('data'=>$result?$result:array());


           exit(json_encode($backData));
       }elseif($do == 'del'){
           $res = M('aptitude')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
           if($res){
               exit(json_encode(array('status'=>1)));
               die;
           }else{
               exit(json_encode(array('status'=>0)));
               die;
           }
       }


       $this->title = '资质列表';
       $this->display();
    }

   public function c_aptitude_list(){


        $do = I('do');
        if($do == 'listTableData'){
            $row = I('get.');

            $info = D('Aptitude')->getData($row);


            foreach($info as $k=>$v){
                $check = '<label class="select-check"><input type="checkbox" value="'. $v['id'] .'" class="check_all"><span class="fl"></span></label>';
                if($v['type']==1){
                    $chakan = '<a href="/Admin/Organization/c_organ_detail/id'.'/'. $v['connet'] .'"   class="shenhe" id="organ_check"><i class="organ-look"></i></a>';
                    $bianji = '<a href="/Admin/Organization/organ_edit/id'.'/'. $v['connet'] .'"  class="bianji" id="organ_item"><i class="organ-editt"></i></a>';
                }else{
                    $chakan = '<a href="/Admin/Organization/c_person_detail/id'.'/'. $v['connet'] .'"   class="shenhe" id="organ_check"><i class="organ-look"></i></a>';
                    $bianji = '<a href="/Admin/Organization/person_edit/id'.'/'. $v['connet'] .'"  class="bianji" id="organ_item"><i class="organ-editt"></i></a>';
                }


                $result[] = array($check,$k+1,$v['code'],$v['a_type'],$v['name'],$v['level'],$v['connet_name'],$v['daoqi'],$v['is_daoqi'],$chakan,$bianji);
            }
            $backData = array('data'=>$result?$result:array());


            exit(json_encode($backData));
        }elseif($do == 'del'){
            $res = M('aptitude')->where(array('id'=>array('IN',I('id'))))->save(array('del'=>1));
            if($res){
                exit(json_encode(array('status'=>1)));
                die;
            }else{
                exit(json_encode(array('status'=>0)));
                die;
            }
        }


        $this->title = '资质列表';
        $this->display('aptitude_list');
    }
    


}