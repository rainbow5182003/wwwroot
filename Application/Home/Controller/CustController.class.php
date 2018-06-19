<?php
namespace Home\Controller;
use Think\Controller;
class CustController extends BaseController {
	public function _initialize(){
		 parent::_initialize();
	}
	/* 用户中心首页 */
	public function index(){
		$map ['keys'] = array('like','%'.trim(session('keys')).'%');    	 	
    	$list= M('custmer')->where($map)->page($_GET['p'].',25')->order('uid desc')->select();    	
    	$count=M('custmer')->where($map)->group('uid')->count();// 查询满足要求的总记录数    	
    	$Page= new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数
    	$show = $Page->show();// 分页显示输出
    	$this->assign('page',$show);// 赋值分页输出     		
    	$this->assign('list',$list);//栏目
      	$this->display();		
	}
	
}
