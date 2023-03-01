<?php
/**
 * 1.Bootstrap5 共用Jquery匯入這必須用在最尾
 *
 * @author Peter Chang
 *
 * @return string
 */
function getBoostrapBlundleJsImportEnd(){
    $result="
<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js' integrity='sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p' crossorigin='anonymous'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js' integrity='sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ' crossorigin='anonymous'></script>
";
    return $result;
}
/**
 * 1.員工頁面共用的HtmlHead
 *
 * @author Peter Chang
 * 
 * @param string $title 網頁標題文字
 * 
 * @param boolean $parent_link 判斷資料夾是幾層
 *
 * @return string
 */
function TESTransportStaffCommonHtmlHead($title,$parent_link=true,$navbar_top_fixed=true){
    $navbar_result="";
    if ($parent_link){
        $parent_href="../../";
    }else{
        $parent_href="../";
    }
    $result="
    <meta http-equiv='content-type' content='text/html;charset=utf-8' />
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <META NAME='Author' CONTENT='測試股份有限公司'>
    <META NAME='Copyright' CONTENT='本網頁著作權屬測試股份有限公司所有'>
    <LINK rev='made' href='mailto:jack@TESTransport.com'>
    <link rev='made' href='http://www.test.com.tw'>
    <title>".$title."</title>
    ".$navbar_result."
    <link href='".$parent_href."css/IconAHrefShow.css' rel='stylesheet' type='text/css'>
    <link href='".$parent_href."assets/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='".$parent_href."css/CommonCss.css' rel='stylesheet'>
    <link rel='canonical' href='https://getbootstrap.com/docs/5.0/examples/sign-in/'>
    <link rel='shortcut icon' href='".$parent_href."images/ico.png'>
    <link rel='icon' href='".$parent_href."images/ico.png' type='image/ico' />
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='".$parent_href."js/CommonPage.js'></script>";
    return $result;
}
/**
 * 1.員工頁面共用的Header開頭
 * 2.這邊將員工權限做一些控管顯示
 *
 * @author Peter Chang
 * 
 * @param string $title 網頁標題文字
 * 
 * @param boolean $parent_link 判斷資料夾是幾層
 *
 * @return array(boolean,string)
 */
function TESTransportStaffHeader($parent_link){
    $msg="";
    if ($parent_link){
        $parent_href="../../";
        $dropdown_href="../";
    }else{
        $parent_href="../";
        $dropdown_href="./";
    }
    if (isset($_SESSION['username']) && isset($_SESSION['owner_company_id'])){
        $row=getStaffAccountListUsername($_SESSION['username']);
        $staff_array=getStaffListStaffId($_SESSION['staff_id']);
        if (!$row){
            $msg.=PopupWidowScriptHiddenButton(false,"NotStaffLogin").PopupStaticWidowHref("測試財務系統","不是此測試財務系統會員。",$parent_href."view/Staff/StaffLogin.php",true,"NotStaffLogin");
            $msg.=getBoostrapBlundleJsImportEnd();
            return array(false,$msg);
        }
    }else{
        $msg.=PopupWidowScriptHiddenButton(false,"NotStaffLogin").PopupStaticWidowHref("測試財務系統","請先登入會員。",$parent_href."view/Staff/StaffLogin.php",true,"NotStaffLogin");
        $msg.=getBoostrapBlundleJsImportEnd();
        return array(false,$msg);
    }
    $msg.="
<nav class='navbar navbar-expand-lg navbar-dark navbar-static-top bg-dark '>
  <div class='container-fluid bg-dark'>
     <img src='".$parent_href."/assets/brand/TEST_log.png' width='150' height='100' class='me-3' alt='Bootstrap'>
      <a class='navbar-brand' >".$staff_array['extension']." ".ucfirst(strtolower($staff_array['ename']))." ".ucfirst(strtolower($staff_array['elastname']))."</a>
    <button class='navbar-toggler p-0 border-0' type='button' data-bs-toggle='offcanvas' aria-label='Toggle navigation'>
    </button>
    <div class='navbar-collapse offcanvas-collapse' id='navbarsExampleDefault'>
    <ul class='navbar-nav me-auto mb-2 mb-lg-0'>";
        $msg.=getStaffHeaderPriorityDropDownList($dropdown_href);
        $row=getOwnerCompanyStaffId($_SESSION['owner_company_id']);
      $msg.="</ul>
      <a class='navbar-brand' >".$row["company_chinese"]."</a>
        
        <button class='btn btn-outline-success' onclick=\"location.href='".$dropdown_href."StaffLogout.php'\" >登出</button>
    </div>
  </div>
</nav>
<div class='row'>
</div>
";
return array(true,$msg);
}
/**
 * 1.會員頁面共用的Footer開頭，且匯入js共用的彈跳視窗使用必須在尾端
 *
 * @author Peter Chang
 *
 * @return string
 */
