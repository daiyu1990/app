<?php
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
/**
 * @Author: Sincez
 * @Date:   2016-06-01 16:00:02
 * @Last Modified by:   Sincez
 * @Last Modified time: 2017-02-05 11:56:43
 */


function getpage($count, $pagesize = 10) {
	$p = new Think\Page($count, $pagesize);
//    $p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
	$p->setConfig('prev', '<');
	$p->setConfig('next', '>');
//    $p->setConfig('last', '末页');
//    $p->setConfig('first', '首页');
//    $p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
//    $p->lastSuffix = true;//最后一页不显示为总页数
	$p->rollPage=5;
	return $p;
}


function sendTemplateSMS($to,$datas,$tempId)
{

	include_once("CCPRestSmsSDK.php");

	//主帐号,对应开官网发者主账号下的 ACCOUNT SID
	$accountSid= '8a216da85cb0540d015cc922be42072a';

	//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
	$accountToken= '51bb1910af814abca5e1dd4632ab1ee4';

	//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
	//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
	$appId='8a216da85cb0540d015cc922be90072f';

	//请求地址
	//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
	//生产环境（用户应用上线使用）：app.cloopen.com
	$serverIP='sandboxapp.cloopen.com';


	//请求端口，生产环境和沙盒环境一致
	$serverPort='8883';

	//REST版本号，在官网文档REST介绍中获得。
	$softVersion='2013-12-26';
	// 初始化REST SDK
//	global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
	$rest = new REST($serverIP,$serverPort,$softVersion);
	$rest->setAccount($accountSid,$accountToken);
	$rest->setAppId($appId);

	// 发送模板短信
//	echo "Sending TemplateSMS to $to <br/>";
	$result = $rest->sendTemplateSMS($to,$datas,$tempId);
	if($result == NULL ) {
//		echo "result error!";
//		break;
		return false;
	}
	if($result->statusCode!=0) {
//		echo "error code :" . $result->statusCode . "<br>";
//		echo "error msg :" . $result->statusMsg . "<br>";

		return false;
		//TODO 添加错误处理逻辑
	}else{
//		echo "Sendind TemplateSMS success!<br/>";
		// 获取返回信息
		$smsmessage = $result->TemplateSMS;
//		echo "dateCreated:".$smsmessage->dateCreated."<br/>";
//		echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
		//TODO 添加成功处理逻辑
		return true;
	}
}



/**
 * 获取七牛token
 * @return token
 */
function getQiniuToken(){
    $accessKey = C('QINIU_ACCESSKEY');
    $secretKey = C('QINIU_SECRETKEY');
    $auth = new Auth($accessKey, $secretKey);
    $bucket = C('QINIU_SPACENAME');
    $token = $auth->uploadToken($bucket);
    return $token;
}

/**
 * 删除七牛图片
 * @param  [String] $pic_name [图片名称]
 * @return 返回信息
 */
function delQiniuOnePic($pic_name){
    // $accessKey = 'XNwUQv0UnzXmDBDytakQYer_DhDM-vbeZW-sdufe';
    // $secretKey = 'zfowh__jmZNC5yT2MC9ST5bFSKIg1ICZxNRLGlwy';
    $accessKey = C('QINIU_ACCESSKEY');
    $secretKey = C('QINIU_SECRETKEY');
    $auth = new Auth($accessKey, $secretKey);
    $bucketMgr = new BucketManager($auth);
    //你要测试的空间， 并且这个key在你空间中存在
    $bucket = C('QINIU_SPACENAME');
    $key = $pic_name;

    $err = $bucketMgr->delete($bucket, $key);
        // if ($err !== null) {
    //   var_dump($err);
    // } else {
    //   echo "Success!";
    // }
    return $err;

}
/**
 * 获取上一级地址
 * @return [String] [上一级地址]
 */
function returnUrl() {
	return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
}
/**
 * 行为日志记录
 * @param  [String] $content [日志内容]
 * @return
 */
