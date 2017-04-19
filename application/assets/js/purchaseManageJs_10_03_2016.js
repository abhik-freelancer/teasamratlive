/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

   /* $("#saledate").change(function() {

        var saledate = $("#saledate").val().split("-");
        var sale = saledate[1] + '/' + saledate[0] + '/' + saledate[2];
        dtNextWeek = new Date(sale);
        dtNextWeek.setDate(dtNextWeek.getDate() + 14);
        var month = dtNextWeek.getMonth() + parseFloat(1);
        if (month < 9)
        {
            month = '0' + month;
        }

        var promtdate = dtNextWeek.getDate() + '-' + month + '-' + dtNextWeek.getFullYear();
        $('#promtdate').val(promtdate);
    });*/
  
    $( ".accordion" ).accordion({
        collapsible: true,
        heightStyle: "content" 

    });
    
    /*@date 18-01-2016
     * @author Mihtilesh
     */
    
    $("#taxinvoicedate").change(function(){
       var taxinvoicedate = $("#taxinvoicedate").val().split("-");
       var taxinvoice = taxinvoicedate[1] + '/' + taxinvoicedate[0] + '/' + taxinvoicedate[2];
        dtNextWeek = new Date(taxinvoice);
        dtNextWeek.setDate(dtNextWeek.getDate());
        var day = dtNextWeek.getDate();
        var month = dtNextWeek.getMonth() + parseFloat(1);
        
        if (month < 9)
        {
            month = '0' + month;
        }
        if (day < 10)
        {
            day = '0' + day;
        }
        promptdate = new Date(taxinvoice);
        promptdate.setDate(promptdate.getDate() + 14);
        var day1 = promptdate.getDate();
        var month1 = promptdate.getMonth() + parseFloat(1);
        
        if (month1 < 9)
        {
            month1 = '0' + month1;
        }
        if (day1 < 10)
        {
            day1 = '0' + day1;
        }
        var saledate = day + '-' + month + '-' + dtNextWeek.getFullYear();
        var promt_date = day1 + '-' + month1 + '-' + promptdate.getFullYear();
       
        $('#saledate').val(saledate);
         $('#promtdate').val(promt_date);
    });
    
    /**
     * //adding new sample bag
     */
    $(".samplebag").click(function(){
       var purDtlid=$(this).attr('id');
       //alert(purDtlid);
       var tableId="#sampleBag_"+purDtlid+" tr:last";
       //alert(tableId);
       var newRow='<tr id="row_'+purDtlid+'_'+sampleBagRow+'">'+
                  '<td>'+
                  '<input type="hidden" id="txtSampleBagid_'+purDtlid+'_0" name="txtSampleBagid" value="0"/>'+
                  '<input type="hidden" id="txtSampleBagTypeId_'+purDtlid+'_0" name="txtSampleBagTypeId" value="2"/>'+
                  '<img src="'+basepath+'application/assets/images/delete-ab.png" title="Delete" alt="Delete" class="removeRow" id="'+purDtlid+'_'+sampleBagRow+'" style="cursor: pointer; cursor: hand;"/>'+
                  '</td>'+
                  '<td>'+
                  '<input type="text" id="txtNumOfSampleBag_'+purDtlid+'_0" name="txtNumOfSampleBag" class="txtNumOfSampleBag" value="0"/>[Bags]</td>'+
                  '<td>'+
                  '<input type="text" id="txtNumOfSampleNet_'+purDtlid+'_0" name="txtNumOfSampleNet" class="txtNumOfSampleNet" value="0"/>[Kgs/bag]</td>'+
                  '<td><input type="text" id="txtNumOfSampleChess_'+purDtlid+'_0" name="txtNumOfSampleChess" class="txtNumOfSampleChess" value=""/></td>'+
                  '</tr>';
       
       
       $(tableId).after(newRow);
       sampleBagRow++;
       
               /* $(".removeRow").click(function(){*/
               $(document).on('click', ".removeRow", function() {
                var delRowId = $(this).attr('id');
                var rowNumber = "#row_"+delRowId;
                var priceid= $(this).attr('id');
                var purDtlId = priceid.split('_');
                var purchase_dtl_id =purDtlId[0];
                $(rowNumber).remove();
                getTotalTeaValue(purchase_dtl_id);
                console.log(getTotalTeaValue(purchase_dtl_id));
                //totalBagNo(purchase_dtl_id);
                TotalBags(purchase_dtl_id);
                
                totalBagNo();
                
                });
     });
     //adding new sample bag end
     
    $(".stampval").keyup(function(){
        
        var priceid= $(this).attr('id');
        var purDtlId = priceid.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        
    });
     
     
    $(".price").keyup(function(){
        
        var priceid= $(this).attr('id');
        var purDtlId = priceid.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        getCostOfTeaPrKg(purchase_dtl_id);
        
    });
    $(".transCost").keyup(function(){
        
        var priceid= $(this).attr('id');
        var purDtlId = priceid.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        getCostOfTeaPrKg(purchase_dtl_id);
        
    });
    
    $(".txtBrokerage").keyup(function(){
        
        var brokerageid= $(this).attr('id');
        var purDtlId = brokerageid.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        getCostOfTeaPrKg(purchase_dtl_id);
        
    });
    
    $(".txtNumOfNormalBag").keyup(function(){
        var NumOfNormalBagId=$(this).attr('id');
        var purDtlId = NumOfNormalBagId.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        getCostOfTeaPrKg(purchase_dtl_id);
        getGrandWeight();
        
    });
    
    
