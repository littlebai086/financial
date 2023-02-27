<?php
session_start();
header("Cache-Control:private");
require_once("../../model/CommonSql.php");
require_once("../../model/Staff.php");
require_once("../../controllers/CommonController.php");
require_once("../../controllers/CommonHtmlController.php");
require_once("../../controllers/CommonSqlController.php");
require_once("../../controllers/StaffController.php");
list($result,$message)=getStaffStatePriorityReturn(false,1,false,true);
if(!$result){
  echo QATransportStaffPageHeadDecideErrorImportHtml("測試財務系統",true);
  echo PopupStaticWidowHref("測試財務系統",$message,"../StaffIndex.php",true,"StaffPriorityMessage");
  exit;
}
$search_fields=array();
$fields=array("ename","elastname","cname","email","extension","position_id","department_id","staff_state_id");
foreach ($fields as $field){
  if (isset($_POST[$field])){
    $search_fields[$field]=trim($_POST[$field]);
  }else{
    if($field=="staff_state_id"){
      $search_fields[$field]=1;
    }else{
      $search_fields[$field]="";
    }
  }
}

$page_total=mysqli_num_rows(sqlSelectStaffList($search_fields,false,false));
if (isset($_POST['page'])){$page= intval(trim($_POST['page']));}else{$page=1;}
if ($page==0){$page=1;}
$per=getAllPageNumPer();
$pages = ceil($page_total/$per);
if($page>$pages && $pages!=0){$page=$pages;}
$start = ($page-1)*$per;
$page_text=getAllPageNum($page,$pages);
$table=getStaffListSearchTable($search_fields,$start,$per);

?>
<!doctype html>
<html lang="en">
  <head>
<?php 
  echo QATransportStaffCommonHtmlHead("測試海運網後台",true);
?>
   </head>
  <body>
<?php
  list($result,$html)=QATransportStaffHeader(true);
  echo $html;
  if(!$result){exit;}
  echo PopupWidowScriptHiddenButton(false);
?>
<form action="" method="post">
  <input type="text" id="page" name="page" value="<?php echo $page;?>" hidden>
  <div class="container-fluid">
    <div class="row">
      <div class="col col-lg-1 d-flex align-items-center" >
        <label for="inputChineseName" class="control-label">中文名稱</label>
      </div>
      <div class="col col-lg-2 d-flex align-items-center">
        <input type="text" class="form-control" id="inputChineseName" name="cname" value="<?php echo $search_fields['cname'];?>">
      </div>
      <div class="col col-lg-1 d-flex align-items-center">
        <label for="inputEnglishName" class="control-label">英文名稱</label>
      </div>
      <div class="col col-lg-2 d-flex align-items-center" >
        <input type="text" class="form-control" id="inputEnglishName" name="ename" value="<?php echo $search_fields['ename'];?>">
      </div>
      <div class="col col-lg-1 d-flex align-items-center">
        <label for="inputEmail" class="control-label">E-MAIL</label>
      </div>
      <div class="col col-lg-2 d-flex align-items-center">
        <input type="text" class="form-control" id="inputEmail" name="email" value="<?php echo $search_fields['email'];?>">
      </div>
      <div class="col col-lg-1 d-flex align-items-center">
        <label for="inputExtension" class="control-label">分機</label>
      </div>
      <div class="col col-lg-2 d-flex align-items-center">
        <input type="text" class="form-control" id="inputExtension" name="extension" value="<?php echo $search_fields['extension'];?>">
      </div>
    </div>
    <div class="row">
      <div class="col col-lg-1 d-flex align-items-center">
       <label for="selectDepartmentId" class="control-label">部門</label>
      </div>
      <div class="col col-lg-2 d-flex align-items-center">
        <select class="form-select" id="selectDepartmentId" name="department_id" aria-label="Default select example" required="required">
          <option value="all">ALL</option>
           <?php
             echo getDepartmentOptionDepartmentValueId($search_fields['department_id']);
           ?>
         </select>
      </div>
      <div class="col col-lg-1 d-flex align-items-center">
        <label for="selectPositionId" class="control-label">職位</label>
      </div>
      <div class="col col-lg-2 d-flex align-items-center">
        <select class="form-select" id="selectPositionId" name="position_id" aria-label="Default select example" required="required">
          <option value="all">ALL</option>
           <?php
             echo getPositionOptionPositionValueId($search_fields['position_id']);
           ?>
         </select>
        </div>
      <div class="col col-lg-1 d-flex align-items-center">
        <label for="selectPositionId" class="control-label">員工為</label>
      </div>
      <div class="col col-lg-2 d-flex align-items-center">
          <select name="staff_state_id" class="form-select">
            <option value="all">ALL</option>
            <?php 
            echo getStaffStateOptionStateValueId($search_fields['staff_state_id']);
            ?>
          </select>
        </div>
    </div>
    <div class="row">
      <div class="col col-lg-1 d-flex align-items-center" >
        <input type="submit" value="查詢" class="btn btn-success">
      </div>
      <div class="col col-lg-1 d-flex align-items-center" >
        <input type="button" value="清除查詢" onclick="location.href='./StaffList.php'" class="btn btn-secondary">
      </div>
      <div class="col">
      </div>
    </div>
  </div>
</form>
<table class="table table-success table-striped table-hover caption-top">
   <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">中文名稱</th>
      <th scope="col">英文名稱</th>
      <th scope="col">E-MAIL</th>
      <th scope="col">分機</th>
      <th scope="col">部門</th>
      <th scope="col">職位</th>
      <th scope="col">編輯</th>
    </tr>
  </thead>
  <?php

  echo $table;
  ?>
</table>
<?php 
  echo $page_text;
?>
<?php echo QATransportStaffFooter();?>
</body>
</html>