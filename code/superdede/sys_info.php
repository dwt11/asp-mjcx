<?php
/**
 * ϵͳ����
 *
 * @version        $Id: sys_info.php 1 22:28 20��Z tianya $
 * @package        Administrator
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Edit');
if(empty($dopost)) $dopost = "";

$configfile = DEDEDATA.'/config.cache.inc.php';



//�������õĸĶ�
if($dopost=="save")
{
	
			  if($pwd!=""){
				  
					  $pwd =  substr(md5($pwd), 5, 20);
				 
				  
				  echo $k;
				  $dsql->ExecuteNoneQuery("UPDATE `#@__sysconfig` SET `value`='$pwd' WHERE aid=1 ");
				  ShowMsg("�ɹ�����վ�����ã�", "sys_info.php");
				  exit();
			  }else{
				  ShowMsg("����޸���������д���ݣ�", "sys_info.php");
				  exit();
				  
				  }
			  
	
}


include DedeInclude('templets/sys_info.htm');