$(document).ready(function(){
$( ".legal-menu"+$('#transactionmenu').val() ).addClass( " collapse in " );
$( ".purchaseinvoice").addClass( " active " );
 
    // $( "#vendor" ).combobox();
       //  $( "#combobox" ).combobox();
     /*   $( "#toggle" ).click(function() {
      $( "#vendor" ).toggle();
    });*/
    
    
        $("#vendor").customselect();
     
     
   
});
$(function() {


    



    var basepath = $("#basepath").val();

    $(".mini").click(function() {


        $('#edit').css('visibility', 'visible');
        $('#del').css('visibility', 'visible');
    });




    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;

    var currentDate = new Date();


    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });

    $("#startdate").val(mindate);
    $("#enddate").val(maxDate);

    $("#saledate").change(function() {

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
    });




    $("#gotodetail").click(function() {

        var purType = $("#purchasetype option:selected").val();
        if (purType == 'SB') {
            $("#do").attr("disabled", "disabled");
            $("#dodate").attr("disabled", "disabled");
            $("#warehouse").attr("disabled", "disabled");
            $("#stockLocation").removeAttr("disabled");

        } else {
            $("#do").removeAttr("disabled");
            $("#dodate").removeAttr("disabled");
            $("#warehouse").removeAttr("disabled");
            $('#stockLocation').attr("disabled", "disabled");
        }
        $("#detailpurchaseinvoice").dialog({
            resizable: false,
            height: 600,
            width: 1000,
            modal: true,
            buttons: {
                "Confirm": function() {

                    
                    $("#example2").find('td.dataTables_empty').parent().remove();
                    $("#countdetail").val(parseFloat($("#countdetail").val()) + parseFloat(1));

                    var createspan = '';
                    var createspanhidden = '';
                    var numberofBags='';
                    
                    $("input[name='packtno[]']").each(function() {
                        if($(this).val()!=''){numberofBags=$(this).val();}else{numberofBags=0;}
                        createspan = createspan + (numberofBags + '<br/>');
                        createspanhidden = createspanhidden + (numberofBags + ',');

                    })

                    var samplenet = '';
                    var samplenethidden = '';
                    var BagQty='';
                    $("input[name='packtvalue[]']").each(function() {
                        if($(this).val()!=''){BagQty=$(this).val()}else{BagQty=0}
                        samplenet = samplenet + (BagQty + '<br/>');
                        samplenethidden = samplenethidden + (BagQty + ',');

                    })
                    
                    var bagTypeText ="";
                    var bagTypehiddenIds =""
                   
                    
                     $("select[name='drpBagtype[]']").each(function() {
                        if($(this).val()!=''){
                            bagTypeText = bagTypeText + $(this).find('option:selected').text()+"<br/>";
                        
                        }
                        if($(this).val()!=''){
                         bagTypehiddenIds = bagTypehiddenIds + ($(this).val() + ',');
                     }

                    })
                    var chestText  ="";
                    var chestValue ="";
                    
                     $("textarea[name='chestSerial[]']").each(function() {
                        chestText = chestText + ($(this).val() + '<br/>');
                        chestValue = chestValue + ($(this).val() + '~');

                    })

                    var sample = "";
                    if (createspan != '')
                    {
                        var sample = "<table>" +
                                "<tr>"+
                                "<td>" + createspan + "<input type='hidden' name='detailsamplename[]' value='" + createspanhidden + "'/></td>"+
                                "<td>=></td>" +
                                "<td>" + samplenet + "<input type='hidden' name='detailsamplenet[]' value='" + samplenethidden + "'/>"+"</td>"+
                                "<td>" + bagTypeText + "<input type='hidden' name='bagtypeIds[]' value='" + bagTypehiddenIds + "'/>"+"</td>"+
                                "<td>" + chestText + "<input type='hidden' name='chestvalues[]' value='" + chestValue + "'/>"+"</td>"+
                                "</tr>"+
                                "</table>";
                    }
                    
                    

                    var err = 0;
                    if(createspan=="" ){
                        var err =1;
                        alert("Add package and net on clicking on Bags(+)");
                        
                    }
                    
                    
                    if (($('#lot').val()) == '')
                    {
                        err = 1;
                        $("#lot").addClass("glowing-border");
                    }
                    if (($('#invoice').val()) == '')
                    {
                        err = 1;
                        $("#invoice").addClass("glowing-border");
                    }

                   
                    if (($('#price').val()) == '')
                    {
                        err = 1;
                        $("#price").addClass("glowing-border");
                    }
                    if (($('#garden').val()) == 0)
                    {
                        err = 1;
                        $("#gardenerr").addClass("glowing-border");
                    }
                    if (purType != 'SB') {
                        if (($('#warehouse').val()) == 0)
                        {
                            err = 1;
                            $("#wareerr").addClass("glowing-border");
                        }
                    } else {
                        if (($('#stockLocation').val()) == 0)
                        {
                            err = 1;
                            $("#stockLocation").addClass("glowing-border");
                        }
                    }
                    if (($('#grade').val()) == 0)
                    {
                        err = 1;
                        $("#gradeerr").addClass("glowing-border");
                    }

                    if (($('#gross').val()) == '')
                    {
                        err = 1;
                        $("#gross").addClass("glowing-border");
                    }


                    

                    if (err == 0)
                    {
                        if (purType != 'SB') {
                            var warehouseText = $("#warehouse option:selected").text();
                        } else {
                            var warehouseText = $("#stockLocation option:selected").text();
                           
                        }
                        $("#example2").append(
                                "<tr id='detailtr" + $("#countdetail").val() + "'>" +
                                "<td>" + $('#lot').val() +
                                "<input type='hidden' name='detaillot[]' value='" + $('#lot').val() + "'/><br/>"
                                + $('#do').val() +
                                "<input type='hidden' name='detaildo[]' value='" + $('#do').val() + "' /><br/>"
                                + $('#dodate').val() +
                                "<input type='hidden' name='detaildodate[]' value='" + $('#dodate').val() + "' />" +
                                "<input type='hidden' name='detailtableid[]' value='0'/>" +
                                "</td>" +
                                "<td>" + $('#invoice').val() + "<input type='hidden' name='detailinvoice[]' value='" + $('#invoice').val() + "' /></td>" +
                                "<td>" + $("#garden option:selected").text() + "<input type='hidden'  name='detailgardenid[]' value='" + $("#garden option:selected").val() + "'/><br/>" +
                                warehouseText +
                                "<input type='hidden' name='detaillocationid[]' value='" + $("#stockLocation option:selected").val() + "'/>" +
                                "<input type='hidden'  name='detailwarehouseid[]' value='" + $("#warehouse option:selected").val() + "'/><br/>" + $("#teagroup option:selected").text() +
                                "<input type='hidden'  name='detailteagroupid[]' value='" + $("#teagroup option:selected").val() + "'/></td>" +
                                "<td><span name='grade[]'>" + $("#grade option:selected").text() + "</span><input type='hidden'  name='detailgradeid[]' value='" + $("#grade option:selected").val()+"'/></td>" +
                                "<td>" + $('#gpno').val() + "<input type='hidden' name='detailgpno[]' value='" + $('#gpno').val() + "' /><br/>" + $('#date').val() + "<input type='hidden' name='detaildate[]' value='" + $('#date').val() + "'/></td>" +
                                "<td>" + $('#stamp').val() + "<input type='hidden' name='detailstamp[]' value='" + $('#stamp').val() + "'/>"+"</td>" +
                                "<td>" + sample + "</td>" +                                
                                "<td>" + $('#gross').val() + "<input type='hidden' name='detailgross[]' value='" + $('#gross').val() + "'/><br/>" +
                                $('#brok').val() + "<input type='hidden' class='listbrok' name='detaillistbrokerage[]' value='" + $('#brok').val() + "'/></td>" +
                                "<td>" + (calculateTotalWeight()).toFixed(2) + 
                                    "<input type='hidden' name='detaillisttweight[]' value='" + calculateTotalWeight() + "'/><br/>" + 
                                    getOption() + " => " + $('#taxrate').val() +
                                    "<input type='hidden' name='detailvat[]' value='" + $('#taxrate').val() + "'/>"+
                                    "<input type='hidden' name='rate_type[]' value='" + $('input[name=type]:checked').val() + "'/>"+
                                    "<input type='hidden' class='fieldvatrate' name='fieldvatrate[]' id='fieldvatrate" + $("#countdetail").val() + "' value=''/>"+
                                    "<input type='hidden'  id='fieldcstrate" + $("#countdetail").val() + "' class='fieldcstrate' name='fieldcstrate[]' value=''/>"+
                                    "<input type='hidden' name='rate_type_id[]' value='" + $("#optionrate option:selected").val() + "'/>"+
                                "</td>" +
                                "<td>" + $('#price').val() + "<input type='hidden' name='detailprice[]' value='" + $('#price').val() + "'/><br/>" + 
                                $('#stax').val() + "<input type='hidden' name='detailstax[]' value='" + $('#stax').val() + "'/>"+
                                "<input type='hidden' name='stax_id[]' value='" + $("#optionstax option:selected").val() + "'/></td>" +
                                "<td>" + (calculateValue()).toFixed(2) + "<input type='hidden' value='" + calculateValue() + "' name='detailvalue[]'/><br/> " +
                                (calculatetotal()).toFixed(2) + "<input type='hidden' value='" + calculatetotal() + "' name='detaillisttotal[]'/></td>" +
                                "<td><img src='" + basepath + "/application/assets/images/delete.png' height='20' width='20' onclick='deleterow(\"detailtr\"," + $("#countdetail").val() + ")'/></td>" +
                                "</tr>");

                        calculateratetypetotal($("#countdetail").val());
                        calculateTeavalue();
                        calculateTotalBrokerage();
                        calculateTotalServiceTax();
                        calculateTotalVatrate();
                        calculateTotalCstrate();
                        calculateTotalStamp();
                        claculeteTotalPurchaseInvoice();

                        makealltextblank();

                        $(this).dialog("close");
                    }

                },
                Cancel: function() {
                     $("#addsamplehere").hide();
                    $(this).dialog("close");
                    //$("#popupwindow input:text").val("");
                    //$("#popupwindow select").val(0);
                    //$("#addsamplehere").html('');
                    makealltextblank();

                }
            }
        });
    });



    $("#addsample").click(function() {
        $("#addsamplehere").show();
        $.ajax({
            type: "get",
            url: basepath + 'purchaseinvoice/callSamplepage',
            cache: false,
            dataType: 'html',
            success: function(mdata) {
                $("#addsamplehere").append(mdata);
                var count = '';
                if ($("#samplecount").val() == '')
                {
                    count = 0;
                }
                else
                {
                    count = parseFloat($("#samplecount").val());
                }
                var finalc = parseFloat(count) + parseFloat(1);
                $("#samplecount").val(finalc);
                $("#sampletr").attr("id", "sampletr" + finalc);
                $("#sampleimg").attr("id", "sampleimg" + finalc);
                $("#sampleimg" + finalc).attr("onclick", "deletesample(" + finalc + ")");

            }
        });
    });

