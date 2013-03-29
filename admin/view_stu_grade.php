<?php
/*教师管理平时成绩页面
 * @author F
 */
header("Content-Type: text/html; charset=gbk");
include_once '../class/config.php';//导入配置文件

$user=$_COOKIE['userid'];//取得当前登录的教师的id

//查询出当前教师任教的班级
$ClassSql = "SELECT `classid` FROM `syllabus` WHERE `userid` = '$user' AND `state` = 3 GROUP BY `classid`";// ? AND `state` = 3 表示阶段考核考了才有平时成绩
$ClaRes = $db->query($ClassSql);
$ClaNum = $db->num1($ClaRes);


//是否选择了班级
if (isset($_GET['class'])){
	$class = $_GET['class'];
	$_SESSION['class']=$class;
}elseif (!empty($_SESSION['class'])){
	$class=$_SESSION['class'];
}else{
	$class =0;
}
/////////////////////////////////////////////

//修改单个平时成绩
if(isset($_POST[subone])&& !empty($_POST[sel])){    //如果点击修改和复选框处于选中状态
	$pegradeid = $_POST[sel][0];//取得复选框里的学生id
	
	if (ereg("[0-9]{1,3}",$_POST['grade'])){//判断输入的是否是数字
		if ($_POST['grade'] > 100){
			echo "<script>alert('平时成绩不能大于100分');</script>";
		}else {
			$mark = $_POST['grade'];//取得平时成绩
		}
	}else{
		echo "<script>alert('您输入的不是一个数字');</script>";
	}

	
		$onepe = "UPDATE `pegrade` SET `mark` = $mark  WHERE `pegradeid` =$pegradeid";//更新平时成绩
		$pers = $db->query($onepe);//执行插入
		if ($pers){//是否成功?
			ShowMsg("修改成功","view_stu_grade.php?class=$class");
			exit();
		} 
}

//-----------------------------------------------------------------


//批量修改不会做


?>







<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">当前位置：相关操作 - 平时成绩管理</td>
  </tr>
  <tr>
    <td>
        <form action="" method="post">
            <table>
                <tr>
                    <td>&nbsp;</td>
                    <td>选择班级</td>
                    <td>
                    <select name="class" id="class" style="width:160px;" onchange='window.location="view_stu_grade.php?class="+this.value'>
                    <?php 
                    //这里把班级循环出来供选择
                    	for ($C=0;$C<$ClaNum;$C++){
                    		$CRos = $db->fetch($ClaRes);
                    		$ClaNamSql = "SELECT `classname` FROM `class` WHERE `classid` =$CRos[0]";
                    		$ClaNam = $db->fetch1($ClaNamSql); 
                    ?>
                    		<option value="<?php echo $CRos[0];?>" <?php if ($CRos[0]==$class){echo "selected";}?> ><?php echo $ClaNam[0];?></option>
                         <?php }?>  
                         </select>
                          
                    </td>
                </tr>
            </table>
         </form>   
    </td>
  </tr>
  <tr>
  	<td>
    	<table width="100%">
