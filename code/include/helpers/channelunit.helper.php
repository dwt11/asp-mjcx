<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * �ĵ�С����
 *
 * @version        $Id: channelunit.helper.php 1 16:49 6��Z tianya $
 * @package        Helpers
 
 */




 
		/**
		 *  ��ȡ��ǰ��Ŀ�����б�������ֶ�  130214  
		 *  listservlet.java��ʹ��
		 * @param     int  $team_id  ��ĿID
		
		
		 * @return    array   allfield["��ID"]
		 */


		function Getallfield($team_id)
		{
			  global $dsql;
	
		    $dsql->SetQuery("SELECT t_id,t_name  from #@__team_datebase_table WHERE team_id='$team_id' order by t_name");
			$dsql->Execute();
			while($row = $dsql->GetObject())
			{
				    $t_idss =(empty($t_idss)?$row->t_id:$t_idss.",". $row->t_id);
			}
			$idArray = explode(',',$t_idss);
		  $i=0;
		  foreach($idArray as $t_id)
		  {
			  //$t_id = $idArray[$i];
			  $dsql->SetQuery("SELECT field_name  from #@__team_datebase_field WHERE t_id='$t_id' order by id asc");
			  $dsql->Execute();
			  while($row = $dsql->GetObject())
			  {
					  $allfield[$t_id] =(empty($allfield[$t_id])?"\"".$row->field_name."\"":$allfield[$t_id].",". "\"".$row->field_name."\"");
			  }
			  
		  }
		 
		 // dump($allfield);
		      return $allfield;
		}



		/**
		 *  ��ȡ��ǰ��Ŀ�����б�������ֶ�  130214  
		 *  �༭�����Ӻ�Ķ���������ʹ��
		 ��WEBPAGE.CLASS.PHP�е��� 
		 * @param     int  $t_id  ��ID
		 
		         jsp��Ŀʹ��
		 * @param     string $savetype  ���������  
		         
				      "newfield"//��������ֶ�  new���ӱ���ʱ������
					  (title,content,times,type)
		              "newvalue"//��������ֶ�  new���ӱ���ʱ��ֵ
					  values('"+title+"','"+content+"','"+times+"','"+type+"')
					  
					  "update"//��������ֶ�  update�༭����ʱ����ʽ
					  title='"+title+"',content='"+content+"',times='"+times+"',type='"+type+"' 
					  ��������ֶ�  select_field��ʾ�༭ҳ��ʱȡֵ����ʽ
					  
					  
					  SSH��Ŀʹ��
					  entity String noTitle, String noContent, String noAuthor,String noTime, String noIsTop,Integer noType
					  
		 * @return    string   
		 */
//
		function GetTablefield($t_id,$savetype)
		{
			  global $dsql;
	
		  
			  //$t_id = $idArray[$i];
			  $sql="SELECT field_name,relevance_t_id  from #@__team_datebase_field WHERE t_id='$t_id' and major_key=0 order by id asc";
			  $dsql->SetQuery($sql);
			  $dsql->Execute();
			  while($row = $dsql->GetObject())
			  {
					  if($savetype=="update")$tablefield =(empty($tablefield)?$row->field_name."='\"+".$row->field_name."+\"'":$tablefield.",". $row->field_name."='\"+".$row->field_name."+\"'");
					  if($savetype=="newvalue")$tablefield =(empty($tablefield)?"'\"+".$row->field_name."+\"'":$tablefield.",". "'\"+".$row->field_name."+\"'");
					  if($savetype=="newfield")$tablefield =(empty($tablefield)?$row->field_name:$tablefield.",".$row->field_name);
					  
					  
					  
					  //SSH��Ŀ�У����������������ı���������ֶ�Ϊ���������� AdminEntity.javaģ������
					  if($savetype=="entity"){
						  $field_name="String ".$row->field_name;
						  if($row->relevance_t_id>0)
						  {
							  $field_name=GetTableFilename($row->relevance_t_id)." ".GetTableFilename($row->relevance_t_id);
						  }
						  $tablefield =(empty($tablefield)?$field_name:$tablefield.",".$field_name);
		 //dump($field_name);
					  }
			  }
			
			  if($savetype=="select") 
			  {
				  $sql="SELECT field_name  from #@__team_datebase_field WHERE t_id='$t_id' order by id asc";
				  $dsql->SetQuery($sql);
				  $dsql->Execute();
				  while($row = $dsql->GetObject())
				  {
						 $tablefield =(empty($tablefield)?"\"".$row->field_name."\"":$tablefield.",". "\"".$row->field_name."\"");
				  }
			  }
			  
		 
		  //dump($sql);
		      return $tablefield;
		}


