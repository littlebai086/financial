<?php
session_start();
require_once("../../model/CommonSql.php");
require_once("../../model/DocumentFile.php");
require_once("../../model/QACDocumentFile.php");
require_once("../../controllers/CommonController.php");
require_once("../../controllers/CommonHtmlController.php");
require_once("../../controllers/CommonSqlController.php");
require_once("../../controllers/DocumentFileController.php");
$title="測試財務部作業系統";
if(isset($_GET['id'])){$id=$_GET['id'];}else{$id=false;}
$data_array=getDocumentFileSqlJudgeState($id,"document_file_id",false);
?>
<!doctype html>
<html lang="en">
  <head>
<?php 
  echo QATransportStaffCommonHtmlHead("測試財務部作業系統",true);
?>
   </head>
  <body class="text-center">
<?php
  list($result,$html)=QATransportStaffHeader(true);
  echo $html;
  if(!$result){exit;}
  $table=getDocumentFileRecordTable($id);
?>
<h3><?php echo $data_array["document_type"]." : ".$data_array['document'];?></h3>
<table class="table table-success table-striped table-hover caption-top text-start">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">人員</th>
      <th scope="col">檔案名稱</th>
      <th scope="col">狀態</th>
      <th scope="col">時間</th>
    </tr>
  </thead>
  <?php 
  echo $table;
  ?>
</table>
  <?php echo QATransportStaffFooter();?>
</body>
</html>