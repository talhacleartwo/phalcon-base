    	$('#CustomerSupplier').change(function(e){        
       // 	CustomerSupplier_OnChange();
        });
        
         
        
        $('#report_type').change(function(e){        
       // 	debugger;
         	var id = e.currentTarget.selectedOptions[0].value;        	
        	var ctlCustomerSupplierData = document.getElementById("CustomerSupplier");
        	var ctlOrderType = document.getElementById("order_type");
        	ctlOrderType.parentElement.style.display = "none";
        	var ctlCategory = document.getElementById("Category");
        	(ctlCategory.parentElement).parentElement.style.display = "none";
        	
        	var ctlDateRange = document.getElementById("daterange");
        	ctlDateRange.parentElement.style.display = "block";
        	
        	var strApiName = "";
        	if(id == "customerstatement") {
        		strApiName = "getallcustomers";
        		ctlOrderType.parentElement.style.display = "block";
        		ctlDateRange.parentElement.style.display = "block";
        	}
        	else if(id == "customerproductReport") {
        		strApiName = "getallcustomers";
        		ctlDateRange.parentElement.style.display = "none";
        	}
        	else if(id == "suppliernegativelisting") {
        		strApiName = "getallsuppliers";        		
        		ctlDateRange.parentElement.style.display = "none";
        	}
        	else if(id == "supplierstockreorderlevel") {
        		strApiName = "getallsuppliers";        		
        		ctlDateRange.parentElement.style.display = "none";
        	}
        	else if(id == "supplierstatement" || id == "supplierproductsold" || id == "supplierproductpurchase") {
        		strApiName = "getallsuppliers";
        		ctlDateRange.parentElement.style.display = "block";
        	}
        	else if(id == "productsales") {
        		(ctlCategory.parentElement).parentElement.style.display = "block";
        		ctlDateRange.parentElement.style.display = "block";
        	}
        	else if (id == 'profitpercategory'){
        		(ctlCategory.parentElement).parentElement.style.display = "block";
        		ctlDateRange.parentElement.style.display = "block";
        	}
        	if(strApiName != null && strApiName != "") {
        		ctlCustomerSupplierData.parentElement.style.display = "block";
        		
    			$.ajax({
    	            type: "POST",
    	            url: "/api/" + strApiName,
    	            data: {},
    	            success:function(data){         
						var obj = JSON.parse(data);
     	            	ctlCustomerSupplierData.length = 0;
     	            	$.each(obj, function (k, v) {
        	                var oCustomerSupplierData = new Option(obj[k].company, obj[k].id);
        	                ctlCustomerSupplierData.add(oCustomerSupplierData);
    	            	});
    	            	
    	            	//CustomerSupplier_OnChange();
    	            }
    	        });
        	}
        	else {
        		ctlCustomerSupplierData.length = 0;
        		ctlCustomerSupplierData.parentElement.style.display = "none";
        	}
        });
 	
 