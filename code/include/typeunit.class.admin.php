<?php  




 if(!defined('DEDEINC')) exit('Request Error!');
/**
 * 部门单元,主要用户管理后台管理处
 *
 * @version        $Id: typeunit.class.admin.php 1 15:21 5日Z tianya $
 * @package        Libraries
 
 */
 

/**
 * 部门单元,主要用户管理后台管理处
 *
 * @package          TypeUnit
 * @subpackage       Libraries
 * @link             http://www.
 */
class TypeUnit
{
    var $dsql;
    var $artDir;
    var $baseDir;
    var $idCounter;
    var $idArrary;
    var $shortName;
    var $CatalogNums;

    //php5构造函数
    function __construct()
    {
        $this->idCounter = 0;
        //$this->artDir = $GLOBALS['cfg_cmspath'].$GLOBALS['cfg_arcdir'];
        //$this->baseDir = $GLOBALS['cfg_basedir'];
        //$this->shortName = $GLOBALS['art_shortname'];
        $this->idArrary = '';
        $this->dsql = 0;
    }

    function TypeUnit()
    {
        $this->__construct();
    }

    //清理类
    function Close()
    {
    }

    
  
    function GetTotalArc($tid)
    {
       
        if(!isset($this->CatalogNums[$tid]))
        {
            return 0;
        }
        else
        {
            $totalnum = 0;
            $ids = explode(',',GetSonIds($tid));
            foreach($ids as $tid)
            {
                if(isset($this->CatalogNums[$tid]))
                {
                    $totalnum += $this->CatalogNums[$tid];
                }
            }
            return $totalnum;
        }
    }

    /**
     *  读出所有分类,在类目管理页(list_type)中使用
     *
     * @access    public
     * @param     int   $channel  频道ID
     * @param     int   $nowdir  当前操作ID
     * @return    string
     */
    function ListAllType($channel=0,$nowdir=0)
    {
        global $cfg_admin_channel, $admin_catalogs;
        $this->dsql = $GLOBALS['dsql'];
           //echo DEDEINC.$GLOBALS['dsql'];
        
       

        $this->dsql->SetQuery("SELECT * FROM `#@__dep` WHERE reid=0 order by sortrank");
        $this->dsql->Execute(0);
        while($row = $this->dsql->GetObject(0))
        {
		    if( $cfg_admin_channel=='array' && !in_array($row->id, $admin_catalogs) )
            {
                continue;
            }
            $depname = $row->depname;
            $id = $row->id;
            $rank = $row->sortrank;
            echo "<table width='100%' border='0' cellspacing='0' cellpadding='2'>\r\n";
                echo "  <tr>\r\n";
                echo "  <td style='background-color:#FBFCE2;' width='2%' class='bline'><img style='cursor:pointer' id='img".$id."' onClick=\"LoadSuns('suns".$id."',$id);\" src='images/dedeexplode.gif' width='11' height='11'></td>\r\n";
                echo "  <td style='background-color:#FBFCE2;' class='bline'><table width='98%' border='0' cellspacing='0' cellpadding='0'><tr><td width='50%'>".$depname;
                echo "    </td><td align='right'>";
                echo "<a href='dep_add.php?id={$id}'>增加子类</a>";
                echo "|<a href='dep_edit.php?id={$id}'>更改</a>";
                echo "|<a href='dep_del.php?id={$id}&typeoldname=".urlencode($depname)."'>删除</a>";
                echo "&nbsp; <input type='text' name='sortrank{$id}' value='{$rank}' style='width:25px;height:20px'></td></tr></table></td></tr>\r\n";
            echo "  <tr><td colspan='2' id='suns".$id."'>";
            $lastid = GetCookie('lastdepid');
            if($channel==$id || $lastid==$id || isset($GLOBALS['exallct']) || $cfg_admin_channel=='array')
            {
                echo "    <table width='100%' border='0' cellspacing='0' cellpadding='0'>\r\n";
                $this->LogicListAllSunType($id,"　");
                echo "    </table>\r\n";
            }
            echo "</td></tr>\r\n</table>\r\n";
        }
    }

    /**
     *  获得子类目的递归调用
     *
     * @access    public
     * @param     int  $id  部门ID
     * @param     string  $step  层级标志
     * @return    void
     */
    function LogicListAllSunType($id, $step)
    {
        global $cfg_admin_channel, $admin_catalogs;
        $fid = $id;
        $this->dsql->SetQuery("SELECT * FROM `#@__dep` WHERE reid='".$id."' order by sortrank");
        $this->dsql->Execute($fid);
        if($this->dsql->GetTotalRow($fid)>0)
        {
            while($row = $this->dsql->GetObject($fid))
            {
                if($cfg_admin_channel=='array' && !in_array($row->id, $admin_catalogs) )
                {
                    continue;
                }
                $depname = $row->depname;
                $reid = $row->reid;
                $id = $row->id;
                if($step=="　")
                {
                    $stepdd = 2;
                }
                else
                {
                    $stepdd = 3;
                }
                $rank = $row->sortrank;
                    echo "<tr height='24' oncontextmenu=\"CommonMenu(event,this,$id,'".urlencode($depname)."')\">\r\n";
                    echo "<td class='nbline'>";
                    echo "<table width='98%' border='0' cellspacing='0' cellpadding='0'>";
                    echo "<tr onMouseMove=\"javascript:this.bgColor='#FAFCE0';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\"><td width='50%'>";
                    echo "$step  ".$depname."(人数：".$this->GetTotalArc($id).")";
                    echo "</td><td align='right'>";
                    echo "<a href='dep_edit.php?id={$id}'>更改</a>";
                    echo "|<a href='dep_del.php?id={$id}&typeoldname=".urlencode($depname)."'>删除</a>";
                    echo "&nbsp; <input type='text' name='sortrank{$id}' value='{$rank}' style='width:25px;height:20px'></td></tr></table></td></tr>\r\n";
                echo "  <tr><td id='suns".$id."' style='display:none'><table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                $this->LogicListAllSunType($id,$step."　");
                echo "</table></td></tr>\r\n";
            }
        }
    }

    /**
     *  返回与某个目相关的下级目录的类目ID列表(删除类目或文章时调用)
     *
     * @access    public
     * @param     int   $id  部门ID
     * @param     int   $channel  频道ID
     * @return    array
     */
    function GetSunTypes($id, $channel=0)
    {
        $this->dsql = $GLOBALS['dsql'];
        $this->idArray[$this->idCounter]=$id;
        $this->idCounter++;
        $fid = $id;
        if($channel!=0)
        {
            $csql = " And channeltype=$channel ";
        }
        else
        {
            $csql = "";
        }
        $this->dsql->SetQuery("SELECT id FROM `#@__dep` WHERE reid=$id $csql");
        $this->dsql->Execute("gs".$fid);

        //if($this->dsql->GetTotalRow("gs".$fid)!=0)
        //{
        while($row=$this->dsql->GetObject("gs".$fid))
        {
            $nid = $row->id;
            $this->GetSunTypes($nid,$channel);
        }
        //}
        return $this->idArray;
    }

    /**
     *  删除类目
     *
     * @access    public
     * @param     int   $id  部门ID
     * @return    string
     */
    function DelType($id)
    {

            $this->dsql = $GLOBALS['dsql'];
        //删除数据库信息
            $this->dsql->ExecuteNoneQuery("DELETE FROM `#@__dep` WHERE id='$id'");
        return TRUE;
    }

   
}//End Class