// Class definition
var KTSelect2 = function() {
	// Private functions
    var select2 = function() {
    	// basic
        $('#kt_permissions').select2({
            placeholder: 'Select a profile'
        });
        $('#contact_status').select2({
            placeholder: 'Select  '
        });
        // $('#carmake').select2({
        //     placeholder: 'Select a Car'
        // });
        $('#kt_selectUserProfile').select2({
            placeholder: "Select User Role",
            allowClear: true
        }); 
         //
        $('#kt_selectActive').select2({
            placeholder: "Select Active or not",
            allowClear: true
        });
        $('#kt_selectbanned').select2({
            placeholder: "Select Banned or not",
            allowClear: true
        });
        $('#kt_selectsuspend').select2({
            placeholder: "Select Suspended or not",
            allowClear: true
        });

        $('#contact_status').on("select2:select", function (e) {
            var iid = e.params.data.id;
             if(iid==2)
            {
                $('.followup').removeClass('hide')
            }
            else{
                $('.followup').addClass('hide')
            }
        });

        // loading data from array
        var data = [{
            id: 0,
            text: 'Enhancement'
        }, {
            id: 1,
            text: 'Bug'
        }, {
            id: 2,
            text: 'Duplicate'
        }, {
            id: 3,
            text: 'Invalid'
        }, {
            id: 4,
            text: 'Wontfix'
        }];

        $('#kt_selectArrayData').select2({
            placeholder: "Select a value",
            data: data
        });
    }
	// Public functions
    return {
        init: function() {
            select2();
        }
    };
}();

//Initialization
jQuery(document).ready(function() {
 KTSelect2.init();
});