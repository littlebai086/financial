function movepage(num)
{
  console.log(num);
  $('#page').val(num);
  $("form").submit();
}

function FileListItems (files) {
  var b = new ClipboardEvent("").clipboardData || new DataTransfer()
  for (var i = 0, len = files.length; i<len; i++) b.items.add(files[i])
  return b.files
}

//取得副檔名
function getFileExtension1(filename) {
  return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
}
//取得檔名
function getFileName(val) {
  filename = val.split('\\').pop().split('/').pop();
    filename = filename.substring(0, filename.lastIndexOf('.'));
  return filename;
}

function getDelUploadFileIcon(){
  return "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-file-earmark-excel-fill' viewBox='0 0 16 16'>  <path d='M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM5.884 6.68 8 9.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 10l2.233 2.68a.5.5 0 0 1-.768.64L8 10.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 10 5.116 7.32a.5.5 0 1 1 .768-.64z'/></svg>";
}

function PopupWidowClick($id){
  $( "#popupwidow"+$id ).click();
}

 function PopupCloseWidowClick(num,href,close_href=false,href_id=false){
  $("#popupclosewidowId"+num).attr("onclick","location.href='"+href+"'");
  $("#popupclosewidow"+num).click();
  if(close_href!==false){
    $("#popupclosewidowcloseId"+num).attr("onclick","location.href='"+close_href+"'");
  }
  if(href_id!==false){
    $("#PopupCloseShowText"+num).html($('#'+href_id).html());
  }
}

function AjaxQuoteRoutePriceDestinationPortCutOffPlaceId(){
  $.ajax({
    type: 'POST',
    url: '../../Action/QuotePriceAction.php',
    data: {
      action: 'ocean_cut_off_place_price',
      shipment_type: $("#ShipmentType").val(),
      destination_port_id: $("#DestinationPort").val(),
      cut_off_place_id: $("#CutOffPlaceId").val(),
      dataType: "json" 
    },
    success:function(item){
      item=JSON.parse(item);
      $("#PriceInformation").html(item);
    },
    cache:false,
    ifModified :true,
    async:false,
    error:function(item){
      result=false;
    }
  })
}

function AjaxOceanQuoteLocalCharge(){
  $.ajax({
    type: 'POST',
    url: '../../Action/QuotePriceAction.php',
    data: {
      action: 'ocean_local_charge',
      shipment_type: $("#ShipmentType").val(),
      destination_port_id: $("#DestinationPort").val(),
      dataType: "json" 
    },
    success:function(item){
      item=JSON.parse(item);
      $("#LocalChargeInformation").html(item);
    },
    cache:false,
    ifModified :true,
    async:false,
    error:function(item){
      result=false;
    }
  })
}

