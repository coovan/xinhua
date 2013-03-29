<?php
error_reporting(E_ALL ^ E_NOTICE);
$eboss=$_POST['eboss'];
if(empty($eboss))
{$eboss=$_GET['eboss'];}
require("../class/config.php");
if($eboss=="login")//登陆
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	$key=$_POST['key'];
	$username=RepPostVar($username);
	$password=RepPostVar($password);
	if(!$username||!$password)
	{
		printerror("密码和用户名均不能为空","index.php");
	}
	//判断验证码
	session_start();
	if($key<>$_SESSION['key']){
		printerror("验证码不正确！","index.php");
		
	}
	if(strlen($username)>30||strlen($password)>30)
	{
		printerror("亲用户名和密码均不能超过30位哦！","index.php");
	}
	$userpwd=md5($password);
	$query="select * from userinfo where username='$username' and userpwd='$userpwd'";
	$result=$db->fetch1($query);
	if(!$result){
		printerror("用户名或密码错误！","index.php");
		
	}else{
		
		if($result['checked']==1){
			printerror("你的用户已经被锁定，请联系管理员！","index.php");
			
		}else{
			//用户权限判断
			$groupid=$result['groupid'];
			$group=$db->fetch1("select * from user_group where groupid=$groupid");
			if(!$group){
				printerror("权限判断出错，请联系管理员！","index.php");
			}else{
			$user_group=array($group[2],$group[3],$group[4],$group[5],$group[6],$group[7],$group[8],$group[9],$group[10],$group[11],$group[12],$group[13],$group[14],$group[15],$group[16],$group[17],$group[18],$group[19],$group[20],$group[21],$group[22]);
			$user_group=serialize($user_group);
			}
			//记录用户信息
			setcookie('userid',$result[0]);//用户ID
			setcookie('username',$result[1]);
			setcookie('truename',$result[3]);
			setcookie('group',$user_group);//用户权限
			//更新登陆信息
			$lasttime=strtotime("now");
			$sql="update userinfo set lasttime=$lasttime where id=$result[0]";
			$db->query($sql);
			printerror("登陆成功","admin.php");
			$db->close();
		}	
	}
}
elseif($eboss=="exit")//退出系统
{
	$userid=$_COOKIE['userid'];
	$username=$_COOKIE['username'];
	if(!$userid||!$username)
	{
		printerror("你还没有登陆！","history.go(-1)");
	}
	setcookie("userid","",0,1);
	setcookie("username","",0,1);
	setcookie("truename","",0,1);
	setcookie("group","",0,1);
	printerror("退出登陆成功","index.php");
	
}
else
{
	printerror("传递值出错！","history.go(-1)");
}
?>