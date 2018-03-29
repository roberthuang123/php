<?php
	function createDB($dbname){
//		CREATE DATABASE database_name
		$con = mysqli_connect("localhost","root","123456");//连接数据库
		$sql = "CREATE DATABASE ".$dbname;
		mysqli_query($con,$sql);
		mysqli_close($con);//用完了数据 直接断开数据库
	}
//	createDB("zouxiu");

	function createTable($dbname,$tablename,$rule){
//		"CREATE TABLE Persons 
//		(
//		FirstName varchar(15),
//		LastName varchar(15),
//		Age int
//		)"
		$con = mysqli_connect("localhost","root","123456");//连接数据库
		mysqli_select_db($con,$dbname);//进入数据库
		$ruleStr = "";
		foreach ($rule as $key => $val) {
			$ruleStr = $ruleStr.$key." ".$val.",";
		}
		$ruleStr = substr($ruleStr,0,-1);
		$sql = "CREATE TABLE ".$tablename." 
				(
				".$ruleStr."
				)";
		mysqli_query($con,$sql);
		mysqli_close($con);//用完了数据 直接断开数据库
	}
//	createTable("zouxiu","userinfo",array("username"=>"varchar(16)","password"=>"varchar(16)","phone"=>"bigint(37)","licence"=>"bigint(60)"));
	
	function dropDB($dbname){
//		drop database databasename
		$con = mysqli_connect("localhost","root","123456");//连接数据库
		mysqli_select_db($con,$dbname);//进入数据库
		$sql = "drop database ".$dbname;
		mysqli_query($con,$sql);
		mysqli_close($con);//用完了数据 直接断开数据库
	}
//	dropDB("zouxiu");
	
	function dropTable($dbname,$tablename){
//		DROP TABLE  tbl_name;
		$con = mysqli_connect("localhost","root","123456");//连接数据库
		mysqli_select_db($con,$dbname);//进入数据库
		$sql = "DROP TABLE ".$tablename;
		mysqli_query($con,$sql);
		mysqli_close($con);//用完了数据 直接断开数据库
	}
//	dropTable("zouxiu","userinfo");
	
	
	function insertDB($dbname,$tablename,$key,$val,$arr){
		$con = mysqli_connect("localhost","root","123456");//连接数据库
		mysqli_select_db($con,$dbname);//进入数据库
		$selectSql = "SELECT * From ".$tablename." WHERE ".$key."='".$val."'";//php字符串拼接出查询sql语句
		$result = mysqli_query($con,$selectSql);//执行查询语句
		$reultArr = mysqli_fetch_array($result,MYSQLI_ASSOC);//将查询的结果转换成数组
//		判断的是 是否数据库中已经有相同的条目了
		if($reultArr[$key]){
			//0代表该条目已经在数据库中存在
			return 0;
		}else{
			$tablehead = '';//存储表头字符串
			$val = '';//存储条目字符串
//			遍历拼接表头和条目字符串
			foreach($arr as $key=>$value){
				$tablehead = $tablehead.$key.",";
				$val = $val.$value."','";
			}
//			删除最后多余的符号
			$tablehead = substr($tablehead,0,-1);
			$val = substr($val,0,-3);
			//拼接出插入数据库的sql语句
			$sql = "INSERT INTO ".$tablename." (".$tablehead.") VALUES('".$val."')";
//			执行插入数据库的sql语句
			mysqli_query($con,$sql);
			return 1;//1代表插入数据成功
		}
		mysqli_close($con);//用完了数据 直接断开数据库
	}
//	insertDB("my_db","Persons","FirstName","jingwen",array("FirstName"=>"jingwen","LastName"=>"jia","Age"=>"101"));
//	insertDB("zouxiu","userinfo","username","qwer77147",array("username"=>"qwer77147","password"=>"123456","phone"=>"13811111111","licence"=>"360219900312002412"));
	function searchDB($dbname,$tablename,$arr){
		$con = mysqli_connect("localhost","root","123456");//链接
		mysqli_select_db($con,$dbname);//进入数据库
		foreach($arr as $key=>$val){
			$arrStr = $arrStr.$key." = '".$val."' AND ";
		}
		$arrStr = substr($arrStr,0,-4);
//		echo "arrStr:".$arrStr;
		$selectSql = "SELECT * From ".$tablename." WHERE ".$arrStr;//php字符串拼接出查询sql语句
		$result = mysqli_query($con,$selectSql);//执行查询语句
		$res = json_encode(mysqli_fetch_array($result,MYSQLI_ASSOC));//json_encode函数 是php内置的函数 作用是将获取的数组转换为json数据
		mysqli_close($con);//断开数据库
		return $res;//输出查到的数据
	}
//	echo searchDB("Persons","FirstName","rl");

	function delDB($tablename,$key,$val){
//		DELETE FROM Persons WHERE LastName='Griffin'
		$con = mysqli_connect("localhost","root","123456");//链接
		mysqli_select_db("zouxiu", $con);//进入数据库
		$delSql = "DELETE FROM ".$tablename." WHERE ".$key."='".$val."'";
		mysqli_query($con,$delSql);
		mysqli_close($con);//断开数据库
	}
//	delDB("Persons","FirstName","");

	function editDB($tablename,$updatedata,$select){
//		"UPDATE Persons SET Age = '36' WHERE FirstName = 'Peter' AND LastName = 'Griffin'"
		$con = mysqli_connect("localhost","root","123456");//链接
		mysqli_select_db($con,"zouxiu");//进入数据库
		$selectStr = "";
		$updateStr = "";
		foreach($select as $key=>$val){
			$selectStr = $selectStr.$key." = '".$val."' AND ";
		}
		foreach($updatedata as $key=>$val){
//			$updateStr = $key." = '".$val."' ";
			$updateStr = $updateStr.$key." = '".$val."',";
		}
		$updateStr = substr($updateStr,0,-1);
		$editSql = "UPDATE ".$tablename." SET ".$updateStr."WHERE ".$selectStr;
		$editSql = substr($editSql,0,-4);
		mysqli_query($con,$editSql);
		mysqli_close($con);//断开数据库
	}
//	editDB("Persons",array("Age"=>"50","LastName"=>"ergou"),array("FirstName"=>"asd"));
	function order($tablename,$orderRule,$type){
//		SELECT * FROM Persons ORDER BY age
		$con = mysqli_connect("localhost","root","123456");//链接
		mysqli_select_db("zouxiu", $con);//进入数据库
		if($type=="DESC"){
			$sql = "SELECT * FROM ".$tablename." ORDER BY ".$orderRule." DESC";
		}else{
			$sql = "SELECT * FROM ".$tablename." ORDER BY ".$orderRule;
		}
		$res = mysqli_query($con,$sql);
		return $res;
		mysqli_close($con);//断开数据库
	}
//	$result = order("Persons","Age");
//	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
//		var_dump($row);
//	}
?>