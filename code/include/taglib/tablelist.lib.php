<?php
/**
 * 查询当前生成项目包含的表信息
 *
 * @version        $Id: sonchannel.lib.php 1 9:29 6日Z tianya $
 * @package        Taglib
 
 */
 
/*>>dede>>
<name>子部门标签</name>
<type>全局标记</type>
<for>V55,V56,V57</for>
<description>子部门调用标签</description>
<demo>
{dede:sonchannel}
<a href='[field:typeurl/]'>[field:typename/]</a>
{/dede:sonchannel}
</demo>
<attributes>
    <iterm>row:返回数目</iterm> 
    <iterm>col:默认单列显示</iterm>
    <iterm>nosonmsg:没有指定ID子部门显示的信息内容</iterm>
</attributes> 
>>dede>>*/
 
function lib_tablelist(&$ctag,&$refObj)
{
    global $team_id; //获取此表的字段
    global $teamtype; //获取此表的字段
	global $dsql;

    $attlist = "row|100,if|,ifcase|";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $innertext = $ctag->GetInnerText();
	//dump($innertext);

     if($if!='') $ifcase = $if;
    if($row!='')$limt=" LIMIT 0,$row";
    if($ifcase!='') $ifcase=" and $ifcase ";
   
    $allfield=Getallfield($team_id);  //表的所有字段
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
		 
		  //获得此表的所有字段,LISTservlet.JAVA文件用
		  $row['major_key']=Gettablemajor_key($row['t_id']);
		  $row['allfield']=$allfield[$row['t_id']];


		 
		   $row['listurl']=GetTableFilename($row['t_id'],'list','1');//列表面地址,JSP页面使用
		 
		   
		   $row['filename_begin_rule']=GetTableFilename($row['t_id'],'','');//在JSP项目delServlet中有使用
		   //菜单中使用MENU//SSH项目使用
		   if($teamtype==6)$row['listurl']="<%=path %>/".$row['filename_begin_rule']."/".$row['filename_begin_rule']."!".$row['filename_begin_rule']."List.do";
		   //SSH struts.xml文件中使用
		    $row['listurl_struts']=GetTableFilename($row['t_id'],'list','1');
		  
		  
		  
		  
		  
		   $row['addurl']=GetTableFilename($row['t_id'],'add','1');//增加页地址
		   $row['editurl']=GetTableFilename($row['t_id'],'edit','1');//增加页地址
		   $row['addeditservlet']=GetTableFilename($row['t_id'],'','');//JSP项目里 WEB.XML文件中的动作名称
		   $row['index']=$GLOBALS['autoindex']+1;//用于菜单计数，显示不同的图标
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
         $GLOBALS['autoindex']++;  //此句必须在FOREACH外，否则会引起autoindex计数错误
      // dump($revalue .= $ctp->GetResult());
  $revalue .= $ctp->GetResult();
    }

	
	return $revalue;
}