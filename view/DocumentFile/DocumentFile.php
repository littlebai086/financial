<?php
require_once("../../PHPMailer/class.phpmailer.php");
require_once("../../model/CommonSql.php");
require_once("../../model/Staff.php");
require_once("../../model/DocumentFile.php");
require_once("../../model/QACDocumentFile.php");
require_once("../../model/DocumentTypeDocumentState.php");
require_once("../../model/StaffDocumentTypeDocumentState.php");
require_once("../../controllers/CommonSqlController.php");
require_once("../../controllers/CommonController.php");
require_once("../../controllers/CommonHtmlController.php");
require_once("../../controllers/StaffController.php");
require_once("../../controllers/DocumentFileController.php");
session_start();
ini_set("memory_limit", -1);

if(isset($_GET['id'])){$id=$_GET['id'];}else{$id=false;}
if(isset($_GET['pass'])){$pass=$_GET['pass'];}else{$pass=false;}
if(isset($_GET['state'])){$state=$_GET['state'];}else{$state=false;}
if(isset($_GET['document_type_id'])){$document_type_id=$_GET['document_type_id'];}else{$document_type_id=false;}
list($result,$message)=getStaffStatePriorityReturn($state,2,$id,false);
if(!$result){
  echo QATransportStaffPageHeadDecideErrorImportHtml("測試財務部作業系統",true);
  echo PopupStaticWidowHref("測試財務部作業系統",$message,"../StaffIndex.php",true,"StaffPriorityMessage");
  exit;
}
$title="檔案上傳";
$submit="";
if($state!==false){

  if($state=="update"){
    $data_array=getDocumentFileSqlJudgeState($id,"document_file_id",false);
    $staff_array=getStaffListStaffId($data_array["staff_id"]);
    $data_array["document"]=str_replace($data_array["bank_trade"],"",$data_array["document"]);
    $submit="修改";
  }elseif($state=="upload"){
    $document_type_array=getDocumentTypeId($document_type_id);
    $data_array=$document_type_array;
    $data_array["document_file_id"]=false;
    $array=explode("_",$state);
    $state=$array[0];
  }else{
    $data_array=getDocumentFileSqlJudgeState($id,"document_file_id",false);
  }
  
}
$items=array("staff_id","year","month","bank_trade_id","currency_id","pay_money","dp_check","document");

if(isset($_POST['emp_edit_send'])){
  foreach ($items as $item){
    if(isset($_POST[$item])){
      $data_array[$item]=trim($_POST[$item]);
    }else{
      $data_array[$item]=NULL;
    }
  }
  $staff_array=getStaffListStaffId($data_array["staff_id"]);
  $submit="上傳";
}elseif($state=="upload"){
  foreach ($items as $item){
    $data_array[$item]="";
  }
  $data_array["year"]=date("Y");
  $data_array["month"]=date("m");
  $data_array["staff_id"]=$_SESSION["staff_id"];
  $staff_array=getStaffListStaffId($data_array["staff_id"]);
  $submit="上傳";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php 
  echo QATransportStaffCommonHtmlHead("測試財務部作業系統",true);
?>
</head>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
  $( "#selectBankTradeId" ).change(function(){
    $.ajax({
    type: 'GET',
    url: '../../Action/CommonAction.php',
    data: {
      action: 'default_currency',
      val: $("#selectBankTradeId").val(),
      dataType: "json" 
    },
    success:function(item){
      item=JSON.parse(item);
      $("#selectCurrencyId").val(item);
    },
    cache:false,
    ifModified :true,
    async:false,
    error:function(item){
      result=false;
    }
    })
  })
  $( "#inputPayMoney" ).keyup(function(){
     // 清除"數字"和"."以外的字符
     $('#inputPayMoney').val($('#inputPayMoney').val().replace(/[^\d\.]/g, ""));
    // 驗證第一個字符是數字
    $('#inputPayMoney').val($('#inputPayMoney').val().replace(/^\./g,""));
    // 只保留第一個, 清除多餘的
    $('#inputPayMoney').val($('#inputPayMoney').val().replace(/\.{2,}/g,"."));
    $('#inputPayMoney').val($('#inputPayMoney').val().replace(".","$#$").replace(/\./g,"").replace("$#$","."));
    // 只能輸入兩個小數
    $('#inputPayMoney').val($('#inputPayMoney').val().replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3'));
  })
  $( "form" ).submit(function(){
    $("#Year").removeAttr("disabled");
    $("#Month").removeAttr("disabled");
    $("#selectDPCheck").removeAttr("disabled");
    $("#selectBankTradeId").removeAttr("disabled");
    $("#selectCurrencyId").removeAttr("disabled");
    $("#inputPayMoney").removeAttr("disabled");
    $("#inputDocument").removeAttr("disabled");
  })
});
</script>
<body>
<?php 
  list($result,$html)=QATransportStaffHeader(true);
  echo $html;
  if(!$result){exit;}

	echo PopupWidowScriptHiddenButton(1);
