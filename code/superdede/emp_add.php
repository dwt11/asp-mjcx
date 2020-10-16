<?php
/**
 * 增加
 *
 * @package        Administrator
 */
require_once(dirname(__FILE__).'/config.php');
require_once(DEDEINC.'/typelink.class.php');
CheckPurview('a_New,a_AccNew');

if(empty($dopost)) $dopost = '';

if($dopost != 'save')
{
    
    include DedeInclude('templets/emp_add.htm');
    exit();
}
/*--------------------------------
function __save(){  }
-------------------------------*/
else if($dopost=='save')
{
//    require_once(DEDEINC.'/image.func.php');
//    require_once(DEDEINC.'/oxwindow.class.php');
//


    if($depid==0)
    {
        ShowMsg('请指定部门！', '-1');
        exit();
    }

        $row = $dsql->GetOne("SELECT COUNT(*) AS dd FROM `#@__emp` WHERE empid = '$empid' ");
    if($row['dd']>0)
    {
        ShowMsg('<b><font color=red>员工编号已存在！</font></b>','-1');
         exit();
      
    }
   
	
	



    //对保存的内容进行处理
    $updatedate = time();









    //保存到表
    $query = "INSERT INTO `#@__emp`(empid,depid,empname,sex,face,updatedate)
    VALUES ('$empid','$depid','$empname','$sex','$picname','$updatedate');";
//echo $query;
    if(!$dsql->ExecuteNoneQuery($query))
    {
        ShowMsg("把数据保存到数据库表时出错。","javascript:;");
        exit();
    }


    //返回成功信息
    $msg = "    　　请选择你的后续操作：
    <a href='emp_add.php?depid=$depid'><u>继续添加</u></a>
    &nbsp;&nbsp;
   
    <a href='emp_list.php?depid=$depid'><u>员工管理</u></a>
    &nbsp;&nbsp;
    $backurl
  ";
    $msg = "<div style=\"line-height:36px;height:36px\">{$msg}</div>";

    $wintitle = '成功增加！';
    $wecome_info = '员工管理::增加员工';
    $win = new OxWindow();
    $win->AddTitle('成功增加：');
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow('hand', '&nbsp;', false);
    $win->Display();
}