<?php
/*
 * @file
 * 班级管理页面
 * 添加班级
 * @author F
 */
include_once '../class/config.php';//导入配置文件
$sql="SELECT * FROM `profession`";//查询专业
$result_pro=$db->query($sql);//取得专业的结果
$num=$db->num1($result_pro);//取得专业表里的行数
$sql2="SELECT * FROM `userinfo` WHERE `isclass` = 1";//查询出班主任
$result_isc=$db->query($sql2);
$num2=$db->num1($result_isc);//得到的行数

function add_class($classname,$proid,$userid,$addtime,$whodo,$db){//导入数据库
	$sql_add="INSERT INTO `class` (`classid` ,`classname` ,`proid` ,`userid` ,`addtime` ,`outtime` ,`state` ,`whodo` ) VALUES (NULL , '".$classname."', '".$proid."', '".$userid."', '".$addtime."', '', '0', '".$whodo."')";
	$db->query($sql_add);//将数据导入数据库中
	if ($db){//如果成功
		ShowMsg("添加成功！","add_class.php","系统提示！");//提示成功
		exit();
	}
}
if (isset($_POST["submit"]) && $_POST["submit"]!=""){		//点击提交
	if (empty($_POST["classname"])){						//班级名称不能为空
		echo "<script>alert(\"请填写班级名称！\")</script>";
	}elseif (empty($_POST["headclass"])){				//班主任不能为空
		echo "<script>alert(\"请选择班主任！\")</script>";
	}elseif (empty($_POST["addtime"])){
		$addtime=time();								//默认开班时间为当天
		add_class($_POST["classname"],$_POST["profession"], $_POST["headclass"], $addtime, $_COOKIE["userid"],$db);
	}else {//如果以上条件都成立
		$addtime=strtotime($_POST["addtime"]);
		add_class($_POST["classname"],$_POST["profession"], $_POST["headclass"], $addtime, $_COOKIE["userid"],$db);
	}
}






?>

<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">当前位置：班级管理 - 班级开班</td>
  </tr>
  <tr>
    <td>
		<br />
		<hr />
		<br/>
		<form action="" method="post" name="add_class">
		<table width="100%">
			<tr>
		    	<td width="95" align="left" nowrap="nowrap">班级名称：</td>
	    	  <td width="154" align="left" nowrap="nowrap"><input name="classname" type="text" size="18" /></td>
	          <td width="82" align="left" nowrap="nowrap">开班时间:</td>
	    	  <td width="145" align="left" nowrap="nowrap"><input name="addtime" type="text" size="12" /></td>
              <td width="6" align="left" nowrap="nowrap">&nbsp;</td>
              <td width="101" align="left" nowrap="nowrap">选择班主任:</td>
	          <td width="108" align="left" nowrap="nowrap">
                  <select name="headclass">
                    <?php //循环出班主任
                        for ($a=0;$a<$num2;$a++){
                            $row_isc=$db->fetch($result_isc);
                    
                    ?>
                    <option value="<?php echo $row_isc["id"]?>"><?php echo $row_isc["truename"]?></option>
                  <?php }?>
              	</select>
              </td>
	          <td width="8" align="left" nowrap="nowrap"></td>
	          <td width="83" align="left" nowrap="nowrap">选择专业:</td>
		        <td width="346" align="left" nowrap="nowrap">
	        	  <select name="profession">
		        		<?php
		        		/*
		        	     *循环输出专业
		        		 */
		        			for ($i=0;$i<$num;$i++){
		        				$row_pro=$db->fetch($result_pro);
		        		?>
		          		<option value="<?php echo $row_pro["proid"]?>"><?php echo $row_pro["proname"]?></option>
		          		<?php } //循环结束?>
		      		</select>
		        </td>
		    </tr>
		</table>
		<p>&nbsp;</p>
		<br/>
		<table width="100%">
		  <tr>
		    	<td><input type="submit" value="添  加" name="submit" /></td>
		        <td></td>
		        <td width="80"><input name="cancle" type="button" value="取  消" onclick="javascript:history.go(-1)" /></td>
			</tr>
		</table>

</form>
	</td>
  </tr>
</table>
