<?php
/**
 * @Author: Sincez
 * @Date:   2016-07-27 10:11:17
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-06-29 12:26:55
 */
namespace Admin\Controller;
use Think\Controller;
class EmptyController extends Controller{

	function _empty(){
		header( " HTTP/1.0  404  Not Found" );
		$this->display( 'Public:404 ' );


	}
    public function index(){
        header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码
        $this->display("Public:404");
    }
}
