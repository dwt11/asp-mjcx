<?php
/**
 * ��̨��½
 *
 * @version        $Id: login.php 1 8:48 13��Z tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__).'/../include/common.inc.php');
require_once(DEDEINC.'/userlogin.class.php');
if(empty($dopost)) $dopost = '';



//���·�����
require_once (DEDEDATA.'/admin/config_update.php');

if ($dopost=='showad')
{
    include('templets/login_ad.htm');
    exit;
}

//����̨Ŀ¼�Ƿ����
$cururl = GetCurUrl();
if(preg_match('/dede\/login/i',$cururl))
{
    $redmsg = '<div class=\'safe-tips\'>���Ĺ���Ŀ¼�������а���Ĭ������dede��������FTP������޸�Ϊ�������ƣ����������ȫ��</div>';
}
else
{
    $redmsg = '';
}

//��¼���
$admindirs = explode('/',str_replace("\\",'/',dirname(__FILE__)));
$admindir = $admindirs[count($admindirs)-1];
if($dopost=='login')
{
    $validate = empty($validate) ? '' : strtolower(trim($validate));
    $svali = strtolower(GetCkVdValue());
    if(($validate=='' || $validate != $svali) && preg_match("/6/",$safe_gdopen)){
        ResetVdValue();
        ShowMsg('��֤�벻��ȷ!',-1,0,1000);
        exit;
    } else {
        $cuserLogin = new userLogin($admindir);
        if(!empty($userid) && !empty($pwd))
        {
            $res = $cuserLogin->checkUser($userid,$pwd);
//echo $userid;
            //success
            if($res==1)
            {
                $cuserLogin->keepUser();
                if(!empty($gotopage))
                {
                    ShowMsg('�ɹ���¼������ת����������ҳ��',$gotopage);
                    exit();
                }
                else
                {
                    ShowMsg('�ɹ���¼������ת����������ҳ��',"index.php");
                    exit();
                }
            }

            //error
            else if($res==-1)
            {
				ShowMsg('����û���������!',-1,0,1000);
				exit;
            }
            else
            {
                ShowMsg('����������!',-1,0,1000);
				exit;
            }
        }

        //password empty
        else
        {
            ShowMsg('�û�������û��д����!',-1,0,1000);
			exit;
        }
    }
}

include('templets/login.htm');