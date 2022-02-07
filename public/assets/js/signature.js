var canvas = document.getElementById('signature-pad');

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

var signaturePad = new SignaturePad(canvas, {
    backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
});

document.getElementById('clear').addEventListener('click', function () {
    signaturePad.clear();
});

     $("#createnewimage").click(function(){
     	$('.showsign').css('display','none')
	 });
$("#bookingjobform #updatejobform").click(function (event) {
    event.preventDefault();
    if(!signaturePad.isEmpty())
    {
        var data = signaturePad.toDataURL('image/png');
        $('#vehicledefectscustomersignature').val(data);
     }

     var form = $('#bookingjobform')[0];
    var data = new FormData(form);
    $('.error').html('');
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "/ajax/bookingjobform",
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
                location.reload();
                alert("Updated Successfully");
            }
        },
    });
});




$("#jobdetailupdate #submitform").click(function (event) {
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
    var form = $('#jobdetailupdate')[0];
    var data = new FormData(form);
    $('.error').html('');
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "/ajax/jobdetailupdate",
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
                alert("Updated Successfully");
                location.reload();
            }
        },
    });
});

