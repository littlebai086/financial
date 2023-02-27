<?php 
/**
 * 1.自動讀取text的編碼轉成UTF-8回傳
 *
 * @author Peter Chang
 *
 * @param string  $str  txt的文字資料
 *
 * @return string
 */
function AutoReadTxtEncoding($str) {
  $encode = mb_detect_encoding($str, array("ASCII", "EUC-CN", "BIG-5", "UTF-8"));
    if ($encode == 'UTF-8') {
        return $str;
    }else {
        return mb_convert_encoding($str, 'UTF-8', $encode);
    }
}
/**
 * 1.自動判斷EXCEL檔名的判斷為版本
 *
 * @author Peter Chang
 *
 * @param string  $filename  EXCEL檔名
 *
 * @return integer|boolean
 */
function getExcelVersionNumber($filename){
    if(strtolower(substr($filename,-3))=='xls'){
        return 2005;
    }elseif(strtolower(substr($filename,-4))=='xlsx'){
        return 2007;
    }else{
        return false;
    }
}
/**
 * 1.將EXCEL資料欄位轉換成陣列
 *
 * @author Peter Chang
 *
 * @param string  $filename  EXCEL檔名
 * 
 * @param integer $worksheetpage EXCEL 工作簿頁數
 * 
 * @param boolean $index_dir 讀取PHPEXCEL的物件索引曾數
 *
 * @return array
 */
function getExcelToDataArray($filename,$worksheetpage=0,$index_dir=true){
    $excelversion=getExcelVersionNumber($filename);
    if($index_dir===true){
        $dir="../..";
    }else{
        $dir="..";
    }
    require_once($dir.'/PHPExcel/PHPExcel.php');
    if ($excelversion==2005){
        require_once($dir.'/PHPExcel/PHPExcel/Writer/Excel5.php');
        require_once($dir.'/PHPExcel/PHPExcel/IOFactory.php');
        $reader = PHPExcel_IOFactory::createReader('Excel5');
    }elseif($excelversion==2007){
        require_once($dir.'/PHPExcel/PHPExcel/Writer/Excel2007.php');
        require_once($dir.'/PHPExcel/PHPExcel/IOFactory.php');
        $reader = PHPExcel_IOFactory::createReader('Excel2007');
    }
    //$reader ->setReadDataOnly(true);
    $PHPExcel = $reader->load($filename); // 檔案名稱 需已經上傳到主機上現在的路徑
    $sheet = $PHPExcel->getSheet($worksheetpage); // 獲取最大的列號 
    $sheetData = $PHPExcel->getSheet($worksheetpage)->toArray(null,true,true,false);#最後一個索引改成數字
    return $sheetData;
}
/**
 * 1.將EXCEL資料欄位轉換成陣列
 *
 * @author Peter Chang
 *
 * @param boolean $index_dir 讀取PHPEXCEL的物件索引曾數
 *
 * @return array
 */
function CreateExcel($index_dir=true){
    if($index_dir===true){
        $dir="../..";
    }else{
        $dir="..";
    }
    error_reporting(E_ALL);//開啟錯誤顯示
    require_once($dir.'/PHPExcel/PHPExcel.php');
    require_once($dir.'/PHPExcel/PHPExcel/Writer/Excel2007.php');
    $objPHPExcel = new PHPExcel();
    return $objPHPExcel;
}
/**
 * 1.將EXCEL資料列的英文索引對照
 *
 * @author Peter Chang
 *
 * @return array
 */
function ExcelTableEnglish(){
    return array(
"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
"AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ",
"BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BX","BY","BZ",
"CA","CB","CC","CD","CE","CF","CG","CH","CI","CJ","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT","CU","CV","CW","CX","CY","CZ");
}
/**
 * 1.將EXCEL資料欄位設定寬度
 *
 * @author Peter Chang
 *
 * @param class $objPHPExcel PHPEXCEL之前存取的資料
 * 
 * @param integer $num 為活頁簿第幾頁
 *
 * @return array
 */
