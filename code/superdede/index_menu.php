<?php
/**
 * ІЛµҐПо
 *
 * @version        $Id: index_menu.php 1 11:06 13ИХZ tianya $
 * @package        Administrator
 
 */
require(dirname(__FILE__).'/config.php');
require(DEDEADMIN.'/inc/inc_menu.php');
require(DEDEADMIN.'/inc/inc_menu_func.php');
$openitem = (empty($openitem) ? 1 : $openitem);
include DedeInclude('templets/index_menu2.htm');
