<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>日志管理</title>
<link rel="stylesheet" href="tipbox/jquery.cluetip.css" type="text/css" />
<script src="js/jquery.min.js"></script>
<script language="javascript" src="/js/dedeajax2.js"></script>
<script src="js/main.js"></script>
<script language="javascript">
function isdel(id){
		if(confirm('您确定要删除此内容吗？')){
			location.href='?dopost=del&id='+id;
		}
	}
  </script>
    <link href="css/base.css" rel="stylesheet" type="text/css" />
</head>
<body background="images/allbg.gif" leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#cfcfcf;">
  <tr>
    <td height="28" colspan="8" bgcolor="#EDF9D5" background='images/tbg.gif'><table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <form name="form2" method="get" action="log.php">
            <td width='200px'><a href="log_add.php" >添加</a> </td>
            <td width='300px'><input name="mid" type="text" id="mid" class="input" value="<?php echo $mid;?>">
              
              <input name="imageField" type="submit" value="搜索" class='np coolbg' /></td>
          </form>
          <td >&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr bgcolor="#FBFCE2">
    <td  align="center">ID</td>
    <td align="center">日期</td>
    <td  align="center">类型</td>
    <td align="center">修改标题</td>
    <td  align="center">修改内容</td>
    <td  align="center">网站</td>
    <td  align="center">备注</td>
    <td  align="center">操作</td>
  </tr>
  <form name="form1">
    <?php $record11=0;
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
      </td>
    
    <tr bgcolor='#ffffff' onMouseMove="javascript:this.bgColor='#009FCC';" onMouseOut="javascript:this.bgColor='#FFffff';">
      <td align="center" style='white-space:nowrap; '><input  type="hidden" name='aids' value='<?php echo $fields['id'];?>'  class='np'>
        <?php
 		$crmid=$fields['id'];
  echo $crmid?></td>
      <td align="center" style='white-space:nowrap; ' ><?php echo GetDateMk($fields['editdate']);?></td>
      <td  align="center" style='white-space:nowrap; ' ><?php echo GetPType($fields['edittype']);?></td>
      <td style='white-space:nowrap; '  <?php if($fields['iszy']==1)echo "bgcolor='#FF0000'";?>><a href="?mid=<?php echo $fields['edittitle'];?>"><?php echo $fields['edittitle'];?></a></td>
      <td ><?php echo $fields['body'];?></td>
      <td align="center"  style='white-space:nowrap; '><?php echo GetFormSite($fields['formsite']);?></td>
      <td style='white-space:nowrap; '><?php echo $fields['bz'];?></td>
      <td  style='white-space:nowrap; '>
        <a href="log_edit.php?id=<?php echo $fields['id'];?>">编辑</a> <a href='javascript:isdel(<?php echo $fields['id'];?>);'>删除</a> 
        <!-- <a href='?dopost=tk&aid=".$fields['aid']."'>退款</a><?php if($fields['action_type']=='archive'&&$fields['sta']!=9&&$fields['sta']!=10){echo " <a href='?dopost=send&aid=".$fields['aid']."'>发送</a>";}?>
--></td>
    </tr>
   
    <?php
}
}?>
  </form>

  <tr>
    <td height="36" colspan="8" bgcolor="#F9FCEF" align="center"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listitem'] = 'info,index,end,pre,next,pageno';
$atts['listsize'] = '5';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
</table>
<script src="tipbox/jquery.cluetip.min.js"></script> 
<script>$(document).ready(function() {

  for(i=0;i<document.form1.aids.length;i++)
	{
	$('#sticky'+[i]).cluetip({sticky: true, closePosition: 'title', arrows: true });
	//alert('#sticky'+[i]);
	}
  })
.prependTo('#container');
</script>
</body>
</html>