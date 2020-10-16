<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * 验证小助手
 *
 * @version        $Id: validate.helper.php 1 07-05 11:43:09Z tianya $
 * @package        Helpers
 
 */

//邮箱格式检查
if ( ! function_exists('CheckEmail'))
{
    function CheckEmail($email)
    {
        if (!empty($email))
        {
            return preg_match('/^[a-z0-9]+([\+_\-\.]?[a-z0-9]+)*@([a-z0-9]+[\-]?[a-z0-9]+\.)+[a-z]{2,6}$/i', $email);
        }
        return FALSE;
    }
}

