<?php
/**
 * @Author: Sincez
 * @Date:   2017-06-22 09:56:24
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-06-22 09:56:54
 */
namespace Common\Controller;
use Think\Controller;
class ApiController extends Controller
{
	public function _initialize(){
		header('Access-Control-Allow-Origin: *');

		// if(!session('memberinfo.uid') && CONTROLLER_NAME != 'User'){
		// 	$arr = array('status'=>0,'msg'=>'请先登录系统！');
		// 	$this->ajaxReturn($arr);
		// }

  //       $groupid = session('memberinfo.groupid');
		// if($groupid == 1 || $groupid == 2 || $groupid == 3)
  //       {
  //           session('memberinfo', null);
  //           $arr = array(
  //               'status' => 0,
  //               'msg' => '管理员不能进入前台，请登录前台帐号'
  //           );
  //           $this->ajaxReturn($arr);
  //       }
	}
}