<?php
/*��ʦ����ƽʱ�ɼ�ҳ��
 * @author F
 */
header("Content-Type: text/html; charset=gbk");
include_once '../class/config.php';//���������ļ�

$user=$_COOKIE['userid'];//ȡ�õ�ǰ��¼�Ľ�ʦ��id

//��ѯ����ǰ��ʦ�ν̵İ༶
$ClassSql = "SELECT `classid` FROM `syllabus` WHERE `userid` = '$user' AND `state` = 3 GROUP BY `classid`";// ? AND `state` = 3 ��ʾ�׶ο��˿��˲���ƽʱ�ɼ�
$ClaRes = $db->query($ClassSql);
$ClaNum = $db->num1($ClaRes);


//�Ƿ�ѡ���˰༶
if (isset($_GET['class'])){
	$class = $_GET['class'];
	$_SESSION['class']=$class;
}elseif (!empty($_SESSION['class'])){
	$class=$_SESSION['class'];
}else{
	$class =0;
}
/////////////////////////////////////////////

//�޸ĵ���ƽʱ�ɼ�
if(isset($_POST[subone])&& !empty($_POST[sel])){    //�������޸ĺ͸�ѡ����ѡ��״̬
	$pegradeid = $_POST[sel][0];//ȡ�ø�ѡ�����ѧ��id
	
	if (ereg("[0-9]{1,3}",$_POST['grade'])){//�ж�������Ƿ�������
		if ($_POST['grade'] > 100){
			echo "<script>alert('ƽʱ�ɼ����ܴ���100��');</script>";
		}else {
			$mark = $_POST['grade'];//ȡ��ƽʱ�ɼ�
		}
	}else{
		echo "<script>alert('������Ĳ���һ������');</script>";
	}

	
		$onepe = "UPDATE `pegrade` SET `mark` = $mark  WHERE `pegradeid` =$pegradeid";//����ƽʱ�ɼ�
		$pers = $db->query($onepe);//ִ�в���
		if ($pers){//�Ƿ�ɹ�?
			ShowMsg("�޸ĳɹ�","view_stu_grade.php?class=$class");
			exit();
		} 
}

//-----------------------------------------------------------------


//�����޸Ĳ�����


?>







