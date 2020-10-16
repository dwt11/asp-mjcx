<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * ��������
 *
 * @version        $Id: typelink.class.php 1 15:21 5��Z tianya $
 * @package        Libraries
 
 */
//require_once(DEDEINC."/channelunit.func.php");

/**
 * ����������
 *
 * @package          TypeLink
 * @subpackage       Libraries
 * @link             http://www.
 */
class TypeLink
{
    var $typeDir;
    var $dsql;
    var $depid;
    var $baseDir;
    var $modDir;
    var $indexUrl;
    var $indexName;
    var $TypeInfos;
    var $SplitSymbol;
    var $valuePosition;
    var $valuePositionName;
    var $OptionArrayList;

    //���캯��///////
    //php5���캯��
    function __construct($depid)
    {
        $this->indexUrl = $GLOBALS['cfg_basehost'].$GLOBALS['cfg_indexurl'];
        $this->indexName = $GLOBALS['cfg_indexname'];
        $this->baseDir = $GLOBALS['cfg_basedir'];
        $this->modDir = $GLOBALS['cfg_templets_dir'];
        $this->SplitSymbol = $GLOBALS['cfg_list_symbol'];
        $this->dsql = $GLOBALS['dsql'];
        $this->depid = $depid;
        $this->valuePosition = '';
        $this->valuePositionName = '';
        $this->typeDir = '';
        $this->OptionArrayList = '';

        //������Ŀ��Ϣ
        $query = "SELECT depname FROM `#@__dep` WHERE id='$depid' ";
        if($depid > 0)
        {
            $this->TypeInfos = $this->dsql->GetOne($query);
            if(is_array($this->TypeInfos))
            {
                $this->TypeInfos['tempindex'] = MfTemplet($this->TypeInfos['tempindex']);
                $this->TypeInfos['templist'] = MfTemplet($this->TypeInfos['templist']);
                $this->TypeInfos['temparticle'] = MfTemplet($this->TypeInfos['temparticle']);
            }
        }
    }

    //����ʹ��Ĭ�Ϲ��캯�������
    //GetPositionLink()��������
    function TypeLink($depid)
    {
        $this->__construct($depid);
    }

    //�ر����ݿ����ӣ�������Դ
    function Close()
    {
    }

    //������ĿID
    function Setdepid($depid)
    {
        $this->depid = $depid;
        $this->valuePosition = "";
        $this->valuePositionName = "";
        $this->typeDir = "";
        $this->OptionArrayList = "";

        //������Ŀ��Ϣ
        $query = "
        SELECT #@__dep.*  FROM #@__dep  WHERE #@__dep.id='$depid' ";
        $this->dsql->SetQuery($query);
        $this->TypeInfos = $this->dsql->GetOne();
    }

  

    //���ĳ��Ŀ�������б� �磺��Ŀһ>>��Ŀ��>> ��������ʽ
    function GetPositionLink()
    {
       
                $this->valuePositionName = $this->TypeInfos['depname'];
 //echo $this->valuePositionName;
               if($this->TypeInfos['reid']!=0)
                {
                    //���õݹ��߼�
                    $this->LogicGetPosition($this->TypeInfos['reid']);
                }
                return $this->valuePositionName;
           
    }

    //��������б�
    function GetPositionName()
    {
        return $this->GetPositionLink();
    }

    //���ĳ��Ŀ�������б��ݹ��߼�����
    function LogicGetPosition($id)
    {
        $this->dsql->SetQuery("SELECT id,reid,depname FROM #@__dep WHERE id='".$id."'");
        $tinfos = $this->dsql->GetOne();
       
            $this->valuePositionName = $tinfos['depname'].$this->SplitSymbol.$this->valuePositionName;
        if($tinfos['reid']>0)
        {
            $this->LogicGetPosition($tinfos['reid']);
        }
        else
        {
            return 0;
        }
    }



    //�������б�
    //hid ��ָĬ��ѡ����Ŀ��0 ��ʾ����ѡ����Ŀ���򡰲�����Ŀ��
    function GetOptionArray($hid=0)
    {
        return $this->GetOptionList($hid);
    }

    function GetOptionList($hid=0)
    {
        
        if(!$this->dsql) $this->dsql = $GLOBALS['dsql'];
        $this->OptionArrayList = '';
        
        if($hid>0)
        {
            $row = $this->dsql->GetOne("SELECT id,depname FROM #@__dep WHERE id='$hid'");
            $channeltype = $row['channeltype'];
            if($row['ispart']==1) {
                $this->OptionArrayList .= "<option value='".$row['id']."' style='background-color:#DFDFDB;color:#888888' selected>".$row['depname']."</option>\r\n";
            }
            else {
                $this->OptionArrayList .= "<option value='".$row['id']."' selected>".$row['depname']."</option>\r\n";
            }
        }
        
        $query = "SELECT id,depname FROM `#@__dep` WHERE  reid=0  ORDER BY sortrank ASC";

        $this->dsql->SetQuery($query);
        $this->dsql->Execute();
        while($row=$this->dsql->GetObject())
        {
            if($row->id!=$hid)
            {
                    $this->OptionArrayList .= "<option value='".$row->id."'>".$row->depname."</option>\r\n";
            }
            $this->LogicGetOptionArray($row->id, "��", $oper);
        }
        return $this->OptionArrayList;
    }

