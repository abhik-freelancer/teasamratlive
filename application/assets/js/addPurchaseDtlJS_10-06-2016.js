/* 
 * Add purchase details by clicking add details
 * Abhik 
 * 25/08/2015
 */

$(document).ready(function(){
    var basepath = $("#basepath").val();
    
    var sampleBagRow=1;
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;
    
     $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });
    
    $("#startdate").val(mindate);
    $("#enddate").val(maxDate);
    
    
    /**
     * //adding new sample bag
     */
    $(".samplebag").click(function(){
       
       var tableId="#sampleBag tr:last";
       //alert(tableId);
       var newRow='<tr id="row_'+sampleBagRow+'">'+
                  '<td>'+
                  '<input type="hidden" id="txtSampleBagid" name="txtSampleBagid" value="0"/>'+
                  '<input type="hidden" id="txtSampleBagTypeId" name="txtSampleBagTypeId" value="2"/>'+
                  '<img src="'+basepath+'application/assets/images/delete-ab.png" title="Delete" alt="Delete" class="removeRow" id="'+sampleBagRow+'" style="cursor: pointer; cursor: hand;"/>'+
                  '</td>'+
                  '<td>'+
                  '<input type="text" id="txtNumOfSampleBag" name="txtNumOfSampleBag" class="txtNumOfSampleBag" value="0"/>[Bags]</td>'+
                  '<td>'+
                  '<input type="text" id="txtNumOfSampleNet" name="txtNumOfSampleNet" class="txtNumOfSampleNet" value="0"/>[Kgs/bag]</td>'+
                  '<td><input type="text" id="txtNumOfSampleChess" name="txtNumOfSampleChess" class="txtNumOfSampleChess" value=""/></td>'+
                  '</tr>';
       
       
       $(tableId).after(newRow);
       sampleBagRow++;
       
                $(".removeRow").click(function(){
                var delRowId = $(this).attr('id');
                var rowNumber = "#row_"+delRowId;
                //var priceid= $(this).attr('id');
                //var purDtlId = priceid.split('_');
                //var purchase_dtl_id =purDtlId[0];
                $(rowNumber).remove();
                getTotalTeaValue();
                getNumberofBag();
                });
     });
     /**event**/
     
     
     $(".stampval").keyup(function(){
        
        var priceid= $(this).attr('id');
       // var purDtlId = priceid.split('_');
        //var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue();
        
    });
     
     
     $(".price").keyup(function(){
        
        var priceid= $(this).attr('id');
       // var purDtlId = priceid.split('_');
        //var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue();
        getCostOfTeaPrKg();
        
    });
         
         
     $(".transCost").keyup(function(){
        
        var transcost= $(this).attr('id');
       // var purDtlId = priceid.split('_');
        //var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue();
        getCostOfTeaPrKg();
        
    });
    
    $(".txtBrokerage").keyup(function(){
        
        //var brokerageid= $(this).attr('id');
        //var purDtlId = brokerageid.split('_');
        //var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue();
        getCostOfTeaPrKg();
        
    });
    
    $(".txtNumOfNormalBag").keyup(function(){
        //var NumOfNormalBagId=$(this).attr('id');
       // var purDtlId = NumOfNormalBagId.split('_');
       // var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue();
         getCostOfTeaPrKg();
        
    });
    
    $(".txtNumOfNormalNet").keyup(function(){
       // var NumOfNormalNetId=$(this).attr('id');
        //var purDtlId = NumOfNormalNetId.split('_');
        //var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue();
         getCostOfTeaPrKg();
        
    });
    
    $(document).on('keyup', ".txtNumOfSampleBag", function() {
       /* var NumOfSampleBagId=$(this).attr('id');
        var purDtlId = NumOfSampleBagId.split('_');
        var purchase_dtl_id =purDtlId[1];*/
        //console.log("no of smplebag :"+purchase_dtl_id);
        getTotalTeaValue();
         getCostOfTeaPrKg();
    });
    
     $(document).on('keyup', ".txtNumOfSampleNet", function() {
        /*var NumOfSampleNetId=$(this).attr('id');
        var purDtlId = NumOfSampleNetId.split('_');
        var purchase_dtl_id =purDtlId[1];*/
        getTotalTeaValue();
         getCostOfTeaPrKg();
    });
    
     $(document).on('click', ".txtNumOfSampleNet", function() {
        /*var NumOfSampleNetId=$(this).attr('id');
        var purDtlId = NumOfSampleNetId.split('_');
        var purchase_dtl_id =purDtlId[1];*/
        getTotalTeaValue();
    });
    
    
   
    $(".drpVatRate").change(function(){
       /*var vatSelId=$(this).attr('id');
       var purDtlId = vatSelId.split('_');
       var purchase_dtl_id =purDtlId[1];*/
       getTotalTeaValue();
       
    });
    $(".drpCSTRate").change(function(){
      /* var cstSelId=$(this).attr('id');
       var purDtlId = cstSelId.split('_');
       var purchase_dtl_id =purDtlId[1];*/
       getTotalTeaValue();
       
    });
    $(".drpServiceTax").change(function(){
       /*var srvcSelId=$(this).attr('id');
       var purDtlId = srvcSelId.split('_');
       var purchase_dtl_id =purDtlId[1];*/
       getTotalTeaValue();
        getCostOfTeaPrKg();
       
    });
    
     
     /*****event**/
     
      $(".optionRateType").click(function(){
       // var radioId=$(this).attr('id');
       // var purDtlId = radioId.split('_');
        //var purchase_dtl_id =purDtlId[1];
        var val = $(this).val(); // retrieve the value
        
         if( val=='V' ){ // check if the radio is checked
            $("#vatDiv").css("display", "block");
            $("#cstDiv").css("display", "none");
        }
         else{ // check if the radio is checked
            //var val = $(this).val(); // retrieve the value
            $("#vatDiv").css("display", "none");
            $("#cstDiv").css("display", "block");
        }
        
        //console.log(val);
    });
     
   $(document).on('keyup', ".txtNumOfNormalBag", function() {
       getNumberofBag();
    });
  $(document).on('keyup', ".txtNumOfSampleBag", function() {
       getNumberofBag();
    });
    
    
});
/***********************************************************************************************************************/
/*****************************************************User Defined Function*********************************************/
/**
 * @method getTotalTeaValue
 * @param {int} puDtId
 * @return {double}
 * @description Main function for getting total tea cost.
 * All other function also called from here.
 */