/*@date 16-01-2016
 * author mithilesh
 */    
      $(".txtNumOfNormalBag").keyup(function(){
        var NumOfNormalBagId=$(this).attr('id');
        var purDtlId = NumOfNormalBagId.split('_');
        var purchase_dtl_id =purDtlId[1];
        //getTotalTeaValue(purchase_dtl_id);
       // getGrandWeight();
       TotalBags(purchase_dtl_id);
       totalBagNo()
        
    });
    
     $(document).on('keyup', ".txtNumOfSampleBag", function() {
        var NumOfSampleBagId=$(this).attr('id');
        var purDtlId = NumOfSampleBagId.split('_');
        var purchase_dtl_id =purDtlId[1];
        //console.log("no of smplebag :"+purchase_dtl_id);
       // getTotalTeaValue(purchase_dtl_id);
       // getGrandWeight();
        TotalBags(purchase_dtl_id);
        getCostOfTeaPrKg(purchase_dtl_id);
        totalBagNo();
    });
    
   /* $(document).on('keyup', ".txtNumOfSampleBag", function() {
        var NumOfNormalBagId=$(this).attr('id');
        var purDtlId = NumOfNormalBagId.split('_');
        var purchase_dtl_id =purDtlId[1];
        //getTotalTeaValue(purchase_dtl_id);
       // getGrandWeight();
       TotalBags(purchase_dtl_id);
       totalBagNo()
        
    });*/
     
     
     
    
    $(".txtNumOfNormalNet").keyup(function(){
        var NumOfNormalNetId=$(this).attr('id');
        var purDtlId = NumOfNormalNetId.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        getCostOfTeaPrKg(purchase_dtl_id);
        getGrandWeight();
        
    });
    
    $(document).on('keyup', ".txtNumOfSampleBag", function() {
        var NumOfSampleBagId=$(this).attr('id');
        var purDtlId = NumOfSampleBagId.split('_');
        var purchase_dtl_id =purDtlId[1];
        //console.log("no of smplebag :"+purchase_dtl_id);
        getTotalTeaValue(purchase_dtl_id);
        getGrandWeight();
    });
    
     $(document).on('keyup', ".txtNumOfSampleNet", function() {
        var NumOfSampleNetId=$(this).attr('id');
        var purDtlId = NumOfSampleNetId.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        getCostOfTeaPrKg(purchase_dtl_id);
        getGrandWeight();
    });
    
     $(document).on('click', ".txtNumOfSampleNet", function() {
        var NumOfSampleNetId=$(this).attr('id');
        var purDtlId = NumOfSampleNetId.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        getGrandWeight();
    });
    
    
   
    $(".drpVatRate").change(function(){
       var vatSelId=$(this).attr('id');
       var purDtlId = vatSelId.split('_');
       var purchase_dtl_id =purDtlId[1];
       getTotalTeaValue(purchase_dtl_id);
       
    });
    $(".drpCSTRate").change(function(){
       var cstSelId=$(this).attr('id');
       var purDtlId = cstSelId.split('_');
       var purchase_dtl_id =purDtlId[1];
       getTotalTeaValue(purchase_dtl_id);
       
    });
    $(".drpServiceTax").change(function(){
       var srvcSelId=$(this).attr('id');
       var purDtlId = srvcSelId.split('_');
       var purchase_dtl_id =purDtlId[1];
       getTotalTeaValue(purchase_dtl_id);
       
    });
    
    
    
    $(".optionRateType").click(function(){
        var radioId=$(this).attr('id');
        var purDtlId = radioId.split('_');
        var purchase_dtl_id =purDtlId[1];
        
         if( $("#rdRateTypeVat_"+purchase_dtl_id).is(":checked") ){ // check if the radio is checked
            //var val = $(this).val(); // retrieve the value
            $("#vatDiv_"+purchase_dtl_id).css("display", "block");
            $("#cstDiv_"+purchase_dtl_id).css("display", "none");
        }
         if( $("#rdRateTypeCST_"+purchase_dtl_id).is(":checked") ){ // check if the radio is checked
            //var val = $(this).val(); // retrieve the value
            $("#vatDiv_"+purchase_dtl_id).css("display", "none");
            $("#cstDiv_"+purchase_dtl_id).css("display", "block");
        }
        
        //console.log(radioId);
    });
  
  //adding new purchsae details
  $("#addnewDtl").click(function(){
      var pMastId=$("#pMasterId").val();
      if(pMastId!=''){
      window.location.href = basepath+'purchaseinvoice/addPurchaseDetails/masterId/'+pMastId;
    }
  });
  
  $("#txtOtherCharges").keyup(function(){
        getOtherChargesRoundOff();
  });
  
  $("#txtRoundOff").keyup(function(){
        getOtherChargesRoundOff();
  });
  
    /*$("#txtBrokerageTotal").keyup(function(){
        getOtherChargesRoundOff(); //call for other charges
        
    });

    $("#txtServiceTax").keyup(function(){
       getOtherChargesRoundOff(); //call for other charges
        
    });*/
  
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

