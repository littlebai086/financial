<?php
function getDocumentFileDocumentFileId($id){
  $buf = sqlSelectDocumentFileDocumentFileId($id);
  if($buf!==false){
    foreach($buf as $row){
      return $row;
    }
  }
  return false;
}
function getQACDocumentFileQACDocumentFileId($id){
  $buf = sqlSelectQACDocumentFileQACDocumentFileId($id);
  if($buf!==false){
    foreach($buf as $row){
      return $row;
    }
  }
  return false;
}
function getDocumentTypeDocumentStateMaxSort($document_type_id){
  $buf = sqlSelectDocumentTypeDocumentStateMaxSort($document_type_id);
  if($buf!==false){
    foreach($buf as $row){
      return $row["max_sort"];
    }
  }
  return false;
}
function getDocumentTypeDocumentStateDocumentExtraCaseFieldNotNull($document_type_id){
  $buf = sqlSelectDocumentTypeDocumentStateDcoumentExtraCaseFieldNotNull($document_type_id);
  $buf_copy=array();
  if($buf!==false){
    foreach($buf as $row){
      $buf_copy[$row["document_state_execution_sort"]]=$row;
    }
    return $buf_copy;
  }
  return false;
}
function getStaffDocumentTypeDocumentStateStaffIdDocumentTypeId($staff_id,$document_type_id,$sort){
  $buf = sqlSelectStaffDocumentTypeDocumentStateStaffIdDocumentTypeId($staff_id,$document_type_id,$sort);
  if($buf!==false){
    foreach($buf as $row){
      return $row;
    }
  }
  return false;
}
function getDocumentFileRecordDocumentFileIdDocumentFileRecordTimeDesc($document_file_id,$document_type_id){
  $buf = sqlSelectDocumentFileRecordDocumentFileIdDocumentFileRecordTimeDesc($document_file_id,$document_type_id);
  if($buf!==false){
    foreach($buf as $row){
      return $row;
    }
  }
  return false;
}