function getTotalTeaValue(){
    var totalTeaCost=0;
    
    var brokerage=0;
    var vatAmount=0;
    var cstAmount=0;
    var serviceTaxAmt=0;
    var teaTotalPrice=0;
    var stampCharges=0
    
    brokerage=($('#txtBrokerage').val()==''?0:$('#txtBrokerage').val());
    stampCharges = ($('#txtStamp').val()==''?0:$('#txtStamp').val());
    
    if( $("#rdRateTypeVat").is(":checked") ){ // check if the radio is checked
          vatAmount=getVatAmount(); 
        }
    
    if( $("#rdRateTypeCST").is(":checked") ){ // check if the radio is checked
            cstAmount = getCstAmount();
            
        }
    
    serviceTaxAmt = getServiceTax();
    teaTotalPrice = getTeaTotalPrice();
    
    totalTeaCost = (parseFloat(brokerage) + parseFloat(vatAmount) + parseFloat(cstAmount)+ parseFloat(serviceTaxAmt)+ parseFloat(teaTotalPrice)+parseFloat(stampCharges)).toFixed(2);
    $("#DtltotalValue").val(totalTeaCost);
   
    //console.log("totalTeaCost :"+totalTeaCost);
    return totalTeaCost;
    
}






/**
 * @method getServiceTax
 * @return {undefined}
 */
function getServiceTax(){
   var brokerageValue = 0;
   var selectedServiceTax="#drpServiceTax option:selected";
   var serviceTaxAmount=0;
   var serviceTaxPercentage=0;
   
   brokerageValue = ($('#txtBrokerage').val()==''?0:$('#txtBrokerage').val());
   serviceTaxPercentage =($(selectedServiceTax).text()=='Select'?'0':$(selectedServiceTax).text());
   serviceTaxAmount =((parseFloat(brokerageValue))* parseFloat(serviceTaxPercentage))/100;
  // console.log(serviceTaxAmount);
   $("#serviceTax").val(serviceTaxAmount.toFixed(2));
   return serviceTaxAmount;
   
   
}
/**
 * @method getCstAmount
 * @param {int} dtlids
 * @return {int}
 */
function getCstAmount(){
var brokerageValue = 0;
var stampCharges=0;
var totalTeaPrice =0;
var cstPercentage=0;
var cstAmount=0;
var selectedCST ="#drpCSTRate option:selected";

brokerageValue = ($('#txtBrokerage').val()==''?0:$('#txtBrokerage').val());
stampCharges = ($('#txtStamp').val()==''?0:$('#txtStamp').val());
totalTeaPrice = getTeaTotalPrice();
cstPercentage = ($(selectedCST).text()=='Select'?'0':$(selectedCST).text());
cstAmount = ((parseFloat(brokerageValue)+parseFloat(stampCharges)+parseFloat(totalTeaPrice))* parseFloat(cstPercentage))/100;
$("#txtCstAmount").val(cstAmount.toFixed(2));
//console.log(cstAmount);
return cstAmount;

}