function ExcelTableGetColumnDimensionSetWidth($objPHPExcel,$num,$array){
    $engs=ExcelTableEnglish();
    foreach($array as $key=>$width){
        $objPHPExcel->getActiveSheet($num)->getColumnDimension($engs[$key])->setWidth($width);
    }
    return $objPHPExcel;
}
/**
 * 1.將EXCEL資料欄位設定寬度
 *
 * @author Peter Chang
 *
 * @param class $objPHPExcel PHPEXCEL之前存取的資料
 * 
 * @param integer $num 為活頁簿第幾頁
 * 
 * @param integer $i 為欄位第幾列
 * 
 * @param array $array 為欄位的值value
 *
 * @return array
 */
function ExcelTableTitleRow($objPHPExcel,$num,$i,$array){
    $engs=ExcelTableEnglish();
    foreach ($array as $key=>$cellvalue){
        $objPHPExcel->getActiveSheet()->setCellValue($engs[$key].$i,$cellvalue);
    }
    $objPHPExcel->getActiveSheet()->getStyle($engs[0].$i.":".$engs[$key].$i)->getFont()->setBold(true);
    $objPHPExcel = ExcelTableFillColor($objPHPExcel,$engs[0].$i.":".$engs[$key].$i,"A8A8A8");
    return $objPHPExcel;
}
/**
 * 1.將EXCEL資料欄位文字格式設成數字
 *
 * @author Peter Chang
 *
 * @param class $objPHPExcel PHPEXCEL之前存取的資料
 * 
 * @param string $field 為EXCEL欄位
 * 
 * @return array
 */
function ExcelTableNumberFormat($objPHPExcel,$field){
    $objPHPExcel->getActiveSheet()->getStyle($field)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $objPHPExcel->getActiveSheet()->getStyle($field)->getNumberFormat()->setFormatCode('##0.00');
    return $objPHPExcel;
}
/**
 * 1.將EXCEL資料欄位背景顏色
 *
 * @author Peter Chang
 *
 * @param class $objPHPExcel PHPEXCEL之前存取的資料
 * 
 * @param string $field 為EXCEL欄位
 * 
 * @param string $color 為色碼
 * 
 * @param array $num 為EXCEL工作頁的活頁簿第幾頁
 *
 * @return array
 */
function ExcelTableFillColor($objPHPExcel,$field,$color,$num=0){
    $objPHPExcel->getActiveSheet($num)->getStyle($field)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//標題列顏色填滿宣告，一定要有這句才可以接下一句
    $objPHPExcel->getActiveSheet($num)->getStyle($field)->getFill()->getStartColor()->setARGB('FF'.$color); //
    return $objPHPExcel;
}
/**
 * 1.將EXCEL資料欄位合併或框線
 *
 * @author Peter Chang
 *
 * @param class $objPHPExcel PHPEXCEL之前存取的資料
 * 
 * @param string $field 為EXCEL欄位
 * 
 * @param boolean $merge 是否要合併
 * 
 * @param boolean|string $border 是否需要框線
 * 
 * @param boolean|string $border_style 為框線種類
 * 
 * @param integer $num 為工作頁的活頁簿第幾頁
 *
 * @return array
 */
function ExcelTableMergeBorder($objPHPExcel,$field,$merge,$border,$border_style,$num=0){
    $style_array = array();
    if ($merge){
        $objPHPExcel->getActiveSheet($num)->mergeCells($field);
    }
    if ($border){
        if ($border_style=="dotted"){
        $style_array['borders']=array($border => array('style' => PHPExcel_Style_Border::BORDER_DOTTED));//虛線內框線
        }elseif($border_style=="thin"){
           $style_array['borders']=array($border => array('style' => PHPExcel_Style_Border::BORDER_THIN));
        }elseif($border_style=="diagonal_up"){
           $style_array['borders']=array($border => PHPExcel_Style_Borders::DIAGONAL_UP);
        }
        $objPHPExcel->getActiveSheet($num)->getStyle($field)->applyFromArray($style_array);
    }
    return $objPHPExcel;
}
/**
 * 1.將EXCEL資料欄位設定列印格式範圍
 *
 * @author Peter Chang
 *
 * @param class $objPHPExcel PHPEXCEL之前存取的資料
 * 
 * @param integer $num 為工作頁的活頁簿第幾頁
 * 
 * @param integer $left 左邊界
 * 
 * @param integer $top 上邊界
 * 
 * @param integer $right 右邊界
 * 
 * @param boolean|integer $width 寬度
 * 
 * @param boolean|integer $height 高度
 *
 * @return array
 */
