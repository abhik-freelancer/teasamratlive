/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(window).load(function () {
      hideForAuctionType();
});


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
       var dtNextWeek = new Date(taxinvoice);
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
        var promptdate = new Date(taxinvoice);
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
    
   
    $("#purchasetype").change(function(){
        if($('option:selected', this).val()!="AS"){
            $("#auctionArea").attr("disabled", 'disabled');
            $("#auctionArea").val("0");
            $("#transp_label").css("display","block");
            $("#transporterid").css("display","block");
            $("#challan_block").css("display","table-row");
        }else{
            $("#auctionArea").removeAttr('disabled');
             $("#transp_label").css("display","none");
             $("#transporterid").css("display","none");
             $("#challan_block").css("display","none");
            
        }
        
    });
    
     $(document).on('change', "#auctionArea", function() {
          var transcost = 0; 
        transcost = $("#transCostPrice").val();
       getTransCost();
    });
    
    $(document).on('focusout', "#auctionArea", function() {
      var  transcost = $("#transCostPrice").val();
      $(".transCost").val(transcost);
      //alert(transcost);
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
                gstTaxableAmount(purchase_dtl_id);
                getNetamount(purchase_dtl_id);
                
                TotalBags(purchase_dtl_id);
                
                totalBagNo();
                
                });
     });

   
     
    $(".price").keyup(function(){
        this.value = this.value.replace(/[^0-9\.]/g,'');
        var priceid= $(this).attr('id');
        var purDtlId = priceid.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        gstTaxableAmount(purchase_dtl_id);
        getNetamount(purchase_dtl_id);
        getCostOfTeaPrKg(purchase_dtl_id);
        
        
    });


    
    $(".txtNumOfNormalBag").keyup(function(){
        var NumOfNormalBagId=$(this).attr('id');
        var purDtlId = NumOfNormalBagId.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        gstTaxableAmount(purchase_dtl_id);
        getNetamount(purchase_dtl_id);
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
        
       TotalBags(purchase_dtl_id);
       gstTaxableAmount(purchase_dtl_id);
       getNetamount(purchase_dtl_id);
       totalBagNo()
        
    });
    
     $(document).on('keyup', ".txtNumOfSampleBag", function() {
        var NumOfSampleBagId=$(this).attr('id');
        var purDtlId = NumOfSampleBagId.split('_');
        var purchase_dtl_id =purDtlId[1];
        TotalBags(purchase_dtl_id);
        gstTaxableAmount(purchase_dtl_id);
        getNetamount(purchase_dtl_id);
        getCostOfTeaPrKg(purchase_dtl_id);
        totalBagNo();
    });
 
     
     
     
    
    $(".txtNumOfNormalNet").keyup(function(){
        var NumOfNormalNetId=$(this).attr('id');
        var purDtlId = NumOfNormalNetId.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        gstTaxableAmount(purchase_dtl_id)
        getNetamount(purchase_dtl_id);
        getCostOfTeaPrKg(purchase_dtl_id);
        getGrandWeight();
        
    });
    
    $(document).on('keyup', ".txtNumOfSampleBag", function() {
        var NumOfSampleBagId=$(this).attr('id');
        var purDtlId = NumOfSampleBagId.split('_');
        var purchase_dtl_id =purDtlId[1];
        //console.log("no of smplebag :"+purchase_dtl_id);
        getTotalTeaValue(purchase_dtl_id);
        gstTaxableAmount(purchase_dtl_id);
        getNetamount(purchase_dtl_id);
        getGrandWeight();
    });
    
     $(document).on('keyup', ".txtNumOfSampleNet", function() {
        var NumOfSampleNetId=$(this).attr('id');
        var purDtlId = NumOfSampleNetId.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        gstTaxableAmount(purchase_dtl_id);
        getNetamount(purchase_dtl_id);
        getCostOfTeaPrKg(purchase_dtl_id);
        getGrandWeight();
    });
    
     $(document).on('click', ".txtNumOfSampleNet", function() {
        var NumOfSampleNetId=$(this).attr('id');
        var purDtlId = NumOfSampleNetId.split('_');
        var purchase_dtl_id =purDtlId[1];
        getTotalTeaValue(purchase_dtl_id);
        gstTaxableAmount(purchase_dtl_id);
        getNetamount(purchase_dtl_id);
        getGrandWeight();
    });
    
    $(document).on('blur',".DtlDiscount",function(){
        var selectid=$(this).attr("id");
        var purDtlId = selectid.split('_');
        var purchase_dtl_id =purDtlId[1];
        gstTaxableAmount(purchase_dtl_id);
        getNetamount(purchase_dtl_id);
    });
    
    /******************************************************************************/
