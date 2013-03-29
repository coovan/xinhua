<?php 
/*
 * @file 修改学生页面
 * @author F
 * 
 */
include_once '../class/config.php';//导入配置文件
session_start();
//把班级选项查询出来
$class = "SELECT * FROM `class` WHERE `state` = 0";
$cresult = $db->query($class);
$cnum = $db->num1($cresult);

//通过学生id 来操作
if (isset($_GET['stuid'])){
	$stu = "SELECT * FROM `student` WHERE `sid` = '".$_GET['stuid']."' ";
	$sres = $db->fetch1($stu);
	
}else{
	ShowMsg("请选择学生后再访问本页！","stu_info.php");
	exit();
}


//判断是否点击了‘修改’ 按钮
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
	
	$con = $db->query($sql);//执行sql语句,更新学生信息
	if ($con){
		ShowMsg("修改成功！","add_stu.php");
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
    <td height="38" class="right_bg">当前位置：学生管理 - 修改学生信息</td>
  </tr>
  <tr>
    <td style="padding:0 20px;">
    	<form action="" method="post" id="add_stu" style="margin-top:20px;">
        	<table width="60%" align="left" cellspacing="3" bgcolor="#FFFFFF">
<tr>
           	<td width="99" height="24" bgcolor="#E6EBF7"><div align="center">学生姓名：</div></td>
            <td width="476" height="24" bgcolor="#E6EBF7"><input type="text" name="stuname" value="<?php echo $sres['sname'];?>" /></td>
              </tr>
              <tr>
           		<td height="24" bgcolor="#E6EBF7"><div align="center">学 号：</div></td>
                <td height="24" bgcolor="#E6EBF7"><input type="text" name="stunum" value="<?php echo $sres['snum'];?>"/></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">性别:</div></td>
              <td height="24" bgcolor="#E6EBF7">
               	<input type="radio" name="sex" value="1" id="sex" <?php if ($sres['sex']==1){echo "checked";}?>/>男
               	<input type="radio" name="sex" value="0" id="sex" <?php if ($sres['sex']==0){echo "checked";}?>/>女					</td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">出生日期:</div></td>
                  <td height="24" bgcolor="#E6EBF7">
                    <input type="text" name="date" id="idShow" value="<?php echo date("Y-m-d",$sres['age']);?>"/>
                 </td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">电话:</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="tel"  value="<?php echo $sres['tel'];?>"/></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">家长电话：</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="htel" value="<?php echo $sres['htel'];?>"/></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">Q  Q:</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="qq" value="<?php echo $sres['qq'];?>"/></td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">电子邮件：</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input type="text" name="email" value="<?php echo $sres['email'];?>"/></td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">入学时间：</div></td>
                  <td height="24" bgcolor="#E6EBF7">
                    <input type="text" name="intime" id="inShow" value="<?php echo date("Y-m-d",$sres['intime']);?>"/>
                 </td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">毕业时间：</div></td>
                  <td height="24" bgcolor="#E6EBF7">
                    <input type="text" name="outtime" id="outShow" value="<?php echo date("Y-m-d",$sres['outtime']);?>"/>
                 </td>
              </tr>
                <tr>
               	  <td height="24" bgcolor="#E6EBF7"><div align="center">家庭住址：</div></td>
                  <td height="24" bgcolor="#E6EBF7"><input name="address" type="text" size="50" value="<?php echo $sres['adress'];?>"/></td>
              </tr>
              <tr>
              	<td height="24" bgcolor="#E6EBF7"><div align="center">学生状态：</div></td>
              	  <td height="24" bgcolor="#E6EBF7">
              	  	<input name="state[]" <?php if($sres['state']==0){echo "checked";}?> type="radio" value="0" />正常
                    <input name="state[]" type="radio" <?php if($sres['state']==1){echo "checked";}?> value="1" />休学
                 </td>
              </tr>
                <tr>
                	<td width="100" nowrap="nowrap" bgcolor="#E6EBF7"><div align="center">所在班级：</div></td>
                  <td bgcolor="#E6EBF7">
<div>
                    	<ul>
                    <?php 
                    	for ($c=0;$c<$cnum;$c++){//循环出班级id和名字
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
               	  <td width="7%" align="left"><input type="submit" value="修改" name="submit" /></td>
				  <td width="93%" align="left"><input type="button" value="取 消" name="cancle" onclick="javascript:history.go(-1);" /></td>
              </tr>
          </table>
      </form>
    </td>
  </tr>
</table>
