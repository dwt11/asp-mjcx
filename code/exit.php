<?php
/**
 * ÍË³ö
 *
 * @version        $Id: exit.php 1 19:09 12ÈÕZ tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__).'/include/common.inc.php');
DropCookie('webIp');
    header('location:login.php');
