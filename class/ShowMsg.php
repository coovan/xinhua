<?php 
/*
 * ��ʾ��Ϣ����
 * $msg Ҫ��ʾ����Ϣ
 * $gourl Ҫ��ת����ҳ��
 * $title  ��Ϣ��ı���
 * $onlymsg
 * $limittime ͣ����ʱ��Ĭ��3000����
 * �÷� ��ShowMsg('�Բ���,�����Ϣ�������İ���','time.php',$title='���ݹ���ϵͳ��ʾ');
 */
function ShowMsg($msg, $gourl,$title='ϵͳ��ʾ!',$onlymsg=0, $limittime=0 )

{

    if(empty($GLOBALS['cfg_plus_dir'])) $GLOBALS['cfg_plus_dir'] = '..';

    $htmlhead  = "<html>\r\n<head>\r\n<title>$title</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gbk\" />\r\n";

    $htmlhead .= "<base target='_self'/>\r\n<style>div{line-height:120%;}</style></head>\r\n<body leftmargin='0' topmargin='0' bgcolor='#FFFFFF' >\r\n<center>\r\n<script>\r\n";

    $htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";

    //Ĭ��3�뷵��

    $litime = ($limittime==0 ? 3000 : $limittime);

    $func = '';

    if($gourl=='-1')

    {

        if($limittime==0) $litime = 5000;

        $gourl = "javascript:history.go(-1);";

    }

    if($gourl=='' || $onlymsg==1)

    {

        $msg = "<script>alert(\"".str_replace("\"","��",$msg)."\");</script>";

    }

    else

    {

        //����ַΪ:close::objname ʱ, �رո���ܵ�id=objnameԪ��

        if(preg_match('/close::/',$gourl))

        {

            $tgobj = trim(preg_replace('/close::/', '', $gourl));

            $gourl = 'javascript:;';

            $func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";

        }

        

        $func .= "      var pgo=0;

      function JumpUrl(){

        if(pgo==0){ location='$gourl'; pgo=1; }

      }\r\n";

        $rmsg = $func;

        $rmsg .= "document.write(\"<br /><div style='width:300px;padding:0px;border:1px solid #DADADA;'>";

        $rmsg .= "<div style='padding:6px;color:#ffffff;font-size:14px;border-bottom:1px solid #DADADA;background:#3A73AD url({$GLOBALS['cfg_plus_dir']}/img/wbg.gif)';'><b>$title</b></div>\");\r\n";

        $rmsg .= "document.write(\"<div style='height:80px;font-size:10pt;background:#fff'><br />\");\r\n";

        $rmsg .= "document.write(\"".str_replace("\"","��",$msg)."\");\r\n";

        $rmsg .= "document.write(\"";

        

        if($onlymsg==0)

        {

            if( $gourl != 'javascript:;' && $gourl != '')

            {

                $rmsg .= "<br /><br /><a href='{$gourl}'>������������û��Ӧ����������...</a>";

                $rmsg .= "<br/></div>\");\r\n";

                $rmsg .= "setTimeout('JumpUrl()',$litime);";

            }

            else

            {

                $rmsg .= "<br/></div>\");\r\n";

            }

        }

        else

        {

            $rmsg .= "<br/><br/></div>\");\r\n";

        }

        $msg  = $htmlhead.$rmsg.$htmlfoot;

    }

    echo $msg;

}
    
?>