<?php
/*
 * @file �鿴�༶������ҳ��
 * @author F
 */
header("Content-Type: text/html; charset=gbk");
include_once '../class/config.php';//���������ļ�
session_start();

//�Ѱ༶��ѯ����
$classres = "SELECT `classname`,`classid` FROM `class` WHERE `state` =0";//ֻ��ʾ�Ǳ�ҵ�༶���ѱ�ҵ�༶����ʾ
$clres = $db->query($classres);
$clnum = $db->num1($clres);

//�ӵ�ַ����ȡ�ð༶id
if (isset($_GET['class'])){
	$_SESSION['class']=$_GET['class'];
	$class=$_SESSION['class'];
}elseif (empty($_SESSION['class'])){
	$class = $_SESSION['class'];
}else {
	$class = $clnum;
}

//���ַ���ת��Ϊʱ���,����Ҫ�õ�
function totimestamp($time){
	$time = $time." 0:0:0";//����ʱ��Ϊ���
	return strtotime($time);
}

//=============================================================
/*
 * ��������sql����ʹ��
 * @param $starttime ��ʲôʱ�俪ʼ��ѯ
 * @param $endtime ��ѯ��ʲôʱ�����
 */
$now = mktime();//��ǰʱ��
//�ǲ鿴����ǰ�Ļ���һ����ǰ�ģ�Ϊ�˷�ֹ�鿴��������ĵ����ʣ���$endtime��Ϊ��ǰʱ��24Сʱ�Ժ�
if (isset($_GET['date']) && $_GET['date']==7){
	$starttime =$now - 3600*24*7;//����ǰ��ʱ��
	$endtime = $now +3600*24;//����	
}else{
	$starttime =$now - 3600*24*30;//30��ǰ��ʱ��
	$endtime = $now +3600*24;//����	
}

//�û��Զ����ύ��ʱ��
if (isset($_POST['submit'])){
	if(!empty($_POST['starttime'])){//�����Ϊ��
		$starttime = totimestamp($_POST['starttime']);
	}else{//������Ϊ��
		ShowMsg("����ѡ���ʲôʱ��鿴��"," ");
		exit();
	}
	if(!empty($_POST['endtime'])){//�����Ϊ�գ���ֵ
		$endtime = totimestamp($_POST['endtime']);
	}else{//���Ϊ�գ���ֵΪ����
		$endtime = $now +3600*24;//����	
	}
}
//=============================================================







?>


