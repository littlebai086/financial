<?php 
set_time_limit(0);
date_default_timezone_set('Asia/Taipei');
/**
 * 1.將資料0存入資料庫的NULL轉成字串存入
 *
 * @author Peter Chang
 * 
 * @param integer $data 資料
 * 
 * @return integer
 */
function getDataZeroTransferNullSaveSql($data,$str=false){
    if($str===true){$data="'".$data."'";}elseif($data==0 || $data==null){$data="NULL";}
    return $data;
}
/**
 * 1.陣列為公司的Email尾巴
 *
 * @author Peter Chang
 * 
 * @return array
 */
function getEmailAddressArray(){
    return array("@test.com","@test2.com");
}
/**
 * 1.將員工名稱顯示
 *
 * @author Peter Chang
 * 
 * @param array $staff_array 此為員工資訊的陣列
 * 
 * @return string
 */
function getTESTCompanySendShowName($staff_array){
    return $staff_array["extension"]." ".ucfirst(strtolower($staff_array["ename"]))." ".ucfirst(strtolower($staff_array["elastname"]))." / QA Transport";
}
/**
 * 1.將員工名稱顯示
 *
 * @author Peter Chang
 * 
 * @param array $staff_array 此為員工資訊的陣列
 * 
 * @return string
 */
function getTESTShowName($staff_array){
    return $staff_array["extension"]." ".ucfirst(strtolower($staff_array["ename"]))." ".ucfirst(strtolower($staff_array["elastname"]));
}
/**
 * 1.將員工顯示中英文名稱及稱謂
 *
 * @author Peter Chang
 * 
 * @param array $staff_array 此為員工資訊的陣列
 * 
 * @return string
 */
function getStaffEnglishnameChineseNameGender($staff_array){
    return $staff_array['ename']." ".$staff_array['elastname']." ".$staff_array['cname']." ".getGenderChinese($staff_array['gender']);
}
/**
 * 1.將搜尋出員工清單要寄的名單轉成收件人
 *
 * @author Peter Chang
 * 
 * @param array $buf 員工清單搜尋結果
 * 
 * @return string
 */
function getStaffLIstTransferSendMailRecipients($buf){
    $recipients=array();
    foreach($buf as $row){
        $array=array("email" =>$row["email"],"name"=>getTESTCompanySendShowName($row));
        array_push($recipients,$array);
    }
    return $recipients;
}
/**
 * 1.抓資料庫StaffList搜尋條件為員工清單的Id資訊
 *
 * @author Peter Chang
 * 
 * @param integer $id 員工的id
 * 
 * @return array
 */
function getStaffListId($id){
    $buf = sqlSelectStaffListId($id);
    foreach ($buf as $row){
        return $row;
    }
}
/**
 * 1.抓資料庫BankTrade搜尋條件為銀行帳戶清單的Id資訊
 *
 * @author Peter Chang
 * 
 * @param integer $id 員工的id
 * 
 * @return array
 */
function getBankTradeId($id){
    $buf = sqlSelectBankTradeId($id);
    foreach ($buf as $row){
        return $row;
    }
}

function getContainerTypeArray(){
    $array=array(
        "dry"=>array("chinese"=>"乾櫃","english"=>"Dry","value"=>"dry"),
        "tank"=>array("chinese"=>"TANK櫃","english"=>"TANK","value"=>"tank")
            );
    return $array;
}

function getDpCheckArray(){
    $array=array(
        1=>array("value"=>1,"select"=>"是"),
        2=>array("value"=>2,"select"=>"否")
    );
    return $array;
}
/**
 * 1.抓資料庫StaffAccountList搜尋條件為員工帳戶清單的Username
 *
 * @author Peter Chang
 * 
 * @param string $username 會員的username
 * 
 * @return array
 */
function getStaffAccountListUsername($username) {
  $buf=sqlSelectStaffAccountListUsername($username);
  foreach($buf as $row){
    return $row;
  }
}
/**
 * 1.抓資料庫DocumentType搜尋條件為id
 *
 * @author Peter Chang
 * 
 * @param string $value 為id
 * 
 * @return array
 */
function getDocumentTypeId($value) {
  $buf=sqlSelectDocumentTypeId($value);
  foreach($buf as $row){
    return $row;
  }
}
/**
 * 1.抓資料庫DocumentTypePermission搜尋條件為權限
 *
 * @author Peter Chang
 * 
 * @param string $value 為權限名稱
 * 
 * @return array
 */
function getDocumentTypePermission($value) {
  $buf=sqlSelectDocumentTypePermission($value);
  foreach($buf as $row){
    return $row;
  }
}
/**
 * 1.抓資料庫DocumentState搜尋條件為狀態英文
 *
 * @author Peter Chang
 * 
 * @param integer $document_state_english 為狀態英文
 * 
 * @return array
 */
