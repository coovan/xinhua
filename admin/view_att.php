<?php
/*
 * @file 查看班级到课率页面
 * @author F
 */
header("Content-Type: text/html; charset=gbk");
include_once '../class/config.php';//导入配置文件
session_start();

//把班级查询出来
$classres = "SELECT `classname`,`classid` FROM `class` WHERE `state` =0";//只显示非毕业班级，已毕业班级不显示
$clres = $db->query($classres);
$clnum = $db->num1($clres);

//从地址栏里取得班级id
if (isset($_GET['class'])){
	$_SESSION['class']=$_GET['class'];
	$class=$_SESSION['class'];
}elseif (empty($_SESSION['class'])){
	$class = $_SESSION['class'];
}else {
	$class = $clnum;
}

//把字符串转化为时间戳,下面要用到
function totimestamp($time){
	$time = $time." 0:0:0";//设置时间为零点
	return strtotime($time);
}

//=============================================================
/*
 * 下面用于sql语句的使用
 * @param $starttime 从什么时间开始查询
 * @param $endtime 查询到什么时间结束
 */
$now = mktime();//当前时间
//是查看七天前的还是一个月前的，为了防止查看不到当天的到课率，把$endtime设为当前时间24小时以后
if (isset($_GET['date']) && $_GET['date']==7){
	$starttime =$now - 3600*24*7;//七天前的时间
	$endtime = $now +3600*24;//今天	
}else{
	$starttime =$now - 3600*24*30;//30天前的时间
	$endtime = $now +3600*24;//今天	
}

