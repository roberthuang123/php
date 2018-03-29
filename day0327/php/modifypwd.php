<?php
	header("Access-Control-Allow-Origin:*");//允许跨域
	include "sqlCtrl.php";
	$password = $_REQUEST['password'];
	$username = $_REQUEST['username'];
	$phone = $_REQUEST['phone'];
	$licence = $_REQUEST['licence'];
//	searchDB($dbname,$tablename,$key,$val)
//	editDB($tablename,$updatedata,$select)
	$searchRes = json_decode(searchDB("zouxiu","userinfo",array("username"=>$username,"licence"=>$licence,"phone"=>$phone)),true);
	if($searchRes){
		echo 1;
		editDB("userinfo",array("password"=>$password),array("username"=>$username,"licence"=>$licence,"phone"=>$phone));
	}else{
		echo 0;
	}
//	$res = json_decode(editDB("userinfo",array("password"=>$password),array("username"=>$username,"licence"=>$licence)),true);
//	if($res == 1){
//		echo 1;
//	}else{
//		echo 0;
//	}
?>