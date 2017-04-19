

var basepath = $("#basepath").val();
function deletedetail(id)
{
    $.ajax({
        type: "POST",
        url: basepath + "customermaster/deletedetail",
        data: {iddata: id},
        success: function()
        {
            $('#row' + id).remove();

        }

    });
}
$(function() {

    var basepath = $("#basepath").val();


    $("#save").click(function() {
        var err = 0;
        if ($("#name").val() == '')
        {
            err = 1;
            $("#name").addClass("glowing-border");
        }
        if ($("#state").val() == 0)
        {
            err = 1;
            $("#stateerr").addClass("glowing-border");
        }
        if (err == 0)
        {
            $("#spinner").show();
            $("#addcustomer").submit();
        }

    });

    $("#editdetail").click(function() {

        $("#spinner").show();
        $("#editcustomer").submit();

    });

    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;

    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate
    });

    $("#adddetail").click(function() {

        $('#mybody').append('<tr><td>' + $("#bnumber").val() + '<input type="hidden" id="bnumber" name="listbnumber[]" value="' + $("#bnumber").val() + '"/></td><td>' + $("#bdate").val() + '<input type="hidden" id="bdate" name="listbdate[]" value="' + $("#bdate").val() + '"/></td><td>' + $("#ddate").val() + '<input type="hidden" id="ddate" name="listddate[]" value="' + $("#ddate").val() + '"/></td><td>' + $("#bamount").val() + '<input type="hidden" id="bamount" name="listbamount[]" value="' + $("#bamount").val() + '"/></td><td>' + $("#damount").val() + '<input type="hidden" id="damount" name="listdamount[]" value="' + $("#damount").val() + '"/></td></tr>');

        $('#addsection').find('input').val('');

    });

    $("#del").click(function() {
        var selected = $("input[type='radio'][name='action']:checked");
        if (selected.length > 0) {
            selectedVal = selected.val();
            aom = $('#aom' + selectedVal).val();
            am = $('#am' + selectedVal).val();

            $.ajax({
                type: "POST",
                url: basepath + "customermaster/delete",
                data: {id: selectedVal, aom: aom, am: am},
                success: function(data)
                {
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
        $(".editmaster").attr("href", basepath + 'customermaster/editpage/customer/' + this.id);

        $('#del').css('visibility', 'visible');
        $('#opendiv').css('visibility', 'visible');

        $("#selid").val(this.id);

        /*  $.ajax({
         type: "POST",
         url:   basepath+"customermaster/dispalyEditDetails",
         data:  {id: this.id},
         success: function(data)
         {
         $('#mybody').html(data);
         
         }
         
         });*/

    });


    $(document).ready(function() {

        $(".legal-menu" + $('#mastermenu').val()).addClass(" collapse in ");
        $(".customermaster ").addClass(" active ");

    });

    $(".detailopenmaster").click(function() {

        $("#example2").dialog({
            resizable: true,
            height: 200,
            width: 800,
            modal: true,
            buttons: {
                "Close": function() {
                    $(this).dialog("close");


                }

            }
        });

        $("#example2").css("width", '800');
    });

});
