<?php
require_once("../../model/CommonSql.php");
require_once("../../model/Staff.php");
require_once("../../controllers/CommonSqlController.php");
require_once("../../controllers/CommonController.php");
require_once("../../controllers/CommonHtmlController.php");
session_start();
if(isset($_GET['state'])){$state=$_GET['state'];}else{$state=false;}
if(isset($_GET['id'])){$staff_id=$_GET['id'];}else{$staff_id=false;}
list($result,$message)=getStaffStatePriorityReturn($state,1,$staff_id,false);
if(!$result){
  echo QATransportStaffPageHeadDecideErrorImportHtml("測試海運網後台",true);
  echo PopupStaticWidowHref("測試海運網",$message,"../StaffIndex.php",true,"StaffPriorityMessage");
  exit;
}
$items=array("username");
if(isset($_POST['emp_edit_send'])){
  $error=true;
  foreach ($items as $item){
    $data_array[$item]=trim($_POST[$item]);
  }
}elseif($state=="add"){
  $error=false;
  foreach ($items as $item){
    $data_array[$item]="";
  }
}elseif($state=="update"){
  $error=false;
  $data_array=getStaffAccountListStaffId($staff_id);
}
if($state=="add"){
  $title="新增員工帳戶";
  $submit="新增";
}elseif($state=="update"){
  $title="修改員工帳戶";
  $submit="修改";
}
 $data_array['username']=strtolower($data_array['username']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php 
  echo QATransportStaffCommonHtmlHead("測試海運網後台",true);
?>
</head>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
  $('#inputPassword').keyup(function(){
    return password_format();
  })
  $('#inputConfirmPassword').keyup(function(){
    return password_format();
  })
  $("form").submit(function(e){
    if(password_format() && confirm_password_format()){
      return true;
    }
  return false;
  });
});
</script>
<body>
<?php 
  list($result,$html)=QATransportStaffHeader(true);
  echo $html;
  if(!$result){exit;}
	echo PopupWidowScriptHiddenButton(1);
?>
<main class="container-fluid" >
  <form method="post" action="" id="loginForm">
    <input type="text" id="id"  name="staff_id" value="<?php echo $staff_id;?>" hidden>
    <div class="row">
        <div class="col col-lg-4">
        </div>	
        <div class="col col-lg-1 d-flex align-items-center">
          <label for="inputUsername" class="control-label">帳號</label>
        </div>
        <div class="col col-lg-2 d-flex align-items-center">
   			<input type='text' class='form-control' id='inputUsername' name='username' value="<?php echo $data_array['username'];?>" required="required" readonly="readonly">
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-4">
        </div>  
        <div class="col col-lg-1 d-flex align-items-center">
          <label for="inputPassword" class="control-label">密碼</label>
        </div>
        <div class="col col-lg-3">
          <input type="password"  class="form-control col-xs-12 col-sm-10" id="inputPassword" name="password"  placeholder="請填寫英文及數字至少8碼" required="required">
          <small class="text-muted">
           * 限用英文字母及數字，限長8~16字
          </small>
        </div>
        <div class="col col-lg-2 d-flex align-items-center">
          <span id="password_message">
          </span>  
        </div>
    </div>
      <div class="row">
        <div class="col col-lg-4">
        </div>  
        <div class="col col-lg-1 d-flex align-items-center">
          <label for="inputConfirmPassword" class="control-label">確認密碼</label>
        </div>
        <div class="col col-lg-3">
          <input type="password" class="form-control" id="inputConfirmPassword" name="confirm_password" required="required"  placeholder="請再輸入一次密碼">
        </div>
        <div class="col col-lg-2" style="text-align:left">
          <span id="confirm_password_message">
          </span>  
        </div>
      </div>
    <div class="row">
        <div class="col col-lg-5">
        </div>	
        <div class="col col-1">
          <input type="submit" name="emp_edit_send" class="btn btn-success" value="<?php echo $submit;?>">
         </div>
        <div class="col col-lg-1 d-flex align-items-center">
            <input type="button" value="回員工列表" onclick="history.back()" class="btn btn-secondary">
        </div>
     </div>
  </form>
</main>

<?php echo QATransportStaffFooter();?>
</body>
</html>
<?php
if(isset($_POST['emp_edit_send'])){
	$data_array['username']=strtolower($data_array['username']);
  if($state=="add"){
    $title="測試會員帳戶註冊";
  }elseif($state=="update"){
    $title="測試會員帳戶修改";
  }

  if (!PasswordFormat($_POST['password'])){
    echo PopupWidowHref($title,"註冊會員密碼格式錯誤，請再重新輸入",false,true,false);
    exit;
  }

  if ($_POST['password']!=$_POST['confirm_password']){
    echo PopupWidowHref($title,"密碼與確認密碼不相同",false,true,false);
    exit;
  }

  if ($state=="update"){
    //$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $password = $_POST['password'];
   	if (sqlUpdateStaffAccountListPassword($staff_id,$password)){
      echo PopupWidowHref($title,"帳戶".$data_array['username']."密碼修改完成","./StaffList.php",true,false);
    }else{
      echo PopupWidowHref($title,"帳戶".$data_array['username']."密碼修改失敗",false,true,false);
    }
  }
}
?>