function TESTransportStaffFooter(){
    $msg="
<nav class='navbar text-light navbar-dark bg-dark'>
<div class='container-fluid'>
<ul class='list-unstyled' style='width:100%'>
    <p class='text-start'>電話：886-2-1234-5678 &nbsp;&nbsp; 傳真：886-2-1234-4567 &nbsp;&nbsp; </p>
    <p class='text-start'>地址：台北市XX區XXX路X段XXX號XX樓 Copyright &copy; 2023, All Rights Reserved by Peter Test Co., LTD.</p>
    <li class='text-end'>建議使用瀏覽器：IE 9以後版本或Chrome 60.0以上</li>
</ul>
</div>
</nav>
".getBoostrapBlundleJsImportEnd();
return $msg;
}
/**
 * 1.在頁面資料開頭判斷錯誤，會有靜態彈跳視窗畫面時，先需匯入的Html
 *
 * @author Peter Chang
 *
 * @return string
 */
function TESTransportStaffPageHeadDecideErrorImportHtml($head,$parent_link){
    $msg=TESTransportStaffCommonHtmlHead($head,$parent_link);
    $msg.=PopupWidowScriptHiddenButton(false,"StaffPriorityMessage");
    $msg.=getBoostrapBlundleJsImportEnd();
return $msg;
}
/**
 * 1.Html Form頁面共用的Radio
 *
 * @author Peter Chang
 *
 * @param string $postname 為Form表單接收的資料
 * 
 * @param string $class 為將Radio加上class
 * 
 * @param string $data 為預設勾選的選項，若沒有就預設為第一個打勾
 * 
 * @param array $values 此陣列為Radio的value
 * 
 * @param array $shownames 此陣列為顯示的名稱
 * 
 * @return string
 */
function getHtmlRadio($postname,$class,$data,$values,$shownames)
{
    $result = "";
    foreach ($values as $key => $value){
        if ($data==$values[$key]){
            $result.="<input type='radio' name='".$postname."' class='".$class."' value=".$values[$key]." checked>".$shownames[$key];
        }elseif(trim($data)=="" AND $key==0){
            $result.="<input type='radio' name='".$postname."' class='".$class."' value=".$values[$key]." checked>".$shownames[$key];
        }
        else{
            $result.="<input type='radio' name='".$postname."' class='".$class."' value=".$values[$key]." >".$shownames[$key];
        }
    }
    return $result;
}
/**
 * 1.一般彈跳視窗內容
 *
 * @author Peter Chang
 * 
 * @param string $title 彈跳視窗標題
 *
 * @param string $message 彈跳視窗訊息
 * 
 * @param boolean|string $href 是否需要連結到其他網頁
 * 
 * @param boolean $script 是否需要自動跳視窗
 * 
 * @param boolean|string $modal_id 此為彈跳視窗的Id
 * 
 * @return string
 */