function getDocumentStateEnglish($document_state_english) {
  $buf=sqlSelectDocumentStateDocumentStateEnglish($document_state_english);
  foreach($buf as $row){
    return $row;
  }
}
/**
 * 1.將文件狀態顯示回傳
 *
 * @author Peter Chang
 * 
 * @param array $row 文件狀態
 * 
 * @return array
 */
function getDocumentStateShowReturn($row) {
    if($row["state"]=="upload"){
        $text="上傳檔案";
    }elseif($row["state"]=="update"){
        $text="修改檔案";
    }elseif($row["state"]=="dp_check"){
        if($row["pass"]==2){
            $text="<font color='red'>DP審核不通過</font>";
        }elseif($row["pass"]==1){
            $text="<font color='green'>DP審核通過</font>";
        }
    }elseif($row["state"]=="reset_open_update"){
        $text="重新開啟修改功能";
    }else{
        if($row["document_state_show_color"]){
            $text="<font color='".$row["document_state_show_color"]."'>".$row["document_state_chinese"]."</font>";
        }else{
            $text=$row["document_state_chinese"];
        }
        
    }
    return $text;
}
/**
 * 1.拿取年份Html Form Select下拉式選單
 * 
 * @author Peter Chang
 * 
 * @param string $value 為貨物性質的id預設選項
 * 
 * @return string
 */
function getYearOptionYearValueYear($value){
    $result="";
    $y=date("Y");
    for ($i=2021; $i <= $y; $i++) { 
        if ($i==$value){
            $result.="<option value=".$i." selected>".$i."</option>";
        }else{
            $result.="<option value='".$i."'>".$i."</option>";
        }
    }
    return $result;
}
/**
 * 1.拿取公司Html Form Radio自己公司選單
 * 
 * @author Peter Chang
 * 
 * @param string $value 為貨物性質的id預設選項
 * 
 * @return string
 */
function getOwnerCompanyRadio(){
    $result="";
    $buf = sqlSelectOwnerCompanyId();
    foreach($buf as $key=>$row){
        $checked="";
        if($key==0){$checked=" checked";}
        $result.="
        <div class='form-check'>
            <input class='form-check-input' type='radio' name='owner_company_id' value='".$row['owner_company_id']."' ".$checked."  >
            <label class='form-check-label' for='flexRadioDefault1'>
                ".$row['company_chinese']."
            </label>
        </div>
        ";
    }
    return $result;
}
/**
 * 1.拿取自己公司的資料
 * 
 * @author Peter Chang
 * 
 * @param integer $staff_id 為員工id
 * 
 * @return string
 */
function getStaffOwnerCompanyStaffId($staff_id){
    $buf = sqlSelectStaffOwnerCompanyStaffId($staff_id);
    foreach($buf as $row){
        return $row;
    }
}
/**
 * 1.拿取自己公司的資料
 * 
 * @author Peter Chang
 * 
 * @param integer $id 為公司資料id
 * 
 * @return string
 */
function getOwnerCompanyStaffId($id){
    $buf = sqlSelectOwnerCompanyStaffId($id);
    foreach($buf as $row){
        return $row;
    }
}

/**
 * 1.拿取月份Html Form Select下拉式選單
 * 
 * @author Peter Chang
 * 
 * @param string $value 為貨物性質的id預設選項
 * 
 * @return string
 */
function getMonthOptionMonthValueMonth($value){
    $result="";
    for ($i=1; $i <= 12; $i++) {
        $month=$i;
        if($i<10){
            $month="0".$i;
        }
        if ($i==$value){
            $result.="<option value='".$month."' selected>".$i."</option>";
        }else{
            $result.="<option value='".$month."'>".$i."</option>";
        }
    }
    return $result;
}


/**
 * 1.抓資料庫StaffAccountList搜尋條件為員工帳戶清單的staff_id
 *
 * @author Peter Chang
 * 
 * @param integer $staff_id 員工的id
 * 
 * @return array
 */
function getStaffAccountListStaffId($staff_id) {
  $buf=sqlSelectStaffAccountListStaffId($staff_id);
  foreach($buf as $row){
    return $row;
  }
}
/**
 * 1.拿取月份Html Form Select下拉式選單
 * 
 * @author Peter Chang
 * 
 * @param string $value 為銀行交易性質的id預設選項
 * 
 * @return string
 */
function getBankTradeOptionBankTradeValueBankTradeId($value){
    $result="";
    $buf = sqlSelectBankTrade();
    foreach ($buf as $row){
        if($row['bank_trade_id']==$value){
            $result.="<option value='".$row['bank_trade_id']."' selected>".$row['bank_trade']."</option>";
        }else{
            $result.="<option value='".$row['bank_trade_id']."'>".$row['bank_trade']."</option>";
        }
    }
    return $result;
}
/**
 * 1.拿取幣別Html Form Select下拉式選單
 * 
 * @author Peter Chang
 * 
 * @param string $value 為銀行交易性質的id預設選項
 * 
 * @return string
 */