<link href="style/right.css" rel="stylesheet" type="text/css" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="38" class="right_bg">��ǰλ�ã���ز��� - ƽʱ�ɼ�����</td>
  </tr>
  <tr>
    <td>
        <form action="" method="post">
            <table>
                <tr>
                    <td>&nbsp;</td>
                    <td>ѡ��༶</td>
                    <td>
                    <select name="class" id="class" style="width:160px;" onchange='window.location="view_stu_grade.php?class="+this.value'>
                    <?php 
                    //����Ѱ༶ѭ��������ѡ��
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
            	<td width="2%" align="center" valign="middle" nowrap="nowrap" bgcolor="#34699D">ѡ��</td>
            	<td width="18%" height="30" align="center" valign="middle" bgcolor="#34699D">����</td>
                <td width="30%" height="30" align="center" valign="middle" bgcolor="#34699D">��Ŀ</td>
                <td width="15%" height="30" align="center" valign="middle" bgcolor="#34699D">ƽʱ�ɼ�</td>
                <td width="17%" height="30" align="center" valign="middle" bgcolor="#34699D">ʱ��</td>
                <td width="17%" height="30" align="center" valign="middle" bgcolor="#34699D">����</td>
          </tr>

             
             <?php
             	$pe_num = "SELECT * FROM `pegrade` WHERE `stuid` IN(SELECT `sid` FROM `student` WHERE `classid` =$class)";
             	$pgnum=$db->num($pe_num);//��ȡ��ҳ��Ҫ�Ľ������
				$page=new page($pgnum,"page",20);//ʵ�л���ҳ��
				$pagesize=$page->offset();//��ȡ��ҳ�õ�����
				
				$pe_sql = "SELECT * FROM `pegrade` WHERE `stuid` IN(SELECT `sid` FROM `student` WHERE `classid` =$class) LIMIT $pagesize,20";
				$pe_res = $db->query($pe_sql);
				$pen = $db->num1($pe_res);
				for ($pe=0;$pe<$pen;$pe++){
					$pe_row = $db->fetch($pe_res);
					
					$stu = "SELECT `sname` FROM `student` WHERE `sid` ='".$pe_row['stuid']."'";//���ѧ������
					$stuname = $db->fetch1($stu);
					
					$booksql ="SELECT `bookname` FROM `book` WHERE `bookid` = '".$pe_row['bookid']."'";//�����Ŀ����
					$book = $db->fetch1($booksql);
				
             ?>
             <form action="" method="post" id="a<?php echo "f".$pe?>">
             <tr id="<?php echo "pe".$pe+1 ?>" >
             	<td align="center" valign="middle" bgcolor="#C6D9EC" >
             	    <input type="checkbox" name="sel[]" id="<?php echo $pe_row['stuid']//���ѧ��id?>" value="<?php echo $pe_row['pegradeid']//����ɼ�id?>" />				</td>
            	<td onclick="chagecolor(<?php echo "pe".$pe+1 ?>,<?php echo $pe_row['stuid']?>)" width="18%" height="20" align="center" valign="middle" bgcolor="#C6D9EC"><?php echo $stuname[0]?></td>
               <td onclick="chagecolor(<?php echo "pe".$pe+1 ?>,<?php echo $pe_row['stuid']?>)" width="30%" height="20" align="center" valign="middle" bgcolor="#C6D9EC"><?php echo $book[0]?></td>
               <td onclick="chagecolor(<?php echo "pe".$pe+1 ?>,<?php echo $pe_row['stuid']?>)" width="15%" height="20" align="center" valign="middle" bgcolor="#C6D9EC"><input style="border:none;text-align:center;" type="text" value="<?php echo $pe_row['mark']?>" name="grade"  /></td>
               <td onclick="chagecolor(<?php echo "pe".$pe+1 ?>,<?php echo $pe_row['stuid']?>)" width="17%" height="20" align="center" valign="middle" bgcolor="#C6D9EC"><?php echo date("Y-m-d",$pe_row['mark'])?></td>
                <td width="17%" height="20" align="center" valign="middle" bgcolor="#C6D9EC">
                	<input type="submit" value="�� ��" name="subone" />                </td>
            </tr>
            </form>
            <?php }?>
            <tr>
            	<td colspan="6">
                	<a href="#" onClick="selectAll();">ȫ��ѡ��</a>
                    <a href="#" onClick="selectInvert();">��ѡ</a>
                     <a href="#" onClick="selectNone();">ȡ��ѡ��</a> 
                  	<input type="button" value="�����޸�" name="suball" onclick="suball()" />
                                   
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



//�޸�ȫ�� 
function suball(){
	var sed = document.getElementsByName("sel[]");
	for(var i=0;i<sed.length;i++){
		document.getElementById("af"+i).submit();
	}  
	
}

            //����֤ 
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
                    alert("������ѡ��һ�"); 
                    return false ; 
                } 
            } 
            //ȫѡ 
            function iselect(){ //���к����ֲ���Ϊselect ��ΪJS������ 
                var ids = document.getElementsByName("sel[]"); 
                var all = document.getElementByIdx_x_x("all");               
                for(var i=0;i<ids.length;i++){ 
                    ids[i].checked=all.checked; 
                } 
            } 
            //ȫѡ 
            function selectAll(){ 
                var ids = document.getElementsByName("sel[]");                           
                for(var i=0;i<ids.length;i++){ 
                    ids[i].checked=true; 
                } 
            } 
            //ȫ�� 
            function selectNone(){ 
                var ids = document.getElementsByName("sel[]");                           
                for(var i=0;i<ids.length;i++){ 
                    ids[i].checked=false; 
                } 
            } 
            //��ѡ 
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