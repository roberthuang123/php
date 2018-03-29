<?php
	header("Access-Control-Allow-Origin:*");//允许跨域
	include "sqlCtrl.php";
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$phone = $_REQUEST['phone'];
	$licence = $_REQUEST['licence'];
//	insertDB($dbname,$tablename,$key,$val,$arr)
	$res = insertDB("zouxiu","userinfo","username",$username,array("username"=>$username,"password"=>$password,"phone"=>$phone,"licence"=>$licence));
	echo $res;
?>