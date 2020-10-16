<?php
/**
 * 用户管理
 *
 * @version        $Id: sys_admin_user.php 1 16:22 20日Z tianya $
 * @package        Administrator
 */
require_once(dirname(__FILE__)."/../config.php");
CheckPurview('sys_User');
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
if(empty($rank)) $rank = '';
else $rank = " WHERE CONCAT(#@__sys_userid.usertype)='$rank' ";

$dsql->SetQuery("SELECT rank,typename FROM `#@__sys_grouplevel` ");
$dsql->Execute();
while($row = $dsql->GetObject())
{
    $adminRanks[$row->rank] = $row->typename;
}
$query = "SELECT #@__sys_userid.*,#@__arctype.typename FROM #@__sys_userid LEFT JOIN #@__arctype ON #@__sys_userid.typeid = #@__arctype.id $rank order by id desc ";
$dlist = new DataListCP();
$dlist->SetTemplet(DEDEADMIN."/templets/sys/sys_admin_user.htm");
$dlist->SetSource($query);
$dlist->Display();

function GetUserType($trank)
{
    global $adminRanks;
    if(isset($adminRanks[$trank])) return $adminRanks[$trank];
    else return "错误类型";
}

function GetChannel($c)
{
    if($c==""||$c==0) return "所有频道";
    else return $c;
}