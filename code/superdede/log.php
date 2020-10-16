<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Operations');
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');
require_once('inc/inc_list_functions.php');

if($dopost=='del')
{
	
	$dsql->ExecuteNoneQuery("Delete From `#@__que_log` where id='$id';");
	ShowMsg("删除成功！",$ENV_GOBACK_URL);
	exit();
}
if($dopost=='bat')
{
    $upquery = "UPDATE `#@__que_log` SET
     isbat='$isbat' 
    WHERE id='$id' ";

    if(!$dsql->ExecuteNoneQuery($upquery))
    {
        ShowMsg("保存当前部门更改时失败，请检查你的输入资料是否存在问题！","-1");
        exit();
    }
	
	ShowMsg("更新成功！",$ENV_GOBACK_URL);
	exit();
}



//$addsql = "where 1=1 ";
//if(empty($search_type)&&empty($sta))
//{
//	$addsql  = " where sid=0  And sta<>9 ";
//}




//echo $addsql;
$sql = "Select * From `#@__que_log` $addsql order by quedate desc,id desc";
//dump($sql);
$dlist = new DataListCP();
//dump($sql);

//设定每页显示记录数（默认25条）
$dlist->pageSize = 25;
$dlist->SetParameter("mid",$mid);
	$dlist->SetParameter("search_type",$search_type);

if(isset($sta))
{
	$dlist->SetParameter("sta",$sta);
}
//$dlist->dsql->SetQuery("Select * From #@__moneycard_type ");
//$dlist->dsql->Execute('ts');
//while($rw = $dlist->dsql->GetArray('ts'))
//{
//	$TypeNames[$rw['tid']] = $rw['pname'];
//}
$tplfile = DEDEADMIN."/templets/log.htm";

//这两句的顺序不能更换
$dlist->SetTemplate($tplfile);      //载入模板
$dlist->SetSource($sql);            //设定查询SQL
$dlist->Display();                  //显示


function Getemp($empid)
{
	        global $dsql;

			    $row = $dsql->GetOne("Select * From `#@__emp` where id=$empid ");

	 return $row['empid']."-".GetDepname($row['depid'])."-".$row['empname'];
}
function Getisbat($isbat,$id)
{
	if($isbat==0)return "<a href='?dopost=bat&isbat=1&id=$id'>未处理</a>";
	if($isbat==1)return "<a href='?dopost=bat&isbat=1&id=$id'>已处理</a>";
}




?>