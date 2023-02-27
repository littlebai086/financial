<?php
require_once("../model/CommonSql.php");
require_once("../controllers/CommonSqlController.php");
require_once("../controllers/CommonController.php");
require_once("../controllers/CommonHtmlController.php");
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php 
	echo QATransportStaffCommonHtmlHead("測試財務系統",false);
?>
</head>
<body>
<?php 
	echo PopupWidowScriptHiddenButton(1);
	list($result,$html)=QATransportStaffHeader(false);
  	echo $html;
  	if(!$result){exit;}
?>

<?php echo QATransportStaffFooter();?>

</body>
</html>