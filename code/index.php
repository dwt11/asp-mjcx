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

		 //���浽��
		$query = "INSERT INTO `#@__que_log`(quedate,quebody,queip,isbat,empid)
		VALUES ('$updatedate','δ���֤��','". GetIP()."','0','$empid');";
	  //echo $query;
		if(!$dsql->ExecuteNoneQuery($query))
		{
			ShowMsg("�����ݱ��浽���ݿ��ʱ����","javascript:;");
			exit();
		}
				ShowMsg("��¼�ɹ���",-1,0,500);
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
		  $returnstr="����Ƭ";
			  
			  }
        return $returnstr;
    }