function getCurrencyOptionCurrencyValueCurrencyId($value){
    $result="";
    $buf = sqlSelectCurrency();
    foreach ($buf as $row){
        if($row['currency_id']==$value){
            $result.="<option value='".$row['currency_id']."' selected>".$row['currency']."</option>";
        }else{
            $result.="<option value='".$row['currency_id']."'>".$row['currency']."</option>";
        }
    }
    return $result;
}
/**
 * 1.拿取貨櫃種類Html Form Select下拉式選單
 * 
 * @author Peter Chang
 * 
 * @param string $value 為貨櫃種類預設選項
 * 
 * @return string
 */
function getContainerTypeOptionContainerType($value){
    $result="";
    $buf = getContainerTypeArray();
    foreach ($buf as $row){
        if($row['value']==$value){
            $result.="<option value='".$row['value']."' selected>".$row['english']."</option>";
        }else{
            $result.="<option value='".$row['value']."'>".$row['english']."</option>";
        }
    }
    return $result;
}
/**
 * 1.拿取貨櫃種類Html Form Select下拉式選單
 * 
 * @author Peter Chang
 * 
 * @param string $value 為貨櫃種類預設選項
 * 
 * @return string
 */
function getDPCheckOption($value){
    $result="";
    $buf = getDpCheckArray();
    foreach ($buf as $key=>$row){
        if($row['value']==$value || ($key==2 && !$value)){
            $result.="<option value='".$row['value']."' selected>".$row['select']."</option>";
        }else{
            $result.="<option value='".$row['value']."'>".$row['select']."</option>";
        }
    }
    return $result;
}
/**
 * 1.文件檔案權限判斷類別
 *
 * @author Peter Chang
 * 
 * @param string $value 預設selected值
 * 
 * @return string
 */
function getDocumentTypeDepartmentPriority($document_type_id,$staff_id){
    $staff_array=getStaffListStaffId($staff_id);
    $row=getDocumentTypeId($document_type_id);
    $department_ids=explode(";",$row["department_id"]);
    if( array_intersect($staff_array["department_ids"],$department_ids)){
        return true;
    }
    return false;
}
/**
 * 1.文件檔案類別預設值
 *
 * @author Peter Chang
 * 
 * @param string $value 預設selected值
 * 
 * @return string
 */
function getDocumentTypeDepartmentDefaultFirst($staff_id){
    $staff_array=getStaffListStaffId($staff_id);
    $buf=sqlSelectDocumentTypeDepartmentOwnerCompany();
    
    foreach($buf as $row){
        $department_ids=explode(";",$row["department_id"]);
        if(array_intersect($staff_array["department_ids"],$department_ids)){
            return $row['document_type_id'];
        }
    }
    return false;
}
/**
 * 1.Form Select文件檔案類別
 *
 * @author Peter Chang
 * 
 * @param string $value 預設selected值
 * 
 * @return string
 */
function getDocumentTypeOptionDocumentTypeIdValueDocumentType($staff_id,$value){
    $result="";
    $staff_array=getStaffListStaffId($staff_id);
    $buf=sqlSelectDocumentTypeDepartmentOwnerCompany();
    foreach($buf as $row){
        $department_ids=explode(";",$row["department_id"]);
        if(array_intersect($staff_array["department_ids"],$department_ids)){
            if($row['document_type_id']==$value){
                $result.="<option value='".$row['document_type_id']."' selected>".$row['document_type']."</option>";
            }else{
                $result.="<option value='".$row['document_type_id']."'>".$row['document_type']."</option>";
            }
        }
    }
    return $result;
}

/**
 * 1.用於公司若有分機就將電話加分機回傳資料，沒有的話只回傳電話
 *
 * @author Peter Chang
 * 
 * @param string $phone 電話
 * 
 * @param string $extension 分機
 * 
 * @return string
 */
function getPhoneExtensionText($phone,$extension){
    $text="";
    if ($extension){
        $text.=$phone."分機".$extension;
    }else{
        $text.=$phone;
    }
    return $text;
}
/**
 * 1.公司員工新增帳戶填寫Form Html Select Email
 *
 * @author Peter Chang
 * 
 * @param string $value 為預設資料
 * 
 * @return string
 */
function getEmailAddressOptionEmailAddress($value){
    $result="";
    $array=getEmailAddressArray();
    foreach($array as $address){
        if ($address==$value){
            $result.= "<option value=".$address." selected>".$address."</option>";
        }else{
            $result.= "<option value=".$address.">".$address."</option>";
        }
    }
    return $result;
}
/**
 * 1.員工後台員工控管總權限
 * 2.department=>部門權限
 * 3.handling_department=>專責處理部門
 * 4.position=>職位權限
 * 5.extra_staff_id=>額外權限處理staff_id人員
 * 6.baged_show=>右上顯示資料
 * 7.function_permission=>額外功能權限
 * 8.function_permission=>key 此key為狀態
 * 9.bottom_function=>下拉功能
 *
 * @author Peter Chang
 * 
 * @return array
 */