function getTotalTeaValue(puDtId){
    var totalTeaCost=0;
    
    var brokerage=0;
    var vatAmount=0;
    var cstAmount=0;
    var serviceTaxAmt=0;
    var teaTotalPrice=0;
    var stampCharges=0
    
    brokerage=($('#txtBrokerage_'+puDtId).val()==''?0:$('#txtBrokerage_'+puDtId).val());
    stampCharges = ($('#txtStamp_'+puDtId).val()==''?0:$('#txtStamp_'+puDtId).val());
    
    if( $("#rdRateTypeVat_"+puDtId).is(":checked") ){ // check if the radio is checked
          vatAmount=getVatAmount(puDtId); 
        }
    
    if( $("#rdRateTypeCST_"+puDtId).is(":checked") ){ // check if the radio is checked
            cstAmount = getCstAmount(puDtId);
            
        }
    
    serviceTaxAmt = getServiceTax(puDtId);
    teaTotalPrice = getTeaTotalPrice(puDtId);
    
    totalTeaCost = (parseFloat(brokerage) + parseFloat(vatAmount) + parseFloat(cstAmount)+ parseFloat(serviceTaxAmt)+ parseFloat(teaTotalPrice)+parseFloat(stampCharges)).toFixed(2);
    $("#DtltotalValue_"+puDtId).val(totalTeaCost);
   
    //console.log("totalTeaCost :"+totalTeaCost);
    return totalTeaCost;
    
}