function action_log($content){
	if(session('userinfo.back_yes')){
		$row['uid'] = session('userinfo.from_uid');
	} else {
		$row['uid'] = session('userinfo.uid');
	}
    $row['add_time'] = time();
    $row['ip'] = get_Ip();
    $row['remark'] = $content;
    $row['url'] = $_SERVER["REQUEST_URI"];
    $model = new \Admin\Model\ActionlogModel();
    $model->insertData($row);
}
/**
 * 生成权限地址
 * @param  [String] $url    [需要判读权限的地址：模块／控制器／方法]
 * @param  [String] $info   [链接名称]
 * @param  [String] $appUrl [url参数]
 * @param  [String] $attr   [url附加属性]
 * @return [String]         [权限验证后的地址]
 */
function create_Url($url, $info, $appUrl = '', $attr =''){
    $result = authCheck($url);
    // $result = true;
    if($result){
      $u = U($url,$appUrl);
      $dizhi = "<a href='{$u}' {$attr}>$info</a>";
      return $dizhi;
    }
}
/**
 * 判断下拉框，单选框，多选框是否选中
 * @param  [String]  $str  [被判断值]
 * @param  [String]  $item [当前值]
 * @param  [boolean] $c    [是否为下拉框]
 * @return [String]        [返回选中属性]
 */
function checked($str, $item, $c = false) {
	if (empty($str)) {
		return '';
	}
	$ary = explode(',', $str);
	$isIn = in_array($item, $ary);
	if ($isIn) {
		if ($c) {
			return 'selected';
		} else {
			return 'checked';
		}
	}
	return '';
}
/**
 * 序号生成
 * @param  int $i 当前页的第几条
 * @return int    生成序号
 */
function getChange($i){
    $page = $_GET['p']>0 ? $_GET['p'] : 1;
    $z = ($page - 1) * C("PAGE_LISTROWS") + $i;
    return $z;
}

/**
 * 根据某些字段名获取新数组
 * @param  array $array   原数组
 * @param  string $bykey   字段名
 * @param  array $toarray 新数组
 * @return array          新数组
 */
function array_bykeys($array, $bykey, $toarray = null) {
    if (empty($toarray)) {
        $toarray = array();
    }
    $keys = explode(',', $bykey);
    $keys = array_map('trim', $keys);
    foreach ($array as $key => $val) {
        if (in_array($key, $keys)) {
            $toarray[$key] = $val;
        }
    }
    return $toarray;
}

/**
 * 二位数据根据某一键值生成新的一维数组
 * @param  array $array 原来的二位数组
 * @param  string $key   键值
 * @return array        新的一维数组
 */
function array_coltoarray($array,$key){
    foreach($array as $v){
        $newarray[] = $v[$key];
    }
    return $newarray;
}

/**
 * 二维数组排序
 * @param string $arr 二维数组
 * @param string $keys 排序键值
 * @param string $type 排序方式 asc正序 desc倒
 */
