<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�����»�����ѧԺ���Կ�֤ϵͳ</title>
<link rel="stylesheet" type="text/css" href="style/css.css"/>
<script>
function CheckLogin(obj){
	if(obj.username.value=='')
	{
		alert('�������û���');
		obj.username.focus();
		return false;
	}
	if(obj.password.value=='')
	{
		alert('�������¼����');
		obj.password.focus();
		return false;
	}
		if(obj.key.value=='')
		{
			alert('��������֤��');
			obj.key.focus();
			return false;
		}
	return true;
}
</script>
</head>

<body>
	<div id="headbg">
    	<div id="headtop"></div>
        <div id="logo">
        	<div id="logobg1"></div>
        	<div id="logobg"></div>
        </div>
        <div id="kong"></div>
        <div id="cont">
        	<div id="box1">
            	<div id="box1bg"></div>
            </div>
            <div id="cont_2">
            	<div id="Form">
                	<form name="login" id="login" method="post" action="user_login.php" onSubmit="return CheckLogin(document.login);">
    <input type="hidden" name="eboss" value="login">
                    	<p><span>�û�����</span><input class="Fw" type="text" name="username" ></p>
                        <p><span>��&nbsp; �룺</span><input class="Fw" type="password" name="password"></p>
                        <p><span>��֤�룺</span><input id="Fw1" type="text"  name="key" value=""><span id="Yz"><img src="ShowKey.php" name="KeyImg" id="KeyImg" align="bottom" onClick="KeyImg.src='ShowKey.php?'+Math.random()" alt="�������,���ˢ��"></span></p>
                        <p><input class="Hw" type="image" src="images/deng.gif" name="" value="��½"></p>
                    </form>
                </div>
            </div>
            <div id="cont_3">
            	<p>�����»�����ѧԺ���Կ�֤</p>
            </div>
        </div>
        <div id="Hw_a"></div>
        <div id="Hw_b"><p>Copyright (c) �����»�����ѧԺ2010-2014 ��Ȩ���� v1.0</p></div>
        <div id="Hw_c">
          <p>������Ա�������»�����ѧԺ�ⲩ(E-BOSS)��Ŀʵѵ����ȫ���Ա&nbsp;&nbsp;&nbsp; ָ����ʦ����԰԰<p>
        </div>
    </div>
</body>
</html>