/**
 * @method getServiceTax
 * @return {undefined}
 */
function getServiceTax(purchaseDetailId){
   var brokerageValue = 0;
   var selectedServiceTax="#drpServiceTax_"+purchaseDetailId+" option:selected";
   var serviceTaxAmount=0;
   var serviceTaxPercentage=0;
   
   brokerageValue = ($('#txtBrokerage_'+purchaseDetailId).val()==''?0:$('#txtBrokerage_'+purchaseDetailId).val());
   serviceTaxPercentage =($(selectedServiceTax).text()=='Select'?'0':$(selectedServiceTax).text());
   serviceTaxAmount =((parseFloat(brokerageValue))* parseFloat(serviceTaxPercentage))/100;
  // console.log(serviceTaxAmount);
   $("#serviceTax_"+purchaseDetailId).val(serviceTaxAmount.toFixed(2));
   return serviceTaxAmount;
   
   
}
/**
 * @method getCstAmount
 * @param {int} dtlids
 * @return {int}
 */
function getCstAmount(dtlids){
var brokerageValue = 0;
var stampCharges=0;
var totalTeaPrice =0;
var cstPercentage=0;
var cstAmount=0;
var selectedCST ="#drpCSTRate_"+dtlids+" option:selected";

brokerageValue = ($('#txtBrokerage_'+dtlids).val()==''?0:$('#txtBrokerage_'+dtlids).val());
stampCharges = ($('#txtStamp_'+dtlids).val()==''?0:$('#txtStamp_'+dtlids).val());
totalTeaPrice = getTeaTotalPrice(dtlids);
cstPercentage = ($(selectedCST).text()=='Select'?'0':$(selectedCST).text());
cstAmount = ((parseFloat(brokerageValue)+parseFloat(stampCharges)+parseFloat(totalTeaPrice))* parseFloat(cstPercentage))/100;
$("#txtCstAmount_"+dtlids).val(cstAmount.toFixed(2));
//console.log(cstAmount);
return cstAmount;

}

/**
 * @method getVatAmount
 * @param {int} dtlids
 * @return {int}
 */

function getVatAmount(dtlids){
var brokerageValue = 0;
var stampCharges=0;
var totalTeaPrice =0;
var vatPercentage=0;
var vatAmount=0;
var selectedVat ="#drpVatRate_"+dtlids+" option:selected";

brokerageValue = ($('#txtBrokerage_'+dtlids).val()==''?0:$('#txtBrokerage_'+dtlids).val());
stampCharges = ($('#txtStamp_'+dtlids).val()==''?0:$('#txtStamp_'+dtlids).val());
totalTeaPrice = getTeaTotalPrice(dtlids);
vatPercentage = ($(selectedVat).text()=='Select'?'0':$(selectedVat).text());
vatAmount = ((parseFloat(brokerageValue)+parseFloat(stampCharges)+parseFloat(totalTeaPrice))* parseFloat(vatPercentage))/100;
$("#txtVatAmount_"+dtlids).val(vatAmount.toFixed(2));
//console.log(vatAmount);

return vatAmount;

}
/**
 * @method getTeaTotalPrice
 * @param {int} purDtlId description
 * @return {double} total tea price
 */
