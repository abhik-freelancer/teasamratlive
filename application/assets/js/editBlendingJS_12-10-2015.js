/**
 *@add blending [addBlendingJS.js]
 *@08/09/2015 
 */
$(document).ready(function() {

    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });




    $(document).on('blur', ".usedBag", function() {
        var bagId = $(this).attr('id');
        var DtlId = bagId.split('_');
        var dtl_id = DtlId[1];

        if (!getValidation(dtl_id)) {
            $(this).val(0);
            $(this).addClass("glowing-border");
            getBlendedKgs(dtl_id);
            getTotalBlendedBag();
            getTotalBlendedWeight();

        }
        else {
            getBlendedKgs(dtl_id);
            getTotalBlendedBag();
            getTotalBlendedWeight();

        }
    });

    $(document).on('focus', ".usedBag", function() {
        $(this).removeClass("glowing-border");
        $(this).select();
    });


    $("#updateBlend").click(function() {

        if (!validation()) {

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


            return false;
        } else {
            var formData = $("#frmEditBlending").serialize();
            formData = decodeURI(formData);
            $.ajax(
                    {
                        type: 'POST',
                        dataType: 'json',
                        url: basepath + "blending/updateBlending",
                        data: {formDatas: formData},
                        success: function(data) {

                            if (data == 1) {
                                $("#dialog-new-save").dialog({
                                    resizable: false,
                                    height: 140,
                                    modal: true,
                                    buttons: {
                                        "Ok": function() {
                                            window.location.href = basepath + 'blending';
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

    });


})
// document load

function getValidation(dtlId) {
    var numberofBag = parseInt($("#NumberOfBags_" + dtlId).val());
    var hiddenBlendedBag = parseInt($("#hdTxtBlended_" + dtlId).val() == "" ? 0 : parseInt($("#hdTxtBlended_" + dtlId).val()));
    var stockQuantity = parseInt(numberofBag + hiddenBlendedBag);
    var blendBag = ($("#txtused_" + dtlId).val() == "" ? 0 : parseInt($("#txtused_" + dtlId).val()));
    //console.log("nu "+numberofBag+":"+blendBag);
    if (blendBag > stockQuantity) {
        $("#dialog-out-stock").dialog({
            resizable: false,
            height: 140,
            modal: true,
            buttons: {
                "Ok": function() {
                    $(this).dialog("close");
                }
            }
        });

        return false;
    } else {
        return true;
    }
}
function validation() {
    if (!blendingNoValidation()) {
        return false;
    }
    if (!blendingRefValidation()) {
        return false;
    }
    if (!blendingDateValidation()) {
        return false;
    }
    if (!warehouseValidation()) {
        return false;
    }
    if (!productValidation()) {
        return false
    }

    return true;
}
function blendingNoValidation() {
    var blendingNo = $("#txtBlendingNo").val();
    if (blendingNo == "") {
        $("#txtBlendingNo").addClass("glowing-border");
        return false;
    }
    return true;
}

function blendingRefValidation() {
    var blendingRef = $("#txtBlendingRef").val();
    if (blendingRef == "") {
        $("#txtBlendingRef").addClass("glowing-border");
        return false;
    }
    return true;
}

function blendingDateValidation() {
    var blendingDate = $("#txtBlendingDt").val();
    if (blendingDate == "") {
        $("#txtBlendingDt").addClass("glowing-border");
        return false;
    }
    return true;
}
function warehouseValidation() {
    var wareHouse = $("#warehouse").val();
    if (wareHouse == "") {
        $("#warehouse").addClass('glowing-border');
        return false;
    }
    return true;
}
function productValidation() {
    var product = $("#product").val();
    if (product == "") {
        $("#product").addClass('glowing-border');
        return false;
    }
    return true;

}
function getBlendedKgs(dtlId) {
    var blendedKgs = 0;
    var netInBag = parseFloat($("#hdnetBag_" + dtlId).val() == "" ? 0 : $("#hdnetBag_" + dtlId).val());
    var blendedBag = parseFloat($("#txtused_" + dtlId).val() == "" ? 0 : ($("#txtused_" + dtlId).val()));
    blendedKgs = parseFloat(netInBag * blendedBag).toFixed(2);
    //console.log("bl: "+blendedKgs);
    $("#txtBlendKg_" + dtlId).val(blendedKgs);


}
function getTotalBlendedBag() {
    var totalBlendedBag = 0;
    //var i=1;
    $('input[name^="txtused"]').each(function() {
        var bag = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalBlendedBag =parseFloat(totalBlendedBag + bag);
        //console.log("totalBlendedBag "+i+":"+bag);
        //i++;
    });
    
    $("#txtTotalBlendPckt").val((totalBlendedBag).toFixed(2));
    return false;
}
function getTotalBlendedWeight(){
    var totalBlendKg =0 ;
     $('input[name^="txtBlendKg"]').each(function() {
        var bagKg = parseFloat(($(this).val() == "" ? 0 : $(this).val()));
        totalBlendKg =parseFloat(totalBlendKg + bagKg);
    });
    $("#txtTotalBlendKgs").val((totalBlendKg).toFixed(2));
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


///*********************************


        