function getStaffListPriorityArray(){
    $array=array(
        "department"=>"資訊部;人力資源部",
        "handling_department"=>"人力資源部",
        "position"=>"總經理",
        "extra_staff_id"=>false,
        "show_text"=>"員工控管",
        "baged_show"=>false,
        "url"=>false,
        "function_permission"=>array(
            "add"=>array("permission"=>"add","show_text"=>"新增"),
            "update"=>array("permission"=>"update","show_text"=>"修改","required"=>"id"),
            "resign"=>array("permission"=>"resign","show_text"=>"離職"),
            "furlough"=>array("permission"=>"furlough","show_text"=>"留職停薪"),
            "reinstatement"=>array("permission"=>"reinstatement","show_text"=>"復職"),
        ),
        "bottom_function"=>array(
            array(
                "page_id"=>11,
                "show_text"=>"新增員工資料",
                "url"=>"Staff/Staff.php?state=add",
                "bottom_function"=>false
            ),
            array(
                "page_id"=>12,
                "show_text"=>"員工資料列表",
                "url"=>"Staff/StaffList.php",
                "bottom_function"=>false
            )
        )
    );
    return $array;
}

/**
 * 1.員工後台會員控管總權限
 * 2.department=>部門權限
 * 3.handling_department=>專責處理部門
 * 4.position=>職位權限
 * 5.extra_staff_id=>額外權限處理staff_id人員
 * 6.baged_show=>右上顯示資料
 * 7.function_permission=>額外功能權限
 * 8.function_permission=>key 此key為狀態
 * 9.bottom_function=>下拉功能
 *
 * @author Peter Chang
 * 
 * @return array
 */
function getStaffUploadFilePriorityArray(){
    //$buf = sqlSelectDocumentType();
    $array=array(
        "department"=>"all",
        "handling_department"=>false,
        "position"=>false,
        "extra_staff_id"=>false,
        "show_text"=>"上傳檔案",
        "baged_show"=>false,
        "url"=>false,
        "function_permission"=>array(
            "update"=>array("permission"=>"update","show_text"=>"修改檔案"),
            "upload"=>array("permission"=>"upload","show_text"=>"上傳檔案"),
            "del"=>array("permission"=>"del","show_text"=>"刪除")
        ),
        "bottom_function"=>array()
    );
    $buf = sqlSelectDocumentState();
    foreach ($buf as $row) {
        $array["function_permission"][$row["document_state_english"]]=
        array(
            "permission"=>$row["document_state_english"],
            "show_text"=>$row["document_state_chinese"]
        );
    }
    $buf = sqlSelectDocumentTypeOwnerCompanyOwnerCompanyId($_SESSION['owner_company_id']);  
    foreach($buf as $row){
        $i=21;
        $permission="upload_".$row["permission"];
        $show_text="上傳".$row["document_type"];
        $department_buf=sqlSelectDepartmentManyDepartmentId(explode(";",$row["department_id"]));
        $department_array=array();
        foreach($department_buf as $department_row){
            array_push($department_array,$department_row["department"]);
        }
        //$array["function_permission"][$permission]=array("permission"=>$permission,"show_text"=>$show_text);
        $arr=array(
            "page_id"=>$i,
            "department"=>implode(";",$department_array),
            "show_text"=>$show_text,
            "url"=>"DocumentFile/DocumentFile.php?state=upload&document_type_id=".$row["document_type_id"],
            "bottom_function"=>false 
        );
        array_push($array["bottom_function"], $arr);
        $i++;
    }
    return $array;
}
/**
 * 1.員工後台跑馬燈控管總權限
 * 2.department=>部門權限
 * 3.handling_department=>專責處理部門
 * 4.position=>職位權限
 * 5.extra_staff_id=>額外權限處理staff_id人員
 * 6.baged_show=>右上顯示資料
 * 7.function_permission=>額外功能權限
 * 8.function_permission=>key 此key為狀態
 * 9.bottom_function=>下拉功能
 *
 * @author Peter Chang
 * 
 * @return array
 */
function getStaffDocumentFileListPriorityArray(){
    $array=array(
        "department"=>"all",
        "handling_department"=>false,
        "position"=>false,
        "extra_staff_id"=>false,
        "show_text"=>"檔案清單",
        "baged_show"=>false,
        "function_permission"=>false,
        "url"=>"DocumentFile/DocumentFileList.php",
        "bottom_function"=>false
    );
    return $array;
}
/**
 * 1.員工後台總權限陣列
 * 2.getStaffListPriorityArray()=>員工控管權限
 * 3.getStaffMemberListPriorityArray()=>會員控管權限
 * 4.getStaffMarqueePriorityArray()=>跑馬燈權限
 * 5.getStaffDestinationPortListPriorityArray()=>目的港權限
 * 6.getStaffOceanExportQuoteListPriorityArray()=>海運報價權限
 * 7.getStaffBookingOrderListPriorityArray()=>訂艙權限
 *
 * @author Peter Chang
 * 
 * @return array
 */
