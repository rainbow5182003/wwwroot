<?php
namespace Api\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){ 
    	try{    		
    		$data= file_get_contents ( 'php://input' );
    		if($data){
	    		$list=json_decode($data,true);    	
		    	$key=$list['key']; 
		    	$uid=$list['userId'];
		    	$ask=$list['msg'];
    		}
    		
    		$str=urldecode(urlencode($_REQUEST[msg]));    		
    		if($str){
    			$ask=iconv('gb2312','utf-8',$str);
    			$key=$_REQUEST['key']; 
    			$uid=$_REQUEST['userId']; 
    		}
	    	if(empty($uid)){
	    		$uid=md5(date("Y-m-d",time()));	    		
	    	}	    	
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
		     $random_keys=array_rand($arr,1);
		     //调用聊天信息记录函数		     
		    if(conversation($uid,$key,$ask,$arr[$random_keys])){
		    	echo $arr[$random_keys]; 
		    }else{
		    	echo $arr[$random_keys]; 
		    }
	    	 
	    	 //echo $ask;
	    	 //echo json_encode ($arr[$random_keys]);
	    	// echo $data;
    	} catch(\Exception $e){
            
        } 
    }
    
    
    
}