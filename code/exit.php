<?php
/**
 * �˳�
 *
 * @version        $Id: exit.php 1 19:09 12��Z tianya $
 * @package        Administrator
 
 */
require_once(dirname(__FILE__).'/include/common.inc.php');
DropCookie('webIp');
    header('location:login.php');