function getDocumentFileDocument($document){
  $buf = sqlSelectDocumentFileDocument($document);
  if($buf!==false){
    foreach($buf as $row){
      return $row;
    }
  }
  return false;
}
function getQACDocumentFileDocument($document){
  $buf = sqlSelectQACDocumentFileDocument($document);
  if($buf!==false){
    foreach($buf as $row){
      return $row;
    }
  }
  return false;
}
function getQACDocumentFileRecordDocumentFileIdDocumentFileRecordTimeDesc($document_file_id,$document_type_id){
  $buf = sqlSelectQACDocumentFileRecordDocumentFileIdDocumentFileRecordTimeDesc($document_file_id,$document_type_id);
  if($buf!==false){
    foreach($buf as $row){
      return $row;
    }
  }
  return false;
}
function getDocumentFileSqlJudgeState($id,$state,$data_array,$pass=false,$record_state=false,$document_type_document_state_id=false,$search_fields=false){
  $staff_id=$_SESSION['staff_id'];
  $owner_company_id=$_SESSION["owner_company_id"];
  if($state=="insert"){
    if($owner_company_id==1){
      return sqlInsertDocumentFile($data_array);
    }elseif($owner_company_id==2){
      return sqlInsertQACDocumentFile($data_array);
    }
  }elseif($state=="update"){
    if($owner_company_id==1){
      return sqlUpdateDocumentFileNowLastTime($id,$data_array);
    }elseif($owner_company_id==2){
      return sqlUpdateQACDocumentFileNowLastTime($id,$data_array);
    }
  }elseif($state=="delete"){
    if($owner_company_id==1){
      return sqlDeleteDocumentFileId($id);
    }elseif($owner_company_id==2){
      return sqlDeleteQACDocumentFileId($id);
    }
  }elseif($state=="tank_check"){
    if($owner_company_id==1){
      return sqlUpdateDocumentFileTankCheckPass($id,$staff_id,$pass);
    }elseif($owner_company_id==2){
      return sqlUpdateQACDocumentFileTankCheckPass($id,$staff_id,$pass);
    }
  }elseif($state=="record"){
    if($owner_company_id==1){
      return sqlInsertDocumentFileRecord($id,$staff_id,$data_array["file"],$record_state,$document_type_document_state_id,$pass);
    }elseif($owner_company_id==2){
      return sqlInsertQACDocumentFileRecord($id,$staff_id,$data_array["file"],$record_state,$document_type_document_state_id,$pass);
    }
  }elseif($state=="document_file_table"){
    if($owner_company_id==1){
      return sqlSelectDocumentFileList($search_fields);
    }elseif($owner_company_id==2){
      return sqlSelectQACDocumentFileList($search_fields);
    }
  }elseif($state=="document_file_record_table"){
    if($owner_company_id==1){
      return sqlSelectDocumentFileRecordDocumentFileId($id);
    }elseif($owner_company_id==2){
      return sqlSelectQACDocumentFileRecordQACDocumentFileId($id);
    }
  }elseif($state=="document_file_record_id_desc"){
    if($owner_company_id==1){
      return getDocumentFileRecordDocumentFileIdDocumentFileRecordTimeDesc($id,$data_array['document_type_id']);
    }elseif($owner_company_id==2){
      return getQACDocumentFileRecordDocumentFileIdDocumentFileRecordTimeDesc($id,$data_array['document_type_id']);
    }
  }elseif($state=="document_file_id"){
    if($owner_company_id==1){
      return getDocumentFileDocumentFileId($id);
    }elseif($owner_company_id==2){
      return getQACDocumentFileQACDocumentFileId($id);
    }
  }elseif($state=="document"){
    if($owner_company_id==1){
      return getDocumentFileDocument($data_array["document"]);
    }elseif($owner_company_id==2){
      return getQACDocumentFileDocument($data_array["document"]);
    }
  }
  return false;
}
function getDocumentFileStaffPriorityReturn($row,$document_file_records,$max_sort=false,$document_extra_buf=false){
  $states=array();
  if($max_sort===false){
    $max_sort=intval(getDocumentTypeDocumentStateMaxSort($row["document_type_id"]));
  }
  if($document_extra_buf===false){
    $document_extra_buf=getDocumentTypeDocumentStateDocumentExtraCaseFieldNotNull($row["document_type_id"]);
  }
  if($document_file_records["document_state_id"]===NULL){
    $sort=1;
  }elseif($document_file_records["pass"]==2){
    if((intval($document_file_records["document_state_execution_sort"])-1)!=0){
      $sort=intval($document_file_records["document_state_execution_sort"])-1;
    }else{
      $sort=1;
    }
  }elseif(intval($document_file_records["document_state_execution_sort"])==$max_sort){
    $sort=intval($document_file_records["document_state_execution_sort"]);
  }else{
    $sort=intval($document_file_records["document_state_execution_sort"])+1;
  }
  if($sort==1 && $row["staff_id"]==$_SESSION["staff_id"]){
    array_push($states,"update");
  }

  if(isset($document_extra_buf[$sort])){
    for ($i=0; $i < count($document_extra_buf); $i++) { 
      if(isset($row[$document_extra_buf[$sort]["document_extra_case_field"]])){
        if($row[$document_extra_buf[$sort]["document_extra_case_field"]]==$document_extra_buf[$sort]["document_extra_case_condition"]){
          break;
        }
        $sort++;
      }else{
        break;
      }
    }
  }
  $array = getStaffDocumentTypeDocumentStateStaffIdDocumentTypeId($_SESSION["staff_id"],$row["document_type_id"],$sort);
  if(isset($array["document_state_id"])){
    if($array["document_state_english"]=="open_case" || $array["document_state_english"]=="close_case"){
      array_push($states,$array["document_state_english"]);
    }elseif($array["document_state_english"]=="dp_check" && $row["dp_check"]==1 && $document_file_records["pass"]!=2){
      array_push($states,$array["document_state_english"]);
    }
  }
  if(getDepartmentLeaderPermissionsReturn($row["staff_id"],$_SESSION['staff_id'])){
    array_push($states,"del");
  }
  return $states;
}
/**
 * 1.文件清單顯示的表格資料
 * 
 * @author Peter Chang
 * 
 * @param array $search_fields 為使用者搜尋的資訊
 * 
 * @return string
 */
