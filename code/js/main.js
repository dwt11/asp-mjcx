<!--

var fixupPos = false;
var canMove = false;
var leftLeaning = 0;
//�첽�ϴ�����ͼ��ر���
var nForm = null;
var nFrame = null;
var picnameObj = null;
var vImg = null;

function $Nav()
{
	if(window.navigator.userAgent.indexOf("MSIE")>=1) return 'IE';
	else if(window.navigator.userAgent.indexOf("Firefox")>=1) return 'FF';
	else return "OT";
}

function $Obj(objname)
{
	return document.getElementById(objname);
}



function SeePic(img,f)
{
	if( f.value != '' ) 	img.src = f.value;
}

function SeePicNew(f, imgdid, frname, hpos, acname,fname)
{
	empid = document.getElementById(fname).value;
	if(empid == '') {
		alert('��������Ա�����');
	   document.form1.empid.focus();
		return false;
	}else
	{
		//alert('sdfsdf');
		  var newobj = null;
		  if(f.value=='') return ;
		  vImg = $Obj(imgdid);
		  picnameObj = document.getElementById('picname');
		  nFrame = $Nav()=='IE' ? eval('document.frames.'+frname) : $Obj(frname);
		  nForm = f.form;
		  //�޸�form��action�Ȳ���
		  if(nForm.detachEvent) nForm.detachEvent("onsubmit", checkSubmit);
		else nForm.removeEventListener("submit", checkSubmit, false);
		  nForm.action = 'emp_do.php';
		  nForm.target = frname;
		  nForm.dopost.value = 'uploadLitpic';
		  nForm.empid.value = empid;
		  nForm.submit();
		  
		  picnameObj.value = '';
		  newobj = $Obj('uploadwait');
		  if(!newobj)
		  {
			  newobj = document.createElement("DIV");
			  newobj.id = 'uploadwait';
			  newobj.style.position = 'absolute';
			  newobj.className = 'uploadwait';
			  newobj.style.width = 120;
			  newobj.style.height = 20;
			  newobj.style.top = hpos;
			  newobj.style.left = 100;
			  newobj.style.display = 'block';
			  document.body.appendChild(newobj);
			  newobj.innerHTML = '<img src="images/loadinglit.gif" width="16" height="16" alit="" />�ϴ���...';
		  }
		  newobj.style.display = 'block';
		  //�ύ��ԭform��action�Ȳ���
		  nForm.action = acname;
		  nForm.dopost.value = 'save';
		  nForm.target = '';
		  nForm.litpic.disabled = true;
		  //nForm.litpic = null;
		  //if(nForm.attachEvent) nForm.attachEvent("onsubmit", checkSubmit);
		//else nForm.addEventListener("submit", checkSubmit, true);
	}
}




-->