function array_sort($arr, $keys, $type = 'asc') {
    $keysvalue = $new_array = array();
    foreach ($arr as $k => $v) {
        $keysvalue[$k] = $v[$keys];
    }
    if ($type == 'asc') {
        asort($keysvalue);
    } else {
        arsort($keysvalue);
    }
    reset($keysvalue);
    foreach ($keysvalue as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}

/**
 * 获取客户机IP
 * @param  boolean $isstr TRUE 或者 FALSE
 * @return          ip或者转换后的纯数字
 */
function get_Ip($isstr = false) {
    $ip = getenv('REMOTE_ADDR');
    $cIP1 = getenv('HTTP_X_FORWARDED_FOR');
    $cIP2 = getenv('HTTP_CLIENT_IP');
    $cIP1 ? $ip = $cIP1 : null;
    $cIP2 ? $ip = $cIP2 : null;
    if (empty($isstr)) {
        $ip = ip2long($ip);
    }
    return $ip;
}
function array_getcol($data, $col = 'id') {
	$func = create_function('$v', 'return $v[\'' . $col . '\'];');
	return array_map($func, $data);
}
/**
 * 以某个数组值当作主键生成数组
 * @param  [array] $data [原数组]
 * @param  string $key  [数组键值]
 * @return [array]       [生成新数组]
 */
function array_coltokey($data, $key = 'id') {
	return array_combine(array_getcol($data, $key), $data);
}

function change_to_quotes($str) {
	return sprintf("'%s'", $str);
}

/**
 * 获取周几
 * @param  [Int] $cur [week返回值]
 * @return [String]      [返回中文周几值]
 */
function getWeek($cur) {
	switch ($cur) {
		case 0:$week = '周日';
			break;
		case 1:$week = '周一';
			break;
		case 2:$week = '周二';
			break;
		case 3:$week = '周三';
			break;
		case 4:$week = '周四';
			break;
		case 5:$week = '周五';
			break;
		case 6:$week = '周六';
			break;
	}
	return $week;
}

/**
 * 发送Curl值
 * @param  [String] $url        [curl地址]
 * @param  [array] $parameters [curl参数数组]
 * @return [array]             [返回curl结果数组]
 */
function sendCurl($url, $parameters) {
	$content = json_encode($parameters);
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

	$json_response = curl_exec($curl);
	// var_dump($json_response);

	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

	// if ( $status != 200 ) {
	//     die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
	// }
	curl_close($curl);
	$response = json_decode($json_response, true);
	return $response;
}

/**
 * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
 * @return string
 */
function rand_string($len = 6, $type = '', $addChars = '') {
	$str = '';
	switch ($type) {
		case 0:
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
			break;
		case 1:
			$chars = str_repeat('0123456789', 3);
			break;
		case 2:
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
			break;
		case 3:
			$chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
			break;
		case 4:
			$chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借" . $addChars;
			break;
		case 5:
			$chars = '0123456789abcdefghijklmnopqrstuvwxyz' . $addChars;
			break;
		case 6:
			$chars = '123456789abcdefghijklmnpqrstuvwxyz' . $addChars;
			break;
		default :
			// 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
			$chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
			break;
	}
	if ($len > 10) {//位数过长重复字符串一定次数
		$chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
	}
	if ($type != 4) {
		$chars = str_shuffle($chars);
		$str = substr($chars, 0, $len);
	} else {
		// 中文随机字
		for ($i = 0; $i < $len; $i++) {
			$str.= msubstr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1);
		}
	}
	return $str;
}

/**
 * @param $receive_email 收件地址
 * @param $mail_subject  邮件标题
 * @param $mail_content  邮件内容
 * @param string $receive_name 收件人称呼
 * @param string $reply_email 复邮件地址
 * @param string $reply_name 回复邮件地址的称呼
 * @return array
 */
function send_mail($receive_email, $mail_subject, $mail_content, $receive_name = '', $reply_email = '', $reply_name = '') {
	import("Org.Phpmailer.Phpmailer");

	$mail = new PHPMailer();
	$mail->IsSMTP();		   // set mailer to use SMTP
	$mail->Host = C('MAIL_HOST_ADDRESS');  // specify main and backup server
	$mail->SMTPAuth = TRUE;  // turn on SMTP authentication
	$mail->Username = C('MAIL_USERNAME');  // SMTP username
	$mail->Password = C('MAIL_PASSWORD'); // SMTP password

	$mail->From = C('MAIL_FROM_EMAIL');
	$mail->FromName = C('MAIL_FROM_NAME');
	$mail->AddAddress($receive_email, $receive_name);
	//$mail->AddAddress("ellen@example.com");                  // name is optional
	$mail->AddReplyTo($reply_email, $reply_name);
	$mail->CharSet = "utf-8";
	$mail->Encoding = "base64";
	$mail->IsHTML(TRUE);
	$mail->Subject = "=?UTF-8?B?" . base64_encode($mail_subject) . "?=";
	$mail->Body = $mail_content;

	$send_status = array();

	if (!$mail->Send()) {
		$send_status['code'] = 1;
		$send_status['info'] = $mail->ErrorInfo;
	} else {
		$send_status['code'] = 0;
		$send_status['info'] = 'success';
	}
	return $send_status;
}

