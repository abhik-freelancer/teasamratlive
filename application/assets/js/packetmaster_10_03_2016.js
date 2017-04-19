$(document).ready(function() {

        $('#packetQty').keypress(function (event) {
            
            return isNumber(event, this)

        });        

    });

function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }    
    
 
function openPacketAdd()
{
    $("#addform").trigger('reset');
    $('#adddiv').show('slow', function() {
        $("#packet").val("");
        $("#packetQty").val();
        
    });
    $('.buttondiv').html('<div class="save" id="save" align="center">Save</div>');
    $("#save").click(function() {
        $("#spinner").show();


        var basepath = $("#basepath").val();
        var packet = $("#packet").val();
       // var whouse = $("#whouse option:selected").val();
       var packetQty = $("#packetQty").val();
        


        $.ajax({
            type: "POST",
            url: basepath + "packet/add",
            data: {packet: packet, packetQty: packetQty},
            success: function(data)
            {
                if (data == 'err')
                {
                    $("#spinner").hide();
                    $("#err").html("combination already exist");
                }
                else
                {
                    window.location.href = basepath + 'packet';
                }
            }

        });

        return false;  //stop the actual form post !important!

    });
}

$(function() {

    var basepath = $("#basepath").val();

    $("#edit").click(function() {

        var selected = $("input[type='radio'][name='action']:checked");
        if (selected.length > 0) {
            selectedVal = selected.val();

            
            $("#packet").val($('#packet' + selectedVal).html());
            $("#packetQty").val($('#packQty'+selectedVal).html());
            //jWhid = "#id_warehouse"+selectedVal;
           // warehouseId = $(jWhid).val();
           // $('#whouse option[value='+warehouseId+']').attr('selected', 'selected');
          
            $('.buttondiv').html('<input type="hidden" id="id" name="id" value="' + selectedVal + '"/><div class="save" id="update" align="center">Update</div>');
            $('#adddiv').show('slow', function() {
            });

            $("#update").click(function() {

                var packet = $("#packet").val();
                var pcktQty = $("#packetQty").val();
                var id = $("#id").val();
                


                $.ajax({
                    type: "POST",
                    url: basepath + "packet/modify",
                    data: {id: id, packet: packet, packQty: pcktQty},
                    success: function(data)
                    {

                        if (data == 'err')
                        {
                            $("#err").html("combination already exist");
                        }
                        else
                        {
                            $('#packet' + selectedVal).html($("#packet").val());
                           
                            $('#packQty' + selectedVal).html($("#packetQty").val());

                            $('#adddiv').hide();
                            $("#addform").trigger('reset');
                        }

                        //alert('successfully updated');
                    }

                });

                return false;  //stop the actual form post !important!

            });
        }
    });



  //delete start here
 $("#del").click(function() {
        $("#dialog-confirm-packet").css('display', "block");
        
        $("#dialog-confirm-packet").dialog({
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
                            url: basepath + "packet/delete",
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


    $(document).ready(function() {

        $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
        $(".packet").addClass(" active ");
        //$(".scmenu3").removeClass("collapse");



    });

});
