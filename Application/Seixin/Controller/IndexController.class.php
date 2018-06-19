<?php
namespace Seixin\Controller;
use Think\Controller;
use Think\Snoopy;
class IndexController extends Controller {
    public function index(){    	
    	switch (trim($_POST['msgtype'])){
			case 3://图片			 
		      $em=M('Image')->Field('url')->limit(1)->order('rand()')->select();
			  echo '{"rs":1,"tip":"[img]'.$em[0]['url'].'[/img]","end":0}';
			  break;  
			//case 34://语音
			  //echo '{"rs":1,"tip":"[结束][url][title=百度],[des=百度一下],[url=http://www.baidu.com/],[img=https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png][/url]","end":0}';
			//  break;
		    case 47://表情包		      
		      $em=M('Emotion')->Field('url')->limit(1)->order('rand()')->select();
			  echo '{"rs":1,"tip":"[img]'.$em[0]['url'].'[/img]","end":0}';
			  break;
			default:
			  	$data['robotid']=$_POST['robotid'];    	
		    	$data['robotnickname']=$this->code($_POST['robotnickname']);
		    	$data['uid']=$_POST['mid'];
		    	$data['nickname']=$this->code($_POST['nickname']);   
		    	$data['sex']=$_POST['sex'];
		    	$data['cust_said']=$this->code($_POST['content']);
		    	$data['msgid']=$_POST['msgid'];     	
		    	$data['msgtype']=$_POST['msgtype'];
		    	$data['time']= date("Y-m-d h:i:s", time());
		    	$map['weixin_id']  = array('in','wxid_ctrehftn2bny22');
		    	$key=M('wx')->where($map)->getField('keys');
		    	$answer=S($key);		    	         
				if(!$answer){
					$dao=M('Chat');
					$map ['keys'] = array('like','%'.trim($key).'%');
					S($key,$dao->field('ask,answer')->where($map)->select(),3600);
					$answer=S($key);			
				}
		    	foreach ($answer as $val) {
			        similar_text($val['ask'],$data['cust_said'], $percent);          
				   	if($percent>80){
				        if(!empty($val['answer'])){		           
			           	  	$arr[]=$val['answer'];
				        }    		
				    }
			    }	     
			    $random_keys=array_rand($arr,1);		    		    	    	
		    	$robot_said=$arr[$random_keys];	
		    	if(!empty($robot_said)){
		    		$data['robot_said']=$robot_said;
		    		$data['keys']= $key;
		    		M('Seixin')->add($data);
		    		echo '{"rs":1,"tip":"'.$robot_said.'","end":0}';
		    	}else{
		    		//这两行代友不能用，用了就会什么话都接。
		    		//$robot_said=M('wx')->where($map)->getField('noanswer');
		    		//$data['robot_said']=$robot_said;
		    		$data['keys']= $key;
		    		M('Seixin')->add($data);
		    		
		    		
		    		   		
		    		//echo '{"rs":1,"tip":"大[结束][img]http://www.dijiu.com/upload/2009/2/24/2009022479639361.gif[/img][结束][img]http://www.dijiu.com/upload/2009/2/24/2009022479639361.gif[/img]","end":0}';
		    	}
		}
    }
    
    
    function code($str) {
    	$t = preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $str);
		return $t;
    }
    
    
    
}