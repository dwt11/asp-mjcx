<?php
/**
 *
 * @version        $Id: login.php 1 8:48 13��Z tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__)."/config.php");
if(empty($dopost)) $dopost = '';





//��¼���
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
                    ShowMsg('�ɹ���¼������ת����ҳ��',$gotopage);
                    exit();
                }
                else
                {
                    ShowMsg('�ɹ���¼������ת����ҳ��',"index.php");
                    exit();
                }
            }

            
            else if($res==-2)
            {
                ShowMsg('����������!',-1,0,1000);
				exit;
            }
        }

        //password empty
        else
        {
            ShowMsg('����д��¼����!',-1,0,1000);
			exit;
        }
   
}

 //�˳���¼
    else if($dopost=="exit")
    {
        $cfg_ml->ExitCookie();
       
        ShowMsg("�ɹ��˳���¼��","login.php",0,2000);
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

