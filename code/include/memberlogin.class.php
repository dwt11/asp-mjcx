<?php   if(!defined('DEDEINC')) exit('Request Error!');
/**
 * 会员登录类
 *
 * @version        $Id: userlogin.class.php 1 15:59 5日Z tianya $
 * @package        Libraries
 */

// 使用缓存助手
helper('cache');
/**
 *  检查用户名的合法性
 *
 * @access    public
 * @param     string  $uid  用户UID
 * @param     string  $msgtitle  提示标题
 * @param     string  $ckhas  检查是否存在
 * @return    string
 */

/**
 * 网站会员登录类
 *
 * @package          MemberLogin
 * @subpackage       Libraries
 * @link             http://www.
 */
class MemberLogin
{
    var $M_ID;
    var $M_LoginID;
    var $M_MbType;
    var $M_Money;
    var $M_Scores;
    var $M_UserName;
    var $M_Rank;
     var $M_Face;
    var $M_LoginTime;
    var $M_KeepTime;
    var $M_Spacesta;
    var $fields;
    var $isAdmin;
    var $M_UpTime;
    var $M_ExpTime;
    var $M_HasDay;
    var $M_JoinTime;
    var $M_Honor = '';
    var $memberCache='memberlogin';

    //php5构造函数
    function __construct($kptime = -1, $cache=FALSE)
    {
        global $dsql;
        if($kptime==-1){
            $this->M_KeepTime = 3600 * 24 * 7;
        }else{
            $this->M_KeepTime = $kptime;
        }
        $formcache = FALSE;
        $this->M_ID = GetCookie("DedeUserID");
        $this->M_LoginTime = GetCookie("DedeLoginTime");
        $this->fields = array();
        $this->isAdmin = FALSE;
        if(empty($this->M_ID))
        {
            $this->ResetUser();
        }else{
            $this->M_ID = intval($this->M_ID);
            
            if ($cache)
            {
                $this->fields = GetCache($this->memberCache, $this->M_ID);
                if( empty($this->fields) )
                {
                    $this->fields = $dsql->GetOne("Select * From `#@__member` where mid='{$this->M_ID}' ");
                } else {
                    $formcache = TRUE;
                }
            } else {
                $this->fields = $dsql->GetOne("Select * From `#@__member` where mid='{$this->M_ID}' ");
            }
                
            if(is_array($this->fields)){
               
            
                //间隔一小时更新一次用户登录时间
                if(time() - $this->M_LoginTime > 3600)
                {
                    $dsql->ExecuteNoneQuery("update `#@__member` set logintime='".time()."',loginip='".GetIP()."' where mid='".$this->fields['mid']."';");
                    PutCookie("DedeLoginTime",time(),$this->M_KeepTime);
                }
                $this->M_LoginID = $this->fields['userid'];
                $this->M_MbType = $this->fields['mtype'];
                $this->M_Money = $this->fields['money'];
                $this->M_UserName = $this->fields['uname'];
                $this->M_Scores = $this->fields['scores'];
                $this->M_Face = $this->fields['face'];
                $this->M_Rank = $this->fields['rank'];
                $this->M_Spacesta = $this->fields['spacesta'];
                $sql = "Select titles From #@__scores where integral<={$this->fields['scores']} order by integral desc";
                $scrow = $dsql->GetOne($sql);
                $this->fields['honor'] = $scrow['titles'];
                $this->M_Honor = $this->fields['honor'];
                if($this->fields['matt']==10) $this->isAdmin = TRUE;
                $this->M_UpTime = $this->fields['uptime'];
                $this->M_ExpTime = $this->fields['exptime'];
                $this->M_JoinTime = MyDate('Y-m-d',$this->fields['jointime']);
                if($this->M_Rank>10 && $this->M_UpTime>0){
                    $this->M_HasDay = $this->Judgemember();
                }
                if( !$formcache )
                {
                    SetCache($this->memberCache, $this->M_ID, $this->fields, 1800);
                }
            }else{
                $this->ResetUser();
            }
        }
    }

    function MemberLogin($kptime = -1)
    {
        $this->__construct($kptime);
    }
    
    /**
     *  删除缓存,每次登录时和在修改用户资料的地方会清除
     *
     * @access    public
     * @param     string
     * @return    string
     */
    function DelCache($mid)
    {
        DelCache($this->memberCache, $mid);
    }
    
