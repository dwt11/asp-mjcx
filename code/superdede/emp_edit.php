<?php
/**
 * �༭
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

    //��ȡ�鵵��Ϣ
    $query = "SELECT *
    FROM `#@__emp` arc
    WHERE id='$id' ";
    $arcRow = $dsql->GetOne($query);
    if(!is_array($arcRow))
    {
        ShowMsg("��ȡ������Ϣ����!","-1");
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
        ShowMsg('��ָ�����ţ�', '-1');
        exit();
    }

    
	
	



    //�Ա�������ݽ��д���
    $updatedate = time();
    

    //�������ݿ��SQL���
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
		ShowMsg('�������ݿ��ʱ��������',-1);
        exit();
    }
    
  
 
  
  
    //���سɹ���Ϣ
    $msg = "
    ������ѡ����ĺ���������
   
    <a href='emp_edit.php?id=".$id."'><u>����</u></a> 
    &nbsp;&nbsp; 
    <a href='emp_list.php?depid=$depid'><u>Ա������</u></a>
    &nbsp;&nbsp;
    
    $backurl
    ";
  
  $wintitle = "�ɹ����ģ�";
    $wecome_info = 'Ա������::����Ա��';
    $win = new OxWindow();
    $win->AddTitle("�ɹ����ģ�");
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow("hand","&nbsp;",false);
    $win->Display();
}