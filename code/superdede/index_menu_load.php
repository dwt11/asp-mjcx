<?php
/**
 * ÔØÈë²Ëµ¥
 *
 * @version        $Id: index_menu_load.php 1 8:48 13ÈÕZ tianya $
 * @package        Administrator
 */
require_once(dirname(__FILE__).'/config.php');
AjaxHead();
if($openitem != 100)
{
    require(dirname(__FILE__).'/inc/inc_menu.php');
    require(DEDEADMIN.'/inc/inc_menu_func.php');
    GetMenus($cuserLogin->getUserRank(),'main');
    exit();
}
else
{
    $openitem = 0;
    require(dirname(__FILE__).'/inc/inc_menu_module.php');
    require(DEDEADMIN.'/inc/inc_menu_func.php');
    GetMenus($cuserLogin->getUserRank(),'module');
    exit();
}