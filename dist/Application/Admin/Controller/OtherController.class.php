<?php
/**
 * Created by coder meng.
 * User: 设备管理
 * Date: 2017/3/15 14:55
 */
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AdminController;
class OtherController extends AdminController
{
	public function index(){
		$this->display();
	}
    
    public function quesition_survey(){
		$this->display();
	}
    
}