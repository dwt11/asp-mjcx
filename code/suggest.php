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

//��ѯ
//$dlist->SetSource($query);

echo "suggest_so1({q:\"".$keyword."\",p:true,s:[".$strreturn."]});";