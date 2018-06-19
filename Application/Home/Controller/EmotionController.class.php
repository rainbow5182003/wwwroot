<?php
namespace Home\Controller;
use Think\Controller;
class EmotionController extends BaseController {
	public function _initialize(){
		 parent::_initialize();
	}
	/* 用户中心首页 */
	public function index(){		
		//$map['rid']=session('rid');		
		//$map['uid']=session('user_auth.uid');    	 	
    	$list= M('Emotion')->where($map)->page($_GET['p'].',25')->order('id desc')->select();
    	$count=M('Emotion')->where($map)->count();// 查询满足要求的总记录数
    	$Page= new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数
    	$show = $Page->show();// 分页显示输出
    	$this->assign('page',$show);// 赋值分页输出     		
    	$this->assign('list',$list);//栏目
      	$this->display();		
	}
	
	public function del(){
		$model=M('Emotion');		
		if ($model) {    		  
    		   $map[id]=$_REQUEST['id']; 		      		      		   
               $model->where($map)->delete(); 
               $this->success("成功");
	    }else{
	        $this->error("失败");
	   }    
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
        $upload->exts      =     array('gif');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     'emotion/'; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
             $data['savepath']=$info['Filedata']['savepath'];
             $data['savename']=$info['Filedata']['savename']; 
             $data['name']=$info['Filedata']['name']; 
             $data['ext']=$info['Filedata']['ext'];
             $data['md5']=$info['Filedata']['md5'];
             $data['sha1']=$info['Filedata']['sha1'];
             $data['size']=$info['Filedata']['size'];
             $data['create_time']=date("Y-m-d",time());             
             $data['rid']=session('rid');
             $data['url']= 'http://'.$_SERVER['HTTP_HOST']."/Uploads/".$info['Filedata']['savepath'].$info['Filedata']['savename'];    
             M('Emotion')->where($map)->add($data);
    		 //echo $info;
        }
    }
}
