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


$whereSql =" where 1=1 ";
if($keyword != '')
{
	$whereSql .= " AND (empname LIKE '%$keyword%' or empid LIKE '%$keyword%') ";
}

$strreturn="";
$query = "SELECT * FROM `dede_emp`  $whereSql  order by empid asc  limit 0,10";
//echo $query;
        $dsql->SetQuery($query);
        $dsql->Execute();
        while($row=$dsql->GetObject())
        {
          $strreturn .= "\"".$row->empname."\",";
        }

//查询
//$dlist->SetSource($query);

echo "suggest_so1({q:\"".$keyword."\",p:true,s:[".$strreturn."]});";