//  ��ȡ�������

		function Gettablemajor_key($t_id)
		{
			  global $dsql;
	
			  $arcQuery = "SELECT major_key,field_name  from #@__team_datebase_field WHERE t_id='$t_id' and major_key=1";       //!error
			  $chRow =$dsql->GetOne($arcQuery);
			  $field_name=$chRow['field_name'];
		      return $field_name;
		}


//��ȡ�������    δʹ��
//fieldlist.lib.php��ʹ��
//����SSH��Ŀ��ȡ������ı�����

		function Gettablename($t_id)
		{
			  global $dsql;
	
			  $arcQuery = "SELECT t_name  from #@__team_datebase_table WHERE t_id='$t_id'";       //!error
			  $chRow =$dsql->GetOne($arcQuery);
			  $t_name=$chRow['t_name'];
		      return $t_name;
		}


//��ȡ�������
//fieldlist.lib.php��ʹ��
//����SSH��Ŀ��ȡ�������Ҫ��ʾ���ֶε�����

		function Getnextfieldname($t_id)
		{
			  global $dsql;
	
			  $arcQuery = "SELECT field_name  from #@__team_datebase_field WHERE t_id='$t_id'  and major_key=0 order by id asc";       //!error
			  $chRow =$dsql->GetOne($arcQuery);
			  $field_name=$chRow['field_name'];
		      return $field_name;
		}



		/**
		 *  ��ȡ��������  130214
		 *
		 * @param     int  $team_id  ��ĿID
		 * @param     int  $t_id  ���ID
		 * @param     string  $getnametype  Ҫ��ȡ�����ƺ�꡵����ͣ���-Ϊ�ļ����� xxzx
		                                                        add-          xxzx_zj
																list-
																edit-
																del-
		 * @param     string  $isexname  �Ƿ�����չ������-Ϊ�������չ����
		 			                     //�����100�򷵻�JAVA��ĿSRCԴ����Ҫ�õ�.java��չ������100�������ݿ��д�ֵ
		
		
		 * @return    string
		 */
		function GetTableFilename($t_id, $getnametype='', $isexname='')
		{
			  global $dsql;
			 $TableFilename='';
			  //��ȡ��������Ϣ��Ҫʹ�õģ����������ƣ���Ӣ������
			  $arcQuery = "SELECT t_name,t_name_page,t_id,team_id  from #@__team_datebase_table WHERE t_id='$t_id' ";       //!error
			  $chRow =$dsql->GetOne($arcQuery);
			  $t_name=$chRow['t_name'];
			  $t_name_page=$chRow['t_name_page'];
			  $team_id=$chRow['team_id'];
			 
    	   	  //��ȡ��Ŀ�������Ϣ��Ҫʹ�õģ�ʹ�ü������ļ�������������ļ�ǰ���������
			  $arcQuery = "SELECT syjs,filename_begin_rule,filename_end_rule  from #@__team WHERE id='$team_id' ";       //!error
			  $chRow =$dsql->GetOne($arcQuery);
			  $teamtype=$chRow['syjs'];
		    // dump($teamtype."kkkkk");
			  $filename_begin_rule=$chRow['filename_begin_rule'];
			  $filename_end_rule=$chRow['filename_end_rule'];
			  
			 
			 
			  //����Ĭ�ϵ�����
			  if($filename_begin_rule==1)//0���������Ƶ�ƴ������ĸ��1��Ӣ������
			  {
				  $TableFilename=$t_name;
			  }
			  else 
			  {
				  $TableFilename=GetPinyin($t_name_page,1,1);
			  }
			  
			  
			  //��Ŀ�б��ļ����ƺ����������0ƴ������ĸLB\BJ\ZJ\sc��1Ӣ��\MANAGE\EDIT\ADD\del
			  //�����ȡ��������Ϊlist  
			  if($getnametype=="list") {
				  if($filename_end_rule==1){$TableFilename=$TableFilename."_manage";}
				  else {$TableFilename=$TableFilename."_lb";}
			  }
			  if($getnametype=="add") {
				  if($filename_end_rule==1){$TableFilename=$TableFilename."_add";}
				  else {$TableFilename=$TableFilename."_zj";}
			  }
			  if($getnametype=="edit") {
				  if($filename_end_rule==1){$TableFilename=$TableFilename."_edit";}
				  else {$TableFilename=$TableFilename."_bj";}
			  }
			  if($getnametype=="del") {
				  if($filename_end_rule==1){$TableFilename=$TableFilename."_del";}
				  else {$TableFilename=$TableFilename."_sc";}
			  }
			 
			 
			 
			 
			   if($isexname!="") //��� ��չ����Ϊ�գ����ڷ���ֵ ��Ӷ�Ӧ����չ����
			                     //�����100�򷵻�JAVA��ĿSRCԴ����Ҫ�õ�.java��չ������100�������ݿ��д�ֵ
               {
				  if($teamtype==10||$teamtype==6)$TableFilename=$TableFilename.".jsp";				   
				  if($teamtype==13)$TableFilename=$TableFilename.".asp";				   
				  if($teamtype==12)$TableFilename=$TableFilename.".php";				   
				  if($teamtype==14)$TableFilename=$TableFilename.".aspx";				   
				  if($teamtype==100)$TableFilename=$TableFilename.".java";				   
			   }
			  
			  
			return $TableFilename;
		}
	





