<?php
/*
 * 添加学生时上传头像
 */
session_start();
include_once '../class/config.php';
date_default_timezone_set("PRC");
header("content-type:text/html;charset=gbk");
if(isset($_GET['act']) && ($_GET['act'] =="uploads")){
	//判断上传文件是否合法
	if(!is_uploaded_file($_FILES['avator'][tmp_name])){
			msg("上传文件不合法");
	}
	//判断文件大小
	$allowed_size = 2*1024*1024;
	if($_FILES['avator']['size']>$allowed_size){
			msg("上传的图片过大，请修改后重新上传");
	}
	//判断类型
	$allowed_type = array("jpg","bmp","gif","jpeg","png","zip","rar","txt");
	$path_info_arr = pathinfo($_FILES['avator']['name']);//取得文件类型的数组
	$extension = strtolower($path_info_arr['extension']);
	if(!in_array($extension,$allowed_type)){
		msg("上传的类型不允许");	
	}
	//重命名
	if(!file_exists("../stupic/")){
		@mkdir("../stupic/",0777,true);	
	}
	$new_name = date("YmdHis").rand(1000,9999).".".$extension;
	//移动
	
	$res = move_uploaded_file($_FILES['avator']['tmp_name'],"../stupic/{$new_name}");
	if($res){
		
		echo "<img src='../stupic/{$new_name}' height='100%'>";
		$_SESSION["stu_img"]="{$new_name}";
		
		
	}
}else{
	 $sql="SELECT `simg` FROM `student` WHERE `sid` = '".$_GET['stuid']."'";
	 $rst=$db->fetch1($sql);
	?>
    <form method="post" action="?act=uploads" enctype="multipart/form-data">
    <span style="margin:0 auto;">上传头像</span><br/>
    <input type="file" name = "avator">
    <input type="submit" value="上传">
    </form>
    <?php 
    	if ($rst){
    ?>
    <img src="../stupic/<?php echo  $rst['simg'];?>" height="80%">
   <?php }?>
    
    <?php
}
?>