function getDocumentFileSearchTable($search_fields){
  $items=array("document","file","staff","document_state");
  if($search_fields["document_type_id"]==1){
    $items=array("document","file","dp_check","staff","document_state");
  }elseif($search_fields["document_type_id"]==4){
    $items=array("document","file","pay_money","staff","document_state");
  }
  $table="";
  $dp_check_array=getDpCheckArray();
  $max_sort=intval(getDocumentTypeDocumentStateMaxSort($search_fields['document_type_id']));
  $document_extra_buf=getDocumentTypeDocumentStateDocumentExtraCaseFieldNotNull($search_fields['document_type_id']);
  $buf = getDocumentFileSqlJudgeState(false,"document_file_table",false,false,false,false,$search_fields);
  foreach ($buf as $key=>$row){
    $document_file_records=getDocumentFileSqlJudgeState($row["document_file_id"],"document_file_record_id_desc",$row);
    $table.="<tr>";
    $table.="<td>".($key+1)."</td>";
      foreach($items as $item){
        if($item=="file"){
          $path=getDocumentTypeFilePath($row);
          $table.="<td><a href='".$path.$row["file"]."?".time()."' id='Trash".$row['document_file_id']."' target='_blank'>".$row["file"]."</a></td>";
        }elseif($item=="staff"){
          $table.="<td>".getQATShowName($row)."</td>";
        }elseif($item=="dp_check"){
          $table.="<td>".$dp_check_array[$row[$item]]["select"]."</td>";
        }elseif($item=="pay_money"){
          if($row["currency_id"]==2){
            $row["pay_money"]=number_format($row["pay_money"]);
          }else{
            $row["pay_money"]=number_format($row["pay_money"], 2, '.', ',');
          }
          $table.="<td>".$row["currency"]." ".$row["pay_money"]."</td>";
        }elseif($item=="document_state"){
          $table.="<td>".getDocumentStateShowReturn($document_file_records)."</td>";
        }else{
          $table.="<td>".$row[$item]."</td>";
        }
      }
      $table.="<td>";
      $table.=getHtmlAHrefRecordIcon("./DocumentFileRecord.php?id=".$row['document_file_id']);
      $states=getDocumentFileStaffPriorityReturn($row,$document_file_records,$max_sort,$document_extra_buf);
      if($states){
        foreach ($states as $state) {
          if($state=="update"){
            $table.=getHtmlAHrefUpdateIcon("./DocumentFile.php?state=update&id=".$row['document_file_id']);
          }elseif($state=="open_case"){
             $table.=getHtmlAHrefOpenCaseIcon("#","PopupCloseWidowClick(\"OpenCase\",\"./DocumentFile.php?state=".$state."&id=".$row['document_file_id']."\",false,\"Trash".$row['document_file_id']."\")");
          }elseif($state=="close_case"){
            $table.=getHtmlAHrefCloseCaseIcon("#","PopupCloseWidowClick(\"CloseCase\",\"./DocumentFile.php?state=".$state."&id=".$row['document_file_id']."\",false,\"Trash".$row['document_file_id']."\")");
          }elseif($state=="dp_check"){
            $table.=getHtmlAHrefRecieveBookingOrderIcon("#","PopupCloseWidowClick(
            \"TankCheck\",
            \"./DocumentFile.php?state=dp_check&pass=1&id=".$row['document_file_id']."\",
            \"./DocumentFile.php?state=dp_check&pass=2&id=".$row['document_file_id']."\",
            \"Trash".$row['document_file_id']."\")");
          }elseif($state=="del"){
            $table.=getHtmlAHrefTrashIcon("#","PopupCloseWidowClick(\"DocumentDel\",\"./DocumentFile.php?state=del&id=".$row['document_file_id']."\",false,\"Trash".$row['document_file_id']."\")");
          }
        }
      }
    $table.="</td></tr>";
  }
  return $table;
}

