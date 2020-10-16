<?php
/**
 *
 * @version        $Id: login.php 1 8:48 13日Z tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__)."/config.php");
if(empty($dopost)) $dopost = '';





//登录检测
if($dopost=='login')
{
        if(!empty($q))
        {
			
			$pwd = substr(md5($q), 5, 20);
			$dsql->SetQuery("SELECT * FROM `#@__sysconfig`   WHERE aid=1");
			$dsql->Execute();
			$row = $dsql->GetObject();

			if(!isset($row->value))
			{
				$res= -1;
			}
			else if($pwd!=$row->value)
			{
				$res= -2;
			}
			else
			{
				$loginip = GetIP();
				$res= 1;
			}
		     if($res==1)
            {
				
	
				PutCookie('webIp',  GetIP(), 3600 * 24, '/');
                if(!empty($gotopage))
                {
                    ShowMsg('成功登录，正在转向主页！',$gotopage);
                    exit();
                }
                else
                {
                    ShowMsg('成功登录，正在转向主页！',"index.php");
                    exit();
                }
            }

            
            else if($res==-2)
            {
                ShowMsg('你的密码错误!',-1,0,1000);
				exit;
            }
        }

        //password empty
        else
        {
            ShowMsg('请填写登录密码!',-1,0,1000);
			exit;
        }
   
}

 //退出登录
    else if($dopost=="exit")
    {
        $cfg_ml->ExitCookie();
       
        ShowMsg("成功退出登录！","login.php",0,2000);
        exit();
    }
	
if(GetCookie("webIp")=="")
{
	include_once(dirname(__FILE__)."/templets/login.htm");
}
else
{

	
	include('templets/index.htm');


}

