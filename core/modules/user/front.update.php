<?php
if(!defined('ROOT'))exit('Access denied!');
if($this->do=='update'){
	check_request();
	$this->template->template_dir='core/modules/user/templates/front';
	$this->template->out("user.update.php");
}
if($this->do=='update-check'){
	check_request();
	if(!$user->is_login())exit('请重新登陆！');
	if($_SESSION['user_login']!='-')exit('非法操作！');
	$user_login=empty($_POST['user_login'])?'':trim(addslashes($_POST['user_login']));
	$user_nickname=empty($_POST['user_nickname'])?'':trim(addslashes($_POST['user_nickname']));
	if(empty($user_login)){
		exit('帐号不能为空');
	}
	if(!is_email($user_login)){
		exit('帐号不合法');
	}
	if($this->db->repeat(DB_PREFIX."user",'user_login',$user_login)){
		exit('帐号已存在');
	}
	if(empty($user_nickname)){
		exit('昵称不能为空');
	}
	if($this->db->repeat(DB_PREFIX."user",'user_nickname',$user_nickname)){
		exit('昵称已存在');
	}
	$array=array();
	$array['user_login']=$user_login;
	$array['user_nickname']=$user_nickname;
	$this->db->update(DB_PREFIX."user",$array,"user_id=".$_SESSION['user_id']);
    $_SESSION['user_login']=$user_login;
    $_SESSION['user_nickname']=$user_nickname;
	exit('SUCCESS');
}