function PopupWidowHref($title,$message,$href,$script,$modal_id){
    if (!$modal_id){
        $modal_id="";
    }
    $msg="
<div class='modal fade' id='exampleModal".$modal_id."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>".$title."</h5>
      </div>
      <div class='modal-body'>
        ".$message."
      </div>
      <div class='modal-footer'>";
      if($href=="reload"){
        $msg.="<input type='button' class='btn btn-secondary' data-bs-dismiss='modal'  value='關閉' onclick=\"history.go(0)\" >";
      }elseif($href=="back"){
        $msg.="<input type='button' class='btn btn-secondary' data-bs-dismiss='modal'  value='關閉' onclick=\"history.back()\" >";
      }elseif ($href){
        $msg.="<input type='button' class='btn btn-secondary' data-bs-dismiss='modal'  value='關閉' onclick=\"location.href='".$href."'\" >";
      }else{
                $msg.="<input type='button' class='btn btn-secondary' data-bs-dismiss='modal' value='關閉'>";
      }
      $msg.="</div>
    </div>
  </div>
</div>";
    if($script){
        $msg.='<script type="text/javascript">$(document).ready(function(){$( "#popupwidow'.$modal_id.'" ).click();});</script>';
    }
  return $msg;
}
/**
 * 1.靜態彈跳視窗必須按關閉才能關掉視窗
 *
 * @author Peter Chang
 * 
 * @param string $title 彈跳視窗標題
 *
 * @param string $message 彈跳視窗訊息
 * 
 * @param boolean|string $href 是否需要連結到其他網頁
 * 
 * @param boolean $script 是否需要自動跳視窗
 * 
 * @param boolean|string $modal_id 此為彈跳視窗的Id
 * 
 * @return string
 */
function PopupStaticWidowHref($title,$message,$href,$script,$modal_id){
    if (!$modal_id){
        $modal_id="";
    }
    $msg="
<input type='button' class='btn btn-primary' id='staticBackdrop".$modal_id."' data-bs-toggle='modal' data-bs-target='#examplestaticModal".$modal_id."' hidden>
<div class='modal fade' id='examplestaticModal".$modal_id."' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='staticBackdropLabel'>".$title."</h5>
      </div>
      <div class='modal-body'>
        ".$message."
      </div>
      <div class='modal-footer'>";
      if($href=="reload"){
        $msg.="<input type='button' class='btn btn-secondary' data-bs-dismiss='modal'  value='關閉' onclick=\"history.go(0)\" >";
      }elseif($href=="back"){
        $msg.="<input type='button' class='btn btn-secondary' data-bs-dismiss='modal'  value='關閉' onclick=\"history.go(-1)\" >";
      }elseif ($href){
        $msg.="<input type='button' class='btn btn-secondary' data-bs-dismiss='modal'  value='關閉' onclick=\"location.href='".$href."'\" >";
      }else{
        $msg.="<input type='button' class='btn btn-secondary' data-bs-dismiss='modal' value='關閉'>";
      }
      $msg.="</div>
    </div>
  </div>
</div>";
    if($script){
        $msg.='<script type="text/javascript">$(document).ready(function(){$( "#staticBackdrop'.$modal_id.'" ).click();});</script>';
    }
  return $msg;
}
/**
 * 1.此為關閉視窗為確認及取消
 *
 * @author Peter Chang
 * 
 * @param string $title 彈跳視窗標題
 *
 * @param string $message 彈跳視窗訊息
 * 
 * @param string $value 為確認前往的按鈕顯示文字
 * 
 * @param string $close 為關閉視窗顯示的文字
 * 
 * @param boolean|string $href 是否需要連結到其他網頁
 * 
 * @param boolean $script 是否需要自動跳視窗
 * 
 * @param boolean|string $modal_id 此為彈跳視窗的Id
 * 
 * @return string
 */
function PopupCloseWidowHref($title,$message,$value,$close,$href,$script,$modal_id){
    if (!$modal_id){
        $modal_id="";
    }
    $msg="
<div class='modal fade' id='exampleModalclose".$modal_id."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>".$title."</h5>
         <input type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'>
      </div>
      <div class='modal-body'>
        ".$message."
      </div>
      <div class='modal-footer'>";
        $msg.="<input type='button' class='btn btn-secondary' id='popupclosewidowId".$modal_id."' data-bs-dismiss='modal'  value='".$value."'  >";
       $msg.="<input type='button' class='btn btn-secondary' id='popupclosewidowcloseId".$modal_id."' data-bs-dismiss='modal' value='".$close."'>";
      $msg.="</div>
    </div>
  </div>
</div>";
    if($script){
        $msg.='<script type="text/javascript">$(document).ready(function(){$( "#popupclosewidow'.$modal_id.'" ).click();});</script>';
    }
  return $msg;
}
/**
 * 1.彈跳視窗隱藏按鈕
 *
 * @author Peter Chang
 * 
 * @param boolean|string $modal_id 此為彈跳視窗的Id
 * 
 * @param boolean|string $static_id 此為靜態彈跳視窗的Id
 * 
 * @param boolean|string $modal_close_id 此為關閉彈跳視窗的Id
 * 
 * @return string
 */
