<?php   if(!defined('DEDEINC')) exit("Request Error!");
/**
 * ģ�ͻ���
 *
 * @version        $Id: model.class.php 1 13:46 12-1 tianya $
 * @package        Libraries
 
 */

class Model
{
    var $dsql;
    var $db;
    
    // ��������
    function Model()
    {
        global $dsql;
        if ($GLOBALS['cfg_mysql_type'] == 'mysqli')
        {
            $this->dsql = $this->db = isset($dsql)? $dsql : new DedeSqli(FALSE);
        } else {
            $this->dsql = $this->db = isset($dsql)? $dsql : new DedeSql(FALSE);
        }
            
    }
    
    // �ͷ���Դ
    function __destruct() 
    {
        $this->dsql->Close(TRUE);
    }
}