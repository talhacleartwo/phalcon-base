var $a = $(".dropdownfilter,.company,.service").select2({
    width: 'resolve', // need to override the changed default
    placeholder: "Select Type"
});


var $a = $(".service,.companyrefre").select2({
    width: 'resolve', // need to override the changed default
    placeholder: "Select Type"
});
var $a = $(".popupcompanydata").select2({
    width: 'resolve', // need to override the changed default
    placeholder: "Select Type"
});
var $a = $(".refreeename").select2({
    width: 'resolve', // need to override the changed default
    placeholder: "Select"
});


var $a = $("#users").select2({
    width: 'resolve', // need to override the changed default
    placeholder: "Select User"
});
var $a = $(".loadexistingproductoption").select2({
    width: 'resolve', // need to override the changed default
    placeholder: "Select Product"
});
var $a = $(".mechanics").select2({
    width: 'resolve', // need to override the changed default
    placeholder: "Select"
});
$('.service').on("select2:unselect", function (e) {
    var iid = e.params.data.id;
    $('#table' + iid).remove();
    $('.table' + iid).remove();
});


$('.service').on("select2:unselect", function (e) {
    var sum = parseInt(0);
    var sum1 = parseInt(0);

    $('.leadproducts').each(function () {
        sum1 = sum1 + parseFloat($(this).attr('data-duration'));
    });
    var mechanic = parseFloat($('.mechanics').children("option:selected").attr('data-value'));

    $('.extendendamount').each(function () {
        sum = sum + parseFloat($(this).val());
    });


    $('.durationfield input').val(sum1);

    $('.subtotal span').html(sum.toFixed(2));
    var duration = $('#duration').val();
    $('.mechanicprice').html('£ ' + mechanic * duration);
    if (parseInt(mechanic)) {
        sum = sum + mechanic * duration;
    }
    if (!isNaN(sum)) {
        $('.totalprice').html('£ ' + sum.toFixed(2));
    }
});
$('.service').on("select2:select", function (e) {
    $('.table').removeClass('hide');
    $('.card-footer').css('clear', 'both');
    var iid = e.params.data.id;
    if ($('#newbookingdirect').val() != undefined) {
        var formdata = {
            'user_id': iid,
            'newbookingdirect': 1,
        }
    } else {
        var formdata = {
            'user_id': iid,
        }
    }

    $.ajax({
        type: "POST",
        url: "/api/getproducts",
        data: formdata,
        success: function (data) {
            $('#products').prepend(data);
            var mechanic = parseInt($('.mechanics').children("option:selected").attr('data-value'));
            var sum = parseFloat(0);
            var sum1 = parseInt(0);

            $('.extendendamount').each(function () {
                sum = sum + parseFloat($(this).val());
            });
            $('.leadproducts').each(function () {
                sum1 = sum1 + parseInt($(this).attr('data-duration'));
            });
            $('.durationfield input').val(sum1);
            $('.subtotal span').html(sum.toFixed(2));
            var duration = $('#duration').val();
            $('.mechanicprice').html('£ ' + mechanic * duration);
            if (parseInt(mechanic)) {
                sum = sum + mechanic * duration;
            }

            $('.totalprice').html('£ ' + parseFloat(sum.toFixed(2)));
        }
    });
});
$('.mechanics').on("select2:select", function (e) {
    $('.table').removeClass('hide');
    $('.card-footer').css('clear', 'both');
    var mechanic = parseFloat($('.mechanics').children("option:selected").attr('data-value'));
    var sum = parseFloat(0);

    $('#tableaddnew tbody td:last-child').each(function () {
        sum = sum + parseFloat($(this).attr('data-cost-value'));
    })
    $('.subtotal span').html('£ ' + sum.toFixed(2));
    $('.mechanicprice').html('£ ' + mechanic);
    if (parseFloat(mechanic)) {
        sum = sum + mechanic;
    }
    $('.totalprice').html('£ ' + sum);
});


$('.dropdownfilter').on("select2:select", function (e) {
    var iid = e.params.data.title;
    $('#leaddetail').val(iid)

         $.ajax({
            type: "POST",
            url: "/api/getcar",
            data: {'user_id': iid},
            success: function (data) {

                 var a = JSON.parse(data);
                $('#newcar').attr('checked',false);
                $(".cardropdown").html("<option></option>");
                if(a.car!=null) {
                    for (var i = 0; i < a.car.length; i++) {

                        b = a.car[i];
                        $(".cardropdown")
                            .append($("<option></option>")
                                .attr("value", b['id'])
                                .text(b.carmake + '(' + b.registration + ')'));
                    }
                }
                $('.addnewcustomer input[name=fname]').val(a.customerdetail['fname']);
                $('.addnewcustomer input[name=lname]').val(a.customerdetail['lname']);
                $('.addnewcustomer input[name=phoneno]').val(a.customerdetail['phoneno']);
                $('.addnewcustomer input[name=email]').val(a.customerdetail['email']);
                $('.addnewcustomer input[name=address1]').val(a.customerdetail['address']);
                $('.addnewcustomer input[name=city]').val(a.customerdetail['city']);
                $('.addnewcustomer input[name=town]').val(a.customerdetail['town']);
                $('.addnewcustomer input[name=postCode]').val(a.customerdetail['postCode']);
                $('.addnewcustomer input[name=dob]').val(a.customerdetail['dob']);

                 // });

            }
        });

});

// Check Whether company exists or not

$('#existingcompany').click(function(){
    $('.addnewcompany').addClass('hide');
    $('#newcompany').prop('checked',false);
    $('.existingcompanylist').removeClass('hide');
    $('.company').val("");
})
$('#newcompany').click(function(){
    $('#existingcompany').prop('checked',true);
    $('.addnewcompany').removeClass('hide');
    $('.existingcompanylist').addClass('hide');
    $('.existingcompanylist input').val("");
    $('.company').val("");
})



