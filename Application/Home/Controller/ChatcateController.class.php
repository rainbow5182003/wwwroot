<?php
namespace Home\Controller;
use Think\Controller;
class ChatcateController extends BaseController {
	public function _initialize(){
		 parent::_initialize();
	}
	public function add(){			
		if(IS_POST){
    		$model=M('Chat_cate');    		
    		$data=$_POST; 
    		if ($model->create($data)) {
    		   $data["uid"]=session('user_auth.uid');
    		   $data["rid"]=session('rid'); 
               $model->add($data);               
               $this->success("成功",U("Robot/setting",array("rid"=>session('rid'))));
              
	        }else{
	        	$this->error("失败");
	        }    		
    	}else{	    		 	
			$this->display();
    	}
	}
}
