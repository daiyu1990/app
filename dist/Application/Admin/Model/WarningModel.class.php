<?php
/**
 * @Author: Sincez
 * @Date:   2016-02-25 22:35:59
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-02-25 22:37:48
 */
namespace Admin\Model;
use Think\Model;
class WarningModel extends Model
{


    public function getData($is_refresh,$ter)
    {

        if(!$is_refresh){

            $ter = M('crane_realtime')
                ->field('terminal_number')
                ->group('terminal_number')
                ->select();

        }




            $info = array();

            foreach ($ter as $k => $v) {

                $info[$k] = M('crane_realtime')
                    ->field('
                        id,terminal_number,time,work_type,liju,weight,height,hz_jd,fudu,fengsu,

                        output_outside_lower,output_inside_lower,
                        xc_outside_lower,xc_inside_lower,area_outside_lower,area_inside_lower,
                        fpz_outside_lower,fpz_inside_lower,output_left_lower,output_right_lower,
                        xc_left_lower,xc_right_lower,area_left_lower,area_right_lower,fpz_left_lower,
                        fpz_right_lower,output_up_lower,output_down_lower,xc_up_lower,xc_down_lower,
                        area_up_lower,area_down_lower,fpz_up_lower,fpz_down_lower,output_fsyj,weight_ninety_yj,
                        lj_ninety_yj,

                        output_outside_stop,output_inside_stop,
                        xc_outside_stop,xc_inside_stop,area_outside_stop,area_inside_stop,
                        fpz_outside_stop,fpz_inside_stop,output_left_stop,output_right_stop,
                        xc_left_stop,xc_right_stop,area_left_stop,area_right_stop,fpz_left_stop,
                        fpz_right_stop,output_up_stop,output_down_stop,xc_up_stop,xc_down_stop,
                        area_up_stop,area_down_stop,fpz_up_stop,fpz_down_stop,output_fsbj,weight_bj,
                        lj_bj,

                        no_niutuixiao_error,ds_bf,ds_fs,ds_up,ds_hz,weight_limiter_error,liju_limiter_error,
                        fudu_machine_error,height_machine_error,hz_machine_error,front_msg,back_msg,left_msg,right_msg
                    ')
                    ->where(array('terminal_number' => array('eq', $v['terminal_number'])))
                    ->order('time DESC')
                    ->find();

//                dump(M('crane_real')->getlastsql());
//                dump($info);die;


                $ol = M('terminal')->alias('a')
                    ->field('b.did')
                    ->join('left join box_crane_msgid as b on a.id=b.did')
                    ->where(array('a.terminal_number' => array('eq', $v['terminal_number'])))
                    ->find();

                if ($ol['did'] != '') {
                    $info[$k]['ol'] = '在线';
                } else {
                    $info[$k]['ol'] = '离线';
                }


                $info[$k]['work_type'] = $info[$k]['work_type'] == 2 ? '是' : '否';


                $info[$k]['cq_num'] = 'test00' . $k;
                $info[$k]['sb_type'] = '塔式起重机';
                $info[$k]['project_name'] = '测试00' . $k;
                $info[$k]['gd_zbh'] = $k . '#';
                $info[$k]['danwei'] = '中建'.($k+1).'局';
                $info[$k]['czy'] = '老王';




//              判断是否预警

                //            判断幅度是否预警
                if( $info[$k]['output_outside_lower']==0 ||
                    $info[$k]['output_inside_lower']==0 ||
                    $info[$k]['xc_outside_lower']==0 ||
                    $info[$k]['xc_inside_lower']==0 ||
                    $info[$k]['area_outside_lower']==0 ||
                    $info[$k]['area_inside_lower']==0 ||
                    $info[$k]['fpz_outside_lower']==0 ||
                    $info[$k]['fpz_inside_lower']==0
                ){
                    $info[$k]['y_fudu'] = 1;
                }else{
                    $info[$k]['y_fudu'] = 0;
                }

               //            判断回转是否预警
                if( $info[$k]['output_left_lower']==0 ||
                    $info[$k]['output_right_lower']==0 ||
                    $info[$k]['xc_left_lower']==0 ||
                    $info[$k]['xc_right_lower']==0 ||
                    $info[$k]['area_left_lower']==0 ||
                    $info[$k]['area_right_lower']==0 ||
                    $info[$k]['fpz_left_lower']==0 ||
                    $info[$k]['fpz_right_lower']==0
                ){
                    $info[$k]['y_huizhuan'] = 1;
                }else{
                    $info[$k]['y_huizhuan'] = 0;
                }

                //            判断高度是否预警
                if( $info[$k]['output_up_lower']==0 ||
                    $info[$k]['output_down_lower']==0 ||
                    $info[$k]['xc_up_lower']==0 ||
                    $info[$k]['xc_down_lower']==0 ||
                    $info[$k]['area_up_lower']==0 ||
                    $info[$k]['area_down_lower']==0 ||
                    $info[$k]['fpz_up_lower']==0 ||
                    $info[$k]['fpz_down_lower']==0
                ){
                    $info[$k]['y_gaodu'] = 1;
                }else{
                    $info[$k]['y_gaodu'] = 0;
                }

                //            判断风速是否预警
                if( $info[$k]['output_fsyj']==0){
                    $info[$k]['y_fengsu'] = 1;
                }else{
                    $info[$k]['y_fengsu'] = 0;
                }

                //            判断重量是否预警
                if( $info[$k]['weight_ninety_yj']==0){
                    $info[$k]['y_zhongliang'] = 1;
                }else{
                    $info[$k]['y_zhongliang'] = 0;
                }

                //            判断力矩是否预警
                if( $info[$k]['lj_ninety_yj']==0){
                    $info[$k]['y_liju'] = 1;
                }else{
                    $info[$k]['y_liju'] = 0;
                }




//              判断是否报警

                //            判断幅度是否报警
                if( $info[$k]['output_outside_stop']==0 ||
                    $info[$k]['output_inside_stop']==0 ||
                    $info[$k]['xc_outside_stop']==0 ||
                    $info[$k]['xc_inside_stop']==0 ||
                    $info[$k]['area_outside_stop']==0 ||
                    $info[$k]['area_inside_stop']==0 ||
                    $info[$k]['fpz_outside_stop']==0 ||
                    $info[$k]['fpz_inside_stop']==0
                ){
                    $info[$k]['w_fudu'] = 1;
                }else{
                    $info[$k]['w_fudu'] = 0;
                }


                //            判断回转是否报警
                if( $info[$k]['output_left_stop']==0 ||
                    $info[$k]['output_right_stop']==0 ||
                    $info[$k]['xc_left_stop']==0 ||
                    $info[$k]['xc_right_stop']==0 ||
                    $info[$k]['area_left_stop']==0 ||
                    $info[$k]['area_right_stop']==0 ||
                    $info[$k]['fpz_left_stop']==0 ||
                    $info[$k]['fpz_right_stop']==0
                ){
                    $info[$k]['w_huizhuan'] = 1;
                }else{
                    $info[$k]['w_huizhuan'] = 0;
                }


                //            判断高度是否报警
                if( $info[$k]['output_up_stop']==0 ||
                    $info[$k]['output_down_stop']==0 ||
                    $info[$k]['xc_up_stop']==0 ||
                    $info[$k]['xc_down_stop']==0 ||
                    $info[$k]['area_up_stop']==0 ||
                    $info[$k]['area_down_stop']==0 ||
                    $info[$k]['fpz_up_stop']==0 ||
                    $info[$k]['fpz_down_stop']==0
                ){
                    $info[$k]['w_gaodu'] = 1;
                }else{
                    $info[$k]['w_gaodu'] = 0;
                }

                //            判断风速是否报警
                if( $info[$k]['output_fsbj']==0){
                    $info[$k]['w_fengsu'] = 1;
                }else{
                    $info[$k]['w_fengsu'] = 0;
                }

                //            判断重量是否报警
                if( $info[$k]['weight_bj']==0){
                    $info[$k]['w_zhongliang'] = 1;
                }else{
                    $info[$k]['w_zhongliang'] = 0;
                }

                //            判断力矩是否报警
                if( $info[$k]['lj_bj']==0){
                    $info[$k]['w_liju'] = 1;
                }else{
                    $info[$k]['w_liju'] = 0;
                }




//             判断一级报警
                $info[$k]['top_warning'] = '';
                $warning_info = C('WARNING_CODE');

                //            判断牛腿销轴是否报警
                if( $info[$k]['no_niutuixiao_error']==0){
                    $info[$k]['top_warning'] = $warning_info[0].',';
                }

                //            判断顶升变幅作业是否报警
                if( $info[$k]['ds_bf']==0){
                    $info[$k]['top_warning'] = $warning_info[1].',';
                }

                //            判断顶升四级风速是否报警
                if( $info[$k]['ds_fs']==0){
                    $info[$k]['top_warning'] = $warning_info[2].',';
                }

                //            判断顶升起升作业是否报警
                if( $info[$k]['ds_up']==0){
                    $info[$k]['top_warning'] = $warning_info[3].',';
                }

                //            判断顶升回转作业是否报警
                if( $info[$k]['ds_hz']==0){
                    $info[$k]['top_warning'] = $warning_info[4].',';
                }

                //            判断重量限制功能是否报警
                if( $info[$k]['weight_limiter_error']==0){
                    $info[$k]['top_warning'] = $warning_info[5].',';
                }

                //            判断力矩限制是否报警
                if( $info[$k]['liju_limiter_error']==0){
                    $info[$k]['top_warning'] = $warning_info[6].',';
                }

                //            判断幅度限制功能是否报警
                if( $info[$k]['fudu_machine_error']==0){
                    $info[$k]['top_warning'] = $warning_info[7].',';
                }

                //            判断高度限制功能是否报警
                if( $info[$k]['height_machine_error']==0){
                    $info[$k]['top_warning'] = $warning_info[8].',';
                }

                //            判断回转限制功能是否报警
                if( $info[$k]['hz_machine_error']==0){
                    $info[$k]['top_warning'] = $warning_info[9].',';
                }

                //            判断垂直度是否报警
                if( $info[$k]['front_msg']==0 ||
                    $info[$k]['back_msg']==0 ||
                    $info[$k]['left_msg']==0 ||
                    $info[$k]['right_msg']==0
                ){
                    $info[$k]['top_warning'] = $warning_info[10].',';
                }



                if($info[$k]['top_warning'] == ''){
                    $info[$k]['top_warning'] = '-';
                    $info[$k]['is_top'] = 0;
                }else{
                    $info[$k]['top_warning'] = substr($info[$k]['top_warning'],0,strlen($info[$k]['top_warning'])-1);
                    $info[$k]['is_top'] = 1;
                }



            }

            $count = count($ter);


//        dump($info);die;
        return array('info' => $info, 'count' => $count);
    }


    public function getWarning($arr,$time,$type){

//        报警信息
        $warning = array(
            'fudu' => 0,
            'gaodu' => 0,
            'fengsu' => 0,
            'huizhuan' => 0,
            'zhongliang' => 0,
            'liju' => 0,
        );

//        一级报警信息
        $warning_top = array(
            'niutui' => 0,
            'bianfu' => 0,
            'fengsu' => 0,
            'qisheng' => 0,
            'top_huizhuan' => 0,
            'zhongliang' => 0,
            'liju' => 0,
            'fudu' => 0,
            'gaodu' => 0,
            'huizhuan' => 0,
            'chuizhi' => 0
        );

        foreach($arr as $k=>$v){

//            获取普通报警数量
            $warning['fudu'] +=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',11),
                    'terminal_number'=>array('eq',$v)
                ))
                ->count();

            $warning['gaodu'] +=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',12),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning['fengsu'] +=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',13),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning['huizhuan'] +=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',14),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning['zhongliang'] +=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',15),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning['liju'] +=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',16),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();


