<?php
namespace Home\Controller;
use Think\Controller;
class ChatController extends BaseController {
	public function _initialize(){
		 parent::_initialize();
	}
	/* 用户中心首页 */
	public function index(){		
		$map['rid']=session('rid');
		$map['cate']=$_REQUEST['cid'];
		$map['uid']=session('user_auth.uid');    	 	
    	$list= M('Chat')->where($map)->page($_GET['p'].',25')->order('id desc')->select();
    	$count=M('Chat')->where($map)->count();// 查询满足要求的总记录数
    	$Page= new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数
    	$show = $Page->show();// 分页显示输出
    	$this->assign('page',$show);// 赋值分页输出     		
    	$this->assign('list',$list);//栏目
      	$this->display();		
	}
	
	public function add(){			
		if(IS_POST){
    		$model=M('Chat');  
    		dump($_POST);
    		  		
    		$keywords=$this->scws($_POST['ask']); 
    		if ($keywords) {
    			foreach ($keywords as $key=>$val) {
            		$data[$key]["keyword"] = $val['word'];
            		$data[$key]["rid"]=session('rid');
    		   		$data[$key]["keys"]=session('keys');
    		   		$data[$key]["time"]=date("Y-m-d h:m:s",time());
    		   		$data[$key]["ask"]=$_POST['ask'];
    		   		$data[$key]["answer"]=$_POST['answer'];
    		   		$data[$key]["cate"]=$_POST['cate'];
        	}  
	            $model->addall($data);              
	            $this->success("成功",U('Chat/index',array("cid"=>$_POST['cate'],"rid"=>session('rid'))));
	       }else{
	       			$data["keyword"] = $_POST['ask'];
            		$data["rid"]=session('rid');
    		   		$data["keys"]=session('keys');
    		   		$data["time"]=date("Y-m-d h:m:s",time());
    		   		$data["ask"]=$_POST['ask'];
    		   		$data["answer"]=$_POST['answer'];
    		   		$data["cate"]=$_POST['cate'];	        	
	        	$model->add($data);              
	            $this->success("成功",U('Chat/index',array("cid"=>$_POST['cate'],"rid"=>session('rid'))));
	        }    		
    	}else{	    	
			$this->display();
    	}
	}
	
	
	
	public function edit(){		
		if(IS_POST){
    		$model=M('Chat');    		
    		$data=$_POST; 
    		if ($model->create($data)) {
    		   $data["id"]=$_POST['id']; 
    		   $data["cid"]=$_POST['cid'];  		      		      		   
               $model->save($data); 
              $this->success("成功",U('Chat/index',array("cid"=>$_POST['cate'],"rid"=>session('rid'))));
	        }else{
	        	$this->error("失败");
	        }    		
    	}else{
    		$model=M('Chat');
    		$map[id]=I('id');
    		$list=$model->where($map)->find();
    		$this->assign('data',$list); 	    	
			$this->display();
    	}	
	}
	public function del(){
		$model=M('Chat');		
		if ($model) {    		  
    		   $map[id]=$_REQUEST['id']; 		      		      		   
               $model->where($map)->delete(); 
               $this->success("成功");
	    }else{
	        $this->error("失败");
	   }    
	}
	
	
}
