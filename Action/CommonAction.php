<?php
require_once('../model/CommonSql.php');
require_once('../controllers/CommonSqlController.php');
require_once('../controllers/CommonHtmlController.php');

header('Content-Type:text/html;charset=utf-8');

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
if (isset($_GET['val'])) {
    $id = $_GET['val'];
}

switch ($action) {
    case 'default_currency':
        $row=getBankTradeId($id);
        $content_text=json_encode($row["default_currency_id"]);
        break;
}
echo $content_text;
?>