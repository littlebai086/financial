<?php
/**
 * 1.資料庫DocumentFileList 列出員工資訊及查詢的資料
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
function sqlSelectDocumentFileList($search_fields){
    $sql="SELECT *
    FROM `document_file` 
    INNER JOIN `document_type` ON `document_file`.`document_type_id` = `document_type`.`document_type_id`
    INNER JOIN `staff_list` ON `document_file`.`staff_id` = `staff_list`.`staff_id`
    INNER JOIN `position` ON `staff_list`.`position_id` = `position`.`position_id`
    LEFT JOIN `currency` ON `document_file`.`currency_id` = `currency`.`currency_id`
    WHERE 1 ";
    $sql=getDocumentFileSqlSearchWhere($sql,$search_fields);
    $sql.= " ORDER BY `document_file`.`document` ASC ";
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentFileList 列出員工資訊及查詢的資料
 *
 * @author Peter Chang
 *
 * @param integer $document_file_id 使用者搜尋的資料
 * 
 * @return array
 */
function sqlSelectDocumentFileRecordDocumentFileId($document_file_id){
    $sql="SELECT *
    FROM `document_file_record` 
    INNER JOIN `staff_list` ON `staff_list`.`staff_id` = `document_file_record`.`staff_id`
    LEFT JOIN `document_type_document_state` ON `document_type_document_state`.`document_type_document_state_id` = `document_file_record`.`document_type_document_state_id`
    LEFT JOIN `document_state` ON `document_state`.`document_state_id` = `document_type_document_state`.`document_state_id`
    WHERE `document_file_record`.`document_file_id` = ".$document_file_id ." 
    ORDER BY `document_file_record`.`document_file_record_time` ASC,`document_file_record`.`document_file_record_id` ASC ";
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentFileId 搜尋此Id
 *
 * @author Peter Chang
 *
 * @param integer $id 檔案id
 * 
 * @return array
 */
function sqlSelectDocumentFileDocumentFileId($id){
    $sql="SELECT *
    FROM `document_file` 
    INNER JOIN `document_type` ON `document_type`.`document_type_id` = `document_file`.`document_type_id`
    LEFT JOIN `bank_trade` ON `bank_trade`.`bank_trade_id` = `document_file`.`bank_trade_id`
    WHERE `document_file_id` = ".$id;
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentFile 搜尋是否有此相同檔名
 *
 * @author Peter Chang
 *
 * @param string $document 檔名資料
 * 
 * @return array
 */
function sqlSelectDocumentFileDocument($document){
    $sql="SELECT *
    FROM `document_file` 
    WHERE `document` LIKE '".$document."' ";
    return sendSQL($sql);
}

/**
 * 1.資料庫DocumentFile 搜尋當日的銀行交易上傳資料
 *
 * @author Peter Chang
 *
 * @param string $document 檔名資料
 * 
 * @return array
 */
function sqlSelectDocumentFileDailyCostYearMonthDay($year,$month,$day){
    $sql="SELECT *
    FROM `document_file`
    INNER JOIN `document_type` ON `document_type`.`document_type_id` = `document_file`.`document_type_id`
    LEFT JOIN `bank_trade` ON `bank_trade`.`bank_trade_id` = `document_file`.`bank_trade_id`
    WHERE `year` = ".$year." AND 
    `month` = ".$month." AND 
    `document` LIKE '".$year.$month.$day."%' AND 
    `document_file`.`document_type_id` =4 ";
    return sendSQL($sql);
}
function sqlSelectDocumentFileRecordDocumentFileIdDocumentFileRecordTimeDesc($document_file_id,$document_type_id){
    $sql = "SELECT *
    FROM `document_file_record`
    LEFT JOIN `document_type_document_state` ON `document_type_document_state`.`document_type_document_state_id` = `document_file_record`.`document_type_document_state_id`
    LEFT JOIN `document_state` ON `document_state`.`document_state_id` = `document_type_document_state`.`document_state_id`
    WHERE `document_file_id` = ".$document_file_id."
    ORDER BY `document_file_record`.`document_file_record_time` DESC,`document_file_record`.`document_file_record_id` DESC 
    LIMIT 0,1";
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentFileList 新增歸檔檔案
 *
 * @author Peter Chang
 *
 * @param array $data_array 員工資料
 * 
 * @return array
 */
function sqlInsertDocumentFile($data_array){
    $create_time=date("Y-m-d");
    $last_time=date("Y-m-d H:i:s");
    $data_array["bank_trade_id"]=getDataZeroTransferNullSaveSql($data_array["bank_trade_id"]);
    $data_array["currency_id"]=getDataZeroTransferNullSaveSql($data_array["currency_id"]);
    $data_array["pay_money"]=getDataZeroTransferNullSaveSql($data_array["pay_money"]);
    $data_array["dp_check"]=getDataZeroTransferNullSaveSql($data_array["dp_check"]);
    $sql = "INSERT INTO `document_file`(
    `staff_id`, `year`, `month`,
    `document_type_id`,`bank_trade_id`, 
    `document`,`currency_id`,`pay_money`,
    `file`,`dp_check`,
    `create_time`,`last_time`) 
    VALUES ('".$data_array['staff_id']."','".$data_array['year']."','".$data_array['month']."',
    '".$data_array['document_type_id']."',".$data_array["bank_trade_id"].",
    '".$data_array['document']."',".$data_array["currency_id"].",".$data_array["pay_money"].",
    '".$data_array['file']."',".$data_array['dp_check'].",
    '".$create_time."','".$last_time."')";
    // $sql = "INSERT INTO `document_file`(`staff_id`, `year`, `month`, `document_type_id`, `document`, `file`) 
    // VALUES ('".$data_array['staff_id']."','".$data_array['year']."','".$data_array['month']."','".$data_array['document_type_id']."','".$data_array['document']."','".$data_array['file']."')";
    return sendSQL($sql,true);
}
/**
 * 1.資料庫DocumentFileRecord 新增檔案紀錄
 *
 * @author Peter Chang
 *
 * @param integer $id 文件歸檔id
 * 
 * @param integer $staff_id 員工id
 * 
 * @param string $file 文件檔案名稱
 * 
 * @param string $state 狀態
 * 
 * @param integer|boolean $pass 審核通過或不通過
 * 
 * @return array
 */
function sqlInsertDocumentFileRecord($id,$staff_id,$file,$state,$document_type_document_state_id=false,$pass=false){
    $last_time=date("Y-m-d H:i:s");
    if($pass===false){$pass="NULL";}
    $document_type_document_state_id=getDataZeroTransferNullSaveSql($document_type_document_state_id);

    $sql = "INSERT INTO `document_file_record`(`document_file_id`,`staff_id`, `state`,`document_type_document_state_id`,`pass`, `file`,`document_file_record_time`) 
    VALUES ('".$id."','".$staff_id."','".$state."',".$document_type_document_state_id.",".$pass.",'".$file."','".$last_time."')";
    return sendSQL($sql);
}

/**
 * 1.資料庫DocumentFileList 修改歸檔檔案修改時間
 *
 * @author Peter Chang
 * 
 * @param integer $document_file_id 歸檔檔案資料
 * 
 * @return array
 */
function sqlUpdateDocumentFileNowLastTime($document_file_id,$data_array){
    $sql="UPDATE `document_file` SET `staff_id` = '".$data_array["staff_id"]."',`last_time` = Now(),`file` = '".$data_array["file"]."'
    WHERE `document_file_id`=".$document_file_id;
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentFileList 修改歸檔檔案修改時間
 *
 * @author Peter Chang
 * 
 * @param integer $document_file_id 歸檔檔案資料
 * 
 * @return array
 */
function sqlUpdateDocumentFileTankCheckPass($document_file_id,$staff_id,$pass){
    $sql="UPDATE `document_file` 
    SET `last_time` = Now(),`tank_check` = ".$pass."
    WHERE `document_file_id`=".$document_file_id;
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentFileList 修改歸檔檔案成刪除
 *
 * @author Peter Chang
 * 
 * @param integer $document_file_id 歸檔檔案資料
 * 
 * @return array
 */
function sqlUpdateDocumentFileNotDel($document_file_id){
    $sql="UPDATE `document_file` SET `document_file_del`=1
    WHERE `document_file_id`=".$document_file_id;
    return sendSQL($sql);
}


/**
 * 1.資料庫DocumentFileList 刪除歸檔檔案成
 *
 * @author Peter Chang
 * 
 * @param integer $document_file_id 歸檔檔案資料
 * 
 * @return array
 */
function sqlDeleteDocumentFileId($document_file_id){
    $sql="DELETE FROM `document_file`
    WHERE `document_file_id`=".$document_file_id;
    return sendSQL($sql);
}
?>