function PopupWidowScriptHiddenButton($modal_id,$static_id=false,$modal_close_id=false){
    $msg="
<input type='button' class='btn btn-primary' id='popupwidow' data-bs-toggle='modal' data-bs-target='#exampleModal' hidden>";
    if($modal_id){
        $msg.="<input type='button' class='btn btn-primary' id='popupwidow".$modal_id."' data-bs-toggle='modal' data-bs-target='#exampleModal".$modal_id."' hidden>";
    }
    if($static_id){
        $msg.="<input type='button' class='btn btn-primary' id='staticBackdrop".$static_id."' data-bs-toggle='modal' data-bs-target='#examplestaticModal".$static_id."' hidden>";
    }
    if($modal_close_id){
        $msg.="<input type='button' class='btn btn-primary' id='popupclosewidow".$modal_close_id."' data-bs-toggle='modal' data-bs-target='#exampleModalclose".$modal_close_id."' hidden>";
    }
    return $msg;

}
function JumpPageDelay($href,$second=3){
    $second=$second*1000;
    $msg='<script type="text/javascript">';
    $msg.='setTimeout("window.location.href= \''.$href.'\'",'.$second.')';
    $msg.='</script>';
    return $msg;
}
/**
 * 1.全部頁面共用頁數頁碼顯示
 *
 * @author Peter Chang
 * 
 * @param integer $page 目前第幾頁
 * 
 * @param integer $pages 總頁數
 * 
 * @return string
 */
function getAllPageNum($page,$pages){
    $select_num="";
    $content="<ul class='pagination'>";
    if($page==1)        {$disf = " btn disabled";}else {$disf="";}
    if($page==$pages)   {$disl = " btn disabled";}else {$disl="";}
    for ($co=1;$co<=$pages;$co++) {
        if ($co==$page){
            $select_num.= "\t<option value=$co selected>$co</option>";
        }else{
            $select_num.= "\t<option value=$co>$co</option>";
        }
    }
    //<button type='button' onclick='movepage(1)' ".$disf."> |< </button>
    $content.="
    <li class='page-item'>
    <a class='page-link".$disf."' href='#' onclick='movepage(1)'>
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chevron-bar-left' viewBox='0 0 16 16'>
        <path fill-rule='evenodd' d='M11.854 3.646a.5.5 0 0 1 0 .708L8.207 8l3.647 3.646a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708 0zM4.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 1 0v-13a.5.5 0 0 0-.5-.5z'/>
        </svg>
    </a>
    </li>
    <li class='page-item'>
    <a class='page-link".$disf."' href='#'  onclick='movepage(".($page-1).")' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a>
    </li>";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if ( $page-10 < $i && $i < $page+10 ) {
            $content.= "<li class='page-item'><a class='page-link' href='#' onclick='movepage($i)'>".$i."</a></li>";
        }
    } 
    $content.="
    <li class='page-item'>
      <a class='page-link".$disl."' href='#' aria-label='Next' onclick='movepage(".($page+1).")'><span aria-hidden='true'>&raquo;</span>
      </a>
      </li>
    <li class='page-item'>
    <a class='page-link".$disl."' href='#' onclick='movepage(".$pages.")'> 
    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chevron-bar-right' viewBox='0 0 16 16'>
    <path fill-rule='evenodd' d='M4.146 3.646a.5.5 0 0 0 0 .708L7.793 8l-3.647 3.646a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708 0zM11.5 1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13a.5.5 0 0 1 .5-.5z'/>
    </svg>
     </a>
    </li>
    <li class='page-item'>
   <div class='input-group'>
    <select class='form-select' size='1' id='selectpage'>".$select_num."</select>
    <span class='align-self-center'>
     頁，共".$pages."頁</div>
    </div>
    </li>
    </ul>";
return $content;
}
/**
 * 1.若無預設顯示比數的話直接預設1頁10筆
 *
 * @author Peter Chang
 * 
 * @return integer
 */
function getAllPageNumPer(){
    $per=10;
    return $per;
}
/**
 * 1.全部頁面共用頁數計算
 *
 * @author Peter Chang
 * 
 * @param integer $page 目前第幾頁
 * 
 * @param integer $page_total 總筆數
 * 
 * @param boolean|integer $per 一頁幾筆
 * 
 * @return array(string,integer,integer,integer)
 */
