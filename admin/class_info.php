<?php
/*
 * @file �༶��Ϣҳ��
 * @author F
 */
include_once '../class/config.php';//���������ļ�


/*
 * ����Ǳ�ҵ�༶�����ѱ�ҵ�༶
 * ����ø��Ӱ�~~~~~
 */
if(isset($_GET['state'])){
	if ($_GET["state"]==1){
		$class_num = "SELECT * FROM `class` WHERE `state` = 1 ";
		$num=$db->num($class_num);//��ȡ��ҳ��Ҫ�Ľ������
		$page=new page($num,"page",18);//ʵ�л���ҳ��
		$pagesize=$page->offset();
		
		$get_class = "SELECT * FROM `class` WHERE `state` = 1 limit $pagesize,18 ";//�鿴�ѱ�ҵ�༶
	}elseif ($_GET['state']==0){
		$class_num = "SELECT * FROM `class` WHERE `state` = 0 ";
		$num=$db->num($class_num);//��ȡ��ҳ��Ҫ�Ľ������
		$page=new page($num,"page",18);//ʵ�л���ҳ��
		$pagesize=$page->offset();
		
		$get_class = "SELECT * FROM `class` WHERE `state` = 0 limit $pagesize,18 ";//�鿴�ѱ�ҵ�༶
	}
}else{
	$class_num = "SELECT * FROM `class` WHERE `state` = 0 ";
		$num=$db->num($class_num);//��ȡ��ҳ��Ҫ�Ľ������
		$page=new page($num,"page",18);//ʵ�л���ҳ��
		$pagesize=$page->offset();
		
		$get_class = "SELECT * FROM `class` WHERE `state` = 0 limit $pagesize,18 ";//�鿴�ѱ�ҵ�༶
}
/////////////////////////////////////////////////////////////	
/*
 * �Ѱ༶��Ϊ��ҵ�༶����
 */
function fin_class($classid,$db){
	$fin = "UPDATE `class` SET `state` = '1',`outtime` = '".time()."' WHERE `classid` ='".$classid."' ";
	$res=$db->query($fin);
	if ($res){
		ShowMsg("�޸ĳɹ���","class_info.php");
		exit();
	}
}
//���ø�Ϊ��ҵ��ķ���
if (isset($_GET['fin'])){
	fin_class($_GET['fin'], $db);
}


$result=$db->query($get_class);
$num=$db->num1($result);


?>


<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">��ǰλ�ã��༶����  - �鿴�༶��Ϣ</td>
  </tr>
  <tr>
    <td>
			<br/>
			<table width="900" border="0" align="center">
				<tr>
			    	<td width="104"><a href="class_info.php?state=0">��У�༶����</a></td>
			        <td width="707"><a href="class_info.php?state=1">��ҵ�༶����</a></td>
			        <td width="75"><a href="add_class.php">��Ӱ༶</a></td>
			    </tr>
			</table>
			<table width="1000" border="0" align="center" cellspacing="1" style="margin-top:20px;">
			  <tr>
			    <td width="189" height="30" align="center" valign="middle" bgcolor="#B3CBFF">�� ��</td>
			    <td width="89" height="30" align="center" valign="middle" bgcolor="#B3CBFF">������</td>
			    <td width="240" height="30" align="center" valign="middle" bgcolor="#B3CBFF">ר ҵ</td>
			    <td width="69" align="center" valign="middle" bgcolor="#B3CBFF">�༶����</td>
			    <td width="95" height="30" align="center" valign="middle" bgcolor="#B3CBFF">����ʱ��</td>
			    <td width="91" height="30" align="center" valign="middle" bgcolor="#B3CBFF">��ҵʱ��</td>
			    <td width="205" height="30" align="center" valign="middle" bgcolor="#B3CBFF">����</td>
			  </tr>
			  <tr>
			  	<td height="20"></td>
			  </tr>
			  <?php 
			  	for ($i=0;$i<$num;$i++){
			  		$row = $db->fetch($result);
			  		
			  		//��ȡ����������
			  		$get_uid = "SELECT `truename` FROM `userinfo` WHERE `id` = '".$row['userid']."'";
			  		$result2 = $db->query($get_uid);
			  		$user = $db->fetch($result2);
			  		
			  		//��ȡרҵ
			  		$get_pro = "SELECT `proname` FROM `profession` WHERE `proid` = '".$row['proid']."'";
					$result3 = $db->query($get_pro);
			  		$pro = $db->fetch($result3);
			  		
			  		//��ȡ�༶ѧ������
			  		$get_stu = "SELECT * FROM `student` WHERE `classid` = '".$row['classid']."'";
			  		$stu_num=$db->num($get_stu);		
			  ?>
			  <tr>
			  	<td height="22" align="center" bgcolor="#EBEBEB"><?php echo $row['classname'];?></td>
			  	<td height="22" align="center" bgcolor="#EBEBEB"><?php echo $user['truename'];?></td>
			    <td height="22" align="center" bgcolor="#EBEBEB"><?php echo $pro["proname"];?></td>
			    <td height="22" align="center" bgcolor="#EBEBEB"><?php echo $stu_num;?></td>
			    <td height="22" align="center" bgcolor="#EBEBEB"><?php echo date("Y-m-d",$row['addtime']);?></td>
			    <td height="22" align="center" bgcolor="#EBEBEB"><?php if ($row['outtime']!=0)echo date("Y-m-d",$row['outtime']);?></td>
			    <td height="22" align="center" bgcolor="#EBEBEB"><a href="class_info.php?fin=<?php echo $row['classid'];?>"><?php if ($row['state']==0){echo "��Ϊ��ҵ";}?></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="renew_class.php?classid=<?php echo $row["classid"];?>">�޸�</a></td>
			  </tr>
			  <?php }?>
			</table>
			<table align="right" style="margin-top:20px;">
				<tr>
			    	<td><?php echo $page->show();?></td>
			    </tr>
			</table>
			
			    	
    </td>
  </tr>
</table>