?>
<main class="container-fluid">
  <?php 
  if($state=="upload"){
    $user="上傳人員";
    $disabled='';
    require_once("./DocumentFileForm.php");
  }elseif($state=="update"){
    $disabled='disabled="disabled"';
    $user="前次上傳人員";
    $now_user="此次上傳人員";
    $now_staff_array=getStaffListStaffId($_SESSION["staff_id"]);
    $now_staff_array['ename']=ucfirst(strtolower($now_staff_array['ename']));
    $now_staff_array['elastname']=ucfirst(strtolower($now_staff_array['elastname']));
    require_once("./DocumentFileForm.php");
  }
  ?>
</main>
  <?php echo QATransportStaffFooter();?>
</body>
</html>
<?php
list($account,$auth)=getAccountAuth();

if($state!="upload"){
  $document_file_records=getDocumentFileSqlJudgeState($data_array["document_file_id"],"document_file_record_id_desc",$data_array);
  $states=getDocumentFileStaffPriorityReturn($data_array,$document_file_records);
  if(!in_array($state,$states)){
    echo PopupStaticWidowHref($title,"並不符合此權限或者步驟跳過","back",true,"Message");
    exit;
  }
}
if(isset($_POST['emp_edit_send'])){
  $path=getDocumentTypeFilePath($data_array);
  $document_strlen=mb_strlen($data_array["document"]);
  list($result,$message)=getDocumentFileTextFormatReturn($id,$state,$data_array);
  if($data_array["permission"]=="jobno"){
    $data_array["tank_check"]=0;
  }elseif($data_array["permission"]=="daily_cost"){
    $bank_trade_array=getBankTradeId($data_array["bank_trade_id"]);
    $data_array["document"].=$bank_trade_array["bank_trade"];
  }
  if(!$result){
    echo PopupStaticWidowHref($title,$message,false,true,"Message");
    exit;
  }
  list($result,$data_array["file"])=getUploadFile($path,"file",$data_array["document"]);
  if(!$result){
    echo PopupStaticWidowHref($title,"上傳出現錯誤","back",true,"Message");
    exit;
  }

  if ($state=="upload"){
    if($data_array["permission"]=="jobno"){
      $body="<span style='font-family:Microsoft JhengHei;'>
      Job No : ".$data_array["document"]."上傳成功<br>
      建檔人員 : ".getQATShowName($staff_array)."</span>";
      if($data_array["dp_check"]==1){
        // $buf = sqlSelectStaffListTankDepartmentCheck();
      }else{
        // $buf = sqlSelectStaffListFinancialDepartmentStaffId();
        // $buf=sqlSelectStaffListDepartmentPositionId("資訊部","主管");
      }
      // $recipients=getStaffLIstTransferSendMailRecipients($buf);
      $attach_array=array($path.$data_array["file"]);
    }
    
    $id=getDocumentFileSqlJudgeState(false,"insert",$data_array);
    if ($id){
      if(getDocumentFileSqlJudgeState($id,"record",$data_array,false,"upload")){
        if(isset($recipients)){
          if(sendMailLetter($account,$auth,$account,"[系統自動寄送]測試財務作業系統","【QAT測試財務作業系統】Job No 上傳通知",$body,false,$attach_array,$recipients,false)){
            echo "寄件成功";
          }else{
            echo "寄件失敗";
          }
        }
        echo PopupWidowHref($title,"文件新增資料庫完成","./DocumentFileList.php?document_type_id=".$data_array["document_type_id"]."&year=".$data_array["year"]."&month=".$data_array["month"],true,false);
        exit;
      }
    }
    echo PopupWidowHref($title,"文件新增資料庫失敗",false,true,false);
    exit;
  }elseif($state=="update"){
    if(getDocumentFileSqlJudgeState($id,"update",$data_array)){
      if(getDocumentFileSqlJudgeState($id,"record",$data_array,false,"update")){
        echo PopupWidowHref($title,"修改基本資料完成","./DocumentFileList.php?document_type_id=".$data_array["document_type_id"]."&year=".$data_array["year"]."&month=".$data_array["month"],true,false);
        exit;
      }
    }
    echo PopupWidowHref($title,"修改基本資料失敗，請聯絡公司相關IT人員",false,true,false);
    exit;
  }
}elseif($state=="dp_check"){
  $row=getDocumentStateEnglish($state);
  if(getDocumentFileSqlJudgeState($id,"record",$data_array,$pass,$state,$row["document_type_document_state_id"])){
    $body="<span style='font-family:Microsoft JhengHei;'>
        Job No : ".$data_array["document"]."<br>
        建檔人員 : ".getQATShowName(getStaffListStaffId($data_array["staff_id"]))."<br>";
    if($pass==2){
      $body.="<font color='red'>此筆Jon No 審核不通過</font></span>";
      $buf = sqlSelectStaffListStaffId($data_array["staff_id"]);
      $buf=sqlSelectStaffListDepartmentPositionId("資訊部","主管");
    }elseif($pass==1){
      $body.="<font color='green'>此筆Jon No 審核通過</font></span>";
      $buf = sqlSelectStaffListFinancialDepartmentStaffId();
      $buf=sqlSelectStaffListDepartmentPositionId("資訊部","主管");
    }
    $recipients=getStaffLIstTransferSendMailRecipients($buf);
    $cc = getStaffLIstTransferSendMailRecipients(sqlSelectStaffListStaffId($_SESSION["staff_id"]));
    $path=getDocumentTypeFilePath($data_array);
    $attach_array=array($path.$data_array["file"]);
    if(sendMailLetter($account,$auth,$account,"[系統自動寄送]測試財務作業系統","【QAT測試財務作業系統】Job No 審核通知",$body,false,$attach_array,$recipients,false)){
      echo PopupWidowHref($title,"DP已審核完成","./DocumentFileList.php?document_type_id=".$data_array["document_type_id"]."&year=".$data_array["year"]."&month=".$data_array["month"],true,false);
      exit;
    }else{
      echo PopupWidowHref($title,"寄信失敗",false,true,false);
      exit;
    }
  }
  echo PopupWidowHref($title,"修改資料失敗，請聯絡公司相關IT人員",false,true,false);
  exit;
}elseif($state=="open_case" || $state=="close_case"){
  $row=getDocumentStateEnglish($state);
  $text=$row["document_state_chinese"];
  if(getDocumentFileSqlJudgeState($id,"record",$data_array,false,$state,$row["document_type_document_state_id"])){
    if($state=="open_case"){
      if(!getDocumentFileSqlJudgeState($id,"record",$data_array,false,"reset_open_update")){
        echo PopupWidowHref($title,"開檔失敗，請聯絡公司相關IT人員",false,true,false);
        exit;
      }
    }
    $body="<span style='font-family:Microsoft JhengHei;'>
        ".$data_array["document_type"]." : ".$data_array["document"]."<br>
        建檔人員 : ".getQATShowName(getStaffListStaffId($data_array["staff_id"]))."<br>
        <font color='red'>此筆".$data_array["document_type"]." : ".$data_array["document"]." 已".$text."</font></span>";
    $recipients=getStaffLIstTransferSendMailRecipients(sqlSelectStaffListStaffId($data_array["staff_id"]));
    $cc = getStaffLIstTransferSendMailRecipients(sqlSelectStaffListStaffId($_SESSION["staff_id"]));
    $path=getDocumentTypeFilePath($data_array);
    $attach_array=array($path.$data_array["file"]);
    if(sendMailLetter($account,$auth,$account,"[系統自動寄送]測試財務作業系統","【QAT測試財務作業系統】".$data_array["document_type"].$text."通知",$body,false,$attach_array,$recipients,$cc)){
      echo PopupWidowHref($title,$text."完成","./DocumentFileList.php?document_type_id=".$data_array["document_type_id"]."&year=".$data_array["year"]."&month=".$data_array["month"],true,false);
      exit;
    }else{
      echo PopupWidowHref($title,"寄信失敗",false,true,false);
      exit;
    }
  }
  echo PopupWidowHref($title,"修改資料失敗，請聯絡公司相關IT人員",false,true,false);
  exit;
}elseif($state=="del"){
  $old_path=getDocumentTypeFilePath($data_array);
  $path="../../upload/DeleteDocumentFileRecord/";
  //$file=$data_array["file"];
  $file=mb_convert_encoding($data_array["file"],"BIG-5",'UTF-8');
  if(getDepartmentLeaderPermissionsReturn($data_array["staff_id"],$_SESSION['staff_id'])){
    if(getDocumentFileSqlJudgeState($id,"delete",$data_array)){
      if(copy($old_path.$file,$path.$file)){
      //if(copy($old_path.$data_array["file"],$path.$data_array["file"])){
        if(unlink($old_path.$file)){
          echo PopupWidowHref($title,"刪除歸檔檔案成功","./DocumentFileList.php",true,false);
          exit;
        }
      }
    }
    echo PopupWidowHref($title,"刪除歸檔檔案失敗，請聯絡公司相關IT人員",false,true,false);
    exit;
  }
  echo PopupWidowHref($title,"無此刪除權限，請聯絡公司相關IT人員",false,true,false);
  exit;
}
?>
