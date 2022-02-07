$('#costprice,#qty').focusout(function () {
    var qty = parseInt($('#qty').val());
    var costprice = parseInt($('#costprice').val());
    var amount = qty * costprice;
    if (isNaN(amount)) {
        amount = costprice
    }
    $('#amount').val(amount);
    $('#tax').trigger('focusout')
});
$('#tax').focusout(function () {
    var amount = parseInt($('#amount').val());
    if (!isNaN(amount)) {
        var tax = $(this).val();
        if (!isNaN(tax)) {
            var taxamount = amount * (tax / 100);
            var extendeedamount = (taxamount + amount).toFixed(2);
            $('#extendeedamount').val(extendeedamount);
        }
        else {

            $('#extendeedamount').val((amount).toFixed(2));
        }

    }
});

var $a = $(".producttype").select2({
    width: 'resolve', // need to override the changed default
    placeholder: "Select Type"
});


$(document).on('click', '.productremove', function () {
    if ($('.productremove').hasClass('removeaddmore')) {
        $('.removeaddmore').addClass('addmore');
        $('.addmore').removeClass('removeaddmore');
        $('.addmore').html('+');
        $('.addnewptype').attr('disabled', true);
        $('.addnewptype').addClass('hide');
        $('#existingproducttype').attr('disabled', false);
        $('#existingproducttype').next('span').removeClass('hide');
        $('#newproduct').val(0);
    }
    else {
        $('.addmore').addClass('removeaddmore');
        $('.removeaddmore').removeClass('addmore');
        $('.removeaddmore').html('x');
        $('#addnewproductfeature').removeClass('hide');
        $('.addnewptype').attr('disabled', false);
        $('.addnewptype').removeClass('hide');
        $('#existingproducttype').attr('disabled', true);
        $('#existingproducttype').next('span').addClass('hide');
        $('#newproduct').val(1);
        $('#assignproducttypeonly').val(0);

    }
});

$(document).on('click', '#serviceidaddproduct', function () {
    var serviceid = $(this).attr('data-service-id');
    //  $('#existingproducttype option').each(function () {
    //     if ($(this).attr('data-service') != serviceid) {
    //         $(this).attr('disabled', 'disabled');
    //     }
    //     else {
    //         $(this).removeAttr('disabled', 'disabled')
    //     }
    // });
    $('#myModal2').modal('show');
    $('#modalserviceid').val(serviceid);
});

$('#duration').trigger('change');


$(document).on("click", "#bookingproductadd input[type=submit]", function (e) {
    e.preventDefault();
    var form = $('#bookingproductadd')[0];
    var data = new FormData(form);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "/ajax/addproductbooking",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (res) {
            var respose = JSON.parse(res);
            console.log(respose);
            var serviceid = $('#modalserviceid').val();
            $('#bookingproductadd').trigger("reset");
            var serviceid = respose.data.serviceid;
            $('#table' + serviceid + ' tbody #producttype' + respose.data.producttype).addClass("exists");

            var ins = '<tr id="producttype' + respose.data.producttype + '">        \t\t\t\n' +
                '                \t        <td width="12%">' + respose.servicename + '</td>\n' +
                '                          <td width="12%">' + respose.producttypename + '</td>\n' +
                '        \t\t\t\t<td><select name="producttype" id="producttype" class="form-control">\' ;\n' +
                '                      <option data-product-type="' + respose.data.id + '" value="' + respose.data.name + '">' + respose.data.name + '</option>\';\n' +
                '                </select></td>";\n' +
                '   <td width="14%"><input type="hidden" class="id" value="' + respose.data.id + '" name="product[' + respose.data.serviceid + '][' + respose.data.id + '][id]">' +
                '<input type="hidden" class="existingproductid" value="' + respose.data.relatedproduct + '" name="product[' + respose.data.serviceid + '][' + respose.data.id + '][existingproductid]" >' +
                '<input min="0" type="number" class=" qty form-control"  data-actual-amount="' + respose.data.extendedamount + '"  value="' + respose.data.qty + '" name="product[' + respose.data.serviceid + '][' + respose.data.id + '][qty]"></td>\n' +
                '        \t\t\t\t<td><input type="number" class="unit form-control" min="0" value="' + respose.data.unit + '" name="product[' + respose.data.serviceid + '][' + respose.data.id + '][unit]"></td>\n' +
                '        \t\t\t\t<td width="14%"  class="sizeproduct" ><input type="text" class="form-control" value="' + respose.data.size + '"  name="product[' + respose.data.serviceid + '][' + respose.data.id + '][size]"> </td>\n' +
                '        \t\t\t\t<td width="12%" class="productprice"> <input type="text" class="form-control extendendamount " value="' + respose.data.extendedamount + '" name="product[' + respose.data.serviceid + '][' + respose.data.id + '][extendedamount]"></td>\n' +
                '       <td><span  class="removerowbookingproducts   btn btn-danger">Remove</span></td>  ' +
                '        \t\t\t</tr>';
            $('#table' + serviceid + ' tbody').append(ins);
            // }
            $('.modal').modal('hide');
            $('#duration').trigger('change');
        }
    });
});