function getStaffHeaderPriorityArray(){
    if($_SESSION['owner_company_id']==1){
        $array=array(
            1=>getStaffListPriorityArray(),     
            2=>getStaffUploadFilePriorityArray(),           
            3=>getStaffDocumentFileListPriorityArray()
        );
    }elseif($_SESSION['owner_company_id']==2){
        $array=array(
            2=>getStaffUploadFilePriorityArray(),           
            3=>getStaffDocumentFileListPriorityArray()
        );
    }
    return $array;
}
/**
 * 1.員工後台功能狀態判斷
 *
 * @author Peter Chang
 * 
 * @param string $state 頁面接收資訊狀態
 * 
 * @param integer $key 總權限的key
 * 
 * @param boolean|integer $id 資料庫的id
 * 
 * @param boolean $state_null 是否狀態可以為空
 * 
 * @return array
 */
function getStaffStatePriorityReturn($state,$key,$id=false,$state_null=true){
    $result="";
    $message="";
    $now_urls=explode("/",$_SERVER['REQUEST_URI']);
    $end_now_urls=end($now_urls);
    $staff_prioritys=getStaffHeaderPriorityArray();
    $arrays=$staff_prioritys[$key];
    if(!isset($_SESSION['staff_id']) || !isset($_SESSION['owner_company_id'])){
        $message="尚未登入";
        return array(false,$message);
    }
    $staff_array=getStaffListStaffId($_SESSION['staff_id']);
    if($id!==false && !$id){
        if($state!="add"){
            $message="id不可為空";
            return array(false,$message);
        }
    }elseif($id!==false && $id && $state=="add"){
        $message="新增時id不會有資料";
        return array(false,$message);
    }
    if($state===false && $state_null===false){
        $message="無狀態，錯誤";
        return array(false,$message);
    }elseif($state){
        if(!isset($arrays["function_permission"][$state])){
            return array(false,"無此狀態權限");
        }
        if(!getStaffStateFunctionPermissionReturn($arrays,$state,$staff_array)){
            return array(false,"無此狀態個別權限");
        }
    }
    
    if(isset($arrays["bottom_function"])){
        if($arrays["bottom_function"]!==false){
            foreach($arrays["bottom_function"] as $array){
                $urls=explode("/",$array["url"]);
                if(strpos($end_now_urls,end($urls))!==false){
                    if(getStaffPriorityReturn($arrays,$array,$staff_array)){
                        $message="BottomFunction權限正確";
                        return array(true,$message);
                    }
                    return array(false,"不符合權限");   
                }
                $message="網址不符合，仍可使用";
            }
        }
    }
    return array(true,$message);
}
/**
 * 1.員工後台功能下拉選單
 *
 * @author Peter Chang
 * 
 * @param string $dropdown_href 父層連結
 * 
 * @return array
 */
function getStaffHeaderPriorityDropDownList($dropdown_href){
    $result="";
    $page_keys=array();
    $staff_array=getStaffListStaffId($_SESSION['staff_id']);
    $staff_prioritys=getStaffHeaderPriorityArray();
    foreach($staff_prioritys as $arrays){
        if(getStaffPriorityReturn($arrays,false,$staff_array)){
            $baged_show_text=getBagedShowShowTextReturn($arrays);
            //id='dropdown01' data-bs-toggle='dropdown' aria-expanded='false' 會影響class=nav-link dropdown-toggle下拉清單滑動
            if($arrays["url"]!==false){
                $url=$dropdown_href.$arrays["url"];
            }else{
                $url="#";
            }
            if($arrays["bottom_function"]===false){
                 $result.="
           <li class='nav-item'>
            <a class='nav-link' href='".$url."' >".$arrays["show_text"].$baged_show_text."</a>";
            }else{
                 $result.="
           <li class='nav-item dropdown'>
            <a class='nav-link dropdown-toggle' href='".$url."' >".$arrays["show_text"].$baged_show_text."</a>";
                $result.="
                <ul class='dropdown-menu' aria-labelledby='dropdown01'>";
                foreach($arrays["bottom_function"] as $bottom_funcions){
                    if(getStaffPriorityReturn($arrays,$bottom_funcions,$staff_array)){
                        $show_text=$bottom_funcions["show_text"];
                        $baged_show_text=getBagedShowShowTextReturn($bottom_funcions);
                        if(isset($bottom_funcions["extra_show_text"])){
                            if($bottom_funcions["extra_show_text"]===true){
                                if(in_array($bottom_funcions["page_id"],$page_keys)){
                                    continue;
                                }else{
                                    array_push($page_keys,$bottom_funcions["same_key"]);
                                }
                            }
                        }
                        $result.="
                    <li><a class='dropdown-item' href='".$dropdown_href.$bottom_funcions["url"]."'>".$show_text.$baged_show_text."</a></li>";
                    }
                }
                $result.="
                </ul>";
            }
            $result.="
            </li>";
        }
    }
    return $result;
}
/**
 * 1.員工後台功能回傳浮動標籤文字
 *
 * @author Peter Chang
 * 
 * @param array $array 浮動數字標籤陣列相關文字
 * 
 * @return array
 */
