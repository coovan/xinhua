<?php
error_reporting(E_ALL ^ E_NOTICE);
$eboss=$_POST['eboss'];
if(empty($eboss))
{$eboss=$_GET['eboss'];}
require("../class/config.php");
if($eboss=="login")//��½
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	$key=$_POST['key'];
	$username=RepPostVar($username);
	$password=RepPostVar($password);
	if(!$username||!$password)
	{
		printerror("������û���������Ϊ��","index.php");
	}
	//�ж���֤��
	session_start();
	if($key<>$_SESSION['key']){
		printerror("��֤�벻��ȷ��","index.php");
		
	}
	if(strlen($username)>30||strlen($password)>30)
	{
		printerror("���û�������������ܳ���30λŶ��","index.php");
	}
	$userpwd=md5($password);
	$query="select * from userinfo where username='$username' and userpwd='$userpwd'";
	$result=$db->fetch1($query);
	if(!$result){
		printerror("�û������������","index.php");
		
	}else{
		
		if($result['checked']==1){
			printerror("����û��Ѿ�������������ϵ����Ա��","index.php");
			
		}else{
			//�û�Ȩ���ж�
			$groupid=$result['groupid'];
			$group=$db->fetch1("select * from user_group where groupid=$groupid");
			if(!$group){
				printerror("Ȩ���жϳ�������ϵ����Ա��","index.php");
			}else{
			$user_group=array($group[2],$group[3],$group[4],$group[5],$group[6],$group[7],$group[8],$group[9],$group[10],$group[11],$group[12],$group[13],$group[14],$group[15],$group[16],$group[17],$group[18],$group[19],$group[20],$group[21],$group[22]);
			$user_group=serialize($user_group);
			}
			//��¼�û���Ϣ
			setcookie('userid',$result[0]);//�û�ID
			setcookie('username',$result[1]);
			setcookie('truename',$result[3]);
			setcookie('group',$user_group);//�û�Ȩ��
			//���µ�½��Ϣ
			$lasttime=strtotime("now");
			$sql="update userinfo set lasttime=$lasttime where id=$result[0]";
			$db->query($sql);
			printerror("��½�ɹ�","admin.php");
			$db->close();
		}	
	}
}
elseif($eboss=="exit")//�˳�ϵͳ
{
	$userid=$_COOKIE['userid'];
	$username=$_COOKIE['username'];
	if(!$userid||!$username)
	{
		printerror("�㻹û�е�½��","history.go(-1)");
	}
	setcookie("userid","",0,1);
	setcookie("username","",0,1);
	setcookie("truename","",0,1);
	setcookie("group","",0,1);
	printerror("�˳���½�ɹ�","index.php");
	
}
else
{
	printerror("����ֵ����","history.go(-1)");
}
?>