function ExcelTableSetPrintFormat($objPHPExcel,$num,$left,$top,$right,$width,$height){
    $objPHPExcel->getActiveSheet($num)->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
    $objPHPExcel->getActiveSheet($num)->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
    $objPHPExcel->getActiveSheet($num)->getPageMargins()->setLeft($left);//左邊界
    $objPHPExcel->getActiveSheet($num)->getPageMargins()->setTop($top);//上邊界
    $objPHPExcel->getActiveSheet($num)->getPageMargins()->setRight($right);//右邊界
    if ($width){
        $objPHPExcel->getActiveSheet($num)->getPageSetup()->setFitToWidth($width);//調整成每頁寬
    }
    if ($height){
        $objPHPExcel->getActiveSheet($num)->getPageSetup()->setFitToHeight($height);//調整成每頁高
    }
    
    return $objPHPExcel;
}
/**
 * 1.將POST單筆資料上傳回傳正確錯誤
 *
 * @author Peter Chang
 *
 * @param string $path 為上傳檔案存放路徑
 * 
 * @param string $postname 為Form表單的file name名稱接收
 * 
 * @param boolean|string $filename 若$filename有資料就設為新黨案名稱，若沒有就原本上傳名稱
 *
 * @return arra(boolean,string)
 */
function getUploadFile($path,$postname,$filename){
    if(!$filename){
        $filename=$_FILES[$postname]["name"];
    }else{
        $extension =strtolower(pathinfo($_FILES[$postname]["name"], PATHINFO_EXTENSION));
        $filename.=".". $extension;
    }
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    if(copy($_FILES[$postname]["tmp_name"],$path.mb_convert_encoding($filename,"BIG-5",'UTF-8'))){
    //if(copy($_FILES[$postname]["tmp_name"],$path.$filename)){
        if(unlink($_FILES[$postname]["tmp_name"])){
            return array(true,$filename);
        }
        return array(false,$filename);
    }
    return array(false,$filename);
}
/**
 * 1.將POST多筆資料指定的key上傳回傳正確錯誤
 *
 * @author Peter Chang
 *
 * @param string $path 為上傳檔案存放路徑
 * 
 * @param string $postname 為Form表單的file name名稱接收
 * 
 * @param integer $key 為POST File 的Key
 * 
 * @param boolean|string $filename 若$filename有資料就設為新黨案名稱，若沒有就原本上傳名稱
 *
 * @return boolean
 */
function getMultipleUploadFile($postname,$path,$key,$filename){
    if(!$filename){$filename=$_FILES[$postname]["name"][$key];}
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    if(copy($_FILES[$postname]["tmp_name"][$key],$path.$filename)){
        if(unlink($_FILES[$postname]["tmp_name"][$key])){
            return true;
        }
    }
    return false;
}
/**
 * 1.將POST多筆資料上傳且限定檔名最多上傳5個
 * 2.$extension_allows為允許上傳的檔案副檔名 
 *
 * @author Peter Chang
 *
 * @param string $postname 為Form表單的file name名稱接收
 * 
 * @param string $path 為上傳檔案存放路徑
 * 
 * @param array|string $attachments 若有資料就是陣列代表先前該筆上傳有幾個檔案
 *
 * @return array(boolean,string,array)
 */
