<?php
require("../model/CommonSql.php");
require("../controllers/CommonController.php");
require("../controllers/CommonSqlController.php");
function sqlInsertCity($city_chinese){
	$sql="INSERT INTO `city`(`country_id`,`city_chinese`)VALUES(1,'".$city_chinese."')";
	return sendSQL($sql);
}
function sqlInsertArea($city_id,$area){
	$sql="INSERT INTO `area`(`city_id`,`area_chinese`)VALUES(".$city_id.",'".$area."')";
	return sendSQL($sql);
}
function sqlSelectCityCityChinese($city){
	$sql="SELECT * FROM `city` WHERE `city_chinese` LIKE '".$city."'";
	return sendSQL($sql);
}
function sqlSelectAreaAreaChinese($area){
	$sql="SELECT * FROM `area` WHERE `area_chinese` LIKE '".$area."'";
	return sendSQL($sql);
}
function getCityCityChinese($city){
	$buf=sqlSelectCityCityChinese($city);
	foreach ($buf as $row){
		return $row;
	}
}
function getAreaAreaChinese($area){
	$buf=sqlSelectAreaAreaChinese($area);
	foreach ($buf as $row){
		return $row;
	}
}
$excel_arrays=getExcelToDataArray("./鄉鎮市區.xlsx",$worksheetpage=0,false);

$city_array=array();
foreach ($excel_arrays as $excel_array){
	array_push($city_array,$excel_array[0]);
}
$city_array=array_unique($city_array);
foreach ($city_array as $city){
	$city=trim($city);
	if(!getCityCityChinese($city)){
		if(!sqlInsertCity($city)){
			echo $city."新增失敗<br>";
		}
	}else{
			echo $city."已有資料<br>";
	}

}

foreach($excel_arrays as $excel_array){
	$city=trim($excel_array[0]);
	$area=trim($excel_array[1]);
	$city_array=getCityCityChinese($city);
	if($city_array){
		if(!getAreaAreaChinese($area)){
			if(!sqlInsertArea($city_array['id'],$area)){
				echo $area."新增失敗<br>";
			}
		}else{
			echo $area."已有資料<br>";
		}
	}else{
		echo $city."無此城市ID<br>";
	}
}
echo "新增成功";
?>
