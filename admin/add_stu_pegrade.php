<?php
/*��ʦ���ƽʱ�ɼ�ҳ��
 * @author F
 */
header("Content-Type: text/html; charset=gbk");
include_once '../class/config.php';//���������ļ�

$user=$_COOKIE['userid'];//ȡ�õ�ǰ��¼�Ľ�ʦ��id

//��ѯ����ǰ��ʦ�ν̵İ༶
$ClassSql = "SELECT `classid` FROM `syllabus` WHERE `userid` = '$user' AND `state` = 3 GROUP BY `classid`";// ? AND `state` = 3 ��ʾ�׶ο��˿��˲���ƽʱ�ɼ�
$ClaRes = $db->query($ClassSql);
$ClaNum = $db->num1($ClaRes);


//�Ƿ�ѡ���˰༶
if (isset($_GET['class'])){
	$class = $_GET['class'];
	$_SESSION['class']=$class;
}elseif (!empty($_SESSION['class'])){
	$class=$_SESSION['class'];
}else{
	$class =0;
}
/////////////////////////////////////////////



?>







<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">��ǰλ�ã���ز��� - ƽʱ�ɼ�����</td>
  </tr>
  <tr>
    <td>
        <form action="" method="post">
            <table>
                <tr>
                    <td>&nbsp;</td>
                    <td>ѡ��༶</td>
                    <td>
                    <select name="class" id="class" style="width:160px;" onchange='window.location="add_stu_pegrade.php?class="+this.value'>
                    <?php 
                    //����Ѱ༶ѭ��������ѡ��
                    	for ($C=0;$C<$ClaNum;$C++){
                    		$CRos = $db->fetch($ClaRes);
                    		$ClaNamSql = "SELECT `classname` FROM `class` WHERE `classid` =$CRos[0]";
                    		$ClaNam = $db->fetch1($ClaNamSql); 
                    ?>
                    		<option value="<?php echo $CRos[0];?>" <?php if ($CRos[0]==$class){echo "selected";}?> ><?php echo $ClaNam[0];?></option>
                         <?php }?>  
                         </select>
                          
                    </td>
                </tr>
            </table>
         </form>   
    </td>
  </tr>
  <tr>
  	<td><form action="" method="post">
    	<table width="100%">
			<tr>
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#34699D">����</td>
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#34699D">�༶</td>
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#34699D">��Ŀ</td>
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#34699D">ƽʱ�ɼ�</td>
          </tr>
			<tr>
              <td width="20%" height="20" align="center" valign="middle" bgcolor="#DCE8F3">����</td>
              <td width="20%" height="20" align="center" valign="middle" bgcolor="#DCE8F3">�༶</td>
              <td width="20%" height="20" align="center" valign="middle" bgcolor="#DCE8F3">��Ŀ</td>
              <td width="20%" height="20" align="center" valign="middle" bgcolor="#DCE8F3">
              	<input type="text" name="mark"  style="text-align:center; border:none" />
              </td>
          </tr>
       </table> </form>
    </td>
  </tr>
  <tr>
  	<td>
         <table align="right">
   	  		<tr>
            	<td align="right">
                	<?php // echo $page->show();?>                
                </td>
            </tr>
        </table>
    </td>
  </tr>


</table>

