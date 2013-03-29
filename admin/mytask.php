<?php
/*
 * @file 查看教学任务页面
 * @author F
 * 
 */
//引入配置文件
require_once '../class/config.php';

if(isset($_GET['state'])){//通过GET 方式查看什么状态的课程
	$state=$_GET['state'];
}else {
	$state = 0;//默认为进行中的课程
}

	$sy_num = "SELECT * FROM `syllabus` WHERE `state` = $state AND `userid` = ".$_COOKIE['userid']."";
	$num=$db->num($sy_num);//获取分页需要的结果行数
	$page=new page($num,"page",20);//实列化分页类
	$pagesize=$page->offset();
	$sy = "SELECT * FROM `syllabus` WHERE `state` = $state AND `userid` = ".$_COOKIE['userid']." ORDER BY `addtime` DESC LIMIT $pagesize,20";
	$res = $db->query($sy);//执行查询

	
	
	//提交结课操作
	
	if (isset($_GET[put]) and $_GET['put']==true){
		$putin = "UPDATE `syllabus` SET `state` = '1' WHERE `syid` = ".$_GET['syid']." " ;
		$putres = $db->query($putin);
		if ($putres){
			ShowMsg('提交成功，需要教务处审核后才可以结课！',"mytask.php");
			exit();
		}
	}
	
?>


<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">当前位置：相关操作 - 我的教学任务</td>
  </tr>
  <tr>
    <td>
    	<table width="100%">
        	<tr>
            	<td width="3%">&nbsp;</td>
                <td width="10%" align="center" valign="middle" nowrap="nowrap"><a href="mytask.php?state=0">进行中课程</a></td>
                <td width="10%" align="center" valign="middle" nowrap="nowrap"><a href="mytask.php?state=1">审核中课程</a></td>
                <td width="10%" align="center" valign="middle" nowrap="nowrap"><a href="mytask.php?state=2">已审核课程</a></td>
                <td width="10%" align="center" valign="middle" nowrap="nowrap"><a href="mytask.php?state=3">阶段性考试已考课程</a></td>
                <td>&nbsp;</td>
            </tr>
        </table>
  
    </td>
  </tr>
  <tr>
  	<td>
    	<table width="100%">
        	<tr align="center" valign="middle">
            	<td width="16%" height="30" bgcolor="#376DA4">班级</td>
                <td width="24%" height="30" bgcolor="#376DA4">课程</td>
                <td width="9%" height="30" bgcolor="#376DA4">开课时间</td>
                <td width="30%" height="30" bgcolor="#376DA4">描述</td>
                <td width="7%" height="30" bgcolor="#376DA4"><?php if ($state==2){echo "审核人";}else{echo "开课人";}?></td>
                <td width="14%" height="30" bgcolor="#376DA4"><?php if($state==0){echo "操作";}else{echo "状态";}?></td>
            </tr>
            <?php 
            	for ($s=0;$s<$num;$s++){
            		$syrow = $db->fetch($res);//这是`syllabus`表的结果
            		
            		$class = "SELECT `classname` FROM `class` WHERE `classid` = ".$syrow['classid']." ";//把对应的班级查找出来
            		$cla = $db->fetch1($class);//得到班级的结果
            		
            		$booksql = "SELECT `bookname` FROM `book` WHERE `bookid` = ".$syrow['bookid']."";//把对应的课程查出来
            		$book  = $db->fetch1($booksql);
            		
            		if ($state==2){//审核通过的显示审核操作的人
            			$man = $syrow['whodo2'];
            		}else {
            			$man = $syrow['whodo'];
            		}
            		$wdsql = "SELECT `truename` FROM `userinfo` WHERE `id` = '".$man."'";//把开课人/审核人查出
            		$wd = $db->fetch1($wdsql);
            		
            		
            	
            ?>
          <tr align="center" valign="middle" bgcolor="#CFDFEF">
            	<td width="16%" height="20"><?php echo $cla['0']?></td>
                <td width="24%" height="20"><?php echo $book['0']?></td>
                <td width="9%" height="20"><?php echo date("Y-m-d",$syrow['addtime'])?></td>
                <td width="30%" height="20"><?php echo $syrow['content']?></td>
                <td width="7%" height="20"><?php echo $wd['0']?></td>
                <td width="14%" height="20"><?php if ($state==0){echo '<a href="mytask.php?put=true&syid='.$syrow["syid"].' ">提交结课</a>';}elseif ($syrow['state']==1){echo "正在审核";}elseif ($syrow['state']==2){echo "审核通过";}else {echo "已考试";} ?></td>
          </tr>
          <?php }?>

        </table>
    </td>
  </tr>
  <tr>
  	<td align="right"><?php echo $page->show();?></td>
  </tr>
</table>