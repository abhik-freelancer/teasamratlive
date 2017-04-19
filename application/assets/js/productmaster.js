$(document).ready(function() {

    $('#addproduct').click(function() {
        $("#frmaddproduct").trigger('reset');
        $('#adddiv').show('slow', function() {
            $("#product").val("");
            $("#productdesc").val("");
            $("#drp_packet").val("");
            $('#drp_packet').multipleSelect();
        });
    });
    $('.buttondiv').html('<div class="save" id="save" align="center">Save</div>');
    //save start from here
    $('#save').click(function() {
        $("#spinner").show();
        // var productExist=0;
        var basepath = $("#basepath").val();
        var product = $("#product").val();
        var productDesc = $("#productdesc").val();
        var packet = "";
        var error = 0;
        $('input[name="selectItemdrp_packet"]:checked').each(function() {
            packet = packet + this.value + "~";
        });
        //alert(packet) 
        if (packet != '') {
            $("#packets").val(packet);
        } else {
            $("#packets").val("");
        }

        if (product == "") {
            $("#spinner").hide();
            error = 1;
            $("#product").addClass("glowing-border");
            return false;
        }
        /* if(packet==""){
         $("#spinner").hide();
         error =1;
         $(".ms-choice").addClass("glowing-border");
         return false;
         }*/

        /* $.ajax({
         type: "POST",
         url: basepath + "product/IsProductExist",
         data: {product: product},
         success: function(data)
         {
         if (data == '1')
         {
         $("#spinner").hide();   
         $("#err").text("Product already exist.");return false;
         }
         
         }
         
         });*/
        // data saving ajax
        if (error != 1) {
            $.ajax({
                type: "POST",
                url: basepath + "product/add",
                data: {product: product, productdesc: productDesc, packets: packet},
                success: function(data)
                {

                    if (data != '1')
                    {
                        $("#spinner").hide();
                        $("#err").html("Error in insertion..");
                    }
                    else
                    {
                        window.location.href = basepath + 'product';
                    }
                }

            });

        }
    });


    //save end here

    //edit start from here
    $('#edit').click(function() {

        var selected = $("input[type='radio'][name='action']:checked");
        if (selected.length > 0) {

            var selected_product_id = selected.val();
            var selected_packets;
            $("#product").val($('#product' + selected_product_id).html());
            $("#productdesc").val($('#productdesc' + selected_product_id).html())
            $('#drp_packet').multipleSelect();
            selected_packets = $('#id_packets' + selected_product_id).val().trim();

            var pkt_arr = selected_packets.split(',');
            $("#drp_packet").multipleSelect("setSelects", pkt_arr);



            $('.buttondiv').html('<input type="hidden" id="id" name="id" value="' + selected_product_id + '"/><div class="save" id="update" align="center">Update</div>');
            $('#adddiv').show('slow', function() {
            });

        }
        //update  here
        $("#update").click(function() {
            $("#spinner").show();

            var basepath = $("#basepath").val();
            var product = $("#product").val();
            var productDesc = $("#productdesc").val();
            var productId = $("#id").val();
            var packet = "";
            var error = 0;
            $('input[name="selectItemdrp_packet"]:checked').each(function() {
                packet = packet + this.value + "~";
            });

            if (packet != '') {
                $("#packets").val(packet);
            } else {
                $("#packets").val("");
            }

            if (product == "") {
                $("#spinner").hide();
                error = 1;
                $("#product").addClass("glowing-border");
                return false;
            }

            // data saving ajax
            if (error != 1) {
                $.ajax({
                    type: "POST",
                    url: basepath + "product/modify",
                    data: {productid: productId, product: product, productdesc: productDesc, packets: packet},
                    success: function(data)
                    {

                        if (data != '1')
                        {
                            $("#spinner").hide();
                            $("#err").html("Error in updation..");
                        }
                        else
                        {
                            window.location.href = basepath + 'product';
                        }
                    }

                });

            }

        });
        //update  here
    });

   

    //edit end here
    //delete start here
 $("#del").click(function() {
        $("#dialog-confirm").css('display', "block");
        
        $("#dialog-confirm").dialog({
            resizable: false,
            height: 140,
            modal: true,
            buttons: {
                "Delete": function() {
                    $(this).dialog("close");
                    var basepath = $("#basepath").val();
                    var selected = $("input[type='radio'][name='action']:checked");
                    if (selected.length > 0) {
                        selectedVal = selected.val();
                        $.ajax({
                            type: "POST",
                            url: basepath + "product/delete",
                            data: {id: selectedVal},
                            success: function(data)
                            {
                                if (data == 0)
                                {
                                    alert("Cannot delete this record: Already exist in another transaction");
                                }
                                else
                                {
                                    $('#row' + selectedVal).remove();
                                }

                            }

                        });

                        return false;  //stop the actual form post !important!
                        

                    }
               },
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });
    });
    //delete end here

    $(".mini").click(function() {
        $('#edit').css('visibility', 'visible');
        $('#del').css('visibility', 'visible');
    });
    $(".legal-menu" + $('#mastermenu').val()).addClass("collapse in ");
    $(".product").addClass(" active ");

});//document ready

/*
 $(function() {
 $( "#dialog-confirm" ).dialog({
 resizable: false,
 height:140,
 modal: true,
 buttons: {
 "Delete all items": function() {
 $( this ).dialog( "close" );
 },
 Cancel: function() {
 $( this ).dialog( "close" );
 }
 }
 });
 });
 
 */




/**$('select').multipleSelect({
 styler: function(value) {
 if (value == '1') {
 return 'background-color: #ffee00; color: #ff0000;';
 }
 if (value == '6') {
 return 'background-color: #000; color: #fff;';
 }
 }
 });*/
/*multiselect
 $('#drp_packet').multipleSelect({
 onClick: function(view) {
 //alert(view.label + '(' + view.value + ') '+(view.checked ? 'checked' : 'unchecked'));
 }
 });*/
//$("#[id$=drp_packet]").multipleSelect("uncheckAll");