/**
 *  �����Ǹ�ֵ  ���TEAMҪ��130214
 *
 * @param     object  $dtp  ģ���������
 * @param     object  $refObj  ʵ��������
 * @param     object  $parfield
 * @return    string
 */
function MakeOneTag(&$dtp, &$refObj, $parfield='Y')
{
    $alltags = array();
    $dtp->setRefObj($refObj);
    //��ȡ���ɵ���tag�б�
    $dh = dir(DEDEINC.'/taglib');
    while($filename = $dh->read())
    {
        if(preg_match("/\.lib\./", $filename))
        {
            $alltags[] = str_replace('.lib.php','',$filename);
        }
    }
    $dh->Close();
//
    //����tagԪ��
    if(!is_array($dtp->CTags))
    {
        return '';
    }
    foreach($dtp->CTags as $tagid=>$ctag)
    {
        $tagname = $ctag->GetName();
//dump($alltags); 
//dump($dtp->CTags);
       if($tagname=='field' && $parfield=='Y')
        {
            $vname = $ctag->GetAtt('name');
            if( $vname=='array' && isset($refObj->Fields) )
            {
                $dtp->Assign($tagid,$refObj->Fields);
            }
            else if(isset($refObj->Fields[$vname]))
            {
                $dtp->Assign($tagid,$refObj->Fields[$vname]);
            }
            else if($ctag->GetAtt('noteid') != '')
            {
                if( isset($refObj->Fields[$vname.'_'.$ctag->GetAtt('noteid')]) )
                {
                    $dtp->Assign($tagid, $refObj->Fields[$vname.'_'.$ctag->GetAtt('noteid')]);
                }
            }
            continue;
        }

        //���ڿ��Ǽ����ԣ�ԭ�����µ���ʹ�õı�Ǳ���ͳһ��������Щ���ʵ�ʵ��õĽ����ļ�Ϊinc_arclist.php
        if(preg_match("/^(artlist|likeart|hotart|imglist|imginfolist|coolart|specart|autolist)$/", $tagname))
        {
            $tagname='arclist';
        }
        if($tagname=='friendlink')
        {
            $tagname='flink';
        }
        if(in_array($tagname,$alltags))
        {
            $filename = DEDEINC.'/taglib/'.$tagname.'.lib.php';
            include_once($filename);
            $funcname = 'lib_'.$tagname;
            $dtp->Assign($tagid,$funcname($ctag,$refObj));
        }
    }
}
 
 /**
 *  ���������ַ
 *  ���Ҫ����ļ���·����ֱ����
 *  GetFileUrl($aid,$typeid,$timetag,$title,$ismake,$rank,$namerule,$typedir,$money)
 *  ���ǲ�ָ��վ������򷵻��൱�Ը�Ŀ¼����ʵ·��
 *
 * @param     int  $aid  �ĵ�ID
 * @param     int  $typeid  ����ID
 * @param     int  $timetag  ʱ���
 * @param     string  $title  ����
 * @param     int  $ismake  �Ƿ�����
 * @param     int  $rank  �Ķ�Ȩ��
 * @param     string  $namerule  ���ƹ���
 * @param     string  $typedir  ����dir
 * @param     string  $money  ��Ҫ���
 * @param     string  $filename  �ļ�����
 * @param     string  $moresite  ��վ��
 * @param     string  $siteurl  վ���ַ
 * @param     string  $sitepath  վ��·��
 * @return    string
 */
