<?php
/**
 * @Author: Sincez
 * @Date:   2017-06-19 13:22:04
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-06-19 13:22:27
 */
namespace Doc\Controller;
use Think\Controller;

class IndexController extends Controller {
	public function index(){	
		$name = I('name','index');
		$path = $_SERVER['DOCUMENT_ROOT']."/Public/docs/$name.md";
		$Parsedown = new \Org\Parse\Parsedown();
		$html = file_get_contents($path);
		$html = $Parsedown->text($html);
		// $html = file_get_contents($path);
		$this->html = $html;
		$this->display('base');
	}
}