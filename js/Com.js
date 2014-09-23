

function getUrlParam(name)
{
	var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
	var r = window.location.search.substr(1).match(reg);  //匹配目标参数
	if (r!=null) 
		return unescape(r[2]); 
	return null; //返回参数值
}

function intal()
{
	var href = location.href;
	var index=href.indexOf('changepass');
	if(index > -1)
	{
		jQuery('.li01').removeClass('li01_o');
		jQuery('.li02').addClass('li02_o');
	}
	 alert(index);
}
intal();