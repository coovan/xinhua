<?php
/*
 * @file
 * �༶����ҳ��
 * ��Ӱ༶
 * @author F
 */
include_once '../class/config.php';//���������ļ�
$sql="SELECT * FROM `profession`";//��ѯרҵ
$result_pro=$db->query($sql);//ȡ��רҵ�Ľ��
$num=$db->num1($result_pro);//ȡ��רҵ���������
$sql2="SELECT * FROM `userinfo` WHERE `isclass` = 1";//��ѯ��������
$result_isc=$db->query($sql2);
$num2=$db->num1($result_isc);//�õ�������

function add_class($classname,$proid,$userid,$addtime,$whodo,$db){//�������ݿ�
	$sql_add="INSERT INTO `class` (`classid` ,`classname` ,`proid` ,`userid` ,`addtime` ,`outtime` ,`state` ,`whodo` ) VALUES (NULL , '".$classname."', '".$proid."', '".$userid."', '".$addtime."', '', '0', '".$whodo."')";
	$db->query($sql_add);//�����ݵ������ݿ���
	if ($db){//����ɹ�
		ShowMsg("��ӳɹ���","add_class.php","ϵͳ��ʾ��");//��ʾ�ɹ�
		exit();
	}
}
if (isset($_POST["submit"]) && $_POST["submit"]!=""){		//����ύ
	if (empty($_POST["classname"])){						//�༶���Ʋ���Ϊ��
		echo "<script>alert(\"����д�༶���ƣ�\")</script>";
	}elseif (empty($_POST["headclass"])){				//�����β���Ϊ��
		echo "<script>alert(\"��ѡ������Σ�\")</script>";
	}elseif (empty($_POST["addtime"])){
		$addtime=time();								//Ĭ�Ͽ���ʱ��Ϊ����
		add_class($_POST["classname"],$_POST["profession"], $_POST["headclass"], $addtime, $_COOKIE["userid"],$db);
	}else {//�����������������
		$addtime=strtotime($_POST["addtime"]);
		add_class($_POST["classname"],$_POST["profession"], $_POST["headclass"], $addtime, $_COOKIE["userid"],$db);
	}
}






?>

<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">��ǰλ�ã��༶���� - �༶����</td>
  </tr>
  <tr>
    <td>
		<br />
		<hr />
		<br/>
		<form action="" method="post" name="add_class">
		<table width="100%">
			<tr>
		    	<td width="95" align="left" nowrap="nowrap">�༶���ƣ�</td>
	    	  <td width="154" align="left" nowrap="nowrap"><input name="classname" type="text" size="18" /></td>
	          <td width="82" align="left" nowrap="nowrap">����ʱ��:</td>
	    	  <td width="145" align="left" nowrap="nowrap"><input name="addtime" type="text" size="12" /></td>
              <td width="6" align="left" nowrap="nowrap">&nbsp;</td>
              <td width="101" align="left" nowrap="nowrap">ѡ�������:</td>
	          <td width="108" align="left" nowrap="nowrap">
                  <select name="headclass">
                    <?php //ѭ����������
                        for ($a=0;$a<$num2;$a++){
                            $row_isc=$db->fetch($result_isc);
                    
                    ?>
                    <option value="<?php echo $row_isc["id"]?>"><?php echo $row_isc["truename"]?></option>
                  <?php }?>
              	</select>
              </td>
	          <td width="8" align="left" nowrap="nowrap"></td>
	          <td width="83" align="left" nowrap="nowrap">ѡ��רҵ:</td>
		        <td width="346" align="left" nowrap="nowrap">
	        	  <select name="profession">
		        		<?php
		        		/*
		        	     *ѭ�����רҵ
		        		 */
		        			for ($i=0;$i<$num;$i++){
		        				$row_pro=$db->fetch($result_pro);
		        		?>
		          		<option value="<?php echo $row_pro["proid"]?>"><?php echo $row_pro["proname"]?></option>
		          		<?php } //ѭ������?>
		      		</select>
		        </td>
		    </tr>
		</table>
		<p>&nbsp;</p>
		<br/>
		<table width="100%">
		  <tr>
		    	<td><input type="submit" value="��  ��" name="submit" /></td>
		        <td></td>
		        <td width="80"><input name="cancle" type="button" value="ȡ  ��" onclick="javascript:history.go(-1)" /></td>
			</tr>
		</table>

</form>
	</td>
  </tr>
</table>
