<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload;
class RobotController extends BaseController {
	public function _initialize(){
		 parent::_initialize();
	}
	/* 用户中心首页 */
	public function index(){
		$map['uid']=session('user_auth.uid');    	 	
    	$list= M('Robot')->where($map)->page($_GET['p'].',25')->select();
    	$count=M('Robot')->where($map)->count();// 查询满足要求的总记录数
    	$Page= new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数
    	$show = $Page->show();// 分页显示输出
    	$this->assign('page',$show);// 赋值分页输出     		
    	$this->assign('list',$list);//栏目
      	$this->display();		
	}
	
	public function add(){		
		if(IS_POST){
    		$model=M('Robot');    		
    		$data=$_POST; 
    		if ($model->create($data)) {
    		   $data["uid"]=session('user_auth.uid');
    		   $data["addtime"]=date("Y-m-d",time()); 
    		   $data["keys"]=md5(time());   		   
               $model->add($data);
               $this->success("成功",U('Robot/index'));
	        }else{
	        	$this->error("失败");
	        }    		
    	}else{	    	
			$this->display();
    	}
		
	}
	
	
	
	public function setting(){		
		$map['id']=$_REQUEST['rid'];    	 	
    	$data= M('Robot')->where($map)->find();    	  		
    	$this->assign('robot',$data);//栏目
    	//dump(session('rid'));
		$this->display();		
	}
	
	
	/**
     * 文件上传
     * @param  array  $files   要上传的文件列表（通常是$_FILES数组）
     * @param  array  $setting 文件上传配置
     * @param  string $driver  上传驱动名称
     * @param  array  $config  上传驱动配置
     * @return array           文件上传成功后的信息
     */
    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     'avatar/'; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
       
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功            
             $info = $info['Filedata']['savepath'].$info['Filedata']['savename'];             
             $map['id']=session('rid');    	 	
    		 $result=M('Robot')->where($map)->setField('avatar',$info);
    		 echo $info;
        }
    }
	
	
	
	
}