/**
 * @method getVatAmount
 * @param {int} dtlids
 * @return {int}
 */

function getVatAmount(){
var brokerageValue = 0;
var stampCharges=0;
var totalTeaPrice =0;
var vatPercentage=0;
var vatAmount=0;
var selectedVat ="#drpVatRate option:selected";

brokerageValue = ($('#txtBrokerage').val()==''?0:$('#txtBrokerage').val());
stampCharges = ($('#txtStamp').val()==''?0:$('#txtStamp').val());
totalTeaPrice = getTeaTotalPrice();
vatPercentage = ($(selectedVat).text()=='Select'?'0':$(selectedVat).text());
vatAmount = ((parseFloat(brokerageValue)+parseFloat(stampCharges)+parseFloat(totalTeaPrice))* parseFloat(vatPercentage))/100;
$("#txtVatAmount").val(vatAmount.toFixed(2));
//console.log(vatAmount);//26082015

return vatAmount;

}
/**
 * @method getTeaTotalPrice
 * @param {int} purDtlId description
 * @return {double} total tea price
 */
function getTeaTotalPrice(){
    var price=0;
    var totalQty=0;
    var totalTeaPrice=0;
    
    totalQty = getNumberofBagQty();
    price=($('#txtPrice').val()==""?0:$('#txtPrice').val());
    totalTeaPrice = parseFloat(totalQty) * parseFloat(price);
    
    //console.log(totalTeaPrice);
    return totalTeaPrice;
}
/**
 * @method getNumberofBagQty
 * @param {int} dtlId description
 * @return {int} Total Quantity of Bags
 * 
 */
function getNumberofBagQty(){

    var tableId = "#tableNormal  tr";
    var sampleTableId = "#sampleBag tr";

    var numOfBags;
    var normalBagQty;
    var numOfSampleBag;
    var sampleBagQty;
    var total_Quantity_normal_bag = 0;
    var total_Quantity_sample_bag = 0;
    var totalQtyOfBags = 0;

    var i = 0;
    var data = {
        numberofSampleBag: [], QtyInSampleBag: [], qty: []
    }

    $(tableId).each(function() {
        numOfBags = ($(this).find(".txtNumOfNormalBag").val() == "" ? 0 : $(this).find(".txtNumOfNormalBag").val());
        normalBagQty = ($(this).find(".txtNumOfNormalNet").val() == "" ? 0 : $(this).find(".txtNumOfNormalNet").val());
    });
    total_Quantity_normal_bag = parseFloat(numOfBags) * parseFloat(normalBagQty);

    //loop through the tr's
    $(sampleTableId).each(function() {

        //look for the fields firstName and lastName in the tr
        //get their values and push into storage   
        if (i != 0) {
            numOfSampleBag = ($(this).find(".txtNumOfSampleBag").val() == "" ? 0 : $(this).find(".txtNumOfSampleBag").val());
            sampleBagQty = ($(this).find(".txtNumOfSampleNet").val() == "" ? 0 : $(this).find(".txtNumOfSampleNet").val());
            data.numberofSampleBag.push(numOfSampleBag);
            data.QtyInSampleBag.push(sampleBagQty);
            data.qty.push(parseFloat(numOfSampleBag) * parseFloat(sampleBagQty));
            total_Quantity_sample_bag = total_Quantity_sample_bag + parseFloat(numOfSampleBag * sampleBagQty);
        }
        i++;

    });

    totalQtyOfBags = total_Quantity_normal_bag + total_Quantity_sample_bag;
    $("#DtltotalWeight").val(totalQtyOfBags);
    
    //console.log("totalWeight :"+totalQtyOfBags);

    return totalQtyOfBags;
}

/*
 * @method getNumberofBag()
 * @date 16-01-2016
 */
