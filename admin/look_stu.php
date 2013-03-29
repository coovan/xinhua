<?php 
/*
 * @file 管理学生页面
 * 查看学生详细信息
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
    <td height="38" class="right_bg">当前位置：学生管理 - 学生详细信息</td>
  </tr>
  <tr>
    <td style="padding:0 20px;">
   	  <table width="60%" align="left" cellspacing="3" bgcolor="#FFFFFF">
<tr>
           	<td width="99" height="24" bgcolor="#E6EBF7"><div align="center">学生姓名：</div></td>
            <td width="476" height="24" bgcolor="#E6EBF7"><?php echo $look['sname']?></td>
              </tr>
              <tr>
           		<td height="24" bgcolor="#E6EBF7"><div align="center">学 号：</div></td>
                <td height="24" bgcolor="#E6EBF7"><?php echo $look['snum']?></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">性别:</div></td>
              <td height="24" bgcolor="#E6EBF7">
              <?php 
              	if ($look['sex']==1){echo "男";}else {echo "女";}
              ?>
          		</td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">出生日期:</div></td>
                  <td height="24" bgcolor="#E6EBF7">
                   	<?php echo date("Y-m-d",$look['age']);?>
                 </td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">电话:</div></td>
                  <td height="24" bgcolor="#E6EBF7"><?php echo $look['tel']?></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">家长电话：</div></td>
                  <td height="24" bgcolor="#E6EBF7"><?php echo $look['htel']?></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">Q  Q:</div></td>
                  <td height="24" bgcolor="#E6EBF7"><?php echo $look['qq']?></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">电子邮件：</div></td>
                  <td height="24" bgcolor="#E6EBF7"><?php echo $look['email']?></td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">入学时间：</div></td>
                  <td height="24" bgcolor="#E6EBF7">
                    <?php if (!empty($look['intime'])) echo date("Y-m-d",$look['intime'])?>
                 </td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">毕业时间：</div></td>
                  <td height="24" bgcolor="#E6EBF7">
					<?php if (!empty($look['outtime'])) echo date("Y-m-d",$look['outtime'])?>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">家庭住址：</div></td>
                  <td height="24" bgcolor="#E6EBF7"><?php echo $look['adress']?></td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">学生状态：</div></td>
              	  <td height="24" bgcolor="#E6EBF7">
              	  	<?php if ($look['state']==0){echo "正常";}elseif ($look['state']==1){echo "休学";}?>
                 </td>
              </tr>
                <tr>
                	<td width="100" nowrap="nowrap" bgcolor="#E6EBF7"><div align="center">所在班级：</div></td>
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
