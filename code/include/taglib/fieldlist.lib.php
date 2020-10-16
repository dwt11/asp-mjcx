<?php
/**
 * 查询当前生成表包含的字段信息
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
 
function lib_fieldlist(&$ctag,&$refObj)
{
    global $t_id; //获取此表的字段
	global $t_name; //当类型为JSP时，此为获取编辑字段值时的名称前辍
	global $teamtype; //项目类型
	global $dsql;
	global $web_templets_name; //项目的WEB页面模板 ，用于在列表页模板的搜索框中，获取搜索按钮的样式，在fieldlist.php中调用 
    $attlist = "row|100,if|,ifcase|,issearch|0,iselementvalue|0,idischeckbox|0";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);
    $innertext = $ctag->GetInnerText();

     if($if!='') $ifcase = $if;
    if($row!='')$limt=" LIMIT 0,$row";
    if($ifcase!='') $ifcase=" and $ifcase ";
   
   $sql = "SELECT *
        FROM `#@__team_datebase_field` WHERE t_id='$t_id'  $ifcase  ORDER BY id ASC $lim ";
	
	$dsql->SetQuery($sql);
    $dsql->Execute();
    $ctp = new DedeTagParse();
    $ctp->SetNameSpace("field","[","]");
    $ctp->LoadSource($innertext);
	//dump($sql);
    $GLOBALS['autoindex'] = 0;
	//$GLOBALS['t_name']=$t_name;
         //    dump($ctp->CTags) ;
 		   $filename_begin_rule=GetTableFilename($t_id,'','');//JSP项目里 前辍名称
		  // dump($filename_begin_rule);
   while($row = $dsql->GetArray())
    {
       //dump($GLOBALS['autoindex']);
		 
		 
		 
		 /* a、取值的语句代码
		 // （1）JSP项目用
		  // $row['index']=$GLOBALS['autoindex'];  //索引值
		  //dump( $teamtype);
		  */
	   $row['filename_begin_rule']=$filename_begin_rule;
		   if( $teamtype=='10')
		   {
			   $row['edit_valuename']="<%=".$filename_begin_rule.".get(".$GLOBALS['autoindex'].")%>";//编辑页面字段取值用的名称
			   $row['list_valuename']="<%=alRow3.get(".$GLOBALS['autoindex'].")  %>";   //列表页面字段取值用的名称
				//如果是主键并idischeckbox为1刚输出多选框
				if($row['major_key']=='1'&&$idischeckbox==1)$row['list_valuename']="<input type='checkbox'  value='<%=alRow3.get(".$GLOBALS['autoindex'].")  %>' name='".$row['field_name']."' />";   
			  //日期显示缩短字符
			   if($row['field_type']=='datetime')$row['edit_valuename']="<%=".$filename_begin_rule.".get(".$GLOBALS['autoindex'].").toString().substring(0,10)%>";
			   //日期显示 列表页面字段取值用的名称
			   if($row['field_type']=='datetime')$row['list_valuename']="<%=alRow3.get(".$GLOBALS['autoindex'].").toString().substring(0,10)  %>";   
	    
				//如果字段为索引别的表则输出以下,列表页面字段取值用
			   if($row['relevance_t_id']>0)$row['list_valuename']="<%
				  ArrayList ".GetTableFilename($row['relevance_t_id'],'','')." = (ArrayList)request.getAttribute(\"".GetTableFilename($row['relevance_t_id'],'','')."\");
				for(int j = 0;j < ".GetTableFilename($row['relevance_t_id'],'','').".size();j++){
							ArrayList ".GetTableFilename($row['relevance_t_id'],'','')."Row = (ArrayList)".GetTableFilename($row['relevance_t_id'],'','').".get(j);
							if(".GetTableFilename($row['relevance_t_id'],'','')."Row.get(0).equals(alRow3.get(".$GLOBALS['autoindex']."))){
								%><%=".GetTableFilename($row['relevance_t_id'],'','')."Row.get(1) %><%
								break;
							}
						}
						 %>";   
		   }
		 // （2）SSH项目用
		   if( $teamtype=='6')
		   {
			   $row['edit_valuename']=$filename_begin_rule.".".$row['field_name'];   //增加和编辑页面字段名称
			   $row['list_valuename']="\${".$row['field_name']."}";                //列表页面字段取值用的名称
				//如果是主键并idischeckbox为1刚输出多选框
				if($row['major_key']=='1'&&$idischeckbox==1)$row['list_valuename']="<input type='checkbox'  value='\${".$row['field_name']."}' name='".$row['field_name']."' />";   
			  //日期显示缩短字符
			   if($row['field_type']=='datetime')$row['edit_valuename']=$row['edit_valuename'];
			   //日期显示 列表页面字段取值用的名称
			   if($row['field_type']=='datetime')$row['list_valuename']=$row['list_valuename'];   
	    
				//如果字段为索引别的表则输出以下,列表页面字段取值用
			   if($row['relevance_t_id']>0)$row['list_valuename']="<s:if test='%{".GetTableFilename($row['relevance_t_id'],'','')."!= null}'>
			    			\${".GetTableFilename($row['relevance_t_id'],'','').".".Getnextfieldname($row['relevance_t_id'])."}
			    		</s:if>
			    		<s:else>
			    			无
			    		</s:else>"; 
			   //SSH项目中，如果表中有索引别的表，则输出此字段为这个表的类型 AdminEntity.java模板中用				
			  if($row['relevance_t_id']>0)$row['relevance_t_name']=GetTableFilename($row['relevance_t_id']);
  //dump($row['field_type']);
		   }

		//dump($row['list_valuename']);

         //(2)PHP 项目
		 //还未做
		
		
		
		
		
		
		
		
		
		
		
		
		
		if($row['field_name_page']=="")$row['field_name_page']="&nbsp;";
		//b、表单的元素，根据字段的关联属性、是否固化、是否编辑器来判断元素的输出
		//如果不等于1，则输出表单元素的获取值 的代码
		
	
		
		if($iselementvalue=="0"){
			if($teamtype==10)
			{    
			
				  //普通文件输入框
				  $row['edit_element']="<input name='".$row['field_name']."' type='text' value='".$row['edit_valuename']."'  />";
				  //如果是主键则输出隐藏INPUT
				  if($row['major_key']=='1')$row['edit_element']="请填写以下内容<input name='".$row['field_name']."' type='hidden' value='".$row['edit_valuename']."'  />";
				  //内容域，？？？此处用：如果字段类型为MSSQL的'TEXT'类型则输出编辑器，$row['use_editor']字段后期改为编辑器的样式
				  if($row['field_type']=='text')$row['edit_element']="<TEXTAREA  NAME='".$row['field_name']."' ROWS='20' COLS='70'>".$row['edit_valuename']."</TEXTAREA>";
			
			
				/*此段没有用了  //日期输入,mssql--datetime
				  //要匹配日期框的调用格式，每套模板都不一样
				  if($row['field_type']=='datetime'&&$web_templets_name=="4UTF-BLUE/")$row['edit_element']="<input  name='".$row['edit_valuename']."'  id='".$row['field_name']."'
				      value='".$row['edit_valuename']."'  style='border: 1px solid black;' 
					type='text' readonly='readonly' 
					 onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\"/>";
				  if($row['field_type']=='datetime'&&$web_templets_name=="2GB-GREEN/")$row['edit_element']="<input type='text' name='".$row['field_name']."'  readonly='readonly' onFocus='calendar()' value='".$row['edit_valuename']."' />";
		  */
		  
		  
				  //固化SELECT
				  //$row['edit_element']="";
		  
		  
		  
				  //索引别的表SELECT,
				  //---------此段要优化，索引别的表时，要在数据库字段管理里，加上索引别的表的，哪个字段.默认为1，也就是第二个字段-------
				  if($teamtype==10&&$row['relevance_t_id']>0)$row['edit_element']="<jsp:include flush='true' page='/servlet/ListServlet'/>
									  <select name='".$row['field_name']."'>
					  <%
				  ArrayList ".GetTableFilename($row['relevance_t_id'],'','')." = (ArrayList)request.getAttribute(\"".GetTableFilename($row['relevance_t_id'],'','')."\");
					 for(int i = 0;i < ".GetTableFilename($row['relevance_t_id'],'','').".size();i++){
						  ArrayList alRow = (ArrayList)".GetTableFilename($row['relevance_t_id'],'','').".get(i);
					  %>
					   <option value='<%=alRow.get(0)%>' <%if (alRow.get(0)!= null &&alRow.get(0).equals(".$filename_begin_rule.".get(".$GLOBALS['autoindex']."))){%> selected <%}%>><%=alRow.get(1)%></option>
					   <%}%>
					  </select>";
					  
			}
			
			
			
			if($teamtype==6)
			{     //普通文件输入框<input type="text" class="input1" name="employee.empName" id="empName" Tip="姓名不能为空,且不能大于20字!"  Exp="^[\s|\S]{1,20}$"/>
				  if($row['null_value']>0)$tip="Tip='".$row['field_name_page']."不能为空'  usage='notempty'";
				  $row['edit_element']="<input name='".$row['edit_valuename']."'  id='".$row['field_name']."' type='text' $tip value='\${".$row['edit_valuename']."}'/>";
				  //如果是主键则输出隐藏INPUT
				  if($row['major_key']=='1')$row['edit_element']="请填写以下内容<input name='".$row['edit_valuename']."'  value='\${".$row['edit_valuename']."}' type='hidden' />";
				  //内容域，？？？此处用：如果字段类型为MSSQL的'TEXT'类型则输出编辑器，$row['use_editor']字段后期改为编辑器的样式
				  if($row['field_type']=='text')$row['edit_element']="<textarea  name='".$row['edit_valuename']."'  id='".$row['field_name']."'  style='width:40px;'>\${".$row['edit_valuename']."}</textarea>";
			
			
			/*  引段没有用了	  //日期输入,mssql--datetime
				  //if( $teamtype=='10')$nowdate="SimpleDateFormat sdf = new SimpleDateFormat('yyyy-MM-dd');String nowdate = sdf.format(new Date())";
				 
				 
				 
				 //要匹配日期框的调用格式，每套模板都不一样
				  if($row['field_type']=='datetime'&&$web_templets_name=="4UTF-BLUE/")$row['edit_element']="<input  name='".$row['edit_valuename']."'  id='".$row['field_name']."'
				      value='".$row['edit_valuename']."'  style='border: 1px solid black;' 
					type='text' readonly='readonly' 
					 onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\"/>";
				  if($row['field_type']=='datetime'&&$web_templets_name=="2GB-GREEN/")$row['edit_element']="<input type='text' name='".$row['field_name']."'  readonly='readonly' onFocus='calendar()'  value='\${".$row['edit_valuename']."}' />";
		  
		  */
		  
				  //固化SELECT
				  //$row['edit_element']="";
		  
		  
		  
				  //索引别的表SELECT,
				  //---------此段要优化，索引别的表时，要在数据库字段管理里，加上索引别的表的，哪个字段.默认为1，也就是第二个字段-------
				  if($row['relevance_t_id']>0)$row['edit_element']="<select id=\"".$row['field_name']."\" name=\"".$row['field_name']."\" style=\"width: 150px\" Tip=\"请选择".$row['field_name_page']."!\" usage='notempty' >
				<option value=\"\">----请选择----</option>
        <s:iterator value='#request.".GetTableFilename($row['relevance_t_id'],'','')."s'>
                <option value='\${".Gettablemajor_key($row['relevance_t_id'])."}'> \${".Getnextfieldname($row['relevance_t_id'])."} </option>
              </s:iterator>
			</select>
   
			  ";
		
		
			}
			
				
		}
		//如果等于1，则不输出表单元素的获取值 的代码
		if($iselementvalue=="1"){
			


			if($teamtype==10)
			{     //普通文件输入框
				  $row['edit_element']="<input name='".$row['field_name']."' type='text'  />";
				  //如果是主键则输出隐藏INPUT
				  if($row['major_key']=='1')$row['edit_element']="请填写以下内容<input name='".$row['field_name']."' type='hidden' />";
				  //内容域，？？？此处用：如果字段类型为MSSQL的'TEXT'类型则输出编辑器，$row['use_editor']字段后期改为编辑器的样式
				  if($row['field_type']=='text')$row['edit_element']="<TEXTAREA  NAME='".$row['field_name']."' ROWS='20' COLS='70'></TEXTAREA>";
			/*此段没用了，直接取当前值	  //日期输入,mssql--datetime
				  //if( $teamtype=='10')$nowdate="SimpleDateFormat sdf = new SimpleDateFormat('yyyy-MM-dd');String nowdate = sdf.format(new Date())";
			//要匹配日期框的调用格式，每套模板都不一样
				  if($row['field_type']=='datetime'&&$web_templets_name=="2GB-GREEN/")$row['edit_element']="<input type='text' name='".$row['field_name']."'  readonly='readonly' onFocus='calendar()' value='' />";
			if($row['field_type']=='datetime'&&$web_templets_name=="4UTF-BLUE/")$row['edit_element']="
				    <input  name='".$row['field_name']."'  id='".$row['field_name']."'
				    value=''  style='border: 1px solid black;' 
					type='text' readonly='readonly' 
					 onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\"/>";
		  
		  */
		  
				  //固化SELECT
				  //$row['edit_element']="";
		  
		  
		  
				  //索引别的表SELECT,
				  //---------此段要优化，索引别的表时，要在数据库字段管理里，加上索引别的表的，哪个字段.默认为1，也就是第二个字段-------
				  if($row['relevance_t_id']>0)$row['edit_element']="<jsp:include flush='true' page='/servlet/ListServlet'/>
									  <select name='".$row['field_name']."'>
					  <%
				  ArrayList ".GetTableFilename($row['relevance_t_id'],'','')." = (ArrayList)request.getAttribute(\"".GetTableFilename($row['relevance_t_id'],'','')."\");
					 for(int i = 0;i < ".GetTableFilename($row['relevance_t_id'],'','').".size();i++){
						  ArrayList alRow = (ArrayList)".GetTableFilename($row['relevance_t_id'],'','').".get(i);
					  %>
					   <option value='<%=alRow.get(0)%>' ><%=alRow.get(1)%></option>
					   <%}%>
					  </select>";
		
		
			}

			if($teamtype==6)
			{     //普通文件输入框<input type="text" class="input1" name="employee.empName" id="empName" Tip="姓名不能为空,且不能大于20字!"  Exp="^[\s|\S]{1,20}$"/>
				  if($row['null_value']>0)$tip="Tip='".$row['field_name_page']."不能为空'  usage='notempty'";
				  $row['edit_element']="<input name='".$row['edit_valuename']."'  id='".$row['field_name']."' type='text' $tip />";
				  //如果是主键则输出隐藏INPUT
				  if($row['major_key']=='1')$row['edit_element']="请填写以下内容<input name='".$row['edit_valuename']."' type='hidden'  />";
				  //内容域，？？？此处用：如果字段类型为MSSQL的'TEXT'类型则输出编辑器，$row['use_editor']字段后期改为编辑器的样式
				  if($row['field_type']=='text')$row['edit_element']="<textarea  name='".$row['edit_valuename']."'  id='".$row['field_name']."'  style='width:40px;'></textarea>";
			/*	此段没有用了  //日期输入,mssql--datetime
				 
			//要匹配日期框的调用格式，每套模板都不一样
				  if($row['field_type']=='datetime'&&$web_templets_name=="2GB-GREEN/")$row['edit_element']="<input type='text' name='".$row['field_name']."'  readonly='readonly' onFocus='calendar()' value='' />";
			if($row['field_type']=='datetime'&&$web_templets_name=="4UTF-BLUE/")$row['edit_element']="
				    <input  name='".$row['edit_valuename']."'  id='".$row['field_name']."'
				    value=''  style='border: 1px solid black;' 
					type='text' readonly='readonly' 
					 onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\"/>";
		  
		  */
		  
				  //固化SELECT
				  //$row['edit_element']="";
		  
		  
		  
				  //索引别的表SELECT,
				  //---------此段要优化，索引别的表时，要在数据库字段管理里，加上索引别的表的，哪个字段.默认为1，也就是第二个字段-------
				   if($row['relevance_t_id']>0)$row['edit_element']="<select id=\"".$row['field_name']."\" name=\"".$row['field_name']."\" style=\"width: 150px\" Tip=\"请选择".$row['field_name_page']."!\" usage='notempty' >
				<option value=\"\">----请选择----</option>
        <s:iterator value='#request.".GetTableFilename($row['relevance_t_id'],'','')."s'>
                <option value='\${".Gettablemajor_key($row['relevance_t_id'])."}'> \${".Getnextfieldname($row['relevance_t_id'])."} </option>
              </s:iterator>
			</select>
			  ";
		
		
			}
	//	dump($row['field_type']);
		
		}
		
				//不分编辑还是新增 日期框都默认输出当前日期
		
		if($teamtype==10&&$row['field_type']=='datetime')
		{
			$row['edit_element']="
		 <%@ page import=\"java.util.Date\"%>　
		<%@ page import=\"java.text.SimpleDateFormat\"%>　
		<%SimpleDateFormat sdf = new SimpleDateFormat(\"yyyy-MM-dd\");String nowdate = sdf.format(new Date());%>
		<input type='hidden' name='".$row['field_name']."'  value='<%=nowdate%>' />";
		}

		
		
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
       //dump($revalue .= $ctp->GetResult());
  $revalue .= $ctp->GetResult();
    }
	
    //列表页面如果字段中有要搜索的，输出此内容，
if($issearch=='1'&&$revalue!=""){
	
	//查询提交的搜索按钮 没有用130304
	//if($teamtype==10)$subbottom="<input name=\"提交\" type=\"submit\" class=\"inp1\"  value=\"搜索\" >";
	//if($teamtype==6)$subbottom="<input type='image'  onclick='turnpage('".$filename_begin_rule.".html','')' src='admin/images/search.gif' class='input3' />";
	
	//被搜索的字段名称
	$revalue="<select name='".$filename_begin_rule."_selectColumnName' id='".$filename_begin_rule."_selectColumnName'>	".$revalue."</select>";
	
	//搜索的值
    if($teamtype==10)$revalue.=" <input name='".$filename_begin_rule."_sKey' type='text' id='".$filename_begin_rule."_sKey' value='<%=".$filename_begin_rule."_sKey%>'>";
    if($teamtype==6)$revalue.=" <input name='".$filename_begin_rule."_sKey' type='text' id='".$filename_begin_rule."_sKey' value='\${".$filename_begin_rule."_sKey }'>";
    
	
	//
	$revalue.=$subbottom."<input name=\"提交\" type=\"submit\" class=\"inp1\"  value=\"搜索\" > ";
}
	return $revalue;
}