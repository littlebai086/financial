<?php
/**
 * 1.資料庫StaffListDepartment 新增員工清單及部門基本資訊
 *
 * @author Peter Chang
 *
 * @param integer $staff_id 員工id
 * 
 * @param integer $department_id 部門id
 * 
 * @return array
 */
function sqlInsertStaffListDepartment($staff_id,$department_id){
    $sql = "INSERT INTO `staff_list_department`(`staff_id`,`department_id`) 
    VALUES (".$staff_id.",".$department_id.")";
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffListDepartment 刪除員工清單及部門的員工id
 *
 * @author Peter Chang
 * 
 * @param integer $staff_id 員工id
 * 
 * @return array
 */
function sqlDeleteStaffListDepartmentStaffId($staff_id){
    $sql="DELETE FROM `staff_list_department`
    WHERE `staff_id`=".$staff_id;
    return sendSQL($sql);
}
?>