$('.company').on("select2:select", function (e) {
    var id = e.params.data.id;

    if (id == "addnewcompany") {
        $('.addnewcompany').removeClass('hide');
    } else {
        $('.addnewcompany').addClass('hide');
        $.ajax({
            // dataType: "json",
            type: "POST",
            url: "/api/getleads",
            data: {'user_id': id},
            success: function (data) {
			
                a = JSON.parse(data);


                for (var i = 0; i < a.length; i++) {
                    b = a[i];
                    $(".dropdownfilter")
                        .append($("<option></option>")
                            .attr("value", b.id)
                            .attr("title", b.leadid)
                            .text(b.name));
                }

            }
        });
    }
});


var $a = $(".cardropdown").select2({
    width: 'resolve', // need to override the changed default
    placeholder: "Select Type"
});

$('#newcar').click(function(){
    if($(this).is(':checked'))
    {
        // $('.hideonaddnewcustomer select').prop('disabled',true)
      $('.addnewcar').removeClass('hide');
        $('.hideonaddnewcustomer').addClass('hide')
    }else{
        // $('.hideonaddnewcustomer select').prop('disabled',false)

        $('.hideonaddnewcustomer').removeClass('hide');
      //    $('.addnewcar').addClass('hide');
    }

    $('.addnewcar   input[name=registration]').val("");
    $('.addnewcar   input[name=carmake]').val("");
    $('.addnewcar   input[name=carmodel]').val("");
    $('.addnewcar   input[name=enginesize]').val("");
    $('.addnewcar   input[name=transmission]').val("");
});


$('.cardropdown').on("select2:select", function (e) {
    var id = e.params.data.id;

    $.ajax({
        // dataType: "json",
        type: "POST",
        url: "/api/cardetail",
        data: {'id': id},
        success: function (data) {
            var a=JSON.parse(data);
            $('.addnewcar   input[name=registration]').val(a['registration']);
            $('.addnewcar   input[name=carmake]').val(a['carmake']);
            $('.addnewcar   input[name=carmodel]').val(a['carmodel']);
            $('.addnewcar   input[name=enginesize]').val(a['enginesize']);
            $('.addnewcar   input[name=transmission]').val(a['transmission']);

        }
    });


    // if (id == "addnewcar") {
    //     $('.addnewcar').removeClass('hide')
    // } else {
    //     $('.addnewcar').addClass('hide');
    // }

});


$('.datepickers').datepicker({
    format: 'dd-mm-yyyy ',
    todayHighlight: true,
    orientation: "bottom auto",
    startView: 2,
    autoclose: true,
    todayBtn: true,
    calendarWeeks: true,
});

$('#followupdate').datepicker({
    format: 'dd-mm-yyyy ',
    todayHighlight: true,
    minDate: 0,
    startDate: new Date(),
    orientation: "bottom auto",
     autoclose: true,
    todayBtn: true,
    calendarWeeks: true,
});


jQuery('.checkboxcontainer input').change(function () {
    if ($(this).prop('checked')) {
        var status = $(this).val();
    } else {
        var status = "";
    }
    var id = $(this).attr('data-value');
    $.ajax({
        type: "POST",
        url: "/driver/updatestatus",
        data: {'user_id': id, 'status': status},
        success: function (data) {
            alert("Status Updated");
            // location.reload();
        }
    })
});


$('.paymentdate').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
    orientation: "bottom auto",
    startView: 2,
    autoclose: true,
    todayBtn: true,
    calendarWeeks: true,
});

$(document).on("change", "table tbody tr td input.productqty", function () {
    var totalprice;
    var qty = $(this).val();
    var peritemprice = $(this).attr('data-value');
    var size = $(this).parent().next().children('td input').val();
    if (size != "") {
        totalprice = size * peritemprice;
    }
    else {
        totalprice = peritemprice;
    }
    if (qty != "") {
        totalprice = qty * totalprice;
    }
    $(this).parent().next().next('td').html(totalprice);
    var mechanic = parseFloat($('.mechanics').children("option:selected").attr('data-value'));

    var sum = parseInt(0);


    $('.productprice').each(function () {
        sum = sum + parseFloat($(this).text());
    })
    $('.subtotal').html('£ ' + sum);

    var duration = $('#duration').val();
    $('.mechanicprice').html('£ ' + mechanic * duration);
    if (parseFloat(mechanic)) {
        sum = sum + mechanic * duration;
    }

    $('.totalprice').html('£ ' + sum);
})
$(document).on("change", "table tbody tr td input.productsize", function () {
    var totalprice;
    var qty = $(this).val();
    var peritemprice = $(this).attr('data-value');
    var size = $(this).parent().next().children('td input').val();
    if (size != "") {
        totalprice = size * peritemprice;
    }
    else {
        totalprice = peritemprice;
    }
    if (qty != "") {
        totalprice = qty * totalprice;
    }
    $(this).parent().next().next('td').html(totalprice);
    var mechanic = parseInt($('.mechanics').children("option:selected").attr('data-value'));

    var sum = parseInt(0);


    $('.extendendamount').each(function () {
        sum = sum + parseInt($(this).val());
    })

    $('.subtotal').html('£ ' + sum);
    var duration = $('#duration').val();
    $('.mechanicprice').html('£ ' + mechanic * duration);
    if (parseInt(mechanic)) {
        sum = sum + mechanic * duration;
    }
    $('.totalprice').html('£ ' + sum);
});