$(document).ready(function(){
  $('#selectpage').change(function(){
    $('#page').val($('#selectpage').val());
    $("form").submit();
  })

  $('#QuoteRoute').change(function(){
    if($("#ShipmentType").val()!=undefined){
      if($("#ShipmentType").val()=="CY"){
        var action="destinationcountry";
      }else if($("#ShipmentType").val()=="CFS"){
        var action="cfsdestinationcountry";
      }
    }
    $.ajax({
      type: 'POST',
      url: '../../Action/QuotePriceAction.php',
      data: {
        action: action,
        ocean_export_id: $("#QuoteRoute").val(),
        dataType: "json" 
      },
      success:function(item){
        $("#DestinationCountry").empty();
        $("#DestinationPort").empty();
        arrays=JSON.parse(item);
        $('#DestinationCountry').append("<option>請選擇國家</option>");
        $.each(arrays, function (key,array) {
          $.each(array, function (key2,value) {
            $('#DestinationCountry').append("<option value="+key2+">"+value+"</option>");
          });
        });
      },
      cache:false,
      ifModified :true,
      async:false,
      error:function(item){
        result=false;
      }
    })
  })

  $('#DestinationCountryAll').change(function(){
    $.ajax({
      type: 'GET',
      url: '../../Action/CommonAction.php',
      data: {
        action: 'destinationport',
        val: $("#DestinationCountryAll").val(),
        dataType: "json" 
      },
      success:function(item){
        $("#DestinationPort").empty();
        arrays=JSON.parse(item);
        $('#DestinationPort').append("<option value=all>ALL</option>");
        $.each(arrays, function (key,array) {
          $.each(array, function (key2,value) {
            $('#DestinationPort').append("<option value="+key2+">"+value+"</option>");
          });
        });
      },
      cache:false,
      ifModified :true,
      async:false,
      error:function(item){
        result=false;
      }
    })
  })

  $('#DestinationCountrySelectDestination').change(function(){
    $.ajax({
      type: 'GET',
      url: '../../Action/CommonAction.php',
      data: {
        action: 'destination',
        shipment_type: $("#ShipmentType").val(),
        val: $("#DestinationCountrySelectDestination").val(),
        dataType: "json" 
      },
      success:function(item){
        $("#Destination").empty();
        arrays=JSON.parse(item);
        $.each(arrays, function (key,array) {
          $.each(array, function (key2,value) {
            $('#Destination').append("<option value="+key2+">"+value+"</option>");
          });
        });
      },
      cache:false,
      ifModified :true,
      async:false,
      error:function(item){
        result=false;
      }
    })
  })

  // $('#DestinationCountrySelectDestinationAll').change(function(){
  //   $.ajax({
  //     type: 'GET',
  //     url: '../../Action/CommonAction.php',
  //     data: {
  //       action: 'destination',
  //       val: $("#DestinationCountrySelectDestinationAll").val(),
  //       dataType: "json" 
  //     },
  //     success:function(item){
  //       $("#Destination").empty();
  //       arrays=JSON.parse(item);
  //       $('#Destination').append("<option value=all>ALL</option>");
  //       $.each(arrays, function (key,array) {
  //         $.each(array, function (key2,value) {
  //           $('#Destination').append("<option value="+key2+">"+value+"</option>");
  //         });
  //       });
  //     },
  //     cache:false,
  //     ifModified :true,
  //     async:false,
  //     error:function(item){
  //       result=false;
  //     }
  //   })
  // })
  $('#DestinationCountryDestinationAll').change(function(){
    var action="alldestination";
    var select_id=$("#Destination");
    $.ajax({
      type: 'GET',
      url: '../../Action/CommonAction.php',
      data: {
        action: action,
        val: $("#DestinationCountryDestinationAll").val(),
        dataType: "json" 
      },
      success:function(item){
        select_id.empty();
        arrays=JSON.parse(item);
        select_id.append("<option value=all>ALL</option>");
        $.each(arrays, function (key,array) {
          $.each(array, function (key2,value) {
            select_id.append("<option value="+key2+">"+value+"</option>");
          });
        });
      },
      cache:false,
      ifModified :true,
      async:false,
      error:function(item){
        result=false;
      }
    })
  })
  $('#DestinationCountry').change(function(){
    var action="alldestination";
    var select_id=$("#Destination");
    if($("#ShipmentType").val()!=undefined){
      var select_id=$("#DestinationPort");
      if($("#ShipmentType").val()=="CY"){
        var action="destinationport";
      }else if($("#ShipmentType").val()=="CFS"){
        var action="cfsdestinationport";
      }
    }
    $.ajax({
      type: 'GET',
      url: '../../Action/CommonAction.php',
      data: {
        action: action,
        val: $("#DestinationCountry").val(),
        dataType: "json" 
      },
      success:function(item){
        select_id.empty();
        arrays=JSON.parse(item);
        $.each(arrays, function (key,array) {
          $.each(array, function (key2,value) {
            select_id.append("<option value="+key2+">"+value+"</option>");
          });
        });
      },
      cache:false,
      ifModified :true,
      async:false,
      error:function(item){
        result=false;
      }
    })
  })

});

function format_true_img(){
  return "<img src='../../images/true.png'>";
}

function username_format(){
  if(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($('#inputUsername').val())){
    $('#username_message').html(format_true_img());
    return true;
  }else{
    $('#username_message').html("<p class='text-danger'>帳號E-MAIL格式錯誤</p>");
    return false;
  }
}

function password_format(true_img=true){
  if($('#inputPassword').val().length>=8 && $('#inputPassword').val().length<=16){

    if (/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d/@_]{8,16}$/.test($('#inputPassword').val())){
      if(true_img){
        $('#password_message').html(format_true_img());
      }else{
        $('#password_message').html("");
      }
      return confirm_password_format(true_img);
    }else{
      $('#password_message').html("<p class='text-danger'>密碼內沒有英文數字混合</p>");
      $('#confirm_password_message').html("");
      return false;
    }
  }else{
    $('#password_message').html("<p class='text-danger'>密碼少於8位數或是多餘16位數</p>");
    $('#confirm_password_message').html("");
    return false;
  }
}