function getNumberofBag(){

    var tableId = "#tableNormal  tr";
    var sampleTableId = "#sampleBag tr";
    
    
    var numOfBags=0;
   
    var numOfSampleBag=0;
   

    var i = 0;
    var data = {
        numberofSampleBag: []
    }

    $(tableId).each(function() {
        numOfBags_N = ($(this).find(".txtNumOfNormalBag").val() == "" ? 0 : $(this).find(".txtNumOfNormalBag").val());
      
    });
  
   numOfBags = numOfBags + parseInt(numOfBags_N);

    //loop through the tr's
    $(sampleTableId).each(function() {

        
        if (i != 0) {
            numOfSampleBag_N = ($(this).find(".txtNumOfSampleBag").val() == "" ? 0 : $(this).find(".txtNumOfSampleBag").val());
           
            data.numberofSampleBag.push(parseInt(numOfSampleBag));
           
            numOfSampleBag = parseInt(numOfSampleBag_N) + numOfSampleBag;
        }
        i++;

    });

    //totalQtyOfBags = total_Quantity_normal_bag + total_Quantity_sample_bag;
    totalNoOfBag =  numOfBags + numOfSampleBag;
    
   //    $("#DtltotalBags_" + dtlId).val(totalNoOfBag);

    //console.log("totalBag :" + totalNoOfBag);
   // console.log("id :" + dtlId);
    $("#DtltotalBags").val(totalNoOfBag);
    return totalNoOfBag;
   // console.log();
}

function getCostOfTeaPrKg(){
    var brokerageValue=0;
    var price = 0 ;
     var transPortCost = 0;
    var totalWeight = 0;
    var serviceTax = 0;
    var totalTeaPrice= 0 ;
   var teaCost = 0;
    var teaCostPrKg = 0;
    
    brokerageValue = ($('#txtBrokerage').val()==''?0:$('#txtBrokerage').val());
    transPortCost = ($('#transCost').val() == '' ? 0 : $('#transCost').val());
    price=($('#txtPrice').val()==""?0:$('#txtPrice').val());
    totalWeight = getNumberofBagQty();
    if(totalWeight!=0){
        serviceTax = getServiceTax();
        totalTeaPrice = (parseFloat(totalWeight) * parseFloat(price))+parseFloat(brokerageValue)+parseFloat(serviceTax);
        
       teaCost = totalTeaPrice / parseFloat(totalWeight);
    
    teaCostPrKg = teaCost+parseFloat(transPortCost);
        $("#DtlteaCost" ).val(teaCostPrKg.toFixed(2));
        }
        else{
             $("#DtlteaCost" ).val('0.00');
        }
    
    return teaCostPrKg;
}


