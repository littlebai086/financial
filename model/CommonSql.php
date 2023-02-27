<?php
/**
 * 1.sendSQL為全部SQL共用資料的部分，將SQL資料轉成陣列於PHP5以下必須為這樣
 * 2.getSQLLink為正式使用的資料庫帳密
 * 3.getSQLLink_test為內網放在主機上的測試使用
 * 
 * @author Peter Chang
 *
 * @param string $sql 為$sql語法
 * 
 * @param boolean $insert_id 是否需要新增的id號碼
 * 
 * @return array
 */
function sendSQL($sql,$insert_id=false)
{
    set_time_limit(0);
    require_once('sqlLink.php');
    //$db = getSQLLink();
    $db = getSQLLink_test();
    //$buf_array=array();
    $buf = mysqli_query($db, $sql);
    // if ($buf !==true and $buf !==false){
    //     $buf_array=array();
    //     while ($row=mysqli_fetch_array($buf,MYSQLI_ASSOC)){
    //         array_push($buf_array,$row);
    //     }
    //     $buf=$buf_array;
    // }
    $id=mysqli_insert_id($db);
    mysqli_close($db);
    if ($insert_id){
        return $id;
    }
    return $buf;
}
/**
 * 1.資料庫OwnerCompany 搜尋自己公司的資料
 *
 * @author Peter Chang
 * 
 * @return array
 */
function sqlSelectOwnerCompanyId(){
    $sql = "SELECT * 
    FROM `owner_company`";
    return sendSQL($sql);
}
/**
 * 1.資料庫staff_owner_company 搜尋公司及員工id的資料
 *
 * @author Peter Chang
 * 
 * @param string $staff_id 員工id
 * 
 * @return array
 */
function sqlSelectStaffOwnerCompanyStaffId($staff_id){
    $sql = "SELECT * 
    FROM `staff_owner_company`
    WHERE `staff_id` = ".$staff_id;
    return sendSQL($sql);
}
/**
 * 1.資料庫OwnerCompany 搜尋公司的資料
 *
 * @author Peter Chang
 * 
 * @param integer $id 公司資料id
 * 
 * @return array
 */
