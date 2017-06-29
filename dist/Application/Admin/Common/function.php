<?php

function getWuliu($typeCom,$typeNu){
    $AppKey = C('KUAIDI_KEY');//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
    $url = 'http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=0&muti=1&order=desc';
    import("Org.Util.Snoopy");
    $snoopy = new \Snoopy();
    $snoopy->referer = 'http://www.baidu.com/';//伪装来源
    $snoopy->fetch($url);
    $content = $snoopy->results;
    return $content;
}

function setCurUrl($append_param){
    $param = I('get.');
    $last_param = array_merge($param,$append_param);
    $url = U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME,$last_param);
    return $url;
}
function getGroupName($gids,$group){
    if(!is_array($gids)){
        $gids = explode(',',$gids);
    }
    foreach($gids as $v){
        $groupname .= ($group[$v]['title'].'、');
    }
    return trim($groupname,'、');
}

function getAllName($gids,$arr,$colname=''){
    if(!is_array($gids)){
        $gids = explode(',',$gids);
    }
    foreach($gids as $v){
        if($colname){
            $allname .= ($arr[$v][$colname].'、');
        } else {
           $allname .= ($arr[$v].'、'); 
        }
    }
    return trim($allname,'、');
}

function getNoticChecks()
{
    if(session('userinfo.groupid')==1)
    {
        $uid = session('userinfo.uid');
        unset($map);
        $map['from'] = $uid;
        $map['ischeck'] = 2;
        $num = M('users')->where($map)->count();
        return $num;
    }else
    {
        return false;
    }
}

function getColname($col){
    switch($col){
        case 'hour':
            $colname = '小时';
            break;
        case 'day':
            $colname = '日期';
            break;
        case 'week':
            $colname = '周';
            break;
        case 'adusername':
            $colname = '广告主';
            break;
        case 'product_name':
            $colname = '产品名称';
            break;
        case 'ad_name':
            $colname = '广告活动';
            break;
        case 'seat_name':
            $colname = '广告栏目';
            break;
        case 'media':
            $colname = '媒体';
            break;
        case 'province':
            $colname = '省份';
            break;
        case 'channel':
            $colname = '广告位置／形式';
            break;
        case 'exposure':
            $colname = '展现量';
            break;
        case 'click':
            $colname = '点击量';
            break;
        case 'click_percent':
            $colname = '点击率';
            break;
        case 'land_percent':
            $colname = '到达率';
            break;
        case 'land':
            $colname = '到达访问次数';
            break;
        case 'frequency':
            $colname = '广告展现频次';
            break;
        case 'exposure_uv':
            $colname = '独立访客';
            break;
        case 'land_uv':
            $colname = '到达访问次数';
            break;
        case 'username':
            $colname = '用户名';
                break;    
        case 'email':
            $colname = '邮箱';
                    break;   
        case 'create_time':
            $colname = '创建时间';
                break;
        case 'income_full':
            $colname = '全量收入';
                break;
        case 'click_full':
            $colname = '全量点击量';
                break;
        case 'click_rate_full':
            $colname = '全量点击率';
                break;
        case 'ccrate':
            $colname = '抽成比例';
                break;                        
    }
    return $colname;
}

