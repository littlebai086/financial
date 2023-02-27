<?php
/**
 * 1.拿取員工自動創立帳戶密碼
 * 
 * @author Peter Chang
 * 
 * @param integer $id 為員工id
 * 
 * @return array(string,string)
 */
function getAccountPassword($id){
    $row=getStaffListStaffIdAccount($id);
    $array=explode("@",$row['email']);
    $username=$array[0];
    $array=explode("-", $row['birthday']);
    $password=$username.(intval($array[0])-1911).$array[1].$array[2];
    //$password = password_hash($password, PASSWORD_DEFAULT);
    return array($username,$password);
}
/**
 * 1.員工後台員工資訊顯示的表格資料
 * 
 * @author Peter Chang
 * 
 * @param array $search_fields 為使用者搜尋的資訊
 * 
 * @param boolean|integer $start 第幾筆開始
 * 
 * @param boolean|integer $per 顯示筆數
 * 
 * @return string
 */
function getStaffListSearchTable($search_fields,$start,$per){
	$items=array("cname","ename","email","extension","department","position","state");
	$table="";
	$buf=sqlSelectStaffList($search_fields,$start,$per);
	foreach ($buf as $key=>$row){
    $row["department"]=str_replace(";","<br>",$row["department"]);
  	$table.="<tr>";
  	$table.="<td>".($start+$key+1)."</td>";
  		foreach ($items as $item){
    		if($item=="ename"){
                $table.="<td>".ucfirst(strtolower($row["ename"]))." ".ucfirst(strtolower($row['elastname']))."</td>";
    		}elseif($item=="state"){
                $table.="<td>";
                if ($row["staff_state_id"]==1){
                $table.="<input type='button' value='修改' class='btn btn-primary' onclick=\"location.href='./Staff.php?state=update&id=".$row['staff_id']."'\">
                <input type='button' value='變更密碼' class='btn btn-success' onclick=\"location.href='./StaffAccount.php?state=update&id=".$row['staff_id']."'\"> ";
                    if($row["position_id"]!=8){
                $table.="
                <input type='button' value='離職' class='btn btn-danger' onclick=\"location.href='./Staff.php?state=resign&id=".$row['staff_id']."&staff_state_id=2'\">
                <input type='button' value='留職停薪' class='btn btn-danger' onclick=\"location.href='./Staff.php?state=furlough&id=".$row['staff_id']."&staff_state_id=3'\">";
                    }
                }elseif($row["staff_state_id"]==2 or $row["staff_state_id"]==3){
                $table.="<input type='button' value='修改' class='btn btn-primary' onclick=\"location.href='./Staff.php?state=update&id=".$row['staff_id']."'\">
                <input type='button' value='復職' class='btn btn-danger' onclick=\"location.href='./Staff.php?state=reinstatement&id=".$row['staff_id']."&staff_state_id=1'\">";
                }
                $table.="</td>";
            }else{
      		    $table.="<td>".$row[$item]."</td>";
    		}
  		}
  	$table.="</tr>";
	}
	return $table;
}
/**
 * 1.StaffList資料庫使用者搜尋的資訊做SQL判斷
 * 
 * @author Peter Chang
 * 
 * @param string $sql 先前SQL的資料
 * 
 * @param array $search_fields 使用者搜尋的資訊
 * 
 * @return string
 */
function getStaffListSqlSearchWhere($sql,$search_fields){
	if ($search_fields!==false){
        if ($search_fields['cname']){
            $sql.=" and `staff_list`.`cname` like '%".$search_fields['cname']."%' ";
        }
        if ($search_fields['ename']){
            $sql.=" and `staff_list`.`ename` like '%".$search_fields['ename']."%' ";
        }
        if ($search_fields['email']){
            $sql.=" and `staff_list`.`email` like '%".$search_fields['email']."%' ";
        }
        if ($search_fields['extension']){
            $sql.=" and `staff_list`.`extension` like '%".$search_fields['extension']."%' ";
        }
        if ($search_fields['department_id']!="all" AND $search_fields['department_id']){
            $sql.=" and `department`.`department_id` = '".$search_fields['department_id']."' ";
        }
        if ($search_fields['position_id']!="all" AND $search_fields['position_id']){
            $sql.=" and `staff_list`.`position_id` = '".$search_fields['position_id']."' ";
        }
        if ($search_fields['staff_state_id']!="all" AND $search_fields['staff_state_id']){
            $sql.=" and `staff_list`.`staff_state_id` = '".$search_fields['staff_state_id']."' ";
        }
    }
    return $sql;
}
/**
 * 1.StaffList資料庫被移交的客戶的資訊做SQL判斷
 * 
 * @author Peter Chang
 * 
 * @param string $sql 先前SQL的資料
 * 
 * @param array $departments 部門判斷
 * 
 * @param array $position 職位判斷
 * 
 * @return string
 */
function getStaffListDepartmentPositionSqlSearchWhere($sql,$departments,$position){
    if(!empty($departments) || $position){
        $sql.=" AND (";
    }
    if(!empty($departments)){
        foreach($departments as $department){
            $sql.="`department`.`department` like '%".$department."%' OR ";
        }
        $sql=rtrim($sql,"OR ");
    }
    if($position){
        $sql.=" OR `position`.`position` like '%".$position."%'";
    }
    if(!empty($departments) || $position){
        $sql.=")";
    }
    return $sql;
}
?>