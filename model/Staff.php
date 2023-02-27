<?php
/**
 * 1.資料庫StaffList 列出員工資訊及查詢的資料
 *
 * @author Peter Chang
 *
 * @param array|boolean $search_fields 使用者搜尋的資料
 * 
 * @param boolean|integer $start 第幾筆開始
 * 
 * @param boolean|integer $per 顯示筆數
 * 
 * @return array
 */
function sqlSelectStaffList($search_fields,$start,$per){
    $limit=getSQLLimitStartEnd($start,$per);
    $sql="
    SELECT *,GROUP_CONCAT(DISTINCT `department`.`department` SEPARATOR ';') AS `department`,
    GROUP_CONCAT(DISTINCT `department`.`department` SEPARATOR ';') AS `department`
    FROM `staff_list` 
    INNER JOIN `staff_list_department` ON `staff_list`.`staff_id` = `staff_list_department`.`staff_id`
    INNER JOIN `department` ON `staff_list_department`.`department_id` = `department`.`department_id`
    INNER JOIN `staff_owner_company` ON `staff_list`.`staff_id` = `staff_owner_company`.`staff_id`
    INNER JOIN `owner_company` ON `staff_owner_company`.`owner_company_id` = `owner_company`.`owner_company_id`
    INNER JOIN `position` ON `staff_list`.`position_id` = `position`.`position_id`
    INNER JOIN `staff_state` ON `staff_list`.`staff_state_id` = `staff_state`.`staff_state_id`
    WHERE 1
    ";
    $sql=getStaffListSqlSearchWhere($sql,$search_fields);
    $sql.= "
    GROUP BY `staff_list`.`staff_id`
    ORDER BY `staff_list`.`extension` ASC ".$limit;
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffList 新增員工基本資訊
 *
 * @author Peter Chang
 *
 * @param array $data_array 員工資料
 * 
 * @return array
 */
function sqlInsertStaffList($data_array){
    $sql = "INSERT INTO `staff_list`(`cname`, `ename`, `elastname`, `gender`, `email`, `extension`, `position_id`, `birthday`,`staff_state_id`) 
    VALUES ('".$data_array['cname']."','".$data_array['ename']."','".$data_array['elastname']."','".$data_array['gender']."',
        '".$data_array['email']."','".$data_array['extension']."',".$data_array['position_id'].",'".$data_array['birthday']."',".$data_array['staff_state_id'].")";
    return sendSQL($sql,true);
}
/**
 * 1.資料庫StaffList 修改員工基本資訊
 *
 * @author Peter Chang
 * 
 * @param array $data_array 員工資料
 * 
 * @return array
 */
function sqlUpdateStaffList($staff_id,$data_array){
    $sql="UPDATE `staff_list` SET `cname`='".$data_array['cname']."',`ename`='".$data_array['ename']."',`elastname`='".$data_array['elastname']."',
    `gender`='".$data_array['gender']."',`email`='".$data_array['email']."',`extension`=".$data_array['extension'].",
    `position_id`=".$data_array['position_id'].",`birthday`='".$data_array['birthday']."',
    `staff_state_id`=".$data_array['staff_state_id']."
    WHERE `staff_id`=".$staff_id;
    return sendSQL($sql);
}
/**
 * 1.資料庫StaffAccountList 修改員工帳戶密碼
 *
 * @author Peter Chang
 *
 * @param integer $staff_id 員工id
 * 
 * @param string $password 員工密碼
 * 
 * @return array
 */
function sqlUpdateStaffAccountListPassword($staff_id,$password){
    $sql = "UPDATE `staff_account_list` SET `password`='".$password."' WHERE `staff_id` =".$staff_id;
    return sendSQL($sql);
}
?>