<?php
require_once(dirname(__FILE__)."/config.php");
CheckPurview('member_Operations');
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
require_once(DEDEINC.'/datalistcp.class.php');
require_once('inc/inc_list_functions.php');

if($dopost=='del')
{
	
	$dsql->ExecuteNoneQuery("Delete From `#@__que_log` where id='$id';");
	ShowMsg("ɾ���ɹ���",$ENV_GOBACK_URL);
	exit();
}
if($dopost=='bat')
{
    $upquery = "UPDATE `#@__que_log` SET
     isbat='$isbat' 
    WHERE id='$id' ";

    if(!$dsql->ExecuteNoneQuery($upquery))
    {
        ShowMsg("���浱ǰ���Ÿ���ʱʧ�ܣ�����������������Ƿ�������⣡","-1");
        exit();
    }
	
	ShowMsg("���³ɹ���",$ENV_GOBACK_URL);
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

//�趨ÿҳ��ʾ��¼����Ĭ��25����
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

//�������˳���ܸ���
$dlist->SetTemplate($tplfile);      //����ģ��
$dlist->SetSource($sql);            //�趨��ѯSQL
$dlist->Display();                  //��ʾ


function Getemp($empid)
{
	        global $dsql;

			    $row = $dsql->GetOne("Select * From `#@__emp` where id=$empid ");

	 return $row['empid']."-".GetDepname($row['depid'])."-".$row['empname'];
}
function Getisbat($isbat,$id)
{
	if($isbat==0)return "<a href='?dopost=bat&isbat=1&id=$id'>δ����</a>";
	if($isbat==1)return "<a href='?dopost=bat&isbat=1&id=$id'>�Ѵ���</a>";
}




?>