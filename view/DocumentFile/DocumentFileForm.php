  <?php
  $staff_array['ename']=ucfirst(strtolower($staff_array['ename']));
  $staff_array['elastname']=ucfirst(strtolower($staff_array['elastname']));

  ?>
  <form method="post" action="" enctype="multipart/form-data" id="DocumentFileForm">
    <input type="text" id="id"  name="staff_id" value="<?php echo $data_array["staff_id"];?>" hidden>
    <div class="row">
        <div class="col col-lg-4">
        </div>  

        <div class="col col-lg-1 d-flex align-items-center">
          所屬日期
        </div>
        <div class="col col-lg-2 d-flex align-items-center">
          <select id="Year" name="year" class='form-select' <?php echo $disabled;?>>
           <?php echo getYearOptionYearValueYear($data_array['year']);?>
          </select>
          <select id="Month" name="month" class='form-select' <?php echo $disabled;?>>
            <?php echo getMonthOptionMonthValueMonth($data_array['month']);?>
          </select>
        </div>
        <div class="col d-flex align-items-center">
          <?php
            if($data_array["document_type_id"]==1){
              echo "依照JOB所屬月份做選擇，如：JOB為11月，則選2022/11";
            }elseif($data_array["document_type_id"]==2){
              echo "依照傳票月份做選擇，如：傳票號碼為11月，則選2022/11";
            }elseif($data_array["document_type_id"]==3){
              echo "依照月結費用所屬日期做選擇，如：費用所屬為11月，則選2022/11";
            }elseif($data_array["document_type_id"]==4){
              echo "依照該天交易月份做選擇，如：銀行交易為12/13，則選2022/12";
            }
          ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-4">
        </div>	
        <div class="col col-lg-1 d-flex align-items-center">
          <label for="inputUser" class="control-label"><?php echo $user;?></label>
        </div>
        <div class="col col-lg-2 d-flex align-items-center">
   			  <?php echo $staff_array['extension']." ".$staff_array['ename']." ".$staff_array['elastname'];?>
        </div>
    </div>
    <?php
    if($state=="update"){
      echo '
      <div class="row">
        <div class="col col-lg-4">
        </div>  
        <div class="col col-lg-1 d-flex align-items-center">
          <label for="inputUser" class="control-label">'.$now_user.'</label>
        </div>
        <div class="col col-lg-2 d-flex align-items-center">
          '.$now_staff_array['extension'].' '.$now_staff_array['ename'].' '.$now_staff_array['elastname'].'
        </div>
    </div>';
    }
    if($data_array["document_type_id"]==4){
      echo '
      <div class="row">
        <div class="col col-lg-4">
        </div>  
        <div class="col col-1 d-flex align-items-center">
          帳戶選擇          
        </div>
        <div class="col col-auto d-flex align-items-center">
          <select name="bank_trade_id" id="selectBankTradeId" class="form-select" '.$disabled.'>
            '.getBankTradeOptionBankTradeValueBankTradeId($data_array['bank_trade_id']).'
          </select>
        </div>
      </div>';
      echo '
      <div class="row">
        <div class="col col-lg-4">
        </div>  
        <div class="col col-1 d-flex align-items-center">
          幣別      
        </div>
        <div class="col col-auto d-flex align-items-center">
          <select name="currency_id" id="selectCurrencyId" class="form-select" '.$disabled.'>
            '.getCurrencyOptionCurrencyValueCurrencyId($data_array['currency_id']).'
          </select>  
        </div>
      </div>';
      echo '
      <div class="row">
        <div class="col col-lg-4">
        </div>  
        <div class="col col-1 d-flex align-items-center">
         金額    
        </div>
        <div class="col col-auto d-flex align-items-center">
           <input type="text" class="form-control" id="inputPayMoney" name="pay_money" value="'.$data_array['pay_money'].'" required="required"  '.$disabled.'>
        </div>
      </div>';

    }elseif($data_array["document_type_id"]==1){
      echo '
      <div class="row">
        <div class="col col-lg-4">
        </div>  
        <div class="col col-1 d-flex align-items-center">
          DP審核
        </div>
        <div class="col col-auto d-flex align-items-center">
          <select name="dp_check" id="selectDPCheck" class="form-select" '.$disabled.'>
            '.getDPCheckOption($data_array["dp_check"]).'
          </select>
        </div>
      </div>';
    }
    ?>
    
    <div class="row">
        <div class="col col-lg-4">
        </div>	
        <div class="col col-1 d-flex align-items-center">
          <label for='inputDocument' class='control-label'><?php echo $data_array["document_type"];?></label>

        </div>
        <div class="col col-lg-2">
          <input type='text' class='form-control' id='inputDocument' name='document' value="<?php echo $data_array['document'];?>" required="required"  <?php echo $disabled;?>>
        </div>
        <div class="col d-flex align-items-center">
          <?php
            if($data_array["document_type_id"]==1){
              echo "命名為前2碼系統代碼Job No，如:TE2212001";
            }elseif($data_array["document_type_id"]==2){
              $owner_company_id=$_SESSION["owner_company_id"];
              if($owner_company_id==1){
                $english="A";
              }elseif($owner_company_id==2){
                $english="B";
              }
              echo "命名為第1碼為$english+年月日第幾筆，如:$english"."220101001";
            }elseif($data_array["document_type_id"]==3){
              echo "命名為前4碼公司名稱+費用所屬年月，如:費用屬於10月，於11月請款支付，則請打「XXXX0224」";
            }elseif($data_array["document_type_id"]==4){
              echo "命名為年月日，如:20221128";
            }
          ?>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-4">
        </div>  
        <div class="col col-lg-1 d-flex align-items-center">
          <label for='inputFile' class='control-label'>上傳檔案</label>
        </div>
        <div class="col col-lg-2">
          <input type='file' class='form-control' name='file' id='inputFile' required="required">
        </div>
        <div class="col col-lg-1">
        </div>
    </div>

    <div class="row">
      <div class="col col-lg-5">
      </div>	
      <div class="col col-lg-1 d-flex align-items-center">
        <input type="submit" name="emp_edit_send" class="btn btn-success" value="<?php echo $submit;?>">
      </div>
    </div>
  </form>