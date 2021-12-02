$(function(){
	$(".media_is_active").click(function(){
		var data = {};
		
		data['active'] = $(this).attr("data-active");
		data['media'] = $(this).attr('data-id');
		
		Ssx.ajax('AjaxUtils_mediaIsactive', data, 'callbackMediaIsActive');
	});
	
});

function previewImg(input){
	if(input.files && input.files[0]){
		var reader = new FileReader();
		
		reader.onload = function(e){
			$("#preview_img").attr('src', e.target.result).width(150).height(150);
		};
		
		reader.readAsDataURL(input.files[0]);
	}
}

function callbackMediaIsActive(result){
	if(result.success){
		if(result.active){
			$('.'+result.media).attr("data-active",'1');
			$('.'+result.media).html("_desactive");
			$('.'+result.media).css("opacity",'1.0');
		}else{
			$('.'+result.media).attr("data-active",'0');
			$('.'+result.media).html("_active");
			$('.'+result.media).css("opacity",'0.4');
		}
		
	}
}