<?php
/**
 * Created by coder meng.
 * User: coder meng
 * Date: 2017/3/15 16:08
 */
namespace Admin\Model;
use Think\Model;
class TerminalModel extends Model{
    protected $tableName='terminal';
    protected $col = 'terminal_number,terminal_company,qualified_number,install_status,register_date,typeid';
    public function insertData($row){
        $data = array_bykeys($row,$this->col);
        if($row['id']){
            $this->where(array('id'=>$row['id']))->save($data);
        } else {
            $data['register_date'] = time();
            $res = $this->add($data);
            return $res;
        }
    }
    public function getData($row){

        $map = array();
        if($row['type']!=''){
            $map['type'] = array('eq',$row['type']);
        }

        if($row['code']!=''){
            $map['terminal_number'] = array('eq',$row['code']);
        }


        if(session('userinfo.uid')!=1){
            $map['create_company']=array('eq',session('userinfo.company_id'));
        }


        $map['del'] = array('eq',0);

        $info = $this->where($map)->select();

        $type = array(
            1=>'塔式起重机安全监控系统',
            2=>'施工升降机安全监控系统'
        );

        $check = array(
            0=>'待审核',
            1=>'已审核',
            2=>'被驳回'
        );

        foreach($info as $k=>$v){
            $ol = $this->alias('a')
                ->field('b.did')
                ->join('left join box_crane_msgid as b on a.id=b.did')
                ->where(array('a.terminal_number' => array('eq', $v['terminal_number'])))
                ->find();

            if ($ol['did'] != '') {
                $info[$k]['ol'] = '在线';
            } else {
                $info[$k]['ol'] = '离线';
            }

            $info[$k]['type'] = $type[$v['type']];
            $info[$k]['status'] = $check[$v['status']];

        }

        return $info;

    }

    public function getOne($id){

        $info = $this->find($id);

        $info['ass'] = M('terminal_assembly')->where(array('tid'=>array('eq',$id)))->select();

        return $info;


    }

    public function getDetail($id){

        $info = $this->find($id);

        $type = array(
            1=>'塔式起重机安全监控系统',
            2=>'施工升降机安全监控系统'
        );

        $company_name = M('company')->find($info['terminal_company']);

        $info['company_name'] = $company_name['name'];
        $info['type'] = $type[$info['type']];

        $info['ass'] = M('terminal_assembly')->where(array('tid'=>array('eq',$id)))->select();

        return $info;
    }
}