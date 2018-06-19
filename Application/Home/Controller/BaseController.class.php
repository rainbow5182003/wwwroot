<?php

namespace Home\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class BaseController extends Controller {
	
	public function _initialize(){
		if ( !is_login() ) {
			$this->error( '您还没有登陆',U('User/login') );
		}
		$robot=$_REQUEST['rid'];
		//dump($robot);
		if($robot){
			session('rid',$robot);
			$robot=M('Robot')->where('id='.$robot)->find();
			session('robot',$robot['name']);
			session('keys',$robot['keys']);	
			$map['uid']=session('user_auth.uid');
			$map['rid']=session('rid');
			$cate=M('Chat_cate')->where($map)->select();
			//dump($cate);
			$this->assign('cate',$cate);
		}		
		
			
	}

	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect('Index/index');
	}
	
	public function scws($ask=NULL){
        $keyword = rawurldecode($ask);
        Vendor('scws.pscws4');
        $pscws = new \PSCWS4();
        $pscws->set_dict(VENDOR_PATH.'scws/lib/dict.utf8.xdb');
        $pscws->set_rule(VENDOR_PATH.'scws/lib/rules.utf8.ini');
        $pscws->set_ignore(true);
        $pscws->set_charset("UTF8");
        $pscws->set_multi(2);
        $pscws->send_text($keyword);
        $words = $pscws->get_tops(10);
        $k=$pscws->get_result();
        $tags = array();
        foreach ($words as $val) {
            $tags[] = $val['word'];
        }
        $pscws->close();
        return $words;
    }
	

}
