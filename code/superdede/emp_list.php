<?php
/**
 * �����б�
 * content_s_list.php��content_i_list.php��content_select_list.php
 * ��ʹ�ñ��ļ���Ϊʵ�ʴ�����룬ֻ��ʹ�õ�ģ�岻ͬ��������ر䶯��ֻ��ı��ļ������ģ�弴��
 *
 * @version        $Id: content_list.php 1 14:31 12��Z tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__).'/config.php');
require_once(DEDEINC.'/typelink.class.php');
require_once(DEDEINC.'/datalistcp.class.php');
require_once(DEDEADMIN.'/inc/inc_list_functions.php');



if($dopost=='del')
{
	
	$dsql->ExecuteNoneQuery("Delete From `#@__emp` where id='$id';");
	ShowMsg("ɾ���ɹ���","emp_list.php");
	exit();
}

$depid = isset($depid) ? intval($depid) : 0;


//���Ȩ����ɣ���Ȩ��
CheckPurview('a_List,a_AccList,a_MyList');

//����������
$userCatalogSql = '';
if(TestPurview('a_List'))
{
    ;
}
else if(TestPurview('a_AccList'))
{
    if($depid==0 && $cfg_admin_channel == 'array')
    {
        $admin_catalog = join(',', $admin_catalogs);
        $userCatalogSql = " arc.depid IN($admin_catalog) ";
    }
    else
    {
        CheckCatalog($depid, '����Ȩ�����ָ�����ŵ����ݣ�');
    }
    if(TestPurview('a_MyList')) $mid =  $cuserLogin->getUserID();

}




$adminid = $cuserLogin->getUserID();
$maintable = '#@__emp';
setcookie('ENV_GOBACK_URL', $dedeNowurl, time()+3600, '/');
$tl = new TypeLink($depid);



if($depid==0)
{
   
        $positionname = '���в���&gt;';
   
}
else
{
    $positionname = str_replace($cfg_list_symbol," &gt; ",$tl->GetPositionName())." &gt; ";
}




    $optionarr = $tl->GetOptionArray($depid);
//echo $optionarr ."ooooo";
$whereSql =" where 1=1 ";







if($keyword != '')
{
    //$whereSql .= " AND ( CONCAT(arc.title,arc.writer) LIKE '%$keyword%') ";
	$whereSql .= " AND (arc.empname LIKE '%$keyword%' or arc.empid LIKE '%$keyword%') ";
}
if($depid != 0)
{
    $whereSql .= ' AND depid IN ('.GetSonIds($depid).')';
}

$orderby = empty($orderby) ? 'id' : preg_replace("#[^a-z0-9]#", "", $orderby);
$orderbyField = 'arc.'.$orderby;
//Ĭ��DESC����110716
    $neworderway = ($orderway == 'desc' ? 'asc' : 'desc');

$query = "SELECT arc.* 
FROM `$maintable` arc 

$whereSql
group  by $orderbyField $neworderway";

//dump($query);
if(empty($f) || !preg_match("#form#", $f)) $f = 'form1.ardepid1';

//��ʼ��
$dlist = new DataListCP();
$dlist->pageSize = 30;
//��ҳ�� datalistcp.class.php



//GET����
$dlist->SetParameter('dopost', 'listArchives');
$dlist->SetParameter('keyword', $keyword);
$dlist->SetParameter('depid', $depid);
$dlist->SetParameter('idnumb', $idnumb);//��ID����110716
$dlist->SetParameter('orderby', $orderby);
$dlist->SetParameter('where', $where);

//ģ��
if(empty($s_tmplets)) $s_tmplets = 'templets/emp_list.htm';
$dlist->SetTemplate(DEDEADMIN.'/'.$s_tmplets);

//��ѯ
$dlist->SetSource($query);

//��ʾ
$dlist->Display();
// echo $dlist->queryTime;
$dlist->Close();







	
	 function Getface($face)
    {
        //echo $fstr;
       // $ks = explode(' ',$this->Keywords);
      if ($face!=""){
		  
		  $returnstr="<a href=\"javascript:;\" onClick=\"ChangeImage('$face',295,413);\"><img src='../include/dialog/img/picviewnone.gif' name='picview' border='0' alt='Ԥ��'>����鿴</a>";

		  }else
		  {
		  $returnstr="��";
			  
			  }
        return $returnstr;
    }