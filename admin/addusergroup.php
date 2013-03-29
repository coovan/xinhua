<?php
error_reporting(E_ALL ^ E_NOTICE);
require("../class/config.php");
//验证用户
$lur=$db->is_login();
//验证权限
$group=unserialize($lur['group']);
if($group[0]<>1){
	printerror("你的权限不够哦！","admin.php");
}
$eboss=$_POST['eboss'];
if(empty($eboss))
{$eboss=$_GET['eboss'];}
if($eboss=='add')//添加用户组
{
	$groupname=$_POST['groupname'];
	$grouplist=$_POST['grouplist'];
	$groupname=RepPostVar($groupname);
	//判断是否已经添加过
	$query="select * from user_group where groupname='$groupname'";
	$result=$db->fetch1($query);
	if($result){
		printerror("此用户组已经存在，不可重复添加！","addusergroup.php");
		
	}
	//添加数据处理
	$sqlkey="groupname"; 
	$sqlval="'".$groupname."'";
	if(is_array($grouplist)){
	foreach($grouplist as $value){  
  	$sqlkey.=",".$value;
  	$sqlval.=","."1";

  }
	}
  $sql="insert into user_group ($sqlkey) value($sqlval)";
  echo $sql;
	$db->query($sql);
	$db->close();
	printerror("添加成功","listusergroup.php");

}
if($eboss=='update')//查看修改用户组
{
	$groupid=$_GET['groupid'];
	if(!$groupid){
		printerror("传递值出错！","listusergroup.php");
	}
$sql="select * from user_group where groupid=$groupid";

	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>添加用户组</title>
<script>
function CheckLogin(obj){
	if(obj.groupname.value=='')
	{
		alert('请输入用户组名称！');
		obj.groupname.focus();
		return false;
	}
	return true;
}
</script>
</head>

<body>
<form id="form1" name="form1" method="post" onSubmit="return CheckLogin(document.form1);"  action="addusergroup.php">
  <table width="900" border="1" align="center" cellpadding="0" cellspacing="0"  style="font-size:12px;">
    <tr>
      <td height="60" colspan="2" align="center">用户组权限管理</td>
    </tr>
    <tr>
      <td width="124" height="40" align="center">用户组名称</td>
      <td><label>
        <input type="text" name="groupname" id="groupname" />
      <input type="hidden" name="eboss" value="add"></label></td>
    </tr>
    <tr>
      <td height="40" align="center">用户组权限</td>
      <td><p>
       <label>
         <input type="checkbox" name="grouplist[]" value="douser" id="grouplist_0" />
         用户管理</label>
        1<br />
      </p>
      <p><input type="checkbox" name="grouplist[]" value="doi" id="grouplist_1" />
          仅操作自己</label>
      2</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="dotextual" id="grouplist_2" />
         考试考证中心</label>
        3<br />
          &nbsp;&nbsp;&nbsp;<label>
            <input type="checkbox" name="grouplist[]" value="doexam" id="grouplist_3" />
          阶段性考核管理</label>
          4
          <label>
            <input type="checkbox" name="grouplist[]" value="dotextl" id="grouplist_4" />
          考试考证管理</label>
        5</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="doeducational" id="grouplist_5" />
         教务处</label>
        6<br />
          &nbsp;&nbsp;&nbsp;<label>
            <input type="checkbox" name="grouplist[]" value="dobook" id="grouplist_6" />
          科目管理</label>
          7
          <label>
            <input type="checkbox" name="grouplist[]" value="domajor" id="grouplist_7" />
          专业管理</label>
          <label>8
            <input type="checkbox" name="grouplist[]" value="docourse" id="grouplist_8" />
            课程开设管理
          </label>
      9</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="dostmanage" id="grouplist_9" />
         学生管理处</label>
        10<br />
          &nbsp;&nbsp;&nbsp;<label>
            <input type="checkbox" name="grouplist[]" value="doclteacher" id="grouplist_10" />
          班主任管理</label>
          <label>
            <input type="checkbox" name="grouplist[]" value="doclass" id="grouplist_11" />
          班级管理 </label>
           <input type="checkbox" name="grouplist[]" value="dostudent" id="grouplist_12" />
          学生管理 </label>
      </p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="domentor" id="grouplist_13" />
         班主任</label>
       14<br />
        &nbsp;&nbsp;&nbsp;</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="doteacher" id="grouplist_14" />
         教师</label>
        <br />
        &nbsp;&nbsp;&nbsp;15</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="doproscenium" id="grouplist_15" />
         前台</label>
        16<br />
        &nbsp;&nbsp;&nbsp;</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="dolook" id="grouplist_16" />
         资料查看</label>
        17<br />
        &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="grouplist[]" value="dolookexam" id="grouplist_17" />
           查看阶段性成绩</label>
          <label>
            <input type="checkbox" name="grouplist[]" value="dolooktextual" id="grouplist_18" />
            查看考试考证
          </label>
          <label>
            <input type="checkbox" name="grouplist[]" value="dolookcourse" id="grouplist_19" />
          查看课程开设</label>
          <label>
            <input type="checkbox" name="grouplist[]" value="dolookstudent" id="grouplist_20" />
          查看学生情况</label></p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    </tr>
    <tr>
      <td height="40">&nbsp;</td>
      <td><label>
        <input type="submit" name="button" id="button" value="提交" />
      </label></td>
    </tr>
  </table>
</form>
</body>
</html>