if ( ! function_exists('GetFileUrl'))
{
    function GetFileUrl($aid,$typeid,$timetag,$title,$ismake=0,$rank=0,$namerule='',$typedir='',
    $money=0, $filename='',$moresite=0,$siteurl='',$sitepath='')
    {
        $articleUrl = GetFileName($aid,$typeid,$timetag,$title,$ismake,$rank,$namerule,$typedir,$money,$filename);
        $sitepath = MfTypedir($sitepath);

        //�Ƿ�ǿ��ʹ�þ�����ַ
        if($GLOBALS['cfg_multi_site']=='Y')
        {
            if($siteurl=='')
            {
                $siteurl = $GLOBALS['cfg_basehost'];
            }
            if($moresite==1)
            {
                $articleUrl = preg_replace("#^".$sitepath.'#', '', $articleUrl);
            }
            if(!preg_match("/http:/", $articleUrl))
            {
                $articleUrl = $siteurl.$articleUrl;
            }
        }

        return $articleUrl;
    }
}

/**
 *  ������ļ���(���������Զ�����Ŀ¼)
 *
 * @param     int  $aid  �ĵ�ID
 * @param     int  $typeid  ����ID
 * @param     int  $timetag  ʱ���
 * @param     string  $title  ����
 * @param     int  $ismake  �Ƿ�����
 * @param     int  $rank  �Ķ�Ȩ��
 * @param     string  $namerule  ���ƹ���
 * @param     string  $typedir  ����dir
 * @param     string  $money  ��Ҫ���
 * @param     string  $filename  �ļ�����
 * @return    string
 */
if ( ! function_exists('GetFileNewName'))
{
     function GetFileNewName($aid,$typeid,$timetag,$title,$ismake=0,$rank=0,$namerule='',$typedir='',$money=0,$filename='')
    {
        global $cfg_arc_dirname;
        $articlename = GetFileName($aid,$typeid,$timetag,$title,$ismake,$rank,$namerule,$typedir,$money,$filename);
        
        if(preg_match("/\?/", $articlename))
        {
            return $articlename;
        }
        
        if($cfg_arc_dirname=='Y' && preg_match("/\/$/", $articlename))
        {
            $articlename = $articlename."index.html";
        }
        
        $slen = strlen($articlename)-1;
        for($i=$slen;$i>=0;$i--)
        {
            if($articlename[$i]=='/')
            {
                $subpos = $i;
                break;
            }
        }
        $okdir = substr($articlename,0,$subpos);
        CreateDir($okdir);
        return $articlename;
    }
}



/**
 *  ħ�����������ڻ�ȡ�����ɱ��ֵ
 *
 * @param     string  $v1  ��һ������
 * @param     string  $v2  �ڶ�������
 * @return    string
 */
if ( ! function_exists('MagicVar'))
{
    function MagicVar($v1,$v2)
    {
        return $GLOBALS['autoindex']%2==0 ? $v1 : $v2;
    }
}

/**
 *  ��ȡĳ����Ŀ�������ϼ�����id
 *
 * @param     int  $tid  ����ID
 * @return    string
 */
if ( ! function_exists('GetTopids'))
{
    function GetTopids($tid)
    {
        $arr = GetParentIds($tid);
        return join(',',$arr);
    }
}



/**
 *  ��ȡ�ϼ�ID�б�
 *
 * @access    public
 * @param     string  $tid  ����ID
 * @return    string
 */
if ( ! function_exists('GetParentIds'))
{
    function GetParentIds($tid)
    {
        global $cfg_Cs;
        $GLOBALS['pTypeArrays'][] = $tid;
        if(!is_array($cfg_Cs))
        {
            require_once(DEDEDATA."/cache/inc_dep_base.inc");
        }
        if(!isset($cfg_Cs[$tid]) || $cfg_Cs[$tid][0]==0)
        {
            return $GLOBALS['pTypeArrays'];
        }
        else
        {
            return GetParentIds($cfg_Cs[$tid][0]);
        }
    }
}


/**
 *  ��ⲿ���Ƿ�����һ�����ŵĸ�Ŀ¼
 *
 * @access    public
 * @param     string  $sid  ����Ŀ¼id
 * @param     string  $pid  �¼�Ŀ¼id
 * @return    bool
 */