/**
 * 
 */
 $("#purchasetype").change(function() {
        if($('option:selected', this).val()!="AS"){
            $("#auctionArea").attr("disabled", 'disabled');
            $("#auctionArea").val("0");
        }else{
            $("#auctionArea").removeAttr('disabled');;
        }
        //alert( $('option:selected', this).text() );
    });

    $("#savedpage").click(function() {
        if (($("#calculatevatinput").val() > 0) && ($("#calculatecstinput").val() > 0))
        {
            alert("Please check in detail section. VAT and CST cann't persist in a same bill");
        }
        else
        {
            var error = 0;
            if (($('#taxinvoice').val()) == '')
            {
                error = 1;
                $("#taxinvoice").addClass("glowing-border");
            }
            if (($('#taxinvoicedate').val()) == '')
            {
                error = 1;
                $("#taxinvoicedate").addClass("glowing-border");
            }
            if (($('#vendor').val()) == 0)
            {
                error = 1;
                $("#vendorerr").addClass("glowing-border");
            }
          
            if (error == 0)
            {
                //	$("#spinner").show();
                $("#addpurchaseinvoice").submit();
            }
        }
    });


    $("#chestallow").blur(function() {
        claculeteTotalPurchaseInvoice();

    });
    /*
     $("#stampcharge").blur(function(){
     claculeteTotalPurchaseInvoice();
     });
     
     
     /*$( ".call" ).change(function() {
     calculateTotalVatrate();
     claculeteTotalPurchaseInvoice();
     
     });*/


    $("#showinvoice").click(function() {

        var vendor = $("#vendor option:selected").val();
        var startdate = $('#startdate').val();
        var enddate = $('#enddate').val();

        $.ajax({
            type: "POST",
            url: basepath + "purchaseinvoice/getlistpurchaseinvoice",
            data: {vendor: vendor, startdate: startdate, enddate: enddate},
            success: function(data)
            {

               
                window.location.href = basepath + 'purchaseinvoice';

            }

        });

    });


    $(".opendetail").click(function() {
        var id = $(this).attr('id');

        $.ajax({
            type: "POST",
            url: basepath + "purchaseinvoice/getlistingindetail",
            data: {id: id},
            success: function(data)
            {                
             $rowhead ='<div class="CSSDtlFlyTable"><table id="popuptable" border="1" width="100%">'+
            '<thead>'+
                '<tr>'+
                    '<td>LOT/<br>DO</td>'+
                    '<td>Invoice Number</td>'+
                    '<td>Garden/<br>Warehouse</td>'+
                    '<td>Grade</td>'+
                    '<td>GP No/Date</td>'+
                    '<td>Bag/Nos/Kgs</td>'+
                    '<td>Gross/<br>Brokerage</td>'+
                    '<td>Total Wt./<br>Vat</td>'+
                    '<td>Price/<br>Service tax</td>'+
                    '<td>Value</td>'+
                    '<td>Total</td>'+
                '</tr>'+
            '</thead>'+data+'</table></div>';
                
                
                $("#popupdiv").html($rowhead);

                $("#popupdiv").dialog({
                    resizable: false,
                    height: 300,
                    width: 1000,
                    modal: true,
                    buttons: {
                        "CLOSE": function() {
                            $(this).dialog("close");
                        }
                    }
                });
            }

        });
    });


    $(".showtooltip").tooltip({
        show: null,
        position: {
            effect: "slideDown"
        },
    });
    /**
     * Work on 06-04-2015
     * 
     */

    $('input:radio[name="type"]').change(function() {

        $.ajax({
            type: "POST",
            data: {startdate: mindate, enddate: maxDate, type: $('input[name=type]:checked').val()},
            url: basepath + "purchaseinvoice/getTaxlist",
            success: function(data)
            {
                if ($('input[name=type]:checked').val() == 'V') {
                    $("#currentcstrate").html('');
                    $("#currentvatrate").html(data);
                } else {
                    $("#currentvatrate").html('');
                    $("#currentcstrate").html(data);
                }

            }

        });
        if ($(this).val() == 'V')
        {
            $("#currentvatrate").css("display", "");
            $("#currentcstrate").css("display", "none");
            $("#selectionlable").html("VAT Rate");

        }
        else
        {
            $("#currentvatrate").css("display", "none");
            $("#currentcstrate").css("display", "");
            $("#selectionlable").html("CST Rate");
        }

    });

    $('.optionrate').change(function() {
        //calculateTotalVatrate();
        calculateCurrentVatratetotal();

    });


    $('#brok').change(function() {
        calculateCurrentVatratetotal();
    });

    $('#price').change(function() {
        calculateCurrentVatratetotal();
    });


    $('#package').change(function() {
        calculateCurrentVatratetotal();
    });

    $('#net').change(function() {
        calculateCurrentVatratetotal();
    });




    $('#optionstax').change(function() {
        var staxrate = $("#optionstax :selected").text();
        var brokerage = $("#brok").val();
        var result = brokerage * (staxrate / 100);
        if (staxrate > 0)
        {
            $("#stax").val(result.toFixed(2));
        }


    });


});
var basepath = $("#basepath").val();
function calculateCurrentVatratetotal()
{

    var vatrate = parseFloat($("#optionrate :selected").text());
    var value = calculateValue();


    var brokerage = parseFloat($("#brok").val());

    if (brokerage != '')
    {
        var btotal = parseFloat(brokerage) + parseFloat(value);
    }
    else
    {
        var btotal = parseFloat(value);
    }

    var result = parseFloat(btotal) * parseFloat(vatrate / 100);


    if (vatrate > 0)
    {
        $("#taxrate").val(result.toFixed(2));
    }
}

