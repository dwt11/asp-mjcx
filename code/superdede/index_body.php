<?php
/**
 * �����̨��ҳ����
 *
 * @version        $Id: index_body.php 1 11:06 13��Z tianya $
 * @package        Administrator
 
 */
require(dirname(__FILE__).'/config.php');
if(!file_exists($myIcoFile)) $myIcoFile = $defaultIcoFile;

//Ĭ����ҳ
if(empty($dopost))
{
 
        include DedeInclude('templets/index_body.htm');
    exit();
}


?>
       
    

