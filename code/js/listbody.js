<!--

//CRM��ARC�б����Է���ʾ�����ݿ���

//��ʾ������COOKIEдΪ1 ����ʾдΪ��
//ҳ��BODY�У�����ʱҪ�ж�COOKIE�е�ֵ�������Ƿ���ʾ
function showHidechildlist(listname)
{
	var trs = $("tr[class='hid']"); 
	for(i = 0; i < trs.length; i++){   
			//trs[i].style.display = "none"; //�����ȡ��trs[i]��DOM���������jQuery������˲���ֱ��ʹ��hide()���� 
	
		if(trs[i].style.display == 'block' || trs[i].style.display =='')
		{
			trs[i].style.display = 'none';
			setCookie(listname,'',7);
		}
		else
		{
			trs[i].style.display = '';
			setCookie(listname,'1',7);
			$("#hidchild").attr("checked",true);//��ʾ�ĸ�ѡ���
		}//return true;
	}
	
	
	
	 //��������cookie
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
//��дcookie����
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
	document.cookie = c_name + "=" +escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()); //ʹ���õ���Чʱ����ȷ������toGMTString()
}
//�����ǰ�û�չ���Ĳ˵���
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
				$("#hidchild").attr("checked",true);//��ʾ�ĸ�ѡ���
		}	
	}else
	{
		for(i = 0; i < trs.length; i++){   
				//trs[i].style.display = "none"; //�����ȡ��trs[i]��DOM���������jQuery������˲���ֱ��ʹ��hide()���� 
		
				trs[i].style.display = 'none';
								$("#hidchild").attr("checked",false);//��ʾ�ĸ�ѡ�򲻴�
		}	
	}
	
}


-->