//            获取一级报警数量
            $warning_top['niutui']+=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',0),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning_top['bianfu']+=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',1),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning_top['fengsu']+=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',2),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning_top['qisheng']+=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',3),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning_top['top_huizhuan']+=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',4),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning_top['zhongliang']+=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',5),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning_top['liju']+=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',6),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning_top['fudu']+=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',7),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning_top['gaodu']+=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',8),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning_top['huizhuan']+=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',9),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();

            $warning_top['chuizhi']+=
                (int)M('warning_code')->where(array(
                    'time'=>array('egt',$time),
                    'warning_code'=>array('eq',10),
                    'terminal_number'=>array('eq',$v)
                ))
                    ->count();



        }

        if($type=='day'){


            $time_warning = array();

            for($i=0;$i<=23;$i++){
                $time_warning[$i]['war']=0;
                $time_warning[$i]['top']=0;
            }


            foreach($arr as $k=>$v) {

                for($i=0;$i<=23;$i++) {

//
                    $count_war = M('warning_code')->where(array(
                                'time'=>array('egt',$time),
                                'hours'=>array('eq',$i),
                                'warning_code'=>array('IN','11,12,13,14,15,16'),
                                'terminal_number'=>array('eq',$v)

                            ))
                           ->count();

                    $count_top = M('warning_code')->where(array(
                        'time'=>array('egt',$time),
                        'hours'=>array('eq',$i),
                        'warning_code'=>array('IN','0,1,2,3,4,5,6,7,8,9,10'),
                        'terminal_number'=>array('eq',$v)

                    ))
                        ->count();

                    $time_warning[$i]['war']+=(int)$count_war;
                    $time_warning[$i]['top']+=(int)$count_top;

                }
            }


        }else{

            $time_warning = array();

            $date = strtotime($time);

            if($type == 'week'){
                $day = 6;
            }
            if($type == 'month'){
                $day = 30;
            }

            foreach($arr as $k=>$v) {

                for ($i = 0; $i <= $day; $i++) {

                    $start = date('Y-m-d H:i:s', (int)$date + (86400 * $i));
                    $end = date('Y-m-d H:i:s', (int)$date + (86400 * ($i + 1)));


                    $count_war = M('warning_code')
                        ->where(array(
                            'time' => array(array('egt', $start), array('lt', $end)),
                            'warning_code' => array('IN', '11,12,13,14,15,16'),
                            'terminal_number' => array('eq', $v)

                        ))
                        ->count();


                    $count_top = M('warning_code')
                        ->where(array(
                            'time' => array(array('egt', $start), array('lt', $end)),
                            'warning_code' => array('IN', '0,1,2,3,4,5,6,7,8,9,10'),
                            'terminal_number' => array('eq', $v)

                        ))
                        ->count();


                    $time_warning[$i]['war'] += (int)$count_war;
                    $time_warning[$i]['top'] += (int)$count_top;
                    $time_warning[$i]['riqi'] = substr($start, 5, 5);


                }
            }

        }



        return array('warning'=>$warning,'top'=>$warning_top,'time'=>$time_warning,'type'=>$type);

    }



