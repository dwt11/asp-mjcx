<?php
/**
 * 编辑系统管理员
 *
 * @version        $Id: pwd_edit.php 1 16:22 20日Z tianya $
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
        ShowMsg('密码不合法，请使用[0-9a-zA-Z_@!.-]内的字符！', '-1', 0, 3000);
        exit();
    }
    $safecodeok = substr(md5($cfg_cookie_encode.$randcode), 0, 24);
    if($safecodeok != $safecode)
    {
        ShowMsg("请填写正确的安全验证串！", "pwd_edit.php?id={$id}&dopost=edit");
        exit();
    }
    $pwdm = '';
    if($pwd != '')
    {
        $pwd = substr(md5($pwd), 5, 20);
    }
   
        $query = "UPDATE `#@__admin` SET pwd='$pwd' WHERE id='$id'";
    
    $dsql->ExecuteNoneQuery($query);
    ShowMsg("成功修改密码！", "pwd_edit.php");
    exit();
}


//显示用户信息
$randcode = mt_rand(10000,99999);
$safecode = substr(md5($cfg_cookie_encode.$randcode),0,24);
$typeOptions = '';
$row = $dsql->GetOne("SELECT * FROM `#@__admin` WHERE id='$id'");

include DedeInclude('templets/pwd_edit.htm');