/**
 * 得到当前用户的IP地址
 *
 * @return string
 */
function getip() {
	$clientip = '';
	if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$clientip = getenv('HTTP_CLIENT_IP');
	} elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$clientip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$clientip = getenv('REMOTE_ADDR');
	} elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$clientip = $_SERVER['REMOTE_ADDR'];
	}

	preg_match("/[\d\.]{7,15}/", $clientip, $clientipmatches);
	$clientip = $clientipmatches[0] ? $clientipmatches[0] : 'unknown';
	return $clientip;
}

/**
 * 权限验证
 * @param rule string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
 * @param uid  int           认证用户的id
 * @param string mode        执行check的模式
 * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
 * @return boolean           通过验证返回true;失败返回false
 * @return author            黄药师		46914685@qq.com
 */
function authCheck($rule, $uid, $type = 1, $mode = 'url', $relation = 'or') {
	// echo $rule;die;
	// return true;
	//超级管理员跳过验证
	$auth = new \Think\Auth();
    $uid = $uid ? $uid : session('userinfo.uid');
	if (in_array($uid, C('ADMINISTRATOR'))) {
		return true;
	} else {
		return $auth->check($rule, $uid, $type, $mode, $relation) ? true : false;
	}
}

function getLeftmenu() {
	$menus = M('leftmenu')->order('if(ord=0,99999,ord),id asc')->select();
	foreach ($menus as $v) {
		if (!authCheck($v['name'], session('uid')))
			continue;
		$m[$v['mid']]['name'] = $v['moduleName'];
		if ($v['is_first']) {
			$m[$v['mid']]['url'] = $v['name'];
		} else {
			$m[$v['mid']]['items'][] = $v;
		}
	}
	return $m;
}

function tohourday($str, $day, $start, $end) {
	$array = str_split($str);
	if ($day == $start) {
		$hour = '';
		foreach ($array as $k => $v) {
			if ($k >= 24)
				continue;
			if ($v == 1) {
				$hour.=(($k + 1) . ',');
			}
		}
	} elseif ($day == $end) {
		$i = 1;
		foreach ($array as $k => $v) {
			if ($k < (($day - $start) / 86400) * 24)
				continue;
			if ($v == 1) {
				$hour.=(($i) . ',');
			}
			if ($i % 24 == 0) {
				$i = 1;
			}
			$i++;
		}
	} elseif ($day > $start && $day < $end) {
		$i = 1;
		foreach ($array as $k => $v) {
			if ($k < (($day - $start) / 86400 + 1) * 24)
				continue;
			if ($v == 1) {
				$hour.=(($i) . ',');
			}
			if ($i == 24) {
				break;
			}
			$i++;
		}
	}
	return trim($hour, ',');
}

function strtostr($str, $str2) {
	$strs = array_filter(explode(',', $str));
	$cstr = '';
	foreach ($strs as $c) {
		$cstr.=($str2[$c] . ',');
	}
	return trim($cstr, ',');
}

/**
 * 获取当前页面完整URL地址
 */
function get_url() {
	//$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	$php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	$relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
	return $relate_url;
	//return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
}

/**
 * 调用通用Model
 */
function MC($name = '', $tablePrefix = '', $connection = '') {
	return M("Admin\Model\CommonModel:$name", $tablePrefix, $connection);
}

function getCode($index,$value){
	$ary = explode('_',$value);
	return $ary[$index];
}

function getParentCode($index,$value){
	if($index==0){
		return $index;
	}
	$ary = explode('_',$value);
	return $ary[$index-1];
}

/**
 * 获取主题列表(目录版)
 * @return array
 */
