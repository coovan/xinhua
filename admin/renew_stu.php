<?php 
/*
 * @file �޸�ѧ��ҳ��
 * @author F
 * 
 */
include_once '../class/config.php';//���������ļ�
session_start();
//�Ѱ༶ѡ���ѯ����
$class = "SELECT * FROM `class` WHERE `state` = 0";
$cresult = $db->query($class);
$cnum = $db->num1($cresult);

//ͨ��ѧ��id ������
if (isset($_GET['stuid'])){
	$stu = "SELECT * FROM `student` WHERE `sid` = '".$_GET['stuid']."' ";
	$sres = $db->fetch1($stu);
	
}else{
	ShowMsg("��ѡ��ѧ�����ٷ��ʱ�ҳ��","stu_info.php");
	exit();
}


//�ж��Ƿ����ˡ��޸ġ� ��ť
if (isset($_POST["submit"])){
	$name=$_POST['stuname'];
	$snum=$_POST['stunum'];
	$sex=$_POST['sex'][0];
	if(!isset($_SESSION['stu_img'])){
		$stu_img=$sres["simg"];
	}else{
		$stu_img=$_SESSION['stu_img'];
	}
	$date=strtotime($_POST['date']);
	$tel=$_POST['tel'];
	$htel=$_POST['htel'];
	$qq=$_POST["qq"];
	$email=$_POST['email'];
	$address=$_POST['address'];
	$class=$_POST['class'][0];
	$intime=strtotime($_POST['intime']);
	$outtime=strtotime($_POST["outtime"]);
	$state = $_POST["state"][0];
	$schoolid=$_POST["schoolid"];

	$sql = "UPDATE `student` SET 
`snum` = '".$snum."',
`sname`	= '".$name."',
`sex` = '".$sex."',
`simg` = '".$stu_img."',
`age`  = '".$date."',
`tel` = '".$tel."',
`htel`  = '".$htel."',
`qq` = '".$qq."',
`email` = '".$email."',
`classid` = '".$class."',
`intime` = '".$intime."',
`outtime` = '".$outtime."',
`adress` ='".$address."',
`state` = '".$state."',
`schoolid` = '".$schoolid."'
 WHERE `sid` ='".$_GET['stuid']."';";
	
	$con = $db->query($sql);//ִ��sql���,����ѧ����Ϣ
	if ($con){
		ShowMsg("�޸ĳɹ���","add_stu.php");
		exit();
	}
	
}








?>

<style>
	#add_stu{ line-height:24px;}
	#add_stu input{ border:none; margin-left:10px;}
</style>
<link href="style/right.css" rel="stylesheet" type="text/css" />
<script src="../js/date.js" type="text/javascript" language="javascript"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">��ǰλ�ã�ѧ������ - �޸�ѧ����Ϣ</td>
  </tr>
  <tr>
    <td style="padding:0 20px;">
    	<form action="" method="post" id="add_stu" style="margin-top:20px;">
        	<table width="60%" align="left" cellspacing="3" bgcolor="#FFFFFF">
<tr>
           	<td width="99" height="24" bgcolor="#E6EBF7"><div align="center">ѧ��������</div></td>
            <td width="476" height="24" bgcolor="#E6EBF7"><input type="text" name="stuname" value="<?php echo $sres['sname'];?>" /></td>
              </tr>
              <tr>
           		<td height="24" bgcolor="#E6EBF7"><div align="center">ѧ �ţ�</div></td>
                <td height="24" bgcolor="#E6EBF7"><input type="text" name="stunum" value="<?php echo $sres['snum'];?>"/></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�Ա�:</div></td>
              <td height="24" bgcolor="#E6EBF7">
               	<input type="radio" name="sex" value="1" id="sex" <?php if ($sres['sex']==1){echo "checked";}?>/>��
               	<input type="radio" name="sex" value="0" id="sex" <?php if ($sres['sex']==0){echo "checked";}?>/>Ů					</td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">��������:</div></td>
                  <td height="24" bgcolor="#E6EBF7">
                    <input type="text" name="date" id="idShow" value="<?php echo date("Y-m-d",$sres['age']);?>"/>
                 </td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�绰:</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="tel"  value="<?php echo $sres['tel'];?>"/></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�ҳ��绰��</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="htel" value="<?php echo $sres['htel'];?>"/></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">Q  Q:</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="qq" value="<?php echo $sres['qq'];?>"/></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�����ʼ���</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="email" value="<?php echo $sres['email'];?>"/></td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">��ѧʱ�䣺</div></td>
                  <td height="24" bgcolor="#E6EBF7">
                    <input type="text" name="intime" id="inShow" value="<?php echo date("Y-m-d",$sres['intime']);?>"/>
                 </td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">��ҵʱ�䣺</div></td>
                  <td height="24" bgcolor="#E6EBF7">
                    <input type="text" name="outtime" id="outShow" value="<?php echo date("Y-m-d",$sres['outtime']);?>"/>
                 </td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">��ͥסַ��</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input name="address" type="text" size="50" value="<?php echo $sres['adress'];?>"/></td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">ѧ��״̬��</div></td>
              	  <td height="24" bgcolor="#E6EBF7">
              	  	<input name="state[]" <?php if($sres['state']==0){echo "checked";}?> type="radio" value="0" />����
                    <input name="state[]" type="radio" <?php if($sres['state']==1){echo "checked";}?> value="1" />��ѧ
                 </td>
              </tr>
                <tr>
                	<td width="100" nowrap="nowrap" bgcolor="#E6EBF7"><div align="center">���ڰ༶��</div></td>
                  <td bgcolor="#E6EBF7">
<div>
                    	<ul>
                    <?php 
                    	for ($c=0;$c<$cnum;$c++){//ѭ�����༶id������
                    		$crow=$db->fetch($cresult);                    	
                    ?>
                    			<li style="float:left; width:235px;"><input type="radio" name="class[]" <?php if ($sres['classid']==$crow["classid"]){echo "checked";}?> value="<?php echo $crow["classid"];?>" /><?php echo $crow["classname"];?>&nbsp&nbsp</li>
                    <?php }?>
                    			<li style="clear:both"></li>
                    	</ul>
                    </div>                    </td>
              </tr>
          </table>
<table width="40%">
       	  		<tr>
                	<td>
                   	  <div style="height:300px; width:100%; background:#fff;">
                        	<iframe src="uppic.php?stuid=<?php echo $sres['sid'];?>" frameborder="0" scrolling="no" width="100%" height="100%"></iframe>
                      </div>
                    </td>
              </tr>
          </table>
            <table width="100%" align="center" style="margin-top:20px">
       	    <tr>
               	  <td width="7%" align="left"><input type="submit" value="�޸�" name="submit" /></td>
				  <td width="93%" align="left"><input type="button" value="ȡ ��" name="cancle" onclick="javascript:history.go(-1);" /></td>
              </tr>
          </table>
      </form>
    </td>
  </tr>
</table>
