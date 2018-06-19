<?php
namespace Weixin\Controller;
use Think\Controller;
use Com\Wechat;
use Com\WechatCrypt;
class IndexController extends Controller {
    public function index(){    	   	
        if (!isset($_GET['echostr'])) {
        	$uid=$_GET['uid'];//从微信服务器得到院校ID
            $cache=$this->getweixin($uid);//调用下方的院校数据库或缓存数据     
            $this->responseMsg($cache);
        }else{
            $echoStr = $_GET['echostr'];
            if($this->checkSignature()){
                ob_clean();
                echo $echoStr;
                exit;
            }
        }
    }
    private function checkSignature(){
    	$signature = $_GET["signature"];//从微信服务器得到signature
        $timestamp = $_GET["timestamp"];//从微信服务器得到timestamp
        $nonce = $_GET["nonce"];//从微信服务器得到nonce
        $uid=$_GET['uid'];//从微信服务器得到院校ID
        $cache=$this->getweixin($uid);//调用下方的院校数据库或缓存数据        
        $token="robot";
        $tmpArr = array($token, $timestamp, $nonce);//建立数组tmpArr
        sort($tmpArr);   //字典序排序；
        $tmpStr = implode($tmpArr); //将数组的内容连接成一个字符串
        $tmpStr = sha1($tmpStr); // sha1加密；
        if($tmpStr == $signature){ //验证   
            return true;
        }else{
            return false;
        }
    }
    
    private function getweixin($uid=NULL){    	
    	$map['uid']  =$uid;
        //读取缓存
        $cache=S($uid);
        if($cache){
        	return $cache;
       }else{
        	 $list=M("weixin")->where($map)->find();
        	 S($uid,$list);
        	 $cache=S($uid);
        	 return $list;
        }
    } 
    
    //名称：获取微信的POST所有信息，$cache是各个用户的信息。
    public function responseMsg($cache){
        try{          
            $appid = trim($cache['appid']); //AppID(应用ID)
	        $token = trim($cache['token']); //微信后台填写的TOKEN
	        $crypt = trim($cache['encodingaeskey']); //消息加密KEY（EncodingAESKey）
	        $robotkey=trim($cache['robotkey']);
	        $uid=trim($cache['uid']);
	        $wechat = new Wechat($token, $appid, $crypt);  /* 加载微信SDK */
	        $data = $wechat->request(); /* 获取请求信息 */	        
	        $this->MyProgrom($wechat,$data,$cache);	       
        } catch(\Exception $e){
            file_put_contents('./error.json', json_encode($e->getMessage()));
        }
    }
    
    /**
     * MyProgrom
     * @param  Object $wechat Wechat对象
     * @param  array  $data   接受到微信推送的消息
     * @param  array  $cache  $cache是各个用户的信息。
     */
    private function MyProgrom($wechat, $data,$cache){
    	switch ($data['MsgType']) {
            case Wechat::MSG_TYPE_EVENT:
                switch ($data['Event']) {
                    case Wechat::MSG_EVENT_SUBSCRIBE:
                        $wechat->replyText('欢迎您关注我哈哈：）');
                        break;
                    case Wechat::MSG_EVENT_UNSUBSCRIBE:
                        //取消关注，记录日志
                        break;
                    default:
                        $wechat->replyText("欢迎您关注我");
                        break;
                }
                break;
            case Wechat::MSG_TYPE_TEXT:
                $key=$cache['robotkey'];
                $ask=$data["Content"];                
	            $answer=S($key);          
				if(!$answer){
					$dao=M('Chat');
					$map ['keys'] = array('like','%'.trim($key).'%');
					S($key,$dao->field('ask,answer')->where($map)->select(),3600);
					$answer=S($key);			
				}
		    	foreach ($answer as $val) {
			        similar_text($val['ask'],$ask, $percent);          
				   	if($percent>80){
				        if(!empty($val['answer'])){		           
			           	  	$arr[]=$val['answer'];
				        }    		
				    }
			    }			    
			    if(!empty($arr)){
			    	 $random_keys=array_rand($arr,1);
			     	//调用聊天信息记录函数		     
				    if(conversation($data['FromUserName'],$key,$ask,$arr[$random_keys])){
				    	//echo $arr[$random_keys];
				    	$wechat->replyText($arr[$random_keys]); 
				    }else{
				    	//echo ;
				    	$wechat->replyText($arr[$random_keys]); 
				    }
			    }else{
			    	
			    	//$news=array("这是标题 ", "这是描述", "http://www.baidu.com");
			    	//$wechat->replyNews($news); 
			    	
			    }     
			    
                break;
            case Wechat::MSG_TYPE_IMAGE:
            	$wechat->replyText("图片");
            	break;    
      	}    	
    }
        
    
}