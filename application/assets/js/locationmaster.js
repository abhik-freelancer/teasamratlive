
function openLocationAdd()
{
    $("#addform").trigger('reset');
    $('#adddiv').show('slow', function() {
        $("#location").val("");
        $('#whouse option[value=0]').attr('selected', 'selected');
        
    });
    $('.buttondiv').html('<div class="save" id="save" align="center">Save</div>');
    $("#save").click(function() {
        $("#spinner").show();


        var basepath = $("#basepath").val();
        var location = $("#location").val();
        var whouse = $("#whouse option:selected").val();
        


        $.ajax({
            type: "POST",
            url: basepath + "locationmaster/add",
            data: {location: location, warehouseid: whouse},
            success: function(data)
            {
                if (data == 'err')
                {
                    $("#spinner").hide();
                    $("#err").html("combination already exist");
                }
                else
                {
                    window.location.href = basepath + 'locationmaster';
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

            
            $("#location").val($('#location' + selectedVal).html());
            jWhid = "#id_warehouse"+selectedVal;
            warehouseId = $(jWhid).val();
            $('#whouse option[value='+warehouseId+']').attr('selected', 'selected');
          
            $('.buttondiv').html('<input type="hidden" id="id" name="id" value="' + selectedVal + '"/><div class="save" id="update" align="center">Update</div>');
            $('#adddiv').show('slow', function() {
            });

            $("#update").click(function() {

                var location = $("#location").val();
                var whouse = $("#whouse option:selected").val();
                var id = $("#id").val();
                


                $.ajax({
                    type: "POST",
                    url: basepath + "locationmaster/modify",
                    data: {id: id, location: location, warehouseid: whouse},
                    success: function(data)
                    {

                        if (data == 'err')
                        {
                            $("#err").html("combination already exist");
                        }
                        else
                        {
                            $('#location' + selectedVal).html($("#location").val());
                           
                            $('#warehouse' + selectedVal).val($("#whouse option:selected").val());

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



    $("#del").click(function() {
        var selected = $("input[type='radio'][name='action']:checked");
        if (selected.length > 0) {
            selectedVal = selected.val();
            $.ajax({
                type: "POST",
                url: basepath + "locationmaster/delete",
                data: {id: selectedVal},
                success: function(data)
                {
                    //$('#row'+selectedVal).remove();
                    if (data == 0)
                    {
                        alert("Cannot delete this record: Already exist in another table");
                    }
                    else
                    {
                        $('#row' + selectedVal).remove();
                    }

                }

            });

            return false;  //stop the actual form post !important!


        }
    });


    $(".mini").click(function() {


        $('#edit').css('visibility', 'visible');
        $('#del').css('visibility', 'visible');
    });


    $(document).ready(function() {

        $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
        $(".locationmaster").addClass(" active ");
        //$(".scmenu3").removeClass("collapse");



    });

});