function getMultipleUploadFileAttachmentsNumLimitArray($postname,$path,$attachments){
    $extension_allows=array("pdf","docx","doc","jpg","jpeg","png","gif");
    if(!empty($_FILES[$postname]["name"][0])){
        if(empty($attachments)){
            $file_count=count($_FILES[$postname]["name"]);
        }else{
            $file_count=count($_FILES[$postname]["name"])+count($attachments);
        }
        if($file_count>5){
            return array(false,"檔案上傳檔案最多為5個附檔",$attachments);
        }
        foreach($_FILES[$postname]["name"] as $key=>$value){
            $extension =strtolower(pathinfo($value, PATHINFO_EXTENSION));
            $filename =pathinfo($value, PATHINFO_FILENAME);
            if(in_array($extension,$extension_allows)){
                if(in_array($value,$attachments)){
                    $num=1;
                    $value=$filename." (".strval($num).").".$extension;
                    foreach($attachments as $attachment){
                        if(!in_array($value,$attachments)){
                            break;
                        }
                        $num++;
                        $value=$filename." (".strval($num).").".$extension;
                    }
                }
                if(getMultipleUploadFile($postname,$path,$key,$value)){
                    array_push($attachments,$value);
                    //echo $value;
                }
            }else{
                return array(false,"檔案上傳格式為PDF及圖片相關",$attachments);
            }
        }
        sort($attachments);
        return array(true,"成功上傳",$attachments);
    }
    return array(true,"無上傳檔案",$attachments);
}
/**
 * 1.將POST多筆資料上傳且限定檔名
 * 2.$extension_allows為允許上傳的檔案副檔名 
 *
 * @author Peter Chang
 *
 * @param string $postname 為Form表單的file name名稱接收
 * 
 * @param string $path 為上傳檔案存放路徑
 *
 * @return array(boolean,string,array)
 */
function getMultipleUploadFileAttachmentsArray($postname,$path,$filename=false){
    $attachments=array();
    $extension_allows=array("pdf","docx","doc","jpg","jpeg","png","gif","xlsx","xls");
    if(!empty($_FILES[$postname]["name"][0])){
        foreach($_FILES[$postname]["name"] as $key=>$value){
            if(!empty($value)){
            $extension =strtolower(pathinfo($value, PATHINFO_EXTENSION));
            $filename =pathinfo($value, PATHINFO_FILENAME);
                if(in_array($extension,$extension_allows)){
                    if(getMultipleUploadFile($postname,$path,$key,$value)){
                        array_push($attachments,$value);
                    }
                }else{
                    return array(false,"檔案上傳格式為EXCEL和PDF及圖片相關",$attachments);
                }
            }
        }
        return array(true,"成功上傳",$attachments);
    }
    return array(true,"無上傳檔案",$attachments);
}
/**
 * 1.將CSV檔轉成陣列
 *
 * @author Peter Chang
 *
 * @param string $upload_dir 為檔案讀取路徑
 *
 * @return array
 */
function getCsvToDataArray($upload_dir){
    $openfile = fopen($upload_dir, "r");
    $i=0;
    while (($line = fgetcsv($openfile)) !== FALSE) {
        foreach ($line as $key=>$value){
            $csv_datas[$i][$key]=AutoReadTxtEncoding($value);
        }
        $i++;
    }
    return $csv_datas;
}
/**
 * 1.共用的為將陣列刪除指定的value並且重新索引key
 *
 * @author Peter Chang
 *
 * @param array $array 原陣列內容
 * 
 * @param string $str 指定刪除的value
 *
 * @return array
 */
function getArrayValueDeleteSort($array,$str){
    foreach($array as $key=>$value){
        if($value==$str){
            unset($array[$key]);
        }
    }
    return array_values($array);
}
/**
 * 1.共用的為將陣列刪除指定的key並且重新索引key
 *
 * @author Peter Chang
 *
 * @param array $array 原陣列內容
 * 
 * @param array|string $keys 指定刪除單筆或多筆的key
 *
 * @return array
 */
