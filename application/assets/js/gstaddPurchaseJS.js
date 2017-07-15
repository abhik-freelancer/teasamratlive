/* 
 * for adding purchase
 * 28/08/2015
 * 
 */
jQuery(window).load(function () {
    hideForAuctionType();
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
$(document).ready(function() {
    $( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
    $( ".purchaseinvoice").addClass( " active " );
    
    var basepath = $("#basepath").val();
    var sampleBagRow = 1;
    var divNumber = 1;
    var purchaseType ='';


    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;



    $("#startdate").val(mindate);
    $("#enddate").val(maxDate);
        $("#vendor").customselect();

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
    
    

  /*@date for invoice,saledate,promptdate
 * @date 14-01-2016
 * @author Mithilesh
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
    
     //purchase type check.
     $("#purchasetype").change(function() {
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
       getTransCost();
    });
      
   
     //purchase type check.
     
    $("#addnewDtlDiv").click(function() {
        
        
        purchaseType = $("#purchasetype").val();
     var  transcost = $("#transCostPrice").val();
      //  alert(transcost);
   //  exit;
        $.ajax({
            url: basepath + "gstpurchaseinvoice/createDetails",
            type: 'post',
            data: {divNumber: divNumber,purType:purchaseType,transcost:transcost
            },
            success: function(data) {
                $("#detailDiv").append(data);

            },
            complete: function() {
            },
            error: function(e) {
                //called when there is an error
                //console.log(e.message);
            }
        });
        divNumber++;
    });


    $(document).on('click', ".plus", function() {
        var id_img = $(this).attr("id");
        var divno = id_img.split('_');
        var idnum = divno[1];
        $("#dtlDiv_" + idnum).toggle();
    });
    $(document).on('click',".divdel",function(){
        var id_img = $(this).attr("id");
        var divno = id_img.split('_');
        var idnum = divno[1];
        $("#purchaseDtl_" + idnum).remove();
        DtlGlobalFunction(idnum);
    });
    
    
    /**
     * //adding new sample bag
     */

    $(document).on('click', ".samplebag", function() {
        var Dtlid = $(this).attr('id');
        var divno = Dtlid.split('_');
        var idnum = divno[1];
        //alert(purDtlid);
        var tableId = "#sampleBag_" + idnum + " tr:last";
        //alert(tableId);
        var newRow = '<tr id="row_' + idnum + '_' + sampleBagRow + '">' +
                '<td>' +
                '<input type="hidden" id="txtSampleBagid_' + idnum + '_0" name="txtSampleBagid[]" value=""/>' +
                '<input type="hidden" id="txtSampleBagTypeId_' + idnum + '_0" name="txtSampleBagTypeId" value="2"/>' +
                '<img src="' + basepath + 'application/assets/images/delete-ab.png" title="Delete" alt="Delete" class="removeRow" id="' + idnum + '_' + sampleBagRow + '" style="cursor: pointer; cursor: hand;"/>' +
                '</td>' +
                '<td>' +
                '<input type="text" id="txtNumOfSampleBag_' + idnum + '_0" name="txtNumOfSampleBag_' + idnum + '[]" class="txtNumOfSampleBag" value=""/>[Bags]</td>' +
                '<td>' +
                '<input type="text" id="txtNumOfSampleNet_' + idnum + '_0" name="txtNumOfSampleNet_' + idnum + '[]" class="txtNumOfSampleNet" value=""/>[Kgs/bag]</td>' +
                '<td><input type="text" id="txtNumOfSampleChess_' + idnum + '_0" name="txtNumOfSampleChess_' + idnum + '[]" class="txtNumOfSampleChess" value=""/></td>' +
                '</tr>';


        $(tableId).after(newRow);
        sampleBagRow++;

    
       $(document).on('click', ".removeRow", function() {
          
            var delRowId = $(this).attr('id');
            var rowNumber = "#row_" + delRowId;
            var priceid = $(this).attr('id');
            var purDtlId = priceid.split('_');
            var purchase_dtl_id = purDtlId[0];
            $(rowNumber).remove();
            
            DtlGlobalFunction(purchase_dtl_id);
        
            
            

        });
    });
    //adding new sample bag

    $(document).on('focus', '.datepicker', function() {
        $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy',
            minDate: mindate,
            maxDate: maxDate
        });
    });





    $(document).on('click', ".optionRateType", function() {
        var radioId = $(this).attr('id');
        var purDtlId = radioId.split('_');
        var purchase_dtl_id = purDtlId[1];

        if ($("#rdRateTypeVat_" + purchase_dtl_id).is(":checked")) { // check if the radio is checked
            //var val = $(this).val(); // retrieve the value
            $("#vatDiv_" + purchase_dtl_id).css("display", "block");
            $("#cstDiv_" + purchase_dtl_id).css("display", "none");
        }
        if ($("#rdRateTypeCST_" + purchase_dtl_id).is(":checked")) { // check if the radio is checked
            //var val = $(this).val(); // retrieve the value
            $("#vatDiv_" + purchase_dtl_id).css("display", "none");
            $("#cstDiv_" + purchase_dtl_id).css("display", "block");
        }

        //console.log(radioId);
    });
    //form control event//


    $(document).on('focus', ".clsstamp", function() {

        $('.clsstamp').keyup(function() {
            var priceid = $(this).attr('id');
            var purDtlId = priceid.split('_');
            var purchase_dtl_id = purDtlId[1];
            console.log("clsstamp :" + purchase_dtl_id);
            //getTotalTeaValue(purchase_dtl_id);
            DtlGlobalFunction(purchase_dtl_id);

        });


    });


    $(document).on('focus', ".price", function() {

        $('.price').keyup(function() {
            var priceid = $(this).attr('id');
            var purDtlId = priceid.split('_');
            var purchase_dtl_id = purDtlId[1];
            console.log("price :" + purchase_dtl_id);
           DtlGlobalFunction(purchase_dtl_id);

        });


    });
  //  transCost
  //  getTransCost
  
    $(document).on('focus', ".transCost", function() {

        $('.transCost').keyup(function() {
            var priceid = $(this).attr('id');
            var purDtlId = priceid.split('_');
            var purchase_dtl_id = purDtlId[1];
            console.log("transCost :" + purchase_dtl_id);
           DtlGlobalFunction(purchase_dtl_id);

        });


    });
    //Tb Charges added here 26/09/2016
    
    $(document).on('keyup',".txtTbCharges",function(){
        this.value = this.value.replace(/[^0-9\.]/g,'');
        
        var txtTbChrgId = $(this).attr('id');
        var purDtlId = txtTbChrgId.split('_');
        var purchase_dtl_id = purDtlId[1];
         DtlGlobalFunction(purchase_dtl_id);
    });


    $(document).on('focus', ".DtlDiscount", function() {
  
        $('.DtlDiscount').keyup(function() {
             this.value = this.value.replace(/[^0-9\.]/g,'');
            var brokerageid = $(this).attr('id');
            var purDtlId = brokerageid.split('_');
            var purchase_dtl_id = purDtlId[1];
            DtlGlobalFunction(purchase_dtl_id);
            

        });

    });

    //Normal bag event handler//

    $(document).on('focus', ".txtNumOfNormalBag", function() {

        $('.txtNumOfNormalBag').keyup(function() {
            var NumOfNormalBagId = $(this).attr('id');
            var purDtlId = NumOfNormalBagId.split('_');
            var purchase_dtl_id = purDtlId[1];
            
            DtlGlobalFunction(purchase_dtl_id);

        });

    });


    $(document).on('focus', ".txtNumOfNormalNet", function() {
        $('.txtNumOfNormalNet').keyup(function() {
            var NumOfNormalNetId = $(this).attr('id');
            var purDtlId = NumOfNormalNetId.split('_');
            var purchase_dtl_id = purDtlId[1];
            
            DtlGlobalFunction(purchase_dtl_id);

        });
    });
    //Normal bag event handler//

    //***************************Samplebag Event*******************************//
    $(document).on('focus', ".txtNumOfSampleBag", function() {
        $('.txtNumOfSampleBag').keyup(function() {
            var NumOfSampleBagId = $(this).attr('id');
            var purDtlId = NumOfSampleBagId.split('_');
            var purchase_dtl_id = purDtlId[1];
            
           DtlGlobalFunction(purchase_dtl_id);
         

        });
    });

    $(document).on('focus', ".txtNumOfSampleNet", function() {
        $(".txtNumOfSampleNet").keyup(function() {
            var NumOfSampleNetId = $(this).attr('id');
            var purDtlId = NumOfSampleNetId.split('_');
            var purchase_dtl_id = purDtlId[1];
            
            DtlGlobalFunction(purchase_dtl_id);
            

        });
    });


    //***************************Samplebag Event*******************************// 



    $(document).on('focus', ".drpVatRate", function() {

        $('.drpVatRate').change(function() {
            var vatSelId = $(this).attr('id');
            var purDtlId = vatSelId.split('_');
            var purchase_dtl_id = purDtlId[1];
            DtlGlobalFunction(purchase_dtl_id);

        });

    });


    $(document).on('focus', ".drpCSTRate", function() {

        $('.drpCSTRate').change(function() {
            var cstSelId = $(this).attr('id');
            var purDtlId = cstSelId.split('_');
            var purchase_dtl_id = purDtlId[1];
            DtlGlobalFunction(purchase_dtl_id);

        });

    });

    $(document).on('focus', ".drpServiceTax", function() {
        $('.drpServiceTax').change(function() {
            var srvcSelId = $(this).attr('id');
            var purDtlId = srvcSelId.split('_');
            var purchase_dtl_id = purDtlId[1];
            DtlGlobalFunction(purchase_dtl_id);

        });
    });

   /* $("#txtBrokerageTotal").keyup(function(){
        allTotalOfCost() ; //call for other charges
        
    });

    $("#txtServiceTax").keyup(function(){
        allTotalOfCost() ; //call for other charges
        
    });*/

    
    $("#txtOtherCharges").change(function(){
        allTotalOfCost() ; //call for other charges
        
    });
    
    /*@date 14-01-2016
     * @author Mithilesh
     * 
     */
    /* $("#txtTotalBags").change(function(){
        totalNoOfBags() ; //call for other charges
        
    });*/
    $("#txtRoundOff").change(function(){
        allTotalOfCost() ; //call for other charges
    });

// save data on add purchase [02/09/2015]
    $('#savePurchase').click(function() {
        //  e.preventDefault();
        if (divNumber == 1) {
            
            $("#dialog-new-add").dialog({
                    resizable: false,
                    height: 140,
                    modal: true,
                    buttons: {
                        "Ok": function() {
                            $(this).dialog("close");
                        }
                    }
                });
        } else {
            
        if (validationDetails()) {
                
                var formData=$('#frmPurchase').serialize();
               // var formData=$('#frmPurchase').serializeArray();
                formData = decodeURI(formData);
                //console.log(decodeURI(formData));
              $("#savePurchase").css("display","none");
           
  
                $.ajax(
                        {
                            type: 'POST',
                            dataType : 'json',
                            url: basepath + "gstpurchaseinvoice/insertNewPurchaseInvoice",
                            data: {formDatas:formData},
                            success: function(data) {
                                
                                if(data==1){
                                     $( "#dialog-new-save" ).dialog({
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
                                }else{
                                    $("#dialog-error-save").dialog({
                                                        resizable: false,
                                                        height: 140,
                                                        modal: true,
                                                        buttons: {
                                                            "Ok": function() {
                                                                $(this).dialog("close");
                                                                 $("#savePurchase").css("display","block");
                                                            }
                                                        }
                                                    });
                                }
                            },
                            complete: function() {
                            },
                            error: function(e) {
                                //called when there is an error
                                console.log(e.message);
                            }
                        });

            } else {

                $("#dialog-new-add").dialog({
                    resizable: false,
                    height: 140,
                    modal: true,
                    buttons: {
                        "Ok": function() {
                            $(this).dialog("close");
                           $("#savePurchase").css("display","block");
                        }
                    }
                });
            }
          
            
        }//else confirm
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
    DtlGlobalFunction(detailId);
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
    DtlGlobalFunction(detailId);
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
     DtlGlobalFunction(detailId);
});









    //document on load
});

/***********************************************************************************************************************/
/*****************************************************User Defined Function 28/08/2015 to do*********************************************/

function hideForAuctionType(){
 
    var purchasetype = $("#purchasetype").val();
    if(purchasetype=="AS"){
        $("#transp_label").css("display","none");
        $("#transporterid").css("display","none");
        $("#challan_block").css("display","none");
    }
    else{
        $("#transp_label").css("display","block");
        $("#transporterid").css("display","block");
       $("#challan_block").css("display","table-row");
    }
}

// By Mithilesh --23.04.2016

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

/**
 * 
 * @param {type} ctlID
 * @returns {Boolean}
 * @description All function in detail section will be call here
 */
function DtlGlobalFunction(ctlID){
    TotalWeightPerDtl(ctlID);
    TotalBags(ctlID);
    getTeaCostPerKg(ctlID)
    DetailTeaCost(ctlID);
    gstTaxableAmount(ctlID);
    getNetamount(ctlID);
    allTotalOfCost();
    totalCGSTValue();
    totalSGSTValue();
    totalIGSTValue();
    totalGSTincludedAmount();
    getGrandWeight();
    totalBagNo();
    return false;
}


/**
 * 
 * @param {type} dtlId
 * @returns Total bag weight in Kgs [text:DtltotalWeight]
 */
function TotalWeightPerDtl(dtlId){
    
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
    
    $("#DtltotalWeight_" + dtlId).val(totalQtyOfBags);

    //console.log("totalWeight :" + totalQtyOfBags);
   // console.log("id :" + dtlId);

    return totalQtyOfBags;
    
}
/*
 * @date 14-01-2016
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


/**
 * @method TotalTeaPricePerDtl
 * @returns peice X weight perDetail
 */
function TotalTeaPricePerDtl(purDtlId){
    var price = 0;
    var totalQty = 0;
    var totalTeaPrice = 0;

    totalQty = TotalWeightPerDtl(purDtlId);
    
    price = ($('#txtPrice_' + purDtlId).val() == "" ? 0 : $('#txtPrice_' + purDtlId).val());
    totalTeaPrice = parseFloat(totalQty) * parseFloat(price);
 
    return totalTeaPrice.toFixed(2);
}
/*
 * @method DetailTeaCost
 * @param {type} puDtId
 * @returns total per dtl cost
 */
function DetailTeaCost(puDtId){
    var teaPrice =0;
    teaPrice = TotalTeaPricePerDtl(puDtId);
    $("#DtltotalValue_" + puDtId).val(teaPrice);
}

/**
 * @method gstTaxableAmount
 * @param {int} puDtId
 * @returns {Number}
 * 
 */
function gstTaxableAmount(puDtId){
    var taxableamount =0;
    var teavalue =0;
    var discount = 0;
    
    var disDiscStr = "#DtlDiscountValue_"+puDtId;
    var teaValueStr = "#DtltotalValue_"+puDtId;
    discount =$(disDiscStr).val()||0;
    
    teavalue = $(teaValueStr).val()||0;
    taxableamount = parseFloat(teavalue) - parseFloat(discount);
    
    $("#DtlTaxableValue_"+puDtId).val(taxableamount.toFixed(2));
    return taxableamount; 
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
    //console.log(basepath + "GSTtaxinvoice/getAmount");
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




/**
 * @method getVatAmount
 * @param {int} dtlids
 * @return {int}
 */

function getVatAmount(dtlids) {
    var brokerageValue = 0;
    var stampCharges=0;
    var totalTeaPrice = 0;
    var vatPercentage = 0;
    var vatAmount = 0;
    var selectedVat = "#drpVatRate_" + dtlids + " option:selected";

    brokerageValue = ($('#txtBrokerage_' + dtlids).val() == '' ? 0 : $('#txtBrokerage_' + dtlids).val());
    stampCharges = ($('#txtStamp_' + dtlids).val() == '' ? 0 : $('#txtStamp_' + dtlids).val());
    
    totalTeaPrice = TotalTeaPricePerDtl(dtlids);
    vatPercentage = ($(selectedVat).text() == 'Select' ? '0' : $(selectedVat).text());
    
    vatAmount = ((parseFloat(brokerageValue)+ parseFloat(stampCharges) + parseFloat(totalTeaPrice)) * parseFloat(vatPercentage)) / 100;
    $("#txtVatAmount_" + dtlids).val(vatAmount.toFixed(2));
    
    console.log("VatAmt "+vatAmount);


    return vatAmount.toFixed(2);

}
/**
 * @method getCstAmount
 * @param {int} dtlids
 * @return {int}
 */
function getCstAmount(dtlids) {
    var brokerageValue = 0;
    var stampCharges=0;
    var totalTeaPrice = 0;
    var cstPercentage = 0;
    var cstAmount = 0;
    var selectedCST = "#drpCSTRate_" + dtlids + " option:selected";

    brokerageValue = ($('#txtBrokerage_' + dtlids).val() == '' ? 0 : $('#txtBrokerage_' + dtlids).val());
    stampCharges = ($('#txtStamp_' + dtlids).val() == '' ? 0 : $('#txtStamp_' + dtlids).val());
    totalTeaPrice = TotalTeaPricePerDtl(dtlids);
    cstPercentage = ($(selectedCST).text() == 'Select' ? '0' : $(selectedCST).text());
    
    cstAmount = ((parseFloat(brokerageValue)+ parseFloat(stampCharges) +  parseFloat(totalTeaPrice)) * parseFloat(cstPercentage)) / 100;
    $("#txtCstAmount_" + dtlids).val(cstAmount.toFixed(2));
    
    console.log(cstAmount);
    return cstAmount.toFixed(2);

}

/**
 * @method getServiceTax
 * @return {undefined}
 */
function getServiceTax(purchaseDetailId) {
    var brokerageValue = 0;
    var selectedServiceTax = "#drpServiceTax_" + purchaseDetailId + " option:selected";
    var serviceTaxAmount = 0;
    var serviceTaxPercentage = 0;

    brokerageValue = ($('#txtBrokerage_' + purchaseDetailId).val() == '' ? 0 : $('#txtBrokerage_' + purchaseDetailId).val());
    serviceTaxPercentage = ($(selectedServiceTax).text() == 'Select' ? '0' : $(selectedServiceTax).text());
    serviceTaxAmount = ((parseFloat(brokerageValue)) * parseFloat(serviceTaxPercentage)) / 100;
    // console.log(serviceTaxAmount);
    $("#serviceTax_" + purchaseDetailId).val(serviceTaxAmount.toFixed(2));
    
     console.log(serviceTaxAmount);
    return serviceTaxAmount.toFixed(2);


}


function getTeaCostPerKg(prdtlId){
    var discount=0;
    var price = 0 ;
    var transPortCost = 0;
    var totalWeight = 0;
    var serviceTax = 0;
    var totalTeaPrice= 0 ;
    var teaCost = 0;
    var teaCostPrKg = 0;
    
    discount = ($('#DtlDiscountValue_' + prdtlId).val() == '' ? 0 : $('#DtlDiscountValue_' + prdtlId).val());
   // transPortCost = ($('#transCost_' + prdtlId).val() == '' ? 0 : $('#transCost_' + prdtlId).val());
    price = ($('#txtPrice_' + prdtlId).val() == "" ? 0 : $('#txtPrice_' + prdtlId).val());
  //  transCost =($('#txtTransCost_' + prdtlId).val() == "" ? 0 : $('#txtTransCost_' + prdtlId).val());
    totalWeight = TotalWeightPerDtl(prdtlId);
        if(totalWeight!=0){
   // serviceTax = getServiceTax(prdtlId);
    totalTeaPrice = (parseFloat(totalWeight) * parseFloat(price)) - parseFloat(discount) ;
    teaCost = totalTeaPrice / parseFloat(totalWeight);
    
    teaCostPrKg = parseFloat(teaCost)+parseFloat(transPortCost);
    $("#DtlteaCost_" + prdtlId).val(teaCostPrKg.toFixed(2));
        }
        else{
            $("#DtlteaCost_" + prdtlId).val('0.00');
        }
    return teaCostPrKg.toFixed(2);
 
    
        
}

///////////////////////////////////////////////////////////////Summation Calculation//////////////////////////////////////

/**
 * @method totalTeaValues
 * @param {null} name description
 * @return {float} description
 * @description totalWeight * totalprice [#tea_value:database] 
 */
function totalTeaValues() {
    var totalTaxableAmt = 0;
    $(".txtTaxableAmt").each(function(){
        totalTaxableAmt = totalTaxableAmt + parseFloat($(this).val()||0);
    });
     
    $("#txtTeaValue").val(totalTaxableAmt.toFixed(2));

    return totalTaxableAmt.toFixed(2);
}
function totalCGSTValue() {
    var totalcgstamt = 0;

    $(".cgstAmt").each(function() {
        totalcgstamt = totalcgstamt + parseFloat($(this).val()||0);
    });
     $("#txtCGSTTotal").val(totalcgstamt.toFixed(2));
    return totalcgstamt.toFixed(2);
}
function totalSGSTValue(){
    var totalSGSTamt = 0 ;
    $(".sgstAmt").each(function(){
        totalSGSTamt = totalSGSTamt + parseFloat($(this).val()||0);
    });
    $("#txtSGSTTotal").val(totalSGSTamt.toFixed(2));
    return totalSGSTamt.toFixed(2);
 }
 function totalIGSTValue(){
     var totalIGSTamt = 0;
     $(".igstAmt").each(function(){
         totalIGSTamt = totalIGSTamt + parseFloat($(this).val()||0);
     });
     $("#txtIGSTTotal").val(totalIGSTamt.toFixed(2));
     return totalIGSTamt;
 } 
function totalGSTincludedAmount(){
    var taxableAmount = 0;
    var cgstamount=0;
    var sgstsmount=0;
    var igstamount=0;
    var totalGSTincludedAmount=0;
    
    taxableAmount = totalTeaValues();
    cgstamount = totalCGSTValue();
    sgstsmount = totalSGSTValue();
    igstamount = totalIGSTValue();
    
    totalGSTincludedAmount = parseFloat(taxableAmount)+parseFloat(cgstamount)+parseFloat(sgstsmount)+parseFloat(igstamount);
    
    $("#txtGSTIncludedAmount").val(totalGSTincludedAmount.toFixed(2));
    return totalGSTincludedAmount.toFixed(2);
    
}



function allTotalOfCost() {
    var finalCostofAllCost=0;
    //var gstincludedamt=0;
    var teaValuesTotal = 0;
    var roundoffs=0;
    
     teaValuesTotal = totalTeaValues();
     //gstincludedamt = $("#txtGSTIncludedAmount").val()||0;
     //console.log("gstincludedamt :"+gstincludedamt);
     roundoffs = $("#txtRoundOff").val()||0;
     finalCostofAllCost = parseFloat(totalGSTincludedAmount()) + parseFloat(roundoffs); 
    $("#txtTotalPurchase").val(finalCostofAllCost.toFixed(2));
    
  //alert(finalVatAmount);
    
    return finalCostofAllCost.toFixed(2);
}

///////////////////////////////Summation End////////////////////////////



//purchase details validation on adding 

function validationDetails() {
    if(!purTypeValidation()){return false;}
    if(!taxInvoiceValidation()){return false;}
    if(!invoicedateValidation()){return false;}
    if(!salenoValidation()){return false;}
    if(!vendorValidation()){return false;}
    if(!lotNumberValiadation()){return false;}
    if(!invoicevalidation() ) {return false;}
    if(!pricevaliadtion()){return false;}
    if(!normalBagValiadtion()){return false;}
    if(!normalBagQtyValidation()){return false;}
    if(!gardenValidation()){return false;}
    if(!gradeValidation()){return false;}
    if(!warehouseValidation()){return false;}
    if(!teagroupValidation()){return false;}
    
    if($("#purchasetype").val()=='SB'){        
       if(!locationValidation()){return false;}
    }
    
    return true;
}

/**
  * @method checkPurchaseInvoiceExist
  * @param 
  * @author Mithilesh
  * @date 13/01/2016
  */
 
$(document).on("blur", "#taxinvoice",function(){
   
   checkPurchaseInvoiceExist();
});

function checkPurchaseInvoiceExist(){
    var basepath = $("#basepath").val();
    var purchaseInvoiceNo = $("#taxinvoice").val();
   
        $.ajax({
            type: "POST",
            url: basepath + "purchaseinvoice/checkExistPurchaseInvoice",
            data: {purchaseInvoiceNo:purchaseInvoiceNo},
            dataType: 'html',
            success: function(data) {
               if(data==1){
                     $( "#dialog-check-invoice" ).dialog({
                            resizable: false,
                            height:140,
                            modal: true,
                            buttons: {
                            "Ok": function() {
                               $( this ).dialog( "close" );
                                $("#taxinvoice").val("");
                                  $( "#taxinvoice" ).focus();
                                       } 
                                         }
                                        });
                                   }},
                            complete: function() {
                            },
                            error: function(e) {
                                //called when there is an error
                                console.log(e.message);
                            }
            
        
});
}

function purTypeValidation(){
    if($("#purchasetype").val()==""){
        $("#purchasetype").addClass("glowing-border");
        return false;
    }
    return true;
}
function taxInvoiceValidation(){
    if($("#taxinvoice").val()==""){
        $("#taxinvoice").addClass("glowing-border");
        return false;
    }
    return true;
}
function invoicedateValidation(){
    if($("#taxinvoicedate").val()==""){
        $("#taxinvoicedate").addClass("glowing-border");
        return false;
    }
    return true;
}

function salenoValidation(){
    if($("#salenumber").val()==""){
        $("#salenumber").addClass("glowing-border");
        return false;
    }
    return true;
}

function vendorValidation(){
    if($('#vendor').val()==0){
       // $("#vendor").addClass("glowing-border");
        $("#vendor_err").css("display","block");
        return false;
    }
    return true;
}
function lotNumberValiadation(){

     var error = 0;
    $('.lotNumber').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#txtLot_' + id).val() == '' ? '' : $('#txtLot_' + id).val());

        if (inv == '') {
            $("#txtLot_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
    
}

function invoicevalidation() {
    var error = 0;
    $('.invoice').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#txtInvoice_' + id).val() == '' ? '' : $('#txtInvoice_' + id).val());

        if (inv == '') {
            $("#txtInvoice_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
}

function pricevaliadtion(){
    var error = 0;
    $('.price').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#txtPrice_' + id).val() == '' ? '' : $('#txtPrice_' + id).val());

        if (inv == '') {
            $("#txtPrice_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
}
function normalBagValiadtion(){
    var error = 0;
    $('.txtNumOfNormalBag').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#txtNumOfNormalBag_' + id).val() == '' ? '' : $('#txtNumOfNormalBag_' + id).val());

        if (inv == '') {
            $("#txtNumOfNormalBag_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
}
function normalBagQtyValidation(){
    var error = 0;
    $('.txtNumOfNormalNet').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#txtNumOfNormalNet_' + id).val() == '' ? '' : $('#txtNumOfNormalNet_' + id).val());

        if (inv == '') {
            $("#txtNumOfNormalNet_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
}

function gardenValidation(){
    
     var error = 0;
    $('.garden').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#drpGarden_' + id).val() == 0 ? 0 : $('#drpGarden_' + id).val());

        if (inv == 0) {
            $("#drpGarden_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
    
    
}

function gradeValidation(){
    
     var error = 0;
    $('.grade').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#drpGrade_' + id).val() == 0 ? 0 : $('#drpGrade_' + id).val());

        if (inv == 0) {
            $("#drpGrade_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
    
    
}

function warehouseValidation(){
    
    var error = 0;
    $('.wrhouse').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#drpWarehouse_' + id).val() == 0 ? 0 : $('#drpWarehouse_' + id).val());

        if (inv == 0) {
            $("#drpWarehouse_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
    
    
}
function teagroupValidation(){
    
    
    var error = 0;
    $('.teagroup').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#drpGroup_' + id).val() == 0 ? 0 : $('#drpGroup_' + id).val());

        if (inv == 0) {
            $("#drpGroup_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
}
/**
 * only for 'SB' ,location validation.
 * 
 */
function locationValidation(){
    
    
    var error = 0;
    $('.location').each(function() {
        var ctlID = $(this).attr('id');
        var purDtlId = ctlID.split('_');
        var id = purDtlId[1];
        var inv = ($('#drpLocation_' + id).val() == 0 ? 0 : $('#drpLocation_' + id).val());

        if (inv == 0) {
            $("#drpLocation_" + id).addClass("glowing-border");
            error = 1;
            return false;
        }

    });
    if (error == 1) {
        return false;
    } else {
        return true;
    }
    
   
}


function getGrandWeight()
{
   var totalGrandWeight=0;
   $(".dtlTotalWght").each(function() {
        var totalID = $(this).attr('id');
        var purDtlId = totalID.split('_');
        var id = purDtlId[1];
        var total = ($("#DtltotalWeight_" + id).val() == "" ? 0 : $("#DtltotalWeight_" + id).val());
        totalGrandWeight = parseFloat(totalGrandWeight + parseFloat(total));
        $("#txtGrandWeight").val(totalGrandWeight.toFixed(2));

   });
    return totalGrandWeight;
}

/*
 * @method totalBagNo()
 * @date 16-01-2016
 * 
 */
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
        //console.log(totalAllBag);

   });
    return totalAllBag;
}
