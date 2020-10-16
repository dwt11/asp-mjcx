<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * �ϴ�����С����
 *
 
 */

/**
 *  ����Ա�ϴ��ļ���ͨ�ú���
 *
 * @access    public
 * @param     string  $uploadname  �ϴ�����
 * @param     string  $ftype  �ļ�����
 * @return    int   -1 ûѡ���ϴ��ļ���0 �ļ����Ͳ�����, -2 ����ʧ�ܣ������������ϴ�����ļ���
 */
if ( ! function_exists('AdminUpload'))
{
    function AdminUpload($uploadname, $ftype='image',$empid )
    {
        global $dsql, $cuserLogin, $cfg_addon_savetype, $cfg_dir_purview;
        global $cfg_basedir, $cfg_image_dir, $cfg_soft_dir, $cfg_other_medias;
        global $cfg_imgtype, $cfg_softtype, $cfg_mediatype;
        if($watermark) include_once(DEDEINC.'/image.func.php');
        
        $file_tmp = isset($GLOBALS[$uploadname]) ? $GLOBALS[$uploadname] : '';
        if($file_tmp=='' || !is_uploaded_file($file_tmp) )
        {
            return -1;
        }
        
        $file_tmp = $GLOBALS[$uploadname];
        $file_size = filesize($file_tmp);
        $file_type = $filetype=='' ? strtolower(trim($GLOBALS[$uploadname.'_type'])) : $filetype;
        
        $file_name = isset($GLOBALS[$uploadname.'_name']) ? $GLOBALS[$uploadname.'_name'] : '';
        $file_snames = explode('.', $file_name);
        $file_sname = strtolower(trim($file_snames[count($file_snames)-1]));
        
       
            $sparr = Array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/png', 'image/xpng', 'image/wbmp');
            if(!in_array($file_type, $sparr)) return 0;
            if($file_sname=='')
            {
                if($file_type=='image/gif') $file_sname = 'jpg';
                else if($file_type=='image/png' || $file_type=='image/xpng') $file_sname = 'png';
                else if($file_type=='image/wbmp') $file_sname = 'bmp';
                else $file_sname = 'jpg';
            }

        
      
       
        $fileurl = '/uploads/'.$empid.'.'.$file_sname;
		echo $fileurl ;
        $rs = move_uploaded_file($file_tmp, $cfg_basedir.$fileurl);
        if(!$rs) return -2;
        if($ftype=='image' && $watermark)
        {
            WaterImg($cfg_basedir.$fileurl, 'up');
        }
        
       
        return $fileurl;
    }
}


