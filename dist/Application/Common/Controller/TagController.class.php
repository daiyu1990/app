<?php
namespace Common\Controller;
use Think\Controller;
class TagController extends Controller {
    // public function __construct(){
    //     parent::__construct();
    // }
    /**
     * 添加标签
     * @param [string] $tag_name [标签字符串]
     */
    public function addTag($tag_name){
        $Tag = M('tag');
        $data['name'] = $tag_name;
        $result = $Tag->where($data)->find();
        if(!$result){
            $result = $Tag->data($data)->add();
            return $result;
        }
        return $result['tag_id'];
    }
    /**
     * 删除标签
     * @param [int] $parent_id [关联表ID]
     * @param [string] $relation_type [关联表表示]
     */
    public function deleteTags($parent_id,$relation_type){
        $TagRelation = M('tag_relation');
        $condition['parent_id'] = $parent_id;
        $condition['tag_relation_type'] = $relation_type;
        $TagRelation->where($condition)->delete();
    }
    /**
     * 存储标签
     * @param  [int] $parent_id     [关联表ID]
     * @param  [string] $tags          [标签字符串]
     * @param  [string] $relation_type [关联表标示]
     */
	public function updateTags($parent_id,$tags,$relation_type){
        $tags = trim($tags);
        if(!strlen($tags)){
            return;
        }
        $this->deleteTags($parent_id,$relation_type);
        $TagRelation = M('tag_relation');
        $tagAry = explode(',',$tags);
        // trace($tagAry);
        foreach ($tagAry as $key => $value){
            $tag_id = $this->addTag($value);
            // trace($tag);
            $data=array();
            $data['tag_id'] = $tag_id;
            $data['parent_id'] = $parent_id;
            $data['tag_relation_type'] = $relation_type;
            $TagRelation->add($data);
        }
	}
}