<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<title><?php echo C('WEB_SITE_TITLE');?></title>
<link href="/wwwroot/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/wwwroot/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="/wwwroot/Public/static/bootstrap/css/docs.css" rel="stylesheet">
<link href="/wwwroot/Public/static/bootstrap/css/onethink.css" rel="stylesheet">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/wwwroot/Public/static/bootstrap/js/html5shiv.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="/wwwroot/Public/static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/wwwroot/Public/static/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/wwwroot/Public/static/bootstrap/js/bootstrap.min.js"></script>
<!--<![endif]-->
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body >
	<!-- 头部 -->
	<!-- 导航条
================================================== -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo U('index/index');?>">Robot</a>
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <?php $__NAV__ = M('Channel')->field(true)->where("status=1")->order("sort")->select(); if(is_array($__NAV__)): $i = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i; if(($nav["pid"]) == "0"): ?><li>
                            <a href="<?php echo (get_nav_url($nav["url"])); ?>" target="<?php if(($nav["target"]) == "1"): ?>_blank<?php else: ?>_self<?php endif; ?>"><?php echo ($nav["title"]); ?></a>
                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    <?php if($_REQUEST['rid']): ?><li><a href="<?php echo U('Robot/setting',array('rid'=>$_REQUEST['rid']));?>"><?php echo (session('robot')); ?></a></li>
		            <li><a href="<?php echo U('Chatcate/add',array('rid'=>$_REQUEST['rid']));?>"  >创建分类</a></li>
		            <li><a href="<?php echo U('Cust/index',array('rid'=>$_REQUEST['rid']));?>"  >微信客户</a></li> 
		            <li><a href="<?php echo U('Conversation/index',array('rid'=>$_REQUEST['rid']));?>"  >聊天记录</a></li>  
		            <li><a href="<?php echo U('Emotion/index',array('rid'=>$_REQUEST['rid']));?>"  >表情包</a></li>  
		            <li><a href="<?php echo U('Image/index',array('rid'=>$_REQUEST['rid']));?>" >图片库</a></li>
		            <li><a href="<?php echo U('Article/index',array('rid'=>$_REQUEST['rid']));?>" >软文库</a></li>
		            <?php else: endif; ?>
                </ul>
            </div>
            <div class="nav-collapse collapse pull-right">
                <?php if(is_login()): ?><ul class="nav" style="margin-right:0">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:0;padding-right:0"><?php echo get_username();?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            	<li><a href="<?php echo U('Robot/add');?>" class="t2">创建机器人</a></li>
                            	<li><a href="<?php echo U('Robot/index');?>" class="t2">机器人管理</a></li>
                                <li><a href="<?php echo U('User/profile');?>">修改密码</a></li>
                                <li><a href="<?php echo U('User/logout');?>">退出</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="nav" style="margin-right:0">
                        <li>
                            <a href="<?php echo U('User/login');?>">登录</a>
                        </li>
                        <li>
                            <a href="<?php echo U('User/register');?>" style="padding-left:0;padding-right:0">注册</a>
                        </li>
                    </ul><?php endif; ?>
            </div>
        </div>
    </div>
</div>

	<!-- /头部 -->
	
	<!-- 主体 -->
	
<div id="main-container" class="container" >
    <div class="row">
         
        
	<section>
		<script src="/wwwroot/Public/static/uploadify/jquery.uploadify.min.js"></script>
	    <link rel="stylesheet" type="text/css" href="/wwwroot/Public/static/uploadify/uploadify.css">
		<div class="span12">
			<div class="thumbnail">
				<?php if(empty($robot['avatar'])): ?><form action="<?php echo U('Robot/upload');?>" enctype="multipart/form-data" method="post" >
						<input type="file" name="avatar" id="ups"/>
    				</form>
					<img src="/wwwroot/Uploads/avatar/default.jpg" class="img-circle" style="width: 200px; height: 200px;">
					<?php else: ?>					
					<img src="/wwwroot/Uploads/<?php echo ($robot["avatar"]); ?>" id ="imgs" class="img-circle" style="width: 200px; height: 200px;"><?php endif; ?>				
			</div>
			<table class="table">
				<thead>
					<tr>
						<th style="width:30%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;"><?php echo (session('robot')); ?></th>
						<th>星座</th>
						<th>年龄</th>
						<th>APIKEY</th>
						<th>创建时间</th>
						<th>到期时间</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo ($robot["name"]); ?></td>
						<td><?php echo ($robot["constellation"]); ?></td>
						<td><?php echo ($robot["age"]); ?></td>
						<td><?php echo ($robot["keys"]); ?></td>
						<td><?php echo ($robot["addtime"]); ?></td>
						<td><?php echo ($robot["endtime"]); ?></td>
					</tr>

				</tbody>
			</table>
			<ul class="thumbnails">
				<?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="span3">
						<div class="thumbnail">							
							<i class="icon-th-large" style="font-size: 50px;"></i>					
							<div class="caption" align="center">
								<h3><?php echo ($vo["cate"]); ?></h3>								
								<p align="center">
									<a href="<?php echo U('Chat/index',array('cid'=>$vo['id'],'rid'=>$_REQUEST['rid']));?>" class="btn">设置</a>
								</p>
							</div>
						</div>
					</li><?php endforeach; endif; else: echo "" ;endif; ?> 				
			</ul>
		</div>
	</section>


    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(window).resize(function(){
            $("#main-container").css("min-height", $(window).height() - 343);
        }).resize();
    })
</script>
	<!-- /主体 -->

	<!-- 底部 -->
	
    <!-- 底部
    ================================================== -->
    <footer class="footer">
      <div class="container">
          <p> 本站由 <strong><a href="http://www.xuetutime.com" target="_blank">robot</a></strong>强力驱动</p>
      </div>
    </footer>

<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "/wwwroot", //当前网站地址
		"APP"    : "/wwwroot", //当前项目地址
		"PUBLIC" : "/wwwroot/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>

	<script type="text/javascript">	
    	$('#ups').uploadify({
        'swf'        : '/wwwroot/Public/static/uploadify/uploadify.swf',
        'uploader'   : '<?php echo U("Robot/upload");?>',
        'buttonText' : '上传头相',
        onUploadSuccess : function(file, data, response) {
        	window.location.reload();
        }
    });
	</script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</body>
</html>