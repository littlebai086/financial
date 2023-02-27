<?php
date_default_timezone_set('Asia/Taipei');//調整時區
require_once("../PHPMailer/class.phpmailer.php");
require_once("../model/CommonSql.php");
require_once("../model/Staff.php");
require_once("../model/DocumentFile.php");
require_once("../controllers/CommonSqlController.php");
require_once("../controllers/CommonController.php");
require_once("../controllers/CommonHtmlController.php");
require_once("../controllers/StaffController.php");
require_once("../controllers/DocumentFileController.php");
ini_set("memory_limit", -1);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<?php
$year=date('Y');
$month=date('m');
$day=date('d');
$body="<span style='font-family:Microsoft JhengHei;'>今日交易銀行<br>";
$array=array();
$attach_array=array();
$document_type_array=getDocumentTypeId(4);
$path=getDocumentTypeFilePath($document_type_array,true);
$bank_trade_buf = sqlSelectBankTrade();
$buf = sqlSelectDocumentFileDailyCostYearMonthDay($year,$month,$day);
foreach($buf as $key=>$row){
    if($key==0){
        $body.="<font color='green'>已上傳為".count($buf)."筆<br>";
    }
    $body.=($key+1).".".$row["bank_trade"]."<br>";
    array_push($attach_array,$path.$row["file"]);
    foreach($bank_trade_buf as $key2=>$bank_trade_row){
        if($bank_trade_row["bank_trade_id"]==$row["bank_trade_id"]){
            array_push($array,$key2);
            continue;
        }
    }
}
if(count($buf)>0){
    $body.="</font>";
}
$buf = getArrayKeyDeleteKeyIndex($bank_trade_buf,$array);
foreach($buf as $key=>$row){
    if($key==0){
        $body.="<font color='red'>未上傳為".count($buf)."筆<br>";
    }
    $body.=($key+1).".".$row["bank_trade"]."<br>";
    
}
if(count($buf)>0){
    $body.="</font>";
}
echo $body.="</span>";
list($account,$auth)=getAccountAuth();
$buf=sqlSelectStaffListDepartmentPositionId("財務部","主管");
//$buf=sqlSelectStaffListDepartmentPositionId("資訊部","主管");
$recipients=getStaffLIstTransferSendMailRecipients($buf);
if(sendMailLetter($account,$auth,$account,"[系統自動寄送]洋宏財務作業系統","【QAT洋宏財務作業系統】每日銀行交易通知",$body,false,$attach_array,$recipients,false)){
    echo "寄件成功";
}else{
    echo "寄件失敗";
}
?>
</body>
</html>