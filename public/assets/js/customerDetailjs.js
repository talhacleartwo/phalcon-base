// Class definition
var KTCustomerDetails = function() {
	// Private functions
    var select2 = function() {
    	// basic
        $('#kt_CustomerDeliveryRoute').select2({
            placeholder: 'Select a profile'
        });
        
    }
    // form validation
    var _initformValidation = function () 
    {
    	FormValidation.formValidation(
    		document.getElementById('kt_editCustomerform'),
    		{
    			fields: {
    				
    			},
    			plugins: { //Learn more: https://formvalidation.io/guide/plugins
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),
            		// Submit the form when all fields are valid
            		defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
				}
    		}
    	);
    }
	
    // customer Orders Table
    var initOrderTable = function() {

		// begin first table
		var table = $('#kt_CustomerOrders').DataTable({
			responsive: true,
			bSort: false,
			dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
				<'row'<'col-sm-12'tr>>
				<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
			buttons: [
				{
	                extend: 'print',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 , 4 ]
	                }
	            },
				{
	                extend: 'excelHtml5',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 , 4]
	                }
	            },
				{
	                extend: 'csvHtml5',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 , 4 ]
	                }
	            },
				{
	                extend: 'pdfHtml5',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 , 4]
	                }
	            },
			],
			searchDelay: 500,
			
			columnDefs: [
				
				{
					targets: -1,
					title: 'Actions',
					orderable: false,
				}]
		});

		

	};

    // customer Orders Table
    var initRatesTable = function() {

		// begin first table
		var table = $('#kt_CustomerRates').DataTable({
			responsive: true,
			bSort: false,
			dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
				<'row'<'col-sm-12'tr>>
				<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
			buttons: [
				{
	                extend: 'print',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 ]
	                }
	            },
				{
	                extend: 'excelHtml5',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 ]
	                }
	            },
				{
	                extend: 'csvHtml5',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 ]
	                }
	            },
				{
	                extend: 'pdfHtml5',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3]
	                }
	            },
			],
			searchDelay: 500,
			
		
		});

		

    };
	// customer Payments Table
    var initPaymentTable = function() {

		// begin first table
		var table = $('#kt_CustomerPayments').DataTable({
			responsive: true,
			bSort: false,
			dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
				<'row'<'col-sm-12'tr>>
				<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
			buttons: [
				{
	                extend: 'print',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 , 4 ]
	                }
	            },
				{
	                extend: 'excelHtml5',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 , 4]
	                }
	            },
				{
	                extend: 'csvHtml5',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 , 4 ]
	                }
	            },
				{
	                extend: 'pdfHtml5',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 , 4]
	                }
	            },
			],
			searchDelay: 500,
			columnDefs: [
				{
					targets: -1,
					title: 'Actions',
					orderable: false,
				},]
			
		});


	};
    
    // Public functions
    return {
        init: function() {
            select2();
            initOrderTable();
            initRatesTable();
            initPaymentTable();
        }
    };
}();

//Initialization
jQuery(document).ready(function() {
	KTCustomerDetails.init();
});