function getListPageText($page,$page_total,$per=false){
    if ($page==0){$page=1;}
    if(!$per){
        $per=getAllPageNumPer();
    }
    $pages = ceil($page_total/$per);
    if($page>$pages && $pages!=0){$page=$pages;}
    $start = ($page-1)*$per;
    $page_text=getAllPageNum($page,$pages);
    return array($page_text,$page,$start,$per);
}
/**
 * 1.href右上顯示未處理訊息使用
 *
 * @author Peter Chang
 * 
 * @param integer $text 顯示數字為多少
 * 
 * @return string
 */
function getHtmlButtonAHrefBadge($text){
    $msg="<span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger'>
            ".$text."
            <span class='visually-hidden'>unread messages</span>
            </span>";
    return $msg;
}
/**
 * 1.
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @return string
 */
function getHtmlFormCheckInlineInputRadio($name,$ids,$values,$labels,$default_value){
    $result="";
    foreach($ids as $key=>$id){
        if(($default_value=="" || $default_value===false) && $key==0){
            $checked=" checked";
        }elseif($values[$key]==$default_value){
            $checked=" checked";
        }else{
            $checked="";
        }
        $result.="
    <div class='form-check form-check-inline'>
        <input class='form-check-input' type='radio' name='".$name."' id='".$ids[$key]."' value='".$values[$key]."' ".$checked.">
        <label class='form-check-label' for='".$ids[$key]."'>".$labels[$key]."</label>
    </div>
    ";
    }
    return $result;
}
/**
 * 1.
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @return string
 */
function getHtmlFormCheckInlineInputCheckBoxCheckedOne($name,$value,$label,$default_value){
    $result="";
    if($default_value=="" || $default_value===false){
        $checked=" checked";
    }elseif($value==$default_value){
        $checked=" checked";
    }else{
        $checked="";
    }
        $result.="
    <input class='form-check-input' type='checkbox' name='".$name."' value='".$value."' ".$checked.">
          <label class='form-check-label' >".$label."</label>
    ";
    
    return $result;
}
/**
 * 1.HtmlAHref資訊Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @return string
 */
