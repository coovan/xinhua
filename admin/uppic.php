<?php
/*
 * ���ѧ��ʱ�ϴ�ͷ��
 */
session_start();
include_once '../class/config.php';
date_default_timezone_set("PRC");
header("content-type:text/html;charset=gbk");
if(isset($_GET['act']) && ($_GET['act'] =="uploads")){
	//�ж��ϴ��ļ��Ƿ�Ϸ�
	if(!is_uploaded_file($_FILES['avator'][tmp_name])){
			msg("�ϴ��ļ����Ϸ�");
	}
	//�ж��ļ���С
	$allowed_size = 2*1024*1024;
	if($_FILES['avator']['size']>$allowed_size){
			msg("�ϴ���ͼƬ�������޸ĺ������ϴ�");
	}
	//�ж�����
	$allowed_type = array("jpg","bmp","gif","jpeg","png","zip","rar","txt");
	$path_info_arr = pathinfo($_FILES['avator']['name']);//ȡ���ļ����͵�����
	$extension = strtolower($path_info_arr['extension']);
	if(!in_array($extension,$allowed_type)){
		msg("�ϴ������Ͳ�����");	
	}
	//������
	if(!file_exists("../stupic/")){
		@mkdir("../stupic/",0777,true);	
	}
	$new_name = date("YmdHis").rand(1000,9999).".".$extension;
	//�ƶ�
	
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
    <span style="margin:0 auto;">�ϴ�ͷ��</span><br/>
    <input type="file" name = "avator">
    <input type="submit" value="�ϴ�">
    </form>
    <?php 
    	if ($rst){
    ?>
    <img src="../stupic/<?php echo  $rst['simg'];?>" height="80%">
   <?php }?>
    
    <?php
}
?>