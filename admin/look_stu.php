<?php 
/*
 * @file ����ѧ��ҳ��
 * �鿴ѧ����ϸ��Ϣ
 * @author F
 * 
 */
require_once '../class/config.php';
if(isset($_GET['look'])){
$sql = "SELECT * FROM `student` as s,`class` as c WHERE s.sid = '".$_GET['look']."' AND s.classid = c.classid ";
$res=$db->query($sql);
$look=$db->fetch($res);
}


?>

<style>
	#add_stu{ line-height:24px;}
	#add_stu input{ border:none; margin-left:10px;}
</style>
<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">��ǰλ�ã�ѧ������ - ѧ����ϸ��Ϣ</td>
  </tr>
  <tr>
    <td style="padding:0 20px;">
   	  <table width="60%" align="left" cellspacing="3" bgcolor="#FFFFFF">
<tr>
           	<td width="99" height="24" bgcolor="#E6EBF7"><div align="center">ѧ��������</div></td>
            <td width="476" height="24" bgcolor="#E6EBF7"><?php echo $look['sname']?></td>
              </tr>
              <tr>
           		<td height="24" bgcolor="#E6EBF7"><div align="center">ѧ �ţ�</div></td>
                <td height="24" bgcolor="#E6EBF7"><?php echo $look['snum']?></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�Ա�:</div></td>
              <td height="24" bgcolor="#E6EBF7">
              <?php 
              	if ($look['sex']==1){echo "��";}else {echo "Ů";}
              ?>
          		</td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">��������:</div></td>
                  <td height="24" bgcolor="#E6EBF7">
                   	<?php echo date("Y-m-d",$look['age']);?>
                 </td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�绰:</div></td>
                  <td height="24" bgcolor="#E6EBF7"><?php echo $look['tel']?></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�ҳ��绰��</div></td>
                  <td height="24" bgcolor="#E6EBF7"><?php echo $look['htel']?></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">Q  Q:</div></td>
                  <td height="24" bgcolor="#E6EBF7"><?php echo $look['qq']?></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�����ʼ���</div></td>
                  <td height="24" bgcolor="#E6EBF7"><?php echo $look['email']?></td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">��ѧʱ�䣺</div></td>
                  <td height="24" bgcolor="#E6EBF7">
                    <?php if (!empty($look['intime'])) echo date("Y-m-d",$look['intime'])?>
                 </td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">��ҵʱ�䣺</div></td>
                  <td height="24" bgcolor="#E6EBF7">
					<?php if (!empty($look['outtime'])) echo date("Y-m-d",$look['outtime'])?>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">��ͥסַ��</div></td>
                  <td height="24" bgcolor="#E6EBF7"><?php echo $look['adress']?></td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">ѧ��״̬��</div></td>
              	  <td height="24" bgcolor="#E6EBF7">
              	  	<?php if ($look['state']==0){echo "����";}elseif ($look['state']==1){echo "��ѧ";}?>
                 </td>
              </tr>
                <tr>
                	<td width="100" nowrap="nowrap" bgcolor="#E6EBF7"><div align="center">���ڰ༶��</div></td>
                  <td bgcolor="#E6EBF7">
                  <?php echo $look['classname']?>
                 </td>
              </tr>
          </table>
          
<table width="40%" align="center">
       	  		<tr>
                	<td align="center" valign="left">
  						<img  src="../stupic/<?php echo $look['simg'];?>" height="250px">
                    </td>
              </tr>
          </table>

    </td>
  </tr>
</table>
