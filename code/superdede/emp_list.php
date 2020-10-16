<?php
/**
 * 内容列表
 * content_s_list.php、content_i_list.php、content_select_list.php
 * 均使用本文件作为实际处理代码，只是使用的模板不同，如有相关变动，只需改本文件及相关模板即可
 *
 * @version        $Id: content_list.php 1 14:31 12日Z tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__).'/config.php');
require_once(DEDEINC.'/typelink.class.php');
require_once(DEDEINC.'/datalistcp.class.php');
require_once(DEDEADMIN.'/inc/inc_list_functions.php');



if($dopost=='del')
{
	
	$dsql->ExecuteNoneQuery("Delete From `#@__emp` where id='$id';");
	ShowMsg("删除成功！","emp_list.php");
	exit();
}

$depid = isset($depid) ? intval($depid) : 0;


//检查权限许可，总权限
CheckPurview('a_List,a_AccList,a_MyList');

//部门浏览许可
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
        CheckCatalog($depid, '你无权浏览非指定部门的内容！');
    }
    if(TestPurview('a_MyList')) $mid =  $cuserLogin->getUserID();

}




$adminid = $cuserLogin->getUserID();
$maintable = '#@__emp';
setcookie('ENV_GOBACK_URL', $dedeNowurl, time()+3600, '/');
$tl = new TypeLink($depid);



if($depid==0)
{
   
        $positionname = '所有部门&gt;';
   
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
//默认DESC降序，110716
    $neworderway = ($orderway == 'desc' ? 'asc' : 'desc');

$query = "SELECT arc.* 
FROM `$maintable` arc 

$whereSql
group  by $orderbyField $neworderway";

//dump($query);
if(empty($f) || !preg_match("#form#", $f)) $f = 'form1.ardepid1';

//初始化
$dlist = new DataListCP();
$dlist->pageSize = 30;
//分页在 datalistcp.class.php



//GET参数
$dlist->SetParameter('dopost', 'listArchives');
$dlist->SetParameter('keyword', $keyword);
$dlist->SetParameter('depid', $depid);
$dlist->SetParameter('idnumb', $idnumb);//按ID搜索110716
$dlist->SetParameter('orderby', $orderby);
$dlist->SetParameter('where', $where);

//模板
if(empty($s_tmplets)) $s_tmplets = 'templets/emp_list.htm';
$dlist->SetTemplate(DEDEADMIN.'/'.$s_tmplets);

//查询
$dlist->SetSource($query);

//显示
$dlist->Display();
// echo $dlist->queryTime;
$dlist->Close();







	
	 function Getface($face)
    {
        //echo $fstr;
       // $ks = explode(' ',$this->Keywords);
      if ($face!=""){
		  
		  $returnstr="<a href=\"javascript:;\" onClick=\"ChangeImage('$face',295,413);\"><img src='../include/dialog/img/picviewnone.gif' name='picview' border='0' alt='预览'>点击查看</a>";

		  }else
		  {
		  $returnstr="无";
			  
			  }
        return $returnstr;
    }