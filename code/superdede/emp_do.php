<?php
/**
 * �ĵ�����
 *
 
 */
require_once(dirname(__FILE__).'/config.php');
if(empty($dopost))
{
    ShowMsg('�Բ�����ûָ�����в�����','-1');
    exit();
}
//$aid = isset($aid) ? preg_replace("#[^0-9]#", '', $aid) : '';

/*--------------------------
//�첽�ϴ�����ͼ
function uploadLitpic(){ }
---------------------------*/
 if($dopost=="uploadLitpic")
{
    $upfile = AdminUpload('litpic', 'imagelit',$empid );
    if($upfile=='-1')
    {
        $msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('��ûָ��Ҫ�ϴ����ļ����ļ���С�������ƣ�');
            </script>";
    }
    else if($upfile=='-2')
    {
        $msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('�ϴ��ļ�ʧ�ܣ�����ԭ��');
            </script>";
    }
    else if($upfile=='0')
    {
        $msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('�ļ����Ͳ���ȷ��');
            </script>";
    }
    else
    {
        
                 $msg = "<script language='javascript'>
                    parent.document.getElementById('uploadwait').style.display = 'none';
                    parent.document.getElementById('picname').value = '{$upfile}';
                    if(parent.document.getElementById('divpicview'))
                    {
                        parent.document.getElementById('divpicview').style.width = '295px';
                        parent.document.getElementById('divpicview').style.height = '413px';
                        parent.document.getElementById('divpicview').innerHTML = \"<img src='{$upfile}' width='295' height='413' />\";
                    }
                </script>";
        
    }
    echo $msg;
    exit();
}
    //����û����Ƿ����
else    if($dopost=="checkempid")
    {
        AjaxHead();
        $msg = '';
       $row = $dsql->GetOne("SELECT COUNT(*) AS dd FROM `#@__emp` WHERE empid = '$empid' ");
    if($row['dd']>0)
    {
        $msg="<b><font color='red'>Ա������Ѵ��ڣ�</font></b>";
       
    }
	
	
        echo $msg;
        exit();
    }

?>