function getBagedShowShowTextReturn($array){
    $show_text="";
    if(getBagedShowPriorityReturn($array)){
        $show_text=getHtmlButtonAHrefBadge(strval("+".$array["baged_show"]["num"]));
    }
    return $show_text;
}
/**
 * 1.員工後台功能回傳浮動標籤正確或錯誤
 *
 * @author Peter Chang
 * 
 * @param array $array 浮動數字標籤陣列相關資訊
 * 
 * @return boolean
 */
function getBagedShowPriorityReturn($array){
    if(isset($array["baged_show"])){
        if($array["baged_show"]!==false){
            if($array["baged_show"]["num"]>0){
                return true;
            }
        }
    }
    return false;
}
/**
 * 1.員工後台功能回傳權限正確或錯誤
 *
 * @author Peter Chang
 * 
 * @param array $arrays 權限的第一層陣列
 * 
 * @param array $array 權限的下拉清單陣列
 * 
 * @param array $staff_array 員工資料陣列
 * 
 * @return boolean
 */
function getStaffPriorityReturn($arrays,$array,$staff_array){
    $departments=explode(";",$arrays["department"]);
    $extra_staff_ids=explode(";",$arrays["extra_staff_id"]);
    $position=$arrays["position"];
    if($array!==false){
        if(isset($array["department"])){$departments=explode(";",$array["department"]);}
        if(isset($array["extra_staff_id"])){$extra_staff_ids=explode(";",$array["extra_staff_id"]);}
        if(isset($array["position"])){$position=$array["position"];}
    }
    foreach($extra_staff_ids as $extra_staff_id){
        if($staff_array["staff_id"]==$extra_staff_id && $extra_staff_id!==false && $extra_staff_id){
            return true;
        }
    }
    if(array_intersect( $departments, $staff_array['departments']) || in_array("all",$departments)){
        return true;
    }
    if(strpos($staff_array['position'],$position)!==false && $position!==false){
        return true;
    }
    return false;
}
/**
 * 1.員工後台功能回傳權限正確或錯誤
 *
 * @author Peter Chang
 * 
 * @param array $arrays 權限的第一層陣列
 * 
 * @param array $array 權限的下拉清單陣列
 * 
 * @param array $staff_array 員工資料陣列
 * 
 * @return boolean
 */
function getStaffStateFunctionPermissionReturn($arrays,$state,$staff_array){
    $extra_staff_ids=false;
    $departments=false;
    $array=$arrays["function_permission"][$state];
    if(isset($arrays["department"])){
        $departments=explode(";",$arrays["department"]);
    }
    if(isset($arrays["extra_staff_id"])){
        $extra_staff_ids=explode(";",$arrays["extra_staff_id"]);
    }



    if(isset($array["department"])){
        $departments=false;
        if($array["department"]!==false){
            $departments=explode(";",$arrays["function_permission"][$state]["department"]);
        }
    } 
    if(isset($array["extra_staff_id"])){
        $extra_staff_ids=false;
        if($array["extra_staff_id"]!==false){
            $extra_staff_ids=explode(";",$arrays["function_permission"][$state]["extra_staff_id"]);
        }
    }
    if($departments){
        foreach($departments as $key=>$department){
            if(strpos($staff_array['department'],$department)!==false ||
                $department=="all"){
                return true;
            }
        }
    }
    if($extra_staff_ids){
        foreach($extra_staff_ids as $extra_staff_id){
            if($staff_array["staff_id"]==$extra_staff_id && $extra_staff_id!==false){
                return true;
            }
        }
    }
    return false;
}
/**
 * 1.抓資料庫StaffLIst搜尋條件為Staff List資料
 * 
 * @author Peter Chang
 * 
 * @param integer $id 為員工的id
 * 
 * @return array
 */
function getStaffListStaffIdAccount($id){
    $buf = sqlSelectStaffListStaffIdAccount($id);
    if($buf){
        foreach ($buf as $row){
            return $row;
        }
    }
    return false;
}
/**
 * 1.抓資料庫StaffLIst搜尋條件為員工id
 * 
 * @author Peter Chang
 * 
 * @param integer $id 為員工的id
 * 
 * @return array
 */
function getStaffListStaffId($id){
    $buf = sqlSelectStaffListStaffId($id);
    if($buf){
        foreach ($buf as $row){
            $row["department_ids"]=explode(";",$row["department_id"]);
            $row["departments"]=explode(";",$row["department"]);            
            $row["owner_company_ids"]=explode(";",$row["owner_company_id"]);
            $row["company_chineses"]=explode(";",$row["company_chinese"]);
            $row["document_type_document_state_ids"]=explode(";",$row["document_type_document_state_id"]);
            return $row;
        }
    }
    return false;
}

