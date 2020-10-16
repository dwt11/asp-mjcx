<?php
/**
 * 系统配置
 *
 * @version        $Id: sys_info.php 1 22:28 20日Z tianya $
 * @package        Administrator
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Edit');
if(empty($dopost)) $dopost = "";

$configfile = DEDEDATA.'/config.cache.inc.php';



//保存配置的改动
if($dopost=="save")
{
	
			  if($pwd!=""){
				  
					  $pwd =  substr(md5($pwd), 5, 20);
				 
				  
				  echo $k;
				  $dsql->ExecuteNoneQuery("UPDATE `#@__sysconfig` SET `value`='$pwd' WHERE aid=1 ");
				  ShowMsg("成功更改站点配置！", "sys_info.php");
				  exit();
			  }else{
				  ShowMsg("如果修改配置请填写内容！", "sys_info.php");
				  exit();
				  
				  }
			  
	
}


include DedeInclude('templets/sys_info.htm');