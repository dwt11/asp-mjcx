<?php
/**
 * 部门编辑
 *
 * @version        $Id: dep_edit.php 1 14:31 12日Z tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/typelink.class.php");
if(empty($dopost)) $dopost = '';
$id = isset($id) ? intval($id) : 0;

//检查权限许可
CheckPurview('t_Edit,t_AccEdit');

//检查部门操作许可
CheckCatalog($id, '你无权更改本部门！');

/*-----------------------
function action_save()
----------------------*/
if($dopost=="save")
{
    
    $upquery = "UPDATE `#@__dep` SET
     depname='$depname' 
    WHERE id='$id' ";

    if(!$dsql->ExecuteNoneQuery($upquery))
    {
        ShowMsg("保存当前部门更改时失败，请检查你的输入资料是否存在问题！","-1");
        exit();
    }


    ShowMsg("成功更改一个部门！","dep_main.php");
    exit();
}//End Save Action


//读取部门信息
$dsql->SetQuery("SELECT * FROM `#@__dep` WHERE id=$id");
$myrow = $dsql->GetOne();

PutCookie('lastdepid',GetTopid($id),3600*24,"/");

    include DedeInclude('templets/dep_edit.htm');
?>