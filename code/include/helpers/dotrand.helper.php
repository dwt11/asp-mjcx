<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * 
 *
 * @version        $Id: test.helper.php 5 15:01 5��Z tianya $
 * @package        Helpers
 
 */

//�������С����arc.listview.class.php�ã��������������С���������� 
if ( ! function_exists('dotrand'))
{
    	
	//110115���������ֺ���
function dotrand($startnum,$endnum,$sdot=0,$edot=99){
        $newnum = rand($startnum,$endnum);
        $newdot = rand($sdot,$edot);
        if (strlen($newdot) == "1"){
                $newdot = "0".$newdot;
        }
        return $newnum.".".$newdot;
}

}