function confirm_password_format(true_img=true){
  if($('#inputPassword').val()== $('#inputConfirmPassword').val()){
    if(true_img){
      $('#confirm_password_message').html(format_true_img());
    }else{
      $('#confirm_password_message').html("");
    }
    return true;
  }else{
    $('#confirm_password_message').html("<p class='text-danger'>確認密碼輸入不同</p>");
    return false;
  }
}

function tax_id_number_format(){
  if(/^[0-9]{8}$/.test($('#inputTaxIdNumber').val())){
    $('#tax_id_number_message').html(format_true_img());
    return true;
  }else{
    $('#tax_id_number_message').html("<p class='text-danger'>統編為8位數字</p>");
    return false;
  }
}

function company_chinese_format(){
  if(/^[\u4E00-\u9FA5]+$/.test($('#inputCompanyChinese').val())){
    $('#company_chinese_message').html(format_true_img());
    return true;
  }else{
    $('#company_chinese_message').html("<p class='text-danger'>公司中文名稱應只有中文</p>");
    return false;
  }
}

function company_english_format(){
  if($('#inputCompanyEnglish').val()==""){
    $('#company_english_message').html("");
    return true;
  }
  if(/^[a-zA-Z][a-zA-Z\d\s.,'"-]+[a-zA-Z\s.,]$/.test($('#inputCompanyEnglish').val())){
    $('#company_english_message').html(format_true_img());
    return true;
  }else{
    $('#company_english_message').html("<p class='text-danger'>公司英文名稱不該有中文</p>");
    return false;
  }
}

function contact_name_format(){
  if(/^[\u4E00-\u9FA5]+$/.test($('#inputContactName').val())){
    $('#contact_name_message').html(format_true_img());
    return true;
  }else{
    $('#contact_name_message').html("<p class='text-danger'>聯絡人名稱應只有中文</p>");
    return false;
  }
}

function contact_cellphone_format(){
  if($('#inputContactCellphone').val()==""){
    $('#contact_cellphone_message').html("");
    return true;
  }
  if(/^[0][9][0-9]{8}$/.test($('#inputContactCellphone').val())){
    $('#contact_cellphone_message').html(format_true_img());
    return true;
  }else{
    $('#contact_cellphone_message').html("<p class='text-danger'>電話應為數字10碼</p>");
    return false;
  }
}

function contact_company_phone_format(){
  if(/^[(][0-9]{2,3}[)][0-9]{2,4}[-][0-9]{4}$/.test($('#inputContactCompanyPhone').val())){
    $('#contact_company_phone_message').html(format_true_img());
    return true;
  }else{
    $('#contact_company_phone_message').html("<p class='text-danger'>電話應為數字且半形無空白</p>");
    return false;
  }
}

function contact_company_fax_format(){
  if($('#inputContactCompanyFax').val()!=""){
    if(/^[(][0-9]{2,3}[)][0-9]{2,4}[-][0-9]{4}$/.test($('#inputContactCompanyFax').val())){
      $('#contact_company_fax_message').html(format_true_img());
      return true;
    }else{
      $('#contact_company_fax_message').html("<p class='text-danger'>傳真應為數字且半形無空白</p>");
      return false;
    }
  }
  $('#contact_company_fax_message').html("");
  return true;
}

function contact_email_format(){
  if(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($('#inputContactEmail').val())){
    $('#contact_email_message').html(format_true_img());
    return true;
  }else{
    $('#contact_email_message').html("<p class='text-danger'>E-MAIL格式錯誤</p>");
    return false;
  }
}

function removeDuplicates(originalArray, prop) {
     var newArray = [];
     var lookupObject  = {};
 
     for(var i in originalArray) {
        lookupObject[originalArray[i][prop]] = originalArray[i];
     }
 
     for(i in lookupObject) {
         newArray.push(lookupObject[i]);
     }
      return newArray;
}

function AjaxQuoteExportPriceSearch(cabinet_volumes,cut_off_place_id,destination_port_id) {
    $.ajax({
      type: 'POST',
      url: '../../Action/QuotePriceAction.php',
      data: {
        action: 'price',
        cabinet_volumets:cabinet_volumes,
        cut_off_place_id: cut_off_place_id,
        destination_port_id: destination_port_id,
        dataType: "json" 
      },
      success:function(item){
        item=JSON.parse(item);
        msg="<div class='col col-lg-1 d-flex align-items-center'>海運價格</div>";
        msg+="<div class='col col-lg-2 text-start'>"+item[0]+"</div>";
        $("#OceanExportPriceShow").html(msg);
        $("#inputOceanExportPriceData").val(item[1]);
      },
      cache:false,
      ifModified :true,
      async:false,
      error:function(item){
        result=false;
      }
    })
}
