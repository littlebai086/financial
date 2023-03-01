<?php
session_start();
require_once("../../model/CommonSql.php");
require_once("../../model/Staff.php");
require_once("../../controllers/CommonController.php");
require_once("../../controllers/CommonHtmlController.php");
require_once("../../controllers/CommonSqlController.php");
$title="測試財務系統";
$staff_array=getStaffListStaffId($_SESSION['staff_id']);
if(!isset($_SESSION['staff_id'])){
  echo TESTransportStaffPageHeadDecideErrorImportHtml("測試財務系統",true);
  echo PopupStaticWidowHref("測試財務系統","尚未登入","../StaffIndex.php",true,"StaffPriorityMessage");
  exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
  <?php 
  echo TESTransportStaffCommonHtmlHead("測試財務部作業系統",true,false);
  ?>
  <link href="../../css/signin.css" rel="stylesheet">
  </head>
  <style>
    #intro {
      background-image: url(../../images/b6.jpg);
      background-size: cover;
      height: 100vh;
    }
  </style>
  <body class="text-center">
<?php
echo PopupWidowScriptHiddenButton("StaffNotLoginMessage","StaffLoginMessage");
?> 
    <div id="intro" class="bg-image shadow-2-strong">
      <div class="mask d-flex align-items-center h-100"style="background-color: rgba(0, 0, 0, 0.4);">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-md-8">
              <form method="post" action=""class="bg-white  rounded-5 shadow-5-strong p-5">
                <!-- Email input -->
                <div class="mb-4">
                  <img class="mb-4" src="../../assets/brand/TEST_log.png" alt="" width="200" height="100">
                  <h1 class="h3 mb-3 fw-normal">測試財務部作業系統選擇</h1>
                </div>
                <?php
                  echo getOwnerCompanyRadio();
                ?>
                <input type="submit" name="emp_login" class="btn btn-success" value="登入">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php 
  echo getBoostrapBlundleJsImportEnd();
?>
</body>

</html>

<?php
if(isset($_POST['emp_login'])){
  $_SESSION['owner_company_id']=$_POST['owner_company_id'];
  $row=getOwnerCompanyStaffId($_SESSION['owner_company_id']);
  echo PopupStaticWidowHref($title,"您選擇的是".$row["company_chinese"],"../StaffIndex.php",true,"StaffLoginMessage");
}else{
  $buf = sqlSelectStaffOwnerCompanyStaffId($_SESSION['staff_id']);
  if(count($buf)==1){
    foreach($buf as $row){
      $_SESSION['owner_company_id']=$row['owner_company_id'];
      $row=getOwnerCompanyStaffId($_SESSION['owner_company_id']);
      echo PopupStaticWidowHref($title,"您選擇的是".$row["company_chinese"],"../StaffIndex.php",true,"StaffLoginMessage");
      exit;
    }
  }
}
?>