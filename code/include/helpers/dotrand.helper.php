<?php  if(!defined('DEDEINC')) exit('dedecms');
/**
 * 
 *
 * @version        $Id: test.helper.php 5 15:01 5日Z tianya $
 * @package        Helpers
 
 */

//随机数字小助手arc.listview.class.php用，生成随机附件大小和文章字数 
if ( ! function_exists('dotrand'))
{
    	
	//110115添加随机数字函数
function dotrand($startnum,$endnum,$sdot=0,$edot=99){
        $newnum = rand($startnum,$endnum);
        $newdot = rand($sdot,$edot);
        if (strlen($newdot) == "1"){
                $newdot = "0".$newdot;
        }
        return $newnum.".".$newdot;
}

}