/**
 * 1.文件清單顯示的表格資料
 * 
 * @author Peter Chang
 * 
 * @param array $document_file_id 為使用者搜尋的資訊
 * 
 * @return string
 */
function getDocumentFileRecordTable($document_file_id){
  
  $items=array("staff","file","state","document_file_record_time");
  $table="";
  $buf = getDocumentFileSqlJudgeState($document_file_id,"document_file_record_table",false,false,false,false);
  foreach ($buf as $key=>$row){
    $table.="<tr>";
    $table.="<td>".($key+1)."</td>";
      foreach($items as $item){
        if($item=="staff"){
            $table.="<td>".$row['extension']." ".ucfirst(strtolower($row['ename']))." ".ucfirst(strtolower($row['elastname']))."</td>";
        }elseif($item=="state"){
          
          $table.="<td>".getDocumentStateShowReturn($row)."</td>";
        }else{
          $table.="<td>".$row[$item]."</td>";
        }
      }
    $table.="</tr>";
  }
  return $table;
}
/**
 * 1.DocumentFile資料庫使用者搜尋列表的資訊做SQL判斷
 * 
 * @author Peter Chang
 * 
 * @param string $sql 先前SQL的資料
 * 
 * @param array $search_fields 使用者搜尋的資訊
 * 
 * @return array|boolean
 */
function getDocumentFileSqlSearchWhere($sql,$search_fields){
  if ($search_fields!==false){
        if ($search_fields['document_type_id']){
            $sql.=" AND `document_file`.`document_type_id` = ".$search_fields['document_type_id'];
            if($search_fields['document_type_id']==4 && $search_fields['bank_trade_id']!="ALL" && $search_fields['bank_trade_id']){
              $sql.=" AND `document_file`.`bank_trade_id` = ".$search_fields['bank_trade_id'];
            }
        }
        if($search_fields['date']){
          $dates=explode("-",$search_fields['date']);
          $sql.=" AND `document_file`.`year` = ".$dates[0]." ";
          $sql.=" AND `document_file`.`month` = ".$dates[1]." ";
        }
        if($search_fields['document']){
          $sql.=" AND `document_file`.`document` LIKE '%".$search_fields['document']."%' ";
        }

    }
    return $sql;
}
/**
 * 1.QACDocumentFile資料庫使用者搜尋列表的資訊做SQL判斷
 * 
 * @author Peter Chang
 * 
 * @param string $sql 先前SQL的資料
 * 
 * @param array $search_fields 使用者搜尋的資訊
 * 
 * @return array|boolean
 */