$('#newcontact').change(function (e) {
    if ($(this).is(':checked')) {
        $('.existingcustomer').addClass('hide');
        // $('.dropdownfilter').prop('disabled',true)
          $('#newcar').attr('checked',true);
         $('.addnewcar').removeClass('hide');
     }else{
        $('.existingcustomer').removeClass('hide');
      //  $('.addnewcar').addClass('hide');
        $('.hideonaddnewcustomer').removeClass('hide')
        // $('.dropdownfilter').prop('disabled',false)
        // $('#newcar').attr('readonly',false);
          $('#newcar').attr('checked',false);
     }
});
$('#companyask').change(function (e) {
    if ($(this).is(':checked')) {
         $('.existingcompanylist').removeClass('hide');
        $('.company').attr('disabled', false);
     }
    else {
        $('.company').attr('disabled', true);

        $('.company').parent().parent().addClass('hide');
        $('.addnewcompany').addClass('hide');
    }

})
$('.ownercompany').on('change', function () {
    var value = $(".ownercompany option:selected").text();

 
	
    if (value == "DKU") {
		$('.ecutype').addClass('hide');
        $('.dkureference').attr('type', 'text');
        $('.apreference').attr('type', 'hidden');
        $('.dkureference').attr('disabled', false)
        $('.apreference').attr('disabled', true);
    }
    else {
		
		$('.ecutype').removeClass('hide');
        $('.apreference').attr('disabled', false);
        $('.dkureference').attr('disabled', true)
        $('.dkureference').attr('type', 'hidden');
        $('.apreference').attr('type', 'text');
    }
    $.ajax({
        // dataType: "json",
        type: "POST",
        url: "/api/getcompanyservice",
        data: {'value': value},
        success: function (data) {
			console.log(data)
          var   a = JSON.parse(data);
             $(".service")
                .text($("<option></option>")
                    .attr("value", '')
                    .text('Select'));

            for (var i = 0; i  < a.length ; i++) {
                b = a[i];
                $(".service")
                    .append($("<option></option>")
                        .attr("value", b.id)
                        .text(b.name));
            }
        }
    })
})
// $('.saveclose').click(function () {
//       $('#closebtn').val('close');
//     $('.saveclose').val('close');
//     // $('.createlead input').trigger('click');
//     //  return false;
//
// });

$('#duration').change(function () {
    $('.table').removeClass('hide');
    var mechanic = parseFloat($('.mechanics').children("option:selected").attr('data-value'));
    var sum = parseFloat(0);
    var sum1 = parseFloat(0);
    $('.extendendamount').each(function () {
        sum = sum + parseFloat($(this).val());
    });
    $('.subtotal span').html(sum.toFixed(2));
    $('.leadproducts').each(function () {
        sum1 = sum1 + parseFloat($(this).attr('data-duration'));
    });
    var mechanic = parseFloat($('.mechanics').children("option:selected").attr('data-value'));


    var mechanicprice = $(this).val() * mechanic;
    if (!isNaN(mechanicprice)) {
        $('.mechanicprice').html('£ ' + mechanicprice);
    }
    else {
        $('.mechanicprice').html('£ 0')
    }
    var subtotalvalue = $('.subtotal span').text();
    if (!isNaN(mechanicprice)) {
        var totalprice = parseFloat(subtotalvalue) + parseFloat(mechanicprice);
    } else {
        totalprice = subtotalvalue;
    }
    if (!isNaN(totalprice)) {
        $('.totalprice').html('£ ' + parseFloat(totalprice).toFixed(2));
    }

});
$('#duration').trigger('change');
$(document).on("change", "table tbody tr td .qty", function () {
    var qty = $(this).val();
    var amount = $(this).attr('data-actual-amount');
    var total = qty * amount;
    $(this).parent().next('td').next('td').next('td').children('.extendendamount').val(total.toFixed(2))
    $('#duration').trigger('change');

});
$(document).on("change", "table tbody tr td select#producttype", function () {
    var producttype = $('option:selected', this).attr('data-product-type');
    var current = $(this);
    var bookingid = $('#bookingid').val();
    $.ajax({
        type: "POST",
        url: "/api/getproductsbytype",
        data: {'producttype': producttype, 'bookingid': bookingid},
        success: function (res) {
            console.log(data);
            var data = JSON.parse(res);
            current.parent().next('td').children('.qty').attr('name', 'product[' + data.serviceid + '][' + data.id + '][qty]');
            current.parent().next('td').children('.qty').attr('data-actual-amount', data.extendedamount);
            current.parent().next('td').children('.qty').val(data.qty);
            current.parent().next('td').children('.id').attr('name', 'product[' + data.serviceid + '][' + data.id + '][id]');
            current.parent().next('td').children('.id').val(data.id);
            current.parent().next('td').next('td').children('input').attr('name', 'product[' + data.serviceid + '][' + data.id + '][unit]');
            current.parent().next('td').next('td').children('input').val(data.unit);
            current.parent().next('td').next('td').next('td').next('td').children('input').val(data.extendedamount);
            current.parent().next('td').next('td').next('td').next('td').children('input').attr('name', 'product[' + data.serviceid + '][' + data.id + '][extendedamount]');
            // alert(data.extendedamount);
            current.parent().next('td').next('td').next('td').children('input').attr('name', 'product[' + data.serviceid + '][' + data.id + '][size]');
            current.parent().next('td').next('td').next('td').children('input').val(data.size);
            $('#duration').trigger('change');
        }
    });
    $('#duration').trigger('change');


});
$('table tbody tr td select#producttype').trigger('change');

$(document).on('change', '.extendendamount', function () {

    $('#duration').trigger('change');

});
//Delete row
$(document).on("click", ".removerowbookingproducts", function (e) {
    $(this).parent().parent().remove();
    $('#duration').trigger('change');


});

$(document).on('change', '#bookingproductadd .col-md-6 .form-check-input', function () {
    $('.col-md-6 .form-check-input').not(this).prop('checked', false);
    $('#existingproducttype').val("");
    $('#existingproducttype').trigger('change');
    if ($('.col-md-6 .form-check-input:checked').val() == 0) {
        $('.addmore').removeClass('hide');
        $('.loadexistingproduct').addClass('hide');
        $('.loadexistingproductoption option').remove();
        $('.productname .form-group:first-child').removeClass('hide');
        $('.addnewproductbtn').addClass('hide');
    }
    else {
        $('.addnewproductbtn').removeClass('hide');
        $('.addnewproductbtn').removeClass('hide');
        $('.addmore').addClass('hide');

    }
    $('#bookingproductadd .addnewproductbtn   .form-check-input:checked').prop('checked', false);
    $('.productstock input').prop('disabled', true);

});
$(document).on('change', '#bookingproductadd .addnewproductbtn .form-check-input', function () {
    var val = $('#bookingproductadd .addnewproductbtn   .form-check-input:checked').val();
    if (val == 1) {
        $('.productremove').removeClass('hide');
        $('.addmore').addClass('removeaddmore');
        $('.removeaddmore').removeClass('addmore');
        $('.removeaddmore').html('x');
        $('.addnewptype').attr('disabled', false);
        $('.addnewptype').removeClass('hide');
        $('#existingproducttype').attr('disabled', true);
        $('#existingproducttype').next('span').addClass('hide');
        $('#newproduct').val(1);
        $('.productstock input').prop('disabled', false);
        $('.productstock input[name=stockremaining]').prop('disabled', true);
        $('.productstock').removeClass('hide');
    }
    else {
        $('.productstock').removeClass('hide');
        $('.productremove').addClass('hide');
        $('.removeaddmore').addClass('addmore');
        $('.addmore').removeClass('removeaddmore');
        $('.addmore').html('+');
        $('.addnewptype').attr('disabled', true);
        $('.addnewptype').addClass('hide');
        $('#existingproducttype').attr('disabled', false);
        $('#existingproducttype').next('span').removeClass('hide');
        $('#newproduct').val(0);
        $('.productstock input').prop('disabled', true);
        $('.productstock input[type=stockremaining]').prop('disabled', true);

    }
});