<style>
.date-picker-wp {
display: none;
position: absolute;
background: #f1f1f1;
left: 40px;
top: 40px;
border-top: 4px solid #3879d9;
}
.date-picker-wp table {
border: 1px solid #ddd;
}
.date-picker-wp td {
background: #fafafa;
width: 22px;
height: 18px;
border: 1px solid #ccc;
font-size: 12px;
text-align: center;
}
.date-picker-wp td.noborder {
border: none;
background: none;
}
.date-picker-wp td a {
color: #1c93c4;
text-decoration: none;
}
.strong {font-weight: bold}
.hand {cursor: pointer; color: #3879d9}
</style>

<link href="style/right.css" rel="stylesheet" type="text/css" />
<body style="width:100%">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="38" class="right_bg">��ǰλ�ã����ϲ鿴 - �����ʲ鿴</td>
  </tr>
  <tr>
    <td>
            <table width="100%" align="center" cellspacing="0" style=" float:left">
<tr>
   	  <td><form action="" method="post" style="width:270px; float:left">
        ѡ��༶:
       	<select name="class" id="class" style="width:160px;" onchange='window.location="view_att.php?class="+this.value'>
       	<?php 
       	//ѭ�����༶����ѡ��
       		for ($c=0;$c<$clnum;$c++){
       			$clrow=$db->fetch($clres);
       	?>
        	  <option value="<?php echo $clrow['classid'];?>"<?php if ($clrow['classid']==$class){ echo " selected";}?>><?php echo $clrow['classname']?></option>
        <?php }?>
        </select>
      </form></td>

            	<td width="18" height="20" align="center" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td width="83" height="20" align="center" valign="middle" nowrap="nowrap"><a href="view_att.php?date=7">�������</a></td>
                <td width="96" height="20" align="center" valign="middle" nowrap="nowrap"><a href="view_att.php?date=30">���һ����</a></td>
                <td width="84" height="20" align="center" valign="middle" nowrap="nowrap">ѡ������</td>
                <td width="722" height="20" nowrap="nowrap">
                <form action="" method="post">
           	    ��<input name="starttime" type="text" size="10"  id="date-input" />
                	��
                   <input name="endtime" type="text" size="10" id="demo2"/>
                   <input type="submit" name="submit" id="button" value="ȷ��">
                   </form>
               </td>
          </tr>
      </table>
    </td>
  </tr>
  <tr>
  <?php 
  	/**
  	 * ��ȡ�༶����Ӧ������
  	 */
  $clnamesql = "SELECT * FROM `class` WHERE `classid` = '$class'";
  	$clares = $db->query($clnamesql);
  	$claname = $db->fetch($clares);
  	$stunumsql = "SELECT `state`,`classid` FROM `student` WHERE `classid` = '$class' and `state` = 0";
  	$stunum = $db->num($stunumsql);
  ?>
  <tr>
  	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="color:#34699D"><h3><?php echo $claname['classname']?>�ൽ���� Ӧ��<?php echo $stunum;?>��</h3></td>
  </tr>
  	  <td align="left">
    	<table width="100%" align="left">
			<tr>
              <td width="14%" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">��ѵ</td>
              <td width="14%" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">����</td>
              <td width="14%" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">����</td>
              <td width="14%" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">����ϰ</td>
              <td width="14%" rowspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">����</td>
          	  <td width="14%" rowspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">��ע</td>
          	  <td width="14%" rowspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">���</td>
          </tr>
          <tr>
            	<td width="14%" height="15" align="center" valign="middle" nowrap="nowrap">
                <table width="100%" border="0" cellspacing="1">
                  <tr>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">ʵ��</td>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">������</td>
                  </tr>
                </table>
                </td>
                <td width="14%" align="center" valign="middle" nowrap="nowrap">
                <table width="100%" border="0" cellspacing="1">
                  <tr>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">ʵ��</td>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">������</td>
                  </tr>
                </table></td>
                <td width="14%" align="center" valign="middle" nowrap="nowrap">
                <table width="100%" border="0" cellspacing="1">
                  <tr>
                    
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">ʵ��</td>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">������</td>
                  </tr>
                </table></td>
                <td width="14%" align="center" valign="middle" nowrap="nowrap">
                <table width="100%" border="0" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                  <tr>
                    <td width="50%" align="center" valign="middle" bordercolor="#34699D" bgcolor="#5A92C9">ʵ��</td>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">������</td>
                  </tr>
                </table>
              </td>
            </tr>
        </table>
    </td>
  </tr>
</table>
<table width="100%">
<?php 
	
	$pagesql = "SELECT * FROM `attendance` WHERE `classid` = '$class' AND `day` > '$starttime' AND `day` < '$endtime'";		
	$num=$db->num($pagesql);//��ȡ��ҳ��Ҫ�Ľ������
	$page=new page($num,"page",20);//ʵ�л���ҳ��
	$pagesize=$page->offset();//��ȡsql��� limit��Ҫ����ֵ

	echo $sql = "SELECT * FROM `attendance` WHERE `classid` = '$class' AND `day` > '$starttime' AND `day` < '$endtime' ORDER BY `day` DESC LIMIT '$pagesize', 20";
	$ress = $db->query($sql);
	echo $att_num = $db->num1($ress); 
	for ($att=0;$att<$att_num;$att++){
		


?>
  <tr>
    <td width="14%" height="15" align="center" nowrap="nowrap" bgcolor="#D6E3F1"><table width="100%" border="0" cellspacing="1">
      <tr>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">ʵ��</td>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">������</td>
      </tr>
    </table></td>
    <td width="14%" align="center" nowrap="nowrap" bgcolor="#D6E3F1"><table width="100%" border="0" cellspacing="1">
      <tr>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">ʵ��</td>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">������</td>
      </tr>
    </table></td>
    <td width="14%" align="center" nowrap="nowrap" bgcolor="#D6E3F1"><table width="100%" border="0" cellspacing="1">
      <tr>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">ʵ��</td>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">������</td>
      </tr>
    </table></td>
    <td width="14%" align="center" nowrap="nowrap" bgcolor="#D6E3F1"><table width="100%" border="0" cellspacing="1">
      <tr>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">ʵ��</td>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">������</td>
      </tr>
    </table></td>
       <td width="14%"  align="center" nowrap="nowrap" bgcolor="#D6E3F1">����</td>
    <td width="14%" align="center" nowrap="nowrap" bgcolor="#D6E3F1">��ע</td>
    <td width="14%"  align="center" nowrap="nowrap" bgcolor="#D6E3F1">���</td>
  </tr>
  <?php }?>
</table>
			<table align="right" style="margin-top:20px;">
				<tr>
			    	<td><?php echo $page->show();?></td>
			    </tr>
			</table>

<script type="text/javascript" src="../js/selectdate.js"></script>
</body>