function getArrayKeyDeleteKeyIndex($array,$keys){
    if(!is_array($keys)){$keys=explode(";",$keys);}
    foreach($keys as $key){
        if(isset($array[$key])){
            unset($array[$key]);
        }
    }
    return array_values($array);
}
/**
 * 1.複製指定的資料夾到另一個路徑
 *
 * @author Peter Chang
 *
 * @param string $src 指定複製的路徑檔案
 * 
 * @param array|string $keys 指定刪除單筆或多筆的key
 *
 * @return array
 */
function CopyDirectory($src,$dst) { 
    $text="";
    $dir = opendir($src); 
    if (!file_exists($dst)) {
        @mkdir($dst, 0777, true);
    }
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                CopyDirectory($src . '/' . $file,$dst . '/' . $file); 
                @rmdir($src . '/' . $file);
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
                unlink($src . '/' . $file);
                $text.= "檔案:".$file."移動成功<br>";
            } 
        } 
    } 
    @rmdir($src);
    $text.= "目錄:".$src."移動成功"."<br>";
    closedir($dir); 
    return $text;
}  
/**
 * 1.刪除指定的資料夾
 *
 * @author Peter Chang
 *
 * @param string $path 指定的路徑
 * 
 * @return array
 */
function DeleteDirectory($path){
    $text="";
    if(!mb_substr($path, -1, 1,"utf-8")=="/"){$path=$path."/";}
    //如果是目錄則繼續
    if(is_dir($path)){
    //掃描一個資料夾內的所有資料夾和檔案並返回陣列
        $p = scandir($path);
        foreach($p as $val){
        //排除目錄中的.和..
            if($val !="." && $val !=".."){
            //如果是目錄則遞迴子目錄，繼續操作
                if(is_dir($path.$val)){
                //子目錄中操作刪除資料夾和檔案
                    DeleteDirectory($path.$val.'/');
                //目錄清空後刪除空資料夾
                @rmdir($path.$val.'/');
                }else{
                //如果是檔案直接刪除
                    unlink($path.$val);
                    $text.= "檔案:".$val."刪除成功<br>";
                }
                $text.= "目錄:".$path."刪除成功"."<br>";
            }
        }
    }
    return $text;
}
/**
 * 1.計算起始及結束日為幾天
 *
 * @author Peter Chang
 *
 * @param string|integer $start 起始日有可能為datetime或是字串
 * 
 * @param string|integer $end 結束日有可能為datetime或字串
 * 
 * @return integer
 */
function getCountDay($start,$end){
    //if (strtotime($start) !== false && strtotime($start)!= -1){
    if (!is_numeric($start)){
        $start=intval(strtotime($start));
    }
    if (!is_numeric($end)){
        $end=intval(strtotime($end));
    }
    return floor(abs(floatval($end-$start)))/ (60 * 60 * 24);
}
/**
 * 1.密碼判斷為8到16位數不能有多餘中文且必須英文數字混合
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return boolean
 */
function PasswordFormat($value){
    if(preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d\@\_]{8,16}$/",$value)){
        return true;
    }
    return false;
}
/**
 * 1.是否為數字判斷
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return boolean
 */
function AllNumberFormat($value){
    if(preg_match("/^[0-9]+$/",$value)){
        return true;
    }
    return false;
}
/**
 * 1.是否為數字判斷然後必須為幾位數
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return boolean
 */
function NumberFormat($num,$value){
    if(preg_match("/^[0-9]{".$num."}$/",$value)){
        return true;
    }
    return false;
}
/**
 * 1.是否為中文判斷
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return boolean
 */
function ChineseFormat($value){
    if(preg_match("/^[\x7f-\xff]+$/",$value)){
        return true;
    }
    return false;
}
/**
 * 1.是否為公司英文判斷
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return boolean
 */
function CompanyEnglishFormat($value){
    if(preg_match("/^[a-zA-Z][a-zA-Z\d\s\.\,\'\"\&\-]+[a-zA-Z\s\.\,\&\-]$/",$value)){
        return true;
    }
    return false;
}
/**
 * 1.是否為英文判斷
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return boolean
 */
