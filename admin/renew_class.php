<?php
/*
 * @file �༶����ҳ��
 * �޸İ༶
 * @author F
 */
include_once '../class/config.php';//���������ļ�

//�ӵ�ַ����ȡ��Ҫ�޸İ༶��id
if (!isset($_GET["classid"])){
	ShowMsg("��ѡ��༶���ٷ��ʱ�ҳ��","class_info.php","ϵͳ��ʾ��");
	exit();
}
	//��ѯ�༶�������Ϣ
	$get_class="SELECT * FROM `class` WHERE `classid` = '".$_GET["classid"]."' ";
	$result=$db->query($get_class);
	$row_cla=$db->fetch($result);//ȡ�ý��
	
	//��ѯ������
	$get_cmen="SELECT * FROM `userinfo` WHERE `isclass` = 1";
	$cmen_res=$db->query($get_cmen);
	$cmen_num=$db->num1($cmen_res);
	
	//��ѯרҵ
	$get_pro="SELECT * FROM `profession`";
	$pro_res=$db->query($get_pro);
	$pro_num=$db->num1($pro_res);

//�������ύ	
if (isset($_POST['submit'])){
	
	//��������ֵ
	$userid=$_POST["headclass"][0];
	$pro=$_POST["pro"][0];
	
	//sql���
	$up_class="UPDATE `class` SET  
	`classname` = '".$_POST['classname']. " ', 
	`proid` = '".$pro. " ', 
	`userid` = '".$userid. " ', 
	`addtime` = '".$_POST['addtime']. " ', 
	`outtime` = '".$_POST['outtime']. " ', 
	`whodo` = '".$_COOKIE['userid']. " '  
	 WHERE `classid` =".$_GET['classid'].";";
	
	//ִ��sql���
	$update=$db->query($up_class);
	
	//��ʾִ����Ϣ
	if ($update){
		ShowMsg("�޸ĳɹ���","class_info.php","ϵͳ��ʾ��");
		exit();
	}else {
		ShowMsg("δ֪����","class_info.php","ϵͳ��ʾ��");
		exit();
	}
}





?>

<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">��ǰλ�ã��༶���� - �޸İ༶</td>
  </tr>
  <tr>
    <td>
		<div style="width:150px; margin:0 auto;">
		<h1>�޸İ༶</h1>
		</div>
		<hr />
		<br/>
		<form id="renewclass" name="renewclass" method="post" action="">
			<table width="900" cellspacing="2">
				<tr>
		        	<td width="200" bgcolor="#EEEEFF">�޸İ༶����</td>
		          	<td bgcolor="#EEEEFF"><input type="text" name="classname" value="<?php echo $row_cla['classname']?>"></input></td>
		      </tr>
		      <tr>
		      		<td bgcolor="#EEEEFF">�޸Ŀ���ʱ�䣺</td>
		            <td bgcolor="#EEEEFF"><input type="text" name="addtime" value="<?php echo date("Y-m-d",$row_cla['addtime'])?>" /></td>
		      </tr>
		      <tr>
		      		<td bgcolor="#EEEEFF">�޸ı�ҵʱ��</td>
		            <td bgcolor="#EEEEFF"><input type="text" name="outtime" value="<?php echo $row_cla['outtime']?>" /></td>
		      </tr>
		      <tr>
		      		<td valign="middle" bgcolor="#EEEEFF">�޸�רҵ��</td>
		            <td bgcolor="#EEEEFF">
		            	<div>
		                	<ul>
		                	<?php 
		                		//������רҵѭ��������ѡ�񣬵�ǰרҵ��ѡ��״̬
		                		for ($i=0;$j<$pro_num;$j++){
		                			$pro_row=$db->fetch($pro_res);		
		                	?>
		                    	<li style="float:left"><input type="radio" name="pro[]" <?php if($row_cla['proid']==$pro_row['proid']){echo " checked ";}?> value="<?php echo $pro_row['proid']?>" id="proid" /><?php echo $pro_row['proname']?></li>
		                       <?php }?>
		                        <li style="clear:both"></li>
		                    </ul>
		                </div>
		            </td>
		      </tr>
		      <tr>
		      		<td valign="middle" bgcolor="#EEEEFF">�����α��:</td>
		            <td align="left" valign="middle" bgcolor="#EEEEFF">
		            	<div>
		                	<ul>
		                	<?php 
		                		//�����а�����ѭ��������ѡ�񣬵�ǰ�����α�ѡ��״̬
		                		for ($i=0;$i<$cmen_num;$i++){
		                			$row_cmen=$db->fetch($cmen_res);		
		                	?>
		                    	<li style="float:left"><input type="radio" name="headclass[]"<?php if($row_cla['userid']==$row_cmen['id']){echo " checked";} ?> value="<?php echo $row_cmen['id']?>" id="classmen" /><?php echo $row_cmen['truename']?></li>
		                    <?php }?>
		                        <li style="clear:both"></li>
		                    </ul>
		                </div>
		            </td>
		      </tr>
		      <tr>
		      	<td height="15"></td>
		        <td height="15"></td>
		      </tr>
		      <tr>
		      		<td>&nbsp;</td>
		            <td align="right"><table width="200" border="0">
		              <tr>
		                <td width="98" align="right">
		                	<input name="cancle" type="button" value="ȡ  ��" onclick="javascript:history.go(-1)" />
		                </td>
		                <td width="60" align="right">
		                  	<input type="submit" name="submit" id="button" value="��  ��" />
						</td>
		                <td width="20">&nbsp;</td>
		              </tr>
		            </table></td>
		      </tr>
			</table>
		</form>
    	
    </td>
  </tr>
</table>














