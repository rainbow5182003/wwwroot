<?php
namespace Home\Controller;
use Think\Controller;
class ConversationController extends BaseController {
	public function _initialize(){
		 parent::_initialize();
	}
	/* 用户中心首页 */
	public function index(){		
		
		$map ['keys'] = array('like','%'.trim(session('keys')).'%');    	 	
    	$list= M('Seixin')->where($map)->page($_GET['p'].',25')->order('uid desc')->select();    	
    	$count=M('Seixin')->where($map)->count();// 查询满足要求的总记录数    	
    	$Page= new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数
    	$show = $Page->show();// 分页显示输出
    	$this->assign('page',$show);// 赋值分页输出     		
    	$this->assign('list',$list);//栏目
      	$this->display();		
	}
	
	
	
	
	public function edit(){		
		if(IS_POST){
    		$model=M('Chat');    		
    		$data=$_POST; 
    		if ($model->create($data)) {
    		   $data["rid"]=$_POST['rid']; 
    		   $data["cate"]=$_POST['cate']; 
    		   $data["keys"]=trim(session('keys'));
    		   $data["time"]=date("Y-m-d h:m:s",time());		      		      		   
               $model->add($data); 
              $this->success("成功",U('Conversation/index'));
	        }else{
	        	$this->error("失败");
	        }    		
    	}else{
    		$model=M('Seixin');
    		$map[id]=I('id');
    		$list=$model->where($map)->find();
    		$cate=M('chat_cate')->where('rid='.session('rid'))->select();
    		//dump($cate);
    		$this->assign('cate_list',$cate); 
    		
    		
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
