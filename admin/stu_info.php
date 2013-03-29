<?php
/*
 * @file 管理学生页面
 * @author F
 * 
 */
//引入配置文件
require_once '../class/config.php';

//是管理在校学生还是毕业学生，通过$_GET['class']来确定
if (isset($_GET['class'])){
	$class = "SELECT * FROM `class` WHERE `state` = '".$_GET['class']."' order by `addtime` desc";
}else {
	//默认显示在校班级学生
	$class = "SELECT * FROM `class` WHERE `state` = '0' order by `addtime` desc";
}
//查询出班级,供选择
$clnum = $db->num($class);
$cla = $db->query($class);

/**
*确定是否选择了某个班级
*也就是把选择的班级ID找出来，为显示做准备
*如果不选择，则通过地址栏获取
*默认显示，最新开班的班级
*/
if (isset($_POST['submit'])){
	$classid=$_POST['class'];
}elseif (isset($_GET['classid'])){
	$classid=$_GET['classid'];
}else{
	$c_id=$db->fetch1($class);
	$classid=$c_id["classid"];
}

//查询出结果行数，用于分页
$stupage = "SELECT * FROM `student` WHERE `classid` = '".$classid."'  AND `state`<>2";
$stu_num = $db->num($stupage);
$page=new page($stu_num,"page",14);//实列化分页类
$pagesize=$page->offset();//得到分页需要的数字
//把班级Id写入url的GET 中，免得点击下一页时不起作用,这里好晕~~
$page->_set_url('?classid='.$classid);

//分页显示出来
$stu = "SELECT * FROM `student` WHERE `classid` = '".$classid."' AND `state`<>2 limit $pagesize,14 ";
$stu_res=$db->query($stu);
$num=$db->num($stu);

/*
 * 删除学生
 */
if (isset($_GET['del_stu'])){
	$del_stu = "UPDATE `student` SET `state` = '2' WHERE `sid` ='".$_GET['del_stu']."'";
	$del=$db->query($del_stu);
	if ($del){
		ShowMsg("删除成功！","stu_info.php?classid=".$classid);
		exit();
	}
}



?>
<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">当前位置：学生管理 - 查看学生信息</td>
  </tr>
  <tr>
  	<td height="20">&nbsp;</td>
  </tr>
  <tr>
    <td>
    <form action="" method="post">
    	<table width="100%">
        	<tr>
            	<td></td>
            	<td><a href="stu_info.php?class=0">管理在校学生</a></td>
                <td>&nbsp;&nbsp;<a href="stu_info.php?class=1">管理毕业学生</a></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
            </tr>
        	<tr>
            	<td width="21">&nbsp;</td>
            	<td width="99" nowrap="nowrap">选择班级：</td>
				<td width="158">
                	<select name="class" style="width:150px;">
                	<?php 
                		for ($i=0;$i<$clnum;$i++){
                			$res = $db->fetch($cla);         			
                	?>
                	  <option <?php if($res['classid']==$_SESSION['classid']){echo "checked";}?> value="<?php echo $res['classid'];?>"><?php echo $res['classname'];?></option>
                	  <?php }?>
                	</select>
                </td>
                <td width="735"><input type="submit" value="选择" name="submit" /></td>
            </tr>
      </table>
      <table width="100%" cellspacing="2" style="margin-top:20px;">
      	<tr style=" color:#FFF;">
        	<td width="17%" height="30" align="center" valign="middle" bgcolor="#376DA4">姓  名</td>
            <td width="26%" height="30" align="center" valign="middle" bgcolor="#376DA4">班  级</td>
            <td width="5%" height="30" align="center" valign="middle" bgcolor="#376DA4">性  别</td>
            <td width="14%" height="30" align="center" valign="middle" bgcolor="#376DA4">电  话</td>
            <td width="5%" height="30" align="center" valign="middle" bgcolor="#376DA4">状  态</td>
            <td width="30%" height="30" align="center" valign="middle" bgcolor="#376DA4">操  作</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <?php 
        	for ($s=0;$s<$num;$s++){
        		$stu_row=$db->fetch($stu_res);
        		$stu_class= "SELECT * FROM `class` WHERE `classid` = '".$stu_row['classid']."'";
        		$sc=$db->fetch1($stu_class);
        ?>
        <tr>
        	<td height="24" align="center" valign="middle" bgcolor="#DCE8F3"><?php echo $stu_row['sname']?></td>
            <td height="24" align="center" valign="middle" bgcolor="#DCE8F3"><?php echo $sc['classname'];?></td>
            <td height="24" align="center" valign="middle" bgcolor="#DCE8F3"><?php if($stu_row['sex']==1){ echo "男";}else{echo "女";}?></td>
            <td height="24" align="center" valign="middle" bgcolor="#DCE8F3"><?php echo $stu_row['tel']?></td>
            <td height="24" align="center" valign="middle" bgcolor="#DCE8F3"><?php if ($stu_row['state']==0){echo "<font color='#00ff00'>正常</font>";}elseif($stu_row['state']==0) {echo "<font color='red'>休学</font>";}?></td>
            <td height="24" align="center" valign="middle" bgcolor="#DCE8F3">
              <table width="100%" border="0">
                <tr>
                  <td align="center" valign="middle" nowrap="nowrap"><a href='look_stu.php?look=<?php echo $stu_row['sid'];?>'>查看</a></td>
                  <td align="center" valign="middle" nowrap="nowrap"><a href="renew_stu.php?stuid=<?php echo $stu_row['sid'];?>">修改</a></td>
                  <td align="center" valign="middle" nowrap="nowrap"><a href="stu_info.php?del_stu=<?php echo $stu_row['sid'];?>">删除</a></td>
                </tr>
            </table></td>
        </tr>
        <?php }?>
      </table>
      <table align="right">
      	<tr>
        	<td><?php echo $page->show();?></td>
        </tr>
      </table>
      </form>
    </td>
  </tr>
</table>