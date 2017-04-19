/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function isSession(selector) {
    return $.ajax({
        type: "POST",
        url: '/order.html',
        data: {
            issession: 1,
            selector: selector
        },
        dataType: "html",
        async: !1,
        error: function() {
            alert("Error occured")
        }
    });
}
// global param
var selector = !0;
// get return ajax object
var ajaxObj = isSession(selector);
// store ajax response in var
var ajaxResponse = ajaxObj.responseText;
// check ajax response
console.log(ajaxResponse);
// your ajax callback function for success
ajaxObj.success(function(response) {
    alert(response);
});

//////////////////////////////
$.extend({
    xResponse: function(url, data) {
        // local var
        var theResponse = null;
        // jQuery ajax
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            dataType: "html",
            async: false,
            success: function(respText) {
                theResponse = respText;
            }
        });
        // Return the response text
        return theResponse;
    }
});

// set ajax response in var
var xData = $.xResponse('temp.html', {issession: 1,selector: true});

// see response in console
console.log(xData);