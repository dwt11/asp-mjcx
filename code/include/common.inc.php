<?php


// �������趨,һ���ڿ�����������E_ALL,�����ܹ��������д�����ʾ
// ϵͳ�������к�,ֱ���趨ΪE_ALL || ~E_NOTICE,ȡ��������ʾ
//error_reporting(E_ALL );
error_reporting(E_ALL & ~E_NOTICE);//ֻ��ʾ ���� ����ʾ����
define('DEDEINC', str_replace("\\", '/', dirname(__FILE__) ) );
define('DEDEROOT', str_replace("\\", '/', substr(DEDEINC,0,-8) ) );
define('DEDEDATA', DEDEROOT.'/data');
// ------------------------------------------------------------------------
define('DEBUG_LEVEL', TRUE);
if (version_compare(PHP_VERSION, '5.3.0', '<')) 
{
    set_magic_quotes_runtime(0);
}
//���ժҪ��Ϣ��****�벻Ҫɾ������**** ����ϵͳ�޷���ȷ����ϵͳ©����������Ϣ
$cfg_version = 'V1.0';
$cfg_soft_lang = 'gb2312';
$cfg_soft_public = 'base';

$cfg_softname = '�Ž���Ա��ѯϵͳ';

//վ���Ŀ¼   Ҫ��120603
$cfg_basedir = preg_replace('#'.$cfg_cmspath.'\/include$#i', '', DEDEINC);
//ģ��Ĵ��Ŀ¼ Ҫ��120603
$cfg_templets_dir = $cfg_cmspath.'/templets';

//���Ŀ¼�����Ŀ¼�����ڴ�ż�������ͶƱ�����۵ȳ���ı�Ҫ��̬����
$cfg_plus_dir = $cfg_cmspath.'/plus';    // Ҫ��120603

$cfg_phpurl = $cfg_mainsite.$cfg_plus_dir;

$cfg_data_dir = $cfg_cmspath.'/data';
$cfg_dataurl = $cfg_mainsite.$cfg_data_dir;


//�Ƿ�����mb_substr�滻cn_substr�����Ч��
$cfg_is_mb = $cfg_is_iconv = FALSE;
if(function_exists('mb_substr')) $cfg_is_mb = TRUE;
if(function_exists('iconv_substr')) $cfg_is_iconv = TRUE;

function _RunMagicQuotes(&$svar)
{
    if(!get_magic_quotes_gpc())
    {
        if( is_array($svar) )
        {
            foreach($svar as $_k => $_v) $svar[$_k] = _RunMagicQuotes($_v);
        }
        else
        {
            $svar = addslashes($svar);
        }
    }
    return $svar;
}

if (!defined('DEDEREQUEST')) 
{
    //����ע���ⲿ�ύ�ı���   (8.10 �޸ĵ�¼ʱ��ع���)
    function CheckRequest(&$val) {
        if (is_array($val)) {
            foreach ($val as $_k=>$_v) {
                if($_k == 'nvarname') continue;
                CheckRequest($_k); 
                CheckRequest($val[$_k]);
            }
        } else
        {
            if( strlen($val)>0 && preg_match('#^(cfg_|GLOBALS|_GET|_POST|_COOKIE)#',$val)  )
            {
                exit('Request var not allow!');
            }
        }
    }
    CheckRequest($_REQUEST);

    foreach(Array('_GET','_POST','_COOKIE') as $_request)
    {
        foreach($$_request as $_k => $_v) 
		{
			if($_k == 'nvarname') ${$_k} = $_v;
			else ${$_k} = _RunMagicQuotes($_v);
		}
    }
}

//ϵͳ��ر������
if(!isset($needFilter))
{
    $needFilter = false;
}
$registerGlobals = @ini_get("register_globals");
$isUrlOpen = @ini_get("allow_url_fopen");
$isSafeMode = @ini_get("safe_mode");
if( preg_match('/windows/i', @getenv('OS')) )
{
    $isSafeMode = false;
}

//Session����·��
$sessSavePath = DEDEDATA."/sessions/";
if(is_writeable($sessSavePath) && is_readable($sessSavePath))
{
    session_save_path($sessSavePath);
}

