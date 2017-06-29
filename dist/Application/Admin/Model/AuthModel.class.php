<?php
/**
 * @Author: Sincez
 * @Date:   2016-02-22 21:17:02
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-12-01 12:23:50
 */
namespace Admin\Model;
use Think\Model;
class AuthModel extends Model
{
    protected $tableName='auth_rule';

    protected $col = 'pid,name,title,type,status,condition,is_show,is_open,ord,class';

    public function insertData($row){
        $data = array_bykeys($row,$this->col);
        if($row['id']){
            $this->where(array('id'=>$row['id']))->save($data);
        } else {
            $this->add($data);
        }
    }

    public function firstMenu(){
        $groupid = session('userinfo.groupid');
        $groupinfo = D('Group')->find($groupid);
        // if($groupid!=1 && !session('userinfo.back_yes')){
            
        // }
        $leftmenu = D('Auth')->getLeftMenu($groupinfo['rules']);
        $curlan = strtolower(cookie('think_language'));
        $admin_menu = $curlan == 'zh-cn'?array('系统设置'):array('System settings');
        foreach($leftmenu as $vo){
            // $curtitle = $curlan == 'zh-cn'?$vo['title']:$vo['title_en'];
            // if(($groupid==1 && !in_array($curtitle,$admin_menu)) || (session('userinfo.back_yes')==1 && in_array($curtitle,$admin_menu)))continue;
            $i=1;
            foreach($vo['tree'] as $v){
                if($i == 1){
                    $url = U($v['name']);
                    break 2;
                }
                $i++;
            }
        }
        return $url;
    }


    /**
     * 获取树状结构
     * @param $cid 选项ID
     * @param $data 源数据
     */
    public static function getTree($cid, $data) {
        $items = array();
        foreach ($data as $v) {
            if ($v['pid'] == $cid) {
                $v['tree'] = self::getTree($v['id'], $data);
                $items[$v['id']] = $v;
            }
        }
        return $items;
    }
    public function getLeftMenu($mids){
        if($mids){
            $where['id'] = array('in',$mids);
        }
        $where['is_show'] = 1;
        // $where['is_menu'] = 1;
        $data = $this->order('if(ord=0,9999,ord)')->where($where)->select();
        $result = $this->getTree(0,$data);
        foreach($result as $v){
            if($v['name'] && authcheck($v['name']) && $v['is_show']){
            // if($v['name'] && $v['is_show']){
                $item[$v['id']] = $v;
            }
            if(!$v['tree']){
                continue;
            }
            $right = 0;
            foreach($v['tree'] as $t){
                if($t['name'] && authcheck($t['name']) && $t['is_show']){
                // if($t['is_show']){
                    $right++;
                }
            }
            if(!$right){
                continue;
            }
            // $item[$v['id']] = $v;print_r($item);die;
            $item[$v['id']] = array('id'=>$v['id'],'pid'=>$v['pid'],'title'=>$v['title'],'title_en'=>$v['title_en'],'name'=>$v['name'],'type'=>$v['type'],'status'=>$v['status'],'condition'=>$v['condition'],'is_show'=>$v['is_show'],'is_open'=>$v['is_open'],'ord'=>$v['ord'],'class'=>$v['class']);
            foreach($v['tree'] as $t){
                if(!authcheck($t['name']))continue;
                $item[$v['id']]['tree'][$t['id']] = $t;
                if(!$t['tree']){
                    continue;
                }
                foreach($t['tree'] as $s){
                    if(!authcheck($s['name']))continue;
                    $item[$v['id']]['tree'][$t['id']]['tree'][$s['id']] = $s;
                }
            }
        }


        return $item;

    }
    /**
     * 生成下拉选项
     * @param  array  $data   源数据
     * @param  array  $select 选中数组
     * @param  [type]  $tg     [description]
     * @param  string  $prefix 前缀
     * @param  integer $level  级别
     * @return [type]          树形下拉框
     */
    public static function treeOpiton($data, $select = '', $tg = null, $prefix = '&nbsp;&nbsp;', $level = 0){
        if (!is_array($select)) {
            $select = explode(',', $select);
        }
        $level++;
        $html = '';
        foreach ($data as $v) {
            if ($tg == $v['id'])
                continue;
            if ($v['pid'] == 0) {
                $pre = '';
            } else {
                $pre = '└' . str_repeat($prefix, $level - 1);
            }
            $html .= sprintf('<option value="%d" %s>%s%s</option>', $v['id'], in_array($v['id'], $select) ? 'selected="selected"' : '', $pre, $v['title']);
            $html .= self::treeOpiton($v['tree'], $select, $tg, $prefix, $level);
        }
        return $html;
    }