function sqlSelectOwnerCompanyStaffId($id){
    $sql = "SELECT * 
    FROM `owner_company`
    WHERE `owner_company_id` = ".$id;
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffList 搜尋員工id個人資料
 *
 * @author Peter Chang
 *
 * @param integer $id 資料庫StaffList的id資料
 * 
 * @return array
 */
function sqlSelectStaffListId($id){
    $sql = "SELECT * 
    FROM `staff_list`
    INNER JOIN `position` ON `position`.`position_id` = `staff_list`.`position_id`
    WHERE `staff_id` = ".$id;
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffList 查詢單個員工個人資料用於做出帳密
 *
 * @author Peter Chang
 *
 * @param integer $id 員工id
 * 
 * @return array
 */
function sqlSelectStaffListStaffIdAccount($id){
    $sql="
    SELECT *
    FROM `staff_list`
    WHERE `staff_list`.`staff_id`=".$id;
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffList 查詢單個員工個人資料將部門及職位一起顯示
 *
 * @author Peter Chang
 *
 * @param integer $id 員工id
 * 
 * @return array
 */
function sqlSelectStaffListStaffId($id){
    $sql="
    SELECT *,
    GROUP_CONCAT(DISTINCT `department`.`department` SEPARATOR ';') AS `department`,
    GROUP_CONCAT(DISTINCT `department`.`department_id` SEPARATOR ';') AS `department_id`,
    GROUP_CONCAT(DISTINCT `owner_company`.`company_chinese` SEPARATOR ';') AS `company_chinese`,
    GROUP_CONCAT(DISTINCT `owner_company`.`owner_company_id` SEPARATOR ';') AS `owner_company_id`,
    GROUP_CONCAT(DISTINCT `staff_document_type_document_state`.`document_type_document_state_id` SEPARATOR ';') AS `document_type_document_state_id`
    FROM `staff_list`
    INNER JOIN `staff_list_department` ON `staff_list`.`staff_id` = `staff_list_department`.`staff_id`
    INNER JOIN `department` ON `staff_list_department`.`department_id` = `department`.`department_id`
    INNER JOIN `staff_owner_company` ON `staff_list`.`staff_id` = `staff_owner_company`.`staff_id`
    INNER JOIN `owner_company` ON `staff_owner_company`.`owner_company_id` = `owner_company`.`owner_company_id`
    INNER JOIN `position` ON `staff_list`.`position_id` = `position`.`position_id`
    LEFT JOIN `staff_document_type_document_state` ON `staff_list`.`staff_id` = `staff_document_type_document_state`.`staff_id`
    WHERE `staff_list`.`staff_id`=".$id."
    GROUP BY `staff_list`.`staff_id`";
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffList 查詢單個員工個人資料將部門及職位一起顯示
 *
 * @author Peter Chang
 *
 * @param string $department 部門
 *
 * @param string $position 職位
 * 
 * @return array
 */
function sqlSelectStaffListDepartmentPositionId($department,$position="主管"){
    if($position=="職員"){
        $position_id=1;
    }else{
        $position_id=3;
    }
    $sql="SELECT * FROM `staff_list`
    INNER JOIN `staff_list_department` ON `staff_list`.`staff_id` = `staff_list_department`.`staff_id`
    INNER JOIN `department` ON `staff_list_department`.`department_id` = `department`.`department_id`
    INNER JOIN `position` ON `staff_list`.`position_id` = `position`.`position_id`
    WHERE `staff_list`.`staff_state_id` = 1
    `department`.`department` LIKE '".$department."%' AND 
    `staff_list`.`position_id` >= ".$position_id;
    return sendSQL($sql);
}

/**
 * 1.資料庫StaffList 查詢Tank營業部的審核Tank人員列出
 *
 * @author Peter Chang
 * 
 * @return array
 */
function sqlSelectStaffListTankDepartmentCheck(){
    $sql="SELECT * FROM `staff_list`
    INNER JOIN `staff_list_department` ON `staff_list`.`staff_id` = `staff_list_department`.`staff_id`
    INNER JOIN `department` ON `staff_list_department`.`department_id` = `department`.`department_id`
    INNER JOIN `position` ON `staff_list`.`position_id` = `position`.`position_id`
    WHERE (`staff_list`.`email` LIKE 'sharon%' OR `staff_list`.`email` LIKE 'peter%') AND 
    `staff_list`.`staff_state_id` = 1";
    return sendSQL($sql);
}

/**
 * 1.資料庫StaffList 查詢財務部主管及員工id一起顯示
 *
 * @author Peter Chang
 * 
 * @return array
 */
function sqlSelectStaffListFinancialDepartmentStaffId(){
    $sql="SELECT * FROM `staff_list`
    INNER JOIN `staff_list_department` ON `staff_list`.`staff_id` = `staff_list_department`.`staff_id`
    INNER JOIN `department` ON `staff_list_department`.`department_id` = `department`.`department_id`
    INNER JOIN `position` ON `staff_list`.`position_id` = `position`.`position_id`
    WHERE (`department`.`department` LIKE '財務部%' AND 
    `staff_list`.`position_id` >= 3) OR 
    `staff_list`.`staff_id` = 19";
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffAccountList 員工帳戶資訊查詢員工帳號
 *
 * @author Peter Chang
 *
 * @param string $username 為員工帳號
 * 
 * @return array
 */
function sqlSelectStaffAccountListUsername($username){
    $sql = "SELECT * FROM `staff_account_list` WHERE `username`='".$username."'";
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffAccountList 員工帳戶資訊查詢員工id
 *
 * @author Peter Chang
 *
 * @param integer $staff_id 為員工id
 * 
 * @return array
 */
function sqlSelectStaffAccountListStaffId($staff_id){
    $sql = "SELECT * FROM `staff_account_list` WHERE `staff_id`=".$staff_id;
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentTypeOwnerCompany 文件上傳對公司的權限
 *
 * @author Peter Chang
 *
 * @param integer $id 公司資料id
 * 
 * @return array
 */
function sqlSelectDocumentTypeOwnerCompanyOwnerCompanyId($id){
    $sql = "SELECT * , GROUP_CONCAT( DISTINCT `document_type_department`.`department_id`
SEPARATOR ';' ) AS `department_id`
FROM `document_type_owner_company`
INNER JOIN `document_type` ON `document_type_owner_company`.`document_type_id` = `document_type`.`document_type_id`
INNER JOIN `owner_company` ON `document_type_owner_company`.`owner_company_id` = `owner_company`.`owner_company_id`
INNER JOIN `document_type_department` ON `document_type`.`document_type_id` = `document_type_department`.`document_type_id`
WHERE `document_type_owner_company`.`owner_company_id` = ".$id."
GROUP BY `document_type`.`document_type_id`";
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentTypePermission 文件上傳類型
 *
 * @author Peter Chang
 * 
 * @return array
 */
function sqlSelectDocumentTypeOwnerCompanyDocumentType(){
    $sql = "SELECT * 
    FROM `document_type_owner_company`
    INNER JOIN `document_type` ON `document_type_owner_company`.`document_type_id` = `document_type`.`document_type_id`
    WHERE `document_type_owner_company`.`owner_company_id` = ".$_SESSION["owner_company_id"]."
    ORDER BY `document_type`.`document_type_id` ASC";
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffList 列出員工資訊及查詢的資料
 *
 * @author Peter Chang
 * 
 * @return array
 */
function sqlSelectDocumentTypeDepartmentOwnerCompany(){
$sql = "SELECT * , GROUP_CONCAT( DISTINCT `department`.`department_id`
SEPARATOR ';' ) AS `department_id`
FROM `document_type`
INNER JOIN `document_type_department` ON `document_type_department`.`document_type_id` = `document_type`.`document_type_id`
INNER JOIN `department` ON `document_type_department`.`department_id` = `department`.`department_id`
INNER JOIN `document_type_owner_company` ON `document_type_owner_company`.`document_type_id` = `document_type`.`document_type_id`
WHERE `document_type_owner_company`.`owner_company_id` = ".$_SESSION["owner_company_id"]."
GROUP BY `document_type`.`document_type_id`
ORDER BY `document_type`.`document_type_id` ASC";
return sendSQL($sql);
}
/**
 * 1.資料庫DocumentType 文件上傳id
 *
 * @author Peter Chang
 * 
 * @param string $value 為id
 * 
 * @return array
 */
function sqlSelectDocumentTypeId($value){
    $sql = "SELECT *, GROUP_CONCAT( DISTINCT `department`.`department_id`
SEPARATOR ';' ) AS `department_id`
FROM `document_type`
INNER JOIN `document_type_department` ON `document_type_department`.`document_type_id` = `document_type`.`document_type_id`
INNER JOIN `department` ON `document_type_department`.`department_id` = `department`.`department_id` 
WHERE `document_type`.`document_type_id` = ".$value."
GROUP BY `document_type`.`document_type_id`";
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentTypePermission 文件上傳類型
 *
 * @author Peter Chang
 * 
 * @param string $value 為權限名稱
 * 
 * @return array
 */
function sqlSelectDocumentTypePermission($value){
    $sql = "SELECT * FROM `document_type` WHERE `permission` LIKE '".$value."'";
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentState 文件狀態
 *
 * @author Peter Chang
 * 
 * @return array
 */
function sqlSelectDocumentState(){
    $sql = "SELECT *
    FROM `document_state` ";
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentState 文件狀態
 *
 * @author Peter Chang
 * 
 * @param integer $document_state_english 為文件狀態英文
 * 
 * @return array
 */
function sqlSelectDocumentStateDocumentStateEnglish($document_state_english){
    $sql = "SELECT *
    FROM `document_state` 
    INNER JOIN `document_type_document_state` ON `document_type_document_state`.`document_state_id` = `document_state`.`document_state_id`
    WHERE `document_state_english` LIKE '".$document_state_english."'";
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentTypeDocumentState 文件類型狀態
 *
 * @author Peter Chang
 * 
 * @return mysqli_result
 */
function sqlSelectDocumentTypeDocumentState(){
    $sql = "SELECT *
    FROM `document_type_document_state`
    INNER JOIN `document_type` ON `document_type_document_state`.`document_type_id` = `document_type`.`document_type_id`
    INNER JOIN `document_state` ON `document_type_document_state`.`document_state_id` = `document_state`.`document_state_id`
    ORDER BY `document_type`.`document_type_id`,`document_state`.`document_state_id`
    ";
    return sendSQL($sql);
}
/**
 * 1.資料庫BankTrade 銀行交易帳戶
 *
 * @author Peter Chang
 * 
 * @return array
 */
function sqlSelectBankTrade(){
    $sql = "SELECT * FROM `bank_trade` ORDER BY `bank_trade` ASC";
    return sendSQL($sql);
}
/**
 * 1.資料庫Currency 幣別
 *
 * @author Peter Chang
 * 
 * @return array
 */
function sqlSelectCurrency(){
    $sql = "SELECT * FROM `currency`";
    return sendSQL($sql);
}
/**
 * 1.資料庫BankTrade 銀行交易帳戶
 *
 * @author Peter Chang
 * 
 * @param integer $id 洋宏帳戶交易id
 * 
 * @return array
 */
function sqlSelectBankTradeId($id){
    $sql = "SELECT * FROM `bank_trade` WHERE `bank_trade_id` = ".$id;
    return sendSQL($sql);
}
function sqlSelectDepartmentManyDepartmentId($departments){
    $buf="";
    foreach($departments as $department_id){
        $buf.=" `department_id` = ".$department_id." OR";
    }
    $buf=mb_substr($buf,0,-2,"utf-8");
    $sql = "SELECT * FROM `department` WHERE ".$buf;
    return sendSQL($sql);
}

/**
 * 1.資料庫Department 查詢部門所有資料
 *
 * @author Peter Chang
 *
 * @return array
 */
function sqlSelectDepartment(){
    $sql="SELECT * FROM `department` ORDER BY `department_id` ASC";
    return sendSQL($sql);
}
/**
 * 1.資料庫Department 查詢部門所有資料
 *
 * @author Peter Chang
 *
 * @return array
 */
function sqlSelectOwnerCompany(){
    $sql="SELECT * FROM `owner_company` ORDER BY `owner_company_id` ASC";
    return sendSQL($sql);
}
/**
 * 1.資料庫Department 查詢部門名稱相關文字
 *
 * @author Peter Chang
 *
 * @param string $value 部門名稱
 * 
 * @return array
 */
function sqlSelectDepartmentDepartment($value){
    $sql="SELECT * FROM `department` WHERE `department` LIKE '".$value."'";
    return sendSQL($sql);
}
/**
 * 1.資料庫Position 查詢職位所有資料
 *
 * @author Peter Chang
 * 
 * @return array
 */
function sqlSelectPosition(){
    $sql="SELECT * FROM `position` ORDER BY `position_id` ASC";
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffState 查詢員工狀態
 *
 * @author Peter Chang
 *
 * @return array
 */
function sqlSelectStaffState(){
    $sql="SELECT * FROM `staff_state` ORDER BY `staff_state_id` ASC";
    return sendSQL($sql);
}

/**
 * 1.資料庫StaffAccountList 新增員工帳戶
 *
 * @author Peter Chang
 *
 * @param integer $id 員工id
 * 
 * @param string $username 員工帳號
 * 
 * @param string $password 員工密碼
 * 
 * @return array
 */
function sqlInsertStaffAccountList($id,$username,$password){
    $sql = "INSERT INTO `staff_account_list`(`staff_id`,`username`, `password`)
    VALUES('".$id."','".$username."','".$password."')";
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffList 員工資訊查詢該員工修改員工狀態
 *
 * @author Peter Chang
 *
 * @param integer $staff_id 員工id
 * 
 * @param integer $staff_state_id 員工狀態id
 * 
 * @return array
 */
function sqlUpdateStaffListStaffStateId($staff_id,$staff_state_id){
    $sql="UPDATE `staff_list` SET `staff_state_id`=".$staff_state_id."
    WHERE `staff_id` =".$staff_id;
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffAccountList 若員工為離職或留職停薪則刪除該帳戶
 *
 * @author Peter Chang
 *
 * @param integer $id 員工id
 * 
 * @return array
 */
function sqlDeleteStaffAccountListStaffId($id){
    $sql = "DELETE FROM `staff_account_list` WHERE `staff_id` =".$id;
    return sendSQL($sql);
}
?>