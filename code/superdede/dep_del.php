<?php
/**
 * 删除部门
 *
 * @version        $Id: dep_del.php 1 14:31 12日Z tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__).'/config.php');

//检查权限许可
CheckPurview('t_Del,t_AccDel');
require_once(DEDEINC.'/typeunit.class.admin.php');
require_once(DEDEINC.'/oxwindow.class.php');
$id = trim(preg_replace("#[^0-9]#", '', $id));

//检查部门操作许可
CheckCatalog($id,"你无权删除本部门！");
if(empty($dopost)) $dopost='';
if($dopost=='ok')
{
    $ut = new TypeUnit();
    $ut->DelType($id);
    ShowMsg("成功删除一个部门！","dep_main.php");
    exit();
}
$dsql->SetQuery("SELECT depname FROM #@__dep WHERE id=".$id);
$row = $dsql->GetOne();
$wintitle = "删除部门确认";
$wecome_info = "<a href='dep_main.php'>部门管理</a> &gt;&gt; 删除部门确认";
$win = new OxWindow();
$win->Init('dep_del.php','js/blank.js','POST');
$win->AddHidden('id',$id);
$win->AddHidden('dopost','ok');
$win->AddTitle("你要确实要删除部门： [{$row['depname']}] 吗？");
$winform = $win->GetWindow('ok');
$win->Display();