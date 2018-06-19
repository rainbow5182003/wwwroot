<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;
use Think\Snoopy;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){
    	//$method = "GET";
		// 请求示例 url 默认请求参数已经做URL编码
		//$url = "http://api01.bitspaceman.com:8000/page/so?apikey=CUuaSfHxJyxmGzQPcUZEeLwGq1ggx5KgFY75U99L4wFYvffSg67cVdxn6ot0SKQq&kw=会计代账";
		//$data=$this->get_k($url);
		//dump($data);
        $this->display();
    }
    
    
    public  function kuaizhaoo() {
	    $text = '会计主要做什么';
	    //$url = 'https://zhidao.baidu.com/search?&word='.$text;
	    
	    $url = "http://weixin.sogou.com/weixin?p=01030402&query=".$text."&type=2&ie=utf8";
	    $snoopy = new Snoopy();
	    $snoopy->fetchlinks($url);
	    $snoopy->fetchtext($url);//获取链接 
		$text=$snoopy->results;
		print_r($text);
	   // dump($str);
	    
	}
    
    private function api(){
    	$param = [
            'apiKey' =>"6b909ce7159fb317b970ee844496e850",
            'userId' =>"rainbow",
            'text' =>"你喜欢上班吗"
        ];                  
        $result = json_decode('['.$this->post('http://localhost/wwwroot/api',json_encode($param)).']',true);
       //$result = $this->post('http://localhost/wwwroot/api',json_encode($param));
       return json_encode($result);
    }
    
    private function get_k($url=NULL){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_FAILONERROR, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_ENCODING, "gzip");
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    
    private function post($url=NULL,$data=NULL){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $url);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

}