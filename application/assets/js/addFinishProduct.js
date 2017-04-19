/**
 *@add blending [addBlendingJS.js]
 *@08/09/2015 
 */
$(document).ready(function() {
    $( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
    $( ".finishproduct").addClass( " active " );   


    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;
    var divSerialNumber = 0;

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });

    $("#dropdownblendref").change(function() {
        $(".finished_product").hide('slow', function() {

            $(".finished_product").html("");
        });
        var selectedBlendRef = $("#dropdownblendref").val();
        if (selectedBlendRef != 0) {
            $(".finished_product").show('slow', function() {
                $("#stock_loader").show();
                $.ajax({
                    url: basepath + "finishproduct/showDetails",
                    type: 'post',
                    data: {blend: selectedBlendRef},
                    success: function(data) {
                        $(".finished_product").html(data);
                    },
                    complete: function() {
                        $("#stock_loader").hide();
                    },
                    error: function(e) {
                        //called when there is an error
                        console.log(e.message);
                    }
                });
            });


        }
    });

    $("#txtPackingDt").focus(function() {
        $(this).removeClass("glowing-border");
    });
    $("#warehouse").focus(function() {
        $(this).removeClass("glowing-border");
    });
    $("#dropdownblendref").focus(function() {
        $(this).removeClass("glowing-border");
    });

    $(document).on('change', ".noofpacket", function() {
        var packetId = $(this).attr('id');
        var DtlId = packetId.split('_');
        var dtl_id = DtlId[1];
        getKgsPerPacket(dtl_id);
		getTotalPacketKg();

    });

    //save start//

    $("#save_finish_product").click(function() {
        var consumeQuantity=0;
        if (getValidation()) {
           
            if (checkTotalQuantity()) {

                //to do
                var formData = $("#frmFinishedProduct").serialize();
                formData = decodeURI(formData);
                consumeQuantity = getConsumedQty();
               
                $.ajax(
                        {
                            type: 'POST',
                            dataType: 'json',
                            url: basepath + "finishproduct/insertFinishedProduct",
                            data: {formDatas: formData,Qtyofconsume:consumeQuantity},
                            success: function(data) {

                                if (data == 1) {
                                    $("#dialog-new-save").dialog({
                                        resizable: false,
                                        height: 140,
                                        modal: true,
                                        buttons: {
                                            "Ok": function() {
                                                window.location.href = basepath + 'finishproduct';
                                                $(this).dialog("close");
                                            }
                                        }
                                    });
                                } else {
                                    $("#dialog-error-save").dialog({
                                        resizable: false,
                                        height: 140,
                                        modal: true,
                                        buttons: {
                                            "Ok": function() {
                                                $(this).dialog("close");
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



            }


        } else {
            $("#dialog-validation-save").dialog({
                                        resizable: false,
                                        height: 140,
                                        modal: true,
                                        buttons: {
                                            "Ok": function() {
                                                $(this).dialog("close");
                                            }
                                        }
                                    });
        }

    });

})
// document load

/******** User defined function ****** */

function checkTotalQuantity() {
    var totalPacketQty = 0;
    var blendedQty = 0;
    blendedQty = ($("#netblendkg").val() == "" ? 0 : parseFloat($("#netblendkg").val()));
    $('input[name^="txtPcktKg"]').each(function() {
        var qty = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalPacketQty = parseFloat(totalPacketQty + qty);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
    if (blendedQty < totalPacketQty) {
        //alert("exceed stock");

       /* $("#dialog-blendkg").dialog({
            resizable: false,
            width: 450,
            height: 200,
            modal: true,
            buttons: {
                "Yes": function() {

                    $(this).dialog("close");
                    confirmQty(true);
                },
                Cancel: function() {

                    $(this).dialog("close");
                    confirmQty(false);
                }
            }
        });*/
     var val =confirm("Blended Quantity not matched.Do you want to proceed ?");
     if(val==true){
         return true;
     }else{
         return false;
     }
    } else if (blendedQty > totalPacketQty) {
        
     var val =confirm("Blended Quantity not matched.Do you want to proceed ?");
     if(val==true){
         return true;
     }else{
         return false;
     }
        
        
       /* $("#dialog-blendkg").dialog({
            resizable: true,
            width: 450,
            height: 200,
            modal: true,
            buttons: {
                "Yes": function() {

                    $(this).dialog("close");
                    confirmQty(true);
                },
                Cancel: function() {

                    $(this).dialog("close");
                    confirmQty(false);
                }
            }
        });*/
    } else {
        return true;
    }


}
function confirmQty(value){
    if(value==true){
        alert('aaa');
        return true;
    }else
    {
        return false;
    }
}

function getConsumedQty(){
    var totalPacketQty = 0;
    $('input[name^="txtPcktKg"]').each(function() {
        var qty = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalPacketQty = parseFloat(totalPacketQty + qty);
    
    });
    return totalPacketQty;
}


/**
 * @function getKgsPerPacket
 * @param {type} dtlid
 * @returns {Number|getKgsPerPacket.totalkg}
 */
function getKgsPerPacket(dtlid) {
    var no_of_packet = 0;
  //  var kg_in_packet = 0;
  var kg_in_bag=0;
    var totalkg = 0;

   // kg_in_packet = ($("#qtyinpckt_" + dtlid).val() == "" ? 0 : $("#qtyinpckt_" + dtlid).val());
    kg_in_bag = ($("#qtyinbag_" + dtlid).val() == "" ? 0 : $("#qtyinbag_" + dtlid).val());
    no_of_packet = ($("#txtpacket_" + dtlid).val() == "" ? 0 : $("#txtpacket_" + dtlid).val());

    totalkg = parseFloat(kg_in_bag * no_of_packet);

    $("#txtPcktKg_" + dtlid).val(totalkg);

    return totalkg;

}
function getValidation() {
    if (!packingDateValidation()) {
        return false;
    }
    if (!warehouseValidation()) {
        return false;
    }
    if (!blendRefNoValidation()) {
        return false;
    }


    return true;
}

function packingDateValidation() {
    var packingDate = $("#txtPackingDt").val();
    if (packingDate == "") {
        $("#txtPackingDt").addClass("glowing-border");
        return false;
    } else {
        return true;
    }
}
function warehouseValidation() {
    var warehouse = $("#warehouse").val();
    if (warehouse == 0) {
        $("#warehouse").addClass("glowing-border");
        return false;
    }
    else {
        return true;
    }
}
function blendRefNoValidation() {
    var blendRefNo = $("#dropdownblendref").val();
    if (blendRefNo == 0) {
        $("#dropdownblendref").addClass("glowing-border");
        return false;
    } else {
        return true;
    }
}
function getTotalPacketKg(){
	var table = $(".CSSTableGenerator");
	//alert(table);
	var data=[];
	var totalPackets =0;
	var totalkgs = 0;
	table.find('tr:gt(0)').each(function(rowIndex,r){
		var this_row = $(this);
		var no_of_packet = parseFloat($.trim(this_row.find('td:eq(3)').children('input').val()||0));
		var consumed_kgs = parseFloat($.trim(this_row.find('td:eq(4)').children('input').val()||0));
		console.log(consumed_kgs);
		totalPackets = parseFloat((totalPackets + no_of_packet));
		totalkgs = parseFloat((totalkgs + consumed_kgs));
	});
	console.log(totalPackets);
	$('.totpkt').val(totalPackets.toFixed(2));
	$('.totkgs').val(totalkgs.toFixed(2));
	//return totalPackets;
        
}


        