function getOption()
{
    var selected = $('input[name=type]:checked').val();

    if (selected == 'V')
    {
        return "VAT";
    }
    else
    {
        return "CST";
    }


}

function deleterow(rowname, rowid)
{
    $("#" + rowname + rowid).remove();

    calculateTeavalue();
    calculateTotalBrokerage();
    calculateTotalServiceTax();
    calculateTotalVatrate();
    calculateTotalCstrate();
    claculeteTotalPurchaseInvoice();
}
/**
 * 
 * @param {type} rowname
 * @param {type} rowid
 * @returns {undefined}
 * modified by abhik ,on 12/06/2015
 */
function deleterowdb(rowname, rowid)
{
    $("#dialog-confirm_purDtl_delete").dialog({
        resizable: false,
        height: 140,
        modal: true,
        buttons: {
            "Ok": function() {
                $(this).dialog("close");
                //var basepath = $("#basepath").val();
                /* $.ajax({
                 type: "POST",
                 data: {detailid: rowid},
                 url: basepath + "purchaseinvoice/deleteInvoicedetail",
                 success: function(data)
                 {
                 deleterow(rowname, rowid);
                 }
                 
                 });*/
            },
            /*Cancel: function() {
             $(this).dialog("close");
             }*/
        }
    });

}

function calculateTotalWeight()
{
    var countsample = 0;
    var weight = 0;
    var net = 0;
    var value = 0;
    var samplednet = 0;
    var package = 0;

    if ($("#samplecount").val() != '')
    {
        countsample = $("#samplecount").val();
    }
    else
    {
        countsample = 0;
    }
   if (countsample > 0)
    {
        var noOfBags = [];
        var netOfBags = [];
        $("input[name='packtno[]']").each(function() {
            if ($(this).val() != '')
            {
                value = $(this).val();
            }
            else
            {
                value = 0;
            }

            noOfBags.push(value);
            //samplednet = parseFloat(samplednet) + parseFloat(value);

        });

        $("input[name='packtvalue[]']").each(function() {

            if ($(this).val() != '') {
                net = $(this).val();
            } else {
                net = 0;
            }
            netOfBags.push(net);

        });

        var i;
        for (i = 0; i < noOfBags.length; i++) {
            weight = weight + (parseInt(noOfBags[i]) * (parseInt(netOfBags[i])));
        }
       //weight = parseFloat(packged) + parseFloat(samplednet);
    }
    else
    {
        weight = 0;
    }
//alert("Weight:"+weight);
    return weight;
}

