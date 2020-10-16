<!--

//CRM和ARC列表中显否显示子内容开关

//显示子内容COOKIE写为1 不显示写为空
//页面BODY中，加载时要判断COOKIE中的值，用以是否显示
function showHidechildlist(listname)
{
	var trs = $("tr[class='hid']"); 
	for(i = 0; i < trs.length; i++){   
			//trs[i].style.display = "none"; //这里获取的trs[i]是DOM对象而不是jQuery对象，因此不能直接使用hide()方法 
	
		if(trs[i].style.display == 'block' || trs[i].style.display =='')
		{
			trs[i].style.display = 'none';
			setCookie(listname,'',7);
		}
		else
		{
			trs[i].style.display = '';
			setCookie(listname,'1',7);
			$("#hidchild").attr("checked",true);//显示的复选框打勾
		}//return true;
	}
	
	
	
	 //正常设置cookie
	var ckstr = getCookie(listname);
	var ischange = false;
	if(trs[i].style.display == 'block' || trs[i].style.display =='')
	{
		trs[i].style.display = 'none';
		
		if(ischange) setCookie(listname,'1',7);
	}
	else
	{
		trs[i].style.display = '';
		ischange = true;
		
			
	}

}
//读写cookie函数
function getCookie(c_name)
{
	if (document.cookie.length > 0)
	{
		c_start = document.cookie.indexOf(c_name + "=")
		if (c_start != -1)
		{
			c_start = c_start + c_name.length + 1;
			c_end   = document.cookie.indexOf(";",c_start);
			if (c_end == -1)
			{
				c_end = document.cookie.length;
			}
			return unescape(document.cookie.substring(c_start,c_end));
		}
	}
	return null
}
function setCookie(c_name,value,expiredays)
{
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = c_name + "=" +escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()); //使设置的有效时间正确。增加toGMTString()
}
//检查以前用户展开的菜单项
var totalitem = 12;
function Checklistchild(c_name)
{
	
	//setCookie('menuitems','');
	var ckstr = getCookie(c_name);
var trs = $("tr[class='hid']"); 
	
	if(ckstr==1)
	{
		for(i = 0; i < trs.length; i++){   
				
				trs[i].style.display = '';
				$("#hidchild").attr("checked",true);//显示的复选框打勾
		}	
	}else
	{
		for(i = 0; i < trs.length; i++){   
				//trs[i].style.display = "none"; //这里获取的trs[i]是DOM对象而不是jQuery对象，因此不能直接使用hide()方法 
		
				trs[i].style.display = 'none';
								$("#hidchild").attr("checked",false);//显示的复选框不打勾
		}	
	}
	
}


-->