<?php
/*
 * @file �����ι���ҳ��
 * @author F
 */
include_once '../class/config.php';//���������ļ�

$tea = "SELECT * FROM `userinfo` WHERE `isclass` = 1";
$num=$db->num($tea);//��ȡ��ҳ��Ҫ�Ľ������
$page=new page($num,"page",14);//ʵ�л���ҳ��
$pagesize=$page->offset();//��ȡ��ҳ�õ�����
$tea = "SELECT * FROM `userinfo` WHERE `isclass` = 1 limit $pagesize,14";//��ѯ������
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
    <td height="38" class="right_bg">��ǰλ�ã������ι��� - �鿴������</td>
  </tr>
  <tr>
  	<td>
    	<table width="100%">
        	<tr>
            	<td width="20%" height="30" align="center" valign="middle" nowrap="nowrap" bgcolor="#3A73AD">������</td>
                <td height="30" align="center" valign="middle" nowrap="nowrap" bgcolor="#3A73AD">�����༶</td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table width="100%">
    	<?php 
    		for ($t=0;$t<$teanum;$t++){//ѭ�����������
    			$tearow=$db->fetch($teares);
    			$class = "SELECT * FROM `class` WHERE `userid` = '".$tearow['id']."'";//��ѯ���ð������µİ༶
    			$classres=$db->query($class);
				$classnum=$db->num1($classres);
    			
    	?>
        	<tr bgcolor="#D6E3F1">
            	<td width="20%" height="20" align="center" valign="middle" nowrap="nowrap"><?php echo $tearow["truename"]?></td>
                <td height="20" align="left" valign="middle" bgcolor="#FFFFFF">
                	<ul>
                	<?php 
                		for ($c=0;$c<$classnum;$c++){//����༶
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