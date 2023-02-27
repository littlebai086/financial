<?php
require_once("../../model/CommonSql.php");
require_once("../../model/Member.php");
require_once("../../model/BookingOrder.php");
require_once("../../controllers/CommonController.php");
require_once("../../controllers/CommonHtmlController.php");
require_once("../../controllers/CommonSqlController.php");
require_once("../../controllers/BookingController.php");
require_once("../../controllers/MemberController.php");
$sql = "SELECT * FROM `destination_container_depot` ORDER BY `destination_container_depot_id` ASC";
$buf = sendSQL($sql);
foreach($buf as $row){
	// $sql = "INSERT INTO `destination`(`destination_container_depot_id`) VALUES (".$row['destination_container_depot_id'].")";
	// sendSQL($sql);
}
echo "成功";
?>