<?php
/**
 * 编辑
 *
 * @package        Administrator
 
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('a_Edit,a_AccEdit,a_MyEdit');

if(empty($dopost)) $dopost = '';


$aid = isset($aid) && is_numeric($aid) ? $aid : 0;
if($dopost!='save')
{
    require_once(DEDEADMIN."/inc/inc_dep_options.php");
    ClearMyAddon();

    //读取归档信息
    $query = "SELECT *
    FROM `#@__emp` arc
    WHERE id='$id' ";
    $arcRow = $dsql->GetOne($query);
    if(!is_array($arcRow))
    {
        ShowMsg("读取档案信息出错!","-1");
        exit();
    }
   
   
    include DedeInclude("templets/emp_edit.htm");
    exit();
}
/*--------------------------------
function __save(){  }
-------------------------------*/
else if($dopost=='save')
{
   if($depid==0)
    {
        ShowMsg('请指定部门！', '-1');
        exit();
    }

    
	
	



    //对保存的内容进行处理
    $updatedate = time();
    

    //更新数据库的SQL语句
    $query = "UPDATE #@__emp SET 
    empid='$empid',
    depid='$depid',
    empname='$empname',
    sex='$sex',
    face='$picname',
    updatedate='$updatedate'
   WHERE id='$id'";
  // echo $query;
    if(!$dsql->ExecuteNoneQuery($query))
    {
		ShowMsg('更新数据库表时出错，请检查',-1);
        exit();
    }
    
  
 
  
  
    //返回成功信息
    $msg = "
    　　请选择你的后续操作：
   
    <a href='emp_edit.php?id=".$id."'><u>更改</u></a> 
    &nbsp;&nbsp; 
    <a href='emp_list.php?depid=$depid'><u>员工管理</u></a>
    &nbsp;&nbsp;
    
    $backurl
    ";
  
  $wintitle = "成功更改！";
    $wecome_info = '员工管理::更改员工';
    $win = new OxWindow();
    $win->AddTitle("成功更改：");
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow("hand","&nbsp;",false);
    $win->Display();
}