function md_get_tpl_dir_list(){
	$template_path='.'.C("THEME_PATH");
	$files=md_scan_dir($template_path."*");
	foreach ($files as $k => $v) {
		if(is_dir($template_path.$v)){
			$tpl_files[] = $v;
		}
	}
	return $tpl_files;
}
function md_get_tpl_file_list(){
	$template_path='.'.C("THEME_PATH");
	$files=md_scan_dir($template_path."*");
	foreach ($files as $k => $v) {
		if(is_file($template_path.$v)){
			$tpl_files[] = $v;
		}
	}
	return $tpl_files;
}
/**
 * 替代scan_dir的方法
 * @param string $pattern 检索模式 搜索模式 *.txt,*.doc; (同glog方法)
 * @param int $flags
 */
function md_scan_dir($pattern,$flags=null)
{
	$files = array_map('basename',glob($pattern, $flags));
	return $files;
}


/**
 * 生成th头
 * @param array $row
 * @param string $temp_tpl
 * @return string
 */
function create_th(array $row, $temp_tpl='')
{
	$str = '';
	$temp_tpl = $temp_tpl?$temp_tpl:"<th class='\$class' style='\$style' \$string>\$title</th>";
	foreach($row as $k=>$v){
		$temp_th = '';
		$temp_th = str_replace('$class',$v['class'],$temp_tpl);
		$temp_th = str_replace('$string',$v['string'],$temp_th);
		$temp_th = str_replace('$style',$v['style'],$temp_th);
		$temp_th = str_replace('$title',$v['title'],$temp_th);
		$str .= $temp_th;
	}
	return $str;
}

/**
 * 创建目标表单
 * @param array $title_list
 * @param array $data
 * @return string
 */
function sj_get_detail(array $title_list, array $data)
{
	//TODO：后期更改为可选择性模版
	$tpl = "<div class='form-group'>
            <label class='col-lg-3 control-label'>\$label</label>
            <div class='col-lg-5'>
                <p class='form-control-static'>\$val</p>
            </div>
            </div>";
	$str .= '';
	foreach($title_list as $k=>$v)
	{
		$temp_tpl = '';
		switch($v['type']){
			case 'inline':
				//sj_get_detail_inline($k,$v,$data);
				#对键名进行拆分判断有几个值
				$fields_key = explode(',',$k);
				$fields = explode(',',$v['field']);
				$label = join('、',$fields);
				if(isset($v['function']))
				{
					$temp_label = '';
					if(is_array($v['function']))
					{
						foreach($fields_key as $k1=>$v1)
						{
							call_user_func($v['function'][$k1],$v1);
							$temp_label .= '<span>'.$fields[$k1].'</span>';
						}
					}else
					{
						foreach($fields_key as $k1=>$v1)
						{
							if(!empty($temp_label)){
								$temp_label .= '&nbsp;&nbsp;';
							}
							$data[$v1] = call_user_func($v['function'],$data[$v1]);
							$temp_label .= $data[$v1];
						}
					}
				}else
				{
					foreach($fields_key as $k1=>$v1)
					{
						if(!empty($temp_label)){
							$temp_label .= '&nbsp;&nbsp;';
						}
						$temp_label .= $data[$v1];
					}
				}
				if($temp_label||$label)
				{
					//TODO:后期可添加模板根据模板写
					$temp_tpl = str_replace('$label', $label.':', $tpl);
					$temp_tpl = str_replace('$val',$temp_label, $temp_tpl);
					$str .= $temp_tpl;
				}
				break;
			default:#单行表单field只代表一个字段
				if(isset($v['function']))
				{
					$data[$k] = call_user_func($v['function'],$data[$k]);
				}
				if($data[$k])
				{
					//TODO:后期可添加模板根据模板写
					$temp_tpl = str_replace('$label', $v['field'].':', $tpl);
					$temp_tpl = str_replace('$val', $data[$k], $temp_tpl);
					$str .= $temp_tpl;
				}
		}

	}
	return $str;
}

/**
 * 获取code对应名称
 * @param $k
 * @return mixed
 */
function get_code($k)
{
	$name = D('Admin/Code')->where(array('id'=>$k))->getField('name');
	return $name;
}