function calculateValue()
{
    var price = 0;
    var TotalWeight=0;
    var TotalValue=0;
    if ($("#price").val() != '')
    {
        price = parseFloat($("#price").val());
    }
//alert("CalculateValue"+calculateTotalWeight() * price);
   TotalWeight = calculateTotalWeight();
   TotalValue = parseFloat(TotalWeight * price) ;
   return TotalValue;
    //return (calculateTotalWeight() * price);
}

function calculatetotal()
{
    var value = calculateValue();
    var brokerage = 0;
    var vat = 0;
    var servicetax = 0;
    var stampCharges = 0;
    var total=0;
    var totalFormated=0;
    if ($("#brok").val() != '')
    {
        brokerage = $("#brok").val();
    }

    if ($("#taxrate").val() != '')
    {
        vat = $("#taxrate").val();
    }
    if ($("#stax").val() != '')
    {
        servicetax = $("#stax").val();
    }
    if ($("#stamp").val() != '') {
        stampCharges = $("#stamp").val();
    }
    total = parseFloat(value) + parseFloat(brokerage) + parseFloat(vat) + parseFloat(servicetax) + parseFloat(stampCharges);
    totalFormated=parseFloat(total);
    return (totalFormated);

}


function calculateTeavalue()
{
    var value = 0;
    var totalnet = 0;
    $('input[name^="detailvalue"]').each(function() {
        if ($(this).val() != '')
        {
            value = $(this).val();
        }
        else
        {
            value = 0;
        }
        totalnet = parseFloat(totalnet) + parseFloat(value);
    });

    $('#teavalue').html(totalnet);
    $('#teavalueinput').val(totalnet);

}

function calculateTotalBrokerage()
{
    var value = 0;
    var totalbrok = 0;
    //detaillistbrokerage
    $('input[name^="detaillistbrokerage"]').each(function() {
        if ($(this).val() != '')
        {
            value = $(this).val();
        }
        else
        {
            value = 0;
        }

        totalbrok = parseFloat(totalbrok) + parseFloat(value);
    });

    $('#totalbrokerage').html(totalbrok);
    $('#brokerageinput').val(totalbrok);

}



function calculateTotalServiceTax()
{
    var value = 0;
    var totalstax = 0;

    $('input[name^="detailstax"]').each(function() {
        if ($(this).val() != '')
        {
            value = $(this).val();
        }
        else
        {
            value = 0;
        }

        totalstax = parseFloat(totalstax) + parseFloat(value);
    });

    $('#servicetax').html(totalstax.toFixed(2));
    $('#servicetaxinput').val(totalstax.toFixed(2));

}


