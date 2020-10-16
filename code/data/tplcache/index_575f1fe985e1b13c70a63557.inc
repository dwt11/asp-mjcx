<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>员工管理</title>
<link rel="stylesheet" type="text/css" href="../dede/templets/css/base.css">
<style>
.napisdiv {left:10;top:0;width:150px;height:100px;position:absolute;z-index:3}
</style><script src="/js/jquery.min.js"></script>
<script language="javascript" src="/js/dedeajax2.js"></script>
<script language="javascript" src="/js/main.js"></script>
<script language="javascript" src="/js/listbody.js"></script>

<script language="javascript">
function ChangeImage(surl,swidth,sheight){ document.getElementById('picview').src = surl;document.getElementById('picview').width = swidth;document.getElementById('picview').height = sheight; }


function isdel(id){
		if(confirm('您确定要删除此内容吗？')){
			location.href='?dopost=del&id='+id;
		}
	}



</script>

</head>
<body leftmargin="8" topmargin="8" background='../dede/templets/images/allbg.gif'  >
<div id="floater" class="napisdiv">
<a href="javascript:;" onClick="ChangeImage('../include/dialog/img/picviewnone.gif',16,16);">
	<img src='../dede/include/dialog/img/picviewnone.gif' id='picview' name='picview' border='0' alt='单击关闭预览' style='z-index:10000'>
</a>
</div>
<SCRIPT language=JavaScript src="../dede/templets/js/float.js"></SCRIPT>

<!--  快速转换位置按钮  --><!--  搜索表单  -->
  <table width='98%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#cfcfcf' align="center" style="margin-top:8px">
    <tr bgcolor='#EEF4EA'background='../dede/templets/images/wbg.gif' >
     
     
     <td >
 <div style="float:left">
 <form name='form5' action='../dede/templets/emp_list.php' method='get'>
  ◆ <B><?php echo $GLOBALS['positionname']; ?></b>员工管理&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     
    
                 &nbsp;&nbsp;&nbsp;&nbsp;
              <select name='depid' style='width:150px'>
                <option value='0'>选择部门...</option>
                
          	<?php echo $GLOBALS['optionarr']; ?>
          
              </select>&nbsp; 关键字：<input type='text' name='keyword' value='<?php echo $GLOBALS['keyword']; ?>' style='width:120px' />
               <input name="imageField" type="submit" value="搜索" class='np coolbg' />
            
            
  </form>            
     </div>

            
            
               <div style="float:right;padding-right:6px;padding-top:6px;">
   	<a href='../dede/templets/emp_add.php' class='np coolbg'>增加</a>
   </div>
<a href="exit.php">退出</a>
</td>
         

    </tr>
  </table>


<!--  内容列表   -->
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
 
  <tr align="right" bgcolor="#F9FCEF">
  <td height="36" colspan="8" align="center">  <?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '3';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
  <form name="form2">
    <tr align="center" bgcolor="#FBFCE2" height="25">
      <td width="6%"><a href="?orderway=<?php echo $neworderway;?>&orderby=id&depid=<?php echo $depid?>&keyword=<?php echo $GLOBALS['keyword']; ?>"><b>ID</b></a></td>
       <td>员工编号</td>
       <td>员工姓名</td>
       <td>性别</td>
       <td>所属部门</td>
       <td>照片</td>
       <td>更新日期</td>
      <td>操作</td>
    </tr>
    <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
    <tr align='center' bgcolor="#FFFFFF" 	height="22" onMouseMove="javascript:this.bgColor='#009FCC';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
      <td nowrap> <a href="crm.php?mid=<?php echo $fields['id']; ?>&search_type=buyid"><?php echo $fields['id']; ?></a> </td>
      <td nowrap> <a href="crm.php?mid=<?php echo $fields['id']; ?>&search_type=buyid"><?php echo $fields['empid']; ?></a> </td>
      <td nowrap> <a href="crm.php?mid=<?php echo $fields['id']; ?>&search_type=buyid"><?php echo $fields['empname']; ?></a> </td>
            <td nowrap> <a href="crm.php?mid=<?php echo $fields['id']; ?>&search_type=buyid"><?php echo $fields['sex']; ?></a> </td>
      <td style="white-space:nowrap;"><a href='emp_list.php?depid=<?php echo $fields['depid']; ?>'><?php echo GetDepname($fields['depid']); ?></a></td>
      <td style="white-space:nowrap;"><?php echo Getface($fields['face']); ?></td>
      <td style="white-space:nowrap;"><?php echo GetDateMk($fields['updatedate']); ?></td>
 
      <td>      
<a href='emp_edit.php?id=<?php echo $fields['id']; ?>'>编辑 </a>

   <a href='javascript:isdel(<?php echo $fields['id'];?>);'>删除</a></td>
    </tr>
    
    
    
    
    
   
    
    
    
    <?php
}
}?>
   
  </form>
  <tr align="right" bgcolor="#F9FCEF">
      </td> <td height="36" colspan="8" align="center"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '3';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
</table>
</body>
</html>