function getHtmlAHrefInformationIcon($href){
    $result="<a href='".$href."' class='information'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-info-circle' viewBox='0 0 16 16'>
  <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
  <path d='m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref修改Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @return string
 */
function getHtmlAHrefUpdateIcon($href){
    $result="<a href='".$href."' class='update'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
  <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
  <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/></svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref紀錄Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @return string
 */
function getHtmlAHrefRecordIcon($href){
    $result="<a href='".$href."' target='_blank' class='record'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-card-list' viewBox='0 0 16 16'><path d='M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z'/>
  <path d='M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref合併Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @return string
 */
function getHtmlAHrefMergeIcon($href){
    $result="<a href='".$href."' class='merge'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-arrows-collapse' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8zm7-8a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 4.293V.5A.5.5 0 0 1 8 0zm-.5 11.707-1.146 1.147a.5.5 0 0 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 11.707V15.5a.5.5 0 0 1-1 0v-3.793z'/></svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref還原Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefReplyFillIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='reply'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-reply-fill' viewBox='0 0 16 16'><path d='M5.921 11.9 1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z'/></svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref開檔Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefOpenCaseIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='open_case' ><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-folder-symlink-fill' viewBox='0 0 16 16'>
  <path d='M13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2l.04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3zM2.19 3c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672a1 1 0 0 1 .707.293L7.586 3H2.19zm9.608 5.271-3.182 1.97c-.27.166-.616-.036-.616-.372V9.1s-2.571-.3-4 2.4c.571-4.8 3.143-4.8 4-4.8v-.769c0-.336.346-.538.616-.371l3.182 1.969c.27.166.27.576 0 .742z'/></svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref關檔Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefCloseCaseIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='close_case' ><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-file-earmark-excel-fill' viewBox='0 0 16 16'>
  <path d='M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM5.884 6.68 8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 1 1 .768-.64z'/></svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref垃圾桶Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefTrashIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='trash' ><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'><path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
  <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/></svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref取消Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefCancelIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='cancel'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-x-square' viewBox='0 0 16 16'>
  <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z'/>
  <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/></svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref員工客服部成為客服人員Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefRecieveBookingOrderIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='recieve'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-clipboard-check' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z'/>
  <path d='M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z'/>
  <path d='M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z'/></svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref員工結案Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefCaseClosedBookingOrderIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='case_closed'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-folder-check' viewBox='0 0 16 16'>
  <path d='m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672z'/>
  <path d='M15.854 10.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.707 0l-1.5-1.5a.5.5 0 0 1 .707-.708l1.146 1.147 2.646-2.647a.5.5 0 0 1 .708 0z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref員工提供S/O Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefProvideSoBookingOrderIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='provide_so'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-file-earmark-medical-fill' viewBox='0 0 16 16'>
  <path d='M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-3 2v.634l.549-.317a.5.5 0 1 1 .5.866L7 7l.549.317a.5.5 0 1 1-.5.866L6.5 7.866V8.5a.5.5 0 0 1-1 0v-.634l-.549.317a.5.5 0 1 1-.5-.866L5 7l-.549-.317a.5.5 0 0 1 .5-.866l.549.317V5.5a.5.5 0 1 1 1 0zm-2 4.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zm0 2h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref文件核對Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefDocumentCheckBookingOrderIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='document_check'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-file-check-fill' viewBox='0 0 16 16'>
  <path d='M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1.146 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708.708z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref財務收款Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefCollectionBookingOrderIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='collection'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-server' viewBox='0 0 16 16'>
  <path d='M1.333 2.667C1.333 1.194 4.318 0 8 0s6.667 1.194 6.667 2.667V4c0 1.473-2.985 2.667-6.667 2.667S1.333 5.473 1.333 4V2.667z'/>
  <path d='M1.333 6.334v3C1.333 10.805 4.318 12 8 12s6.667-1.194 6.667-2.667V6.334a6.51 6.51 0 0 1-1.458.79C11.81 7.684 9.967 8 8 8c-1.966 0-3.809-.317-5.208-.876a6.508 6.508 0 0 1-1.458-.79z'/>
  <path d='M14.667 11.668a6.51 6.51 0 0 1-1.458.789c-1.4.56-3.242.876-5.21.876-1.966 0-3.809-.316-5.208-.876a6.51 6.51 0 0 1-1.458-.79v1.666C1.333 14.806 4.318 16 8 16s6.667-1.194 6.667-2.667v-1.665z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref結關日Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefBookingOrderCutOffDateIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='cut_off_date'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-flag' viewBox='0 0 16 16'>
  <path d='M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12.435 12.435 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A19.626 19.626 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a19.587 19.587 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21.294 21.294 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21.317 21.317 0 0 0 14 7.655V1.222z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref開航日Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @return string
 */
function getHtmlAHrefBookingOrderOnBoardDateIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='onboard_date'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-tsunami' viewBox='0 0 16 16'>
  <path d='M.036 12.314a.5.5 0 0 1 .65-.278l1.757.703a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.757-.703a.5.5 0 1 1 .372.928l-1.758.703a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0l-1.757-.703a.5.5 0 0 1-.278-.65zm0 2a.5.5 0 0 1 .65-.278l1.757.703a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.014-.406a2.5 2.5 0 0 1 1.857 0l1.015.406a1.5 1.5 0 0 0 1.114 0l1.757-.703a.5.5 0 1 1 .372.928l-1.758.703a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0l-1.014-.406a1.5 1.5 0 0 0-1.114 0l-1.015.406a2.5 2.5 0 0 1-1.857 0l-1.757-.703a.5.5 0 0 1-.278-.65zM2.662 8.08c-.456 1.063-.994 2.098-1.842 2.804a.5.5 0 0 1-.64-.768c.652-.544 1.114-1.384 1.564-2.43.14-.328.281-.68.427-1.044.302-.754.624-1.559 1.01-2.308C3.763 3.2 4.528 2.105 5.7 1.299 6.877.49 8.418 0 10.5 0c1.463 0 2.511.4 3.179 1.058.67.66.893 1.518.819 2.302-.074.771-.441 1.516-1.02 1.965a1.878 1.878 0 0 1-1.904.27c-.65.642-.907 1.679-.71 2.614C11.076 9.215 11.784 10 13 10h2.5a.5.5 0 0 1 0 1H13c-1.784 0-2.826-1.215-3.114-2.585-.232-1.1.005-2.373.758-3.284L10.5 5.06l-.777.388a.5.5 0 0 1-.447 0l-1-.5a.5.5 0 0 1 .447-.894l.777.388.776-.388a.5.5 0 0 1 .447 0l1 .5a.493.493 0 0 1 .034.018c.44.264.81.195 1.108-.036.328-.255.586-.729.637-1.27.05-.529-.1-1.076-.525-1.495-.426-.42-1.19-.77-2.477-.77-1.918 0-3.252.448-4.232 1.123C5.283 2.8 4.61 3.738 4.07 4.79c-.365.71-.655 1.433-.945 2.16-.15.376-.301.753-.463 1.13z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref往下個步驟Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @param string $class 設定class
 * 
 * @return string
 */
function getHtmlAHrefBookingOrderNextScheduleIcon($href,$onclick,$class){
    $result="<a href='".$href."'  onclick='".$onclick."' class='".$class."'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-box-arrow-right' viewBox='0 0 16 16'>
  <path fill-rule='evenodd' d='M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z'/>
  <path fill-rule='evenodd' d='M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref上傳檔案及日期Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @param string $class 設定class
 * 
 * @return string
 */
function getHtmlAHrefBookingOrderDateIcon($href,$onclick,$class){
    $result="<a href='".$href."' onclick='".$onclick."' class='".$class."'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-calendar-check' viewBox='0 0 16 16'>
  <path d='M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z'/>
  <path d='M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref回復至上個步驟Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 觸發Juery跳視窗
 * 
 * @param string $class 設定class
 * 
 * @return string
 */
function getHtmlAHrefBookingOrderScheduleReplyIcon($href,$onclick,$class){
    $result="<a href='".$href."' onclick='".$onclick."' class='".$class."'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-skip-backward-circle-fill' viewBox='0 0 16 16'>
  <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.79-2.907L8.5 7.028V5.5a.5.5 0 0 0-.79-.407L5 7.028V5.5a.5.5 0 0 0-1 0v5a.5.5 0 0 0 1 0V8.972l2.71 1.935a.5.5 0 0 0 .79-.407V8.972l2.71 1.935A.5.5 0 0 0 12 10.5v-5a.5.5 0 0 0-.79-.407z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref附檔Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $text 附檔檔名
 * 
 * @return string
 */
function getHtmlAHrefBookingOrderAttachmentIcon($href,$text){
    $result="<a href='".$href."'  target='_blank' class='text-decoration-none'>".$text."<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-file-earmark-check-fill' viewBox='0 0 16 16'>
  <path d='M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref附檔Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $attachment 附檔檔名
 * 
 * @return string
 */
function getHtmlButtonBookingOrderMemberAttachmentIcon($href,$attachment){
    $result="<button type='button' class='btn btn-secondary' onclick='window.open(\"".$href."\", \"_blank\")'>".$attachment."<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-file-earmark-check-fill' viewBox='0 0 16 16'>
  <path d='M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708z'/>
</svg></button> ";
    return $result;
}
/**
 * 1.HtmlAHref黑單Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 點擊觸發Juqery事件
 * 
 * @return string
 */
function getHtmlAHrefAddBlackListIcon($href,$onclick){
    $result="<a href='".$href."' onclick='".$onclick."' class='add_blacklist'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-person-x' viewBox='0 0 16 16'><path d='M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z'/>
  <path fill-rule='evenodd' d='M12.146 5.146a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z'/>
</svg></a>";
    return $result;
}
/**
 * 1.HtmlAHref移除黑單Icon顯示
 *
 * @author Peter Chang
 * 
 * @param string $href 超連結
 * 
 * @param string $onclick 點擊觸發Juqery事件
 * 
 * @return string
 */
function getHtmlAHrefRemoveBlackListIcon($href,$onclick){
    $result="<a href='".$href."'  onclick='".$onclick."' class='remove_blacklist'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-person-check' viewBox='0 0 16 16'>
  <path d='M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z'/>
  <path fill-rule='evenodd' d='M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z'/>
</svg></a>";
    return $result;
}

?>