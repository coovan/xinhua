<?php
/*
 * @file �鿴��ѧ����ҳ��
 * @author F
 * 
 */
//���������ļ�
require_once '../class/config.php';

if(isset($_GET['state'])){//ͨ��GET ��ʽ�鿴ʲô״̬�Ŀγ�
	$state=$_GET['state'];
}else {
	$state = 0;//Ĭ��Ϊ�����еĿγ�
}

	$sy_num = "SELECT * FROM `syllabus` WHERE `state` = $state AND `userid` = ".$_COOKIE['userid']."";
	$num=$db->num($sy_num);//��ȡ��ҳ��Ҫ�Ľ������
	$page=new page($num,"page",20);//ʵ�л���ҳ��
	$pagesize=$page->offset();
	$sy = "SELECT * FROM `syllabus` WHERE `state` = $state AND `userid` = ".$_COOKIE['userid']." ORDER BY `addtime` DESC LIMIT $pagesize,20";
	$res = $db->query($sy);//ִ�в�ѯ

	
	
	//�ύ��β���
	
	if (isset($_GET[put]) and $_GET['put']==true){
		$putin = "UPDATE `syllabus` SET `state` = '1' WHERE `syid` = ".$_GET['syid']." " ;
		$putres = $db->query($putin);
		if ($putres){
			ShowMsg('�ύ�ɹ�����Ҫ������˺�ſ��Խ�Σ�',"mytask.php");
			exit();
		}
	}
	
?>


<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">��ǰλ�ã���ز��� - �ҵĽ�ѧ����</td>
  </tr>
  <tr>
    <td>
    	<table width="100%">
        	<tr>
            	<td width="3%">&nbsp;</td>
                <td width="10%" align="center" valign="middle" nowrap="nowrap"><a href="mytask.php?state=0">�����пγ�</a></td>
                <td width="10%" align="center" valign="middle" nowrap="nowrap"><a href="mytask.php?state=1">����пγ�</a></td>
                <td width="10%" align="center" valign="middle" nowrap="nowrap"><a href="mytask.php?state=2">����˿γ�</a></td>
                <td width="10%" align="center" valign="middle" nowrap="nowrap"><a href="mytask.php?state=3">�׶��Կ����ѿ��γ�</a></td>
                <td>&nbsp;</td>
            </tr>
        </table>
  
    </td>
  </tr>
  <tr>
  	<td>
    	<table width="100%">
        	<tr align="center" valign="middle">
            	<td width="16%" height="30" bgcolor="#376DA4">�༶</td>
                <td width="24%" height="30" bgcolor="#376DA4">�γ�</td>
                <td width="9%" height="30" bgcolor="#376DA4">����ʱ��</td>
                <td width="30%" height="30" bgcolor="#376DA4">����</td>
                <td width="7%" height="30" bgcolor="#376DA4"><?php if ($state==2){echo "�����";}else{echo "������";}?></td>
                <td width="14%" height="30" bgcolor="#376DA4"><?php if($state==0){echo "����";}else{echo "״̬";}?></td>
            </tr>
            <?php 
            	for ($s=0;$s<$num;$s++){
            		$syrow = $db->fetch($res);//����`syllabus`��Ľ��
            		
            		$class = "SELECT `classname` FROM `class` WHERE `classid` = ".$syrow['classid']." ";//�Ѷ�Ӧ�İ༶���ҳ���
            		$cla = $db->fetch1($class);//�õ��༶�Ľ��
            		
            		$booksql = "SELECT `bookname` FROM `book` WHERE `bookid` = ".$syrow['bookid']."";//�Ѷ�Ӧ�Ŀγ̲����
            		$book  = $db->fetch1($booksql);
            		
            		if ($state==2){//���ͨ������ʾ��˲�������
            			$man = $syrow['whodo2'];
            		}else {
            			$man = $syrow['whodo'];
            		}
            		$wdsql = "SELECT `truename` FROM `userinfo` WHERE `id` = '".$man."'";//�ѿ�����/����˲��
            		$wd = $db->fetch1($wdsql);
            		
            		
            	
            ?>
          <tr align="center" valign="middle" bgcolor="#CFDFEF">
            	<td width="16%" height="20"><?php echo $cla['0']?></td>
                <td width="24%" height="20"><?php echo $book['0']?></td>
                <td width="9%" height="20"><?php echo date("Y-m-d",$syrow['addtime'])?></td>
                <td width="30%" height="20"><?php echo $syrow['content']?></td>
                <td width="7%" height="20"><?php echo $wd['0']?></td>
                <td width="14%" height="20"><?php if ($state==0){echo '<a href="mytask.php?put=true&syid='.$syrow["syid"].' ">�ύ���</a>';}elseif ($syrow['state']==1){echo "�������";}elseif ($syrow['state']==2){echo "���ͨ��";}else {echo "�ѿ���";} ?></td>
          </tr>
          <?php }?>

        </table>
    </td>
  </tr>
  <tr>
  	<td align="right"><?php echo $page->show();?></td>
  </tr>
</table>