if ( ! function_exists('IsParent'))
{
    function IsParent($sid, $pid)
    {
        $pTypeArrays = GetParentIds($sid);
        return in_array($pid, $pTypeArrays);
    }
}


/**
 *  ��ȡһ����Ŀ�Ķ�����Ŀid
 *
 * @param     string  $tid  ����ID
 * @return    string
 */
if ( ! function_exists('GetTopid'))
{
    function GetTopid($tid)
    {
        global $cfg_Cs;
        if(!is_array($cfg_Cs))
        {
            require_once(DEDEDATA."/cache/inc_dep_base.inc");
        }
        if(!isset($cfg_Cs[$tid][0]) || $cfg_Cs[$tid][0]==0)
        {
            return $tid;
        }
        else
        {
            return GetTopid($cfg_Cs[$tid][0]);
        }
    }
}


/**
 *  ���ĳid�������¼�id
 *
 * @param     string  $id  ����id
 * @param     string  $channel  ģ��ID
 * @param     string  $addthis  �Ƿ��������
 * @return    string
 */
function GetSonIds($id,$channel=0,$addthis=true)
{
    global $cfg_Cs;
    $GLOBALS['idArray'] = array();
    if( !is_array($cfg_Cs) )
    {
        require_once(DEDEDATA."/cache/inc_dep_base.inc");
    }
    GetSonIdsLogic($id,$cfg_Cs,$channel,$addthis);
    $rquery = join(',',$GLOBALS['idArray']);
    $rquery = preg_replace("/,$/", '', $rquery); 
    return $rquery;
}

//�ݹ��߼�
function GetSonIdsLogic($id,$sArr,$channel=0,$addthis=false)
{
    if($id!=0 && $addthis)
    {
        $GLOBALS['idArray'][$id] = $id;
    }
    if(is_array($sArr))
    {
        foreach($sArr as $k=>$v)
        {
            if( $v[0]==$id && ($channel==0 || $v[1]==$channel ))
            {
                GetSonIdsLogic($k,$sArr,$channel,true);
            }
        }
    }
}

/**
 *  ����Ŀ¼����
 *
 * @param     string  $typedir   ����Ŀ¼
 * @return    string
 */
function MfTypedir($typedir)
{
    if(preg_match("/^http:|^ftp:/i", $typedir)) return $typedir;
    $typedir = str_replace("{cmspath}",$GLOBALS['cfg_cmspath'],$typedir);
    $typedir = preg_replace("/\/{1,}/", "/", $typedir);
    return $typedir;
}

/**
 *  ģ��Ŀ¼����
 *
 * @param     string  $tmpdir  ģ��Ŀ¼
 * @return    string
 */
function MfTemplet($tmpdir)
{
    $tmpdir = str_replace("{style}", $GLOBALS['cfg_df_style'], $tmpdir);
    $tmpdir = preg_replace("/\/{1,}/", "/", $tmpdir);
    return $tmpdir;
}

/**
 *  �������js�Ŀհ׿�
 *
 * @param     string  $atme  �ַ�
 * @return    string
 */
function FormatScript($atme)
{
    return $atme=='&nbsp;' ? '' : $atme;
}

/**
 *  ������Ĭ��ֵ
 *
 * @param     array  $atts  ����
 * @param     array  $attlist  �����б�
 * @return    string
 */
function FillAttsDefault(&$atts, $attlist)
{
    $attlists = explode(',', $attlist);
    for($i=0; isset($attlists[$i]); $i++)
    {
        list($k, $v) = explode('|', $attlists[$i]);
        if(!isset($atts[$k]))
        {
            $atts[$k] = $v;
        }
    }
}







/**
 *  ��ȡĳ���ŵ�url
 *
 * @param     array  $typeinfos  ������Ϣ
 * @return    string
 */
function GetOneTypeUrlA($typeinfos)
{
    return GetTypeUrl($typeinfos['id'],MfTypedir($typeinfos['typedir']),$typeinfos['isdefault'],$typeinfos['defaultname'],
    $typeinfos['ispart'],$typeinfos['namerule2'],$typeinfos['moresite'],$typeinfos['siteurl'],$typeinfos['sitepath']);
}

/**
 *  ����ȫ�ֻ�������
 *
 * @param     int  $typeid  ����ID
 * @param     string  $typename  ��������
 * @param     string  $aid  �ĵ�ID
 * @param     string  $title  ����
 * @param     string  $curfile  ��ǰ�ļ�
 * @return    string
 */