/*
* Job detail page
* */

$(document).ready(function () {
    var maxField = 100; //Input fields increment limitation
    var addButton = $('#addmoretechnician'); //Add button selector
    var wrapper = $('#timehsheettable tbody'); //Input field wrapper
    //Once add button is clicked
    $(addButton).click(function () {
        $('.addtimesheet').removeClass('hide');

        var x = $('#timehsheettable tbody tr').length; //Initial field counter is 1
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            var fieldHTML = '                  <tr>\n' +
                '                      <td>' + x + '</td>\n' +
                '                      <td><input type="text" name="timesheet[' + x + '][startdate]" autocomplete="off" class="datetime form-control"> </td>\n' +
                '                      <td><input type="text" name="timesheet[' + x + '][starttime]" autocomplete="off" class="timepicker form-control"> </td>\n' +
                '                      <td><input type="text" name="timesheet[' + x + '][enddate]" autocomplete="off" class="form-control datetime"></td>\n' +
                '                      <td><input type="text" name="timesheet[' + x + '][endtime]" autocomplete="off" class="form-control timepicker"></td>\n' +
                '                      <td> <select name="timesheet[' + x + '][mechanicid]" class="form-control disabled mechanics">\n' +
                '                              <option selected disabled>Select Technician</option>\n';
            $.ajax({
                type: "POST",
                async: false,
                url: "/ajax/getmechanic",
                success: function (data) {
                    var res = JSON.parse(data);
                    for (var i = 0; i < res.length; i++) {
                        var mechanicid = $('select[name=mechanicid] option:selected').val();
                        if (mechanicid == res[i].id) {
                            var selected = "selected";
                        }
                        else {
                            var selected = "";
                        }
                        fieldHTML += '<option ' + selected + ' data-value="' + res[i].costperhour + '" value="' + res[i].id + '">' + res[i].name + '</option>\n';
                    }

                }
            });
            console.log(fieldHTML);
            fieldHTML += ' </select></td>\n' +
                '                      <td><textarea class="form-control" name="timesheet[' + x + '][notes]"></textarea> </td>\n' +
                '                      <td class="text-center remove_button"><i class="fa fa-trash"></i> </td>\n' +
                '                  </tr>\n'; //New input field html
            $(wrapper).append(fieldHTML); //Add field html
        }
        $('.datetime').each(function () {
            $('.timepicker').timepicker({
                timeFormat: 'h:mm p',
                interval: 60,
                dynamic: false,
                dropdown: true,
                scrollbar: true,
                minTime: '07:00:00',
                maxTime: '22:00:00'
            });
            $(this).datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                orientation: "top auto",
                startView: 1,
                autoclose: true,
                todayBtn: true,
            }).datepicker("setDate", new Date());
        });
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        if (confirm('Are you sure?')) {
            $.ajax({
                type: "POST",
                url: "/ajax/deletejob",
                data: {'jobid': id},
                success: function (data) {
                    console.log(data);
                }
            });
        }
        $(this).parent('tr').remove(); //Remove field html
    });
});
$(document).ready(function () {
    $('.datetime').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        orientation: "bottom auto",
        startView: 2,
        autoclose: true,
        todayBtn: true,
        calendarWeeks: true,
    });
})
$('.addtimesheet').click(function () {
    event.preventDefault();
    var form = $('#addtimesheet')[0];
    var data = new FormData(form);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "/ajax/addtimesheet",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
            $('input[name=duration]').val(data);
            $('.alert-success').removeClass('hide');
            $('.addtimesheet').addClass('hide');
            setTimeout(function () {
                $('.alert-success').addClass('hide');
            }, 4000);
        },
    });
})
$('.updatetimesheet').click(function () {
    event.preventDefault();
    var form = $('#addtimesheet')[0];
    var data = new FormData(form);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "/ajax/updatetimesheet",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
            $('input[name=duration]').val(data);
            $('.alert-success').removeClass('hide');
            $('.addtimesheet').addClass('hide');
            setTimeout(function () {
                $('.alert-success').addClass('hide');
            }, 4000);
        },
    });
})
$('.sendinvoice').click(function (e) {
    e.preventDefault();

    if (confirm('Are you sure?')) {
        var id = $('#bookingid').val();
        $('#jobdetailupdate').css('opacity', '0.5');
        $('#jobdetailupdate').before('<div class="loader"></div>\n')
        $.ajax({
            type: "POST",
            url: "/ajax/sendemailallparts",
            data: {'bookingid': id},
            success: function (data) {
                $('.loader').remove()
                $('#jobdetailupdate').css('opacity', '1');
                alert("Invoice Send to Customer Sucessfully")
            }
        });
    }
});


//Create booking form
$('.datepickers,.timepicker').click(function () {
    $('.datepickers').css('border', '1px solid #e4e6ef')
    $('.timepicker').css('border', '1px solid #e4e6ef')
})
$(document).ready(function () {
    $("#createbookingformlead input[type=submit]").click(function (event) {
        event.preventDefault();
        if ($('.datepickers').val() == "") {
            $('.datepickers').css('border', '1px solid red');
            $(window).scrollTop(0);
            return false;
        }
        if ($('.timepicker').val() == "") {
            $('.timepicker').css('border', '1px solid red');
            $(window).scrollTop(0);
            return false;
        }

        var form = $('#createbookingformlead')[0];
        var data = new FormData(form);
        $('.error').html('');
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/ajax/leadsbooking",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                var res = JSON.parse(data);
                console.log(res);
                var restext = "";
                if (res.error == 1) {
                    for (var i = 0; i < res.response.length; i++) {
                        $('.producterror').removeClass('hide');
                        restext += '<div class="alert alert-danger">';
                        restext += res.response[i].message + '</div>';
                    }
                    $('.error').prepend(restext);
                }
                else {
                    console.log(res);
                    window.location.href = '/job/detail/' + res.response[0].message;
                }
            },
        });
    });
});


