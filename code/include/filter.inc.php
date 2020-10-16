<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * ���˺��Ĵ����ļ�
 *
 * @version        $Id: filter.inc.php 1 15:59 5��Z tianya $
 * @package        Libraries
 
 */

/**
 *  ���˲��������
 *
 * @access    public
 * @param     string  $fk ���˼�
 * @param     string  $svar ����ֵ
 * @return    string
 */
function _FilterAll($fk, &$svar)
{
    global $cfg_notallowstr,$cfg_replacestr;
    if( is_array($svar) )
    {
        foreach($svar as $_k => $_v)
        {
            $svar[$_k] = _FilterAll($fk,$_v);
        }
    }
    else
    {
        if($cfg_notallowstr!='' && preg_match("#".$cfg_notallowstr."#i", $svar))
        {
            ShowMsg(" $fk has not allow words!",'-1');
            exit();
        }
        if($cfg_replacestr!='')
        {
            $svar = preg_replace('/'.$cfg_replacestr.'/i', "***", $svar);
        }
    }
    return $svar;
}

/* ��_GET,_POST,_COOKIE���й��� */
foreach(Array('_GET','_POST','_COOKIE') as $_request)
{
    foreach($$_request as $_k => $_v)
    {
        ${$_k} = _FilterAll($_k,$_v);
    }
}