<?php
error_reporting(E_ALL ^ E_NOTICE);
require("../class/config.php");
//��֤�û�
$lur=$db->is_login();
//��֤Ȩ��
$group=unserialize($lur['group']);
if($group[0]<>1){
	printerror("���Ȩ�޲���Ŷ��","admin.php");
}
$eboss=$_POST['eboss'];
if(empty($eboss))
{$eboss=$_GET['eboss'];}
if($eboss=='add')//����û���
{
	$groupname=$_POST['groupname'];
	$grouplist=$_POST['grouplist'];
	$groupname=RepPostVar($groupname);
	//�ж��Ƿ��Ѿ���ӹ�
	$query="select * from user_group where groupname='$groupname'";
	$result=$db->fetch1($query);
	if($result){
		printerror("���û����Ѿ����ڣ������ظ���ӣ�","addusergroup.php");
		
	}
	//������ݴ���
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
	printerror("��ӳɹ�","listusergroup.php");

}
if($eboss=='update')//�鿴�޸��û���
{
	$groupid=$_GET['groupid'];
	if(!$groupid){
		printerror("����ֵ����","listusergroup.php");
	}
$sql="select * from user_group where groupid=$groupid";

	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>����û���</title>
<script>
function CheckLogin(obj){
	if(obj.groupname.value=='')
	{
		alert('�������û������ƣ�');
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
      <td height="60" colspan="2" align="center">�û���Ȩ�޹���</td>
    </tr>
    <tr>
      <td width="124" height="40" align="center">�û�������</td>
      <td><label>
        <input type="text" name="groupname" id="groupname" />
      <input type="hidden" name="eboss" value="add"></label></td>
    </tr>
    <tr>
      <td height="40" align="center">�û���Ȩ��</td>
      <td><p>
       <label>
         <input type="checkbox" name="grouplist[]" value="douser" id="grouplist_0" />
         �û�����</label>
        1<br />
      </p>
      <p><input type="checkbox" name="grouplist[]" value="doi" id="grouplist_1" />
          �������Լ�</label>
      2</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="dotextual" id="grouplist_2" />
         ���Կ�֤����</label>
        3<br />
          &nbsp;&nbsp;&nbsp;<label>
            <input type="checkbox" name="grouplist[]" value="doexam" id="grouplist_3" />
          �׶��Կ��˹���</label>
          4
          <label>
            <input type="checkbox" name="grouplist[]" value="dotextl" id="grouplist_4" />
          ���Կ�֤����</label>
        5</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="doeducational" id="grouplist_5" />
         ����</label>
        6<br />
          &nbsp;&nbsp;&nbsp;<label>
            <input type="checkbox" name="grouplist[]" value="dobook" id="grouplist_6" />
          ��Ŀ����</label>
          7
          <label>
            <input type="checkbox" name="grouplist[]" value="domajor" id="grouplist_7" />
          רҵ����</label>
          <label>8
            <input type="checkbox" name="grouplist[]" value="docourse" id="grouplist_8" />
            �γ̿������
          </label>
      9</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="dostmanage" id="grouplist_9" />
         ѧ������</label>
        10<br />
          &nbsp;&nbsp;&nbsp;<label>
            <input type="checkbox" name="grouplist[]" value="doclteacher" id="grouplist_10" />
          �����ι���</label>
          <label>
            <input type="checkbox" name="grouplist[]" value="doclass" id="grouplist_11" />
          �༶���� </label>
           <input type="checkbox" name="grouplist[]" value="dostudent" id="grouplist_12" />
          ѧ������ </label>
      </p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="domentor" id="grouplist_13" />
         ������</label>
       14<br />
        &nbsp;&nbsp;&nbsp;</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="doteacher" id="grouplist_14" />
         ��ʦ</label>
        <br />
        &nbsp;&nbsp;&nbsp;15</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="doproscenium" id="grouplist_15" />
         ǰ̨</label>
        16<br />
        &nbsp;&nbsp;&nbsp;</p>
      <p>
       <label>
         <input type="checkbox" name="grouplist[]" value="dolook" id="grouplist_16" />
         ���ϲ鿴</label>
        17<br />
        &nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="grouplist[]" value="dolookexam" id="grouplist_17" />
           �鿴�׶��Գɼ�</label>
          <label>
            <input type="checkbox" name="grouplist[]" value="dolooktextual" id="grouplist_18" />
            �鿴���Կ�֤
          </label>
          <label>
            <input type="checkbox" name="grouplist[]" value="dolookcourse" id="grouplist_19" />
          �鿴�γ̿���</label>
          <label>
            <input type="checkbox" name="grouplist[]" value="dolookstudent" id="grouplist_20" />
          �鿴ѧ�����</label></p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    </tr>
    <tr>
      <td height="40">&nbsp;</td>
      <td><label>
        <input type="submit" name="button" id="button" value="�ύ" />
      </label></td>
    </tr>
  </table>
</form>
</body>
</html>