//用户自定义提交的时间
if (isset($_POST['submit'])){
	if(!empty($_POST['starttime'])){//如果不为空
		$starttime = totimestamp($_POST['starttime']);
	}else{//不允许为空
		ShowMsg("请先选择从什么时候查看！"," ");
		exit();
	}
	if(!empty($_POST['endtime'])){//如果不为空，赋值
		$endtime = totimestamp($_POST['endtime']);
	}else{//如果为空，赋值为今天
		$endtime = $now +3600*24;//今天	
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
    <td height="38" class="right_bg">当前位置：资料查看 - 到课率查看</td>
  </tr>
  <tr>
    <td>
            <table width="100%" align="center" cellspacing="0" style=" float:left">
<tr>
   	  <td><form action="" method="post" style="width:270px; float:left">
        选择班级:
       	<select name="class" id="class" style="width:160px;" onchange='window.location="view_att.php?class="+this.value'>
       	<?php 
       	//循环出班级，供选择
       		for ($c=0;$c<$clnum;$c++){
       			$clrow=$db->fetch($clres);
       	?>
        	  <option value="<?php echo $clrow['classid'];?>"<?php if ($clrow['classid']==$class){ echo " selected";}?>><?php echo $clrow['classname']?></option>
        <?php }?>
        </select>
      </form></td>

            	<td width="18" height="20" align="center" valign="middle" nowrap="nowrap">&nbsp;</td>
                <td width="83" height="20" align="center" valign="middle" nowrap="nowrap"><a href="view_att.php?date=7">最近七天</a></td>
                <td width="96" height="20" align="center" valign="middle" nowrap="nowrap"><a href="view_att.php?date=30">最近一个月</a></td>
                <td width="84" height="20" align="center" valign="middle" nowrap="nowrap">选择日期</td>
                <td width="722" height="20" nowrap="nowrap">
                <form action="" method="post">
           	    从<input name="starttime" type="text" size="10"  id="date-input" />
                	到
                   <input name="endtime" type="text" size="10" id="demo2"/>
                   <input type="submit" name="submit" id="button" value="确定">
                   </form>
               </td>
          </tr>
      </table>
    </td>
  </tr>
  <tr>
  <?php 
  	/**
  	 * 获取班级名和应到人数
  	 */
  $clnamesql = "SELECT * FROM `class` WHERE `classid` = '$class'";
  	$clares = $db->query($clnamesql);
  	$claname = $db->fetch($clares);
  	$stunumsql = "SELECT `state`,`classid` FROM `student` WHERE `classid` = '$class' and `state` = 0";
  	$stunum = $db->num($stunumsql);
  ?>
  <tr>
  	<td height="30" align="center" valign="middle" bgcolor="#FFFFFF" style="color:#34699D"><h3><?php echo $claname['classname']?>班到课率 应到<?php echo $stunum;?>人</h3></td>
  </tr>
  	  <td align="left">
    	<table width="100%" align="left">
			<tr>
              <td width="14%" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">晨训</td>
              <td width="14%" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">上午</td>
              <td width="14%" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">下午</td>
              <td width="14%" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">晚自习</td>
              <td width="14%" rowspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">日期</td>
          	  <td width="14%" rowspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">备注</td>
          	  <td width="14%" rowspan="2" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">审查</td>
          </tr>
          <tr>
            	<td width="14%" height="15" align="center" valign="middle" nowrap="nowrap">
                <table width="100%" border="0" cellspacing="1">
                  <tr>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">实到</td>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">到课率</td>
                  </tr>
                </table>
                </td>
                <td width="14%" align="center" valign="middle" nowrap="nowrap">
                <table width="100%" border="0" cellspacing="1">
                  <tr>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">实到</td>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">到课率</td>
                  </tr>
                </table></td>
                <td width="14%" align="center" valign="middle" nowrap="nowrap">
                <table width="100%" border="0" cellspacing="1">
                  <tr>
                    
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">实到</td>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">到课率</td>
                  </tr>
                </table></td>
                <td width="14%" align="center" valign="middle" nowrap="nowrap">
                <table width="100%" border="0" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
                  <tr>
                    <td width="50%" align="center" valign="middle" bordercolor="#34699D" bgcolor="#5A92C9">实到</td>
                    <td width="50%" align="center" valign="middle" bgcolor="#5A92C9">到课率</td>
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
	$num=$db->num($pagesql);//获取分页需要的结果行数
	$page=new page($num,"page",20);//实列化分页类
	$pagesize=$page->offset();//获取sql语句 limit需要的数值

	echo $sql = "SELECT * FROM `attendance` WHERE `classid` = '$class' AND `day` > '$starttime' AND `day` < '$endtime' ORDER BY `day` DESC LIMIT '$pagesize', 20";
	$ress = $db->query($sql);
	echo $att_num = $db->num1($ress); 
	for ($att=0;$att<$att_num;$att++){
		


?>
  <tr>
    <td width="14%" height="15" align="center" nowrap="nowrap" bgcolor="#D6E3F1"><table width="100%" border="0" cellspacing="1">
      <tr>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">实到</td>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">到课率</td>
      </tr>
    </table></td>
    <td width="14%" align="center" nowrap="nowrap" bgcolor="#D6E3F1"><table width="100%" border="0" cellspacing="1">
      <tr>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">实到</td>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">到课率</td>
      </tr>
    </table></td>
    <td width="14%" align="center" nowrap="nowrap" bgcolor="#D6E3F1"><table width="100%" border="0" cellspacing="1">
      <tr>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">实到</td>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">到课率</td>
      </tr>
    </table></td>
    <td width="14%" align="center" nowrap="nowrap" bgcolor="#D6E3F1"><table width="100%" border="0" cellspacing="1">
      <tr>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">实到</td>
        <td width="50%" align="center" valign="middle" bgcolor="#D6E3F1">到课率</td>
      </tr>
    </table></td>
       <td width="14%"  align="center" nowrap="nowrap" bgcolor="#D6E3F1">日期</td>
    <td width="14%" align="center" nowrap="nowrap" bgcolor="#D6E3F1">备注</td>
    <td width="14%"  align="center" nowrap="nowrap" bgcolor="#D6E3F1">审查</td>
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