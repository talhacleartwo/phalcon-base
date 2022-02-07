/***
**	Contextual Menu Controls
**	- Manages the contextual actions available on view and forms
**
***/

jQuery(document).ready(function($){
	$('#Actionbar').find('button.action').click(function(e){
		e.preventDefault();
		
		var action = $(e.currentTarget).attr('data-action');
		
		switch(action)
		{
			case 'link':
				var route = $(e.currentTarget).attr('data-route');
				var conf = $(e.currentTarget).attr('data-confirm');
				if(route)
				{
					if(conf)
					{
						if(confirm(conf))
						{
							var nt = $(e.currentTarget).attr('data-new-window') ? true : false;
							nt ? window.open(route) : window.location = route;
						}
					}
					else
					{
						var nt = $(e.currentTarget).attr('data-new-window') ? true : false;
						nt ? window.open(route) : window.location = route;
					}
					
				}
			break;
			case 'save':
				var form = $('#mainform');
				if($(e.currentTarget).attr('data-redir'))
				{
					$(form).append('<input type="hidden" name="redir" value="'+ $(e.currentTarget).attr('data-redir') +'"/>');
				}
				form.submit();
			break;
			case 'function':
				eval($(e.currentTarget).attr('data-route'))
			break;
		}
	});
	
	$('#Actionbar').find('button.bulkaction').click(function(e){
		e.preventDefault();
	});
});