/**
 * 1.拿取部門Html Form Select下拉式選單
 * 
 * @author Peter Chang
 * 
 * @param integer $value 為部門的id預設選項
 * 
 * @return string
 */
function getDepartmentOptionDepartmentValueId($value){
    $result="";
    $buf=sqlSelectDepartment();
    foreach ($buf as $row){
        if ($row['department_id']==$value){
            $result.="<option value=".$row['department_id']." selected>".$row['department']."</option>";
        }else{
            $result.="<option value=".$row['department_id'].">".$row['department']."</option>";
        }
    }
    return $result;
}
/**
 * 1.拿取新增修改員工清單部門Html Form Select下拉式選單
 * 
 * @author Peter Chang
 * 
 * @param integer $value 為部門的id預設選項
 * 
 * @return string
 */
function getDepartmentOptionDepartmentValueIds($department_ids){
    $result="";
    $buf=sqlSelectDepartment();
    foreach ($buf as $row){
        if (in_array($row["department_id"],$department_ids)){
            $result.="<option value=".$row['department_id']." selected>".$row['department']."</option>";
        }else{
            $result.="<option value=".$row['department_id'].">".$row['department']."</option>";
        }
    }
    return $result;
}
/**
 * 1.拿取新增修改員工清單部門Html Form Select下拉式選單
 * 
 * @author Peter Chang
 * 
 * @param integer $value 為部門的id預設選項
 * 
 * @return string
 */
function getOwnerCompanyOptionOwnerCompanyValueIds($owner_company_ids){
    $result="";
    $buf=sqlSelectOwnerCompany();
    foreach ($buf as $key=>$row){
        if (in_array($row["owner_company_id"],$owner_company_ids)){
            $result.="<option value=".$row['owner_company_id']." selected>".$row['company_chinese']."</option>";
        }elseif($key==0 && !$owner_company_ids){
            $result.="<option value=".$row['owner_company_id']." selected>".$row['company_chinese']."</option>";
        }else{
            $result.="<option value=".$row['owner_company_id'].">".$row['company_chinese']."</option>";
        }
    }
    return $result;
}
/**
 * 1.拿取職位Html Form Select下拉式選單
 * 
 * @author Peter Chang
 * 
 * @param integer $value 為職位的id預設選項
 * 
 * @return string
 */
function getPositionOptionPositionValueId($value){
    $result="";
    $buf=sqlSelectPosition();
    foreach ($buf as $row){
        if ($row['position_id']==$value){
            $result.="<option value=".$row['position_id']." selected>".$row['position']."</option>";
        }else{
            $result.="<option value=".$row['position_id'].">".$row['position']."</option>";
        }
    }
    return $result;
}
/**
 * 1.拿取員工狀態等Html Form Select下拉式選單
 * 
 * @author Peter Chang
 * 
 * @param integer $value 為員工狀態的id預設選項
 * 
 * @return string
 */
function getStaffStateOptionStateValueId($value){
    $result="";
    $buf=sqlSelectStaffState();
    foreach ($buf as $row){
        if ($row['staff_state_id']==$value){
            $result.="<option value=".$row['staff_state_id']." selected>".$row['state']."</option>";
        }else{
            $result.="<option value=".$row['staff_state_id'].">".$row['state']."</option>";
        }
    }
    return $result;
}

/**
 * 1.目前寄信信箱預設為公司帳戶
 * 
 * @author Peter Chang
 * 
 * @return array(string,string)
 */
function getAccountAuth(){
    $account="";
    $auth="";
    return array($account,$auth);
}
/**
 * 1.寄信時使用此function 且必須將require匯入PHPMailer
 * 
 * @author Peter Chang
 * 
 * @param string $account 寄信帳戶的帳號
 * 
 * @param string $auth 寄信帳戶的密碼
 * 
 * @param string $smtp 寄件者信箱
 * 
 * @param string $emailname 寄件者姓名
 * 
 * @param string $subject 寄信郵件主旨
 * 
 * @param string $msg 寄件郵件內容
 * 
 * @param string $signature_image 是否需要圖像
 * 
 * @param array|boolean $attach_array 為此封郵件需要的附檔
 * 
 * @param array $recipents 為收件者可以是多位但必須陣列key為name且也有email
 * 
 * @param array|boolean $cc 為郵件副本對象可以是多位但必須陣列key為name且也有email
 * 
 * @param boolean $host_green 是否需要用購買的大量寄信
 * 
 * @return boolean
 */