//ϵͳ���ò���,��������ʱ������
require_once(DEDEDATA."/config.cache.inc.php");
//ת���ϴ����ļ���صı�������ȫ����������ǰ̨ͨ�õ��ϴ�����
if($_FILES)
{
    require_once(DEDEINC.'/uploadsafe.inc.php');
}

//���ݿ������ļ�
require_once(DEDEDATA.'/common.inc.php');

//����ϵͳ��֤��ȫ����
if(file_exists(DEDEDATA.'/safe/inc_safe_config.php'))
{
    require_once(DEDEDATA.'/safe/inc_safe_config.php');
    if(!empty($safe_faqs)) $safefaqs = unserialize($safe_faqs);
}

//Session��������
if(!empty($cfg_domain_cookie))
{
    @session_set_cookie_params(0,'/',$cfg_domain_cookie);
}

//php5.1�汾����ʱ������
//�����������������php5.1���°汾�������壬���ʵ���ϵ�ʱ����ã�Ӧ����MyDate��������
if(PHP_VERSION > '5.1')
{
    $time51 = $cfg_cli_time * -1;
    @date_default_timezone_set('Etc/GMT'.$time51);
}
$cfg_isUrlOpen = @ini_get("allow_url_fopen");

//�û����ʵ���վhost
$cfg_clihost = 'http://'.$_SERVER['HTTP_HOST'];









//�ϴ�����ͨͼƬ��·��,���鰴Ĭ��
$cfg_image_dir = $cfg_medias_dir.'/allimg';

//����ȫ�ֱ���
$_sys_globals['curfile'] = '';
$_sys_globals['typeid'] = 0;
$_sys_globals['typename'] = '';
$_sys_globals['aid'] = 0;


// ------------------------------------------------------------------------
// �趨����������Ϣ
if ($cfg_memcache_enable == 'Y')
{
    $cache_helper_config = array();
    $cache_helper_config['memcache']['is_mc_enable'] = $GLOBALS["cfg_memcache_enable"];
    $cache_helper_config['memcache']['mc'] = array (
        'default' => $GLOBALS["cfg_memcache_mc_defa"],
        'other' => $GLOBALS["cfg_memcache_mc_oth"]
    );
    $cache_helper_config['memcache']['mc_cache_time'] = $GLOBALS["cfg_puccache_time"];
}


if(!isset($cfg_NotPrintHead)) {
    header("Content-Type: text/html; charset={$cfg_soft_lang}");
}

//�Զ�������⴦��
function __autoload($classname)
{
    global $cfg_soft_lang;
    $classname = preg_replace("/[^0-9a-z_]/i", '', $classname);
    if( class_exists ( $classname ) )
    {
        return TRUE;
    }
    $classfile = $classname.'.php';
    $libclassfile = $classname.'.class.php';
        if ( is_file ( DEDEINC.'/'.$libclassfile ) )
        {
            require DEDEINC.'/'.$libclassfile;
        }
        else if( is_file ( DEDEMODEL.'/'.$classfile ) ) 
        {
            require DEDEMODEL.'/'.$classfile;
        }
        else
        {
            if (DEBUG_LEVEL === TRUE)
            {
                echo '<pre>';
				echo $classname.'���Ҳ���';
				echo '</pre>';
				exit ();
            }
            else
            {
                header ( "location:/404.html" );
                die ();
            }
        }
}

//�������ݿ���
    require_once(DEDEINC.'/dedesql.class.php');  //�����������ݿ�
	


//ȫ�ֳ��ú���
require_once(DEDEINC.'/common.func.php');

// ģ��MVC�����Ҫ�Ŀ�������ģ�ͻ���
require_once(DEDEINC.'/control.class.php');
require_once(DEDEINC.'/model.class.php');

//����С��������,���������Ĭ�ϳ�ʼ��
if(file_exists(DEDEDATA.'/helper.inc.php'))
{
    require_once(DEDEDATA.'/helper.inc.php');
    // ��û����������,���ʼ��һ��Ĭ��С��������
    if (!isset($cfg_helper_autoload))
    {
        $cfg_helper_autoload = array('util', 'charset', 'string', 'time', 'cookie');
    }
    // ��ʼ��С����
    helper($cfg_helper_autoload);
}