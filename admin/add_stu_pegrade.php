<?php
/*教师添加平时成绩页面
 * @author F
 */
header("Content-Type: text/html; charset=gbk");
include_once '../class/config.php';//导入配置文件

$user=$_COOKIE['userid'];//取得当前登录的教师的id

//查询出当前教师任教的班级
$ClassSql = "SELECT `classid` FROM `syllabus` WHERE `userid` = '$user' AND `state` = 3 GROUP BY `classid`";// ? AND `state` = 3 表示阶段考核考了才有平时成绩
$ClaRes = $db->query($ClassSql);
$ClaNum = $db->num1($ClaRes);


//是否选择了班级
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
    <td height="38" class="right_bg">当前位置：相关操作 - 平时成绩管理</td>
  </tr>
  <tr>
    <td>
        <form action="" method="post">
            <table>
                <tr>
                    <td>&nbsp;</td>
                    <td>选择班级</td>
                    <td>
                    <select name="class" id="class" style="width:160px;" onchange='window.location="add_stu_pegrade.php?class="+this.value'>
                    <?php 
                    //这里把班级循环出来供选择
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
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#34699D">姓名</td>
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#34699D">班级</td>
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#34699D">科目</td>
              <td width="20%" height="30" align="center" valign="middle" bgcolor="#34699D">平时成绩</td>
          </tr>
			<tr>
              <td width="20%" height="20" align="center" valign="middle" bgcolor="#DCE8F3">姓名</td>
              <td width="20%" height="20" align="center" valign="middle" bgcolor="#DCE8F3">班级</td>
              <td width="20%" height="20" align="center" valign="middle" bgcolor="#DCE8F3">科目</td>
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