    /**
     *  判断会员是否到期
     *
     * @return    string
     */
    function Judgemember()
    {
        global $dsql,$cfg_mb_rank;
        $nowtime = time();
        $mhasDay = $this->M_ExpTime - ceil(($nowtime - $this->M_UpTime)/3600/24) + 1;
        if($mhasDay <= 0){
           $dsql->ExecuteNoneQuery("UPDATE `#@__member` SET uptime='0',exptime='0',
                                         rank='$cfg_mb_rank' WHERE mid='".$this->fields['mid']."';");
        }
        return $mhasDay;
    }

    /**
     *  退出cookie的会话
     *
     * @return    void
     */
    function ExitCookie()
    {
        $this->ResetUser();
    }

    /**
     *  验证用户是否已经登录
     *
     * @return    bool
     */
    function IsLogin()
    {
        if($this->M_ID > 0) return TRUE;
        else return FALSE;
    }

   
    //
    /**
     *  重置用户信息
     *
     * @return    void
     */
    function ResetUser()
    {
        $this->fields = '';
        $this->M_ID = 0;
        $this->M_LoginID = '';
        $this->M_Rank = 0;
        $this->M_Face = "";
        $this->M_Money = 0;
        $this->M_UserName = "";
        $this->M_LoginTime = 0;
        $this->M_MbType = '';
        $this->M_Scores = 0;
        $this->M_Spacesta = -2;
        $this->M_UpTime = 0;
        $this->M_ExpTime = 0;
        $this->M_JoinTime = 0;
        $this->M_HasDay = 0;
        DropCookie('DedeUserID');
        DropCookie('DedeLoginTime');
    }

   

    /**
     *  用户登录
     *  把登录密码转为指定长度md5数据
     *
     * @access    public
     * @param     string  $pwd  需要加密的密码
     * @return    string
     */
    function GetEncodePwd($pwd)
    {
        global $cfg_mb_pwdtype;
        if(empty($cfg_mb_pwdtype)) $cfg_mb_pwdtype = '32';
        switch($cfg_mb_pwdtype)
        {
            case 'l16':
                return substr(md5($pwd), 0, 16);
            case 'r16':
                return substr(md5($pwd), 16, 16);
            case 'm16':
                return substr(md5($pwd), 8, 16);
            default:
                return md5($pwd);
        }
    }
    
    /**
     *  把数据库密码转为特定长度
     *  如果数据库密码是明文的，本程序不支持
     *
     * @access    public
     * @param     string
     * @return    string
     */
    function GetShortPwd($dbpwd)
    {
        global $cfg_mb_pwdtype;
        if(empty($cfg_mb_pwdtype)) $cfg_mb_pwdtype = '32';
        $dbpwd = trim($dbpwd);
        if(strlen($dbpwd)==16)
        {
            return $dbpwd;
        }
        else
        {
            switch($cfg_mb_pwdtype)
            {
                case 'l16':
                    return substr($dbpwd, 0, 16);
                case 'r16':
                    return substr($dbpwd, 16, 16);
                case 'm16':
                    return substr($dbpwd, 8, 16);
                default:
                    return $dbpwd;
            }
        }
    }
    
    /**
     *  检查用户是否合法
     *
     * @access    public
     * @param     string  $loginpwd  密码
     * @return    string
     */
    function CheckUser( $loginpwd)
    {
        global $dsql;


        //matt=10 是管理员关连的前台帐号，为了安全起见，这个帐号只能从后台登录，不能直接从前台登录
        $row = $dsql->GetOne("SELECT mid,matt,pwd,logintime FROM `#@__member` WHERE userid LIKE '$loginuser' ");
        if(is_array($row))
        {
            if($this->GetShortPwd($row['pwd']) != $this->GetEncodePwd($loginpwd))
            {
                return -2;
            }
            else
            {
               
                    $this->PutLoginInfo($row['mid'], $row['logintime']);
                    return 1;
              
            }
        }
       
	   
	      return 0;
        
    }

    /**
     *  保存用户cookie
     *
     * @access    public
     * @param     string  $uid  用户ID
     * @param     string  $logintime  登录限制时间
     * @return    void
     */
    function PutLoginInfo($uid, $logintime=0)
    {
        global $cfg_login_adds, $dsql;
        //登录增加积分(上一次登录时间必须大于两小时)
        if(time() - $logintime > 7200 && $cfg_login_adds > 0)
        {
            $dsql->ExecuteNoneQuery("Update `#@__member` set `scores`=`scores`+{$cfg_login_adds} where mid='$uid' ");
        }
        $this->M_ID = $uid;
        $this->M_LoginTime = time();
        $loginip = GetIP();
        $inquery = "UPDATE `#@__member` SET loginip='$loginip',logintime='".$this->M_LoginTime."' WHERE mid='".$uid."'";
        $dsql->ExecuteNoneQuery($inquery);
        if($this->M_KeepTime > 0)
        {
            PutCookie('DedeUserID',$uid,$this->M_KeepTime);
            PutCookie('DedeLoginTime',$this->M_LoginTime,$this->M_KeepTime);
        }
        else
        {
            PutCookie('DedeUserID',$uid);
            PutCookie('DedeLoginTime',$this->M_LoginTime);
        }
    }

    
}//End Class