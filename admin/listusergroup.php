<?php 
require("../class/config.php");
include '../class/fenye.php';
//��֤�û�
$lur=$db->is_login();
//��֤Ȩ��
$group=unserialize($lur['group']);
if($group[1]<>1){
	printerror("���Ȩ�޲���Ŷ��","admin.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�û������ҳ��</title>
</head>

<body>
<table width="900" border="1" align="center" cellpadding="0" cellspacing="0" style="font-size:12px;">
  <tr>
    <td height="60" colspan="3" align="center">�û������ҳ��</td>
  </tr>
  <tr>
    <td width="350" height="40" align="center">�û���ID</td>
    <td width="350" align="center">�û�������</td>
    <td width="200" align="center">����</td>
  </tr>
  <?php 
  $sql="select * from user_group";
  $num=$db->num($sql);
  $fenye=new page($num,'page',2);
  $sqllim="select * from user_group limit $fenye->offset,2";
  $result=$db->query($sqllim);
  while($row=$db->fetch($result)){
  ?>
  <tr>
    <td height="40"><?php echo $row['groupid'];?></td>
    <td><?php echo $row['groupname'];?></td>
    <td align="center"><a href="addusergroup.php?eboss=update&groupid=<?php echo $row['groupid'];?>">�޸Ĳ鿴</a> <a href="/eboss=delete&groupid=<?php echo $row['groupid'];?>">ɾ��</a> </td>
  </tr>
  <?php
}
  ?>
  <tr>
    <td height="40">&nbsp;</td>
    <td><?php echo $fenye->show(1);?></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="40" colspan="3" align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>