//获取随机整数
function getRan(min,max){
	//min随机最小值  max随机最大值
	return Math.floor(Math.random()*(max-min+1))+min;
}
//数组去重
function delRepeat(arr){
	//arr 需要去重的数组
	var res = [];
	for(var i=0;i<arr.length;i++){
		var flag = false;//记录要推入新数组的旧数组元素是否有相同的元素
		for(var j=0;j<res.length;j++){
			if(arr[i]==res[j]){
				flag = true;
				break;
			}
		}
		if(flag){
			continue;
		}
		res.push(arr[i]);
	}
	return res;
}
//保留小数位 结果转换为数字
function toFixedNum(num,digit){
	//num 需要处理的数字  digit 需要保留的小数点后位数
	if(typeof num=="number"){
		return Number(num.toFixed(digit));
	}else{
		alert("请输入数字");
	}
}
//获取16进制随机颜色
function getRanColor(){
	var oR = parseInt(getRan(0,255),10).toString(16);
	var oG = parseInt(getRan(0,255),10).toString(16);
	var oB = parseInt(getRan(0,255),10).toString(16);
	oR = oR.length==2?oR:("0"+oR);
	oG = oG.length==2?oG:("0"+oG);
	oB = oB.length==2?oB:("0"+oB);
	var colorVal = "#"+oR+oG+oB;
	return colorVal;
}

//			获取元素的子元素
function getAllChildren(par){
	var res = [];
	function a(par){
		
		var child = par.children;
		for(var i=0;i<child.length;i++){
			res.push(child[i]);
			if(child[i].children.length!=0){
				a(child[i]);
			}
		}
	}
	a(par);
	return res;
}

//通过类名获取元素
function getClass(par,cName){
	//par 父元素  cName 类名
	var selectedEle = [];
	var allChildren = getAllChildren(par);
	var reg = /\s+/g;
	for(var i=0;i<allChildren.length;i++){
		var cNameArr = allChildren[i].className.split(reg);
		for(var j=0;j<cNameArr.length;j++){
			if(cNameArr[j]==cName){
				selectedEle.push(allChildren[i]);
				break;
			}
		}
	}
	return selectedEle;
}

//获取传入的ele元素之后所有的标签兄弟节点
function getAllNextEleSibling(ele){
	var res = [];
	function a(ele){
		if(ele.nextElementSibling){
			res.push(ele.nextElementSibling);
			a(ele.nextElementSibling);
		}
	}
	a(ele);
	return res;
}

//获取传入的ele元素 所有的标签兄弟节点
function getAllEleSibling(ele){
	var res = [];
	var par = ele.parentNode;
	var children = par.children;
	for(var i=0,len=children.length;i<len;i++){
		if(children[i]!=ele){
			res.push(children[i]);
		}
	}
	return res;
}

//在refEle之后插入newEle
function insertAfter(newEle,refEle){
	var nextEle = refEle.nextElementSibling;
	if(nextEle){
		nextEle.parentNode.insertBefore(newEle,nextEle)
	}else{
		refEle.parentNode.appendChild(newEle);
	}
}

//除refEle之外所有兄弟元素全部删除
function keepRefDelAll(refEle){
	var par = refEle.parentNode;
	par.innerHTML = "";
	par.appendChild(refEle);
}

//将refEle元素 替换成 newEle
function eleReplace(newEle,refEle){
	var nextEle = refEle.nextElementSibling;
	var par = refEle.parentNode;
	par.removeChild(refEle);
	if(nextEle){
		par.insertBefore(newEle,nextEle);
	}else{
		par.appendChild(newEle);
	}
}

//取得ele外层元素中与selector选择器符合的元素
function getOuterEle(ele,selector){
	var res;
	var firstChar = selector.slice(0,1);
	if(firstChar=="."){
		var cName = selector.slice(1,selector.length);
		a(ele,cName);
	}else{
		var tagName = selector;
		b(ele,tagName);
	}
	function a(ele,cName){
		var par = ele.parentNode;
		var reg = /\s+/g;
		var parCnameArr = par.className.split(reg);
		for(var i=0,len=parCnameArr.length;i<len;i++){
			if(parCnameArr[i]==cName){
				res = par;
			}else{
				a(par,cName);
			}
		}
	}
	
	function b(ele,tagName){
		var par = ele.parentNode;
		if(tagName==par.tagName.toLowerCase()){
			res = par;
		}else{
			b(par,tagName);
		}
	}
	
	return res;
}

var oCookie = {
	setCookie:function(data,day){
		var endDate = new Date();
		endDate.setTime(endDate.getTime()+1000*60*60*24*day);
		for(var key in data){
			document.cookie = key+"="+data[key]+";expires="+endDate.toGMTString();
		}
	},
	delCookie:function(key){
		var endDate = new Date();
		endDate.setTime(endDate.getTime() - 1000*60);
		document.cookie = key+"=123;expires="+endDate.toGMTString();
	},
	getCookie:function(key){
		var res;
		var cookieReg = /\s+/g;
		var cookies = document.cookie.replace(cookieReg,"");
		var cookiesArr = cookies.split(";");
		var cookieJson = {};
		for(var i=0;i<cookiesArr.length;i++){
			var keyValArr = cookiesArr[i].split("=");
			cookieJson[keyValArr[0]] = keyValArr[1];
		}
		if(key){
			res = cookieJson[key];
		}else{
			res = cookieJson;
		}
		return res;
	}
}
function ajax(info){
	var url = info.url;
	var type = info.type||"GET";
	type = type.toUpperCase();
	var data = info.data||"";
	var sync = info.sync||true;
	var xhr;
	if((typeof data).toLowerCase()=="object"){
		var res = "";
		for(var key in data){
			res = res + key +"="+data[key]+"&";
		}
		data = res;
	}
	if(window.XMLHttpRequest){
		xhr = new XMLHttpRequest();
	}else{
		xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if(type=="GET"){
		xhr.open(type,url+"?"+data+"t="+ new Date().getTime(),sync);
		xhr.send();
	}else{
		xhr.open(type,url,sync);
//					不设置这个请求头的话 后台无法正确获取ajax POST方式传输的数据
		xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
		xhr.send(data);
	}
	xhr.onreadystatechange = function(){
		if(xhr.readyState==4){
			if(xhr.status>=200&&xhr.status<300){
				info.success(xhr.responseText);
			}
		}
	}
}