<?php
/**
 * 文档处理
 *
 
 */
require_once(dirname(__FILE__).'/config.php');
if(empty($dopost))
{
    ShowMsg('对不起，你没指定运行参数！','-1');
    exit();
}
//$aid = isset($aid) ? preg_replace("#[^0-9]#", '', $aid) : '';

/*--------------------------
//异步上传缩略图
function uploadLitpic(){ }
---------------------------*/
 if($dopost=="uploadLitpic")
{
    $upfile = AdminUpload('litpic', 'imagelit',$empid );
    if($upfile=='-1')
    {
        $msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('你没指定要上传的文件或文件大小超过限制！');
            </script>";
    }
    else if($upfile=='-2')
    {
        $msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('上传文件失败，请检查原因！');
            </script>";
    }
    else if($upfile=='0')
    {
        $msg = "<script language='javascript'>
                parent.document.getElementById('uploadwait').style.display = 'none';
                alert('文件类型不正确！');
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
    //检查用户名是否存在
else    if($dopost=="checkempid")
    {
        AjaxHead();
        $msg = '';
       $row = $dsql->GetOne("SELECT COUNT(*) AS dd FROM `#@__emp` WHERE empid = '$empid' ");
    if($row['dd']>0)
    {
        $msg="<b><font color='red'>员工编号已存在！</font></b>";
       
    }
	
	
        echo $msg;
        exit();
    }

?>