$(document).ready(function () {
    $("#jobcreate input[type=submit]").click(function (event) {
        event.preventDefault();

        var form = $('#jobcreate')[0];
        var data = new FormData(form);
        $('.error').html('');
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/ajax/jobcreate",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                var res = JSON.parse(data);
                var restext = "";
                if (res.error == 1) {
                    for (var i = 0; i < res.response.length; i++) {
                        $('.producterror').removeClass('hide');
                        restext += '<div class="alert alert-danger">';
                        restext += res.response[i].message + '</div>';
                    }
                    $('.error').prepend(restext);
                }
                else {
                    alert("Job Created Successfully");
                    location.reload();
                }
            },
        });
    });
});

$(document).ready(function () {
    $("#updatejobform input[type=submit]").click(function (event) {
        event.preventDefault();

        var form = $('#updatejobform')[0];
        var data = new FormData(form);
        $('.error').html('');
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/ajax/updatejobform",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                var res = JSON.parse(data);
                var restext = "";
                if (res.error == 1) {
                    for (var i = 0; i < res.response.length; i++) {
                        $('.producterror').removeClass('hide');
                        restext += '<div class="alert alert-danger">';
                        restext += res.response[i].message + '</div>';
                    }
                    $('.error').prepend(restext);
                }
                else {
                    alert("Job Updated Successfully");
                    location.reload();
                }
            },
        });
    });
});

$(document).ready(function () {
    $("#contactnewbooking input[type=submit]").click(function (event) {
        event.preventDefault();
        var a = leadscreatefunction();
        if (a == 0) {
            return false;
        }

        var form = $('#contactnewbooking')[0];
        var data = new FormData(form);
        $('.error').html('');
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/ajax/contactnewbooking",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                var res = JSON.parse(data);
                var restext = "";
                if (res.error == 1) {
                    for (var i = 0; i < res.response.length; i++) {
                        $('.producterror').removeClass('hide');
                        restext += '<div class="alert alert-danger">';
                        restext += res.response[i].message + '</div>';
                    }
                    $('.error').prepend(restext);
                }
                else {
                    window.location.href = '/job/detail/' + res.response[0].message;
                }
            },
        });
    });
});


$(document).ready(function () {
    $("#createjobnewbooking input[type=submit]").click(function (event) {
        event.preventDefault();
        if ($('.datepickers').val() == "") {
            $('.datepickers').css('border', '1px solid red');
            $(window).scrollTop(0);
            return false;
        }
        if ($('.timepicker').val() == "") {
            $('.timepicker').css('border', '1px solid red');
            $(window).scrollTop(0);
            return false;
        }
        var a = leadscreatefunction();
        if (a == 0) {
            return false;
        }
        var form = $('#createjobnewbooking')[0];
        var data = new FormData(form);
        $('.error').html('');
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/ajax/createjobnewbooking",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                var res = JSON.parse(data);
                console.log(res);
                var restext = "";
                if (res.error == 1) {
                    for (var i = 0; i < res.response.length; i++) {
                        $('.producterror').removeClass('hide');
                        restext += '<div class="alert alert-danger">';
                        restext += res.response[i].message + '</div>';
                    }
                    $('.error').prepend(restext);
                }
                else if (res.error == 2) {
                    $('.emailtext-muted').text(res.msg);
                    $('.emailtext-muted').prev().css('border', '1px solid red');
                    $('.emailtext-muted').css('color', 'red');
                    $("html, body").animate({scrollTop: 0}, "slow");
                }
                else {
                    window.location.href = '/job/detail/' + res.response[0].message;
                }
            },
        });
    });
});

$('#platform').on('change', function () {
    var checkbox = $(this);
     if (checkbox.is(":checked")) {
        $('.noplatformpicreason').addClass('hide')
    }
    else {
        $('.noplatformpicreason').removeClass('hide')
    }
});



$('#phonegallery').on('change', function () {
    var checkbox = $(this);
    if (checkbox.is(":checked")) {
        $('.phonegalleryreason').addClass('hide')
    }
    else {
        $('.phonegalleryreason').removeClass('hide')
    }

 });
$('#youtubepic').on('change', function () {
    var checkbox = $(this);
    if (checkbox.is(":checked")) {
        $('.youtubepicreason').addClass('hide')
    }
    else {
        $('.youtubepicreason').removeClass('hide')
    }
 });
$('#whatsapppic').on('change', function () {
    var checkbox = $(this);
     if (checkbox.is(":checked")) {
        $('.whatsppreason').addClass('hide')
    }
    else {
        $('.whatsppreason').removeClass('hide')
    }
 });

