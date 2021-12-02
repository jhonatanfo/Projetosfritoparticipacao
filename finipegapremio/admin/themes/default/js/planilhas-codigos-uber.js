$(function (){
	clickRemoverPlanilha();
	clickCodigoGerados();
});
    

function clickRemoverPlanilha(){
	$('.btn-remover-planilha').unbind('click');
	$('.btn-remover-planilha').click(function(){
		var idPlanilha = $(this).attr('data-id');
		Modal("Deseja realmente <b>REMOVER</b> está planilha: <b>"+idPlanilha+"</b> ?",false,'removerPlanilha',idPlanilha);		
	});
}

function clickCodigoGerados(){
	$('.btn-show-codigos').unbind('click');
	$('.btn-show-codigos').click(function(){
		var idPlanilha = $(this).attr('data-id');
		obterCodigosGerados(idPlanilha);
	});
}

function obterCodigosGerados(idPlanilha){
	var dados = {};
	dados['id_planilha'] = idPlanilha;
	Ssx.ajax('AdminAjaxControl_getCodigosUberPlanilha',dados,'callbackObterCodigosGerados');
}

function callbackObterCodigosGerados(result){
	if(result.success){
		var codigos = result.codigos;
		var html  = "<table class='table table-stripped'>";
			html += "<thead>";
			html += "<tr>";
			// html += "<th>Código</th>";
			// html += "<th>Lote</th>";
			html += "<th>Voucher Link</th>";
			html += "<th>Status</th>";
			html += "<th>Data Criação</th>";
			html += "<th>Data Alteração</th>";
			html += "<th>Remover</th>";
			html += "</tr>";
			html += "<tbody>";
		for(var i =0;i<codigos.length;i++){
			var codigo = codigos[i];
			html += "<tr class='tr-codigo-"+codigo.id_yoki_codigo_uber+"'>";
			// html += "<td>"+codigo.codigo+"</td>";
			// html += "<td>"+codigo.lote+"</td>";
			html += "<td>"+codigo.voucher_link+"</td>";
			html += "<td>"+codigo.status+"</td>";
			html += "<td>"+codigo.data_criacao+"</td>";
			html += "<td>"+codigo.data_alteracao+"</td>";
			if(codigo.status == "NAO USADO"){
				html += "<td>";
				html += "<button class='btn btn-danger btn-remove-code' data-id='"+codigo.id_yoki_codigo_uber+"' data-vlink='"+codigo.voucher_link+"'>";
				html += "<i class='glyphicon glyphicon-trash'></i>";
				html += "</button>"; 
				html += "</td>";	
			}else{
				html += "<td>";
				html += "<b>Já em uso</b>";
				html += "</td>";
			}			
			html += "</tr>";
		}	
			html += "</tbody>";		
			html += "</table>";
		Modal(html);
		removeCode();
	}else{
		Modal("<h3>Nenhum código gerado foi encontrado!</h3>");
	}
}

function removerPlanilha(idPlanilha){
	var dados = {};
	dados['id_planilha'] = idPlanilha;
	Ssx.ajax('AdminAjaxControl_removePlanilhaCodigoUberById',dados,'callbackRemoverPlanilha');
}

function callbackRemoverPlanilha(result){
	if(result.success){
		var _id  = result.id_planilha;
		$('.planilha-linha-'+_id).remove();
		Modal("Planilha de ID: <b>"+_id+"</b> removida!");
	}else{
		Modal("Problemas remover planilha!");
	}
}


function removeCode(){
	$('.btn-remove-code').unbind('click');
	$('.btn-remove-code').click(function(){
		$('.removeCodeModal').modal('show');
		var _id = $(this).attr('data-id');
		var _link = $(this).attr('data-vlink');
		$('.modal-voucher-link').text(_link);
		$('.btn-submit-remove-code').unbind('click');
		$('.btn-submit-remove-code').click(function(){
			var dados = {};
			dados['id_codigo'] = _id;
			Ssx.ajax('AdminAjaxControl_removeCodigoUberById',dados,'callbackRemoveCode');
		});
	});
}

function callbackRemoveCode(response){
	if(response.success){
		var id_codigo = response.id_codigo;
		$('.tr-codigo-'+id_codigo).fadeOut('slow',function(){ $('.tr-codigo-'+id_codigo).remove()});
	}
	$('.removeCodeModal').modal('hide');
}

function Modal(msg,notificationMode,functionToCall,parameterToFunctionCall,callbackFunction,parameterToCallbackFunction){

	$(document).on('shown.bs.modal', '.modal', function () {
		$(".modal-backdrop").not(':last').remove();
	});

	$('.defaultModal').find('.modal-footer').removeClass('hide');
	
	if(msg && $('.defaultModal').find('.modal-body').length > 0){
		var _body = $('.defaultModal').find('.modal-body').empty();
		_body.html(msg);	
	}else{
		console.log('Body modal not found.');
	}
	

	if(typeof notificationMode == 'undefined'){
		notificationMode = true;
	}

	if(notificationMode == true && $('.defaultModal').find('.modal-footer').length){
		$('.defaultModal').find('.modal-footer').addClass('hide');
	}else{
		console.log('Footer on modal not found.')
	}	

	$('.defaultModal').modal('show');
	

	if(typeof functionToCall == 'undefined'){

	}else if(typeof window[functionToCall] == 'function'){
		$('.btn-submit-function').unbind('click');
		$('.btn-submit-function').click(function(){
			window[functionToCall](parameterToFunctionCall);
			if(typeof callbackFunction == 'function' ){
				callbackFunction(parameterToCallbackFunction);	
			}			
			return true;
		});
	}else{
		console.log('Function to call not exists.');	
		return false;
	}				
	
}
