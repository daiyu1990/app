<?php
return array(
     // 添加下面一行定义即可
    //  'view_filter' => array('Behavior\TokenBuild'),
    // 如果是3.2.1版本 需要改成
    'view_filter' => array('Behavior\TokenBuildBehavior'),
    'app_begin'        => array('Behavior\CheckLangBehavior'),   //注意这里，官方的文档解释感觉有误（大家自行分辨），TP3.2.3用Behavior\CheckLang会出错，提示：Class 'Behavior\CheckLang' not found
);
