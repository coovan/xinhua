<?php 
/*
 * @file ���ѧ��ҳ��
 * @author F
 * 
 */
include_once '../class/config.php';//���������ļ�
session_start();
//�Ѱ༶ѡ���ѯ����
$class = "SELECT * FROM `class` WHERE `state` = 0";
$cresult = $db->query($class);
$cnum = $db->num1($cresult);

//�ж��Ƿ����ˡ���ӡ� ��ť
if (isset($_POST["submit"])){
	$name=$_POST['stuname'];
	$snum=$_POST['stunum'];
	$sex=$_POST['sex'];
	$stu_img=$_SESSION['stu_img'];
	$date=strtotime($_POST['date']);
	$tel=$_POST['tel'];
	$ftel=$_POST['father_tel'];
	$qq=$_POST["qq"];
	$email=$_POST['email'];
	$address=$_POST['address'];
	$class=$_POST['class'][0];
	$intime=time();
	$sql = "INSERT INTO `student` (
`sid` ,
`snum` ,
`sname` ,
`sex` ,
`simg` ,
`age` ,
`tel` ,
`htel` ,
`qq` ,
`email` ,
`classid` ,
`intime` ,
`outtime` ,
`adress` ,
`state` ,
`schoolid` 
)
VALUES (
NULL , '".$snum."' , '".$name."', '".$sex."','".$stu_img."' , '".$date."' , '".$tel."' , '".$ftel."' , '".$qq."' , '".$email."' , '".$class."' , '".$intime."' , NULL , '".$address."' , 0 , NULL);
"; 
	
	$con = $db->query($sql);
	if ($con){
		ShowMsg("��ӳɹ���","add_stu.php");
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
    <td height="38" class="right_bg">��ǰλ�ã�ѧ������ - ���ѧ��</td>
  </tr>
  <tr>
    <td style="padding:0 20px;">
    	<form action="" method="post" id="add_stu" style="margin-top:20px;">
        	<table width="60%" align="left" cellspacing="3" bgcolor="#FFFFFF">
<tr>
           	<td width="99" height="24" bgcolor="#E6EBF7"><div align="center">ѧ��������</div></td>
            <td width="476" height="24" bgcolor="#E6EBF7"><input type="text" name="stuname" /></td>
              </tr>
              <tr>
           		<td height="24" bgcolor="#E6EBF7"><div align="center">ѧ �ţ�</div></td>
                <td height="24" bgcolor="#E6EBF7"><input type="text" name="stunum"  /></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�Ա�:</div></td>
              <td height="24" bgcolor="#E6EBF7">
               	<input type="radio" name="sex" value="1" id="sex" />��
               	  <input type="radio" name="sex" value="2" id="sex" />Ů					</td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">��������:</div></td>
                  <td height="24" bgcolor="#E6EBF7">
                  	<select id="idYear" style="width:70px;"></select> 
					<select id="idMonth" style="width:60px;"></select> 
					<select id="idDay" style="width:60px;"></select> 
                    <script type="text/javascript">
							var ds = new DateSelector("idYear", "idMonth", "idDay", {
							MaxYear: new Date().getFullYear() + 2,
							onChange: function(){ $("idShow").value = this.Year + "-" + this.Month + "-" + this.Day; }
						});
	
						ds.onChange();
					</script>
                    <input type="hidden" name="date" id="idShow" />
                 </td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�绰:</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="tel" /></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�ҳ��绰��</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="father_tel" /></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">Q  Q:</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="qq" /></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">�����ʼ���</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="email" /></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">��ͥסַ��</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input name="address" type="text" size="50" /></td>
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
                    			<li style="float:left; width:235px;"><input type="radio" name="class[]" value="<?php echo $crow["classid"];?>" /><?php echo $crow["classname"];?>&nbsp&nbsp</li>
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
                        	<iframe src="uppic.php" frameborder="0" scrolling="no" width="100%" height="100%"></iframe>
                      </div>
                    </td>
              </tr>
          </table>
            <table width="100%" align="center" style="margin-top:20px">
       	    <tr>
               	  <td width="7%" align="left"><input type="submit" value="�� ��" name="submit" /></td>
				  <td width="93%" align="left"><input type="button" value="ȡ ��" name="cancle" onclick="javascript:history.go(-1);" /></td>
              </tr>
          </table>
      </form>
    </td>
  </tr>
</table>
