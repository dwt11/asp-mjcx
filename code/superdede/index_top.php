<?php
/**
 * �����̨����
 *
 * @version        $Id: index_top.php 1 8:48 13��Z tianya $
 * @package        Administrator
 
 */
require(dirname(__FILE__)."/config.php");
if($cuserLogin->adminStyle=='dedecms')
{
    include DedeInclude('templets/index_top1.htm');
}
else
{
    include DedeInclude('templets/index_top2.htm');
}
