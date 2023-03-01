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
	echo TESTransportStaffCommonHtmlHead("測試財務系統",false);
?>
</head>
<body>
<?php 
	echo PopupWidowScriptHiddenButton(1);
	list($result,$html)=TESTransportStaffHeader(false);
  	echo $html;
  	if(!$result){exit;}
?>

<?php echo TESTransportStaffFooter();?>

</body>
</html>