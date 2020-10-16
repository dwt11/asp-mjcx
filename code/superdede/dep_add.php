<?php
/**
 * 部门添加
 *
 * @version        $Id: dep_add.php 1 14:31 12日Z tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__)."/config.php");
//require_once(DEDEINC."/typelink.class.php");

if(empty($listtype)) $listtype='';
if(empty($dopost)) $dopost = '';

$id = empty($id) ? 0 :intval($id);
$reid = empty($reid) ? 0 :intval($reid);
$nid = 'article';



if(empty($myrow)) $myrow = array();


/*---------------------
function action_save(){ }
---------------------*/
 if($dopost=='save')
{
    
    
    $in_query = "INSERT INTO `#@__dep`(reid,sortrank,depname)
    VALUES('$reid','$sortrank','$depname')";

    if(!$dsql->ExecuteNoneQuery($in_query))
    {
        ShowMsg("保存数据时失败，请检查你的输入资料是否存在问题！","-1");
        exit();
    }
    UpDateCatCache();
    if($reid>0)
    {
        PutCookie('lastdepid',GetTopid($reid),3600*24,'/');
    }
    ShowMsg("成功创建一个部门！","dep_main.php");
    exit();

}//End dopost==save


include DedeInclude('templets/dep_add.htm');