<?php
/**
 * �༭ϵͳ����Ա
 *
 * @version        $Id: pwd_edit.php 1 16:22 20��Z tianya $
 * @package        Administrator
 */
require_once(dirname(__FILE__).'/config.php');
CheckPurview('sys_User');
if(empty($dopost)) $dopost = '';
$id = preg_replace("#[^0-9]#", '', $id);

if($dopost=='saveedit')
{
    $pwd = trim($pwd);
    if($pwd!='' && preg_match("#[^0-9a-zA-Z_@!\.-]#", $pwd))
    {
        ShowMsg('���벻�Ϸ�����ʹ��[0-9a-zA-Z_@!.-]�ڵ��ַ���', '-1', 0, 3000);
        exit();
    }
    $safecodeok = substr(md5($cfg_cookie_encode.$randcode), 0, 24);
    if($safecodeok != $safecode)
    {
        ShowMsg("����д��ȷ�İ�ȫ��֤����", "pwd_edit.php?id={$id}&dopost=edit");
        exit();
    }
    $pwdm = '';
    if($pwd != '')
    {
        $pwd = substr(md5($pwd), 5, 20);
    }
   
        $query = "UPDATE `#@__admin` SET pwd='$pwd' WHERE id='$id'";
    
    $dsql->ExecuteNoneQuery($query);
    ShowMsg("�ɹ��޸����룡", "pwd_edit.php");
    exit();
}


//��ʾ�û���Ϣ
$randcode = mt_rand(10000,99999);
$safecode = substr(md5($cfg_cookie_encode.$randcode),0,24);
$typeOptions = '';
$row = $dsql->GetOne("SELECT * FROM `#@__admin` WHERE id='$id'");

include DedeInclude('templets/pwd_edit.htm');