function calculateratetypetotal(id)
{
    var selected = $('input[name=type]:checked').val();
    if ($("#taxrate").val() != '')
    {
        value = $("#taxrate").val();
    }
    else
    {
        value = 0;
    }
    if (selected == 'V')
    {
        $('#fieldvatrate' + id).val(value);
    }
    else
    {
        $('#fieldcstrate' + id).val(value);
    }
}
function calculateTotalVatrate()
{
    var totalvalue = 0;
    $('input[name^="fieldvatrate"]').each(function() {
        if ($(this).val() != '')
        {
            value = $(this).val();
        }
        else
        {
            value = 0;
        }

        totalvalue = parseFloat(totalvalue) + parseFloat(value);
    });

    $('#calculatevat').html(totalvalue.toFixed(2));
    $('#calculatevatinput').val(totalvalue.toFixed(2));
}

function calculateTotalCstrate()
{
    var totalvalue = 0;
    $('input[name^="fieldcstrate"]').each(function() {
        if ($(this).val() != '')
        {
            value = $(this).val();
        }
        else
        {
            value = 0;
        }
        totalvalue = parseFloat(totalvalue) + parseFloat(value);
    });
    $('#calculatecst').html(totalvalue.toFixed(2));
    $('#calculatecstinput').val(totalvalue.toFixed(2));
}
function claculeteTotalPurchaseInvoice()
{
    var teavalue = 0;
    var brokerage = 0;
    var servicetax = 0;
    var chestallow = 0;
    var calculatevat = 0;
    var stampcharge = 0;

    if ($('#teavalue').html() != '')
    {
        teavalue = $('#teavalue').html();
    }
    if ($('#totalbrokerage').html() != '')
    {
        brokerage = $('#totalbrokerage').html();
    }
    if ($('#servicetax').html() != '')
    {
        servicetax = $('#servicetax').html();
    }
    if ($('#chestallow').val() != '')
    {
        chestallow = $('#chestallow').val();
    }
    if ($('#calculatevat').html() != '')
    {
        calculatevat = $('#calculatevat').html();
    }
    if ($('#stampcharge').val() != '')
    {
        stampcharge = $('#stampcharge').val();
    }

    var totalcalculation = parseFloat(teavalue) + parseFloat(brokerage) + parseFloat(servicetax) + parseFloat(chestallow) + parseFloat(calculatevat) + parseFloat(stampcharge);

    $('#total').html(totalcalculation.toFixed(2));
    $('#totalinput').val(totalcalculation.toFixed(2));


}
//abhik
function calculateTotalStamp() {
    var totalvalue = 0;
    $('input[name^="detailstamp"]').each(function() {
        if ($(this).val() != '')
        {
            value = $(this).val();
        }
        else
        {
            value = 0;
        }
        totalvalue = parseFloat(totalvalue) + parseFloat(value);
    });

    $('#stampcharge').val(totalvalue.toFixed(2));

}

function deletesample(rowid)
{
    $("#sampletr" + rowid).remove();

    var count = '';
    if ($("#samplecount").val() == '')
    {
        count = 0;
    }
    else
    {
        count = parseFloat($("#samplecount").val());
    }
    var finalc = parseFloat(count) - parseFloat(1);
    $("#samplecount").val(finalc);
    calculateCurrentVatratetotal();
}

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