function purchaseDetailsAdd(){
    
    var basepath =  $("#basepath").val();
    var LotNumber;
    var doNumber;
    var doDate;
    var invoiceNumber;
    var stamp;
    var gross;
    var brokerage;
    var gpNumber,gpDate,price,transCost,group,location,garden,grade,warehouse,numberOfNormalBag,normalBagQty,normalchest,normalBagId;
    var rateType,rateTypeId,rateTypeAmount;
    var serviceTax,serviceTaxAmount;
    var totalWeight,totalValue,teaCostPrKg;
    var sampleBagTableId ;
    var PurchaseMasterId;
    var PurchaseType;
    var i=0;
    
    var sampleBagData= {
        numberofSampleBag: [], QtyInSampleBag: [], sampleBagChest: []
    };
    
    if(validation()){
        $("#detailDiv").children().attr('disabled', 'disabled');
        
        PurchaseMasterId = $("#PmasterId").val();
        PurchaseType = $("#PurchaseType").val();
        //alert(PurchaseType);
        LotNumber=$("#txtLot").val();
        doNumber = $("#txtDo").val();
        doDate = $("#txtDoDate").val();
        invoiceNumber = $("#txtInvoice").val();
        stamp = $("#txtStamp").val();
        gross = $("#txtGross").val();
        brokerage = $("#txtBrokerage").val();
        gpNumber =$("#txtGpnumber").val();
        gpDate = $("#txtGpDate").val();
        price =$("#txtPrice").val();
        transCost =$("#transCost").val();
        group =$("#drpGroup").val();
        location=$("#drpLocation").val();
        garden=$("#drpGarden").val();
        grade=$("#drpGrade").val();
        warehouse=$("#drpWarehouse").val();
        
        normalBagId =$("#txtNormalBagid").val();
        numberOfNormalBag=$("#txtNumOfNormalBag").val();
        normalBagQty=$("#txtNumOfNormalNet").val();
        normalchest=$("#txtNumOfNormalChess").val();
        //console.log(normalBagQty);
       // var rateTypeVat ="#rdRateTypeVat_"+purchaseDtlId;
        
        if($("#rdRateTypeVat").is(":checked")){rateType = 'V';}
       
        if($("#rdRateTypeCST").is(":checked")){rateType='C';}
       
       
        
        if(rateType=='V'){
          rateTypeId = $("#drpVatRate").val();
          rateTypeAmount = $("#txtVatAmount").val();
        }else{
          rateTypeId = $("#drpCSTRate").val();
          rateTypeAmount = $("#txtCstAmount").val();
        }
        serviceTax=$("#drpServiceTax").val();
        serviceTaxAmount = $("#serviceTax").val();
        totalWeight = $("#DtltotalWeight").val();
        totalValue = $("#DtltotalValue").val();
        teaCostPrKg = $("#DtlteaCost").val();
        
        sampleBagTableId = "#sampleBag tr";
        
        var numOfSampleBag;
        var sampleBagQty;
        var sampleChest;
         $(sampleBagTableId).each(function() {

            if (i != 0) {
                numOfSampleBag = ($(this).find(".txtNumOfSampleBag").val() == "" ? 0 : $(this).find(".txtNumOfSampleBag").val());
                sampleBagQty = ($(this).find(".txtNumOfSampleNet").val() == "" ? 0 : $(this).find(".txtNumOfSampleNet").val());
                sampleChest = ($(this).find(".txtNumOfSampleChess").val() == "" ? 0 : $(this).find(".txtNumOfSampleChess").val());
                
                sampleBagData.numberofSampleBag.push(numOfSampleBag);
                sampleBagData.QtyInSampleBag.push(sampleBagQty);
                sampleBagData.sampleBagChest.push(sampleChest);
            }
        i++;

    });
    //console.log(validation(sampleBagData));
    //saving data
    $.ajax({
        url: basepath + "purchaseinvoice/addNewPurchaseDetails",
        type: 'post',
        data: {
            PurchaseMasterId:PurchaseMasterId,
            PurchaseType:PurchaseType,
            lotnumber:LotNumber,doNumber:doNumber,
            doDate:doDate,invoice:invoiceNumber,stamp:stamp,gross:gross,brokerage:brokerage,
            GPnumber:gpNumber,gpDate:gpDate,price:price,transCost:transCost,group:group,locationId:location,
            garden:garden,grade:grade,warehouse:warehouse,normalBagId:normalBagId,NormalBags:numberOfNormalBag,NormalBagQtys:normalBagQty,normalBagChest:normalchest,
            sampleBags:sampleBagData,rateType:rateType,rateTypeAmount:rateTypeAmount,rateTypeId:rateTypeId,
            servicetaxId:serviceTax,serviceTaxAmount:serviceTaxAmount,
            totalWeight:totalWeight,teaCostPrKg:teaCostPrKg,totalDtlCost:totalValue
        },
        success: function(data) {
                    
            if(data==1){
               
                    $( "#dialog-Edit" ).dialog({
                                            resizable: false,
                                            height:140,
                                            modal: true,
                                            buttons: {
                                              "Ok": function() {
                                                   $("#detailDiv").children().attr('enabled', 'enabled');
                                                  window.location.href = basepath+'purchaseinvoice/addPurchaseInvoice/id/'+PurchaseMasterId;
                                                $( this ).dialog( "close" );
                                              }
                                            }
                                          });
                
                
                
                
            }
        },
        complete: function(){
        
        
        },
        error: function(e) {
            //called when there is an error
            //console.log(e.message);
        }
    });
    
    
    //saving data
        
        
    }else{
        
    }
}



function validation(){
    
    var invoiceNumber = $("#txtInvoice").val();
    var lotNumber = $("#txtLot").val();
    var price = $("#txtPrice").val();
    var normalBag = $("#txtNumOfNormalBag").val();
    var QtyofNormalBag = $("#txtNumOfNormalNet").val();
    var garden = $("#drpGarden").val();
    var grade =$("#drpGrade").val();
    var warehouse=$("#drpWarehouse").val();
    var group = $("#drpGroup").val();
   
   
    if(lotNumber==""){
         
         $("#txtLot").addClass("glowing-border");
         return false;
    }
     if(invoiceNumber==""){
         
         $("#txtInvoice").addClass("glowing-border");
         return false;
    }
    if(price==""){
        
         $("#txtPrice").addClass("glowing-border");
         return false;
    }
   if(group==0){
         
        $("#drpGroup").addClass("glowing-border");
        return false;
   }
      
   if(garden==0){
        
        $("#drpGarden").addClass("glowing-border");
        return false;
   }
   if(grade==0){
       
        $("#drpGrade").addClass("glowing-border");
        return false;
   }
   if(warehouse==0){
        
        $("#drpWarehouse").addClass("glowing-border");
        return false;
   }
  
   
     if(normalBag==""){
        
         $("#txtNumOfNormalBag").addClass("glowing-border");
         return false;
    }
    if(QtyofNormalBag==""){
        
         $("#txtNumOfNormalNet").addClass("glowing-border");
         return false;
    }
   
   
   
   return true;
}
