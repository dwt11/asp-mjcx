<?php
/**
 * ɾ������
 *
 * @version        $Id: dep_del.php 1 14:31 12��Z tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__).'/config.php');

//���Ȩ�����
CheckPurview('t_Del,t_AccDel');
require_once(DEDEINC.'/typeunit.class.admin.php');
require_once(DEDEINC.'/oxwindow.class.php');
$id = trim(preg_replace("#[^0-9]#", '', $id));

//��鲿�Ų������
CheckCatalog($id,"����Ȩɾ�������ţ�");
if(empty($dopost)) $dopost='';
if($dopost=='ok')
{
    $ut = new TypeUnit();
    $ut->DelType($id);
    ShowMsg("�ɹ�ɾ��һ�����ţ�","dep_main.php");
    exit();
}
$dsql->SetQuery("SELECT depname FROM #@__dep WHERE id=".$id);
$row = $dsql->GetOne();
$wintitle = "ɾ������ȷ��";
$wecome_info = "<a href='dep_main.php'>���Ź���</a> &gt;&gt; ɾ������ȷ��";
$win = new OxWindow();
$win->Init('dep_del.php','js/blank.js','POST');
$win->AddHidden('id',$id);
$win->AddHidden('dopost','ok');
$win->AddTitle("��ҪȷʵҪɾ�����ţ� [{$row['depname']}] ��");
$winform = $win->GetWindow('ok');
$win->Display();