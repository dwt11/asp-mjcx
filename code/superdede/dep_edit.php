<?php
/**
 * ���ű༭
 *
 * @version        $Id: dep_edit.php 1 14:31 12��Z tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/typelink.class.php");
if(empty($dopost)) $dopost = '';
$id = isset($id) ? intval($id) : 0;

//���Ȩ�����
CheckPurview('t_Edit,t_AccEdit');

//��鲿�Ų������
CheckCatalog($id, '����Ȩ���ı����ţ�');

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
        ShowMsg("���浱ǰ���Ÿ���ʱʧ�ܣ�����������������Ƿ�������⣡","-1");
        exit();
    }


    ShowMsg("�ɹ�����һ�����ţ�","dep_main.php");
    exit();
}//End Save Action


//��ȡ������Ϣ
$dsql->SetQuery("SELECT * FROM `#@__dep` WHERE id=$id");
$myrow = $dsql->GetOne();

PutCookie('lastdepid',GetTopid($id),3600*24,"/");

    include DedeInclude('templets/dep_edit.htm');
?>