$('.loadexistingproductoption').on('select2:select', function (e) {
    var id = e.params.data.title;
    $.ajax({
        type: "POST",
        url: "/api/productdetails",
        data: {'productid': id},
        success: function (data) {
            var res = JSON.parse(data);
            $('#existingproduct').val(id);
            $('#bookingproductadd input[name=unit]').val(res.unit);
            $('#bookingproductadd input[name=costprice]').val(res.costprice);
            $('#bookingproductadd input[name=qty]').val(res.qty);
            $('#bookingproductadd input[name=amount]').val(res.amount);
            $('#bookingproductadd input[name=tax]').val(res.tax);
            $('#bookingproductadd input[name=extendedamount]').val(res.extendedamount);
            $('#bookingproductadd input[name=stock]').val(res.detail.t_stock);
            $('#bookingproductadd input[name=stockremaining]').val(res.detail.t_stock - res.detail.ordered);
        }
    });
});


$('#existingproducttype').on("select2:select", function (e) {
    var id = e.params.data.id;
    if (($('#bookingproductadd .form-check-input:checked').val() == 1) && ($('#bookingproductadd .addnewproductbtn .form-check-input:checked').val() != 1)) {
        $.ajax({
            type: "POST",
            url: "/api/existingproduct",
            data: {'productid': id},
            success: function (data) {
                var res = JSON.parse(data);
                $('.productname .form-group').addClass('hide');
                $('.loadexistingproductoption option').remove();
                $('.loadexistingproduct').removeClass('hide');
                $(".loadexistingproductoption")
                    .append($("<option></option>")
                        .attr("value", '')
                        .attr("title", '')
                        .attr("disabled", true)
                        .attr("selected", true)
                        .text("Select"));
                $('.productstock').removeClass('hide');
                for (var i = 0; i < res.length; i++) {
                    $(".loadexistingproductoption")
                        .append($("<option></option>")
                            .attr("value", res[i].name)
                            .attr("title", res[i].id)
                            .text(res[i].name));
                }
            }
        });
    }
    else {
        $('.loadexistingproduct').addClass('hide');
        $('.loadexistingproductoption option').remove();
        $('.productname .form-group:first-child').removeClass('hide');

    }
});


$('#productcreateads').click(function () {
    if (!$(this).is(':checked')) {
        $('#existingproducttype').val("");
        $('#existingproducttype').trigger('change');
    }
});
$('#tax').val(20);

$('.addnewproducttrigger').click(function () {
    $('#addnewproductfeature').removeClass('hide');
    $('#assignproducttypeonly').val(0);
})
$(".relatedproduct").select2({
    placeholder: "Select Type"
});

$('.relatedproduct').css('display', 'none');
var $a = $(".productsupplier").select2({
    width: 'resolve', // need to override the changed default
    placeholder: "Select Type"
});


//Service Page new Js
$('#addsupplier').click(function () {
    $('.supplierinfo').toggle();
    if ($('#supplierinfo').val() == 0) {
        $('#supplierinfo').val("1");
    }
    else {
        $('#supplierinfo').val("0");
    }
});