/**
 * 中文截取字符串
 * @param $str
 * @param $len
 * @param string $salt
 * @param string $en
 * @return string
 */
function substring_zh($str, $len, $salt='...', $en='utf-8'){
	$l = mb_strlen($str);
	if($l<=$len)
	{
		return $str;
	}else{

		if($salt!=='false'){
			$saltl = mb_strlen($salt);
			$temp_l = $len-$saltl;
			$str = mb_substr($str,0,$temp_l,$en);
			$str .= $salt;
		}else{
			$str = mb_substr($str,0,$len,$en);
		}
		return $str;
	}
}
/*
 * 图片上传
 * @param $filepath 上传路径
 *
 */
function upFiles($filepath = null ,$type='')
{

	$p = C('upload_path');
	if(!file_exists($p))
	{
		@mkdir($p,0777);
	}
	$upload = new \Think\Upload();// 实例化上传类
	$upload->maxSize = 5000000 ;// 设置附件上传大小 5M
	$upload->saveRule =rand(1,9999);
	if($type==''){
		$upload->allowExts = array('jpg', 'gif', 'png', 'jpeg','flv','avi','mov','doc','txt','docx');// 设置附件上传类型

	}elseif($type == 'image'){
		$upload->allowExts = array('jpg', 'png', 'jpeg');// 设置附件上传类型

	}
	$upload->rootPath = './Public/';
	$upload->savePath  =  $filepath ? $filepath : 'Uploads/admin/file/'; // 设置附件上传（子）目录
	$info = $upload->upload();
	if(!$info) {// 上传错误提示错误信息
		return $upload->getError();
	}else {// 上传成功 获取上传文件信息
		return $info;
	}
}

function upFile($file_name){

	$p = './Public/Uploads/admin/file/';
	if(!file_exists($p))
	{
		@mkdir($p,0777);
	}
//	$file_name = I('file_name');
	$maxsize = 5000000;
	$upload = new \Think\Upload();
	$upload->maxSize = $maxsize;
	$upload->exts = array('jpg', 'gif', 'png', 'jpeg','flv','avi','mov','doc','txt','docx');
	$upload->rootPath = $p;
//	$upload->subName = $file_name;
	$upload->saveName = array('uniqid','');
	$upload->replace = true;
	$upload->autoSub  = true;
	$info = $upload->uploadOne($_FILES[$file_name]);
	if(!$info)
	{
//		exit(json_encode(array('status'=>0,'msg'=>$upload->getError())));
		return false;
	}
	$file = '/Public/Uploads/admin/file/' . $info['savepath'] . $info['savename'];
	return $file;
}
/*
 * 文件下载
 * @param $file 文件路径
 *
 */
function download_file($file){
	if(is_file($file)){
		$length = filesize($file);
		$type = mime_content_type($file);
		$showname =  ltrim(strrchr($file,'/'),'/');
		header("Content-Description: File Transfer");
		header('Content-type: ' . $type);
		header('Content-Length:' . $length);
		if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
			header('Content-Disposition: attachment; filename="' . rawurlencode($showname) . '"');
		} else {
			header('Content-Disposition: attachment; filename="' . $showname . '"');
		}
		readfile($file);
	} else {
		return false;
	}

}

function isMobile()
{
    //如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    //此条摘自TPM智能切换模板引擎，适合TPM开发
    if(isset($_SERVER['HTTP_CLIENT']) && 'PhoneClient' == $_SERVER['HTTP_CLIENT'])
    {
        return true;
    }
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if(isset($_SERVER['HTTP_VIA']))
    {
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    }
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array(
            'nokia','sony','ericsson','mot','samsung','htc','sgh','lg',
            'sharp','sie-','philips','panasonic','alcatel','lenovo','iphone',
            'ipod','blackberry','meizu','android','netfront','symbian','ucweb',
            'windowsce','palm','operamini','operamobi','openwave','nexusone',
            'cldc','midp','wap','xiaomi','mi'
        );
        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if(preg_match("/(".implode('|', $clientkeywords).")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if(isset($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}