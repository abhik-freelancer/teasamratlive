$(document).ready(function () {
    $(".legal-menu" + $('#reportmenu').val()).addClass(" collapse in ");
    $(".stocksummeryall").addClass(" active ");

    var basepath = $("#basepath").val();
    var session_strt_date = $('#startyear').val();
    var session_end_date = $('#endyear').val();
    var mindate = '01-04-' + session_strt_date;
    var maxDate = '31-03-' + session_end_date;

    $("#toDate").datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: mindate,
        maxDate: maxDate,
        

    }).datepicker("setDate", "0");

    $("#stkreport").click(function () {
        var group_id = $("#group_code option:selected").val();
        var fromPrice = $("#fromPrice").val();
        var toPrice = $("#toPrice").val();
        var toDate = $("#toDate").val();
        $("#loader").show();

        $.ajax({
            url: basepath + "stocksummeryall/getStock",
            type: 'post',
            data: {groupId: group_id, fromPrice: fromPrice, toPrice: toPrice,toDate:toDate},
            dataType: 'html',
            success: function (data) {
                $("#popupdiv").show("clip", 500);
                $('#popupdiv').html(data);
            },
            complete: function () {
                $("#loader").hide();
            },
            error: function (e) {
                console.log(e.message);
            }
        });


    });


    $(document).on('keyup', '#fromPrice', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        }

    });

    $(document).on('keyup', '#toPrice', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
            this.value = this.value.replace(/[^0-9\.]/g, '');
        }

    });


    $("#stkreportPrint").click(function () {
        var group_id = $("#group_code option:selected").val();
        var fromPrice = $("#fromPrice").val();
        var toPrice = $("#toPrice").val();
		$("#frmStock").submit();
	});

   
});