//    public function getWarning($arr, $time, $type)
//    {
//
//        if($type == 'day'){
//            $time_warning = array();
//
//            for($i=0;$i<=23;$i++){
//                $time_warning[$i]['war']=0;
//                $time_warning[$i]['top']=0;
//            }
//
//        }elseif($type == 'week'){
//
//        }elseif($type == 'month')
//
//
//
//
////                            报警信息
//        //报警数组
//        $warning = array(
//            'fudu' => 0,
//            'gaodu' => 0,
//            'fengsu' => 0,
//            'huizhuan' => 0,
//            'zhongliang' => 0,
//            'liju' => 0,
//        );
//
////        幅度报警条件
//        $fudu_warning = array(
//            'output_outside_stop' => array('eq', 0),
//            'output_inside_stop' => array('eq', 0),
//            'xc_outside_stop' => array('eq', 0),
//            'xc_inside_stop' => array('eq', 0),
//            'area_outside_stop' => array('eq', 0),
//            'area_inside_stop' => array('eq', 0),
//            'fpz_outside_stop' => array('eq', 0),
//            'fpz_inside_stop' => array('eq', 0),
//            '_logic' => 'or',
//        );
//
////        高度报警条件
//        $gaodu_warning = array(
//            'output_up_stop' => array('eq', 0),
//            'output_down_stop' => array('eq', 0),
//            'xc_up_stop' => array('eq', 0),
//            'xc_down_stop' => array('eq', 0),
//            'area_up_stop' => array('eq', 0),
//            'area_down_stop' => array('eq', 0),
//            'fpz_up_stop' => array('eq', 0),
//            'fpz_down_stop' => array('eq', 0),
//            '_logic' => 'or',
//        );
//
////        回转报警条件
//        $huizhuan_warning = array(
//            'output_left_stop' => array('eq', 0),
//            'output_right_stop' => array('eq', 0),
//            'xc_left_stop' => array('eq', 0),
//            'xc_right_stop' => array('eq', 0),
//            'area_left_stop' => array('eq', 0),
//            'area_right_stop' => array('eq', 0),
//            'fpz_left_stop' => array('eq', 0),
//            'fpz_right_stop' => array('eq', 0),
//            '_logic' => 'or',
//        );
//
////        风速报警条件
//        $fengsu_warning = array(
//            'output_fsbj' => array('eq', 0),
//        );
//
////        重量报警条件
//        $zhongliang_warning = array(
//            'weight_bj' => array('eq', 0),
//        );
//
////        力矩报警条件
//        $liju_warning = array(
//            'lj_bj' => array('eq', 0),
//        );
//
//
////                          一级报警信息;
////      一级报警数组
//        $warning_top = array(
//            'niutui' => 0,
//            'bianfu' => 0,
//            'fengsu' => 0,
//            'qisheng' => 0,
//            'top_huizhuan' => 0,
//            'zhongliang' => 0,
//            'liju' => 0,
//            'fudu' => 0,
//            'gaodu' => 0,
//            'huizhuan' => 0,
//            'chuizhi' => 0
//        );
//
//
////        牛腿销轴一级报警条件
//        $niutui_top = array(
//            'no_niutuixiao_error' => array('eq', 0)
//        );
//
////        变幅一级报警条件
//        $bianfu_top = array(
//            'ds_bf' => array('eq', 0)
//        );
//
////        风速一级报警条件
//        $fengsu_top = array(
//            'ds_fs' => array('eq', 0)
//        );
//
////        起升一级报警条件
//        $qisheng_top = array(
//            'ds_up' => array('eq', 0)
//        );
//
////        顶升回转一级报警条件
//        $top_huizhuan_top = array(
//            'ds_hz' => array('eq', 0)
//        );
//
////        重量一级报警条件
//        $zhongliang_top = array(
//            'weight_limiter_error' => array('eq', 0)
//        );
//
//        //        力矩一级报警条件
//        $liju_top = array(
//            'liju_limiter_error' => array('eq', 0)
//        );
//
////        幅度一级报警条件
//        $fudu_top = array(
//            'fudu_machine_error' => array('eq', 0)
//        );
//
////        高度一级报警条件
//        $gaodu_top = array(
//            'height_machine_error' => array('eq', 0)
//        );
//
////        回转一级报警条件
//        $huizhuan_top = array(
//            'hz_machine_error' => array('eq', 0)
//        );
//
////        垂直一级报警条件
//        $chuizhi_top = array(
//            'front_msg' => array('eq', 0),
//            'back_msg' => array('eq', 0),
//            'left_msg' => array('eq', 0),
//            'right_msg' => array('eq', 0),
//            '_logic' => 'or',
//        );
//
////        获取报警数量
//        foreach ($arr as $k => $v) {
//
////            获取幅度报警数量
//
//            $fudu = $this->count($v,$time,$fudu_warning);
//
//            $warning['fudu'] += (int)$fudu;
//
//
////            获取高度报警数量
//
//            $gaodu = $this->count($v,$time,$gaodu_warning);
//
//            $warning['gaodu'] += (int)$gaodu;
//
//
////            获取回转报警数量
//
//            $huizhuan = $this->count($v,$time,$huizhuan_warning);
//
//            $warning['huizhuan'] += (int)$huizhuan;
//
//
////            获取风速报警数量
//
//            $fengsu = $this->count($v,$time,$fengsu_warning);
//
//            $warning['fengsu'] += (int)$fengsu;
//
//
////            获取重量报警数量
//
//            $zhongliang = $this->count($v,$time,$zhongliang_warning);
//
//            $warning['zhongliang'] += (int)$zhongliang;
//
//
////            获取力矩报警数量
//
//            $liju = $this->count($v,$time,$liju_warning);
//
//            $warning['liju'] += (int)$liju;
//
//
////                  获取一级报警数量
//
//
////            获取牛腿销轴一级报警数量
//
//            $niutui = $this->count($v,$time,$niutui_top);
//
//            $warning_top['niutui'] += (int)$niutui;
//
//
////            获取变幅一级报警数量
//
//            $bianfu = $this->count($v,$time,$bianfu_top);
//
//            $warning_top['biangu'] += (int)$bianfu;
//
//
////            获取风速一级报警数量
//
//            $fengsu = $this->count($v,$time,$fengsu_top);
//
//            $warning_top['fengsu'] += (int)$fengsu;
//
//
////            获取起升一级报警数量
//
//            $qisheng = $this->count($v,$time,$qisheng_top);
//
//            $warning_top['qisheng'] += (int)$qisheng;
//
//
////            获取顶升回转一级报警数量
//
//            $top_huizhuan = $this->count($v,$time,$top_huizhuan_top);
//
//            $warning_top['top_huizhuan'] += (int)$top_huizhuan;
//
//
////            获取重量一级报警数量
//
//            $zhongliang = $this->count($v,$time,$zhongliang_top);
//
//            $warning_top['zhongliang'] += (int)$zhongliang;
//
//
////            获取力矩一级报警数量
//
//            $liju = $this->count($v,$time,$liju_top);
//
//            $warning_top['liju'] += (int)$liju;
//
//
////            获取幅度一级报警数量
//
//            $fudu = $this->count($v,$time,$fudu_top);
//
//            $warning_top['fudu'] += (int)$fudu;
//
//
////            获取高度一级报警数量
//
//            $gaodu = $this->count($v,$time,$gaodu_top);
//
//            $warning_top['gaodu'] += (int)$gaodu;
//
//
////            获取回转一级报警数量
//
//            $huizhuan = $this->count($v,$time,$huizhuan_top);
//
//            $warning_top['huizhuan'] += (int)$huizhuan;
//
//
////            获取垂直一级报警数量
//            $chuizhi = $this->count($v,$time,$chuizhi_top);
//
//            $warning_top['chuizhi'] += (int)$chuizhi;
//
//            if($type == 'day'){
//
//                for($i=0;$i<=23;$i++){
////                    报警数量
//                    $time_warning[$i]['war'] += (int)$this->day_count($v,$time,$fudu_warning,$i);
//                    $time_warning[$i]['war'] += (int)$this->day_count($v,$time,$gaodu_warning,$i);
//                    $time_warning[$i]['war'] += (int)$this->day_count($v,$time,$huizhuan_warning,$i);
//                    $time_warning[$i]['war'] += (int)$this->day_count($v,$time,$fengsu_warning,$i);
//                    $time_warning[$i]['war'] += (int)$this->day_count($v,$time,$zhongliang_warning,$i);
//                    $time_warning[$i]['war'] += (int)$this->day_count($v,$time,$liju_warning,$i);
//
////                    一级报警数量
//                    $time_warning[$i]['top'] += (int)$this->day_count($v,$time,$niutui_top,$i);
//                    $time_warning[$i]['top'] += (int)$this->day_count($v,$time,$bianfu_top,$i);
//                    $time_warning[$i]['top'] += (int)$this->day_count($v,$time,$fengsu_top,$i);
//                    $time_warning[$i]['top'] += (int)$this->day_count($v,$time,$qisheng_top,$i);
//                    $time_warning[$i]['top'] += (int)$this->day_count($v,$time,$top_huizhuan_top,$i);
//                    $time_warning[$i]['top'] += (int)$this->day_count($v,$time,$zhongliang_top,$i);
//                    $time_warning[$i]['top'] += (int)$this->day_count($v,$time,$liju_top,$i);
//                    $time_warning[$i]['top'] += (int)$this->day_count($v,$time,$fudu_top,$i);
//                    $time_warning[$i]['top'] += (int)$this->day_count($v,$time,$gaodu_top,$i);
//                    $time_warning[$i]['top'] += (int)$this->day_count($v,$time,$huizhuan_top,$i);
//                    $time_warning[$i]['top'] += (int)$this->day_count($v,$time,$chuizhi_top,$i);
//
//                }
//            }
//        }
//
////        dump($time_warning);die;
//
//
//
//
//        return array('warning'=>$warning,'top'=>$warning_top,'time'=>$time_warning);
//    }
//
//    public function count($terminal,$time,$data){
//        $map = array(
//            'terminal_number' => $terminal,
//            'time' => array('egt',$time),
//            '_complex' => $data,
//            '_logic' => 'and'
//        );
//        $count = M('crane_realtime')
//            ->where($map)
//            ->count();
//
//        return $count;
//
//
//    }
//
//    public function day_count($terminal,$time,$data,$hours){
//        $map = array(
//            'terminal_number' => $terminal,
//            'time' => array('egt',$time),
//            'hours' =>array('eq',$hours),
//            '_complex' => $data,
//            '_logic' => 'and'
//        );
//        $count = M('crane_realtime')
//            ->where($map)
//            ->count();
//
//        return $count;
//
//
//    }

}