    /**
     * 生成列表内容
     * @param $data 原数据
     * @param $level 级别
     */
    public static function treeList($data, $level = 0) {
        $level++;
        $html = '';
        foreach ($data as $v) {
            if ($v['pid'] == 0) {
                $prefix = '';
            } else {
                $prefix = '└' . str_repeat('─', $level - 1);
            }
            $cz = (create_Url('Admin/Auth/add','添加子菜单',array('pid'=>$v['id']),'class="m-r-5 addMenu"').create_Url('Admin/Auth/edit','编辑',array('id'=>$v['id']),'class="m-r-5 addMenu"').create_Url('Admin/Auth/del','删除',array('id'=>$v['id']),'class="del"'));
            $ord = '<input type="text" class="form-control coledit" col="ord" target="'.$v['id'].'" value="'.$v['ord'].'" style="width:80px"/>';
            $html.=sprintf('<tr id="node-%d"  %s><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>', $v['id'],$v['pid']?'class="child-of-node-'.$v['pid'].'"':'',$ord,$v['id'], $prefix . $v['title'], $v['name'], create_Url('Admin/Auth/index',($v['is_show']?'隐藏':'显示'),array('do'=>'up'),'class="qh" target="'.$v['id'].'" val="'.($v['is_show']?0:1).'" col="is_show"'),  $cz);
            $html.=self::treeList($v['tree'], $level);
        }
        return $html;
    }

    public function scanMenu($mdirname)
    {
        $mdirname = ucwords($mdirname);
        $mdir = APP_PATH . $mdirname;
        if (!is_dir($mdir) || !preg_match('/^\w+$/', $mdirname)) {
            continue;
        }
        $cfilenames = scandir($mdir . '/Controller');
        $module = $mdirname;
        foreach ($cfilenames as $cfilename) {
            $file = $mdir . '/Controller/' . $cfilename;
            if (!is_file($file) || !preg_match('/^\w+Controller\.class\.php$/', $cfilename)) {
                continue;
            }
            $controller = substr($cfilename, 0, strlen($cfilename) - 20);
            $classname = ucwords($controller) . 'Controller';
            $content = file_get_contents($file);
            preg_match_all("/.*?public.*?function(.*?)\(.*?\)/i", $content, $matches);
            $str = '/^\s*public\s*function\s*([A-Za-z]+)\(\)\s*{?\s*\/\/\s*name\s*(?:\:|：)\s*(.*)\s*$/';
            $str = "/.*?public.*?function(.*?)\(.*?\){?.*?\/\/.*?name.*?(?:\:|：).*?(.*)/";
            preg_match_all($str, $content, $matches);
            // print_r($matches);die;
            $functions = $matches[1];
            $menunames = array();
            $menunames = $matches[2];
            //排除部分方法
            $inherents_functions = array('_initialize','__construct','getActionName','isAjax','display','show','fetch','buildHtml','assign','__set','get','__get','__isset','__call','error','success','ajaxReturn','redirect','__destruct','_empty');
            $customer_functions = array();
            foreach ($functions as $func){
                $func = trim($func);
                if(!in_array($func, $inherents_functions)){
                    $customer_functions[] = $func;
                }
            }
            foreach($customer_functions as $k=>$v){
                $title = $module.'/'.$controller.'/'.$v;
                $menu = $this->where(array('name'=>$title))->find();
                if(empty($menu)){
                    $menunew = array(
                            'pid' => 1, 'ord' => 0,
                            'title'=>$menunames[$k],
                            'name' => $title);
                    $this->add($menunew);
                }
            }
        }
    }
}