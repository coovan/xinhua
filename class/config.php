<?php
define("WEB_PATH",getenv("DOCUMENT_ROOT")."/kaozhengv1.1.1");//������վ��Ŀ¼
include_once WEB_PATH.'/class/ShowMsg.php';//������Ϣ��ʾ�ļ�
include_once WEB_PATH.'/class/fenye.php';//�����ҳ�ļ�

//����MYSQL �����ݿ���������ࣻ
class mysql{
	private $host;
	private $name;
	private $pass;
	private $table;
	private $ut;
	public $query;//sql���
	public $num;//���ؼ�¼��
	public $r;//��������
	public $id;//�������ݿ�id��
	function __construct($host,$name,$pass,$table,$ut){
		$this->host=$host;
		$this->name=$name;
		$this->pass=$pass;
		$this->table=$table;
		$this->ut=$ut;
		$this->conn();
		
	}
	function conn(){
		$link=mysql_connect($this->host,$this->name,$this->pass) or die("�������ݿ����");
		mysql_select_db($this->table,$link) or die("Ѱ�Ҳ������ݿ⣡".$this->table);
		mysql_query("SET NAMES'$this->ut'");	
	}
	function query($query)
	{
		$query=mysql_query($query);
		return $query;
	}
	//ִ��mysql_query()���2
	function query1($query)
	{
		$this->sql=mysql_query($query);
		return $this->sql;
	}
	//ִ��mysql_fetch_array()
	function fetch($sql)//�˷����Ĳ�����$sql����sql���ִ�н��
	{
		$this->r=mysql_fetch_array($sql);
		return $this->r;
	}
	//ִ��fetchone(mysql_fetch_array())
	//�˷�����fetch()��������:1���˷����Ĳ�����$query����sql���
	//2���˷�������while(),for()���ݿ�ָ�벻���Զ����ƣ���fetch()�����Զ����ơ�
	function fetch1($query)
	{
		$this->sql=$this->query($query);
		$this->r=mysql_fetch_array($this->sql);
		return $this->r;
	}
	//ִ��mysql_num_rows()
	function num($query)//����Ĳ�����$query����sql���
	{
		$this->sql=$this->query($query);
		$this->num=mysql_num_rows($this->sql);
		return $this->num;
	}
	//ִ��numone(mysql_num_rows())
	//�˷�����num()�������ǣ�1���˷����Ĳ�����$sql����sql����ִ�н����
	function num1($sql)
	{
		$this->num=mysql_num_rows($sql);
		return $this->num;
	}
	//ִ��numone(mysql_num_rows())
	//ͳ�Ƽ�¼��
	function gettotal($query)
	{
		$this->r=$this->fetch1($query);
		return $this->r['total'];
	}
	//ִ��free(mysql_result_free())
	//�˷����Ĳ�����$sql����sql����ִ�н����ֻ�����õ�mysql_fetch_array���������
	function free($sql)
	{
		mysql_free_result($sql);
	}
	//ִ��seek(mysql_data_seek())
	//�˷����Ĳ�����$sql����sql����ִ�н��,$pitΪִ��ָ���ƫ����
	function seek($sql,$pit)
	{
		mysql_data_seek($sql,$pit);
	}
	//ִ��id(mysql_insert_id())
	function lastid()//ȡ�����һ��ִ��mysql���ݿ�id��
	{
		$this->id=mysql_insert_id();
		return $this->id;
	}
	function close() {
		return mysql_close();
	}
	//�Ƿ��½
	function is_login($uid=0,$uname='',$group=''){
		$userid=$_COOKIE['userid'];
		$username=$_COOKIE['username'];
		$rnd=$_COOKIE['group'];
		if(!$userid||!$username||!$rnd)
		{
			printerror("�㻹û�е�½��","index.php");
		}
	
		//db
		$sql="select id,groupid,username,truename from userinfo where id=$userid and username='$username' and checked=0 limit 1";
		$adminr=$this->fetch1($sql);
		if(!$adminr['id'])
		{
			printerror("���½���˺Ų����ڣ�","index.php");
		}
		$user['id']=$userid;
		$user['username']=$username;
		$user['truename']=$adminr['truename'];
		$user['group']=$rnd;
		$user['groupid']=$adminr['groupid'];
		return $user;
	}
}
//ʵ�л����������ݿ�;
$db=new mysql('localhost','root','','xinhuastu',"GBK");
//��������ַ�
function CkPostStrChar($val){
	if(substr($val,-1)=="\\")
	{
		exit();
	}
}

//����������
function RepPostVar($val){
	if($val!=addslashes($val))//addslashes() ������ָ����Ԥ�����ַ�ǰ��ӷ�б�ܡ�
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


//������ʾ
function printerror($error="",$gotourl=""){
	if(empty($gotourl) || $gotourl=="history.go(-1)")
	{
		$gotourl="javascript:history.go(-1)";
	}
	else
	{$gotourl_js="self.location.href='$gotourl';";}
	if(empty($error))
	{$error="�Բ��𣬷����˲�������";}
	echo"<script>alert('".$error."');".$gotourl_js."</script>";
	exit();
}




?>