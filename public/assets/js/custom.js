$(document).on('change', '#applyattendance', function (event) {
    if($(this).is(":checked"))
    {
        var attendance=1;
    } else{
        var attendance=0;
    }
    var datacustomerid= $(this).attr('data-customer-id');
    var datasessionid= $(this).attr('data-session-id');
})
$(document).on('click', '.submitquote', function (event) {
    event.preventDefault();

    if($('#m_select_religion option:selected').val()=="")
    {
        $("html, body").animate({ scrollTop: 0 }, "slow");
         $('#m_select_religion').parent().append("<span class='red'>Value Required</span>");
        return false;
    }
    if($('#salespersonid option:selected').val()=="")
    {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $('#salespersonid').parent().append("<span class='red'>Value Required</span>");
        return false;
    }
    if(($('#customerid option:selected').val()=="") && (!$('input[name=customerexisting]').not(':checked')) )
    {
        alert("df");
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $('#customerid').parent().append("<span class='red'>Value Required</span>");
        return false;
    }

    if(($('input[name=email]').val()=="") && ( !$('input[name=customerexisting]').is(':checked')) )
    {
         $("html, body").animate({ scrollTop: 0 }, "slow");
        $('input[name=email]').parent().append("<span class='red'>Email Required</span>");
        return false;
    }
    if(($('input[name=telephone]').val()=="") && ( !$('input[name=customerexisting]').is(':checked')) )
    {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        $('input[name=telephone]').parent().append("<span class='red'>Email Required</span>");
        return false;
    }
    $.ajax({
        url: "/api/addquote",
        type: 'post',
        data: new FormData($('#quoteform')[0]),
        processData: false,
        contentType: false,
        success: function (data) {
         var res=JSON.parse(data);
          if(res.status=="0")
         {
             $("html, body").animate({ scrollTop: 0 }, "slow");
             $('.alert').removeClass('hide');
         }
         else{
                 window.location.href='/quote/edit/'+res.id;
         }

        }
    });
});
$('#quoteform').click(function(){
    $('.red').remove();
})
$('#existingwrite').change(function(){
     if($(this).is(":checked"))
    {
        $('.existingproduct').addClass('hide');
        $('.writeinproduct').removeClass('hide');
        $('#myModal #rrp').val("")
        $('#myModal #quantity').val("")
    }else{
         $('.existingproduct').removeClass('hide');
         $('.writeinproduct').addClass('hide');
         $('#myModal #rrp').val("")
         $('#myModal #quantity').val("")
     }
});
$('input[name=customerexisting]').on('change',function(){
    if($(this).is(':checked'))
    {
        $('.addnewcustomer').addClass('hide');
        $('.customerexisting').removeClass('hide');
    }else{
        $('.customerexisting').addClass('hide');
        $('.addnewcustomer').removeClass('hide');
    }
});
$('.productform #rrp,.productform #cost').focusout(function () {
     if($.trim($('#cost').val())!="")
    {
       var profit= $('#rrp').val()- $('#cost').val();
       $('#profit').val(profit.toFixed(2));
    }
})


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imagepreview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL(this);
 });
setTimeout(function(){
$('.successMessage').fadeOut();
},2000);


$('.membershippackagecheckbox input').click(function(){
    if($(this).is(':checked') && $(this).attr('name')=="Sun")
    {
        $('.sunday input').prop('disabled', false );
   }
    else if(!$(this).is(':checked') && $(this).attr('name')=="Sun")
    {
        $('.sunday input').prop('disabled','true');
    }
    if($(this).is(':checked') && $(this).attr('name')=="Mon")
    {
        $('.monday input').prop('disabled', false );
   }
    else if(!$(this).is(':checked') && $(this).attr('name')=="Mon")
    {
        $('.monday input').prop('disabled','true');
    }
    if($(this).is(':checked') && $(this).attr('name')=="Tues")
    {
        $('.tuesday input').prop('disabled', false );
   }
    else if(!$(this).is(':checked') && $(this).attr('name')=="Tues")
    {
        $('.tuesday input').prop('disabled','true');
    }
    if($(this).is(':checked') && $(this).attr('name')=="Wed")
    {
        $('.wednesday input').prop('disabled', false );
   }
    else if(!$(this).is(':checked') && $(this).attr('name')=="Wed")
    {
        $('.wednesday input').prop('disabled','true');
    }
    if($(this).is(':checked') && $(this).attr('name')=="Thurs")
    {
        $('.thursday input').prop('disabled', false );
   }
    else if(!$(this).is(':checked') && $(this).attr('name')=="Thurs")
    {
        $('.thursday input').prop('disabled','true');
    }
    if($(this).is(':checked') && $(this).attr('name')=="Fri")
    {
        $('.friday input').prop('disabled', false );
   }
    else if(!$(this).is(':checked') && $(this).attr('name')=="Fri")
    {
        $('.friday input').prop('disabled','true');
    }
    if($(this).is(':checked') && $(this).attr('name')=="Satur")
    {
        $('.saturday input').prop('disabled', false );
   }
    else if(!$(this).is(':checked') && $(this).attr('name')=="Satur")
    {
        $('.saturday input').prop('disabled','true');
    }


})
