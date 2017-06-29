<?php
/**
 * Created by coder meng.
 * User: coder meng
 * Date: 2017/3/14 17:03
 */
namespace Admin\Model;
use Think\Model;
class RegionModel extends Model
{
    protected $tableName='region';
    protected $col ='name,level,parent_id,sort';
    public function insertData($row){
        $data = array_bykeys($row,$this->col);
        if($row['id']){
            $this->where(array('id'=>$row['id']))->save($data);
        } else {
            $this->add($data);
        }
    }
    public function getData($pid=0){
        $where['id'] = $pid;
        $data = $this->where($where)->find();
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
            if ($v['parent_id'] == $cid) {
                $v['tree'] = self::getTree($v['id'], $data);
                $items[$v['id']] = $v;
            }
        }
        return $items;
    }

    /**
     *  无限分类列表
     *@param $types array 分类结果集
     *@param $html string 子级分类填充字符串
     *@param $pid int 父类id
     *@param $num int 填充字符串个数
     *@return array 返回排序后结果集
     */
   public static function getList($types, $pid = 0){
        $arr = array();
        foreach($types as $v){
            if($v['parent_id'] == $pid){
                $arr[] = $v;
                $arr = array_merge($arr, self::getList($types,$v['id']));//递归把子类压入父类数组后
            }
        }
        return $arr;
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
            if ($v['parent_id'] == 0) {
                $prefix = '';
            } else {
                $prefix = '└' . str_repeat('─', $level - 1);
            }
            $cz = (create_Url('Admin/Region/add','添加子区域',array('parent_id'=>$v['id']),'class="m-r-5 addMenu"').create_Url('Admin/Region/edit','编辑',array('id'=>$v['id']),'class="m-r-5 addMenu"').create_Url('Admin/Region/del','删除',array('id'=>$v['id']),'class="del"'));
            $ord = '<input type="text" class="form-control coledit" col="sort" target="'.$v['id'].'" value="'.$v['sort'].'" style="width:80px"/>';
            $html.=sprintf('<tr id="node-%d"  %s><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>', $v['id'],$v['parent_id']?'class="child-of-node-'.$v['parent_id'].'"':'',$ord,$v['id'], $prefix . $v['name'],$cz);
            $html.=self::treeList($v['tree'], $level);
        }
        return $html;
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
            if ($v['parent_id'] == 0) {
                $pre = '';
            } else {
                $pre = '└' . str_repeat($prefix, $level - 1);
            }
            $html .= sprintf('<option value="%d" %s>%s%s</option>', $v['id'], in_array($v['id'], $select) ? 'selected="selected"' : '', $pre, $v['name']);
            $html .= self::treeOpiton($v['tree'], $select, $tg, $prefix, $level);
        }
        return $html;
    }

    public function get_sheng(){
        $res = $this->where(array(
            'level'=>array('eq',1),
        ))->order('sort ASC')
        ->select();

        return $res;
    }

    public function get_shi($id){
        $res = $this->where(array(
            'parent_id'=>array('eq',$id)
        ))->order('sort ASC')
        ->select();

        return $res;
    }
}