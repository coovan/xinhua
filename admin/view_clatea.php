<?php
/*
 * @file 班主任管理页面
 * @author F
 */
include_once '../class/config.php';//导入配置文件

$tea = "SELECT * FROM `userinfo` WHERE `isclass` = 1";
$num=$db->num($tea);//获取分页需要的结果行数
$page=new page($num,"page",14);//实列化分页类
$pagesize=$page->offset();//获取分页用到的数
$tea = "SELECT * FROM `userinfo` WHERE `isclass` = 1 limit $pagesize,14";//查询班主任
$teares=$db->query($tea);
$teanum=$db->num1($teares);



?>

<style>
.cla{
	height:20px;
	padding:5px;
	margin:auto 1px;
	width:auto;
	background-color:#D6E3F1;
	float:left
}

</style>

<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">当前位置：班主任管理 - 查看班主任</td>
  </tr>
  <tr>
  	<td>
    	<table width="100%">
        	<tr>
            	<td width="20%" height="30" align="center" valign="middle" nowrap="nowrap" bgcolor="#3A73AD">班主任</td>
                <td height="30" align="center" valign="middle" nowrap="nowrap" bgcolor="#3A73AD">所带班级</td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table width="100%">
    	<?php 
    		for ($t=0;$t<$teanum;$t++){//循环输出班主任
    			$tearow=$db->fetch($teares);
    			$class = "SELECT * FROM `class` WHERE `userid` = '".$tearow['id']."'";//查询出该班主任下的班级
    			$classres=$db->query($class);
				$classnum=$db->num1($classres);
    			
    	?>
        	<tr bgcolor="#D6E3F1">
            	<td width="20%" height="20" align="center" valign="middle" nowrap="nowrap"><?php echo $tearow["truename"]?></td>
                <td height="20" align="left" valign="middle" bgcolor="#FFFFFF">
                	<ul>
                	<?php 
                		for ($c=0;$c<$classnum;$c++){//输出班级
                			$clarow=$db->fetch($classres);
                	?>
                    	<li class="cla"><a href="renew_class.php?classid=<?php echo $clarow['classid']?>"><?php echo $clarow['classname']?></a></li>
					<?php }?>
                    </ul>
                </td>
          </tr>
          <?php }?>
        </table>
    </td>
  </tr>
  <tr>
  	<td align="right"><?php echo $page->show();?></td>
  </tr>
</table>