    /**
     *  �߼��ݹ�
     *
     * @access    public
     * @param     int   $id   ����ID
     * @param     int   $step   ������־
     * @param     int   $oper   ����Ȩ��
     * @return    string
     */
    function LogicGetOptionArray($id, $step, $oper=0)
    {
        global $cfg_admin_channel;
        if(empty($cfg_admin_channel)) $cfg_admin_channel = 'all';
        
        $this->dsql->SetQuery("SELECT id,depname,ispart FROM #@__dep WHERE reid='".$id."' AND ispart<>2 ORDER BY sortrank ASC");
        $this->dsql->Execute($id);
        while($row=$this->dsql->GetObject($id))
        {
            if(is_array($oper) && $cfg_admin_channel != 'all')
            {
                if(!in_array($row->id, $oper)) continue;
            }
            if($row->ispart==1) {
                $this->OptionArrayList .= "<option value='".$row->id."' style='background-color:#EFEFEF;color:#666666'>$step".$row->depname."</option>\r\n";
            }
            else {
                $this->OptionArrayList .= "<option value='".$row->id."'>$step".$row->depname."</option>\r\n";
            }
            $this->LogicGetOptionArray($row->id, $step."��", $oper);
        }
    }

    /**
     *  ����������ص���Ŀ��������Ӧ����ģ����{dede:channel}{/dede:channel}��
     *  $typetype ��ֵΪ�� sun �¼����� self ͬ������ top ��������
     *
     * @access    public
     * @param     int   $depid   ����ID
     * @param     int   $reid   ����ID
     * @param     int   $row   ��������
     * @param     string   $typetype   ��������
     * @param     string   $innertext   �ײ�ģ��
     * @param     int   $col   ��ʾ����
     * @param     int   $tablewidth   �����
     * @param     int   $myinnertext   �Զ���ײ�ģ��
     * @return    string
     */
    function GetChannelList($depid=0, $reid=0, $row=8, $typetype='sun', $innertext='',
    $col=1, $tablewidth=100, $myinnertext='')
    {
        if($depid==0) $depid = $this->depid;
        if($row=="") $row = 8;
        if($reid=="") $reid = 0;
        if($col=="") $col = 1;

        $tablewidth = str_replace("%","",$tablewidth);
        if($tablewidth=="") $tablewidth=100;
        if($col=="") $col = 1;

        $colWidth = ceil(100/$col);
        $tablewidth = $tablewidth."%";
        $colWidth = $colWidth."%";
        if($typetype=="") $typetype="sun";

        if($innertext=="") $innertext = GetSysTemplets("channel_list.htm");

        if($reid==0 && $depid>0)
        {
            $dbrow = $this->dsql->GetOne("SELECT reid FROM #@__dep WHERE id='$depid' ");
            if(is_array($dbrow))
            {
                $reid = $dbrow['reid'];
            }
        }
        $likeType = "";
        if($typetype=="top")
        {
            $sql = "SELECT id,depname,typedir,isdefault,ispart,defaultname,namerule2,moresite,siteurl
          FROM #@__dep WHERE reid=0 AND ishidden<>1 ORDER BY sortrank ASC limit 0,$row";
        }
        else if($typetype=="sun"||$typetype=="son")
        {
            $sql = "SELECT id,depname,typedir,isdefault,ispart,defaultname,namerule2,moresite,siteurl
          FROM #@__dep WHERE reid='$depid' AND ishidden<>1 ORDER BY sortrank ASC limit 0,$row";
        }
        else if($typetype=="self")
        {
            $sql = "SELECT id,depname,typedir,isdefault,ispart,defaultname,namerule2,moresite,siteurl
            FROM #@__dep WHERE reid='$reid' AND ishidden<>1 ORDER BY sortrank ASC limit 0,$row";
        }

        //AND ID<>'$depid'
        $dtp2 = new DedeTagParse();
        $dtp2->SetNameSpace("field","[","]");
        $dtp2->LoadSource($innertext);
        $this->dsql->SetQuery($sql);
        $this->dsql->Execute();
        $line = $row;
        $GLOBALS['autoindex'] = 0;
        if($col>1)
        {
            $likeType = "<table width='$tablewidth' border='0' cellspacing='0' cellpadding='0'>\r\n";
        }
        for($i=0;$i<$line;$i++)
        {
            if($col>1)
            {
                $likeType .= "<tr>\r\n";
            }
            for($j=0;$j<$col;$j++)
            {
                if($col>1) $likeType .= "    <td width='$colWidth'>\r\n";
                if($row=$this->dsql->GetArray())
                {
                    //����ǰ���ŵ���ʽ
                    if($row['id']=="$depid" && $myinnertext != '')
                    {
                        $linkOkstr = $myinnertext;
                        $row['typelink'] = $this->GetOneTypeUrl($row);
                        $linkOkstr = str_replace("~typelink~", $row['typelink'], $linkOkstr);
                        $linkOkstr = str_replace("~depname~", $row['depname'], $linkOkstr);
                        $likeType .= $linkOkstr;
                    }
                    else
                    {
                        //�ǵ�ǰ����
                        $row['typelink'] = $this->GetOneTypeUrl($row);
                        if(is_array($dtp2->CTags))
                        {
                            foreach($dtp2->CTags as $tagid=>$ctag)
                            {
                                if(isset($row[$ctag->GetName()]))
                                {
                                    $dtp2->Assign($tagid, $row[$ctag->GetName()]);
                                }
                            }
                        }
                        $likeType .= $dtp2->GetResult();
                    }
                }
                if($col>1)
                {
                    $likeType .= "    </td>\r\n";
                }
                $GLOBALS['autoindex']++;
            }//Loop Col

            if($col>1)
            {
                $i += $col - 1;
            }
            if($col>1)
            {
                $likeType .= "    </tr>\r\n";
            }
        }//Loop for $i

        if($col>1)
        {
            $likeType .= "    </table>\r\n";
        }
        $this->dsql->FreeResult();
        return $likeType;
    }//GetChannel

}//End Class