/**
     * 创建文件并写入数据
     * @param array $tableTitle 标题数据，键值为单元格的位置，例如：array('A1'=>'姓名','B1'=>'年龄')
     * @param array $bodyData 主体数据，格式为二维数组，第二维键值为单元格位置，例如：array(array('A1'=>'张三','B1'=>'25'),array('A2'=>'李四','B2'=>'26'))
     * @param array $property 表属性
     */
    function writeExcel($tableTitle, $bodyData,  $property = array(),$export=true) {
        set_time_limit(0);
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");
        $objPHPExcel = new PHPExcel();
        $activeSheet = $objPHPExcel->getActiveSheet();
        if($property['settitle']){
            $activeSheet->setTitle($property['settitle']);
        }
        $cursheet = $objPHPExcel->setActiveSheetIndex(0);
        foreach ($tableTitle as $k => $v) {
            $cursheet->getStyle(str_replace(1,'',$k))->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $cursheet->setCellValueExplicit($k, $v, PHPExcel_Cell_DataType::TYPE_STRING);
            $activeSheet->getStyle($k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $activeSheet->getStyle(substr($k, 0, 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $activeSheet->getColumnDimension(substr($k, 0, 1))->setAutoSize(true);
        }
        foreach ($bodyData as $k=>$v) {
            foreach ($v as $x => $z) {
                $cursheet->getStyle($x)->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $cursheet->setCellValueExplicit($x,$z, PHPExcel_Cell_DataType::TYPE_STRING);
            }
        }
        $creator = isset($property['creator']) ? $property['creator'] : ''; //作者
        $modifier = isset($property['modifier']) ? $property['modifier'] : ''; //修改人
        $title = isset($property['title']) ? $property['title'] : ''; //标题
        $subject = isset($property['subject']) ? $property['subject'] : ''; //主题
        $description = isset($property['description']) ? $property['description'] : ''; //描述
        $keywords = isset($property['keywords']) ? $property['keywords'] : ''; //关键字
        $category = isset($property['category']) ? $property['category'] : ''; //分类
        $objPHPExcel->getProperties()
                ->setCreator($creator)->setLastModifiedBy($modifier)
                ->setTitle($title)->setSubject($subject)
                ->setDescription($description)
                ->setKeywords($keywords)
                ->setCategory($category);
        $objPHPExcel->setActiveSheetIndex(0);
        $format = $property['format'] ? $property['format'] : 'Excel5';
        $filename = $property['filename'] ? $property['filename'] : date('YmdHis').'.xls';
        if($export){
            header("Content-type:application/vnd.ms-excel" );
            header("Content-Disposition:filename=" . $filename);
            header('Pragma: cache');
            header('Cache-Control: public, must-revalidate, max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $format);
            $objWriter->save('php://output');
        }else{
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $format);
            $objWriter->save($filename);
        }


    }

    function exportExcel($titlename,$row,$filename,$export=true){
        $col = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $t = array_keys($titlename);
        foreach($t as $k=>$v){
            $title[$col[$k].'1'] = $titlename[$v];   
        }
        $i = 2;//print_r($row);die;
        foreach($row as $k=>$v){
            if(!array_filter($v))continue;
            foreach($t as $a=>$c){
                if($c == 'xh'){
                    $body[$i][$col[$a] . $i] = $k+1;
                } else{
                    $body[$i][$col[$a] . $i] = $v[$c];
                } 
            }
            $i++;
        }
        writeExcel($title,$body,array('filename'=>$filename),$export);
    }
    //
    function exportExcelDetail($titlename,$row,$filename,$export=true,$type){
        $col = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        if($type == 3){
            $t = array('i','picUrl1','style','pcategory','ktype','number','dtype','inch','kz','ktprice');
            $pstitle = array('配石信息','石头编号','重量','颜色','净度','粒数','金额');
            $ps = array('null','did','dweight','yellow','clarity','ls','dprice');
        } else {
            $t = array_keys($titlename);
            foreach($t as $k=>$v){
                $title[$col[$k].'1'] = $titlename[$v];   
            }
        }
        $cp_sumprice = $cp_sumaprice = $zs_weight = $zs_gjprice = $zs_sumprice= $jl = $zs = 0;
        $i = 3;
        foreach($row as $v){
            if(!array_filter($v))continue;
            if($type == 3){
                foreach($t as $a=>$c){
                    $body[$i][$col[$a] . $i] = $v[$c];
                    if($c == 'ktprice'){
                        $jl += str_replace(',','',$v[$c]);
                    }
                }
                $i++;
                $body[$i]['A' . $i] = '配石信息';
                $body[$i]['B' . $i] = '石头编号';
                $body[$i]['C' . $i] = '重量';
                $body[$i]['D' . $i] = '颜色';
                $body[$i]['E' . $i] = '净度';
                $body[$i]['F' . $i] = '粒数';
                $body[$i]['G' . $i] = '金额';
                $i++;
                foreach($ps as $a=>$c){
                    $body[$i][$col[$a] . $i] = $v[$c];
                    if($c == 'dprice'){
                        $zs+=$v[$c];
                    }
                }
                // $i++;
            } else {
                foreach($t as $a=>$c){
                    $body[$i][$col[$a] . $i] = $v[$c];
                    if($type == 2){
                        if($c == 'dweight'){
                            $zs_weight += $v[$c];
                        } elseif($c == 'price') {
                            $zs_sumprice += str_replace(',','',$v[$c]);
                        } elseif($c == 'intprice') {
                            $zs_gjprice += str_replace(',','',$v[$c]);
                        }
                        
                    } else {
                        if($c == 'price'){//print_r($v);die;
                            $cp_sumprice += str_replace(',','',$v[$c]);//echo $v[$c];die;
                        } elseif($c == 'aprice'){
                            $cp_sumaprice += str_replace(',','',$v[$c]);
                        } elseif($c == 'mweight'){
                            $cp_sumweight += $v[$c];
                        }
                    }
                }   
            }
            $i++;
        }
        if($type == 3){
            $i--;
            $body[$i]['A' . $i] = '合计：';
            $body[$i]['B' . $i] = '款式：'.count($row).'件';
            $body[$i]['C' . $i] = '金料额：'.$jl;
            $body[$i]['D' . $i] = '钻石粒数：';
            $body[$i]['E' . $i] = count($row).'粒';
            $body[$i]['F' . $i] = '钻石金额：';
            $body[$i]['G' . $i] = $zs;
            $body[$i]['H' . $i] = '总计：';
            $body[$i]['I' . $i] = $zs+$jl;//print_r($body);die;
        } elseif($type == 2) {
            $body[$i]['A' . $i] = '合计：';
            $body[$i]['D' . $i] = $zs_weight;
            $body[$i]['N' . $i] = $zs_gjprice;
            $body[$i]['P' . $i] = $zs_sumprice;
        } elseif($type == 1) {
            $body[$i]['A' . $i] = '合计：';
            $body[$i]['H' . $i] = $cp_sumweight;
            $body[$i]['I' . $i] = count($row);
            $body[$i]['J' . $i] = number_format($cp_sumprice,2);
            $body[$i]['K' . $i] = number_format($cp_sumaprice,2);
            // $body[$i]['H' . $i] = '总计：';
            // $body[$i]['I' . $i] = $zs+$jl;//print_r($body);die;
        }
        // print_r($body);die;
        writeExcelDetail($body,$type);
        // writeExcelDetail($title,$body,array('filename'=>$filename),$export,$type);
    }

    function writeExcelDetail($bodyData,$type){
        set_time_limit(0);
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Worksheet.Drawing");
        import("Org.Util.PHPExcel.Writer.Excel2007");
        $objPHPExcel = new PHPExcel();
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objActSheet = $objPHPExcel->getActiveSheet();

        if($property['settitle']){
            $objActSheet->setTitle($property['settitle']);
        }
        $cursheet = $objPHPExcel->setActiveSheetIndex(0);
        $objActSheet = $objPHPExcel->getActiveSheet();
        $objActSheet->getColumnDimension('B')->setWidth(14);
        if($type == 1){
            $objActSheet->mergeCells('A1:K1');
            $bodyData[] = array('A1'=>'查看订单-B成品');
            $tableTitle = array('A2'=>'序号','B2'=>'图片','C2'=>'所在分区','D2'=>'条形码','E2'=>'证书号','F2'=>'款号','G2'=>'品名','H2'=>'石重','I2'=>'粒数','J2'=>'标签价','K2'=>'销售价');
        } elseif($type == 2) {
            $objActSheet->mergeCells('A1:Q1');
            $bodyData[] = array('A1'=>'查看订单-A裸钻');
            $tableTitle = array('A2'=>'序号','B2'=>'内部编码','C2'=>'形状','D2'=>'重量','E2'=>'颜色','F2'=>'净度','G2'=>'切工','H2'=>'抛光','I2'=>'对称','J2'=>'荧光','K2'=>'证书类型','L2'=>'证书号','M2'=>'折扣','N2'=>'国际报价','O2'=>'销售单价','P2'=>'销售总价','Q2'=>'所在地');
        } elseif($type == 3){
            $objActSheet->mergeCells('A1:J1');
            $bodyData[] = array('A1'=>'查看订单-C定制');
            $tableTitle = array('A2'=>'序号','B2'=>'图片','C2'=>'款号','D2'=>'品名','E2'=>'成色','F2'=>'件数','G2'=>'证书','H2'=>'手寸','I2'=>'字印','J2'=>'金额');
            // $zsnum = count($bodyData)+2;
            // $bodyData = array('A'.$zsnum=>'配石信息','B'.$zsnum=>'石头编号','C'.$zsnum=>'重量','D'.$zsnum=>'颜色','E'.$zsnum=>'净度','F'.$zsnum=>'粒数','G'.$zsnum=>'金额');
        }
        
        //表头
        foreach ($tableTitle as $k => $v) {
            $cursheet->getStyle(str_replace(1,'',$k))->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $cursheet->setCellValueExplicit($k, $v, PHPExcel_Cell_DataType::TYPE_STRING);
            $cursheet->getStyle(str_replace(1,'',$k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        //body内容        
        foreach ($bodyData as $k=>$v) {
            $is_img = (strpos($v['B'.$k],'jpg') || strpos($v['B'.$k],'jpeg') || strpos($v['B'.$k],'png'))?1:0;
            if(($k>0 && $is_img && $type == 3) || ($k>0 && $is_img && $type == 1)){
                $objActSheet->getRowDimension($k)->setRowHeight(65);
            } else {
                // $objActSheet->getRowDimension($k)->setRowHeight(10);
            }
            // $objPHPExcel->getActiveSheet()->getRowDimension($x)->setRowHeight(120);
            foreach ($v as $x => $z) {

                
                $is_img = (strpos($z,'jpg') || strpos($z,'jpeg') || strpos($z,'png'))?1:0;
                if($is_img){//echo $x;die;
                    $name =  saveimage($z);
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setPath($name);
                    $objDrawing->setHeight(80);
                    $objDrawing->setWidth(80);
                    
                    $objDrawing->setOffsetX(12);
                    $objDrawing->setRotation(12);
                    $objDrawing->setCoordinates($x);
                    // $objDrawing->getShadow()->setVisible(true);
                    // $objDrawing->getShadow()->setDirection(50);
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

                     //$objPHPExcel->getActiveSheet()->setCellValue($x,'');
                    $nameArr[] = $name;
                    continue;
                }else{
                    $cursheet->getStyle($x)->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                    $cursheet->setCellValueExplicit($x,$z, PHPExcel_Cell_DataType::TYPE_STRING);
                    $cursheet->getStyle($x)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                }
                // if($type==1||$type==3){//print_r($v);die;
                    
                // }else{
                //     $cursheet->getStyle($x)->getNumberFormat()
                //         ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                //     $cursheet->setCellValueExplicit($x,$z, PHPExcel_Cell_DataType::TYPE_STRING);
                //     $cursheet->getStyle($x)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                // }
            }

        }

        $creator = isset($property['creator']) ? $property['creator'] : ''; //作者
        $modifier = isset($property['modifier']) ? $property['modifier'] : ''; //修改人
        $title = isset($property['title']) ? $property['title'] : ''; //标题
        $subject = isset($property['subject']) ? $property['subject'] : ''; //主题
        $description = isset($property['description']) ? $property['description'] : ''; //描述
        $keywords = isset($property['keywords']) ? $property['keywords'] : ''; //关键字
        $category = isset($property['category']) ? $property['category'] : ''; //分类
        $objPHPExcel->getProperties()
                ->setCreator($creator)->setLastModifiedBy($modifier)
                ->setTitle($title)->setSubject($subject)
                ->setDescription($description)
                ->setKeywords($keywords)
                ->setCategory($category);
        $objPHPExcel->setActiveSheetIndex(0);
        $format = $property['format'] ? $property['format'] : 'Excel5';
        $filename = $property['filename'] ? $property['filename'] : date('YmdHis').'.xls';
        header("Content-type:application/vnd.ms-excel" );
        header("Content-Disposition:filename=" . iconv('utf-8', 'gb2312', $filename));
        header('Pragma: cache');
        header('Cache-Control: public, must-revalidate, max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $format);
        $objWriter->save('php://output');
        foreach ($nameArr as $key => $value) {
            unlink($value);
        }
    }

    /**
     * 创建文件并写入数据
     * @param array $tableTitle 标题数据，键值为单元格的位置，例如：array('A1'=>'姓名','B1'=>'年龄')
     * @param array $bodyData 主体数据，格式为二维数组，第二维键值为单元格位置，例如：array(array('A1'=>'张三','B1'=>'25'),array('A2'=>'李四','B2'=>'26'))
     * @param array $property 表属性
     */
    // function writeExcelDetail($tableTitle, $bodyData,  $property = array(),$export=true,$type=1) {
    //     // print_r($bodyData);die;
    //     set_time_limit(0);
    //     import("Org.Util.PHPExcel");
    //     import("Org.Util.PHPExcel.Worksheet.Drawing");
    //     import("Org.Util.PHPExcel.Writer.Excel2007");
    //     $objPHPExcel = new PHPExcel();
    //     $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    //     $objActSheet = $objPHPExcel->getActiveSheet();

    //     if($property['settitle']){
    //         $objActSheet->setTitle($property['settitle']);
    //     }
    //     $cursheet = $objPHPExcel->setActiveSheetIndex(0);
    //     $objActSheet = $objPHPExcel->getActiveSheet();
    //     $objActSheet->getColumnDimension('B')->setWidth(14);
    //     // $objActSheet->mergeCells('A1'.$j.':D'.$j);
    //     //表头
    //     foreach ($tableTitle as $k => $v) {
    //         $cursheet->getStyle(str_replace(1,'',$k))->getNumberFormat()
    //                 ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    //         $cursheet->setCellValueExplicit($k, $v, PHPExcel_Cell_DataType::TYPE_STRING);
    //         $cursheet->getStyle(str_replace(1,'',$k))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //     }
    //     //body内容
    //     // $objActSheet = $objPHPExcel->getActiveSheet();
        
    //     foreach ($bodyData as $k=>$v) {
    //         // $objPHPExcel->getActiveSheet()->getRowDimension($x)->setRowHeight(120);
    //         foreach ($v as $x => $z) {
    //                 /*设置表格宽度*/
    //                 /*设置表格高度*/

    //                  $objActSheet->getRowDimension($k)->setRowHeight(65);
    //             if($type==1||$type==3){//print_r($v);die;
    //                 if($x{0}=='B'){//echo $x;die;
    //                     $name =  saveimage($z);
    //                     $objDrawing = new PHPExcel_Worksheet_Drawing();
    //                     $objDrawing->setPath($name);
    //                     $objDrawing->setHeight(80);
    //                     $objDrawing->setWidth(80);
                        
    //                     $objDrawing->setOffsetX(12);
    //                     $objDrawing->setRotation(12);
    //                     $objDrawing->setCoordinates($x);
    //                     // $objDrawing->getShadow()->setVisible(true);
    //                     // $objDrawing->getShadow()->setDirection(50);
    //                     $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

    //                      //$objPHPExcel->getActiveSheet()->setCellValue($x,'');
    //                     $nameArr[] = $name;
    //                     continue;
    //                 }else{
    //                 $cursheet->getStyle($x)->getNumberFormat()
    //                     ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    //                 $cursheet->setCellValueExplicit($x,$z, PHPExcel_Cell_DataType::TYPE_STRING);
    //                 }
    //             }else{
    //                 $cursheet->getStyle($x)->getNumberFormat()
    //                     ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    //                 $cursheet->setCellValueExplicit($x,$z, PHPExcel_Cell_DataType::TYPE_STRING);
    //             }
    //         }

    //     }

    //     $creator = isset($property['creator']) ? $property['creator'] : ''; //作者
    //     $modifier = isset($property['modifier']) ? $property['modifier'] : ''; //修改人
    //     $title = isset($property['title']) ? $property['title'] : ''; //标题
    //     $subject = isset($property['subject']) ? $property['subject'] : ''; //主题
    //     $description = isset($property['description']) ? $property['description'] : ''; //描述
    //     $keywords = isset($property['keywords']) ? $property['keywords'] : ''; //关键字
    //     $category = isset($property['category']) ? $property['category'] : ''; //分类
    //     $objPHPExcel->getProperties()
    //             ->setCreator($creator)->setLastModifiedBy($modifier)
    //             ->setTitle($title)->setSubject($subject)
    //             ->setDescription($description)
    //             ->setKeywords($keywords)
    //             ->setCategory($category);
    //     $objPHPExcel->setActiveSheetIndex(0);
    //     $format = $property['format'] ? $property['format'] : 'Excel5';
    //     $filename = $property['filename'] ? $property['filename'] : date('YmdHis').'.xls';
    //     if($export){
    //         header("Content-type:application/vnd.ms-excel" );
    //         header("Content-Disposition:filename=" . iconv('utf-8', 'gb2312', $filename));
    //         header('Pragma: cache');
    //         header('Cache-Control: public, must-revalidate, max-age=0');
    //         $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $format);
    //         $objWriter->save('php://output');
    //         foreach ($nameArr as $key => $value) {
    //             unlink($value);
    //         }
    //     }else{
    //         $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $format);
    //         $objWriter->save($filename);
    //         foreach ($nameArr as $key => $value) {
    //             unlink($value);
    //         }
    //     }


    // }
    function verify_code($verifycode){
        $verify = new \Think\Verify(array('reset'=>false));
        if(!empty($verifycode) && !$verify->check($verifycode)){
            exit(json_encode(array('error'=>l('verify_code').l('wrong'))));
        }
    }
    /**
    *更换url参数
    *@param     string $url 原url
    *@param     string $to  替换内容 默认 ‘add’
    *@param     string $delimiter url分隔符 默认 ／
    *@param     int $seg 需要替换的位置 默认2
    *@return    string 新的url
    */
    function get_nurl($url,$to='add',$delimiter='/',$seg = 2)
    {
        $urlarr = explode($delimiter,$url);
        $urlarr[$seg] = $to;
        $url = join($delimiter,$urlarr);
        return $url;
    }
//保存图片并返回本地绝对路径,参数远程图片路径数组 
function saveimage($path) {
    if ($path == '') return false;
        $url = $path; //远程图片路径
        if(stripos($url,'http://')!== false or stripos($url,'ftp://')!== false){ //仅处理外部路径
            $filename = substr($path, strripos($path, '/')); //图片名.后缀
            $ext = substr($path, strripos($path, '.')); //图片后缀
            $picdir = './Public/Uploads/'; //组合图片路径
            $savepath = $picdir . strtotime("now") . $ext; //保存新图片路径
            ob_start(); //开启缓冲
            readfile($url); //读取图片
            $img = ob_get_contents(); //保存到缓冲区
            ob_end_clean(); //关闭缓冲
            $fp2 = @fopen($savepath, "a"); //打开本地保存图片文件
            fwrite($fp2, $img); //写入图片
            fclose($fp2);

        } else {
            $savepath = $path; 
        }
    
    return $savepath; //返回本地保存绝对路径
}