function PlaceEnglishFormat($value){
    if(preg_match("/^[a-zA-Z\(\)\ ]+[a-zA-Z\(\)\ ]$/",$value)){
        return true;
    }
    return false;
}
/**
 * 1.是否為英文判斷
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return boolean
 */
function EnglishFormat($value){
    if(preg_match("/^[a-zA-Z]+[a-zA-Z]$/",$value)){
        return true;
    }
    return false;
}
/**
 * 1.是否為台灣手機電話號碼判斷
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return boolean
 */
function LocalCellPhoneFormat($value){
    if(preg_match("/^[0][9][0-9]{8}$/",$value)){
        return true;
    }
    return false;
}
/**
 * 1.是否為台灣住家電話號碼判斷
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return boolean
 */
function LocalTelePhoneFormat($value){
    if(preg_match("/^[(][0-9]{2,3}[)][0-9]{2,4}[-][0-9]{4}$/",$value)){
        return true;
    }
    return false;
}
/**
 * 1.是否為email判斷
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return boolean
 */
function EmailFormat($value){
    if(preg_match("/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/",$value)){
        return true;
    }
    return false;
}
/**
 * 1.將性別英文轉成中文稱謂
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return string
 */
function getGenderChinese($value){
    if ($value=="male"){
        return "先生";
    }elseif($value=="female"){
        return "小姐";
    }
}
/**
 * 1.將Email用@分成前後
 *
 * @author Peter Chang
 *
 * @param string $email 為email
 * 
 * @return array(string,string)
 */
function getEmailEmailAddress($email){
  $array=explode("@",$email);
  $email=$array[0];
  $email_address="@".$array[1];
  return array($email,$email_address);
}
/**
 * 1.將Html Textarea輸入框的跳行改成br
 *
 * @author Peter Chang
 *
 * @param string $value 為輸入的Textarea
 * 
 * @return string
 */
function getTextareaChangeEnterSymbol($value){
    $values=explode("\r\n",$value);
    return implode("<br>",$values);
}
/**
 * 1.將Html br的跳行改成Textarea輸入框
 *
 * @author Peter Chang
 *
 * @param string $value 為輸入的Textarea
 * 
 * @return string
 */
function getEnterSymbolChangeTextarea($value){
    $value=str_replace("<br>","\r\n",$value);
    $value=str_replace("<br />","\r\n",$value);
    return $value;
}
/**
 * 1.第二種方式將Html Textarea輸入框的跳行改成br
 *
 * @author Peter Chang
 *
 * @param string $value 為字串
 * 
 * @return string
 */
function getTextareaChangeEnterSymbolN12br($value){
    return nl2br($value);   
}
/**
 * 1.驗證碼設定
 *
 * @author Peter Chang
 *
 * @param integer $num 驗證碼幾位數
 * 
 * @return string
 */
function GetrandVerificationCode($num){
$id_len = $num;//字串長度
$id = '';
$word = 'abcdefghijkmnpqrstuvwxyz0123456789';//字典檔 你可以將 數字 0 1 及字母 O L 排除
$len = strlen($word);//取得字典檔長度
for($i = 0; $i < $id_len; $i++){ //總共取 幾次
    $id .= $word[rand() % $len];//隨機取得一個字元
}
return $id;//回傳亂數帳號
}
function getMonthNum($date1,$date2){
    $date1=explode("-",$date1);
    $date2=explode("-",$date2);
    return abs($date1[0]-$date2[0])*12+abs($date1[1]-$date2[1]);
}
function getJobnoArray(){
    $array=array(
        array("jobno_head"=>"TE","service"=>"tank_ocean"),
        array("jobno_head"=>"SE","service"=>"ocean"),
        array("jobno_head"=>"SI","service"=>"inocean")
    );
    return $array;
}

function getJobnoHeadReturn($value){
    $array=getJobnoArray();
    foreach($array as $row){
        if($row["jobno_head"]==mb_substr($value,0,2,"utf-8")){
            return true;
        }
    }
    return false;
}
?>