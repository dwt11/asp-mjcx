<?php
/**
 * ��̨����˵���
 *
 * @version        $Id: inc_menu.php 1 10:32 21��Z tianya $
 * @package        Administrator
 */
require_once(dirname(__FILE__)."/../config.php");

/*//����ɷ���Ƶ��
$addset = '';

//�����õ�����ģ��
if($cfg_admin_channel = 'array' && count($admin_catalogs) > 0)
{
    $admin_catalog = join(',', $admin_catalogs);
    $dsql->SetQuery(" SELECT channeltype FROM `#@__arctype` WHERE id IN({$admin_catalog}) GROUP BY channeltype ");
}
else
{
    $dsql->SetQuery(" SELECT channeltype FROM `#@__arctype` GROUP BY channeltype ");
}
$dsql->Execute();
$candoChannel = '';
while($row = $dsql->GetObject())
{
    $candoChannel .= ($candoChannel=='' ? $row->channeltype : ','.$row->channeltype);
}
if(empty($candoChannel)) $candoChannel = 1;
$dsql->SetQuery("SELECT id,typename,addcon,mancon FROM `#@__channeltype` WHERE id IN({$candoChannel}) AND id<>-1 AND isshow=1 ORDER BY id ASC");
$dsql->Execute();
while($row = $dsql->GetObject())
{
    $addset .= "  <m:item name='{$row->typename}' ischannel='1' link='{$row->mancon}?channelid={$row->id}' linkadd='{$row->addcon}?channelid={$row->id}' channelid='{$row->id}' rank='' target='main' />\r\n";
}
//////////////////////////

$adminMenu1 = $adminMenu2 = '';
if($cuserLogin->getUserType() >= 10)
{
    $adminMenu1 = "<m:top item='1_' name='Ƶ��ģ��' display='block' rank='t_List,t_AccList,c_List,temp_One'>
  <m:item name='����ģ�͹���' link='mychannel_main.php' rank='c_List' target='main' />
  <m:item name='��ҳ�ĵ�����' link='templets_one.php' rank='temp_One' target='main'/>
  <m:item name='����������' link='stepselect_main.php' rank='c_Stepseclect' target='main' />
  <m:item name='�����б����' link='freelist_main.php' rank='c_List' target='main' />
  <m:item name='�Զ����' link='diy_main.php' rank='c_List' target='main' />
</m:top>
";
*/


$adminMenu = "<m:top item='1_' name='ϵͳ����' display='none' rank='sys_User,sys_Group,sys_Edit,sys_Log,sys_Data'>
  <m:item name='ϵͳ��������' link='sys_info.php' rank='sys_Edit' target='main' />
  <m:item name='ϵͳ�û�����' link='sys/sys_admin_user.php' rank='sys_User' target='main' />
  <m:item name='�ּ�Ȩ���趨' link='sys_group.php' rank='sys_Group' target='main' />
  <m:item name='ϵͳ��־����' link='log_list.php' rank='sys_Log' target='main' />
  <m:item name='ϵͳ���ܹ���' link='plus_main.php' rank='10' target='main' />
  <m:item name='����������' link='soft_config.php' rank='sys_SoftConfig' target='main' />
  <m:item name='װ�ù���' link='article_string_mix.php' rank='sys_StringMix' target='main' />
  <m:item name='�豸�������' link='article_template_rand.php' rank='sys_StringMix' target='main' />
  <m:item name='����������' link='sys_task.php' rank='sys_Task' target='main' />
  <m:item name='����ҳ��������' link='sys_data.php' rank='sys_Data' target='main' />
  <m:item name='�ܼ�̨�˷������[S]' link='sys_safetest.php' rank='sys_verify' target='main' />
  <m:item name='�����������' link='sys_safe.php' rank='sys_verify' target='main' />
  <m:item name='�����ֵ�' link='sys_info_mark.php' rank='sys_Edit' target='main' />
</m:top>

    ";
/*}
$remoteMenu = ($cfg_remote_site=='Y')? "<m:item name='Զ�̷�����ͬ��' link='makeremote_all.php' rank='sys_ArcBatch' target='main' />" : "";
*/
   global $dsql;
  //�������˵�
	$menusMain = '';
	$dsql->SetQuery("SELECT * from `#@__sys_left_class` where zclass=0 and isput=true order by orderby asc ");
	$dsql->Execute();
	
	while($row = $dsql->GetObject()) 
	{
		//�����Ȩ������ֱ�Ӿ���������ʾ����,ֻ����ʾ����
		$menusMain .= "<m:top  item='1_' name='".$row->plusname."' display='none' rank='".$row->plusname."'>";
		
		$dsql1 = clone $dsql;
		$dsql1->SetQuery("SELECT * from `#@__sys_left_class` where zclass='".$row->aid."' and isput=true order by orderby asc ");
		$dsql1->Execute();
		
		while($row1 = $dsql1->GetObject()) 
		{
			$menusMain .="  <m:item name='".$row1->plusname."' link='".$row1->menustring."'   rank='".$row1->purviewsName."' target='main' />";
		}


		$menusMain .="</m:top>\r\n";
		
	}
	


$menusMain .= "$adminMenu";
