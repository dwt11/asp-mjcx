<?php
/**
 * ����
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
        ShowMsg('��ָ�����ţ�', '-1');
        exit();
    }

        $row = $dsql->GetOne("SELECT COUNT(*) AS dd FROM `#@__emp` WHERE empid = '$empid' ");
    if($row['dd']>0)
    {
        ShowMsg('<b><font color=red>Ա������Ѵ��ڣ�</font></b>','-1');
         exit();
      
    }
   
	
	



    //�Ա�������ݽ��д���
    $updatedate = time();









    //���浽��
    $query = "INSERT INTO `#@__emp`(empid,depid,empname,sex,face,updatedate)
    VALUES ('$empid','$depid','$empname','$sex','$picname','$updatedate');";
//echo $query;
    if(!$dsql->ExecuteNoneQuery($query))
    {
        ShowMsg("�����ݱ��浽���ݿ��ʱ����","javascript:;");
        exit();
    }


    //���سɹ���Ϣ
    $msg = "    ������ѡ����ĺ���������
    <a href='emp_add.php?depid=$depid'><u>�������</u></a>
    &nbsp;&nbsp;
   
    <a href='emp_list.php?depid=$depid'><u>Ա������</u></a>
    &nbsp;&nbsp;
    $backurl
  ";
    $msg = "<div style=\"line-height:36px;height:36px\">{$msg}</div>";

    $wintitle = '�ɹ����ӣ�';
    $wecome_info = 'Ա������::����Ա��';
    $win = new OxWindow();
    $win->AddTitle('�ɹ����ӣ�');
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow('hand', '&nbsp;', false);
    $win->Display();
}