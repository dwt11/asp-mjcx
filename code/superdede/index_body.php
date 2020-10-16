<?php
/**
 * 管理后台首页主体
 *
 * @version        $Id: index_body.php 1 11:06 13日Z tianya $
 * @package        Administrator
 
 */
require(dirname(__FILE__).'/config.php');
if(!file_exists($myIcoFile)) $myIcoFile = $defaultIcoFile;

//默认主页
if(empty($dopost))
{
 
        include DedeInclude('templets/index_body.htm');
    exit();
}


?>
       
    

