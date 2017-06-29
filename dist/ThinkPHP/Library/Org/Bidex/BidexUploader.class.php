<?php
/**
 * @Author: Sincez
 * @Date:   2016-06-21 17:01:13
 * @Last Modified by:   Sincez
 * @Last Modified time: 2016-07-07 19:09:25
 */
namespace Org\Bidex;
include_once("Http.class.php");
include_once("Error.class.php");
class BidexUploader
{
    private $uploadurl;
    private $dspid;
    private $token;
    public function __construct($dspid, $token, $url) {
        $this->dspid = $dspid;
        $this->token = $token;
        $this->uploadurl = $url;
    }
    public function upload($request){
        $authHeader = array(
            "dspId"     => $this->dspid,
            "token" => $this->token
        );
        $para = array(
            'request'=>$request,
            'authHeader'=>$authHeader
        );
        // var_dump($para);die;
        // echo json_encode($para);die;
        $parameter = json_encode($para);//echo $parameter;die;
        // $parameter = $para;
        /*$parameter = '{
"request": [
{
"Type":1,
"CreativeUrl": "http://www.bidex.com/abc.jpg",
"TargetUrl": "http://w.masky.bidex.com/masky/w/jump?w=123",
"LandingPage": "http://www.bidex.com",
"MonitorUrls": [
"http://monitorurl.com/monitor/123"
],
"OCreativeId": "12",
"AdvertiserId": 72810621,
"Width": 320,
"Height": 50
}
],
"authHeader": {
"dspId": 4,
"token": "df4d6d2fbccc08999483f1f3e0c9b3baa1359c1ddcc96777179480ec89abaa78"
} }';*/
/*$parameter = '{
    "request": [
          {
            "OCreativeId": "58",
            "Type": 1,
            "AdviewType": 1,
            "CreativeUrl": "http://hq/Public/Uploads/20160626/576fdce971f5c.jpg",
            "LandingPage": "http://ww.baidu.com",
            "MonitorUrls": [
                "https://www.baidu.com/baidu?wd=chosen+update&tn=monline_4_dg"
            ],
            "Height": 200,
            "Width": 300,
            "AdvertiserId": 0,
            "Duration": 0
        }
    ],
    "authHeader": {
"dspId": "4",
"token": "df4d6d2fbccc08999483f1f3e0c9b3baa1359c1ddcc96777179480ec89abaa78"
}
}';*/
// $parameter = '{
// "request":{
// "OCreativeIds":["61","62"]
// },
// "authHeader":{
// "dspId":4,
// "token":"df4d6d2fbccc08999483f1f3e0c9b3baa1359c1ddcc96777179480ec89abaa78"
// } }';
// $parameter = '{
//     "request":{
//         "OCreativeIds":[61,62]
//     },
//     "authHeader":{
//         "dspId":4,
//         "token":"df4d6d2fbccc08999483f1f3e0c9b3baa1359c1ddcc96777179480ec89abaa78"
//     }}';
        try {
            $result = json_decode(Http::http_post_json($this->uploadurl, $parameter));
            if (isset($result->error)) {
                $error = $result->error;
                throw new UploadException($error->description,$error->code);
            }
        }catch (UploadException $e) {
            echo $e->getError();
            exit;
        }
        file_put_contents('bidex.txt',date('Y-m-d H:i:s')."\t".$this->uploadurl."\t".$parameter."\t".json_encode($result)."\r\r\n",FILE_APPEND);
        $result = json_encode($result);
        $result = json_decode($result,true);
        return $result;
    }
}