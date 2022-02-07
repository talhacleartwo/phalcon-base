"use strict";
// Class definition

var KTDatatableHtmlTable = function() {
    // Private functions

	var initusers1 = function() {

		// begin first table
		var table = $('#leadtable').DataTable({
			responsive: true,
            "lengthChange": false,
            sorting:true,
            "bPaginate": false,
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
            "pageLength": 50,
            searchDelay: 500,
			// columnDefs: [
			// 	{
			// 		targets: -1,
			// 		title: '',
			// 		orderable: false,
			// 	},]
            order: [[ 6, 'asc' ]]
		});

		$('#export_print').on('click', function(e) {
			e.preventDefault();
			table.button(0).trigger();
		});

		$('#export_excel').on('click', function(e) {
			e.preventDefault();
			table.button(1).trigger();
		});

		$('#export_csv').on('click', function(e) {
			e.preventDefault();
			table.button(2).trigger();
		});

		$('#export_pdf').on('click', function(e) {
			e.preventDefault();
			table.button(3).trigger();
		});
        $('#myInputTextField').keyup(function(){
            table.search($(this).val()).draw() ;
        })
	};

	var initusers2 = function() {

		// begin first table
		var table = $('#followuptable').DataTable({
			responsive: true,
			"lengthChange": false,
			sorting:true,
			"bPaginate": false,
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
			"pageLength": 50,
			searchDelay: 500,
			// columnDefs: [
			// 	{
			// 		targets: -1,
			// 		title: '',
			// 		orderable: false,
			// 	},]
			order: [[ 6, 'asc' ]]
		});

		$('#export_print').on('click', function(e) {
			e.preventDefault();
			table.button(0).trigger();
		});

		$('#export_excel').on('click', function(e) {
			e.preventDefault();
			table.button(1).trigger();
		});

		$('#export_csv').on('click', function(e) {
			e.preventDefault();
			table.button(2).trigger();
		});

		$('#export_pdf').on('click', function(e) {
			e.preventDefault();
			table.button(3).trigger();
		});
		$('#myInputTextField1').keyup(function(){
			table.search($(this).val()).draw() ;
		})
	};

	var initusers = function() {

		// begin first table
		var table = $('#kt_datatable').DataTable({
			  "ordering": true,
				responsive: true,
            "lengthChange": false,
            sorting:true,
            "bPaginate": true,
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
            "pageLength": 50,
            searchDelay: 500,
			// columnDefs: [
			// 	{
			// 		targets: -1,
			// 		title: '',
			// 		orderable: false,
			// 	},]
              order: [[ 1, 'desc' ],[ 3, 'asc' ]],
			 bSort: false,
		});

		$('#export_print').on('click', function(e) {
			e.preventDefault();
			table.button(0).trigger();
		});

		$('#export_excel').on('click', function(e) {
			e.preventDefault();
			table.button(1).trigger();
		});

		$('#export_csv').on('click', function(e) {
			e.preventDefault();
			table.button(2).trigger();
		});

		$('#export_pdf').on('click', function(e) {
			e.preventDefault();
			table.button(3).trigger();
		});
        $('#myInputTextField').keyup(function(){
            table.search($(this).val()).draw() ;
			if( $(this).val() == "" ) {
			$('.deactivatelead').addClass('hide');
			}else{
			$('.deactivatelead').removeClass('hide');
			}	
        })
	};

	var initcategory = function() {
		// begin first table
		var table = $('#kt_datatable_cat').DataTable({
			responsive: true,
            "lengthChange": false,
            "pageLength": 50,
			buttons: [
				{
	                extend: 'print',
	                exportOptions: {
	                    columns: [ 0, 1 ]
	                }
	            },
				{
	                extend: 'excelHtml5',
	                exportOptions: {
	                    columns: [ 0, 1]
	                }
	            },
				{
	                extend: 'csvHtml5',
	                exportOptions: {
	                    columns: [ 0, 1 ]
	                }
	            },
				{
	                extend: 'pdfHtml5',
	                exportOptions: {
	                    columns: [ 0, 1]
	                }
	            },
			],
			searchDelay: 500,
			columnDefs: [
				{
					targets: -1,
					title: 'Actions',
					orderable: false,
				}],
         });
		
		$('#export_print').on('click', function(e) {
			e.preventDefault();
			table.button(0).trigger();
		});

		$('#export_excel').on('click', function(e) {
			e.preventDefault();
			table.button(1).trigger();
		});

		$('#export_csv').on('click', function(e) {
			e.preventDefault();
			table.button(2).trigger();
		});

		$('#export_pdf').on('click', function(e) {
			e.preventDefault();
			table.button(3).trigger();
		});
        $('#myInputTextField').keyup(function(){
            table.search($(this).val()).draw() ;
        })
	};
	
	
    return {
        // Public functions
        init: function() {
        	initusers();
        	initusers1();
        	initusers2();
        	initcategory();
        },
    };
}();

jQuery(document).ready(function() {
	KTDatatableHtmlTable.init();
});