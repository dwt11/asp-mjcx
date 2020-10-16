<?php
require_once(dirname(__FILE__).'/config.php');

require_once('superdede/inc/inc_list_functions.php');
if(GetCookie("webIp")=="")
{
	include_once(dirname(__FILE__)."/templets/login.htm");
}
else
{

	if($dopost=="save"){
		    $updatedate = time();

		 //保存到表
		$query = "INSERT INTO `#@__que_log`(quedate,quebody,queip,isbat,empid)
		VALUES ('$updatedate','未佩戴证件','". GetIP()."','0','$empid');";
	  //echo $query;
		if(!$dsql->ExecuteNoneQuery($query))
		{
			ShowMsg("把数据保存到数据库表时出错。","javascript:;");
			exit();
		}
				ShowMsg("记录成功。",-1,0,500);
			exit();

	
	
	}
	include('templets/index.htm');


}




	
	 function Getface($face)
    {
        //echo $fstr;<img src="css/banner.png" alt="cc" width="100" height="150" align="middle">
       // $ks = explode(' ',$this->Keywords);
      if ($face!=""){
		  
		  $returnstr="<img src='".$face."'   style='width:100px; height:150px'   class='magnify' >";

		  }else
		  {
		  $returnstr="无照片";
			  
			  }
        return $returnstr;
    }