$(document).on('change','.cgst',function(){
    console.log($(this).attr("id"));
    var cgstRateId = $(this).val();
    var amt = getGSTTaxAmount(cgstRateId,$(this).attr("id"),"CGST");
    var arr = $(this).attr("id").toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#cgstAmt"+"_"+masterId+"_"+detailId);
    $(str2).val(amt.toFixed(2));
    //getTotalCGST();
    getNetamount(detailId);
});

//sgst
$(document).on('change','.sgst',function(){
    console.log($(this).attr("id"));
    var sgstRateId = $(this).val();
    var amt = getGSTTaxAmount(sgstRateId,$(this).attr("id"),"SGST");
    var arr = $(this).attr("id").toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#sgstAmt"+"_"+masterId+"_"+detailId);
    $(str2).val(amt.toFixed(2));
    //getTotalSGST();
    getNetamount(detailId);
});

//IGST
$(document).on('change','.igst',function(){
    console.log($(this).attr("id"));
    var igstRateId = $(this).val();
    var amt = getGSTTaxAmount(igstRateId,$(this).attr("id"),"IGST");
    var arr = $(this).attr("id").toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#igstAmt"+"_"+masterId+"_"+detailId);
    $(str2).val(amt.toFixed(2));
       // getTotalIGST();
     //DtlGlobalFunction(detailId);
     getNetamount(detailId);
});

   
    
  
  //adding new purchsae details
  $("#addnewDtl").click(function(){
    
      var pMastId=$("#pMasterId").val();
      var cost_trans = $("#transCostPrice").val();
      if(pMastId!=''){
      window.location.href = basepath+'purchaseinvoice/addPurchaseDetails/masterId/'+pMastId+'/cost_trans/'+cost_trans;
    }
  });
  
   

  
});
/***********************************************************************************************************************/
/*****************************************************User Defined Function*********************************************/
function getNetamount(puDtId){
    var taxable = 0;
    var cgstamt =0;
    var sgstamt =0;
    var igstamt = 0;
    var netamount=0;
    
    taxable = $("#DtlTaxableValue_"+puDtId).val()||0;
    cgstamt = $("#cgstAmt_0_"+puDtId).val()||0;
    sgstamt = $("#sgstAmt_0_"+puDtId).val()||0;
    igstamt = $("#igstAmt_0_"+puDtId).val()||0;
    
    netamount = parseFloat(taxable)+parseFloat(cgstamt)+parseFloat(sgstamt)+parseFloat(igstamt);
    $("#txtdtlnetamount_"+puDtId).val(netamount.toFixed(2));
    return  netamount;
    
}
function gstTaxableAmount(id){
    var teavalue=0;
    var discount=0;
    var taxableamount=0;
    teavalue = $("#DtltotalValue_"+id).val()||0;
    discount = $("#DtlDiscountValue_"+id).val()||0;
    taxableamount = parseFloat(teavalue) - parseFloat(discount);
    
    $("#DtlTaxableValue_"+id).val(taxableamount.toFixed(2));
    return taxableamount.toFixed(2);
}

function getGSTTaxAmount(gstId,jQueryId,type){
    var gstRateId = gstId;
    var arr = jQueryId.toString().split("_");
    var masterId =arr[1];
    var detailId = arr[2]; 
    var str2 = ("#DtlTaxableValue_"+detailId);
    var taxableAmount = $(str2).val()||0;
    var basepath = $("#basepath").val();
    
    var taxAmount = 0;
    
    $.ajax({
            url :  basepath + "gstpurchaseinvoice/getAmount",
            type: "POST",
            dataType:'json',
            data : {gstId:gstRateId,taxableamount:taxableAmount,type:type},
    success: function(result) {
       
      taxAmount =result.amt ;
    },
    async:false
  });
    
   
   return taxAmount;  
    
}

function hideForAuctionType(){
   // alert("test");
    var purchasetype = $("#purchasetype").val();
    if(purchasetype=="AS"){
        $("#transp_label").css("display","none");
        $("#transporterid").css("display","none");
        $("#challan_block").css("display","none");
         $("#auctionArea").removeAttr('disabled');
    }
    else{
          $("#auctionArea").attr("disabled", 'disabled');
        $("#transp_label").css("display","block");
        $("#transporterid").css("display","block");
       $("#challan_block").css("display","table-row");
    }
}


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
    totalTeaCost = parseFloat(teaTotalPrice.toFixed(2))
    $("#DtltotalValue_"+puDtId).val(totalTeaCost);
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
    return totalQtyOfBags;
}