function sendMailLetter($account,$auth,$smtp,$emailname,$subject,$msg,
    $signature_image,$attach_array,$recipients,$cc,$host_green=false){
	$mail = new PHPMailer(); //建立新物件
	$mail->IsSMTP(); //設定使用SMTP方式寄信
	$mail->SMTPAuth = true; // 設定SMTP需要驗證
    if ($host_green){
        $mail->Host = "green.mailcloud.tw"; //設定SMTP主機
        //目前購買green的大量服務，所以SMTP改用這個用此為看當初合約購買多少並無時間隔多少再寄一次限制
    }else{
	   $mail->Host = "ms.mailcloud.com.tw"; //設定SMTP主機
    }
	$mail->Port = 25; //設定SMTP埠位，預設為25埠。
	$mail->CharSet = "utf-8"; //設定郵件編碼
	$mail->Username = "$account"; //設定驗證帳號
	$mail->Password = "$auth"; //設定驗證密碼
	$mail->From = "$smtp"; //設定寄件者信箱
	$mail->FromName = "$emailname"; //設定寄件者姓名
	$mail->Subject = "$subject"; //設定郵件標題
	$mail->Body = "$msg"; //設定郵件內容
	$mail->IsHTML(true); //設定郵件內容為HTML
    print_r($subject);
    print_r($msg);
    print_r($recipients);
    print_r($cc);
    print_r($attach_array);
    // if ($signature_image){
    //     $mail->AddEmbeddedImage($signature_image, 1, 'attachment', 'base64', 'image/gif');
    // }
    // if (is_array($attach_array)){
	//    foreach ($attach_array as $attach){
    //     $attach_path=$attach;
    //     if(mb_detect_encoding($attach)=="UTF-8"){
    //         $attach_path=mb_convert_encoding($attach,"BIG-5",'UTF-8');
    //     }
    //     $attachs=explode("/",$attach);
    //     $mail->AddAttachment($attach_path,end($attachs));
	// 	// $mail->AddAttachment($attach);
	//    }
    // }
    // //$recipients=getStaffLIstTransferSendMailRecipients(sqlSelectStaffListDepartmentPositionId("資訊部","主管"));
    
    // foreach($recipients as $recipient){
    //     $mail->AddAddress($recipient['email'],$recipient['name']); //設定收件者郵件及名稱
    // }
    // $cc=false;
    // if (is_array($cc) && !empty($cc)){
    //     foreach ($cc as $value){
    //         $mail->AddCC($value['email'],$value['name']);
    //     }
    // }
    // if (!$mail->Send()) {
    //     echo "Mailer Error: " . $mail->ErrorInfo . "<br>";
    //     return false;
    // } else {
    //     //echo "Message sent!" . "<br>";
    //     return true;
    // }
    return true;
}
/**
 * 1.SQL的第幾筆到第幾筆列出來
 * 
 * @author Peter Chang
 * 
 * @param boolean|integer $start 第幾筆開始
 * 
 * @param boolean|integer $per 顯示筆數
 * 
 * @return string
 */
function getSQLLimitStartEnd($start,$per){
    if ($start==0 && $per || $start && $per){
        return "LIMIT ".$start.",".$per;
    }
    return "";
}
/**
 * 1.將emain跟name整理成寄信的陣列
 * 
 * @author Peter Chang
 * 
 * @param string $name 寄件姓名
 * 
 * @param string $email 寄件信箱
 * 
 * @return array
 */
function getSendMailRecipientsArray($name,$email){
    $array=array(array("email"=>$email,"name"=>$name));
    return $array;
}
/**
 * 1.此為歸檔檔案上傳檔案的路徑
 * 
 * @author Peter Chang
 * 
 * @param array $document_type_array 此為資料庫document_type的資料
 * 
 * @return string|boolean
 */
function getDocumentTypeFilePath($document_type_array,$parent_link=false){
    $path="../../upload/";
    if($parent_link===true){
        $path="../upload/";
    }
    if($_SESSION["owner_company_id"]==2){
       $path.="QAC";
    }
    if($document_type_array["permission"]=="jobno"){
        $path.="Jobno/";
    }elseif($document_type_array["permission"]=="monthly_bill"){
        $path.="MonthlyBill/";
    }elseif($document_type_array["permission"]=="subpoena_number"){
        $path.="SubpoenaNumber/";
    }elseif($document_type_array["permission"]=="daily_cost"){
        $path.="DailyCost/";
    }else{
        return false;
    }
    return $path;
}
/**
 * 1.此為判斷是否為部門主管
 * 
 * @author Peter Chang
 * 
 * @param integer $staff_id 此為員工id
 * 
 * @param integer $leader_staff_id 此為主管的id 
 * 
 * @return boolean
 */
function getDepartmentLeaderPermissionsReturn($staff_id,$leader_staff_id){
    $staff_array=getStaffListStaffId($staff_id);
    $leader_staff_array=getStaffListStaffId($leader_staff_id);
    if(array_intersect($staff_array["department_ids"],$leader_staff_array["department_ids"])){
        if($leader_staff_array["position_id"]>=3){
            return true;
        }
    }elseif($leader_staff_array["position"]=="總經理"){
        return true;
    }
    return false;
}
?>