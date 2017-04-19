/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
       $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
        $(".rawmaterialconsumption").addClass(" active ");
    
    
     var basepath = $("#basepath").val();
    $("#product").customselect();
    
   $("#rawmaterial").change(function(){
       var rawmaterialid = $("#rawmaterial").val()||"";
      
        $.ajax({
            type: "POST",
            url: basepath + 'rawmaterialconsumption/getRawmaterialData',
            dataType: "json",
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data: {rawmaterialid: rawmaterialid},
            success: function (result) {
                $("#txtUnit").val(result.Unit);
                $("#txtQty").val("");
            }, error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                alert(msg);
            }
        });
        
       
       
   });
   
   
   $(document).on('change','#product',function(){
      var productpacketid = $("#product").val()||"";
      $("#detail_material > tbody").html("");
      if(productpacketid!=""){
       
        
      $.ajax({
            type: "POST",
            url: basepath + 'rawmaterialconsumption/getProductRawmetirial',
            dataType: "json",
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data: {productPacketId: productpacketid},
            success: function (result) {
            
               $.each(result, function(i, item) {
                var row="<tr class='success'><td><input type='hidden' value='"+item.rawmaterialid+"' name='rawmaterialid'/>"+item.product_description+"</td><td>"+item.unitName+"</td>"+
               "<td>"+item.quantity_required+"</td><td><img src='"+basepath+"application/assets/images/error-AB.png' alt='del' class='rowDel' style='cursor: pointer;' /></td></tr>";
               $('#detail_material tbody').append(row);

            });
               
               
               
            }, error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                alert(msg);
            }
        });
    }
       
       
   });
   
   $("#addmatrl").click(function(){
       var rawmaterialname= $("#rawmaterial option:selected").text();
       var rawmaterialid=$("#rawmaterial").val()||"";
       var Unit =$("#txtUnit").val();
       var qty = $("#txtQty").val();
       var string_table = "<tr class='success'><td><input type='hidden' value='"+rawmaterialid+"' name='rawmaterialid'/>"+rawmaterialname+"</td><td>"+Unit+"</td>"+
               "<td>"+qty+"</td><td><img src='"+basepath+"application/assets/images/error-AB.png' alt='del' class='rowDel' style='cursor: pointer;' /></td></tr>";
       if(rowValidation()){
       $('#detail_material tbody').append(string_table);
   }else{
       alert("Please select rawmaterial and qty");
   }
   });
   
   $(".btn_save").click(function(){
       var productid= $("#product").val()||"";
       var rawmaterialDetails=getRawmaterialDtl();
       if(validation()){
       $.ajax({
                type: 'POST',
                url: basepath + "rawmaterialconsumption/saveRawmaterialconsumption",
                data: {
                    "productid":productid,
                    "rawmaterialDetails":rawmaterialDetails,
                   
                },
             
                 dataType:'json',
                success: function (data) {
                    
                    if (data.success==1) {
                        alert('Data successfully saved .');
                        //to do
                           window.location.href = basepath + 'rawmaterialconsumption';
                    }
                    else {
                        alert('Data not properly updated' );
                        return false;
                    }
                }
            });
        }else{
            alert("Valiadation fail");
        }
   });
     $('.Quantity').keypress(function(event){
       return isNumber(event, this);
    });
    
     $("#detail_material").on('click', '.rowDel', function () {
       
       
         $(this).closest('tr').remove();
        
    });
    
});//document end section

function rowValidation(){
    var rawmaterialid=$("#rawmaterial").val()||"";
    var qty = $("#txtQty").val();
    if(rawmaterialid==""){return false;}
    if(qty==""){return false;}
    return true;
}
function getRawmaterialDtl(){
     var DetailJSON = { Details: [] };
        
        var rawmaterialId = 0;
        var Quantity =0;
       

        $("#detail_material tr:gt(0)").each(function () {
            var this_row = $(this);
            rawmaterialId = $.trim(this_row.find('td:eq(0)').children('input').val());//td:eq(0) means first td of this row
            Quantity = parseFloat($.trim(this_row.find('td:eq(2)').html()));
           
            if(rawmaterialId!=""){
            DetailJSON.Details.push({
                 "rawmaterialId": rawmaterialId,
                 "Quantity":Quantity
             });
            }
            
        });
        
        return DetailJSON;
}

function validation(){
    var rowCount=0;
    if($("#product").val()==""){return false;}
    $("#detail_material tr:gt(0)").each(function () {
            var this_row = $(this);
           
            rowCount = rowCount +1;
        });
    
    if(rowCount==0){return false;}
    return true;
    
}
function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }    