<?php
require_once("../../model/CommonSql.php");
require_once("../../model/BookingOrder.php");
require_once("../../controllers/CommonController.php");
require_once("../../controllers/CommonHtmlController.php");
require_once("../../controllers/CommonSqlController.php");
require_once("../../controllers/BookingController.php");
if (isset($_GET['id'])){$id=$_GET['id'];}
$data_array=getBookingOrderId($id);
echo getSendMailOrderStatusMsg($data_array);
?>