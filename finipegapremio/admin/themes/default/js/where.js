$(function(){
		var where_field = "{$where_field}";
		var where_value = "{$where_value}";
		$('.where').val(where_field);
		$(".find-value").val(where_value);
		$('.btn-clear-find').show();
		if(!$('.panel-default').length){
			$('.btn-clear-find').unbind('click');
			$('.btn-clear-find').click(function(){
				window.location = _ssx_siteurl+'nazca/notas-fiscais';
			});
		}		
	});	
