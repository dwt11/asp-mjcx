<?php
require_once(dirname(__FILE__)."/../config.php");




echo  "<html>";
echo  "<head>";
echo  "<title>用户管理</title>";
echo  "<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>";
echo  "<link href='css/ext-all.css' rel='stylesheet' type='text/css'>";
echo  "<link href='css/body.css' rel='stylesheet' type='text/css'>";
echo  "</head>";
echo  "<body leftmargin='2' topmargin='0' marginwidth='0' marginheight='0'>";

switch($action){
  case "add":
       add;
  case "saveadd":
     saveadd;
  case "edit":
	 edit;
  case "saveedit":
     saveedit;
  case "del":
     del;
  case "":
	 main;
}	
function add(){
  echo "11";
}


function main(){
	echo"sdf";
}

?>