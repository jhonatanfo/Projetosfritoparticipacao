$(function(){
	$('.nav-sidebar .submenu').css('display','none');
	$('.nav-sidebar.open .submenu').css('display','block');
	$('.nav-sidebar .active').click(function(){
		if($(this).parent().hasClass('open')){
			$(this).parent().removeClass('open');
			// $(this).parent().find('.drop-indicator').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
			// $(this).parent().find('.submenu').fadeOut('slow');	
			$(this).parent().find('.submenu').css('display','none');	
		}else{
			$(this).parent().addClass('open');
			// $(this).parent().find('.drop-indicator').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
			// $(this).parent().find('.submenu').fadeIn('slow');	
			$(this).parent().find('.submenu').css('display','block');	
		}
	});

	/*Troca abas gráfico*/	
    $('#myTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
	});

});
