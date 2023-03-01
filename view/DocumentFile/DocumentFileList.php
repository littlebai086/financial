<?php
session_start();
header("Cache-Control:private");
require_once("../../model/CommonSql.php");
require_once("../../model/DocumentFile.php");
require_once("../../model/QACDocumentFile.php");
require_once("../../model/DocumentTypeDocumentState.php");
require_once("../../model/StaffDocumentTypeDocumentState.php");
require_once("../../controllers/CommonController.php");
require_once("../../controllers/CommonHtmlController.php");
require_once("../../controllers/CommonSqlController.php");
require_once("../../controllers/DocumentFileController.php");
list($result,$message)=getStaffStatePriorityReturn(false,3,false,true);
if(!$result){
  echo TESTransportStaffPageHeadDecideErrorImportHtml("測試財務部作業系統",true);
  echo PopupStaticWidowHref("測試財務部作業系統",$message,"../StaffIndex.php",true,"StaffPriorityMessage");
  exit;
}
$title="測試財務部作業系統";
$search_fields=array();
$fields=array("document","document_type_id","bank_trade_id","date");
$staff_array=getStaffListStaffId($_SESSION['staff_id']);
foreach ($fields as $field){
  if (isset($_POST[$field])){
    $search_fields[$field]=$_POST[$field];
  }elseif(isset($_GET[$field])){
    $search_fields[$field]=$_GET[$field];
  }else{
    if($field=="document_type_id"){
      $search_fields["document_type_id"]=getDocumentTypeDepartmentDefaultFirst($_SESSION['staff_id']);
    }elseif($field=="date"){
      $search_fields["date"]=date("Y")."-".date("m");
    }else{
      $search_fields[$field]="";
    }
  }
}
if(!getDocumentTypeDepartmentPriority($search_fields["document_type_id"],$_SESSION['staff_id'])){
  echo TESTransportStaffPageHeadDecideErrorImportHtml("測試財務部作業系統",true);
  echo PopupStaticWidowHref("測試財務部作業系統","無此權限查看上傳檔案類別","../StaffIndex.php",true,"StaffPriorityMessage");
  exit;
}
$document_type_array=getDocumentTypeId($search_fields["document_type_id"]);
?>
<!doctype html>
<html lang="en">
  <head>
<?php 
  echo TESTransportStaffCommonHtmlHead("測試財務部作業系統",true);
?>
   </head>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
  $('#selectBankTradeId').change(function(){
    $( "#form" ).submit();
  })
  $('#selectDocumentTypeId').change(function(){
    $( "#form" ).submit();
  })
  $('#DateMonthStartDate').blur(function(){
    $( "#form" ).submit();
  })
});
</script>
  <body class="text-center">
<?php
  list($result,$html)=TESTransportStaffHeader(true);
  echo $html;
  if(!$result){exit;}
  echo PopupWidowScriptHiddenButton(false,false,"DocumentDel");
  echo PopupWidowScriptHiddenButton(false,false,"OpenCase");
  echo PopupWidowScriptHiddenButton(false,false,"CloseCase");
  echo PopupWidowScriptHiddenButton(false,false,"TankCheck");
  echo PopupCloseWidowHref("測試財務部作業系統","確認是否將文件名稱:<span id='PopupCloseShowTextOpenCase'></span>開檔?","確認","取消","",false,"OpenCase");
  echo PopupCloseWidowHref("測試財務部作業系統","確認是否將文件名稱:<span id='PopupCloseShowTextCloseCase'></span>關檔?","確認","取消","",false,"CloseCase");
  echo PopupCloseWidowHref("測試財務部作業系統","確認是否將文件名稱:<span id='PopupCloseShowTextDocumentDel'></span>刪除?","確認","取消","",false,"DocumentDel");
  echo PopupCloseWidowHref("測試財務部作業系統","確認是否將文件名稱:<span id='PopupCloseShowTextTankCheck'></span>審核通過?","通過","不通過","",false,"TankCheck");
  
  $table=getDocumentFileSearchTable($search_fields);
?>
<form action="" method="post" id="form">
  <div class="container-fluid">
    <div class="row">
      <div class="col col-auto d-flex align-items-center">
        <label for="selectDocumentTypeId" class="control-label">上傳檔案類別</label>
      </div>
      <div class="col col-lg-2 d-flex align-items-center">
        <select class="form-select" id="selectDocumentTypeId" name="document_type_id">
           <?php
              echo getDocumentTypeOptionDocumentTypeIdValueDocumentType($_SESSION['staff_id'],$search_fields['document_type_id']);
           ?>
          </select>
      </div>
      <?php
        if($search_fields['document_type_id']==4){
          echo '
      <div class="col col-lg-2 d-flex align-items-center">
        <select class="form-select" id="selectBankTradeId" name="bank_trade_id">
          <option value="ALL">ALL</option>
          '.getBankTradeOptionBankTradeValueBankTradeId($search_fields['bank_trade_id']).'
        </select>
      </div>';
        }
      ?>
      <div class="col col-auto d-flex align-items-center">
        歸檔日期
      </div>
      <div class="col col-auto d-flex align-items-center">
        <input type="month" class="form-control" id="DateMonthStartDate" min='2022-11' max="<?php echo date("Y")."-".date("m");?>" value="<?php echo $search_fields['date'];?>" name="date" >
      </div>
      <div class="col col-auto d-flex align-items-center">
        <label for="inputDocument" class="control-label">
          <?php echo $document_type_array["document_type"];?>
        </label>
      </div>
      <div class="col col-lg-2 d-flex align-items-center">
        <input type="text" name="document" id="inputDocument" value="<?php echo $search_fields["document"];?>" class="form-control">
      </div>
      <div class="col col-auto d-flex align-items-center">
        <input type='submit'  class="btn btn-success"value="查詢">
      </div>
      <div class="col col-auto d-flex align-items-center">
        <input type='button' value="清除查詢" onclick="location.href='./DocumentFileList.php'" class="btn btn-secondary">
      </div>
    </div>
  </div>
</form>
<table class="table table-success table-striped table-hover caption-top text-start">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><?php echo $document_type_array["document_type"];?></th>
      <th scope="col">檔案名稱</th>
      <?php
        if($search_fields['document_type_id']==4){
          echo '<th scope="col">支付金額</th>';
        }elseif($search_fields['document_type_id']==1){
          echo '<th scope="col">DP審核</th>';
        }
      ?>
      <th scope="col">建檔人員</th>
      <th scope="col">狀態</th>
      <th scope="col">編輯</th>
    </tr>
  </thead>
  <?php 
  echo $table;
  ?>
</table>
  <?php echo TESTransportStaffFooter();?>
</body>
</html>