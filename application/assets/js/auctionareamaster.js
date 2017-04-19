$(document).ready(function() {

    });


 
function openAuctionAreaAdd()
{
    $("#addform").trigger('reset');
    $('#adddiv').show('slow', function() {
        $("#AuctionArea").val("");
        $("#transCost").val(""); // by mithilesh
       
        
    });
    $('.buttondiv').html('<div class="save" id="save" align="center">Save</div>');
    $("#save").click(function() {
        $("#spinner").show();


        var basepath = $("#basepath").val();
        var area = $("#AuctionArea").val();
        var transCost = $("#transCost").val();
      


        $.ajax({
            type: "POST",
            url: basepath + "auctionarea/add",
            data: {auctionarea: area,transCost:transCost},
            success: function(data)
            {
                if (data == 'err')
                {
                    $("#spinner").hide();
                    $("#err").html("combination already exist");
                }
                else
                {
                    window.location.href = basepath + 'auctionarea';
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

            
            $("#AuctionArea").val($('#auc_area' + selectedVal).html());
            $("#transCost").val($('#trans_cost' + selectedVal).html());
            
          
            $('.buttondiv').html('<input type="hidden" id="id" name="id" value="' + selectedVal + '"/><div class="save" id="update" align="center">Update</div>');
            $('#adddiv').show('slow', function() {
            });

            $("#update").click(function() {

                var aucArea = $("#AuctionArea").val();
                var transCost = $("#transCost").val();
                var id = $("#id").val();
                


                $.ajax({
                    type: "POST",
                    url: basepath + "auctionarea/modify",
                    data: {id: id, auctionArea: aucArea,transCost:transCost},
                    success: function(data)
                    {

                        if (data == 'err')
                        {
                            $("#err").html("combination already exist");
                        }
                        else
                        {
                            $('#auc_area' + selectedVal).html($("#AuctionArea").val());
                            $('#trans_cost' + selectedVal).html($("#transCost").val());
                           
                           
                           

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
        $("#dialog-confirm-aucArea").css('display', "block");
        
        $("#dialog-confirm-aucArea").dialog({
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
                            url: basepath + "auctionarea/delete",
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
        $(".auctionarea").addClass(" active ");
        //$(".scmenu3").removeClass("collapse");



    });

});
