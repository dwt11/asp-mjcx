<?php
if(!defined('DEDEINC'))
{
    exit("Request Error!");
}
/**
 * �������������ݱ�ǩ
 *
 * @version        $Id: loop.lib.php 1 9:29 6��Z tianya $
 * @package        Taglib
 
 */
 
/*>>dede>>
<name>����ѭ��</name>
<type>ȫ�ֱ��</type>
<for>V55,V56,V57</for>
<description>�������������ݱ�ǩ</description>
<demo>
{dede:loop table='dede_archives' sort='' row='4' if=''}
<a href='[field:arcurl/]'>[field:title/]</a>
{/dede:loop}
</demo>
<attributes>
    <iterm>table:��ѯ����</iterm> 
    <iterm>sort:����������ֶ�</iterm>
    <iterm>row:���ؽ��������</iterm>
    <iterm>if:��ѯ������</iterm>
</attributes> 
>>dede>>*/
 
require_once(DEDEINC.'/dedevote.class.php');
function lib_loop(&$ctag,&$refObj)
{
    global $dsql;
    $attlist="table|,tablename|,row|8,sort|,if|,ifcase|,orderway|desc";//(7.22 ����loop��ǩorderway���� by:����)
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);

    $innertext = trim($ctag->GetInnertext());
    $revalue = '';
    if(!empty($table)) $tablename = $table;

    if($tablename==''||$innertext=='') return '';
    if($if!='') $ifcase = $if;
    if($row!='')$limt=" LIMIT 0,$row";
    if($sort!='') $sort = " ORDER BY $sort $orderway ";
    if($ifcase!='') $ifcase=" WHERE $ifcase ";
    $dsql->SetQuery("SELECT * FROM $tablename $ifcase $sort $limt");
    $dsql->Execute();
    $ctp = new DedeTagParse();
    $ctp->SetNameSpace("field","[","]");
    $ctp->LoadSource($innertext);
    $GLOBALS['autoindex'] = 0;
    while($row = $dsql->GetArray())
    {
        $GLOBALS['autoindex']++;
        foreach($ctp->CTags as $tagid=>$ctag)
        {
                if($ctag->GetName()=='array')
                {
                        $ctp->Assign($tagid, $row);
                }
                else
                {
                    if( !empty($row[$ctag->GetName()])) $ctp->Assign($tagid,$row[$ctag->GetName()]); 
                }
        }
        $revalue .= $ctp->GetResult();
    }
    return $revalue;
}