$(document).ready(function () {
    var max_fields = 100; //maximum input boxes allowed
    var wrapper = $("#tablenewproductmorefield tbody"); //Fields wrapper
    var add_button = $("#addnewproducts"); //Add button ID

    var x = 0;
    $(add_button).click(function (e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;

            var a = $('#categoryservice option:selected').val();
            if (typeof a != undefined) {
                $.ajax({
                    type: "POST",
                    url: "/api/getrelatedproductmadeup",
                    data: {'categoryid': a},
                    success: function (data) {
                        var data1 = ' <tr>\n' +
                            ' <td><select  name="madeupproduct[' + x + '][product]"  class="tableproducts' + x + ' form-control">' + data + '</select> </td>\n' +
                            '  <td><input type="text"  name="madeupproduct[' + x + '][qty]" value="" placeholder="Quantity" class="form-control"> </td>\n' +
                            ' <td class="text-center inline-block"> <input style="width: 80px;" class="btn-sm btn btn-danger" id="removefield" name="button" value="remove"> </td>\n' +
                            ' </tr>';

                        $("#tablenewproductmorefield tbody").append(data1); //add input box

                        $(".tableproducts" + x).select2({
                            placeholder: "Select Type",
                        });

                    }
                });
            }


        }
    });

    $(wrapper).on("click", "#removefield", function (e) {
        e.preventDefault();

        var id = $(this).attr('data-value');
        var wanted_option = $('#madeupproduct option[value="' + id + '"]');
        wanted_option.prop('selected', false).trigger("change");
        $(this).parent('td').parent('tr').remove();
        x--;
    })
});
$(document).ready(function () {
    var max_fields = 10;
    var wrapper = $("#tablenewupgradefield tbody");
    var add_button = $("#addnewupgrade");
    var xy = 1;

    $(add_button).click(function (e) {
        e.preventDefault();
        if (xy < max_fields) {
            xy++;

            var a = $('#categoryservice option:selected').val();
            if (typeof a != undefined) {
                $.ajax({
                    type: "POST",
                    url: "/api/getrelatedproductmadeup",
                    data: {'categoryid': a},
                    success: function (data) {
                        var data1 = ' <tr>\n' +
                            ' <td><select  name="upgradeproduct[' + xy + '][product]"  class="tableproducts' + xy + ' form-control">' + data + '</select> </td>\n' +
                            '  <td><input type="text"  name="upgradeproduct[' + xy + '][qty]" value="" placeholder="Quantity" class="form-control"> </td>\n' +
                            '  <td><input type="text"  name="upgradeproduct[' + xy + '][cost]" value="" placeholder="Additional Cost" class="form-control"> </td>\n' +
                            ' <td class="text-center inline-block"> <input style="width: 80px;" class="btn-sm btn btn-danger" data-value="' + id + '" id="removefieldupgrades" name="button" value="remove"> </td>\n' +
                            ' </tr>';

                        $("#tablenewupgradefield tbody").append(data1); //add input box

                        $(".tableproducts" + xy).select2({
                            placeholder: "Select Type",
                        });

                    }
                });
            }


        }
    });
    $(wrapper).on("click", "#removefieldupgrades", function (e) {
        e.preventDefault();
        var id = $(this).attr('data-value');
        var wanted_option = $('#upgradesproduct option[value="' + id + '"]');
        wanted_option.prop('selected', false).trigger("change");

        $(this).parent('td').parent('tr').remove();
        xy--;
    })
});

$("#madeupof").select2({
    placeholder: "Select Type",
});


$("#tableproducts").select2({
    placeholder: "Select Type",
});
$(".tableproducts1 ").select2({
    placeholder: "Select Type",
});

$("#servicenameadd").select2({
    placeholder: "Select Service",
});
$("#categoryservice").select2({
    placeholder: "Select Category",
});

$('#servicenameadd').on('select2:select', function (e) {
    var id = e.params.data.id;
    $.ajax({
        type: "POST",
        url: "/api/getrelatedcategory",
        data: {'serviceid': id},
        success: function (data) {
            $('#categoryservice').html(data);
        }
    });
});


$(function () {
    var f = function () {
        $(this).next().text($(this).is(':checked') ? 'Package' : 'Package');
        if ($(this).is(':checked')) {
            $('.package').css('display', 'block');
        }
        else {
            $('.package').css('display', 'none');
        }
    };
    $('.filpercheck input').change(f).trigger('change');
});


$("#upgradesproduct").select2({
    placeholder: "Select Type",
    closeOnSelect: false
});

var sd = 1;