function leadsupdatefunction() {
    if (!$('#platform').is(':checked')) {
        if ($.trim($('textarea.noplatformpicreason').val()) == "") {
            $('textarea.noplatformpicreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return 0;
        }
    }
    if (!$('#phonegallery').is(':checked')) {
        if ($.trim($('textarea.phonegalleryreason').val()) == "") {
            $('textarea.phonegalleryreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return 0;
        }
    }
    if (!$('#youtubepic').is(':checked')) {
        if ($.trim($('textarea.youtubepicreason').val()) == "") {
            $('textarea.youtubepicreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return 0;
        }
    }
    if (!$('#whatsapppic').is(':checked')) {
        if ($.trim($('textarea.whatsppreason').val()) == "") {
            $('textarea.whatsppreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return 0;
        }
    }
    return true;
}

function leadscreatefunction() {

    if($('#newcontact').is(':checked')) {
        if ($.trim($('input[name=fname]').val()) == "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $('input[name=fname]').css('border', '1px solid red');
            alert('Enter First Name Please');
            return 0;
        }
        if ($.trim($('input[name=lname]').val()) == "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $('input[name=lname]').css('border', '1px solid red');
            alert('Enter Last Name Please');
            return 0;
        }
        if ($.trim($('input[name=phoneno]').val()) == "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $('input[name=phoneno]').css('border', '1px solid red');
            return 0;
        }
      /*  if ($.trim($('input[name=email]').val()) == "") {
            $("html, body").animate({scrollTop: 0}, "slow");
            $('input[name=email]').css('border', '1px solid red');
            alert('Enter Email Please');  return 0;
        }*/
       
    }
    if (!$('#platform').is(':checked')) {
        if ($.trim($('textarea.noplatformpicreason').val()) == "") {
            $('textarea.noplatformpicreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return 0;
        }
    }


    if (!$('#phonegallery').is(':checked')) {
        if ($.trim($('textarea.phonegalleryreason').val()) == "") {
            $('textarea.phonegalleryreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return 0;
        }
    }
    if (!$('#youtubepic').is(':checked')) {
         if ($.trim($('textarea.youtubepicreason').val()) == "") {
            $('textarea.youtubepicreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return 0;
        }
    }
    if (!$('#whatsapppic').is(':checked')) {
         if ($.trim($('textarea.whatsppreason').val()) == "") {
            $('textarea.whatsppreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return 0;
        }
    }

    return 1;
}

$('input[name=fname],input[name=lname],input[name=phoneno],input[name=email],input[name=dob]').click(function () {
    $(this).removeAttr('style');
})
$('textarea.noplatformpicreason').click(function () {
    $(this).css('border', '1px solid #a52224');
 });
$('.youtubepicreasonreason').click(function () {
    $(this).css('border', '1px solid #a52224');
});
$('.whatsppreason').click(function () {
    $(this).css('border', '1px solid #a52224');
});
$('textarea.phonegalleryreason').click(function () {
    $(this).css('border', '1px solid #a52224');
});
$(document).ready(function () {
    $("#paidamountform input[type=submit]").click(function (event) {
        event.preventDefault();
        var form = $('#paidamountform')[0];
        var formdata = new FormData(form);
        $.ajax({
            type: "POST",
            url: "/ajax/payamount",
            data: formdata,
            contentType: false,
            processData: false,
            datatype: "html",
            success: function (data) {
                 var res = JSON.parse(data);
                if(res.err==0)
                {
					console.log(res)
                var bl=parseFloat(res.balance);
                var amountpaid=parseFloat(res.amountpaid);
                $('#paidamountform input[name=balance]').val(bl)
                $('#paidamountform input[name=amountpaid]').val(amountpaid)
                $('.balanceamount').text('£' + bl.toFixed(2))
                $('.amountpaidpayment').text('£' + amountpaid.toFixed(2));
                var index = 1 + parseInt($('#paymenttable tbody  tr').length);

                var paid=parseFloat(res.paid);

                var re = ' <tr>\n' +
                    '                            <td>' + index + ' </td>\n' +
                    '                            <td>' + res.type + ' </td>\n' +
                    '                            <td>£ ' + paid.toFixed(2) + ' </td>\n' +
                    '                            <td> ' + res.date + ' </td>\n' +
                    '                            <td> ' + res.method + '</td>\n' +
                        '                            <td> ' + $('#paidamountform select[name=userid] option:selected').text() + '</td>\n' +
                    '                        </tr>'
                $('#paymenttable').append(re);
                }
                else{
                    alert('Maximum amount Which can be paid is '+res.balance)
                }
            }
        });
    })
})

$(document).ready(function () {
    $("#socialtype input[type=submit]").click(function (event) {
        event.preventDefault();
        var form = $('#socialtype')[0];
        var formdata = new FormData(form);
        $.ajax({
            type: "POST",
            url: "/ajax/addsocialtype",
            data: formdata,
            contentType: false,
            processData: false,
            datatype: "html",
            success: function (data) {
                $('.modal').modal('hide');
                $(".modal form")[0].reset();

                $('.timeline-items').prepend(data);
            }
        });
    });
});
$(document).ready(function () {
    $("#whatsappmessage input[type=submit]").click(function (event) {
        event.preventDefault();
        var form = $('#whatsappmessage')[0];

        var formdata = new FormData(form);
        $.ajax({
            type: "POST",
            url: "/ajax/whatsappmessage",
            data: formdata,
            contentType: false,
            processData: false,
            datatype: "html",
            success: function (data) {
                 $('.modal').modal('hide');
                $(".modal form")[0].reset();

                $('.timeline-items').prepend(data);
            }
        });
    });
});
$('#phonemodel').click(function () {
    $('#socialtype input[name=leaddetailid]').val($('.leaddetailsidforphone').val());
    $('#socialtype input[name=leadid]').val($('.leadidforphone').val());
    $('#socialtypename').val('phone')
});
$('#syncmodel').click(function () {
    event.preventDefault();
    var id = $('.leaddetailsidforphone').val();
    var formdata = {
        'id': id,
    }
    $.ajax({
        type: "POST",
        url: "/ajax/fetchemail",
        data: formdata,
        success: function (data) {
            if (data == "done") {
                location.reload();
            }
        }
    });
});
$(document).on('click', '#phonedetail', function (event) {
    event.preventDefault();
    $('#socialtype input[name=leaddetailid]').val($('.leaddetailsidforphone').val());
    $('#socialtype input[name=leadid]').val($('.leadidforphone').val());
    var id = $(this).attr('data-id')
    $('#myModal2').modal('show');
    var formdata = {
        'id': id,
    }
    $.ajax({
        type: "POST",
        url: "/ajax/fetchsocial",
        data: formdata,
        success: function (data) {
            var res = JSON.parse(data);
            $('#phoneno').val(res.phoneno);
            $('#datephone').val(res.date);
            $('#timedate').val(res.time);
            $('#descriptiondate').val(res.description);
            $('#socialtype').append('<input type="hidden" name="id" value="' + res.id + '" />');

        }
    });
})
$('#sms').click(function () {
    $('#socialtypename').val('sms');
    $('#socialtype input[name=leaddetailid]').val($('.leaddetailsidforphone').val());
    $('#socialtype input[name=leadid]').val($('.leadidforphone').val());
    $('#myModal2').modal('show');
})
$('#Whatsapp').click(function () {
    $('#whatsappmessage #socialtypename').val('whatsapp');
    $('#whatsappmessage   input[name=leaddetailid]').val($('.leaddetailsidforphone').val());
    $('#whatsappmessage   input[name=leadid]').val($('.leadidforphone').val());
    $('#whatsappmodal').modal('show');
})

var $a = $("#sources,#company,#originatinglead,#finance").select2({
    width: 'resolve', // need to override the changed default
     placeholder: "Select an option",
 }); 
$('#originatinglead').on("select2:select", function (e) {

    var iid = e.params.data.id;
    if (iid == "other" ) {
        $('.originatingleaddivother').css('display', 'block');
    }else{
        $('.originatingleaddivother').css('display', 'none');
    }
	
	   if (iid == "referral" ) {
        $('.refreeenamediv').css('display', 'block');
    }else{
        $('.refreeenamediv').css('display', 'none');
    }

});  
$(window).on('load', function(){
    $('#sources').next('span').attr('id', $('#sources option:selected').val()+'changesourcecolor');
 

    $('#contact_status').next('span').addClass('status'+$('#contact_status option:selected').val());
 });
$('#sources').on("select2:select", function (e) {
  
	var iid = e.params.data.id;
    if (iid == "phone" || iid == "whatsapp" || iid == "walk-in" || iid == "email") {
        $('.originatingleaddiv').css('display', 'block');
    }
    else {
        $('.originatingleaddiv').css('display', 'none');
    }
    if (iid == "reffered") {
        $('.refreeenamediv').css('display', 'block')
    } else {
        $('.refreeenamediv').css('display', 'none')
    }
    if (iid == "instagram") {
        $('.handlediv').css('display', 'block')
    } else {
        $('.handlediv').css('display', 'none')
    }
	
	$('#sources').next('span').attr('id','');
	$('#sources').next('span').attr('id',iid+'changesourcecolor');
	
});
$('#address1,#city,#town').on('keypress', function () {
    var ad = $('#address1').val();
    var ad1 = $('#city').val();
    var ad2 = $('#town').val();
    var a = ad + ', ' + ad1 + ', ' + ad2;
    $('#pac-input').val(a);
    console.log(a);
    $('#my-button').trigger('click');
});
setTimeout(function () {
    $('#pac-input').trigger('focus')
}, 2000);
setTimeout(function () {
    $('#my-button').trigger('click');
}, 3500);

$('#registration').keyup(function(){
    var registration=$(this).val();
    $('form').before('<div class="loader"></div>\n');
    $('form').css('opacity','0.5');
    var formdata={
        'registration':registration,
    }
    $.ajax({
        type: "POST",
        url: "/api/getcarapi",
        data: formdata,
        success: function (data) {
             var res=JSON.parse(data);
             console.log(res);
            $('.loader').remove();
            $('form').css('opacity',1);
            if(res.status=="Success") {
                $('#carmodel').val(res.VehicleRegistration.Model)
                $('#enginetype').val(res.VehicleRegistration.FuelType.toLowerCase())
                $('#carmake').val(res.VehicleRegistration.Make)
                $('#enginesize').val(res.VehicleRegistration.EngineCapacity)
                $('#transmission').val(res.SmmtDetails.Transmission)
            }
         }
    });
});

$('.actionbbtbn').click(function () {
    $('.actionbbtbn').removeClass('bgbtnwhite');
    $(this).addClass('bgbtnwhite');
    $('#status').val($(this).attr('data-attr'));
    if($(this).attr('data-attr')=="notinterested")
    {
        $('#modalformcreateleads .followupdate').css('display','none');
        $('#modalformcreateleads .timedate').css('display','none');
        $('#modalformcreateleads .followupdate input').val('');
        $('#modalformcreateleads .timedate input').val('');
        $('#modalformcreateleads .financepopup').css('display','none');
              $('#modalformcreateleads .popupcompany').css('display','none');
      $('#modalformcreateleads .followuptime').css('display','none');
        $('#modalformcreateleads .col-md-12').css('display','block');
    }
    if($(this).attr('data-attr')=="followup")
    {
        $('#modalformcreateleads .followupdate').css('display','block');
        $('#modalformcreateleads .timedate').css('display','none');
        $('#modalformcreateleads .followuptime').css('display','block');
        $('#modalformcreateleads .followupdate input').val('');
               $('#modalformcreateleads .popupcompany').css('display','none');
    $('#modalformcreateleads .timedate input').val('');
        $('#modalformcreateleads .financepopup').css('display','none');
         $('#modalformcreateleads .col-md-12').css('display','block');
    }
    if($(this).attr('data-attr')=="poppingin")
    {
        $('#modalformcreateleads .followupdate').css('display','block');
        $('#modalformcreateleads .timedate').css('display','none');
        $('#modalformcreateleads .followuptime').css('display','block');
        $('#modalformcreateleads .followupdate input').val('');
        $('#modalformcreateleads .timedate input').val('');
        $('#modalformcreateleads .financepopup').css('display','none');
            $('#modalformcreateleads .popupcompany').css('display','none');
     $('#modalformcreateleads .col-md-12').css('display','block');
    }
    if($(this).attr('data-attr')=="book")
    {
        $('#modalformcreateleads .followupdate').css('display','block');
        $('#modalformcreateleads .followuptime').css('display','none');
        $('#modalformcreateleads .timedate').css('display','block');
        $('#modalformcreateleads .popupcompany').css('display','none'); 
        $('#modalformcreateleads .financepopup').css('display','block');
         $('#modalformcreateleads .followupdate input').val('');
        $('#modalformcreateleads .timedate input').val('');
        $('#modalformcreateleads .col-md-12').css('display','block');

         
    }

});


$(document).ready(function () {
    $(".savemodalform").click(function (event) {
        event.preventDefault();

        var form = $('#modalformcreateleads')[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/ajax/createactiononlead",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                 var res = JSON.parse(data);
                if(res.error==0)
                {
                   window.location.href =  res .response[0].message;

                }

            },
        });
    });
});



//Create Lead from the Contact


$(document).ready(function () {
    $("#createleadcontact input[type=submit],.saveclose").click(function (event) {
        event.preventDefault();
        if($(this).hasClass('saveclose')) {
            $('#closebtn').val('close');
            $('.saveclose').val('close');
        }
        if ($('.dropdownfilter option:selected').val() == "") {
            $('.dropdownfilter').next('span').css('border', '1px solid red');
            return false;
        }
        var a= leadscreatefunction();
        if(a==0) {
            return false;
        }
        var form = $('#createleadcontact')[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/ajax/createleadcontact",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                console.log(data);
                var res = JSON.parse(data);
                if (res.error == 0) {
                    $('.emailtext-muted').text(res.msg);
                    $('.emailtext-muted').prev().css('border', '1px solid red');
                    $('.emailtext-muted').css('color', 'red');
                    $("html, body").animate({scrollTop: 0}, "slow");
                }
                else {

                    $('#bookingmodal #leadid').val(res.redirect);
                    $('#bookingmodal').modal('show');
                 }
            },
        });
    });
});

$('.removetabsposition a').click(function () {
    var a=$(this).attr('href');
    if(a!="#contact")
    {
        $('.titlebookingpage').removeClass('float-left');
        $('.removetabsposition').removeClass('tabsposition');
    }else{
        $('.titlebookingpage').addClass('float-left');
        $('.removetabsposition').addClass('tabsposition');
    }

 });

$('.bookingstatus').on('change',function(){

    if($('.bookingstatus option:selected').val()==3)
    {
        $('.cancelreasondiv').removeClass('hide')
    }else{
        $('.cancelreasondiv').addClass('hide')
    }
})



$(document).ready(function () {
    $("#modaladdproduct .savemodalleads").click(function (event) {
        event.preventDefault();
        var form = $('#modaladdproduct form')[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/ajax/addproductlive",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                var res = JSON.parse(data);
                console.log(res);
                if(res.err==1)
                {
                    $('#modaladdproduct  form').before('<div class="alert alert-danger">Product Already Exists</div>');
                }else{
                    $(".service")
                        .append($("<option></option>")
                            .attr("value", res.details.id)
                            .text(res.details.value));
                    $('#modaladdproduct  form').before('<div class="alert alert-success">Product Add Successfully</div>');
                    $('#modaladdproduct form').trigger("reset");

                }
            },
        });
    });
});



function leadsupdateedfunction() {
    if (!$('#platform').is(':checked')) {
        if ($.trim($('textarea.noplatformpicreason').val()) == "") {
            $('textarea.noplatformpicreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return false;
        }
    }
    if (!$('#phonegallery').is(':checked')) {
        if ($.trim($('textarea.phonegalleryreason').val()) == "") {
            $('textarea.phonegalleryreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return false;
        }
    }
    if (!$('#youtubepic').is(':checked')) {
        if ($.trim($('textarea.youtubepicreason').val()) == "") {
            $('textarea.youtubepicreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return false;
        }
    }
    if (!$('#whatsapppic').is(':checked')) {
        if ($.trim($('textarea.whatsppreason').val()) == "") {
            $('textarea.whatsppreason').css('border', '1px solid red');
            alert("Write Down the Reason Please");
            return false;
        }
    }
    return true;
}




$(document).ready(function () {
    $("#addactivity .submitactivity").click(function (event) {
         event.preventDefault();
        var form = $('#addactivity')[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/ajax/addactivity",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                var res = JSON.parse(data);
                    $('#tasksmodal  form').before('<div class="alert alert-success">Task Created Successfully</div>');
                 $('#tasksmodal form').trigger("reset");
                 setTimeout(function () {
                     $('#tasksmodal').modal('hide');
                 },2000)

            },
        });
    });
});

$(' #modalformcreateleads #finance,  #finance').on("select2:select", function (e) {
    var iid = e.params.data.id;
 		 
	if(iid=="tradeaccount"){
        $(' #modalformcreateleads .popupcompany').css('display','block'); 
        $('   .accounttradefield').css('display','block'); 
	 $.ajax({
                 type: "POST",
                url: "/api/getaccounts",
                success: function (data) {
                    var   a = JSON.parse(data);
					console.log(a);
                    $("#modalformcreateleads .popupcompanydata")
                        .text($("<option></option>")
                            .attr("value", '')
                            .text('Select'));

                    for (var i = 0; i  < a.length ; i++) {
                        b = a[i];
                        $("#modalformcreateleads  .popupcompanydata")
                            .append($("<option></option>")
                                .attr("value", b.id)
                                .text(b.name));
                    }
                }
            })
			}else{
				         $('   .accounttradefield').css('display','none'); 
       $('#modalformcreateleads  .popupcompany').css('display','none'); 
			}
 
});




FORM_DIRTY = false;
jQuery('form').find('input[type=text],input[type=number],input[type=checkbox],input[type=radio], select,textarea ').change(function(e){

    FORM_DIRTY = true;
});
jQuery('form').find('button[type=submit],input[type=submit]').click(function(e){

    FORM_DIRTY = false;
});
 
window.onbeforeunload = function (e) {
    e = e || window.event;

    if(FORM_DIRTY) {
        // For Safari
        return 'Sure?';
    }
};



$('.convertlead').click(function (e) {
    e.preventDefault();
    if (confirm('Are you sure?')) {
        var id=$(this).attr('data-attr');
        window.location.href='/ajax/converlead/'+id;
    }
})


$('.companyrefre').on("select2:select", function (e) {
    var id = e.params.data.id;

        $.ajax({
            // dataType: "json",
            type: "POST",
            url: "/api/getleads",
            data: {'user_id': id},
            success: function (data) {
 				var a = JSON.parse(data);
                          	console.log(a);
  					 $(".refreeename")
                    .text($("<option></option>")
                        .attr("value", "")
                        .attr("title","" )
                        .text(""));
              for (var i = 0; i < a.length; i++) {
                    b = a[i];
                    $(".refreeename")
                        .append($("<option></option>")
                            .attr("value", b.id)
                            .attr("title", b.leadid)
                            .text(b.name));
                }
            }
        });
}); 