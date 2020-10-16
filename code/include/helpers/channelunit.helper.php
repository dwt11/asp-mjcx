<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * 文档小助手
 *
 * @version        $Id: channelunit.helper.php 1 16:49 6日Z tianya $
 * @package        Helpers
 
 */




 
		/**
		 *  获取当前项目的所有表的所有字段  130214  
		 *  listservlet.java中使用
		 * @param     int  $team_id  项目ID
		
		
		 * @return    array   allfield["表ID"]
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
		 *  获取当前项目的所有表的所有字段  130214  
		 *  编辑和增加后的动作代码中使用
		 在WEBPAGE.CLASS.PHP中调用 
		 * @param     int  $t_id  表ID
		 
		         jsp项目使用
		 * @param     string $savetype  保存的类型  
		         
				      "newfield"//表的所有字段  new增加保存时的名称
					  (title,content,times,type)
		              "newvalue"//表的所有字段  new增加保存时的值
					  values('"+title+"','"+content+"','"+times+"','"+type+"')
					  
					  "update"//表的所有字段  update编辑更新时的形式
					  title='"+title+"',content='"+content+"',times='"+times+"',type='"+type+"' 
					  表的所有字段  select_field显示编辑页面时取值的形式
					  
					  
					  SSH项目使用
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
					  
					  
					  
					  //SSH项目中，如果表中有索引别的表，则输出此字段为这个表的名称 AdminEntity.java模板中用
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


//  获取表的主键

		function Gettablemajor_key($t_id)
		{
			  global $dsql;
	
			  $arcQuery = "SELECT major_key,field_name  from #@__team_datebase_field WHERE t_id='$t_id' and major_key=1";       //!error
			  $chRow =$dsql->GetOne($arcQuery);
			  $field_name=$chRow['field_name'];
		      return $field_name;
		}


//获取表的名称    未使用
//fieldlist.lib.php中使用
//用于SSH项目获取索引表的表名称

		function Gettablename($t_id)
		{
			  global $dsql;
	
			  $arcQuery = "SELECT t_name  from #@__team_datebase_table WHERE t_id='$t_id'";       //!error
			  $chRow =$dsql->GetOne($arcQuery);
			  $t_name=$chRow['t_name'];
		      return $t_name;
		}


//获取表的名称
//fieldlist.lib.php中使用
//用于SSH项目获取索引表的要显示的字段的名称

		function Getnextfieldname($t_id)
		{
			  global $dsql;
	
			  $arcQuery = "SELECT field_name  from #@__team_datebase_field WHERE t_id='$t_id'  and major_key=0 order by id asc";       //!error
			  $chRow =$dsql->GetOne($arcQuery);
			  $field_name=$chRow['field_name'];
		      return $field_name;
		}



		/**
		 *  获取命名规则  130214
		 *
		 * @param     int  $team_id  项目ID
		 * @param     int  $t_id  表的ID
		 * @param     string  $getnametype  要获取的名称后辍的类型，空-为文件名如 xxzx
		                                                        add-          xxzx_zj
																list-
																edit-
																del-
		 * @param     string  $isexname  是否有扩展名，空-为不输出扩展名称
		 			                     //如果是100则返回JAVA项目SRC源码中要用的.java扩展名，此100不从数据库中此值
		
		
		 * @return    string
		 */
		function GetTableFilename($t_id, $getnametype='', $isexname='')
		{
			  global $dsql;
			 $TableFilename='';
			  //读取表的相关信息，要使用的：表中文名称，表英文名称
			  $arcQuery = "SELECT t_name,t_name_page,t_id,team_id  from #@__team_datebase_table WHERE t_id='$t_id' ";       //!error
			  $chRow =$dsql->GetOne($arcQuery);
			  $t_name=$chRow['t_name'];
			  $t_name_page=$chRow['t_name_page'];
			  $team_id=$chRow['team_id'];
			 
    	   	  //读取项目的相关信息，要使用的：使用技术，文件后辍命名规则，文件前辍命名规则
			  $arcQuery = "SELECT syjs,filename_begin_rule,filename_end_rule  from #@__team WHERE id='$team_id' ";       //!error
			  $chRow =$dsql->GetOne($arcQuery);
			  $teamtype=$chRow['syjs'];
		    // dump($teamtype."kkkkk");
			  $filename_begin_rule=$chRow['filename_begin_rule'];
			  $filename_end_rule=$chRow['filename_end_rule'];
			  
			 
			 
			  //返回默认的名称
			  if($filename_begin_rule==1)//0表中文名称的拼音首字母，1表英文名称
			  {
				  $TableFilename=$t_name;
			  }
			  else 
			  {
				  $TableFilename=GetPinyin($t_name_page,1,1);
			  }
			  
			  
			  //项目列表文件名称后辍命名规则：0拼音首字母LB\BJ\ZJ\sc，1英文\MANAGE\EDIT\ADD\del
			  //如果获取名称类型为list  
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
			 
			 
			 
			 
			   if($isexname!="") //如果 扩展名不为空，则在返回值 后加对应的扩展名称
			                     //如果是100则返回JAVA项目SRC源码中要用的.java扩展名，此100不从数据库中此值
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
 *  给块标记赋值  这个TEAM要用130214
 *
 * @param     object  $dtp  模板解析引擎
 * @param     object  $refObj  实例化对象
 * @param     object  $parfield
 * @return    string
 */
function MakeOneTag(&$dtp, &$refObj, $parfield='Y')
{
    $alltags = array();
    $dtp->setRefObj($refObj);
    //读取自由调用tag列表
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
    //遍历tag元素
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

        //由于考虑兼容性，原来文章调用使用的标记别名统一保留，这些标记实际调用的解析文件为inc_arclist.php
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
 *  获得文章网址
 *  如果要获得文件的路径，直接用
 *  GetFileUrl($aid,$typeid,$timetag,$title,$ismake,$rank,$namerule,$typedir,$money)
 *  即是不指定站点参数则返回相当对根目录的真实路径
 *
 * @param     int  $aid  文档ID
 * @param     int  $typeid  部门ID
 * @param     int  $timetag  时间戳
 * @param     string  $title  标题
 * @param     int  $ismake  是否生成
 * @param     int  $rank  阅读权限
 * @param     string  $namerule  名称规则
 * @param     string  $typedir  部门dir
 * @param     string  $money  需要金币
 * @param     string  $filename  文件名称
 * @param     string  $moresite  多站点
 * @param     string  $siteurl  站点地址
 * @param     string  $sitepath  站点路径
 * @return    string
 */
if ( ! function_exists('GetFileUrl'))
{
    function GetFileUrl($aid,$typeid,$timetag,$title,$ismake=0,$rank=0,$namerule='',$typedir='',
    $money=0, $filename='',$moresite=0,$siteurl='',$sitepath='')
    {
        $articleUrl = GetFileName($aid,$typeid,$timetag,$title,$ismake,$rank,$namerule,$typedir,$money,$filename);
        $sitepath = MfTypedir($sitepath);

        //是否强制使用绝对网址
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
 *  获得新文件名(本函数会自动创建目录)
 *
 * @param     int  $aid  文档ID
 * @param     int  $typeid  部门ID
 * @param     int  $timetag  时间戳
 * @param     string  $title  标题
 * @param     int  $ismake  是否生成
 * @param     int  $rank  阅读权限
 * @param     string  $namerule  名称规则
 * @param     string  $typedir  部门dir
 * @param     string  $money  需要金币
 * @param     string  $filename  文件名称
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
 *  魔法变量，用于获取两个可变的值
 *
 * @param     string  $v1  第一个变量
 * @param     string  $v2  第二个变量
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
 *  获取某个类目的所有上级部门id
 *
 * @param     int  $tid  部门ID
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
 *  获取上级ID列表
 *
 * @access    public
 * @param     string  $tid  部门ID
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
 *  检测部门是否是另一个部门的父目录
 *
 * @access    public
 * @param     string  $sid  顶级目录id
 * @param     string  $pid  下级目录id
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
 *  获取一个类目的顶级类目id
 *
 * @param     string  $tid  部门ID
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
 *  获得某id的所有下级id
 *
 * @param     string  $id  部门id
 * @param     string  $channel  模型ID
 * @param     string  $addthis  是否包含本身
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

//递归逻辑
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
 *  部门目录规则
 *
 * @param     string  $typedir   部门目录
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
 *  模板目录规则
 *
 * @param     string  $tmpdir  模板目录
 * @return    string
 */
function MfTemplet($tmpdir)
{
    $tmpdir = str_replace("{style}", $GLOBALS['cfg_df_style'], $tmpdir);
    $tmpdir = preg_replace("/\/{1,}/", "/", $tmpdir);
    return $tmpdir;
}

/**
 *  清除用于js的空白块
 *
 * @param     string  $atme  字符
 * @return    string
 */
function FormatScript($atme)
{
    return $atme=='&nbsp;' ? '' : $atme;
}

/**
 *  给属性默认值
 *
 * @param     array  $atts  属性
 * @param     array  $attlist  属性列表
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
 *  获取某部门的url
 *
 * @param     array  $typeinfos  部门信息
 * @return    string
 */
function GetOneTypeUrlA($typeinfos)
{
    return GetTypeUrl($typeinfos['id'],MfTypedir($typeinfos['typedir']),$typeinfos['isdefault'],$typeinfos['defaultname'],
    $typeinfos['ispart'],$typeinfos['namerule2'],$typeinfos['moresite'],$typeinfos['siteurl'],$typeinfos['sitepath']);
}

/**
 *  设置全局环境变量
 *
 * @param     int  $typeid  部门ID
 * @param     string  $typename  部门名称
 * @param     string  $aid  文档ID
 * @param     string  $title  标题
 * @param     string  $curfile  当前文件
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
 *  根据ID生成目录
 *
 * @param     string  $aid  内容ID
 * @return    int
 */
function DedeID2Dir($aid)
{
    $n = ceil($aid / 1000);
    return $n;
}

/**
 *  获得自由列表的网址
 *
 * @param     string  $lid  列表id
 * @param     string  $namerule  命名规则
 * @param     string  $listdir  列表目录
 * @param     string  $defaultpage  默认页面
 * @param     string  $nodefault  没有默认页面
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
 *  使用绝对网址
 *
 * @param     string  $gurl  地址
 * @return    string
 */
function Gmapurl($gurl)
{
    return preg_replace("/http:\/\//i", $gurl) ? $gurl : $GLOBALS['cfg_basehost'].$gurl;
}

/**
 *  引用回复标记处理
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
 *  获取、写入指定cacheid的块
 *
 * @param     string  $cacheid  缓存ID
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
 *  写入缓存块
 *
 * @param     string  $cacheid  缓存ID
 * @param     string  $str  字符串信息
 * @return    string
 */
function WriteCacheBlock($cacheid, $str)
{
    $cachefile = DEDEDATA.'/cache/'.$cacheid.'.inc';
    $fp = fopen($cachefile, 'w');
    $str = fwrite($fp, $str);
    fclose($fp);
}