function getQACDocumentFileSqlSearchWhere($sql,$search_fields){
  if ($search_fields!==false){
        if ($search_fields['document_type_id']){
            $sql.=" AND `qac_document_file`.`document_type_id` = ".$search_fields['document_type_id'];
            if($search_fields['document_type_id']==4 && $search_fields['bank_trade_id']!="ALL" && $search_fields['bank_trade_id']){
              $sql.=" AND `qac_document_file`.`bank_trade_id` = ".$search_fields['bank_trade_id'];
            }
        }
        if($search_fields['date']){
          $dates=explode("-",$search_fields['date']);
          $sql.=" AND `qac_document_file`.`year` = ".$dates[0]." ";
          $sql.=" AND `qac_document_file`.`month` = ".$dates[1]." ";
        }
        if($search_fields['document']){
          $sql.=" AND `qac_document_file`.`document` LIKE '%".$search_fields['document']."%' ";
        }

    }
    return $sql;
}
function getDocumentFileTextFormatReturn($id,$state,$data_array){
  $year=date("Y");
  $month=date("m");
  $owner_company_id=$_SESSION["owner_company_id"];
  $document_strlen=mb_strlen($data_array["document"]);
  if($data_array["permission"]=="jobno"){
    if(mb_strlen($data_array["document"], "utf-8")!=9){
      return array(false,$data_array["document_type"]."總長度應為9碼");
    }
    if(!getJobnoHeadReturn($data_array["document"])){
      return array(false,$data_array["document_type"]."開頭兩碼應為特定英文字母");
    }
    if(mb_substr($data_array["document"],2,2,"utf-8")!=mb_substr($data_array["year"],2,2,"utf-8")){
      return array(false,$data_array["document_type"]."歸屬年錯誤");
    }
    if(mb_substr($data_array["document"],4,2,"utf-8")!=$data_array["month"]){
      return array(false,$data_array["document_type"]."歸屬月錯誤");
    }
    if(!AllNumberFormat(mb_substr($data_array["document"],2,$document_strlen,"utf-8"))){
    //if(!AllNumberFormat(mb_substr($data_array["document"],2,NULL,"utf-8"))){
      return array(false,$data_array["document_type"]."編號應為英文數字");
    }
  }elseif($data_array["permission"]=="subpoena_number"){
    if(mb_strlen($data_array["document"], "utf-8")!=10){
      return array(false,$data_array["document_type"]."總長度應為10碼");
    }
    if($owner_company_id==1 && mb_substr($data_array["document"],0,1,"utf-8")!="A" ){
      return array(false,$data_array["document_type"]."開頭1碼應為英文字母A");
    }elseif($owner_company_id==2 && mb_substr($data_array["document"],0,1,"utf-8")!="B" ){
      return array(false,$data_array["document_type"]."開頭1碼應為英文字母B");
    }
    if(mb_substr($data_array["document"],1,2,"utf-8")!=mb_substr($data_array["year"],2,2,"utf-8")){
      return array(false,$data_array["document_type"]."歸屬年錯誤");
    }
    if(mb_substr($data_array["document"],3,2,"utf-8")!=$data_array["month"]){
      return array(false,$data_array["document_type"]."歸屬月錯誤");
    }
    if(!AllNumberFormat(mb_substr($data_array["document"],1,$document_strlen,"utf-8"))){
    //if(!AllNumberFormat(mb_substr($data_array["document"],1,NULL,"utf-8"))){
      return array(false,$data_array["document_type"]."編號應為數字");
    }
  }elseif($data_array["permission"]=="monthly_bill"){
    if(mb_strlen($data_array["document"], "utf-8")!=10){
      return array(false,$data_array["document_type"]."總長度應為10碼");
    }
    if(!ChineseFormat(mb_substr($data_array["document"],0,4,"utf-8"))){
      return array(false,$data_array["document_type"]."開頭4碼應為中文");
    }
    if(mb_substr($data_array["document"],4,$document_strlen,"utf-8")!=($data_array["year"].$data_array["month"])){
      return array(false,$data_array["document_type"]."後面6碼編碼應為歸檔年月");
    }
  }elseif($data_array["permission"]=="daily_cost"){
    if(mb_strlen($data_array["document"], "utf-8")!=8){
      return array(false,$data_array["document_type"]."總長度應為8碼");
    }

    if(mb_substr($data_array["document"],0,6,"utf-8")!=($data_array["year"].$data_array["month"])){
      return array(false,$data_array["document_type"]."前面6碼編碼應為歸檔年月");
    }
    if(!AllNumberFormat($data_array["document"])){
      //echo PopupStaticWidowHref($title,$data_array["document_type"]."編號應為年月日",false,true,false);
      return array(false,$data_array["document_type"]."編號應為年月日");
    }
  }else{
    return array(false,"皆無此以上判斷");
  }

  if(getDocumentFileSqlJudgeState($id,"document",$data_array)){
    if($state=="upload"){
      return array(false,"已有此文件名稱");
    }elseif($state=="update" && $data_array["document_file_id"]!==$id){
      return array(false,"已有此文件名稱");
    }
  }
  return array(true,"以上格式皆正確");

  
}
?>