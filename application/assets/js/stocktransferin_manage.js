/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
     $( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
    $( ".stocktransferin").addClass( " active " );
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

  
  
    $( ".accordion" ).accordion({
        collapsible: true,
        heightStyle: "content" 

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
    
    
    
   
  //adding new purchsae details
  $("#addnewDtl").click(function(){
      var pMastId=$("#pMasterId").val();
    
      if(pMastId!=''){
      window.location.href = basepath+'stocktransferin/addPurchaseDetails/masterId/'+pMastId;
    }
  });
  
  $("#txtOtherCharges").keyup(function(){
        getOtherChargesRoundOff();
  });
  
  $("#txtRoundOff").keyup(function(){
        getOtherChargesRoundOff();
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


function getTransCost(){
    var auctionareaId = $("#auctionArea").val();
    var basepath = $("#basepath").val();
    
      $.ajax({
                    type: "POST",
                    url: basepath + "purchaseinvoice/getTransportationCost",
                    dataType:'json',
                    data: {auctionareaId:auctionareaId},
                    success: function(data)
                    {
                        $("#transCostPrice").val(data.trans_cost);
                        
                    }

                });

    
}



function getTotalTeaValue(puDtId){
    var totalTeaCost=0;
    var teaTotalPrice=0;
   
    teaTotalPrice = getTeaTotalPrice(puDtId);
    totalTeaCost = (parseFloat(teaTotalPrice)).toFixed(2);
    $("#DtltotalValue_"+puDtId).val(totalTeaCost);
   
    //console.log("totalTeaCost :"+totalTeaCost);
    return totalTeaCost;
    
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
   
    var price = 0 ;
    var transPortCost = 0;
    var totalWeight = 0;
   
    var totalTeaPrice= 0 ;
    var teaCost = 0;
    var teaCostPrKg = 0;
    
  
    transPortCost = ($('#transCost_' + prdtlId).val() == '' ? 0 : $('#transCost_' + prdtlId).val());
    price = ($('#txtPrice_' + prdtlId).val() == "" ? 0 : $('#txtPrice_' + prdtlId).val());
    totalWeight = getNumberofBagQty(prdtlId);
        if(totalWeight!=0){
   
    totalTeaPrice = (parseFloat(totalWeight) * parseFloat(price));
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
    var gross;
    var price,transPortCost,group,location,garden,grade,warehouse,numberOfNormalBag,normalBagQty,normalchest,normalBagId;
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
      
        gross = $("#txtGross_"+purchaseDtlId).val();
        
        
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
        url: basepath + "stocktransferin/updatePurchaseDetail",
        type: 'post',
        data: {
            PurchaseMasterId:PurchaseMasterId,
            purchaseDetailId:purchaseDtlId,
            lotnumber:LotNumber,
            doNumber:doNumber,
            doDate:doDate,
            invoice:invoiceNumber,
            gross:gross,
            price:price,
            transPortCost:transPortCost,
            group:group,
            location:location,
            garden:garden,
            grade:grade,
            warehouse:warehouse,
            normalBagId:normalBagId,
            NormalBags:numberOfNormalBag,
            NormalBagQtys:normalBagQty,
            normalBagChest:normalchest,
            sampleBags:sampleBagData,
            totalWeight:totalWeight,
            teaCostPrKg:teaCostPrKg,
            totalDtlCost:totalValue
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
                                                  window.location.href = basepath+'stocktransferin/addPurchaseInvoice/id/'+PurchaseMasterId;
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
    var location =$("#drpLocation_"+id).val();
   
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
   if(location==0){
       error=1;
       $("#drpLocation_"+id).addClass("glowing-border");
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
  // var auctionArea=$("#auctionArea").val();
   var refrenceNo=$("#refrence_no").val();
   
   var receiptDate=$("#receiptDt").val();
   //var saleNo=$("#salenumber").val();
  // var saleDate=$("#saledate").val();
   var transferDt=$("#transferDt").val();
   var vendor=$("#vendor").val();
   var cnNo = $("#cnNo").val();
   var transporterid = $("#transporterid").val();
   var challanNo = $("#challanNo").val();
   
   if(validMaster()){
       
        $.ajax({
        url: basepath + "stocktransferin/updatePurchaseMasterData",
        type: 'post',
        data: {
            PurMasterId:purchaseMasterId,
            purchaseType:purchaseType,
            refrenceNo:refrenceNo,
            receiptDate:receiptDate,
            transferDt:transferDt,
            vendor:vendor,
            cnNo:cnNo,
            transporterid:transporterid,
            challanNo:challanNo
            
        },
        success: function(data) {
                    
            if(data==1){
               
                    $( "#dialog-Edit" ).dialog({
                                            resizable: false,
                                            height:140,
                                            modal: true,
                                            buttons: {
                                              "Ok": function() {
                                                  window.location.href = basepath+'stocktransferin/addPurchaseInvoice/id/'+purchaseMasterId;
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
   var refrenceNo=$("#refrence_no").val();
   var receiptDate=$("#receiptDt").val();
   var transferDt=$("#transferDt").val();
   var vendor=$("#vendor").val();
   
   if(refrenceNo==""){
         $("#refrence_no").addClass("glowing-border");
         return false;
   }
  if(transferDt==""){
       $("#transferDt").addClass("glowing-border");
       return false;
   }
   if(receiptDate==""){
       $("#receiptDt").addClass("glowing-border");
       return false;
   }
   if(vendor=="0"){
        $("#vendor").addClass("glowing-border");
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
  /*  finalBrokerage = parseFloat($("#txtBrokerageTotal").val()==""?0:$("#txtBrokerageTotal").val());
    finalServiceTax = parseFloat($("#txtServiceTax").val()==""?0:$("#txtServiceTax").val());
    finalVatAmount = parseFloat($("#txtVatTotal").val());
    finalCstAmount = parseFloat($("#txtCstTotal").val());
    finalStamp = parseFloat($("#txtStampTotal").val());
    otherCharges  = parseFloat($("#txtOtherCharges").val()==""?0:$("#txtOtherCharges").val());
    roundOff = parseFloat($("#txtRoundOff").val()==""||$("#txtRoundOff").val()=="-" ||$("#txtRoundOff").val()=="." || $("#txtRoundOff").val()=="-." ?0:$("#txtRoundOff").val());
    */
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
    