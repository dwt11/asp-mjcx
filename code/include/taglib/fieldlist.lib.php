<?php
/**
 * ��ѯ��ǰ���ɱ�������ֶ���Ϣ
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
 
function lib_fieldlist(&$ctag,&$refObj)
{
    global $t_id; //��ȡ�˱���ֶ�
	global $t_name; //������ΪJSPʱ����Ϊ��ȡ�༭�ֶ�ֵʱ������ǰ�
	global $teamtype; //��Ŀ����
	global $dsql;
	global $web_templets_name; //��Ŀ��WEBҳ��ģ�� ���������б�ҳģ����������У���ȡ������ť����ʽ����fieldlist.php�е��� 
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
 		   $filename_begin_rule=GetTableFilename($t_id,'','');//JSP��Ŀ�� ǰ�����
		  // dump($filename_begin_rule);
   while($row = $dsql->GetArray())
    {
       //dump($GLOBALS['autoindex']);
		 
		 
		 
		 /* a��ȡֵ��������
		 // ��1��JSP��Ŀ��
		  // $row['index']=$GLOBALS['autoindex'];  //����ֵ
		  //dump( $teamtype);
		  */
	   $row['filename_begin_rule']=$filename_begin_rule;
		   if( $teamtype=='10')
		   {
			   $row['edit_valuename']="<%=".$filename_begin_rule.".get(".$GLOBALS['autoindex'].")%>";//�༭ҳ���ֶ�ȡֵ�õ�����
			   $row['list_valuename']="<%=alRow3.get(".$GLOBALS['autoindex'].")  %>";   //�б�ҳ���ֶ�ȡֵ�õ�����
				//�����������idischeckboxΪ1�������ѡ��
				if($row['major_key']=='1'&&$idischeckbox==1)$row['list_valuename']="<input type='checkbox'  value='<%=alRow3.get(".$GLOBALS['autoindex'].")  %>' name='".$row['field_name']."' />";   
			  //������ʾ�����ַ�
			   if($row['field_type']=='datetime')$row['edit_valuename']="<%=".$filename_begin_rule.".get(".$GLOBALS['autoindex'].").toString().substring(0,10)%>";
			   //������ʾ �б�ҳ���ֶ�ȡֵ�õ�����
			   if($row['field_type']=='datetime')$row['list_valuename']="<%=alRow3.get(".$GLOBALS['autoindex'].").toString().substring(0,10)  %>";   
	    
				//����ֶ�Ϊ������ı����������,�б�ҳ���ֶ�ȡֵ��
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
		 // ��2��SSH��Ŀ��
		   if( $teamtype=='6')
		   {
			   $row['edit_valuename']=$filename_begin_rule.".".$row['field_name'];   //���Ӻͱ༭ҳ���ֶ�����
			   $row['list_valuename']="\${".$row['field_name']."}";                //�б�ҳ���ֶ�ȡֵ�õ�����
				//�����������idischeckboxΪ1�������ѡ��
				if($row['major_key']=='1'&&$idischeckbox==1)$row['list_valuename']="<input type='checkbox'  value='\${".$row['field_name']."}' name='".$row['field_name']."' />";   
			  //������ʾ�����ַ�
			   if($row['field_type']=='datetime')$row['edit_valuename']=$row['edit_valuename'];
			   //������ʾ �б�ҳ���ֶ�ȡֵ�õ�����
			   if($row['field_type']=='datetime')$row['list_valuename']=$row['list_valuename'];   
	    
				//����ֶ�Ϊ������ı����������,�б�ҳ���ֶ�ȡֵ��
			   if($row['relevance_t_id']>0)$row['list_valuename']="<s:if test='%{".GetTableFilename($row['relevance_t_id'],'','')."!= null}'>
			    			\${".GetTableFilename($row['relevance_t_id'],'','').".".Getnextfieldname($row['relevance_t_id'])."}
			    		</s:if>
			    		<s:else>
			    			��
			    		</s:else>"; 
			   //SSH��Ŀ�У����������������ı���������ֶ�Ϊ���������� AdminEntity.javaģ������				
			  if($row['relevance_t_id']>0)$row['relevance_t_name']=GetTableFilename($row['relevance_t_id']);
  //dump($row['field_type']);
		   }

		//dump($row['list_valuename']);

         //(2)PHP ��Ŀ
		 //��δ��
		
		
		
		
		
		
		
		
		
		
		
		
		
		if($row['field_name_page']=="")$row['field_name_page']="&nbsp;";
		//b������Ԫ�أ������ֶεĹ������ԡ��Ƿ�̻����Ƿ�༭�����ж�Ԫ�ص����
		//���������1���������Ԫ�صĻ�ȡֵ �Ĵ���
		
	
		
		if($iselementvalue=="0"){
			if($teamtype==10)
			{    
			
				  //��ͨ�ļ������
				  $row['edit_element']="<input name='".$row['field_name']."' type='text' value='".$row['edit_valuename']."'  />";
				  //������������������INPUT
				  if($row['major_key']=='1')$row['edit_element']="����д��������<input name='".$row['field_name']."' type='hidden' value='".$row['edit_valuename']."'  />";
				  //�����򣬣������˴��ã�����ֶ�����ΪMSSQL��'TEXT'����������༭����$row['use_editor']�ֶκ��ڸ�Ϊ�༭������ʽ
				  if($row['field_type']=='text')$row['edit_element']="<TEXTAREA  NAME='".$row['field_name']."' ROWS='20' COLS='70'>".$row['edit_valuename']."</TEXTAREA>";
			
			
				/*�˶�û������  //��������,mssql--datetime
				  //Ҫƥ�����ڿ�ĵ��ø�ʽ��ÿ��ģ�嶼��һ��
				  if($row['field_type']=='datetime'&&$web_templets_name=="4UTF-BLUE/")$row['edit_element']="<input  name='".$row['edit_valuename']."'  id='".$row['field_name']."'
				      value='".$row['edit_valuename']."'  style='border: 1px solid black;' 
					type='text' readonly='readonly' 
					 onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\"/>";
				  if($row['field_type']=='datetime'&&$web_templets_name=="2GB-GREEN/")$row['edit_element']="<input type='text' name='".$row['field_name']."'  readonly='readonly' onFocus='calendar()' value='".$row['edit_valuename']."' />";
		  */
		  
		  
				  //�̻�SELECT
				  //$row['edit_element']="";
		  
		  
		  
				  //������ı�SELECT,
				  //---------�˶�Ҫ�Ż���������ı�ʱ��Ҫ�����ݿ��ֶι��������������ı�ģ��ĸ��ֶ�.Ĭ��Ϊ1��Ҳ���ǵڶ����ֶ�-------
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
			{     //��ͨ�ļ������<input type="text" class="input1" name="employee.empName" id="empName" Tip="��������Ϊ��,�Ҳ��ܴ���20��!"  Exp="^[\s|\S]{1,20}$"/>
				  if($row['null_value']>0)$tip="Tip='".$row['field_name_page']."����Ϊ��'  usage='notempty'";
				  $row['edit_element']="<input name='".$row['edit_valuename']."'  id='".$row['field_name']."' type='text' $tip value='\${".$row['edit_valuename']."}'/>";
				  //������������������INPUT
				  if($row['major_key']=='1')$row['edit_element']="����д��������<input name='".$row['edit_valuename']."'  value='\${".$row['edit_valuename']."}' type='hidden' />";
				  //�����򣬣������˴��ã�����ֶ�����ΪMSSQL��'TEXT'����������༭����$row['use_editor']�ֶκ��ڸ�Ϊ�༭������ʽ
				  if($row['field_type']=='text')$row['edit_element']="<textarea  name='".$row['edit_valuename']."'  id='".$row['field_name']."'  style='width:40px;'>\${".$row['edit_valuename']."}</textarea>";
			
			
			/*  ����û������	  //��������,mssql--datetime
				  //if( $teamtype=='10')$nowdate="SimpleDateFormat sdf = new SimpleDateFormat('yyyy-MM-dd');String nowdate = sdf.format(new Date())";
				 
				 
				 
				 //Ҫƥ�����ڿ�ĵ��ø�ʽ��ÿ��ģ�嶼��һ��
				  if($row['field_type']=='datetime'&&$web_templets_name=="4UTF-BLUE/")$row['edit_element']="<input  name='".$row['edit_valuename']."'  id='".$row['field_name']."'
				      value='".$row['edit_valuename']."'  style='border: 1px solid black;' 
					type='text' readonly='readonly' 
					 onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\"/>";
				  if($row['field_type']=='datetime'&&$web_templets_name=="2GB-GREEN/")$row['edit_element']="<input type='text' name='".$row['field_name']."'  readonly='readonly' onFocus='calendar()'  value='\${".$row['edit_valuename']."}' />";
		  
		  */
		  
				  //�̻�SELECT
				  //$row['edit_element']="";
		  
		  
		  
				  //������ı�SELECT,
				  //---------�˶�Ҫ�Ż���������ı�ʱ��Ҫ�����ݿ��ֶι��������������ı�ģ��ĸ��ֶ�.Ĭ��Ϊ1��Ҳ���ǵڶ����ֶ�-------
				  if($row['relevance_t_id']>0)$row['edit_element']="<select id=\"".$row['field_name']."\" name=\"".$row['field_name']."\" style=\"width: 150px\" Tip=\"��ѡ��".$row['field_name_page']."!\" usage='notempty' >
				<option value=\"\">----��ѡ��----</option>
        <s:iterator value='#request.".GetTableFilename($row['relevance_t_id'],'','')."s'>
                <option value='\${".Gettablemajor_key($row['relevance_t_id'])."}'> \${".Getnextfieldname($row['relevance_t_id'])."} </option>
              </s:iterator>
			</select>
   
			  ";
		
		
			}
			
				
		}
		//�������1���������Ԫ�صĻ�ȡֵ �Ĵ���
		if($iselementvalue=="1"){
			


			if($teamtype==10)
			{     //��ͨ�ļ������
				  $row['edit_element']="<input name='".$row['field_name']."' type='text'  />";
				  //������������������INPUT
				  if($row['major_key']=='1')$row['edit_element']="����д��������<input name='".$row['field_name']."' type='hidden' />";
				  //�����򣬣������˴��ã�����ֶ�����ΪMSSQL��'TEXT'����������༭����$row['use_editor']�ֶκ��ڸ�Ϊ�༭������ʽ
				  if($row['field_type']=='text')$row['edit_element']="<TEXTAREA  NAME='".$row['field_name']."' ROWS='20' COLS='70'></TEXTAREA>";
			/*�˶�û���ˣ�ֱ��ȡ��ǰֵ	  //��������,mssql--datetime
				  //if( $teamtype=='10')$nowdate="SimpleDateFormat sdf = new SimpleDateFormat('yyyy-MM-dd');String nowdate = sdf.format(new Date())";
			//Ҫƥ�����ڿ�ĵ��ø�ʽ��ÿ��ģ�嶼��һ��
				  if($row['field_type']=='datetime'&&$web_templets_name=="2GB-GREEN/")$row['edit_element']="<input type='text' name='".$row['field_name']."'  readonly='readonly' onFocus='calendar()' value='' />";
			if($row['field_type']=='datetime'&&$web_templets_name=="4UTF-BLUE/")$row['edit_element']="
				    <input  name='".$row['field_name']."'  id='".$row['field_name']."'
				    value=''  style='border: 1px solid black;' 
					type='text' readonly='readonly' 
					 onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\"/>";
		  
		  */
		  
				  //�̻�SELECT
				  //$row['edit_element']="";
		  
		  
		  
				  //������ı�SELECT,
				  //---------�˶�Ҫ�Ż���������ı�ʱ��Ҫ�����ݿ��ֶι��������������ı�ģ��ĸ��ֶ�.Ĭ��Ϊ1��Ҳ���ǵڶ����ֶ�-------
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
			{     //��ͨ�ļ������<input type="text" class="input1" name="employee.empName" id="empName" Tip="��������Ϊ��,�Ҳ��ܴ���20��!"  Exp="^[\s|\S]{1,20}$"/>
				  if($row['null_value']>0)$tip="Tip='".$row['field_name_page']."����Ϊ��'  usage='notempty'";
				  $row['edit_element']="<input name='".$row['edit_valuename']."'  id='".$row['field_name']."' type='text' $tip />";
				  //������������������INPUT
				  if($row['major_key']=='1')$row['edit_element']="����д��������<input name='".$row['edit_valuename']."' type='hidden'  />";
				  //�����򣬣������˴��ã�����ֶ�����ΪMSSQL��'TEXT'����������༭����$row['use_editor']�ֶκ��ڸ�Ϊ�༭������ʽ
				  if($row['field_type']=='text')$row['edit_element']="<textarea  name='".$row['edit_valuename']."'  id='".$row['field_name']."'  style='width:40px;'></textarea>";
			/*	�˶�û������  //��������,mssql--datetime
				 
			//Ҫƥ�����ڿ�ĵ��ø�ʽ��ÿ��ģ�嶼��һ��
				  if($row['field_type']=='datetime'&&$web_templets_name=="2GB-GREEN/")$row['edit_element']="<input type='text' name='".$row['field_name']."'  readonly='readonly' onFocus='calendar()' value='' />";
			if($row['field_type']=='datetime'&&$web_templets_name=="4UTF-BLUE/")$row['edit_element']="
				    <input  name='".$row['edit_valuename']."'  id='".$row['field_name']."'
				    value=''  style='border: 1px solid black;' 
					type='text' readonly='readonly' 
					 onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})\"/>";
		  
		  */
		  
				  //�̻�SELECT
				  //$row['edit_element']="";
		  
		  
		  
				  //������ı�SELECT,
				  //---------�˶�Ҫ�Ż���������ı�ʱ��Ҫ�����ݿ��ֶι��������������ı�ģ��ĸ��ֶ�.Ĭ��Ϊ1��Ҳ���ǵڶ����ֶ�-------
				   if($row['relevance_t_id']>0)$row['edit_element']="<select id=\"".$row['field_name']."\" name=\"".$row['field_name']."\" style=\"width: 150px\" Tip=\"��ѡ��".$row['field_name_page']."!\" usage='notempty' >
				<option value=\"\">----��ѡ��----</option>
        <s:iterator value='#request.".GetTableFilename($row['relevance_t_id'],'','')."s'>
                <option value='\${".Gettablemajor_key($row['relevance_t_id'])."}'> \${".Getnextfieldname($row['relevance_t_id'])."} </option>
              </s:iterator>
			</select>
			  ";
		
		
			}
	//	dump($row['field_type']);
		
		}
		
				//���ֱ༭�������� ���ڿ�Ĭ�������ǰ����
		
		if($teamtype==10&&$row['field_type']=='datetime')
		{
			$row['edit_element']="
		 <%@ page import=\"java.util.Date\"%>��
		<%@ page import=\"java.text.SimpleDateFormat\"%>��
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
         $GLOBALS['autoindex']++;  //�˾������FOREACH�⣬���������autoindex��������
       //dump($revalue .= $ctp->GetResult());
  $revalue .= $ctp->GetResult();
    }
	
    //�б�ҳ������ֶ�����Ҫ�����ģ���������ݣ�
if($issearch=='1'&&$revalue!=""){
	
	//��ѯ�ύ��������ť û����130304
	//if($teamtype==10)$subbottom="<input name=\"�ύ\" type=\"submit\" class=\"inp1\"  value=\"����\" >";
	//if($teamtype==6)$subbottom="<input type='image'  onclick='turnpage('".$filename_begin_rule.".html','')' src='admin/images/search.gif' class='input3' />";
	
	//���������ֶ�����
	$revalue="<select name='".$filename_begin_rule."_selectColumnName' id='".$filename_begin_rule."_selectColumnName'>	".$revalue."</select>";
	
	//������ֵ
    if($teamtype==10)$revalue.=" <input name='".$filename_begin_rule."_sKey' type='text' id='".$filename_begin_rule."_sKey' value='<%=".$filename_begin_rule."_sKey%>'>";
    if($teamtype==6)$revalue.=" <input name='".$filename_begin_rule."_sKey' type='text' id='".$filename_begin_rule."_sKey' value='\${".$filename_begin_rule."_sKey }'>";
    
	
	//
	$revalue.=$subbottom."<input name=\"�ύ\" type=\"submit\" class=\"inp1\"  value=\"����\" > ";
}
	return $revalue;
}