<?php
/*
 * @file ����ѧ��ҳ��
 * @author F
 * 
 */
//���������ļ�
require_once '../class/config.php';

//�ǹ�����Уѧ�����Ǳ�ҵѧ����ͨ��$_GET['class']��ȷ��
if (isset($_GET['class'])){
	$class = "SELECT * FROM `class` WHERE `state` = '".$_GET['class']."' order by `addtime` desc";
}else {
	//Ĭ����ʾ��У�༶ѧ��
	$class = "SELECT * FROM `class` WHERE `state` = '0' order by `addtime` desc";
}
//��ѯ���༶,��ѡ��
$clnum = $db->num($class);
$cla = $db->query($class);

/**
*ȷ���Ƿ�ѡ����ĳ���༶
*Ҳ���ǰ�ѡ��İ༶ID�ҳ�����Ϊ��ʾ��׼��
*�����ѡ����ͨ����ַ����ȡ
*Ĭ����ʾ�����¿���İ༶
*/
if (isset($_POST['submit'])){
	$classid=$_POST['class'];
}elseif (isset($_GET['classid'])){
	$classid=$_GET['classid'];
}else{
	$c_id=$db->fetch1($class);
	$classid=$c_id["classid"];
}

//��ѯ��������������ڷ�ҳ
$stupage = "SELECT * FROM `student` WHERE `classid` = '".$classid."'  AND `state`<>2";
$stu_num = $db->num($stupage);
$page=new page($stu_num,"page",14);//ʵ�л���ҳ��
$pagesize=$page->offset();//�õ���ҳ��Ҫ������
//�Ѱ༶Idд��url��GET �У���õ����һҳʱ��������,�������~~
$page->_set_url('?classid='.$classid);

//��ҳ��ʾ����
$stu = "SELECT * FROM `student` WHERE `classid` = '".$classid."' AND `state`<>2 limit $pagesize,14 ";
$stu_res=$db->query($stu);
$num=$db->num($stu);

/*
 * ɾ��ѧ��
 */
if (isset($_GET['del_stu'])){
	$del_stu = "UPDATE `student` SET `state` = '2' WHERE `sid` ='".$_GET['del_stu']."'";
	$del=$db->query($del_stu);
	if ($del){
		ShowMsg("ɾ���ɹ���","stu_info.php?classid=".$classid);
		exit();
	}
}



?>
<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">��ǰλ�ã�ѧ������ - �鿴ѧ����Ϣ</td>
  </tr>
  <tr>
  	<td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td>
    <form action="" method="post">
    	<table width="100%">
        	<tr>
            	<td></td>
            	<td><a href="stu_info.php?class=0">������Уѧ��</a></td>
                <td>&nbsp;&nbsp;<a href="stu_info.php?class=1">�����ҵѧ��</a></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
            </tr>
        	<tr>
            	<td width="21">&nbsp;</td>
            	<td width="99" nowrap="nowrap">ѡ��༶��</td>
				<td width="158">
                	<select name="class" style="width:150px;">
                	<?php 
                		for ($i=0;$i<$clnum;$i++){
                			$res = $db->fetch($cla);         			
                	?>
                	  <option <?php if($res['classid']==$_SESSION['classid']){echo "checked";}?> value="<?php echo $res['classid'];?>"><?php echo $res['classname'];?></option>
                	  <?php }?>
                	</select>
                </td>
                <td width="735"><input type="submit" value="ѡ��" name="submit" /></td>
            </tr>
      </table>
      <table width="100%" cellspacing="2" style="margin-top:20px;">
      	<tr style=" color:#FFF;">
        	<td width="17%" height="30" align="center" valign="middle" bgcolor="#376DA4">��  ��</td>
            <td width="26%" height="30" align="center" valign="middle" bgcolor="#376DA4">��  ��</td>
            <td width="5%" height="30" align="center" valign="middle" bgcolor="#376DA4">��  ��</td>
            <td width="14%" height="30" align="center" valign="middle" bgcolor="#376DA4">��  ��</td>
            <td width="5%" height="30" align="center" valign="middle" bgcolor="#376DA4">״  ̬</td>
            <td width="30%" height="30" align="center" valign="middle" bgcolor="#376DA4">��  ��</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <?php 
        	for ($s=0;$s<$num;$s++){
        		$stu_row=$db->fetch($stu_res);
        		$stu_class= "SELECT * FROM `class` WHERE `classid` = '".$stu_row['classid']."'";
        		$sc=$db->fetch1($stu_class);
        ?>
        <tr>
        	<td height="24" align="center" valign="middle" bgcolor="#DCE8F3"><?php echo $stu_row['sname']?></td>
            <td height="24" align="center" valign="middle" bgcolor="#DCE8F3"><?php echo $sc['classname'];?></td>
            <td height="24" align="center" valign="middle" bgcolor="#DCE8F3"><?php if($stu_row['sex']==1){ echo "��";}else{echo "Ů";}?></td>
            <td height="24" align="center" valign="middle" bgcolor="#DCE8F3"><?php echo $stu_row['tel']?></td>
            <td height="24" align="center" valign="middle" bgcolor="#DCE8F3"><?php if ($stu_row['state']==0){echo "<font color='#00ff00'>����</font>";}elseif($stu_row['state']==0) {echo "<font color='red'>��ѧ</font>";}?></td>
            <td height="24" align="center" valign="middle" bgcolor="#DCE8F3">
              <table width="100%" border="0">
                <tr>
                  <td align="center" valign="middle" nowrap="nowrap"><a href='look_stu.php?look=<?php echo $stu_row['sid'];?>'>�鿴</a></td>
                  <td align="center" valign="middle" nowrap="nowrap"><a href="renew_stu.php?stuid=<?php echo $stu_row['sid'];?>">�޸�</a></td>
                  <td align="center" valign="middle" nowrap="nowrap"><a href="stu_info.php?del_stu=<?php echo $stu_row['sid'];?>">ɾ��</a></td>
                </tr>
            </table></td>
        </tr>
        <?php }?>
      </table>
      <table align="right">
      	<tr>
        	<td><?php echo $page->show();?></td>
        </tr>
      </table>
      </form>
    </td>
  </tr>
</table>