<?php
/**
 * ��ȡdedeϵͳ��ʾ��Ϣ
 *
 * @version        $Id: getdedesysmsg.php 1 11:06 13��Z tianya $
 * @package        Administrator
 */
require_once(dirname(__FILE__).'/config.php');
require_once(DEDEINC.'/dedehttpdown.class.php');
AjaxHead();
$dhd = new DedeHttpDown();
$dhd->OpenUrl('http://www./officialinfo.html');
$str = trim($dhd->GetHtml());
$dhd->Close();
if($cfg_soft_lang=='utf-8') $str = gb2utf8($str);
echo $str;
