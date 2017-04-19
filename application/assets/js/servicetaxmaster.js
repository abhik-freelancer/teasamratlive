$(document).ready(function() {

    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: '01-04-' + session_strt_date,
        maxDate: '31-03-' + session_end_date
    });

    $(".datepicker").change(function() {
        checkDates($("#from").val(), $("#to").val());
    });

    /**adding service tax**/
    $("#add_service").click(function() {

        $('#adddiv').show('slow', function() {
            $("#service_addform").trigger('reset');
            $('.buttondiv').html('<div class="save" id="service_save" align="center">Save</div>');

        });


    });

    $(document).on("click", "#service_save", function() {
        var rate = $("#rate").val();
        var from = $("#from").val();
        var to = $("#to").val();

        var err = 0;
        if ($("#rate").val() == '')
        {
            err = 1;
            $("#rate").addClass("glowing-border");
        }
        else if ($("#from").val() == '')
        {
            err = 1;
            $("#from").addClass("glowing-border");
        }
        else if ($("#to").val() == '') {
            err = 1;
            $("#to").addClass("glowing-border");
        } else {
            err = 0;
        }


        if (err == 0)
        {
            $.ajax({
                type: "POST",
                url: basepath + "servicetaxmaster/add",
                data: {rate: rate, from: from, to: to},
                success: function(data)
                {
                    if (data == 1) {
                        dialog.dialog("open");
                    } else {
                        alert("data fail to save");
                        return false;
                    }
                },
                complete: function() {

                }
            });
        }





    });


    $("#edit").click(function() {
        var selected = $("input[type='radio'][name='action']:checked");
        if (selected.length > 0) {
            selectedVal = selected.val();
            $('#rate').val($('#rate' + selectedVal).html());
            $('#from').val($('#from' + selectedVal).html());
            $('#to').val($('#to' + selectedVal).html());
            $('.buttondiv').html('<input type="hidden" id="id" name="id" value="' + selectedVal + '"/><div class="save" id="update" align="center">Update</div>');
            $('#adddiv').show('slow', function() {
            });


            var err = 0;


            $("#update").click(function() {
                var rate = $("#rate").val();
                var from = $("#from").val();
                var id = $("#id").val();
                var to = $("#to").val();

                $.ajax({
                    type: "POST",
                    url: basepath + "servicetaxmaster/modify",
                    data: {id: id, rate: rate, from: from, to: to},
                    success: function(data)
                    {
                        /*$('#rate' + selectedVal).html(rate);
                         $('#from' + selectedVal).html(from);
                         $('#to' + selectedVal).html(to);
                         
                         $('#adddiv').hide('slow',function(){
                         $("#service_addform").trigger('reset');
                         });*/
                        dialog.dialog("open");

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
                url: basepath + "servicetaxmaster/delete",
                data: {id: selectedVal},
                success: function(data)
                {
                    //	 $('#row'+selectedVal).remove();
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




    /**adding service tax**/

    dialog = $("#dialog-save").dialog({
        autoOpen: false,
        resizable: false,
        height: 140,
        modal: true,
        buttons: {
            "Ok": function() {
                /*$('#adddiv').hide('slow', function() {
                 $("#service_addform").trigger('reset');
                 });*/
                location.reload(true);
                $(this).dialog("close");
            }
        }
    });




    $(".mini").click(function() {


        $('#edit').css('visibility', 'visible');
        $('#del').css('visibility', 'visible');
    });

    $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
    $(".servicetaxmaster").addClass(" active ");
    $(".scmenu3").removeClass("collapse");
    
    
    $('#rate').keypress(function (event) {
            
            return isNumber(event, this)

        });   
    
    
    
//*end document
});

function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode;

        if (
            (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57)&&(charCode != 8))
            return false;

        return true;
    }    

