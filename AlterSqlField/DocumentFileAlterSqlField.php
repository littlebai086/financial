<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
require_once('../model/CommonSql.php');
$sql="ALTER TABLE `document_file` ADD COLUMN `dp_check` INT(11) NULL AFTER `container_type`";
sendSQL($sql);
$sql="ALTER TABLE `qac_document_file` ADD COLUMN `dp_check` INT(11) NULL AFTER `container_type`";
sendSQL($sql);

$sql="UPDATE `document_file` SET `dp_check` = 1 WHERE `container_type` LIKE 'tank'";
$buf=sendSQL($sql);
$sql="UPDATE `document_file` SET `dp_check` = 2 WHERE `container_type` LIKE 'Dry'";
$buf=sendSQL($sql);
$sql="ALTER TABLE `document_file` DROP `container_type`";
sendSQL($sql);
$sql="ALTER TABLE `qac_document_file` DROP `container_type`";
sendSQL($sql);
?>
</html>