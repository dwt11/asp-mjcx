<?php
/**
 * ��ѯ��ǰ������Ŀ�����ı���Ϣ
 *
 * @version        $Id: sonchannel.lib.php 1 9:29 6��Z tianya $
 * @package        Taglib
 
 */
 
/*>>dede>>
<name>�Ӳ��ű�ǩ</name>
<type>ȫ�ֱ��</type>
<for>V55,V56,V57</for>
<description>�Ӳ��ŵ��ñ�ǩ</description>
<demo>
{dede:sonchannel}
<a href='[field:typeurl/]'>[field:typename/]</a>
{/dede:sonchannel}
</demo>
<attributes>
    <iterm>row:������Ŀ</iterm> 
    <iterm>col:Ĭ�ϵ�����ʾ</iterm>
    <iterm>nosonmsg:û��ָ��ID�Ӳ�����ʾ����Ϣ����</iterm>
</attributes> 
>>dede>>*/
 
function lib_tablelist(&$ctag,&$refObj)
{
    global $team_id; //��ȡ�˱���ֶ�
    global $teamtype; //��ȡ�˱���ֶ�
	global $dsql;

    $attlist = "row|100,if|,ifcase|";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $innertext = $ctag->GetInnerText();
	//dump($innertext);

     if($if!='') $ifcase = $if;
    if($row!='')$limt=" LIMIT 0,$row";
    if($ifcase!='') $ifcase=" and $ifcase ";
   
    $allfield=Getallfield($team_id);  //��������ֶ�
    $sql = "SELECT t_name_page,t_name,t_id,web_show,web_edit  from #@__team_datebase_table WHERE team_id='$team_id'  $ifcase  ORDER BY t_name ASC $lim ";
    $dsql->SetQuery($sql);
    $dsql->Execute();
    $ctp = new DedeTagParse();
    $ctp->SetNameSpace("field","[","]");
    $ctp->LoadSource($innertext);
    $GLOBALS['autoindex'] = 0;
	//$GLOBALS['t_name']=$t_name;
         //    dump($ctp->CTags) ;
	
		 	
	
	    while($row = $dsql->GetArray())
    {
       //dump($GLOBALS['autoindex']);
		 
		  //��ô˱�������ֶ�,LISTservlet.JAVA�ļ���
		  $row['major_key']=Gettablemajor_key($row['t_id']);
		  $row['allfield']=$allfield[$row['t_id']];


		 
		   $row['listurl']=GetTableFilename($row['t_id'],'list','1');//�б����ַ,JSPҳ��ʹ��
		 
		   
		   $row['filename_begin_rule']=GetTableFilename($row['t_id'],'','');//��JSP��ĿdelServlet����ʹ��
		   //�˵���ʹ��MENU//SSH��Ŀʹ��
		   if($teamtype==6)$row['listurl']="<%=path %>/".$row['filename_begin_rule']."/".$row['filename_begin_rule']."!".$row['filename_begin_rule']."List.do";
		   //SSH struts.xml�ļ���ʹ��
		    $row['listurl_struts']=GetTableFilename($row['t_id'],'list','1');
		  
		  
		  
		  
		  
		   $row['addurl']=GetTableFilename($row['t_id'],'add','1');//����ҳ��ַ
		   $row['editurl']=GetTableFilename($row['t_id'],'edit','1');//����ҳ��ַ
		   $row['addeditservlet']=GetTableFilename($row['t_id'],'','');//JSP��Ŀ�� WEB.XML�ļ��еĶ�������
		   $row['index']=$GLOBALS['autoindex']+1;//���ڲ˵���������ʾ��ͬ��ͼ��
	//dump($row['addeditServlet']);
		
		
		
		
		
		
	    foreach($ctp->CTags as $tagid=>$ctag)
        {
			
			   if($ctag->GetName()=='array')
                {
                        $ctp->Assign($tagid, $row);
                  // dump(sdfds);
				}
                else
                {
                    if( !empty($row[$ctag->GetName()])) $ctp->Assign($tagid,$row[$ctag->GetName()]); 
						//dump($tagid."jjjjjjj".$row[$ctag->GetName()]);
                }
        }
         $GLOBALS['autoindex']++;  //�˾������FOREACH�⣬���������autoindex��������
      // dump($revalue .= $ctp->GetResult());
  $revalue .= $ctp->GetResult();
    }

	
	return $revalue;
}