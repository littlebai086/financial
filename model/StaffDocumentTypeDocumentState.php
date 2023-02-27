<?php
/**
 * 1.資料庫StaffOwnerCompany 新增員工清單及部門基本資訊
 *
 * @author Peter Chang
 * 
 * @param integer $staff_id 員工id
 * 
 * @param integer $document_type_id 文件類型id
 * 
 * @return array
 */
function sqlSelectStaffDocumentTypeDocumentStateStaffIdDocumentTypeId($staff_id,$document_type_id,$sort){
    $sql = "SELECT *
    FROM `staff_document_type_document_state`
    INNER JOIN `document_type_document_state` ON `staff_document_type_document_state`.`document_type_document_state_id` = `document_type_document_state`.`document_type_document_state_id`
    INNER JOIN `document_state` ON `document_type_document_state`.`document_state_id` = `document_state`.`document_state_id`
    WHERE `staff_document_type_document_state`.`staff_id` = ".$staff_id." AND 
    		`document_type_document_state`.`document_type_id` = ".$document_type_id." AND
    		`document_type_document_state`.`document_state_execution_sort` = ".$sort."
    ORDER BY `document_type_document_state`.`document_state_execution_sort` ASC";
    return sendSQL($sql);
}

/**
 * 1.資料庫DocumentTypeDocumentState 新增員工清單及部門基本資訊
 *
 * @author Peter Chang
 * 
 * @return mysqli_result
 */
function sqlSelectDocumentTypeDocumentStateDocumentStateId(){
    $sql = "SELECT * 
    FROM `document_type_document_state`
    GROUP BY `document_state_id`";
    return sendSQL($sql);
}
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
function sqlInsertStaffDocumentTypeDocumentState($staff_id,$document_type_document_state_id){
    $sql = "INSERT INTO `staff_document_type_document_state`(`staff_id`,`document_type_document_state_id`) 
    VALUES (".$staff_id.",".$document_type_document_state_id.")";
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
function sqlDeleteStaffDocumentTypeDocumentState($staff_id){
    $sql="DELETE FROM `staff_document_type_document_state`
    WHERE `staff_id`=".$staff_id;
    return sendSQL($sql);
}
?>