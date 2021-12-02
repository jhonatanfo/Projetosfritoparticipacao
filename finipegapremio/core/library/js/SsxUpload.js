function SsxUploadJs()
{
	this.uploadBoxOpen = false;
	
	this.ajaxUpload = function(form, function_to_call ,callback)
	{
		if(!Ssx.jqueryLoaded())
		{
			console.log('Ssx Ajax: Jquery not found');
			return false;
		}
		
		if(!__JQUERY_FORM__)
		{
			console.log('Ssx Ajax: jquery form not found');
			return false;
		}
		
		if(Ssx.isNull(function_to_call))
		{
			console.log("Ssx Ajax Error: function to call is null");
			return false;
		}
		
		var dataToSend = {
			'function_call' : function_to_call,
			'function_callback' : callback,
			'output' : 'json',
			'ad' : (ad)?true:false
		};
		
		var options = {
				'data':dataToSend,
				'url': _ssx_ajaxurl,
				'dataType':'json',
				'uploadProgress': function(event, position, total, percentComplete) 
				{
			        var percentVal = percentComplete + '%';
			        $('#ssx_dialog_upload_progress_status').html("Carregando imagem: "+percentVal);
			    },
			    'complete':function()
			    {
			    	 $('#ssx_dialog_upload_progress_status').html("Carregando imagem: 100%");
			    	 SsxUpload.closeDialogUpload();
			    },
				'success': function(data) 
				{
			    	if(data.errors)
					{
					    console.log(data.errors);
					    return;
					}
					if(data.callback)
					{
						if(typeof window[data.callback] == 'function')
							window[data.callback](data.result);
						else
							console.log('Ssx Ajax: function callback not exists.');
					}
					
					
				}
		};
		$(form).ajaxSubmit(options);
		return false;
	};
	
	this.uploadDialogCallback = "";
	
	this.uploadDialog = function(callback)
	{
		if(this.uploadBoxOpen)
			return false;
		
		if(!Ssx.jqueryLoaded())
		{
			console.log('Ssx Ajax: Jquery not found');
			return false;
		}
		
		if(!__JQUERY_FORM__)
		{
			console.log('Ssx Ajax: jquery form not found');
			return false;
		}
		
		this.uploadDialogCallback = callback;
		
		var boxDialog = "" +
				"<div id='ssx_dialog_upload'>" +
					"<a class='buttom_admin' href='javascript:void(0);' id='ssx_dialog_close'>[ X ]</a>" +
					"<div style='clear:both'></div>" +
					"<form id='ssx_dialog_upload_form' action='"+_ssx_ajaxurl+"' method='post' enctype='multipart/form-data'>" +
						"<h2 class='module_title'>Upload de Imagem</h2>" +
						"Selecione uma imagem do seu computador:" +
						"<input type='file' name='ssx_upload_item' id='ssx_upload_item' />" +
						"<br /><br /><a class='buttom_admin buttom_ico ico_image' href='javascript:void(0);' id='ssx_dialog_upload_buttom'>Upload</a>" +
						"<span id='ssx_dialog_upload_progress_status'></span>" +
					"</form>" +
				"</div>";
		
		$('body').prepend(boxDialog);
		
		var screenWidth = $(window).width();
		var screenHeight = $(window).height();
		
		$('#ssx_dialog_upload').css({'top': (screenHeight/2 - 100/2)-150, 'left':(screenWidth/2 - 300/2)})
		
		$('#ssx_dialog_close').on('click', function()
		{
			SsxUpload.closeDialogUpload();
		});
		
		$('#ssx_dialog_upload_buttom').on('click', function()
				{
					if($('#ssx_upload_item').val() == "")
					{
						alert('Selecione um arquivo do seu computador');
						return false;
					}
					$('#ssx_dialog_upload').submit();
				});
		
		$('#ssx_dialog_upload').on('submit', function()
				{
					$('#ssx_dialog_upload_buttom').hide();
					$('#ssx_upload_item').hide();
					$('#ssx_dialog_close').off('click');
					SsxUpload.ajaxUpload('#ssx_dialog_upload_form','SsxAjaxUpload_uploadFile','ssx_upload_image_callback');
					return false;
				});
		
		$("#ssx_dialog_upload").fadeIn('slow');
		this.uploadBoxOpen = true;
	};
	
	this.closeDialogUpload = function()
	{
		$("#ssx_dialog_upload").fadeOut(function(){
			
			$(this).remove();
			
			SsxUpload.uploadBoxOpen = false;
			
			$('#ssx_dialog_close').off('click');
			$('#ssx_dialog_upload_buttom').off('click');
			$('#ssx_dialog_upload').off('submit');
		});
		
	};
}

var SsxUpload = new SsxUploadJs();

//off callback
function ssx_upload_image_callback(result)
{
	if(SsxUpload.uploadDialogCallback)
	{
		if(typeof window[SsxUpload.uploadDialogCallback] == 'function')
			window[SsxUpload.uploadDialogCallback](result);
		else
			console.log('Ssx Ajax: function callback not exists.');
	}
}