$('#upgradesproduct').on('select2:select', function (e) {
    var id = e.params.data.id;
    $.ajax({
        type: "POST",
        url: "/api/upgradesproduct",
        data: {'categoryid': id},
        success: function (data) {
            var resdata = JSON.parse(data);
            var data1 = ' <tr id="upgrade' + id + '">\n' +
                ' <td><label>Product</label><select  name="upgradeproduct[' + sd + '][product]"  class="tableproducts' + sd + ' form-control">' + resdata.product + '</select> </td>\n' +
                '  <td><label>Category</label><input type="text" value="' + resdata.category + '" placeholder="Category" class="form-control"> </td>\n' +
                '  <td><label>Quantity</label><input type="text"  name="upgradeproduct[' + sd + '][qty]" value="1" placeholder="Quantity" class="form-control"> </td>\n' +
                '  <td><label>Price</label><input type="text"  name="upgradeproduct[' + sd + '][cost]" value="" placeholder="Additional Cost" class="form-control"> </td>\n' +
                ' <td class="text-center inline-block"> <input style="width: 80px;" data-value="' + id + '" class="btn-sm btn btn-danger  removevalue' + id + '" id="removefieldupgrades" name="button" value="remove"> </td>\n' +
                ' </tr>';

            $("#tablenewupgradefield tbody").append(data1); //add input box

            $(".tableproducts" + sd).select2({
                placeholder: "Select Type",
            });
            sd++;

        }
    });
});
$('#upgradesproduct').on('select2:unselect', function (e) {
    var id = e.params.data.id;
    $('#upgrade' + id).remove();
});


//select with dropdown


$("#madeupproduct").select2({
    placeholder: "Select Type",
    closeOnSelect: false
});
var vsd = 1;
$('#madeupproduct').on('select2:select', function (e) {
    var id = e.params.data.id;
    $.ajax({
        type: "POST",
        url: "/api/madeupproductfunction",
        data: {'categoryid': id},
        success: function (data) {
            var da = JSON.parse(data);
            console.log(da);
            var data1 = ' <tr id="madeup' + id + '">\n' +
                ' <td><label>Product</label><select  name="madeupproduct[' + vsd + '][product]"  class="tableproducts' + vsd + ' form-control">' + da.product + '</select> </td>\n' +
                '  <td><label>Category</label><input  type="text"  class=" form-control" value="' + da.category + '"></td>\n' +
                '  <td><label>Quantity</label><input type="text"  name="madeupproduct[' + vsd + '][qty]" value="1" placeholder="Quantity" class="form-control"> </td>\n' +
                ' <td class="text-center inline-block"> <input style="width: 80px;" data-value="' + id + '" class="btn-sm btn btn-danger  removevalue' + id + '" id="removefield" name="button" value="remove"> </td>\n' +
                ' </tr>';

            $("#tablenewproductmorefield tbody").append(data1); //add input box

            $(".tableproducts" + vsd).select2({
                placeholder: "Select Type",
            });
            vsd++;

        }
    });
});
$('#madeupproduct').on('select2:unselect', function (e) {
    var id = e.params.data.id;
    $('#madeup' + id).remove();
});


/*
* Booking Module
* */
// $('#example').multiSelect('refresh');


$(document).ready(function () {
    $(document).on('click', '.productupgradebtn', function (e) {
        e.preventDefault();
        $('#productupgrade').modal('show');
        $('.productnamemodal').html($(this).attr('data-description'));
        $('#modalcategoryid').val($(this).attr('data-attr'));
        $('#productidmodal').val($(this).attr('data-id'));
        var productid = $(this).attr('data-id');
        var categoryid = $(this).attr('data-attr');
        var current = $(this);

        $.ajax({
            type: "POST",
            url: "/api/madeupproductlist",
            data: {'productid': productid, 'categoryid': categoryid},
            success: function (data) {
                $('#upgradeproducts').html(data);
                $('#upgradeproducts').multiSelect('refresh');
            }
        });
    })
})
$('#upgardeproductform').submit(function (e) {
    e.preventDefault();
    var form = $('#upgardeproductform')[0];
    var data = new FormData(form);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "/api/addupgradeproductbooking",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
            $('.productlist' + $('#productidmodal').val()).after(data);
            $('.modal').modal('hide')
            var sum = 0;
            var mechanic = parseInt($('.mechanics').children("option:selected").attr('data-value'));
            if (isNaN(mechanic)) {
                mechanic = 0.00;
            }
            $('#tableaddnew tbody td:last-child').each(function () {
                sum = sum + parseInt($(this).attr('data-cost-value'));
            })
            $('.subtotal span').html('&pound;' + sum.toFixed(2))
            $('.mechanicprice ').html('&pound;' + mechanic.toFixed(2))
            var total = parseFloat(mechanic) + parseFloat(sum);
            $('.totalprice ').html('&pound;' + total.toFixed(2))
        }
    })
})


