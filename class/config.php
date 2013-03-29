<?php
define("WEB_PATH",getenv("DOCUMENT_ROOT")."/kaozhengv1.1.1");//定义网站根目录
include_once WEB_PATH.'/class/ShowMsg.php';//导入消息提示文件
include_once WEB_PATH.'/class/fenye.php';//导入分页文件

//连接MYSQL 和数据库操作基本类；
class mysql{
	private $host;
	private $name;
	private $pass;
	private $table;
	private $ut;
	public $query;//sql语句
	public $num;//返回记录数
	public $r;//返回数组
	public $id;//返回数据库id号
	function __construct($host,$name,$pass,$table,$ut){
		$this->host=$host;
		$this->name=$name;
		$this->pass=$pass;
		$this->table=$table;
		$this->ut=$ut;
		$this->conn();
		
	}
	function conn(){
		$link=mysql_connect($this->host,$this->name,$this->pass) or die("连接数据库出错！");
		mysql_select_db($this->table,$link) or die("寻找不到数据库！".$this->table);
		mysql_query("SET NAMES'$this->ut'");	
	}
	function query($query)
	{
		$query=mysql_query($query);
		return $query;
	}
	//执行mysql_query()语句2
	function query1($query)
	{
		$this->sql=mysql_query($query);
		return $this->sql;
	}
	//执行mysql_fetch_array()
	function fetch($sql)//此方法的参数是$sql就是sql语句执行结果
	{
		$this->r=mysql_fetch_array($sql);
		return $this->r;
	}
	//执行fetchone(mysql_fetch_array())
	//此方法与fetch()的区别是:1、此方法的参数是$query就是sql语句
	//2、此方法用于while(),for()数据库指针不会自动下移，而fetch()可以自动下移。
	function fetch1($query)
	{
		$this->sql=$this->query($query);
		$this->r=mysql_fetch_array($this->sql);
		return $this->r;
	}
	//执行mysql_num_rows()
	function num($query)//此类的参数是$query就是sql语句
	{
		$this->sql=$this->query($query);
		$this->num=mysql_num_rows($this->sql);
		return $this->num;
	}
	//执行numone(mysql_num_rows())
	//此方法与num()的区别是：1、此方法的参数是$sql就是sql语句的执行结果。
	function num1($sql)
	{
		$this->num=mysql_num_rows($sql);
		return $this->num;
	}
	//执行numone(mysql_num_rows())
	//统计记录数
	function gettotal($query)
	{
		$this->r=$this->fetch1($query);
		return $this->r['total'];
	}
	//执行free(mysql_result_free())
	//此方法的参数是$sql就是sql语句的执行结果。只有在用到mysql_fetch_array的情况下用
	function free($sql)
	{
		mysql_free_result($sql);
	}
	//执行seek(mysql_data_seek())
	//此方法的参数是$sql就是sql语句的执行结果,$pit为执行指针的偏移数
	function seek($sql,$pit)
	{
		mysql_data_seek($sql,$pit);
	}
	//执行id(mysql_insert_id())
	function lastid()//取得最后一次执行mysql数据库id号
	{
		$this->id=mysql_insert_id();
		return $this->id;
	}
	function close() {
		return mysql_close();
	}
	//是否登陆
	function is_login($uid=0,$uname='',$group=''){
		$userid=$_COOKIE['userid'];
		$username=$_COOKIE['username'];
		$rnd=$_COOKIE['group'];
		if(!$userid||!$username||!$rnd)
		{
			printerror("你还没有登陆！","index.php");
		}
	
		//db
		$sql="select id,groupid,username,truename from userinfo where id=$userid and username='$username' and checked=0 limit 1";
		$adminr=$this->fetch1($sql);
		if(!$adminr['id'])
		{
			printerror("你登陆的账号不存在！","index.php");
		}
		$user['id']=$userid;
		$user['username']=$username;
		$user['truename']=$adminr['truename'];
		$user['group']=$rnd;
		$user['groupid']=$adminr['groupid'];
		return $user;
	}
}
//实列化，连接数据库;
$db=new mysql('localhost','root','','xinhuastu',"GBK");
//处理编码字符
function CkPostStrChar($val){
	if(substr($val,-1)=="\\")
	{
		exit();
	}
}

//参数处理函数
function RepPostVar($val){
	if($val!=addslashes($val))//addslashes() 函数在指定的预定义字符前添加反斜杠。
	{
		exit();
	}
	CkPostStrChar($val);
	$val=str_replace(" ","",$val);
	$val=str_replace("%20","",$val);
	$val=str_replace("%27","",$val);
	$val=str_replace("*","",$val);
	$val=str_replace("'","",$val);
	$val=str_replace("\"","",$val);
	$val=str_replace("/","",$val);
	$val=str_replace(";","",$val);
	$val=str_replace("#","",$val);
	$val=str_replace("--","",$val);
	return $val;
}


//错误提示
function printerror($error="",$gotourl=""){
	if(empty($gotourl) || $gotourl=="history.go(-1)")
	{
		$gotourl="javascript:history.go(-1)";
	}
	else
	{$gotourl_js="self.location.href='$gotourl';";}
	if(empty($error))
	{$error="对不起，发生了不明错误！";}
	echo"<script>alert('".$error."');".$gotourl_js."</script>";
	exit();
}




?>