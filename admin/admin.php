<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
require("../class/config.php");

//验证用户
$lur=$db->is_login();
//验证权限
$group=unserialize($lur['group']);
?>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>云南新华电脑学院考试考证管理系统--云南新华意博士（E-BOSS）项目实训中心</title>
<link href="style/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="110">
  <tr>
    <td width="40%" height="60"><img src="images/admin_r2_c3.gif" width="406" height="31" class="marl20" /></td>
    <td width="60%" align="right"><a href="#">个人资料</a> | <a href="#">待办信息</a> | <a href="#">通讯录</a> | <a href="user_login.php?eboss=exit">退出登陆</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td height="50" colspan="2" class="pinrl10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="40" width="46"><img src="images/admin_r4_c3.gif" width="46" height="40" /></td>
        <td class="navbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="19%" height="40">&nbsp;&nbsp;欢迎回来：王园园</td>
            <td width="81%">
           <?php if($group[17]){ ?> <span><img src="images/admin_r5_c6.gif" width="16" height="16" /><a href="left/left_lk.php" target="left">资料查看</a></span>
           <?php } if($group[16]){ ?> <span><img src="images/admin_r5_c6.gif" width="16" height="16" /><a href="left/left_qt.php" target="left">前台</a></span>
            <?php } if($group[15]){ ?><span><img src="images/admin_r6_c19.gif" width="16" height="16" /><a href="left/left_js.php" target="left">教师</a></span>
            <?php } if($group[14]){ ?><span><img src="images/admin_r6_c17.gif" width="16" height="16" /><a href="left/left_bzr.php" target="left">班主任</a></span>
            <?php } if($group[10]){ ?><span><img src="images/admin_r6_c14.gif" width="16" height="16" /><a href="left/left_xg.php" target="left">学生管理</a></span>
            <?php } if($group[6]){ ?><span><img src="images/admin_r6_c12.gif" width="16" height="16" /><a href="left/left_jw.php" target="left">教学管理</a></span>
           <?php } if($group[3]){ ?> <span><img src="images/admin_r5_c6.gif" width="16" height="16" /><a href="left/left_rz.php" target="left">认证中心</a></span><?php }?></td>
          </tr>
        </table></td>
        <td width="6"><img src="images/admin_r4_c9.gif" width="6" height="40" /></td>
      </tr>
      <tr>
        <td height="10" colspan="3" bgcolor="#FFFFFF"></td>
        </tr>
    </table></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="martop10">
  <tr>
 	<td width="10">&nbsp;</td>
    <td width="230" bgcolor="#FFFFFF" class="pintop10">
		<iframe src="left/left.php" name="left"  frameborder="0" width="210" scrolling="no" height="615" style=" margin-left:10px;" ></iframe>

    </td>
    <td width="10">&nbsp;</td>
    <td align="left" valign="top" bgcolor="#FFFFFF">
    	<iframe src="right.php" name="right" width="100%" height="615" scrolling="no" frameborder="0" ></iframe>

    </td>
    <td width="10">&nbsp;</td>
  </tr>
</table>
<div class="foot">Copyright 2013-2014 意博士（E-BOSS）项目实训中心. All Rights Reserved&nbsp;</div>
</body>
</html>