<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * ��֤С����
 *
 * @version        $Id: validate.helper.php 1 07-05 11:43:09Z tianya $
 * @package        Helpers
 
 */

//�����ʽ���
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