function getCostOfTeaPrKg(prdtlId){
    var price = 0;
    var totalWeight = 0;
    var totalTeaPrice = 0;
    var teaCostPrKg = 0;
    price = ($('#txtPrice_' + prdtlId).val() == "" ? 0 : $('#txtPrice_' + prdtlId).val());
    totalWeight = getNumberofBagQty(prdtlId);
    if (totalWeight != 0) {

        totalTeaPrice = (parseFloat(totalWeight) * parseFloat(price));
        teaCostPrKg = totalTeaPrice / parseFloat(totalWeight);
        $("#DtlteaCost_" + prdtlId).val(teaCostPrKg.toFixed(2));
    }
    else {
        $("#DtlteaCost_" + prdtlId).val('0.00');
    }
    return teaCostPrKg.toFixed(2);
}



/**
 * 
 * @param {type} purchaseDtlId
 * @returns {undefined}
 * // vendorid for voucherdetail on 31.05.2016
 * // voucher_master_id on 31.05.2016-- By Mithilesh
 * To Do 26-09-2016
 */
function updatePurDtl(purchaseDtlId){
   
    var basepath =  $("#basepath").val();
    var voucherMastId = $("#voucherMasterId").val();
    var vendorId = $("#vendor").val();
    var LotNumber;
    var doNumber;
    var doDate;
    var invoiceNumber;
    var gross;
    var gpNumber,gpDate,price,group,location,garden,grade,warehouse,numberOfNormalBag,normalBagQty,normalchest,normalBagId;
    var cgstid,sgstid,igstid,cgstamt,sgstamt,igstamt;
    var  totalWeight,totalValue,discount,taxable,netamount,teaCostPrKg,totalbags;
    
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
        gpNumber =$("#txtGpnumber_"+purchaseDtlId).val();
        gpDate = $("#txtGpDate_"+purchaseDtlId).val();
        price =$("#txtPrice_"+purchaseDtlId).val();
        group =$("#drpGroup_"+purchaseDtlId).val();
        location=$("#drpLocation_"+purchaseDtlId).val();
        garden=$("#drpGarden_"+purchaseDtlId).val();
        grade=$("#drpGrade_"+purchaseDtlId).val();
        warehouse=$("#drpWarehouse_"+purchaseDtlId).val();
        normalBagId =$("#txtNormalBagid_"+purchaseDtlId).val();
        numberOfNormalBag=$("#txtNumOfNormalBag_"+purchaseDtlId).val();
        normalBagQty=$("#txtNumOfNormalNet_"+purchaseDtlId).val();
        normalchest=$("#txtNumOfNormalChess_"+purchaseDtlId).val();
       
        discount = $("#DtlDiscountValue_"+purchaseDtlId).val()||0;
        taxable =$("#DtlTaxableValue_"+purchaseDtlId).val()||0;
        cgstid = $("#cgst_0_"+purchaseDtlId).val()||0;
        cgstamt = $("#cgstAmt_0_"+purchaseDtlId).val()||0;
        sgstid = $("#sgst_0_"+purchaseDtlId).val()||0;
        sgstamt = $("#sgstAmt_0_"+purchaseDtlId).val()||0;
        igstid = $("#igst_0_"+purchaseDtlId).val()||0;
        igstamt = $("#igstAmt_0_"+purchaseDtlId).val()||0;
        netamount = $("#txtdtlnetamount_"+purchaseDtlId).val()||0;
        
       
       
        
        totalWeight = $("#DtltotalWeight_"+purchaseDtlId).val();
        totalValue = $("#DtltotalValue_"+purchaseDtlId).val();
        teaCostPrKg = $("#DtlteaCost_"+purchaseDtlId).val();
        totalbags=$("#DtltotalBags_"+purchaseDtlId).val()||0;
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
        url: basepath + "gstpurchaseinvoice/updatePurchaseDetail",
        type: 'post',
        data: {
            PurchaseMasterId:PurchaseMasterId,voucherMastId:voucherMastId,vendorId:vendorId,
            purchaseDetailId:purchaseDtlId,lotnumber:LotNumber,doNumber:doNumber,
            doDate:doDate,invoice:invoiceNumber,gross:gross,
            GPnumber:gpNumber,gpDate:gpDate,price:price,group:group,location:location,
            garden:garden,grade:grade,warehouse:warehouse,normalBagId:normalBagId,
            NormalBags:numberOfNormalBag,NormalBagQtys:normalBagQty,normalBagChest:normalchest,
            sampleBags:sampleBagData,totalWeight:totalWeight,teaCostPrKg:teaCostPrKg,totalDtlCost:totalValue
            ,discount:discount,taxable:taxable,cgstid:cgstid,cgstamt:cgstamt,sgstid:sgstid,sgstamt:sgstamt,
            igstid:igstid,igstamt:igstamt,netamount:netamount
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
                                                  window.location.href = basepath+'gstpurchaseinvoice/addPurchaseInvoice/id/'+PurchaseMasterId;
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
    var transporterid;
    var challanno;
    var challanDt; 
  
   var basepath =  $("#basepath").val(); 
   var purchaseMasterId=$("#pMasterId").val();
   var voucherMastId=$("#voucherMasterId").val();
   var purchaseType=$("#purchasetype").val();
   var auctionArea=$("#auctionArea").val();
   var purchaseInvoiceNumber=$("#taxinvoice").val();
   var invoiceDate=$("#taxinvoicedate").val();
   var saleNo=$("#salenumber").val();
   var saleDate=$("#saledate").val();
   var promptDate=$("#promtdate").val();
   var vendor=$("#vendor").val();
   var cnNo = $("#cnNo").val();
   var HSN = $("#txtHSN").val();
   
  /* var transporterid = $("#transporterid").val();
   var challanno = $("#challanNo").val();
   var challanDt = $("#challanDate").val();*/
   
   if(purchaseType=="AS"){
       transporterid=0;
       challanno="";
       challanDt="";
   }
   else{
    transporterid = $("#transporterid").val();
    challanno = $("#challanNo").val();
    challanDt = $("#challanDate").val();
   }
   
   if(validMaster()){
       
        $.ajax({
        url: basepath + "gstpurchaseinvoice/updatePurchaseMasterData",
        type: 'post',
        data: {
            PurMasterId:purchaseMasterId,voucherMastId:voucherMastId,
            purchaseType:purchaseType,auctionarea:auctionArea,purchaseInvoiceNumber:purchaseInvoiceNumber,invoiceDate:invoiceDate,
            saleNo:saleNo,saleDate:saleDate,promptDate:promptDate,vendor:vendor,cnNo:cnNo,transporterid:transporterid,
            challanno:challanno,challanDt:challanDt,HSN:HSN
        },
        success: function(data) {
                    
            if(data==1){
               
                    $( "#dialog-Edit" ).dialog({
                                            resizable: false,
                                            height:140,
                                            modal: true,
                                            buttons: {
                                              "Ok": function() {
                                                  window.location.href = basepath+'gstpurchaseinvoice/addPurchaseInvoice/id/'+purchaseMasterId;
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
    var voucherMastId = $("#voucherMasterId").val();
    var vendor = $("#vendor").val();
    
    var roundOff =0;
    var totalcost=0;
   
    roundOff = parseFloat(($("#txtRoundOff").val()==""?0:$("#txtRoundOff").val()));
    totalcost = parseFloat(($("#txtTotalPurchase").val()==""?0:$("#txtTotalPurchase").val()));
    
    if(mstId!=""){
         $.ajax({
        url: basepath + "gstpurchaseinvoice/updateOtherandRoundOff",
        type: 'post',
        data: {
            PurMasterId:mstId,voucherMastId:voucherMastId,vendor:vendor,
            roundoff:roundOff,totCost:totalcost
        },
        success: function(data) {
                    
            if(data==1){
               
                    $( "#othercharges-dialog" ).dialog({
                                            resizable: false,
                                            height:140,
                                            modal: true,
                                            buttons: {
                                              "Ok": function() {
                                                            window.location.href = basepath+'gstpurchaseinvoice';
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
    var finalTbCharg = 0;
    var otherCharges =0;
    var roundOff = 0;
    
    
    teaValuesTotal = parseFloat($("#txtTeaValue").val());
    finalBrokerage = parseFloat($("#txtBrokerageTotal").val()==""?0:$("#txtBrokerageTotal").val());
    finalServiceTax = parseFloat($("#txtServiceTax").val()==""?0:$("#txtServiceTax").val());
    finalVatAmount = parseFloat($("#txtVatTotal").val());
    finalCstAmount = parseFloat($("#txtCstTotal").val());
    finalStamp = parseFloat($("#txtStampTotal").val());
    finalTbCharg = parseFloat($("#txtTotalTBchargrs").val());
    otherCharges  = parseFloat($("#txtOtherCharges").val()==""?0:$("#txtOtherCharges").val());
    roundOff = parseFloat($("#txtRoundOff").val()==""||$("#txtRoundOff").val()=="-" ||$("#txtRoundOff").val()=="." || $("#txtRoundOff").val()=="-." ?0:$("#txtRoundOff").val());
    
    finalCostofAllCost  = parseFloat((teaValuesTotal+finalBrokerage+finalServiceTax+finalVatAmount+finalCstAmount+finalStamp+finalTbCharg+otherCharges)+parseFloat(roundOff));
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
        $("#txtGrandWeight").val(totalGrandWeight.toFixed(2));
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
    