<tr>
            	<td width="2%" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">选择</td>
            	<td width="18%" height="30" align="center" valign="middle" bgcolor="#34699D">姓名</td>
                <td width="30%" height="30" align="center" valign="middle" bgcolor="#34699D">科目</td>
                <td width="15%" height="30" align="center" valign="middle" bgcolor="#34699D">平时成绩</td>
                <td width="17%" height="30" align="center" valign="middle" bgcolor="#34699D">时间</td>
                <td width="17%" height="30" align="center" valign="middle" bgcolor="#34699D">操作</td>
          </tr>

             
             <?php
             	$pe_num = "SELECT * FROM `pegrade` WHERE `stuid` IN(SELECT `sid` FROM `student` WHERE `classid` =$class)";
             	$pgnum=$db->num($pe_num);//获取分页需要的结果行数
				$page=new page($pgnum,"page",20);//实列化分页类
				$pagesize=$page->offset();//获取分页用到的数
				
				$pe_sql = "SELECT * FROM `pegrade` WHERE `stuid` IN(SELECT `sid` FROM `student` WHERE `classid` =$class) LIMIT $pagesize,20";
				$pe_res = $db->query($pe_sql);
				$pen = $db->num1($pe_res);
				for ($pe=0;$pe<$pen;$pe++){
					$pe_row = $db->fetch($pe_res);
					
					$stu = "SELECT `sname` FROM `student` WHERE `sid` ='".$pe_row['stuid']."'";//查出学生姓名
					$stuname = $db->fetch1($stu);
					
					$booksql ="SELECT `bookname` FROM `book` WHERE `bookid` = '".$pe_row['bookid']."'";//查出科目名称
					$book = $db->fetch1($booksql);
				
             ?>
             <form action="" method="post" id="a<?php echo "f".$pe?>">
             <tr id="<?php echo "pe".$pe+1 ?>" >
             	<td align="center" valign="middle" bgcolor="#C6D9EC" >
             	    <input type="checkbox" name="sel[]" id="<?php echo $pe_row['stuid']//输出学生id?>" value="<?php echo $pe_row['pegradeid']//输出成绩id?>" />				</td>
            	<td onclick="chagecolor(<?php echo "pe".$pe+1 ?>,<?php echo $pe_row['stuid']?>)" width="18%" height="20" align="center" valign="middle" bgcolor="#C6D9EC"><?php echo $stuname[0]?></td>
               <td onclick="chagecolor(<?php echo "pe".$pe+1 ?>,<?php echo $pe_row['stuid']?>)" width="30%" height="20" align="center" valign="middle" bgcolor="#C6D9EC"><?php echo $book[0]?></td>
               <td onclick="chagecolor(<?php echo "pe".$pe+1 ?>,<?php echo $pe_row['stuid']?>)" width="15%" height="20" align="center" valign="middle" bgcolor="#C6D9EC"><input style="border:none;text-align:center;" type="text" value="<?php echo $pe_row['mark']?>" name="grade"  /></td>
               <td onclick="chagecolor(<?php echo "pe".$pe+1 ?>,<?php echo $pe_row['stuid']?>)" width="17%" height="20" align="center" valign="middle" bgcolor="#C6D9EC"><?php echo date("Y-m-d",$pe_row['mark'])?></td>
                <td width="17%" height="20" align="center" valign="middle" bgcolor="#C6D9EC">
                	<input type="submit" value="修 改" name="subone" />                </td>
            </tr>
            </form>
            <?php }?>
            <tr>
            	<td colspan="6">
                	<a href="#" onClick="selectAll();">全部选择</a>
                    <a href="#" onClick="selectInvert();">反选</a>
                     <a href="#" onClick="selectNone();">取消选择</a> 
                  	<input type="button" value="批量修改" name="suball" onclick="suball()" />
                                   
                </td>	
            </tr>
            
        </table>
        <table align="right">
   	  <tr>
            	<td align="right">
                	<?php echo $page->show();?>                </td>
            </tr>
        </table>
    </td>
  </tr>


</table>

<script>
<!--
function chagecolor(trid,selid){
var obj=document.getElementById(trid);
var obj2=document.getElementById(selid);

obj2.checked=!obj2.checked;
if(obj.style.backgroundColor=="red")
obj.style.backgroundColor="FFFFFF";
else
obj.style.backgroundColor="red";
}



//修改全部 
function suball(){
	var sed = document.getElementsByName("sel[]");
	for(var i=0;i<sed.length;i++){
		document.getElementById("af"+i).submit();
	}  
	
}

            //表单验证 
            function check(){               
                var ids = document.getElementsByName("sel[]");               
                var flag = false ;               
                for(var i=0;i<ids.length;i++){ 
                    if(ids[i].checked){ 
                        flag = true ; 
                        break ; 
                    } 
                } 
                if(!flag){ 
                    alert("请最少选择一项！"); 
                    return false ; 
                } 
            } 
            //全选 
            function iselect(){ //其中函数字不能为select 其为JS保留字 
                var ids = document.getElementsByName("sel[]"); 
                var all = document.getElementByIdx_x_x("all");               
                for(var i=0;i<ids.length;i++){ 
                    ids[i].checked=all.checked; 
                } 
            } 
            //全选 
            function selectAll(){ 
                var ids = document.getElementsByName("sel[]");                           
                for(var i=0;i<ids.length;i++){ 
                    ids[i].checked=true; 
                } 
            } 
            //全不 
            function selectNone(){ 
                var ids = document.getElementsByName("sel[]");                           
                for(var i=0;i<ids.length;i++){ 
                    ids[i].checked=false; 
                } 
            } 
            //反选 
            function selectInvert(){ 
                var ids = document.getElementsByName("sel[]");                           
                for(var i=0;i<ids.length;i++){ 
                    if(ids[i].checked) 
                        ids[i].checked=false ; 
                    else 
                        ids[i].checked=true ; 
                } 
            } 


//-->
</script>