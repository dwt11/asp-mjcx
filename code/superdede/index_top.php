<?php
/**
 * 管理后台顶部
 *
 * @version        $Id: index_top.php 1 8:48 13日Z tianya $
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
