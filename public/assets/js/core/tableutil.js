jQuery(document).ready(function($){
	var tables = $('.datatable');
	tables.each((i) => {
		
		//Init Datatable
		var options = {
			"order": [[ 1, "desc" ]],
			"pageLength": 50,
			"dom": '<"viewpicker">frtip',
			responsive: true,
			"columnDefs": [{
				"targets": 0,
				"orderable": false
			}]
		};
		$(tables[i]).DataTable(options);
		
		//Bind event to re-bind events fater draw
		$(tables[i]).on( 'draw.dt', function(e){
			rebindTableEvents(tables[i]);
		});
		
		//Bind Events
		rebindTableEvents(tables[i]);
	});
	
	var subgrids = $('.datatable_subgrid');
	subgrids.each((i) => {
		
		//Init Datatable
		var options = {
			"order": [[ 1, "desc" ]],
			responsive: true
			/*"columnDefs": [{
				"targets": 0,
				"orderable": false
			}]*/
		};
		$(subgrids[i]).DataTable(options);
		
		//Bind event to re-bind events fater draw
		$(subgrids[i]).on( 'draw.dt', function(e){
			rebindTableEvents(subgrids[i]);
		});
		
		/*$(tables[i]).find('tbody tr .checkcol input').click(function(e){
			e.stopPropagation();
		});*/
	});
	
	initViewPicker();
	
	function rebindTableEvents(table)
	{
		bindRowClick(table);
		bindCheckboxClick(table);
	}
	
	function bindRowClick(table)
	{
		$(table).find('tbody tr').unbind();
		$(table).find('tbody tr').click(function(e){
			var r = $(e.currentTarget).attr('data-route');
			if(r){window.location = r;}
		});
	}
	
	function bindCheckboxClick(table)
	{
		$(table).find('tr .checkcol label').unbind();
		$(table).find('tr .checkcol label').click(function(e){
			e.stopPropagation();
			if($(e.currentTarget).hasClass('all'))
			{
				var check = $(e.currentTarget).find('input').prop('checked');
				$(e.currentTarget).closest('table').find('tbody tr').toggleClass('selectedRow').find('.checkcol input').prop('checked',check);
			}
		});
	}
	
	function initViewPicker()
	{
		if(typeof _core_views !== 'undefined')
		{
			var viewPicker = '<select id="view_picker">';
			for(let x=0;x<_core_views.list.length;x++)
			{
				var s = (_core_views.list[x].link === _core_views.current ? 'selected' : '');
				viewPicker += '<option value="'+ _core_views.list[x].link +'" '+ s +'>' + _core_views.list[x].name + '</option>';
			}
			$('.viewpicker').html(viewPicker);
			if(_core_views.list.length === 1){$('select#view_picker').prop('disabled',true);}
			
			$('select#view_picker').change(function(e){
				var link = $(e.currentTarget).val();
				window.location = link;
			});
		}
	}
	
	
});