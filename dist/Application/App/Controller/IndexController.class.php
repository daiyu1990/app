<?php
/**
 * @Author: Sincez
 * @Date:   2016-10-27 10:09:14
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-06-29 12:35:57
 */
namespace App\Controller;
use Think\Controller;
class IndexController extends Controller
{
	public function index(){	//name:app访问
		// C('DEFAULT_THEME', 'Wap');
		// $this->display();
        $theme = 'default';
        $this->display('./tpl/theme/'.$theme.'/index.html');
	}

	public function themeStatic()
    {
		$theme = 'default';
		$pathinfo = $_SERVER['PATH_INFO'];
		$this->redirect('http://'.$_SERVER['SERVER_NAME'].'/tpl/theme/'.$theme.'/'.$pathinfo);
    }

	public function source(){

        $file = request()->url(true);
        if (file_exists($file)) {
             $this->redirect($file);
        }else{
            return json('资源不存在', 404);
        }
    }
}