function SetSysEnv($typeid=0,$typename='',$aid=0,$title='',$curfile='')
{
    global $_sys_globals;
    if(empty($_sys_globals['curfile']))
    {
        $_sys_globals['curfile'] = $curfile;
    }
    if(empty($_sys_globals['typeid']))
    {
        $_sys_globals['typeid'] = $typeid;
    }
    if(empty($_sys_globals['typename']))
    {
        $_sys_globals['typename'] = $typename;
    }
    if(empty($_sys_globals['aid']))
    {
        $_sys_globals['aid'] = $aid;
    }
}

/**
 *  ����ID����Ŀ¼
 *
 * @param     string  $aid  ����ID
 * @return    int
 */
function DedeID2Dir($aid)
{
    $n = ceil($aid / 1000);
    return $n;
}

/**
 *  ��������б����ַ
 *
 * @param     string  $lid  �б�id
 * @param     string  $namerule  ��������
 * @param     string  $listdir  �б�Ŀ¼
 * @param     string  $defaultpage  Ĭ��ҳ��
 * @param     string  $nodefault  û��Ĭ��ҳ��
 * @return    string
 */
function GetFreeListUrl($lid,$namerule,$listdir,$defaultpage,$nodefault){
    $listdir = str_replace('{cmspath}',$GLOBALS['cfg_cmspath'],$listdir);
    if($nodefault==1)
    {
        $okfile = str_replace('{page}','1',$namerule);
        $okfile = str_replace('{listid}',$lid,$okfile);
        $okfile = str_replace('{listdir}',$listdir,$okfile);
    }
    else
    {
        $okfile = $GLOBALS['cfg_phpurl']."/freelist.php?lid=$lid";
        return $okfile;
    }
    $okfile = str_replace("\\","/",$okfile);
    $okfile = str_replace("//","/",$okfile);
    $trueFile = $GLOBALS['cfg_basedir'].$okfile;
    if(!@file_exists($trueFile))
    {
        $okfile = $GLOBALS['cfg_phpurl']."/freelist.php?lid=$lid";
    }
    return $okfile;
}


/**
 *  ʹ�þ�����ַ
 *
 * @param     string  $gurl  ��ַ
 * @return    string
 */
function Gmapurl($gurl)
{
    return preg_replace("/http:\/\//i", $gurl) ? $gurl : $GLOBALS['cfg_basehost'].$gurl;
}

/**
 *  ���ûظ���Ǵ���
 *
 * @param     string  $quote
 * @return    string
 */
function Quote_replace($quote)
{
    $quote = str_replace('{quote}','<div class="decmt-box">',$quote);
    $quote = str_replace('{title}','<div class="decmt-title"><span class="username">',$quote);
    $quote = str_replace('{/title}','</span></div>',$quote);
    $quote = str_replace('&lt;br/&gt;','<br>',$quote);
    $quote = str_replace('&lt;', '<', $quote);
    $quote = str_replace('&gt;', '>', $quote);
    $quote = str_replace('{content}','<div class="decmt-content">',$quote);
    $quote = str_replace('{/content}','</div>',$quote);
    $quote = str_replace('{/quote}','</div>',$quote);
    return $quote;
}

/**
 *  ��ȡ��д��ָ��cacheid�Ŀ�
 *
 * @param     string  $cacheid  ����ID
 * @return    string
 */
function GetCacheBlock($cacheid)
{
    global $cfg_puccache_time;
    $cachefile = DEDEDATA.'/cache/'.$cacheid.'.inc';
    if(!file_exists($cachefile) || filesize($cachefile)==0 || 
      $cfg_puccache_time==0 || time() - filemtime($cachefile) > $cfg_puccache_time)
    {
        return '';
    }
    $fp = fopen($cachefile, 'r');
    $str = @fread($fp, filesize($cachefile));
    fclose($fp);
    return $str;
}

/**
 *  д�뻺���
 *
 * @param     string  $cacheid  ����ID
 * @param     string  $str  �ַ�����Ϣ
 * @return    string
 */
function WriteCacheBlock($cacheid, $str)
{
    $cachefile = DEDEDATA.'/cache/'.$cacheid.'.inc';
    $fp = fopen($cachefile, 'w');
    $str = fwrite($fp, $str);
    fclose($fp);
}
