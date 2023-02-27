<?php
/**
 * 1.資料庫DocumentTypeDocumentState 文件狀態最高權限為數字最大回傳
 *
 * @author Peter Chang
 *
 * @param integer $document_type_id 文件型態id
 * 
 * @return array
 */
function sqlSelectDocumentTypeDocumentStateMaxSort($document_type_id){
    $sql="SELECT MAX( `document_state_execution_sort` ) AS `max_sort`
	FROM `document_type_document_state`
	WHERE `document_type_id` = ".$document_type_id;
    return sendSQL($sql);
}
/**
 * 1.資料庫DocumentTypeDocumentState 文件狀態找尋例外情形
 *
 * @author Peter Chang
 *
 * @param integer $document_type_id 文件型態id
 * 
 * @return array
 */
function sqlSelectDocumentTypeDocumentStateDcoumentExtraCaseFieldNotNull($document_type_id){
    $sql="SELECT *
	FROM `document_type_document_state`
	WHERE `document_type_id` = ".$document_type_id." AND
	`document_extra_case_field` IS NOT NULL";
    return sendSQL($sql);
}
?>