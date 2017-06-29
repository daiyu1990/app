<?php
/**
 * Created by coder meng.
 * User: coder meng
 * Date: 2017/3/15 16:08
 */
namespace Admin\Model;
use Think\Model;
class SimModel extends Model{
    protected $tableName='sim';
//    protected $col = 'simcard_num,pay_date,date,expire_date,terminalid';
    public function insertData($row){
        if($row){
            $row['pay_date'] = strtotime($row['pay_date']);
            $row['expire_date'] = strtotime($row['expire_date']);
        }
        $data = array_bykeys($row,$this->col);
        if($row['id']){
            $this->where(array('id'=>$row['id']))->save($data);
        } else {
            $res = $this->add($data);
            return $res;
        }
    }

    public function getOne($id){
        $info = $this->find($id);

        return $info;
    }

    public function getDetail($id){
        $info = $this
            ->alias('a')
            ->field('a.*,b.terminal_number,b.terminal_model_number,b.terminal_company,b.type as ter_type')
            ->join('left join box_terminal b on a.ter_id=b.id')
            ->where(array('a.id'=>array('eq',$id)))
            ->find();

        $internet = M('code')
            ->where(array('code'=>array('eq','Network_operator')))
            ->select();
        $yunying_arr = array();
        foreach($internet as $k=>$v){
            $yunying_arr[$v['val']] = $v['name'];
        }

        $xinhao = array(
            1 => '强',
            2 => '中',
            3 => '弱'
        );

        $daoqi = array(
            0 => '未到期',
            1 => '已到期'
        );

        $status = array(
            0 => '待审核',
            1 => '已审核',
            2 => '被驳回'
        );

        $ter_type = array(
            1=>'塔式升降机安全监控系统',
            2=>'施工起重机安全监控系统',
        );

        $info['yunying'] = $yunying_arr[$info['yunying']];
        $info['xinhao'] = $xinhao[$info['xinhao']];
        $info['daoqi'] = $daoqi[$info['daoqi']];
        $info['sim_status'] = $status[$info['status']];
        $info['ter_type'] = $status[$info['ter_type']];

        $ter_company = M('company')->find($info['terminal_company']);
        $info['terminal_company'] = $ter_company['name'];

        return $info;

    }

    public function getData($row){
        $map = array();
        if($row['code']!=''){
            $map['a.code'] = array('eq',$row['code']);
        }

        if($row['yunying']!=''){
            $map['a.yunying'] = array('eq',$row['yunying']);
        }

        if($row['status']!=''){
            $map['a.status'] = array('eq',$row['status']);
        }

        $map['a.del'] = array('eq',0);

        if(session('userinfo.uid')!=1){
            $map['a.create_company']=array('eq',session('userinfo.company_id'));
        }

        $data = $this
                ->alias('a')
                ->field('a.*,b.terminal_number')
                ->join('left join box_terminal b on a.ter_id=b.id')
                ->where($map)
                ->select();

        $internet = M('code')->where(array('code'=>array('eq','Network_operator')))->select();
        $yunying_arr = array();
        foreach($internet as $k=>$v){
            $yunying_arr[$v['val']] = $v['name'];
        }

        $xinhao_arr = array(
            1 => '弱',
            2 => '中',
            3 => '强'
        );

        $status = array(
            0 => '待审核',
            1 => '已审核',
            2 => '被驳回'
        );

        $now = time();

        foreach($data as $k=>$v){
            $data[$k]['yunying'] = $yunying_arr[$v['yunying']];
            $data[$k]['status'] = $status[$v['status']];

            $xinhao = M('crane_realtime')->field('gprs')->where(array('terminal_number'=>array('eq',$v['terminal_number'])))->order('time DESC')->find();
            if($xinhao){
                $data[$k]['xinhao'] = $xinhao_arr[$xinhao['gprs']];
            }else{
                $data[$k]['xinhao'] = '--';
            }

            if(strtotime($v['expire_date'])>$now){
                $data[$k]['daoqi'] = '未到期';
            }else{
                $data[$k]['daoqi'] = '已到期';
            }

        }

        return $data;
    }
}