function getTeaTotalPrice(purDtlId){
    var price=0;
    var totalQty=0;
    var totalTeaPrice=0;
    
    totalQty = getNumberofBagQty(purDtlId);
    price=($('#txtPrice_'+purDtlId).val()==""?0:$('#txtPrice_'+purDtlId).val());
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
function getNumberofBagQty(dtlId){

    var tableId = "#tableNormal_" + dtlId + " tr";
    var sampleTableId = "#sampleBag_" + dtlId + " tr";

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
    $("#DtltotalWeight_"+dtlId).val(totalQtyOfBags);
    
    //console.log("totalWeight :"+totalQtyOfBags);

    return totalQtyOfBags;
}


function getCostOfTeaPrKg(prdtlId){
    var brokerageValue=0;
    var price = 0 ;
    var transPortCost = 0;
    var totalWeight = 0;
    var serviceTax = 0;
    var totalTeaPrice= 0 ;
   var teaCost = 0;
    var teaCostPrKg = 0;
    
    brokerageValue = ($('#txtBrokerage_' + prdtlId).val() == '' ? 0 : $('#txtBrokerage_' + prdtlId).val());
    transPortCost = ($('#transCost_' + prdtlId).val() == '' ? 0 : $('#transCost_' + prdtlId).val());
    price = ($('#txtPrice_' + prdtlId).val() == "" ? 0 : $('#txtPrice_' + prdtlId).val());
    totalWeight = getNumberofBagQty(prdtlId);
        if(totalWeight!=0){
    serviceTax = getServiceTax(prdtlId);
    totalTeaPrice = (parseFloat(totalWeight) * parseFloat(price))+parseFloat(brokerageValue)+parseFloat(serviceTax);
     teaCost = totalTeaPrice / parseFloat(totalWeight);
    
    teaCostPrKg = teaCost+parseFloat(transPortCost);
    
    $("#DtlteaCost_" + prdtlId).val(teaCostPrKg.toFixed(2));
        }
        else{
            $("#DtlteaCost_" + prdtlId).val('0.00');
        }
    return teaCostPrKg;
}



/**
 * 
 * @param {type} purchaseDtlId
 * @returns {undefined}
 */
function updatePurDtl(purchaseDtlId){
   
    var basepath =  $("#basepath").val();
    var LotNumber;
    var doNumber;
    var doDate;
    var invoiceNumber;
    var stamp;
    var gross;
    var brokerage;
    var gpNumber,gpDate,price,transPortCost,group,location,garden,grade,warehouse,numberOfNormalBag,normalBagQty,normalchest,normalBagId;
    var rateType,rateTypeId,rateTypeAmount;
    var serviceTax,serviceTaxAmount;
    var totalWeight,totalValue,teaCostPrKg;
    var sampleBagTableId ;
    var PurchaseMasterId;
    var i=0;
    
    var sampleBagData= {
        numberofSampleBag: [], QtyInSampleBag: [], sampleBagChest: []
    };
    
    if(validation(purchaseDtlId)){
        $("#detailDiv").children().attr('disabled', 'disabled');
        PurchaseMasterId = $("#PurchaseMasterId_"+purchaseDtlId).val();
        LotNumber=$("#txtLot_"+purchaseDtlId).val();
        doNumber = $("#txtDo_"+purchaseDtlId).val();
        doDate = $("#txtDoDate_"+purchaseDtlId).val();
        invoiceNumber = $("#txtInvoice_"+purchaseDtlId).val();
        stamp = $("#txtStamp_"+purchaseDtlId).val();
        gross = $("#txtGross_"+purchaseDtlId).val();
        brokerage = $("#txtBrokerage_"+purchaseDtlId).val();
        gpNumber =$("#txtGpnumber_"+purchaseDtlId).val();
        gpDate = $("#txtGpDate_"+purchaseDtlId).val();
        price =$("#txtPrice_"+purchaseDtlId).val();
        transPortCost =$("#transCost_"+purchaseDtlId).val();
        group =$("#drpGroup_"+purchaseDtlId).val();
        location=$("#drpLocation_"+purchaseDtlId).val();
        garden=$("#drpGarden_"+purchaseDtlId).val();
        grade=$("#drpGrade_"+purchaseDtlId).val();
        warehouse=$("#drpWarehouse_"+purchaseDtlId).val();
        
        normalBagId =$("#txtNormalBagid_"+purchaseDtlId).val();
        numberOfNormalBag=$("#txtNumOfNormalBag_"+purchaseDtlId).val();
        normalBagQty=$("#txtNumOfNormalNet_"+purchaseDtlId).val();
        normalchest=$("#txtNumOfNormalChess_"+purchaseDtlId).val();
       // console.log(normalBagQty);
       // var rateTypeVat ="#rdRateTypeVat_"+purchaseDtlId;
        
        if($("#rdRateTypeVat_"+purchaseDtlId).is(":checked"))
        {
            rateType = 'V';
        }
       
        if($("#rdRateTypeCST_"+purchaseDtlId).is(":checked")){rateType='C';}
       
       
        
        if(rateType=='V'){
          rateTypeId = $("#drpVatRate_"+purchaseDtlId).val();
          rateTypeAmount = $("#txtVatAmount_"+purchaseDtlId).val();
        }else{
          rateTypeId = $("#drpCSTRate_"+purchaseDtlId).val();
          rateTypeAmount = $("#txtCstAmount_"+purchaseDtlId).val();
        }
        serviceTax=$("#drpServiceTax_"+purchaseDtlId).val();
        serviceTaxAmount = $("#serviceTax_"+purchaseDtlId).val();
        totalWeight = $("#DtltotalWeight_"+purchaseDtlId).val();
        totalValue = $("#DtltotalValue_"+purchaseDtlId).val();
        teaCostPrKg = $("#DtlteaCost_"+purchaseDtlId).val();
        
        sampleBagTableId = "#sampleBag_" + purchaseDtlId + " tr";
        
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
        url: basepath + "purchaseinvoice/updatePurchaseDetail",
        type: 'post',
        data: {
            PurchaseMasterId:PurchaseMasterId,
            purchaseDetailId:purchaseDtlId,lotnumber:LotNumber,doNumber:doNumber,
            doDate:doDate,invoice:invoiceNumber,stamp:stamp,gross:gross,brokerage:brokerage,
            GPnumber:gpNumber,gpDate:gpDate,price:price,transPortCost:transPortCost,group:group,location:location,
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

function validation(id){
    
    var error=0;
    var invoiceNumber = $("#txtInvoice_"+id).val();
    var lotNumber = $("#txtLot_"+id).val();
    var price = $("#txtPrice_"+id).val();
    var normalBag = $("#txtNumOfNormalBag_"+id).val();
    var QtyofNormalBag = $("#txtNumOfNormalNet_"+id).val();
    var garden = $("#drpGarden_"+id).val();
    var grade =$("#drpGrade_"+id).val();
    var warehouse=$("#drpWarehouse_"+id).val();
    var group = $("#drpGroup_"+id).val();
   
    if(invoiceNumber==""){
         error=1;
         $("#txtInvoice_"+id).addClass("glowing-border");
         return false;
    }
    if(lotNumber==""){
         error=1;
         $("#txtLot_"+id).addClass("glowing-border");
         return false;
    }
    if(price==""){
         error=1;
         $("#txtPrice_"+id).addClass("glowing-border");
         return false;
    }
    if(normalBag==""){
         error=1;
         $("#txtNumOfNormalBag_"+id).addClass("glowing-border");
         return false;
    }
    if(QtyofNormalBag==""){
         error=1;
         $("#txtNumOfNormalNet_"+id).addClass("glowing-border");
         return false;
    }
    
   if(garden==0){
        error=1;
        $("#drpGarden_"+id).addClass("glowing-border");
        return false;
   }
   if(grade==0){
        error=1;
        $("#drpGrade_"+id).addClass("glowing-border");
        return false;
   }
   if(warehouse==0){
         error=1;
        $("#drpWarehouse_"+id).addClass("glowing-border");
        return false;
   }
   if(group==0){
         error=1;
        $("#drpGroup_"+id).addClass("glowing-border");
        return false;
   }
   
   return true;
}
/**
 * @method updateMasterArea
 * @description Update Purchase Master Area.
 */
function updateMasterArea(){
   var basepath =  $("#basepath").val(); 
   var purchaseMasterId=$("#pMasterId").val();
   var purchaseType=$("#purchasetype").val();
   var auctionArea=$("#auctionArea").val();
   var purchaseInvoiceNumber=$("#taxinvoice").val();
   var invoiceDate=$("#taxinvoicedate").val();
   var saleNo=$("#salenumber").val();
   var saleDate=$("#saledate").val();
   var promptDate=$("#promtdate").val();
   var vendor=$("#vendor").val();
   
   if(validMaster()){
       
        $.ajax({
        url: basepath + "purchaseinvoice/updatePurchaseMasterData",
        type: 'post',
        data: {
            PurMasterId:purchaseMasterId,
            purchaseType:purchaseType,auctionarea:auctionArea,purchaseInvoiceNumber:purchaseInvoiceNumber,invoiceDate:invoiceDate,
            saleNo:saleNo,saleDate:saleDate,promptDate:promptDate,vendor:vendor
        },
        success: function(data) {
                    
            if(data==1){
               
                    $( "#dialog-Edit" ).dialog({
                                            resizable: false,
                                            height:140,
                                            modal: true,
                                            buttons: {
                                              "Ok": function() {
                                                  window.location.href = basepath+'purchaseinvoice/addPurchaseInvoice/id/'+purchaseMasterId;
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
            console.log(e.message);
        }
    });
       
   }
   
}

function validMaster(){
   var purchaseInvoiceNumber=$("#taxinvoice").val();
   var invoiceDate=$("#taxinvoicedate").val();
   var saleNo=$("#salenumber").val();
   var saleDate=$("#saledate").val();
   var promptDate=$("#promtdate").val();
   var vendor=$("#vendor").val();
   if(purchaseInvoiceNumber==""){
         $("#taxinvoice").addClass("glowing-border");
         return false;
   }
   if(invoiceDate==""){
       $("#taxinvoicedate").addClass("glowing-border");
       return false;
   }
   if(saleNo==""){
       $("#salenumber").addClass("glowing-border");
       return false;
   }
   if(saleDate==""){
       $("#saledate").addClass("glowing-border");
       return false;
   }
   if(promptDate==""){
       $("promtdate").addClass("glowing-border");
       return false;
   }
   if(vendor=="0"){
        $("promtdate").addClass("glowing-border");
       return false;
   }
   return true;
}
/**
 * @method checkDecimal
 * @param {type} obj
 * @returns {Boolean}
 * @description Check input value decimal or not.
 */
function checkDecimal(obj)
{
    var regex = new RegExp(/^\+?[0-9(),.-]+$/);
    if (obj.value.match(regex))
    {
        return true;
    }
    obj.value = "";
    return false;
}
/**
 * @method checkNumeric
 * @param {type} obj
 * @returns {Boolean}
 * @description Check input value int or not.
 */
function checkNumeric(obj)
{
   var regex = new RegExp(/^[0-9]+$/);
    if (obj.value.match(regex))
    {
        return true;
    }
    obj.value = "";
    return false;
}
/**
 * @method updateOtherChargesRoundoff
 * @param {type} mstId
 * @returns {boolean}
 * @description Other charges and roundoff update on edit.
 */
function updateOtherChargesRoundoff(mstId){
    var basepath =  $("#basepath").val(); 
    var otherCharges=0;
    var roundOff =0;
    var totalcost=0;
    otherCharges =parseFloat($("#txtOtherCharges").val()==""?0:$("#txtOtherCharges").val());
    roundOff = parseFloat(($("#txtRoundOff").val()==""?0:$("#txtRoundOff").val()));
    totalcost = parseFloat(($("#txtTotalPurchase").val()==""?0:$("#txtTotalPurchase").val()));
    
    if(mstId!=""){
         $.ajax({
        url: basepath + "purchaseinvoice/updateOtherandRoundOff",
        type: 'post',
        data: {
            PurMasterId:mstId,
            othercharge:otherCharges,roundoff:roundOff,totCost:totalcost
        },
        success: function(data) {
                    
            if(data==1){
               
                    $( "#othercharges-dialog" ).dialog({
                                            resizable: false,
                                            height:140,
                                            modal: true,
                                            buttons: {
                                              "Ok": function() {
                                                            window.location.href = basepath+'purchaseinvoice';
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
            console.log(e.message);
        }
    });
        
    }
}
/**
 * @method  getOtherChargesRoundOff
 * @returns {Boolean}
 * 
 */
function getOtherChargesRoundOff(){
   
    var finalCostofAllCost=0;
    var teaValuesTotal = 0;
    var finalBrokerage = 0;
    var finalServiceTax = 0;
    var finalVatAmount = 0;
    var finalCstAmount = 0;
    var finalStamp = 0;
    var otherCharges =0;
    var roundOff = 0;
    
    
    teaValuesTotal = parseFloat($("#txtTeaValue").val());
    finalBrokerage = parseFloat($("#txtBrokerageTotal").val()==""?0:$("#txtBrokerageTotal").val());
    finalServiceTax = parseFloat($("#txtServiceTax").val()==""?0:$("#txtServiceTax").val());
    finalVatAmount = parseFloat($("#txtVatTotal").val());
    finalCstAmount = parseFloat($("#txtCstTotal").val());
    finalStamp = parseFloat($("#txtStampTotal").val());
    otherCharges  = parseFloat($("#txtOtherCharges").val()==""?0:$("#txtOtherCharges").val());
    roundOff = parseFloat($("#txtRoundOff").val()==""||$("#txtRoundOff").val()=="-" ||$("#txtRoundOff").val()=="." || $("#txtRoundOff").val()=="-." ?0:$("#txtRoundOff").val());
    
    finalCostofAllCost  = parseFloat((teaValuesTotal+finalBrokerage+finalServiceTax+finalVatAmount+finalCstAmount+finalStamp+otherCharges)+parseFloat(roundOff));
    console.log(finalCostofAllCost);
    $("#txtTotalPurchase").val(finalCostofAllCost.toFixed(2));
    
    return false;
    
    
}

function getGrandWeight()
{
    //DtltotalWeight_241
   var totalGrandWeight=0;
   $(".dtlTotalWght").each(function() {
       
        var totalID = $(this).attr('id');
        var purDtlId = totalID.split('_');
        var id = purDtlId[1];
        var total = ($("#DtltotalWeight_" + id).val() == "" ? 0 : $("#DtltotalWeight_" + id).val());
        totalGrandWeight = parseFloat(totalGrandWeight + parseFloat(total));
        $("#txtGrandWeight").val(totalGrandWeight);
        console.log(totalGrandWeight);

   });
   
    return totalGrandWeight;
}

/*
 * @date 16-01-2016
 * @author Mithilesh
 */


  function TotalBags(dtlId){
    
    var tableId = "#tableNormal_" + dtlId + " tr";
    var sampleTableId = "#sampleBag_" + dtlId + " tr";

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
    
    $("#DtltotalBags_" + dtlId).val(totalNoOfBag);

    //console.log("totalBag :" + totalNoOfBag);
   // console.log("id :" + dtlId);
    $("#txtTotalBags").val(totalNoOfBag);
    return totalNoOfBag;
 } 
 
 
 function totalBagNo()
{
   var totalAllBag=0;
   $(".dtlTotalBags").each(function() {
        var totalID = $(this).attr('id');
        var purDtlId = totalID.split('_');
        var id = purDtlId[1];
        var total = ($("#DtltotalBags_" + id).val() == "" ? 0 : $("#DtltotalBags_" + id).val());
         totalAllBag = parseInt(total) + totalAllBag;
        $("#txtTotalBags").val(totalAllBag);
        console.log(totalAllBag);

   });
    return totalAllBag;
}
    