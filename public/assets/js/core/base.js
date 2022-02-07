jQuery(document).ready(function($){
	$('#Aside .menu_collapse_toggle').click(function(){
		$('#Body').toggleClass('collapsed');
	});
	$('div#Topbar .responsive_menu_toggle .toggle').click(function(){
		$('#Body').toggleClass('expanded');
	});
	$('#Topbar .session .initalbadge').click(function(){
		$('#usersidebar').toggleClass('on');
	});
	$('.tab_headers li').click(function(e){
		var headers = $(e.currentTarget).closest('.tab_headers');
		$(headers).find('li').removeClass('active');
		$(e.currentTarget).addClass('active');
		var set = $(headers).attr('data-set');
		var target = $(e.currentTarget).attr('data-tab');
		var bodies = $('.tab_bodys' + (set ? '[data-set="'+set+'"]' : ''));
		$(bodies).find('.tab_body').removeClass('active');
		$(bodies).find('.tab_body[data-tab="'+target+'"]').addClass('active');
	});
});