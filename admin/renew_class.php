<?php
/*
 * @file 班级管理页面
 * 修改班级
 * @author F
 */
include_once '../class/config.php';//导入配置文件

//从地址栏中取得要修改班级的id
if (!isset($_GET["classid"])){
	ShowMsg("请选择班级后再访问本页！","class_info.php","系统提示！");
	exit();
}
	//查询班级表里的信息
	$get_class="SELECT * FROM `class` WHERE `classid` = '".$_GET["classid"]."' ";
	$result=$db->query($get_class);
	$row_cla=$db->fetch($result);//取得结果
	
	//查询班主任
	$get_cmen="SELECT * FROM `userinfo` WHERE `isclass` = 1";
	$cmen_res=$db->query($get_cmen);
	$cmen_num=$db->num1($cmen_res);
	
	//查询专业
	$get_pro="SELECT * FROM `profession`";
	$pro_res=$db->query($get_pro);
	$pro_num=$db->num1($pro_res);

//如果点击提交	
if (isset($_POST['submit'])){
	
	//给变量赋值
	$userid=$_POST["headclass"][0];
	$pro=$_POST["pro"][0];
	
	//sql语句
	$up_class="UPDATE `class` SET  
	`classname` = '".$_POST['classname']. " ', 
	`proid` = '".$pro. " ', 
	`userid` = '".$userid. " ', 
	`addtime` = '".$_POST['addtime']. " ', 
	`outtime` = '".$_POST['outtime']. " ', 
	`whodo` = '".$_COOKIE['userid']. " '  
	 WHERE `classid` =".$_GET['classid'].";";
	
	//执行sql语句
	$update=$db->query($up_class);
	
	//提示执行信息
	if ($update){
		ShowMsg("修改成功！","class_info.php","系统提示！");
		exit();
	}else {
		ShowMsg("未知错误！","class_info.php","系统提示！");
		exit();
	}
}





?>

<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">当前位置：班级管理 - 修改班级</td>
  </tr>
  <tr>
    <td>
		<div style="width:150px; margin:0 auto;">
		<h1>修改班级</h1>
		</div>
		<hr />
		<br/>
		<form id="renewclass" name="renewclass" method="post" action="">
			<table width="900" cellspacing="2">
				<tr>
		        	<td width="200" bgcolor="#EEEEFF">修改班级名：</td>
		          	<td bgcolor="#EEEEFF"><input type="text" name="classname" value="<?php echo $row_cla['classname']?>"></input></td>
		      </tr>
		      <tr>
		      		<td bgcolor="#EEEEFF">修改开班时间：</td>
		            <td bgcolor="#EEEEFF"><input type="text" name="addtime" value="<?php echo date("Y-m-d",$row_cla['addtime'])?>" /></td>
		      </tr>
		      <tr>
		      		<td bgcolor="#EEEEFF">修改毕业时间</td>
		            <td bgcolor="#EEEEFF"><input type="text" name="outtime" value="<?php echo $row_cla['outtime']?>" /></td>
		      </tr>
		      <tr>
		      		<td valign="middle" bgcolor="#EEEEFF">修改专业：</td>
		            <td bgcolor="#EEEEFF">
		            	<div>
		                	<ul>
		                	<?php 
		                		//把所有专业循环出来供选择，当前专业被选中状态
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
		      		<td valign="middle" bgcolor="#EEEEFF">班主任变更:</td>
		            <td align="left" valign="middle" bgcolor="#EEEEFF">
		            	<div>
		                	<ul>
		                	<?php 
		                		//把所有班主任循环出来供选择，当前班主任被选中状态
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
		                	<input name="cancle" type="button" value="取  消" onclick="javascript:history.go(-1)" />
		                </td>
		                <td width="60" align="right">
		                  	<input type="submit" name="submit" id="button" value="提  交" />
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














