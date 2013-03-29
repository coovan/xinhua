<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>云南新华电脑学院考试考证系统</title>
<link rel="stylesheet" type="text/css" href="style/css.css"/>
<script>
function CheckLogin(obj){
	if(obj.username.value=='')
	{
		alert('请输入用户名');
		obj.username.focus();
		return false;
	}
	if(obj.password.value=='')
	{
		alert('请输入登录密码');
		obj.password.focus();
		return false;
	}
		if(obj.key.value=='')
		{
			alert('请输入验证码');
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
                    	<p><span>用户名：</span><input class="Fw" type="text" name="username" ></p>
                        <p><span>密&nbsp; 码：</span><input class="Fw" type="password" name="password"></p>
                        <p><span>验证码：</span><input id="Fw1" type="text"  name="key" value=""><span id="Yz"><img src="ShowKey.php" name="KeyImg" id="KeyImg" align="bottom" onClick="KeyImg.src='ShowKey.php?'+Math.random()" alt="看不清楚,点击刷新"></span></p>
                        <p><input class="Hw" type="image" src="images/deng.gif" name="" value="登陆"></p>
                    </form>
                </div>
            </div>
            <div id="cont_3">
            	<p>云南新华电脑学院考试考证</p>
            </div>
        </div>
        <div id="Hw_a"></div>
        <div id="Hw_b"><p>Copyright (c) 云南新华电脑学院2010-2014 版权所有 v1.0</p></div>
        <div id="Hw_c">
          <p>开发人员：云南新华电脑学院意博(E-BOSS)项目实训中心全体成员&nbsp;&nbsp;&nbsp; 指导教师：王园园<p>
        </div>
    </div>
</body>
</html>