$("#productnew").select2({
    placeholder: "Select Product",
    closeOnSelect: false
});


$('#productnew').on('select2:select', function (e) {
    var id = e.params.data.id;
    $.ajax({
        type: "POST",
        url: "/api/addNewProductBooking",
        data: {'productid': id},
        success: function (data) {
            $('#tableaddnew tbody').append(data);
            var sum = 0;
            var mechanic = parseInt($('.mechanics').children("option:selected").attr('data-value'));
            if (isNaN(mechanic)) {
                mechanic = 0.00;
            }
            $('#tableaddnew tbody td:last-child').each(function () {
                sum = sum + parseInt($(this).attr('data-cost-value'));
            })
            $('.subtotal span').html('&pound;' + sum.toFixed(2))
            $('.mechanicprice ').html('&pound;' + mechanic.toFixed(2))
            var total = parseFloat(mechanic) + parseFloat(sum);
            $('.totalprice ').html('&pound;' + total.toFixed(2))

        }
    });
});
$('#productnew').on('select2:unselect', function (e) {
    var id = e.params.data.id;
    $('.productlist' + id).remove();
    var sum = 0;
    var mechanic = parseInt($('.mechanics').children("option:selected").attr('data-value'));
    if (isNaN(mechanic)) {
        mechanic = 0.00;
    }
    $('#tableaddnew tbody td:last-child').each(function () {
        sum = sum + parseInt($(this).attr('data-cost-value'));
    })
    $('.subtotal span').html('&pound;' + sum.toFixed(2))
    $('.mechanicprice ').html('&pound;' + mechanic.toFixed(2))
    var total = parseFloat(mechanic) + parseFloat(sum);
    $('.totalprice ').html('&pound;' + total.toFixed(2))
});
var previousupgradeproduct = "";
var totalprevious = "";

// $("select").on('focus', function (e) {
$(document).on('focus', '.selectdesctiption', function (e) {
    e.preventDefault();

    var name = 'product'+$(this).find(":selected").val();
      totalprevious = $(this).find(":selected").attr('data-cost');


    previousupgradeproduct =  name ;

    if(previousupgradeproduct!=undefined)
    {
        previousupgradeproduct=   previousupgradeproduct;
    }
    else{
        totalprevious=0;
    }

}).on('change', '.selectdesctiption', function (d) {
    d.preventDefault();

     var relatedproductid=$(this).find(":selected").val();
      var reutndataproduct=$.ajax({
        type: "POST",
        url: "/api/getselectedupgradedetail",
          'global': false,
          'dataType': 'html',
          async : false,
        data: {'relatedproductid':relatedproductid},
        success: function (data) {
            return data;
        }
    });
    var reutndataproduct= JSON.parse(reutndataproduct.responseText);
    console.log(reutndataproduct);


    $(this).parent().next().next().children('.' + previousupgradeproduct).remove();
    var total = $(this).parent().next().next().attr('data-cost-value');

 
    $(this).parent().next().next().attr('data-cost-value', parseFloat(total)-parseFloat(totalprevious));


    var cost = $(this).find(":selected").attr('data-cost');
    var name = reutndataproduct.detail.name;
    var total = $(this).parent().next().next().attr('data-cost-value');
    total = parseFloat(total) + parseFloat(cost);



    if (name != undefined) {
        $(this).parent().next().next().attr('data-cost-value', total);
         $(this).parent().next().next().append("<div class='product" + reutndataproduct.id  + "'>" + name + " | &pound" + cost + "<div>");
    }


    var sum = 0;
    var mechanic = parseInt($('.mechanics').children("option:selected").attr('data-value'));
    if (isNaN(mechanic)) {
        mechanic = 0.00;
    }
    $('#tableaddnew tbody td:last-child').each(function () {
        sum = sum + parseInt($(this).attr('data-cost-value'));
    })
    $('.subtotal span').html('&pound;' + sum.toFixed(2))
    $('.mechanicprice ').html('&pound;' + mechanic.toFixed(2))
    var total = parseFloat(mechanic) + parseFloat(sum);
    $('.totalprice ').html('&pound;' + total.toFixed(2))

    $('table').focus();

})