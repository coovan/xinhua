<?php
/*
 * @file 管理学生页面
 * 学生日常管理
 * @author F
 * 
 */
require_once '../class/config.php';//配置文件

if (isset($_GET['state'])){
	$psql = "SELECT * FROM `student` WHERE `state` = '".$_GET['state']."'";
	$pnum=$db->num($psql);
	$page=new page($pnum,"page",20);//实列化分页类
	$pagesize=$page->offset();
	$sql = "SELECT * FROM `student` WHERE `state` = '".$_GET['state']."' limit $pagesize,20";
}else{
	$psql = "SELECT * FROM `student` WHERE `state` = 1";
	$pnum=$db->num($psql);
	$page=new page($pnum,"page",20);//实列化分页类
	$pagesize=$page->offset();
	$sql = "SELECT * FROM `student` WHERE `state` = 1 limit $pagesize,20";
}
$res=$db->query($sql);
$num=$db->num1($res);
?>



<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">当前位置：学生管理 - 学生日常管理</td>
  </tr>

  <tr>
      <td>
      <table style="margin-top:20px; width:100%; margin:10px">
            <tr>
              <td width="6%" nowrap="nowrap"><a href="stu_manage.php?state=2">请假管理</a></td>
              <td width="2%" nowrap="nowrap">&nbsp;</td>
              <td width="92%" nowrap="nowrap"><a href="stu_manage.php?state=1">休学管理</a></td>
            </tr>
          </table>
    </td>
  </tr>
  <tr>
  	<td>
    	<table id="tabhead" width="100%" style="margin-top:20px; width:100%; margin:10px;">
			<tr style="color:#FFF">
            	<td width="20%" height="30" align="center" valign="middle" bgcolor="#3870A8">姓名</td>
                <td width="20%" height="30" align="center" valign="middle" bgcolor="#3870A8">性别</td>
                <td width="20%" height="30" align="center" valign="middle" bgcolor="#3870A8">班级</td>
                <td width="20%" height="30" align="center" valign="middle" bgcolor="#3870A8">状态</td>
            </tr>
            <tr style="margin-top:10px;"><td>&nbsp;</td><td></td><td></td><td></td></tr>
            <?php 
            	for ($i=0;$i<$num;$i++){
            		$row=$db->fetch($res);
            		$csql="SELECT `classname` FROM `class` WHERE `classid` = '".$row['classid']."'";
            		$cl=$db->fetch1($csql);
            ?>
            <tr bgcolor="#CBDCED">
            	<td align="center" valign="middle"><?php echo $row['sname'];?></td>
           	  <td align="center" valign="middle"><?php if($row['sex']==0){echo "男";}else{echo "女";} {
              		;
              	}?></td>
           	  <td align="center" valign="middle"><?php echo $cl['classname'];?></td>
                <td align="center" valign="middle"><?php if($row['state']==1){echo "休学";}elseif($row['state']==2){echo "请假";}?></td>
          </tr>
          <?php }?>
        </table>
    </td>
  </tr>
  <tr>
  	<td align="right"><?php echo $page->show();?></td>
  </tr>
</table>