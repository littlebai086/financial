<?php
/**
 * 1.資料庫StaffOwnerCompany 新增員工清單及部門基本資訊
 *
 * @author Peter Chang
 *
 * @param integer $staff_id 員工id
 * 
 * @param integer $owner_company_id 權限id
 * 
 * @return array
 */
function sqlInsertStaffOwnerCompany($staff_id,$owner_company_id){
    $sql = "INSERT INTO `staff_owner_company`(`staff_id`,`owner_company_id`) 
    VALUES (".$staff_id.",".$owner_company_id.")";
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffOwnerCompany 刪除員工清單及部門的員工id
 *
 * @author Peter Chang
 * 
 * @param integer $staff_id 員工id
 * 
 * @return array
 */
function sqlDeleteStaffOwnerCompanyStaffOwnerCompanyId($staff_id){
    $sql="DELETE FROM `staff_owner_company`
    WHERE `staff_id`=".$staff_id;
    return sendSQL($sql);
}
?>