function makealltextblank()
{
    $('#lot').val('');
    $('#do').val('');
    $("#dodate").val('');
    $('#invoice').val('');
    $('#garden').val('');
    $('#warehouse').val('');
    $('#grade').val('');
    $('#package').val('');
    $('#stamp').val('');
    $('#net').val('');
    $('#gross').val('');
    $('#brok').val('');
    $('#chfrom').val('');
    $('#chto').val('');
    $('#gpno').val('');
    $('#date').val('');
    $('#vat').val('');
    $('#stax').val('');
    $('#taxrate').val('');
    $('#price').val('');
    $('#addsamplehere').html('');
    $("input[name=type][value='V']").prop("checked", true);
    $("#addsamplehere").html('');
    $('#garden').val('0');
    $('#grade').val('0');
    $('#teagroup').val('0');
    $('#warehouse').val('0');
    $('#optionrate').val('0');
    $('#optionstax').val('0');
    $('#samplecount').val('0');


}
function editrow(rowname, rowid)
{

    $('#lot').val($('#lot' + rowid).html());
    $('#do').val($('#do' + rowid).html());
    $('#dodate').val($('#dodate' + rowid).text().trim());
    $('#teagroup').val($('#detailteagroupid' + rowid).val());
    $('#invoice').val($('#invoice' + rowid).html());
    $('#garden').val($('#detailgardenid' + rowid).val());
    $('#warehouse').val($('#detailwarehouseid' + rowid).val());
    $('#stockLocation').val($('#detailLocationid' + rowid).val());
    $('#grade').val($('#detailgradeid' + rowid).val());
    $('#stamp').val($('#stamp' + rowid).html());
    $('#gross').val($('#gross' + rowid).html());
    $('#brok').val($('#brokerage' + rowid).html());
    $('#gpno').val($('#gpnumber' + rowid).html());
    $('#date').val($('#gpdate' + rowid).text().trim());
    $('#vat').val($('#vat' + rowid).html());
    $('#price').val($('#price' + rowid).html());
    $('#stax').val($('#stax' + rowid).html());

    var do_editable = $("#hdeditable" + rowid).val();
    var purType = $("#purchasetype option:selected").val();
    if (purType == 'SB') {
        $("#do").attr("disabled", "disabled");
        $("#dodate").attr("disabled", "disabled");
        $("#warehouse").attr("disabled", "disabled");
        $("#stockLocation").removeAttr("disabled");

    } else {
        if (do_editable == 'N') {
            $("#do").attr("disabled", "disabled");
            $("#dodate").attr("disabled", "disabled");
        } else {
            $("#do").removeAttr("disabled");
            $("#dodate").removeAttr("disabled");
        }
        $("#warehouse").removeAttr("disabled");
        $("#stockLocation").attr("disabled", "disabled");
    }


    var numberOfBagsInBagDetails = parseInt($('#hdNumberOfBagsRow' + rowid).val());
    if ($('#ratetype' + rowid).val() == 'V')
    {
        $("input[name=type][value='C']").removeAttr("checked", false);
        $("input[name=type][value='V']").prop("checked", true);
        $('#selectionlable').html("VAT Rate");
        $('#currentvatrate').show();
        $('#currentcstrate').hide();
    }
    else
    {
        $("input[name=type][value='V']").removeAttr("checked", false);
        $("input[name=type][value='C']").prop("checked", true);
        $('#selectionlable').html("CST Rate");
        $('#currentcstrate').show();
        $('#currentvatrate').hide();
    }
    var option = $('#ratetypeid' + rowid).val();//vat or cst
    $("#optionrate [value='" + option + "']").prop('selected', true);
    $('#taxrate').val($('#ratetypevalue' + rowid).val());
    var staxop = parseInt($('#servicetaxid' + rowid).val());//service tax
    $("#optionstax [value='" + staxop + "']").prop('selected', true);

    
    var sample = $('#sample' + rowid).html();
    var samplenet = $('#samplenet' + rowid).html();
    var bags =$('#bagType'+rowid).html();
    var selectedBagTypeIds = $('#bagtypeIds' + rowid).val();
    var chestSerial=$('#chest'+rowid).html();
    var bagDtlTabId=$('#bagdtlid_'+rowid).val();
    
    if (sample != '')
    {
    	$('#addsamplehere').show();
        var samplearr = sample.split('<br>');
        var samplenetarr = samplenet.split('<br>');
        var chestArray = chestSerial.split('<br>');
        var bagsArr = bags.split('<br>');
        var selectedBags = selectedBagTypeIds.split('*');
        var bagDtlTableIdArr=bagDtlTabId.split(',');
        //(samplearr);
        var row = '';
        var tr = '';

        for (i = 0; i < numberOfBagsInBagDetails; i++) {

            row = '<table class="CSSTableGenerator">' +
                    '<tr id="sampletr' + rowid +i+ '">' +
                    '<td>'+
                    '<select id="drpBagtype" name="drpBagtype[]">'+
                    '<option value="1"'+((selectedBags[i]==1)?'Selected=selected':'')+'>Normal</option>'+
                    '<option value="2"'+((selectedBags[i]==2)?'Selected=selected':'')+'>Sample</option>'+
                    
             		'</select>'+
			        '</td>'+
                    '<td>' +
                    '<input type="text" id="bagDtlid" name="bagDtlid[]" value="'+bagDtlTableIdArr[i]+'" />'+
                    '<input type="text" name="packtno[]" id="packtno" placeholder="No of bags" value="' + samplearr[i] + '" onblur="calculateCurrentVatratetotal()" onkeypress="checkNumeric(this);"/>' +
                    '</td>' +
                    '<td>&nbsp;</td>' +
                    '<td>' +
                    '<input type="text" name="packtvalue[]" placeholder="Net in Kgs" id="packtvalue" class="packtvaluenet" value="' + samplenetarr[i] + '" onblur="calculateCurrentVatratetotal()" onkeypress="checkDecimal(this);"/>' +
                    '</td>'+
                    '<td>'+
                    '<textarea id="chestSerial" name="chestSerial[]" placeholder="chest serial">'+
                    (typeof chestArray[i]!='undefined'?chestArray[i]:'')+'</textarea>'+
                    '</td>'+
                    '<td>'+
                    '<img src="' + basepath + 'application/assets/images/delete.png" id="sampleimg' + rowid + '" height="15" width="15" onclick="deletesample(' + rowid+i+ ')">' +'</td>'
                    '</tr></table>';
            $("#samplecount").val(samplearr.length);
            $('#addsamplehere').html(($('#addsamplehere').html()) + row);
        }
    }


    $("#detailpurchaseinvoice").dialog({
        resizable: false,
        height: 600,
        width: 1000,
        modal: true,
        buttons: {
            "Confirm": function() {

                numberofsample = 0;
                $("#example2").find('td.dataTables_empty').parent().remove();
                $("#countdetail").val(parseInt($("#countdetail").val()) + parseInt(1));

                var createspan = '';
                var createspanhidden = '';
                var numberofbags="";
                $("input[name='packtno[]']").each(function() {
                    if($(this).val()!=''){numberofbags=$(this).val(); }else{numberofbags=0;}
                    createspan = createspan + (numberofbags + '<br>');
                    createspanhidden = createspanhidden + (numberofbags + '*');
                    numberofsample = numberofsample + 1;
                })

                var samplenet = '';
                var samplenethidden = '';
                var BagQty='';
                $("input[name='packtvalue[]']").each(function() {
                    if($(this).val()!=''){BagQty=$(this).val();}else{BagQty=0;}
                    samplenet = samplenet + (BagQty + '<br>');
                    samplenethidden = samplenethidden + (BagQty + '*');
                })
                
                 var bagTypeText ="";
                 var bagTypehiddenIds =""
                   
                    
                     $("select[name='drpBagtype[]']").each(function() {
                        if($(this).val()!=''){
                            bagTypeText = bagTypeText + $(this).find('option:selected').text()+"<br>";
                        
                        }
                        if($(this).val()!=''){
                         bagTypehiddenIds = bagTypehiddenIds + ($(this).val() + '*');
                     }

                    })
                    var chestText  ="";
                    var chestValue ="";
                    
                     $("textarea[name='chestSerial[]']").each(function() {
                        chestText = chestText + ($(this).val() + '<br>');
                        chestValue = chestValue + ($(this).val() + '*');

                    })
                    var bagDtlids="";
                    $("input[name='bagDtlid[]']").each(function(){
                        bagDtlids =bagDtlids+($(this).val()+','); 
                    });


                var sample = "";
                //alert(createspan);numberofsample
                if (createspan != '')
                {
                    var sample = "<table><tr><td>" +
                            "<input type='text' name='bagdtlid_"+rowid+"[]' id='bagdtlid_"+ rowid +"' value='"+bagDtlids+"'/>"+
                            "<input type='hidden' id='hdNumberOfBagsRow" + rowid + "' value='" + numberofsample + "'/>" +
                            "<span id='sample" + rowid + "'>" + createspan + "</span>" +
                            "<input type='hidden' name='detailsamplename_"+rowid+"[]'value='" + createspanhidden + "'/></td>" +
                            "<td>=></td>" +
                            "<td><span id='samplenet" + rowid + "'>" + samplenet + "</span>" +
                            "<input type='hidden' name='detailsamplenet_"+rowid+"[]' value='" + samplenethidden + "'/>" +
                            "</td>"+
                            "<td>"+
                            "<span id='bagType"+rowid+"'>"+bagTypeText+"</span>"+
                            "<input type='hidden' name='bagtypeIds_"+rowid+"[]' id='bagtypeIds"+rowid+"' value='" + bagTypehiddenIds + "'/>"+
                            "</td>"+
                            "<td>"+
                            "<span id='chest"+rowid+"'>"+chestText+"</span>"+
                            "<input type='hidden' name='chestvalues_"+rowid+"[]' value='" + chestValue + "'/>"+
                            "</td>"+
                            "</tr></table>";
                }


                var err = 0;
                
                
                if(createspan=="" ){
                    var err =1;
                    alert("Add package and net on clicking on Bags(+)");
                    
                }
                if (($('#lot').val()) == '')
                {
                    err = 1;
                    $("#lot").addClass("glowing-border");
                }
                if (($('#invoice').val()) == '')
                {
                    err = 1;
                    $("#invoice").addClass("glowing-border");
                }
                /*if(($('#gpno').val()) == '' )
                 {
                 err = 1 ;
                 $( "#gpno" ).addClass( "glowing-border" );
                 }
                 if(($('#date').val()) == '' )
                 {
                 err = 1 ;
                 $( "#date" ).addClass( "glowing-border" );
                 }*/
                
                if (($('#price').val()) == '')
                {
                    err = 1;
                    $("#price").addClass("glowing-border");
                }
                if (($('#garden').val()) == 0)
                {
                    err = 1;
                    $("#gardenerr").addClass("glowing-border");
                }
                if (purType != 'SB') {
                    if (($('#warehouse').val()) == 0)
                    {
                        err = 1;
                        $("#wareerr").addClass("glowing-border");
                    }
                }
                if (($('#grade').val()) == 0)
                {
                    err = 1;
                    $("#gradeerr").addClass("glowing-border");
                }
               

                if (($('#gross').val()) == '')
                {
                    err = 1;
                    $("#gross").addClass("glowing-border");
                }

                if ($('#chfrom').val() > $('#chto').val())
                {
                    err = 1;
                    $('#chto').val('');
                    $("#chto").addClass("glowing-border");

                }


                if (err == 0)
                {
                    if (purType != 'SB') {
                        var warehouseText = $("#warehouse option:selected").text() + "<input type='hidden' id='detailwarehouseid" + rowid + "'  name='detailwarehouseid[]' value='" + $("#warehouse option:selected").val() + "'/><br/>";
                    } else {
                        var warehouseText = $("#stockLocation option:selected").text() + "<input type='hidden' id='detailLocationid" + rowid + "'  name='detailLocationid[]' value='" + $("#stockLocation option:selected").val() + "'/><br/>";
                    }
                    $("#detailtr" + rowid).html(
                            "<td>" +
                            "<span id='lot" + rowid + "'>"
                            + $('#lot').val() + "</span><input type='hidden' name='detailtableid[]' value='" + rowid + "' />" +
                            "<input type='hidden' name='detaillot[]' value='" + $('#lot').val() + "'/><br/>" +
                            "<span id='do" + rowid + "'>" + $('#do').val() + "</span><input type='hidden' name='detaildo[]' value='" + $('#do').val() + "' /><br/>" +
                            "<span id='dodate" + rowid + "'>" + $('#dodate').val() + "</span>" +
                            "<input type='hidden' id='detailDoRelDate' name='detaildodate[]' value='" + $('#dodate').val() + "'/>" +
                            "</td>" +
                            "<td><span id='invoice" + rowid + "'>" + $('#invoice').val() + "</span><input type='hidden' name='detailinvoice[]' value='" + $('#invoice').val() + "' /></td>" +
                            "<td>" + $("#garden option:selected").text() + "<input type='hidden' id='detailgardenid" + rowid + "' name='detailgardenid[]' value='" + $("#garden option:selected").val() + "'/><br/>"
                            + warehouseText +
                            $("#teagroup option:selected").text() + "<input type='hidden'  name='detailteagroupid[]' id='detailteagroupid" + rowid + "' value='" + $("#teagroup option:selected").val() + "'/></td></td>" +
                            "<td><span name='grade[]'>" + $("#grade option:selected").text() +
                            "</span>"+
                            "<input type='hidden' id='detailgradeid" + rowid + "' name='detailgradeid[]' value='" + $("#grade option:selected").val() + "'/>" +
                            "<input type='hidden' id='detailchfrom" + rowid + "'  name='detailchfrom[]' value='" + $("#chfrom").val() + "'/>" +
                            "<input type='hidden' id='detailchto" + rowid + "'  name='detailchto[]' value='" + $("#chto").val() + "'/></td>" +
                            "<td><span id='gpnumber" + rowid + "'>" +
                            $('#gpno').val() +
                            "</span><input type='hidden'  name='detailgpno[]' value='" + $('#gpno').val() + "' /><br/>" +
                            "<span id='gpdate" + rowid + "'>" + $('#date').val() +
                            "</span><input type='hidden'  name='detaildate[]' value='" + $('#date').val() + "'/></td>" +
                            "<td>"+
                            "<span id='stamp" + rowid + "'>" + $('#stamp').val() + "</span>" +
                            "<input type='hidden'  name='detailstamp[]' value='" + $('#stamp').val() + "'/>"+
                            "</td>" +
                            "<td>" + sample + "</td>" +
                            "<td><span id='gross" + rowid + "'>" +
                            $('#gross').val() +
                            "</span><input type='hidden' id='detailgross" + rowid + "' name='detailgross[]' value='" + $('#gross').val() + "'/><br/>" +
                            "<span id='brokerage" + rowid + "'>" + $('#brok').val() + "</span>" +
                            "<input type='hidden' class='listbrok' name='detaillistbrokerage[]' value='" + $('#brok').val() + "'/></td>" +
                            "<td>" + calculateTotalWeight() + "<input type='hidden' name='detaillisttweight[]' value='" + calculateTotalWeight() + "'/><br/>" +
                            getOption() + " => " + $('#taxrate').val() +
                            "<input type='hidden' id='ratetypevalue" + rowid + "' name='detailvat[]' value='" + $('#taxrate').val() + "'/>" +
                            "<input type='hidden' id='ratetype" + rowid + "' name='rate_type[]' value='" + $('input[name=type]:checked').val() + "'/>" +
                            "<input type='hidden' class='fieldvatrate' name='fieldvatrate[]' id='fieldvatrate" + rowid + "' value=''/>" +
                            "<input type='hidden' class='fieldcstrate' id='fieldcstrate" + rowid + "' name='fieldcstrate[]' value=''/>" +
                            "<input type='hidden' id='ratetypeid" + rowid + "' name='rate_type_id[]' value='" + $("#optionrate option:selected").val() + "'/></td>" +
                            "<td>" +
                            "<span id='price" + rowid + "'>" + $('#price').val() +
                            "</span><input type='hidden' name='detailprice[]' value='" + $('#price').val() + "'/><br/>" +
                            "<span id='stax" + rowid + "'>" + $('#stax').val() + "</span><input type='hidden' name='detailstax[]' value='" + $('#stax').val() + "'/>" +
                            "<input type='hidden' id='servicetaxid" + rowid + "'  name='stax_id[]' value='" + $("#optionstax option:selected").val() + "'/></td>" +
                            "<td>" + calculateValue() + 
                            "<input type='hidden' value='" + calculateValue() + "' name='detailvalue[]'/><br/> "
                            + calculatetotal() + "<input type='hidden' value='" + calculatetotal() + "' name='detaillisttotal[]'/></td>" +
                            "<td><img src='" + basepath + "application/assets/images/delete.png' height='20' width='20' onclick='deleterow(\"detailtr\"," + rowid + ")'/><img width='20' height='20' onclick='editrow(\"detailtr\"," + rowid + ")' src='" + basepath + "application/assets/images/edit.jpg'/></td>");

                    calculateratetypetotal(rowid);
                    calculateTeavalue();
                    calculateTotalBrokerage();
                    calculateTotalServiceTax();
                    calculateTotalVatrate();
                    claculeteTotalPurchaseInvoice();
                    calculateTotalStamp();
                    makealltextblank();

                    $(this).dialog("close");
                }

            },
            Cancel: function() {
                $(this).dialog("close");
                $("#popupwindow input:text").val("");
                $("#popupwindow select").val(0);
                $("#addsamplehere").html('');
            }
        }
    });

}


/**
 * @method deleteSalertobuyer.
 * @param {type} masterid
 * @returns {undefined}
 * @modified by Abhik for stop deletion,on 12/06/2015
 */

function deleteSalertobuyer(masterid)
{
    $("#dialog-confirm_purchase_delete").css('display', "block");


    $("#dialog-confirm_purchase_delete").dialog({
        resizable: false,
        height: 140,
        modal: true,
        buttons: {
            "Ok": function() {
                $(this).dialog("close");
                /* var basepath = $("#basepath").val();
                 $.ajax({
                 type: "POST",
                 data: {masterid: masterid},
                 url: basepath + "purchaseinvoice/deleteRecord",
                 success: function(data)
                 {
                 $("#row" + masterid).remove();
                 }
                 
                 });*/
            },
            /*Cancel: function() {
             $(this).dialog("close");
             }*/
        }
    });
}
