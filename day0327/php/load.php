<?php
	header("Access-Control-Allow-Origin:*");//允许跨域
	include "sqlCtrl.php";
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$res = json_decode(searchDB("zouxiu","userinfo",array("username"=>$username)),true);
	if($res!=""){
		if($res["password"]==$password){
			echo 1;//登录成功
		}else{
			echo 0;//密码错误
		}
	}else{
		echo 2;//账号不存在
	}
?>