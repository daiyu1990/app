<?php
/**
 * @Author: Sincez
 * @Date:   2016-10-27 17:20:09
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-03-16 13:30:35
 */
namespace Admin\Model;
use Think\Model;
class CodeModel extends Model
{
	protected $tableName = 'code';

	protected $col = 'name,code,val,trees,ord,pid,uid,modify_time';

	public function insertData($row){
		$data = array_bykeys($row,$this->col);
		if($row['id']){
			$this->where(array('id'=>$row['id']))->save($data);
		} else {
			$this->add($data);
		}
	}

    public function getData($row){
        if($row['code']){
            $this->where(array('code'=>$row['code']));
            $data = $this->order('ord asc')->select();
        }
        if($row['id']){
            $this->where(array('id'=>$row['id']));
            $data = $this->order('ord asc')->find();
        }
        return $data;
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


    /**
     * 生成下拉框内容
     * @param $data 原数据
     * @param $select 选中项的codeid,逗号隔开
     * @param $tg 某项不输出
     * @param $prefix 选中项
     * @param $level 级别
     */
    public static function treeSel($data, $select = '', $tg = null, $prefix = '&nbsp;&nbsp;', $level = 0) {
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
            $html .= sprintf('<option value="%d" %s>%s%s</option>', $v['id'], in_array($v['id'], $select) ? 'selected="selected"' : '', $pre, $v['name']);
            $html .= self::treeSel($v['tree'], $select, $tg, $prefix, $level);
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
            $cz = "<a href='".U('Code/add',array('do'=>'up','id'=>$v['id']))."' class='btn btn-sm btn-info m-r-5 edit'>更新</a><a href='".U('Code/add',array('do'=>'del','id'=>$v['id']))."' class='btn btn-sm btn-danger del'>删除</a>";
            $html.=sprintf('<tr><td>%d</td><td><input type="text" class="form-control" value="%s"/></td><td><input type="text" class="form-control" value="%s"  /></td><td><input type="text" class="form-control" value="%s"/></td><td>%s</td></tr>', $v['id'], $prefix . $v['name'], $v['val'], $v['ord'], $cz);
            $html.=self::treeList($v['tree'], $level);
        }
        return $html;
    }

    /**
     * 生成列表内容
     * @param $data 原数据
     * @param $level 级别
     */
    public static function treeList2($data, $level = 0) {
        $level++;
        $html = '';
        foreach ($data as $v) {
            if ($v['pid'] == 0) {
                $prefix = '';
            } else {
                $prefix = '└' . str_repeat('─', $level - 1);
            }
            $trees = explode(',',$v['trees']);
            if(count($trees)>2){
                $cz = create_Url('Admin/Param/edit','编辑',array('id'=>$v['id']),'class="btn btn-sm btn-info m-r-5 edit"').create_Url('Admin/Param/del','删除',array('id'=>$v['id']),'class="btn btn-sm btn-danger del"');
            }
            $html.=sprintf('<tr id="node-%d"  %s><td>%s</td><td>%d</td><td>%s</td></tr>', $v['id'],$v['pid']?'class="child-of-node-'.$v['pid'].'"':'',$prefix . $v['name'], $v['ord'], $cz);
            $html.=self::treeList2($v['tree'], $level);
        }
        return $html;
    }
}